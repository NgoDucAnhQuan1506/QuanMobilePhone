<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AcUser;
use App\Models\Order;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách các hãng sản xuất để hiển thị trong thanh menu
        $list_brands = Brand::all();

        // Kiểm tra nếu có từ khóa tìm kiếm trong request
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $list_product = Product::where('prd_name', 'like', '%' . $searchTerm . '%')
                ->get();
        }
        // Kiểm tra nếu có hãng sản xuất được chọn
        elseif ($request->has('hangsanxuat')) {
            $brand_id = $request->input('hangsanxuat');
            $list_product = Product::where('brand_id', $brand_id)->get();
        }
        // Nếu không có tìm kiếm hoặc hãng sản xuất, lấy sản phẩm ngẫu nhiên
        else {
            $list_product = Product::where('is_active', 1)
                       ->orderBy('created_at', 'desc')
                       ->take(8)
                       ->get();
        }

        return view('trangchu', compact('list_brands', 'list_product'));
    }

    public function showSP(request $request){
        $id = $request->input('key');

        // Lấy sản phẩm theo id
        $list_product = Product::find($id);
        //dd($list_product);
        // Lấy tất cả các hãng sản xuất
        $list_brands = Brand::all();

        return view('showSp', compact('list_product', 'list_brands'));
    }
    // Hiển thị thông tin người dùng
    public function showUserInfo()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (Auth::guard('acuser')->check()) {
            // Lấy thông tin người dùng đã đăng nhập
            $user = Auth::guard('acuser')->user();

            // Lấy danh sách các hãng sản xuất để hiển thị trong thanh menu
            $list_brands = Brand::all();

            // Lấy danh sách đơn hàng của người dùng
            $orders = Order::where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->get(); // Tải các sản phẩm trong đơn hàng

            // Trả về view với dữ liệu cần thiết
            return view('user.info', compact('list_brands', 'orders'));
        }
        else {
            return redirect()->route('formLoginUser')
                ->withErrors([
                    'error' => 'Vui lòng đăng nhập để sử dụng tính năng info user',
                ]);
        }
    }
    public function ajaxSearch(Request $request)
    {
        $keyword = $request->input('search');

        // Tìm các sản phẩm với từ khóa
        $products = Product::where('prd_name', 'like', "%$keyword%")->take(5)->get();

        return response()->json($products);
    }

    
}
