<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../img/login/BackLoginus.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .login-container img.logo {
            width: 222px; 
            margin-bottom: 1rem;
        }
        .login-container h2 {
            margin-bottom: 1rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            text-align: left; /* Align label text to the left */
            display: block;
        }
        .form-control {
            border-radius: 4px;
        }
        .btn-primary {
            border-radius: 4px;
        }
        .alert {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
		<a href="/">
			<img src="../img/logo-removebg.png" alt="Logo" class="logo">
		</a>
        <h2>Đăng Nhập</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif

        <form action="{{ route('loginUser') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
			<a href="/signup">Tạo tài khoản mới</a>
            <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
        </form>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
