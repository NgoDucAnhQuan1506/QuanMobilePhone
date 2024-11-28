<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('../img/login/BackLoginus.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            padding: 50px 20px; /* Thêm padding để tạo khoảng cách trên và dưới */
            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem; /* Thêm padding để tạo khoảng cách trong container */
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
            margin-top: 50px; /* Thêm margin-top để tạo khoảng cách từ logo */
        }
        .register-container img.logo {
            width: 150px;
            margin-bottom: 1.5rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
            color: #007bff;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-group label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            display: block;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
        }
        .btn-primary {
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1.1rem;
            font-weight: bold;
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }
        .alert {
            margin-top: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <img src="../img/logo-removebg.png" alt="Logo" class="logo">
        <h2>Đăng Ký Tài Khoản</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form id="registerForm" action="{{ route('signupUser') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="us_name">Họ và tên</label>
                <input type="text" class="form-control" id="us_name" name="us_name" required>
            </div>
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="Sdt">Số điện thoại</label>
                <input type="text" class="form-control" id="Sdt" name="Sdt" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="dc_nhanhang">Địa chỉ nhận hàng</label>
                <input type="text" class="form-control" id="dc_nhanhang" name="dc_nhanhang">
            </div>
            <div class="form-group">
                <label for="thanhpho" style="font-size: 18px">Tỉnh thành phố:</label>
                <select id="thanhpho" name="thanhpho" class="form-control" style="font-size: 15px; height: 50px;">
                    <option value="">Vui lòng chọn</option>
                    <option value="An Giang">An Giang</option>
                    <option value="Bà Rịa - Vũng Tàu">Bà Rịa - Vũng Tàu</option>
                    <option value="Bắc Giang">Bắc Giang</option>
                    <option value="Bắc Kạn">Bắc Kạn</option>
                    <option value="Bạc Liêu">Bạc Liêu</option>
                    <option value="Bắc Ninh">Bắc Ninh</option>
                    <option value="Bến Tre">Bến Tre</option>
                    <option value="Bình Định">Bình Định</option>
                    <option value="Bình Dương">Bình Dương</option>
                    <option value="Bình Phước">Bình Phước</option>
                    <option value="Bình Thuận">Bình Thuận</option>
                    <option value="Cà Mau">Cà Mau</option>
                    <option value="Cao Bằng">Cao Bằng</option>
                    <option value="Đắk Lắk">Đắk Lắk</option>
                    <option value="Đắk Nông">Đắk Nông</option>
                    <option value="Điện Biên">Điện Biên</option>
                    <option value="Đồng Nai">Đồng Nai</option>
                    <option value="Đồng Tháp">Đồng Tháp</option>
                    <option value="Gia Lai">Gia Lai</option>
                    <option value="Hà Giang">Hà Giang</option>
                    <option value="Hà Nam">Hà Nam</option>
                    <option value="Hà Tĩnh">Hà Tĩnh</option>
                    <option value="Hải Dương">Hải Dương</option>
                    <option value="Hậu Giang">Hậu Giang</option>
                    <option value="Hòa Bình">Hòa Bình</option>
                    <option value="Hưng Yên">Hưng Yên</option>
                    <option value="Khánh Hòa">Khánh Hòa</option>
                    <option value="Kiên Giang">Kiên Giang</option>
                    <option value="Kon Tum">Kon Tum</option>
                    <option value="Lai Châu">Lai Châu</option>
                    <option value="Lâm Đồng">Lâm Đồng</option>
                    <option value="Lạng Sơn">Lạng Sơn</option>
                    <option value="Lào Cai">Lào Cai</option>
                    <option value="Long An">Long An</option>
                    <option value="Nam Định">Nam Định</option>
                    <option value="Nghệ An">Nghệ An</option>
                    <option value="Ninh Bình">Ninh Bình</option>
                    <option value="Ninh Thuận">Ninh Thuận</option>
                    <option value="Phú Thọ">Phú Thọ</option>
                    <option value="Quảng Bình">Quảng Bình</option>
                    <option value="Quảng Ngãi">Quảng Ngãi</option>
                    <option value="Quảng Ninh">Quảng Ninh</option>
                    <option value="Quảng Trị">Quảng Trị</option>
                    <option value="Sóc Trăng">Sóc Trăng</option>
                    <option value="Sơn La">Sơn La</option>
                    <option value="Tây Ninh">Tây Ninh</option>
                    <option value="Thái Bình">Thái Bình</option>
                    <option value="Thái Nguyên">Thái Nguyên</option>
                    <option value="Thanh Hóa">Thanh Hóa</option>
                    <option value="Thừa Thiên Huế">Thừa Thiên Huế</option>
                    <option value="Tiền Giang">Tiền Giang</option>
                    <option value="Trà Vinh">Trà Vinh</option>
                    <option value="Tuyên Quang">Tuyên Quang</option>
                    <option value="Vĩnh Long">Vĩnh Long</option>
                    <option value="Vĩnh Phúc">Vĩnh Phúc</option>
                    <option value="Yên Bái">Yên Bái</option>
                    <option value="Phú Yên">Phú Yên</option>
                    <option value="Tp.Cần Thơ">Tp.Cần Thơ</option>
                    <option value="Tp.Đà Nẵng">Tp.Đà Nẵng</option>
                    <option value="Tp.Hải Phòng">Tp.Hải Phòng</option>
                    <option value="Tp.Hà Nội">Tp.Hà Nội</option>
                    <option value="TP HCM">TP HCM</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Đăng Ký</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        var password = document.getElementById('password').value;
        var Sdt = document.getElementById('Sdt').value;
        var email = document.getElementById('email').value;

        // Kiểm tra mật khẩu
        if (password.length < 6) {
            alert('Mật khẩu phải có ít nhất 6 ký tự.');
            event.preventDefault(); // Ngăn chặn việc gửi form
            return;
        }

        // Kiểm tra số điện thoại
        var phoneRegex = /^[0-9]{10,10}$/; 
        if (!phoneRegex.test(Sdt)) {
            alert('Số điện thoại phải có 10 chữ số.');
            event.preventDefault(); // Ngăn chặn việc gửi form
            return;
        }

        // Kiểm tra email
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Biểu thức chính quy kiểm tra định dạng email
        if (!emailRegex.test(email)) {
            alert('Email không hợp lệ.');
            event.preventDefault(); // Ngăn chặn việc gửi form
            return;
        }
        });
    </script>
</body>
</html>
