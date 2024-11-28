<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        $user = Auth::guard('acuser')->user();
        $cart = session('cart');
        $total = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $cart));
        $now = Carbon::now('Asia/Ho_Chi_Minh'); // Thời gian hiện tại
        // Check stock availability
        foreach ($cart as $id => $details) {
            $product = Product::find($details['prd_id']); 
            if ($product->quantity < $details['quantity']) {
                return redirect()->route('cart.index')->with('error', 'Số lượng sản phẩm ' . $details['name'] . ' không đủ trong kho.');
            }
        }
        // Tạo mã đơn hàng duy nhất
        $unique = false;
        do {
            if ($paymentMethod == 'cod') {
                $order_number = 'COD' . $now->timestamp . rand(1000, 99999);
            } elseif ($paymentMethod == 'vnpay') {
                $order_number = 'VNPAY' . $now->timestamp . rand(1000, 99999);
            }
            $existing_order = Order::where('order_code', $order_number)->first();
            if (!$existing_order) {
                $unique = true;
            }
        } while (!$unique);

        if ($paymentMethod == 'cod') {
            // Lưu đơn hàng vào bảng orders
            foreach ($cart as $id => $details) {
                Order::create([
                    'order_code' => $order_number, // Mã đơn hàng
                    'user_id' => $user->id,
                    'customer_name' => $user->us_name,
                    'customer_note' => $request->input('message_to_seller', ''), // Sử dụng message_to_seller
                    'customer_phone' => $user->Sdt,
                    'customer_email' => $user->email,
                    'shipping_address' => $user->dc_nhanhang,
                    'status' => 0, // Trạng thái đơn hàng (0: Chưa xử lý)
                    'product_name' => $details['name'],
                    'product_price' => $details['price'],
                    'quantity' => $details['quantity'],
                    'total_price' => $details['quantity'] * $details['price'],
                    'prd_id' => $details['prd_id'],
                    'id_admin' => null, // Có thể cập nhật sau
                ]);
            }
    
            // Xóa giỏ hàng sau khi đặt hàng thành công
            session()->forget('cart');
    
            return redirect()->route('cart.index')->with('success', 'Đặt hàng thành công! Bạn sẽ thanh toán khi nhận hàng.');
        } elseif ($paymentMethod == 'vnpay') {
            // Xử lý thanh toán trực tuyến VNPAY
            $vnp_TmnCode = env('VNP_TMN_CODE');
            $vnp_HashSecret = env('VNP_HASH_SECRET');
            $vnp_Url = env('VNP_URL');
            $vnp_Returnurl = env('VNP_RETURN_URL');
        
            $now = new \DateTime();
            //$expire = $now->modify('+1 hour')->format('YmdHis');   
            // Ngày hết hạn
            $expire = $now->modify('+15 minutes')->format('YmdHis');

        
            // Tạo dữ liệu để gửi đến VNPAY
            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $total * 100, 
                "vnp_Command" => "pay",
                "vnp_CreateDate" => $now->format('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'], // IP khách hàng thanh toán
                "vnp_Locale" => 'vn',
                "vnp_OrderInfo" => 'Thanh toán đơn hàng ' . $order_number, // Nối chuỗi đúng cách
                "vnp_OrderType" => 'billpayment',
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $order_number, // Mã đơn hàng mới
                "vnp_ExpireDate" => $expire
            ];
        
            // Sắp xếp dữ liệu và tạo chuỗi chữ ký
            ksort($inputData);
            $query = "";
            $hashdata = "";
            $i = 0;
            foreach ($inputData as $key => $value) {
                if ($i > 0) {
                    $hashdata .= '&';
                }
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
                $i++;
            }
        
            $query = rtrim($query, '&');
            $vnp_Url .= "?" . $query;
        
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
            }
            return redirect($vnp_Url);
        } else {
            return redirect()->route('cart.index')->with('error', 'Phương thức thanh toán không hợp lệ.');
        }        
                
    }
    public function vnpayReturn(Request $request)
    {
        // Kiểm tra thanh toán thành công hay không
        if ($request->vnp_ResponseCode == '00') {
            // Lấy thông tin người dùng từ session
            $user = Auth::guard('acuser')->user();
            
            // Lấy thông tin giỏ hàng từ session
            $cart = session('cart');

            // Tạo mã đơn hàng duy nhất từ mã đơn hàng trả về từ VNPAY
            $order_number = $request->vnp_TxnRef;

            // Duyệt qua từng sản phẩm trong giỏ hàng và lưu vào bảng `orders`
            foreach ($cart as $id => $details) {
                Order::create([
                    'order_code' => $order_number, // Mã đơn hàng từ VNPAY
                    'user_id' => $user->id,
                    'customer_name' => $user->us_name,
                    'customer_note' => $request->input('customer_note', ''), // Tin nhắn cho người bán
                    'customer_phone' => $user->Sdt,
                    'customer_email' => $user->email,
                    'shipping_address' => $user->dc_nhanhang,
                    'status' => 0, // Trạng thái đơn hàng (0: chưa xử lý)
                    'product_name' => $details['name'],
                    'product_price' => $details['price'],
                    'quantity' => $details['quantity'],
                    'total_price' => $details['quantity'] * $details['price'],
                    'prd_id' => $details['prd_id'],
                    'id_admin' => null, // Có thể cập nhật sau
                ]);
            }

            // Xóa giỏ hàng sau khi đã lưu đơn hàng thành công
            session()->forget('cart');

            // Hiển thị thông báo thành công
            return redirect()->route('cart.index')->with('success', 'Đơn hàng của bạn đã được thanh toán thành công.');
        } else {
            // Hiển thị thông báo lỗi nếu thanh toán thất bại
            return redirect()->route('cart.index')->with('error', 'Có lỗi xảy ra trong quá trình thanh toán. Vui lòng thử lại.');
        }
    }    
}
