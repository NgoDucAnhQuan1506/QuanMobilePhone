<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\AcUser;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function formLoginUser(){
        return view('Auth.login');
    }
    public function loginUser(request $request){
        // Xác thực dữ liệu từ form
        $credentials = $request->validate([
         'username' => 'required|string',
         'password' => 'required|string',
         ]);
         
         // Thử đăng nhập với guard 'acuser'
         if (Auth::guard('acuser')->attempt($credentials)) {
             // Nếu đăng nhập thành công, chuyển hướng về trang chủ
             return redirect()->intended('/');
         }
 
         // Nếu đăng nhập thất bại, quay lại trang đăng nhập với lỗi
         return back()->withErrors([
            'error' => 'Tên đăng nhập hoặc mật khẩu không chính xác, vui lòng nhập lại',
        ]);
     }
    public function formSignupUser(){
        return view('Auth.signup');
    }
    public function registerUser(Request $request) {
        // Validate dữ liệu từ form
        $request->validate([
            'us_name' => 'required|string|max:50',
            'username' => 'required|string|max:20|unique:ac_users,username',
            'password' => 'required|string|min:6',
            'Sdt' => 'required|string|max:10', 
            'email' => 'required|string|email|max:255|unique:ac_users,email',
            'dc_nhanhang' => 'nullable|string|max:255',
            'thanhpho' => 'nullable|string|max:100',
        ], [
            'required' => ':attribute không được bỏ trống.',
            'string' => ':attribute phải là một chuỗi ký tự.',
            'max' => [
                'string' => ':attribute không được vượt quá :max ký tự.',
            ],
            'min' => [
                'string' => ':attribute phải có ít nhất :min ký tự.',
            ],
            'email' => ':attribute phải là một địa chỉ email hợp lệ.',
            'unique' => ':attribute đã được sử dụng.',
            'nullable' => ':attribute có thể để trống.',
            'attributes' => [
                'us_name' => 'Họ và tên',
                'username' => 'Tên đăng nhập',
                'password' => 'Mật khẩu',
                'Sdt' => 'Số điện thoại',
                'email' => 'Email',
                'dc_nhanhang' => 'Địa chỉ nhận hàng',
                'thanhpho' => 'Tỉnh thành phố',
            ],
        ]);        
        // Tạo tài khoản người dùng mới
        $user = new AcUser();
        $user->us_name = $request->us_name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->Sdt = $request->Sdt;
        $user->email = $request->email;
        $user->dc_nhanhang = $request->dc_nhanhang;
        $user->thanhpho = $request->thanhpho;
        $user->save();
    
        // Đăng nhập người dùng và chuyển hướng về trang chủ
        Auth::guard('acuser')->login($user);
    
        return redirect()->intended('/');
    }
    public function logout()
    {
        Auth::guard('acuser')->logout();
        return redirect('/');
    }
    // Xử lý đổi mật khẩu
    public function changePassword(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'required' => ':attribute không được bỏ trống.',
            'string' => ':attribute phải là một chuỗi ký tự.',
            'min' => [
                'string' => ':attribute phải có ít nhất :min ký tự.',
            ],
            'confirmed' => 'Mật khẩu mới không khớp với xác nhận.',
        ]);

        // Lấy người dùng hiện tại và ép kiểu về AcUser
        $user = Auth::guard('acuser')->user();
        if ($user instanceof AcUser) { //check thực thể
            // Kiểm tra xem mật khẩu hiện tại có đúng không
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
            }

            // Cập nhật mật khẩu mới
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            return back()->with('success', 'Đổi mật khẩu thành công.');
        }

        return back()->with('error', 'Không thể xác thực người dùng.');
    }
    public function updateUserInfo(Request $request)
    {
        $userId = Auth::guard('acuser')->id();
        $user = AcUser::find($userId);
        // Xác thực dữ liệu người dùng
        $validatedData = $request->validate([
            'us_name' => 'required|string|max:50',
            'Sdt' => 'required|string|max:10',
            'email' => 'required|email|max:255|unique:ac_users,email,' . $user->id,
            'dc_nhanhang' => 'required|string|max:255',
            'thanhpho' => 'nullable|string|max:100', // Cần thêm nếu muốn cập nhật
        ],[
            'required' => ':attribute không được bỏ trống.',
            'string' => ':attribute phải là một chuỗi ký tự.',
            'max' => [
                'string' => ':attribute không được vượt quá :max ký tự.',
            ],
            'min' => [
                'string' => ':attribute phải có ít nhất :min ký tự.',
            ],
            'email' => ':attribute phải là một địa chỉ email hợp lệ.',
            'unique' => ':attribute đã được sử dụng.',
            'nullable' => ':attribute có thể để trống.',
            'attributes' => [
                'us_name' => 'Họ và tên',
                'username' => 'Tên đăng nhập',
                'password' => 'Mật khẩu',
                'Sdt' => 'Số điện thoại',
                'email' => 'Email',
                'dc_nhanhang' => 'Địa chỉ nhận hàng',
                'thanhpho' => 'Tỉnh thành phố',
            ],
        ]); 
        

         // Cập nhật thông tin người dùng
        $user->us_name = $validatedData['us_name'];
        $user->Sdt = $validatedData['Sdt'];
        $user->email = $validatedData['email'];
        $user->dc_nhanhang = $validatedData['dc_nhanhang'];
        $user->thanhpho = $validatedData['thanhpho'] ?? $user->thanhpho; // Chỉ cập nhật nếu có giá trị mới

        // Lưu thay đổi
        $user->save();

        return back()->with('success', 'Thông tin của bạn đã được cập nhật.');
    }
}
