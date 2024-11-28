<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách người dùng</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fc;
        }

        /* Sidebar Styles */
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            padding-top: 20px;
        }

        .sidebar a {
            color: #adb5bd;
            padding: 15px;
            text-decoration: none;
            display: block;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: #ffffff;
        }

        .sidebar a.active {
            background-color: #007bff;
            color: white;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .container-a {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .them a {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .them a:hover {
            background-color: #0056b3;
        }

        footer {
            margin-top: 50px;
            padding: 40px 0;
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <a href="/admin">
                <img src="/img/logo-removebg.png" alt="Logo" class="img-fluid" width="200">
            </a>
        </div>
        <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="/admin/sanpham/danhsach">
            <i class="fas fa-box"></i> Sản phẩm
        </a>
        <a href="/admin/user/danhsach" class="active">
            <i class="fas fa-users"></i> Người dùng
        </a>
        <a href="/admin/orders/danhsach">
            <i class="fas fa-receipt"></i> Đơn hàng
        </a>
        <a href="{{ route('logoutad') }}" class="btn btn-danger btn-sm w-100 mt-3">
            <i class="fas fa-sign-out-alt"></i> Đăng xuất
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <span class="navbar-brand">Xin chào, {{ Auth::guard('admin')->user()->ad_name }}</span>
            </div>
        </nav>
            <!-- Thông báo -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        <div class="container-a">
            <div class="container-a mb-4">
                <h2 class="text-center mb-4">Tìm kiếm người dùng</h2>
                <form action="{{ url('/admin/user/danhsach') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Nhập tên tài khoản" value="{{ request('username') }}">
                        <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                    </div>
                </form>
            </div>
            <h2 class="text-center mb-4">Danh sách người dùng</h2>
            <!-- Danh sách người dùng -->
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>STT</th>
                            <th>Username</th>
                            <th>Tên Người Dùng</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ nhận hàng</th>
                            <th>Tỉnh/Thành Phố</th>
                            <th colspan="2">Chức Năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->us_name }}</td>
                            <td>{{ $user->Sdt }}</td>
                            <td>{{ $user->dc_nhanhang }}</td>
                            <td>{{ $user->thanhpho }}</td>
                            <td>
                                <a href="/admin/showorders/user?key={{ $user->id }}" class="btn btn-primary btn-sm">Đơn đặt hàng</a>
                            </td>
                            <td>
                                <a href="/admin/user/xoa?key={{ $user->id }}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa account: {{ $user->username }}?')">Xóa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
