<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 2px -2px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card h5 {
            font-weight: 600;
        }

        .stat-card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
        <a href="/admin" class="active">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="/admin/sanpham/danhsach">
            <i class="fas fa-box"></i> Sản phẩm
        </a>
        <a href="/admin/user/danhsach">
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

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3 stat-card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng số đơn hàng</h5>
                        <p class="display-6">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 stat-card">
                    <div class="card-body">
                        <h5 class="card-title">Số đơn hàng hôm nay</h5>
                        <p class="display-6">{{ $todayOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3 stat-card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng số sản phẩm</h5>
                        <p class="display-6">{{ $totalProducts }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3 stat-card">
                    <div class="card-body">
                        <h5 class="card-title">Số người dùng</h5>
                        <p class="display-6">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Table -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Danh sách quản lý</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>STT</th>
                                <th>Danh mục</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><a href="/admin/sanpham/danhsach">Danh sách sản phẩm</a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><a href="/admin/user/danhsach">Danh sách User</a></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><a href="/admin/orders/danhsach">Danh sách Đơn hàng</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Footer -->
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
    </div>

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
