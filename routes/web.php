<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Home\AuthController;
use App\Http\Controllers\Home\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\PaymentController;

route::get('/',[HomeController::class,'index'])->name('home');
route::get('/login',[AuthController::class,'formLoginUser'])->name('formLoginUser');
route::post('/loginuser',[AuthController::class,'loginUser'])->name('loginUser');
route::get('/signup',[AuthController::class,'formSignupUser'])->name('formSignupUser');
route::post('/signup_acc',[AuthController::class,'registerUser'])->name('signupUser');
route::get('/Logout',[AuthController::class,'logout'])->name('logoutUser');




route::get('/testDk',[AdminController::class,'DangKy']);
route::post('/testDk',[AdminController::class,'testDk'])->name('dangky.post');

route::get('/admin/login',[AdminController::class,'viewlogin']);
route::post('/admin/login',[AdminController::class,'login'])->name('admin.login');


Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin', [AdminController::class, 'index']);
    route::get('/admin/logout',[AdminController::class,'logout'])->name('logoutad');
    //sản phẩm
    route::get('/admin/sanpham/danhsach',[AdminController::class,'danhsachsp'])->name('danhsachsp');
    route::get('/admin/sanpham/them',[AdminController::class,'viewThem'])->name('themSanphamForm');;
    route::post('/admin/sanpham/them',[AdminController::class,'themSanpham'])->name('themSanpham');
    route::get('/admin/sanpham/sua',[AdminController::class,'suaSanpham'])->name('ViewSuaSanpham');
    route::post('/admin/sanpham/sua',[AdminController::class,'updateProduct'])->name('updateProduct');
    Route::get('/admin/sanpham/danhsach/timkiem', [AdminController::class, 'searchSanpham'])->name('admin.sanpham.search');
    route::get('/admin/sanpham/xoa',[AdminController::class,'xoaSp'])->name('xoaSanpham');
    //user
    route::get('/admin/user/danhsach',[AdminController::class,'DanhSachUser'])->name('admin.users.index');;
    route::get('/admin/user/xoa',[AdminController::class,'xoaUser'])->name('xoaUser');
    Route::get('/admin/showorders/user', [AdminController::class, 'showOrdersByUser'])->name('orders.showByUser');
    Route::get('/admin/orders/show/{id}', [AdminController::class, 'show'])->name('orders.show');
    //đơn hàng
    Route::get('/admin/orders/danhsach', [AdminController::class, 'listOrders'])->name('admin.orders');
    Route::get('/admin/orders/confirm', [AdminController::class, 'confirm'])->name('orders.confirm');
    Route::get('/admin/orders/delete', [AdminController::class, 'delete'])->name('orders.delete');
    // Thêm các route admin khác tại đây
});
route::get('/showsanpham',[HomeController::class,'showSP'])->name('chiTietSanPham');
route::get('/cart',[CartController::class,'index'])->name('cart.index');
route::post('/addToCart',[CartController::class,'addToCart'])->name('addCart');
route::post('/addToCart2',[CartController::class,'addToCart2'])->name('addCart2');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('remove.from.cart');
Route::post('/update-user-info', [AuthController::class, 'updateUserInfo'])->name('update.user.info');
Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
//Thanh toán
Route::post('/payment', [PaymentController::class, 'create'])->name('payment.create');
Route::get('/vnpay_return', [PaymentController::class, 'vnpayReturn'])->name('vnpay.return');
Route::get('/search', [HomeController::class, 'index'])->name('search.user');
Route::get('/show', [HomeController::class, 'index']);
//info user
Route::get('/user/info', [HomeController::class, 'showUserInfo'])->name('userInfo');
Route::post('/user/change-password', [AuthController::class, 'changePassword'])->name('user.change.password');
//share giỏ hàng
Route::get('/cart/share', [CartController::class, 'shareCart'])->name('cart.share');
Route::get('/cart/{token}', [CartController::class, 'loadSharedCart'])->name('cart.loadShared');
//search Ajax
Route::get('/ajax/search', [HomeController::class, 'ajaxSearch'])->name('ajax.search');


