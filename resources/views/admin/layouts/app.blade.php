<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container-custom {
            padding: 10px;
            background-color: pink;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ddd;
        }
        .logo img {
            max-height: 50px;
        }
        .chucnang {
            display: flex;
            align-items: center;
        }
        .login {
            display: flex;
            align-items: center;
        }
        .login span {
            margin-right: 10px;
            font-weight: bold;
        }
        .btn-custom {
            padding: 10px 20px;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .btn-submit {
            background-color: #007bff;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .btn-back {
            background-color: #6c757d;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
        .form-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-container h2 {
            margin-bottom: 20px;
            background-color: #C0C0C0;
        }
        .form-data {
            margin-bottom: 15px;
        }
        .form-data label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-data input, .form-data select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
    @yield('css')
</head>
<body>
    <div class="container-custom">
        <div class="logo">
            <a href="/admin">
                <img src="/img/logo-removebg.png" alt="Logo" class="img-fluid">
            </a>
        </div>
        <div class="chucnang">
            @if (Auth::guard('admin')->check())
            <div class="login">
                <span>Xin chào, {{ Auth::guard('admin')->user()->ad_name }}</span>
                <a href="{{ route('logoutad') }}" class="btn btn-danger btn-sm ml-2">Đăng xuất</a>
            </div>
            @else
            <?php return redirect()->route('admin.login'); ?>
            @endif
        </div>
    </div>

    <div class="container form-container">
        @yield('content')
    </div>
    
</body>
<footer style="margin-top: 50px; padding: 40px 0; background-color: #343a40; color: #ffffff;">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-around; align-items: center; text-align: center;">
        <div class="footer-logo" style="flex: 1; padding: 0 20px;">
            <img src="https://media.dau.edu.vn/Media/1_TH1057/Images/logo-dhktdn-copy.png" width="80px" height="80px">
            <p class="tentruong" style="margin: 10px 0 0; font-weight: bold; font-size: 16px;">Trường Đại học Kiến trúc Đà Nẵng</p>
            <p class="tentruong-eng" style="margin: 0; font-style: italic; font-size: 14px;">Danang Architecture University</p>
        </div>
        <div style="flex: 1; padding: 0 20px;">
            <p style="font-size: 18px; margin-bottom: 10px;">
                Đồ án tốt nghiệp: Ngành Công nghệ thông tin
            </p>
            <p style="font-size: 18px; margin-bottom: 10px;">
                Sinh viên thực hiện: Ngô Đức Anh Quân
            </p>
            <p style="font-size: 18px; margin-bottom: 10px;">
                Lớp: 20CT2 - MSSV: 2051220163
            </p>
        </div>
    </div>
</footer>
</html>
