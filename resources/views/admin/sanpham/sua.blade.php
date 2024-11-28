<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản Phẩm</title>
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

        .form-control {
            margin-bottom: 15px;
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
        <div class="container-a">
        <div class="container-a">
        <h2 class="text-center mb-4 bg-success text-white p-3 rounded">Sửa Sản Phẩm</h2>

            <!-- Form sửa sản phẩm -->
            <form method="POST" enctype="multipart/form-data" action="{{ route('updateProduct') }}">
                @csrf
                <input type="hidden" name="prd_id" value="{{ $product->prd_id }}">

                <!-- Tên sản phẩm -->
                <div class="mb-3">
                    <label for="prd_name" class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="prd_name" name="prd_name" value="{{ $product->prd_name }}" required>
                </div>

                <!-- Ảnh sản phẩm -->
                <div class="mb-3">
                    <label for="image" class="form-label">Ảnh sản phẩm</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <img src="{{ asset('img/sanpham/' . $product->image) }}" style="width: 100px;" class="mt-3">
                </div>

                <!-- Giá sản phẩm -->
                <div class="mb-3">
                    <label for="price" class="form-label">Giá sản phẩm</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                </div>

                <!-- Số lượng sản phẩm -->
                <div class="mb-3">
                    <label for="quantity" class="form-label">Số lượng sản phẩm</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}" required>
                </div>

                <!-- Mô tả sản phẩm -->
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả sản phẩm</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ $product->description }}</textarea>
                </div>

                <!-- Thương hiệu -->
                <div class="mb-3">
                    <label for="brand_id" class="form-label">Thương hiệu</label>
                    <select class="form-select" id="brand_id" name="brand_id">
                        @foreach ($list_brand as $brand)
                            <option value="{{ $brand->brand_id }}" {{ $product->brand_id == $brand->brand_id ? 'selected' : '' }}>
                                {{ $brand->brand_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Trạng thái mở bán -->
                <div class="mb-3">
                    <label for="is_active" class="form-label">Trạng thái</label>
                    <select class="form-select" id="is_active" name="is_active">
                        <option value="1" {{ $product->is_active == 1 ? 'selected' : '' }}>On</option>
                        <option value="0" {{ $product->is_active == 0 ? 'selected' : '' }}>Off</option>
                    </select>
                </div>

                <!-- Nút thao tác -->
                <div class="btn-group mt-3">
                    <a href="{{ route('danhsachsp') }}" class="btn btn-secondary">Quay lại</a>
                    <input type="submit" class="btn btn-primary" name="btnUpdate" value="Cập nhật">
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
