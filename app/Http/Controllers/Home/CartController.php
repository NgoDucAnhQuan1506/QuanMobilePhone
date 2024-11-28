<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\AcUser;
use App\Models\Brand;
use App\Models\Product;
use Auth;
use Cache;
use Illuminate\Http\Request;
use Str;

class CartController extends Controller
{
    public function index()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (Auth::guard('acuser')->check()) {
            // Lấy người dùng hiện tại
            $user = Auth::guard('acuser')->user();
            $list_brands = Brand::all();
            // Lấy giỏ hàng của người dùng hiện tại
            $cart = session()->get('cart');
            // Lấy danh sách sản phẩm từ giỏ hàng để truyền vào view
            $products = Product::all();
            return view('cart.view', compact('cart', 'list_brands', 'user', 'products'));
        }
        // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
        else {
            return redirect()->route('formLoginUser')
            ->withErrors([
                'error' => 'Vui lòng đăng nhập để sử dụng tính năng giỏ hàng',]);
        }
    }
    public function addToCart(Request $request)
    {
        $id = $request->input('key');
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->withErrors('Sản phẩm không tồn tại');
        }

        $cart = session()->get('cart', []);
        $quantity = $request->input('soluong');

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->prd_name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $product->image,
                'prd_id'   => $product->prd_id
            ];
        }

        session()->put('cart', $cart);
        // Chuyển hướng đến trang giỏ hàng sau khi thêm thành công
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
    }
    public function addToCart2(Request $request)
    {
        $id = $request->input('product_id'); // Use 'product_id' to match the JSON data key
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
        }

        $cart = session()->get('cart', []);
        $quantity = $request->input('soluong', 1); // Default quantity to 1 if not specified

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->prd_name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $product->image,
                'prd_id'   => $product->prd_id
            ];
        }

        session()->put('cart', $cart);

        // Return the updated cart count in JSON format
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng'
        ]);
    }
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->input('id');
        $quantity = $request->input('quantity');

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity[$id];
            session()->put('cart', $cart);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
        }

        return redirect()->route('cart.index')->withErrors('Sản phẩm không tồn tại trong giỏ hàng');
    }
    public function clearCart()
    {
        // Clear the cart session
        session()->forget('cart');

        return redirect()->back()->with('success', 'Giỏ hàng đã được xóa thành công.');
    }
    public function shareCart()
    {
        // Lấy giỏ hàng hiện tại từ session
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors('Giỏ hàng trống, không thể chia sẻ.');
        }
    
        // Tạo token duy nhất cho giỏ hàng và lưu vào cache (lưu trong 60 phút)
        $token = Str::random(10) . time();
        Cache::put($token, $cart, now()->addMinutes(60));
    
        // Tạo liên kết chia sẻ
        $shareLink = route('cart.loadShared', ['token' => $token]);
        $list_brands = Brand::all();
        return view('cart.share', compact('shareLink','list_brands'));
    }
    public function loadSharedCart($token)
    {
        $cart = Cache::get($token);

        if (!$cart) {
            return redirect()->route('cart.index')->withErrors('Liên kết không hợp lệ hoặc đã hết hạn.');
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được tải thành công từ liên kết chia sẻ.');
    }
}
