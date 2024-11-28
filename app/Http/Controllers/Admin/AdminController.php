<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\AcAdmin;
use App\Models\AcUser;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Validator;

class AdminController extends Controller
{
    public function DangKy(){
        return view('admin.auth.textDK');
    }
    public function testDk(request $request){
         // Xác thực dữ liệu đầu vào
         $validator = Validator::make($request->all(), [
            'username' => 'required|unique:ac_admin,username|max:50',
            'password' => 'required|min:6|confirmed',
            'name' => 'required|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // Tạo admin mới
        $admin = new AcAdmin();
        $admin->ad_name = $request->input('name');
        $admin->username = $request->input('username');
        $admin->password = Hash::make($request->input('password')); // Mã hóa mật khẩu
        $admin->save();

        return redirect()->route('dangky')->with('success', 'Đăng ký thành công!');
    }
    public function index()
    {
        // Lấy tổng số đơn hàng
        $totalOrders = Order::count();
    
        // Lấy số đơn hàng hôm nay
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();
    
        // Lấy tổng số sản phẩm
        $totalProducts = Product::count(); 
    
        // Lấy tổng số người dùng
        $totalUsers = AcUser::count(); 
    
        // Truyền dữ liệu qua view
        return view('admin.index', compact('totalOrders', 'todayOrders', 'totalProducts', 'totalUsers'));
    }
    public function danhsachsp()
    {
        // Lấy tất cả sản phẩm từ cơ sở dữ liệu
        $products = Product::all();

        // Truyền dữ liệu sản phẩm đến view
        return view('admin.sanpham.danhsach', compact('products'));
    }
    // Phương thức hiển thị danh sách sản phẩm với tìm kiếm
    public function searchSanpham(Request $request)
    {
        $keyword = $request->input('keyword');
        
        // Kiểm tra nếu có từ khóa tìm kiếm
        if ($keyword) {
            // Tìm kiếm sản phẩm theo tên, có thể bổ sung các điều kiện khác nếu cần
            $products = Product::where('prd_name', 'LIKE', '%' . $keyword . '%')->get();
            // Nếu không tìm thấy sản phẩm nào, gửi thông báo
            if ($products->isEmpty()) {
                return redirect()->back()->with('error', 'Không tìm thấy sản phẩm nào với từ khóa: ' . $keyword);
            }
        }else {
            // Nếu không có từ khóa, hiển thị tất cả sản phẩm
            $products = Product::all();
        }

        return view('admin.sanpham.danhsach', compact('products'));
    }

    public function viewThem(){
        $list_brand = Brand::get();
        return view('admin.sanpham.them',compact('list_brand'));
    }
    // Xử lý việc lưu sản phẩm mới
    public function themSanpham(Request $request)
    {
        // Xác thực dữ liệu
        $validated = $request->validate([
            'prd_name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'required|string|max:1000',
            'brand_id' => 'required|exists:brands,brand_id',
            'is_active' => 'required|boolean',
        ]);
        $id_admin=Auth::guard('admin')->user()->id_admin;
        // Xử lý ảnh sản phẩm
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('img/sanpham'), $image_name);
        } else {
            $image_name = '';
        }
        $now = Carbon::now('Asia/Ho_Chi_Minh');

        // Tạo sản phẩm mới
        $product = new Product();
        $product->prd_name = $request->prd_name;
        $product->image = $image_name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->brand_id = $request->brand_id;
        $product->is_active = $request->is_active;
        $product->id_admin = $id_admin;
        $product->created_at = $now;
        $product->updated_at = $now;
        $product->save();

        return redirect()->route('danhsachsp')->with('success', 'Sản phẩm đã được thêm thành công!');
    }
    public function xoaSp(Request $request)
    {
        $id = $request->input('key');

        $product = Product::find($id);

        if ($product) {
            $product->delete();
            if (file_exists(public_path('img/sanpham/' . $product->image))) {
                unlink(public_path('img/sanpham/' . $product->image));
            }
            return redirect()->back()->with('success', 'Xóa sản phẩm thành công');
        } else {
            return back()->with('error', 'Xóa sản phẩm thất bại');
        }
    }
    public function suaSanPham(Request $request)
    {
        $product = Product::find($request->key);
        $list_brand = Brand::all(); // Lấy danh sách thương hiệu để chọn trong form

        if ($product) {
            return view('admin.sanpham.sua', compact('product', 'list_brand'));
        } else {
            return redirect()->route('danhsachsp')->with('error', 'Sản phẩm không tồn tại.');
        }
    }
    public function updateProduct(Request $request)
    {
        $product = Product::find($request->prd_id);

        if ($product) {
            $product->prd_name = $request->prd_name;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->description = $request->description;
            $product->brand_id = $request->brand_id;
            $product->is_active = $request->is_active;

            if ($request->hasFile('image')) {
                // Lưu hình ảnh mới và xóa hình ảnh cũ
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $request->image->move(public_path('img/sanpham'), $imageName);
                if (file_exists(public_path('img/sanpham/' . $product->image))) {
                    unlink(public_path('img/sanpham/' . $product->image));
                }
                $product->image = $imageName;
            }

            $product->save();

            return redirect()->route('danhsachsp')->with('success', 'Sản phẩm đã được cập nhật thành công.');
        } else {
            return redirect()->route('danhsachsp')->with('error', 'Sản phẩm không tồn tại.');
        }
    }
    //user
    
    public function DanhSachUser(Request $request)
    {
        $keyword = $request->input('username');
        
        if ($keyword) {
            $users = AcUser::where('username', 'LIKE', '%' . $keyword . '%')->get();
            
            if ($users->isEmpty()) {
                return redirect()->back()->with('error', 'Không tìm thấy người dùng nào với username: ' . $keyword);
            }
        } else {
            // Nếu không có từ khóa, lấy tất cả người dùng
            $users = AcUser::all();
        }
    
        // Trả về view để hiển thị danh sách người dùng
        return view('admin.users.index', compact('users'));
    }    
    
    public function xoaUser(Request $request)
    {
        $user = AcUser::find($request->key);

        if ($user) {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa thành công.');
        } else {
            return redirect()->route('admin.users.index')->with('error', 'Không tìm thấy người dùng.');
        }
    }
    public function showOrdersByUser(Request $request)
    {
        // Lấy id của user từ query string
        $userId = $request->query('key');
    
        // Kiểm tra xem user có tồn tại hay không
        $user = AcUser::find($userId);
    
        if (!$user) {
            return redirect()->back()->with('error', 'Người dùng không tồn tại.');
        }
    
        // Lấy danh sách đơn đặt hàng của user
        $orders = Order::where('user_id', $userId)->get();
    
        // Trả về view hiển thị danh sách đơn đặt hàng của user
        return view('admin.order.show_by_user', compact('orders', 'user'));
    }

    public function show($id)
    {
        // Lấy thông tin tất cả sản phẩm thuộc cùng mã order_code
        $order = Order::find($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }
    
        $products = Order::where('order_code', $order->order_code)->get();
    
        // Trả về view hiển thị thông tin chi tiết đơn hàng với tất cả sản phẩm
        return view('admin.order.show', compact('order', 'products'));
    }

// ĐƠN HÀNG
    public function listOrders(Request $request)
    {
        // Lấy giá trị từ khóa từ request
        $orderCode = $request->input('order_code');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $orderSort = $request->input('order_sort', 'desc'); // Mặc định là 'desc'

        // Khởi tạo một truy vấn ban đầu cho danh sách đơn hàng
        $query = Order::query();

        // Kiểm tra nếu có từ khóa mã đơn hàng
        if ($orderCode) {
            // Tìm kiếm đơn hàng theo mã đơn hàng
            $query->where('order_code', 'LIKE', '%' . $orderCode . '%');
        }

        // Kiểm tra nếu có lọc trạng thái đơn hàng
        if (!is_null($status)) {
            // Lọc đơn hàng theo trạng thái
            $query->where('status', $status);
        }

        // Kiểm tra nếu có ngày bắt đầu và ngày kết thúc
        if ($startDate) {
            // Định dạng ngày từ dd/mm/yyyy sang yyyy-mm-dd
            $formattedStartDate = \Carbon\Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
            $query->whereDate('created_at', '>=', $formattedStartDate);
        }
        if ($endDate) {
            // Định dạng ngày từ dd/mm/yyyy sang yyyy-mm-dd
            $formattedEndDate = \Carbon\Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');
            $query->whereDate('created_at', '<=', $formattedEndDate);
        }

        // Sắp xếp đơn hàng theo yêu cầu của người dùng ('desc' hoặc 'asc')
        $query->orderBy('created_at', $orderSort);

        // Lấy danh sách đơn hàng dựa trên các điều kiện đã lọc
        $orders = $query->get();

        // Kiểm tra nếu danh sách đơn hàng rỗng
        if ($orders->isEmpty()) {
            // Lưu thông báo lỗi tạm thời
            session()->flash('error', 'Không tìm thấy đơn hàng nào với các tiêu chí đã chọn.');
        }

        // Trả về view với danh sách đơn hàng
        return view('admin.order.order_list', compact('orders'));
    }


       
    
    public function confirm(Request $request)
    {
        $orderCode = $request->input('key');
    
        // Tìm đơn hàng theo mã đơn hàng
        $orders = Order::where('order_code', $orderCode)->get();
    
        // Kiểm tra xem đơn hàng có tồn tại không
        if ($orders->isEmpty()) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }
    
        // Cập nhật trạng thái của các đơn hàng và số lượng sản phẩm
        foreach ($orders as $order) {
    
            // Cập nhật số lượng tồn kho của sản phẩm
            $product = Product::find($order->prd_id); // Tìm sản phẩm theo ID (prd_id)
            
            if ($product) {
                if ($product->quantity >= $order->quantity) {
                    // Giảm số lượng sản phẩm tồn kho
                    $product->quantity -= $order->quantity;
                    $product->save();
                } else {
                    // Nếu số lượng tồn kho không đủ, trả về lỗi
                    $order->status = 4; // Đặt trạng thái là "hủy"
                    $order->save();
                    return redirect()->back()->with('error', 'Số lượng tồn kho không đủ cho sản phẩm: ' . $product->prd_name);
                }
            } else {
                // Nếu không tìm thấy sản phẩm, trả về lỗi
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
            }
             // Cập nhật trạng thái đơn hàng
             $order->status = 1; // Đặt trạng thái là "Đang giao hàng"
             $order->save();
        }
    
        // Gửi email xác nhận đơn hàng
        Mail::to($orders->first()->customer_email)->send(new OrderConfirmation($orders));
    
        return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận và email xác nhận đã được gửi.');
    }
    public function delete(Request $request)
    {
        $orderCode = $request->input('key');
        
        // Tìm và xóa đơn hàng theo mã đơn hàng
        $order = Order::where('order_code', $orderCode)->first();
        
        if ($order) {
            $order->delete();
            return redirect()->back()->with('success', 'Đơn hàng đã được xóa.');
        } else {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }
    }
    public function viewlogin(){
        return view('admin.auth.login');
    }
    public function login(request $request){
       // Xác thực dữ liệu từ form
       $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
        ]);

        // Thử đăng nhập với guard 'admin'
        if (Auth::guard('admin')->attempt($credentials)) {
            // Nếu đăng nhập thành công, chuyển hướng về trang admin
            
            return redirect()->intended('/admin');
        }

        // Nếu đăng nhập thất bại, quay lại trang đăng nhập với lỗi
        return back()->withErrors([
            'error' => 'Tên đăng nhập hoặc mật khẩu không chính xác, vui lòng nhập lại',
            
        ]);
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return view('admin.auth.login');
    }
}
