<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
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

        .table img {
            width: 100px;
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
        <a href="/admin/sanpham/danhsach" class="active">
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
        <!-- Notifications -->
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <!-- Product List -->
        <div class="container-a">
        <h2 class="text-center mb-4">Danh sách sản phẩm</h2>
            <!-- Search Form -->
            <form action="{{ url('/admin/sanpham/danhsach/timkiem') }}" method="GET" class="form-inline mb-3 d-flex justify-content-between">
                <input type="text" name="keyword" class="form-control w-75" placeholder="Nhập tên sản phẩm..." value="{{ request()->keyword }}">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>

            <!-- Add New Button -->
            <div class="them text-end mb-3">
                <a class="btn btn-primary" href="{{ url('/admin/sanpham/them') }}">Thêm mới</a>
            </div>

            <!-- Product Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh sản phẩm</th>
                            <th>Giá sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Mô tả sản phẩm</th>
                            <th>Thương hiệu</th>
                            <th>Trạng thái mở bán</th>
                            <th colspan="2">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $product->prd_name }}</td>
                            <td><img src="{{ asset('img/sanpham/' . $product->image) }}" alt="Ảnh sản phẩm"></td>
                            <td>{{ number_format($product->price, 0, ',', '.') }} VND</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->brand->brand_name }}</td>
                            <td>
                                @if ($product->is_active == 1)
                                    <span class="badge bg-success">On</span>
                                @else
                                    <span class="badge bg-danger">Off</span>
                                @endif
                            </td>
                            <td><a class="btn btn-primary btn-sm" href="{{ url('/admin/sanpham/sua?key=' . $product->prd_id) }}">Sửa</a></td>
                            <td><a class="btn btn-danger btn-sm" href="{{ url('/admin/sanpham/xoa?key=' . $product->prd_id) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm: {{ $product->prd_name }}')">Xóa</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
        <!-- Footer -->
        <footer>
            <p>&copy; 2024 Trường Đại học Kiến trúc Đà Nẵng</p>
            <p>Đồ án tốt nghiệp: Ngành Công nghệ thông tin - Sinh viên: Ngô Đức Anh Quân - MSSV: 2051220163</p>
        </footer>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
