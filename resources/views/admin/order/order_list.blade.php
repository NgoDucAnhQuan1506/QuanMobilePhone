<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
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
        <a href="/admin/user/danhsach">
            <i class="fas fa-users"></i> Người dùng
        </a>
        <a href="/admin/orders/danhsach"  class="active">
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
        <div class="container mt-4">

            <!-- Thông báo thành công hoặc lỗi -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="container-a mb-4">
            <h2 class="text-center mb-4">Tìm kiếm đơn hàng</h2>
            <form action="{{ url('/admin/orders/danhsach') }}" method="GET">
                <div class="row">
                    <!-- Mã đơn hàng -->
                    <div class="col-md-4 mb-3">
                        <input type="text" name="order_code" class="form-control" placeholder="Nhập mã đơn hàng" value="{{ request('order_code') }}">
                    </div>
                    <!-- Trạng thái đơn hàng -->
                    <div class="col-md-4 mb-3">
                        <select name="status" class="form-select">
                            <option value="">Tất cả trạng thái</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đã giao hàng</option>
                            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Hủy</option>
                        </select>
                    </div>
                    <!-- Ngày bắt đầu -->
                    <div class="col-md-2 mb-3">
                        <input type="text" name="start_date" class="form-control" placeholder="Ngày bắt đầu" value="{{ request('start_date') }}">
                    </div>
                    <!-- Ngày kết thúc -->
                    <div class="col-md-2 mb-3">
                        <input type="text" name="end_date" class="form-control" placeholder="Ngày kết thúc" value="{{ request('end_date') }}">
                    </div>
                    <!-- Lọc đơn hàng mới nhất -->
                    <div class="col-md-4 mb-3">
                        <select name="order_sort" class="form-select">
                            <option value="desc" {{ request('order_sort') == 'desc' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="asc" {{ request('order_sort') == 'asc' ? 'selected' : '' }}>Cũ nhất</option>
                        </select>
                    </div>
                    <!-- Nút tìm kiếm -->
                    <div class="col-md-12 mb-3">
                        <button class="btn btn-primary w-100" type="submit">Tìm kiếm</button>
                    </div>
                </div>
            </form>




            <div class="container-a">
                <h2 class="text-center mb-4">Danh sách đơn hàng</h2>
                <table class="table text-center" id="ordersTable">
                    <thead class="table-dark">
                        <tr>
                            <th>STT</th>
                            <th>Mã đơn hàng</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá sản phẩm</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th colspan="3">Chức Năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1; // Biến đếm để đánh số thứ tự các nhóm đơn hàng.
                            $groupedOrders = $orders->groupBy('order_code'); // Nhóm các đơn hàng theo mã đơn hàng
                        @endphp
                        @foreach ($groupedOrders as $orderCode => $group)
                            @php
                                $rowCount = $group->count(); // Số lượng sản phẩm trong nhóm
                                $totalPrice = $group->sum('total_price'); // Tổng tiền các sản phẩm
                            @endphp
                            @foreach ($group as $key => $order)
                            <tr data-order-code="{{ $orderCode }}">
                                @if ($key == 0)  <!-- chỉ thực thi khi đơn hàng đầu tiên của nhóm được duyệt (dòng đầu tiên). -->
                                    <!-- Gộp ô mã đơn hàng và tổng tiền -->
                                    <td rowspan="{{ $rowCount }}">{{ $i++ }}</td> 
                                    <td rowspan="{{ $rowCount }}">{{ $orderCode }}</td> <!-- Mã đơn hàng (hiển thị một lần cho cả nhóm) -->
                                @endif
                                <!-- Hiển thị thông tin sản phẩm -->
                                <td>{{ $order->product_name }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ number_format($order->product_price) }} VND</td>

                                @if ($key == 0)
                                    <!-- Chỉ hiển thị một lần ô tổng tiền -->
                                    <td rowspan="{{ $rowCount }}">{{ number_format($totalPrice) }} VND</td>
                                    <!-- Gộp ô ngày đặt -->
                                    <td rowspan="{{ $rowCount }}">{{ $order->created_at->format('d/m/Y') }}</td>
                                    <!-- Gộp ô trạng thái đơn hàng -->
                                    <td rowspan="{{ $rowCount }}">
                                        @if ($order->status == 0)
                                            Chờ xử lý
                                        @elseif ($order->status == 1)
                                            Đang giao hàng
                                        @elseif ($order->status == 2)
                                            Đã giao hàng
                                        @else
                                            Hủy
                                        @endif
                                    </td>
                                    <!-- Chức năng sẽ hiển thị một lần ở cuối nhóm -->
                                    <td rowspan="{{ $rowCount }}">
                                        @if ($order->status == 1) <!-- Trạng thái "Đang giao hàng" -->
                                            <button class="btn btn-secondary btn-sm" disabled>Đã xác nhận</button>
                                        @elseif ($order->status == 3) <!-- Trạng thái "Đã giao" -->
                                            <button class="btn btn-primary btn-sm" disabled>Đã giao</button>
                                        @elseif ($order->status == 4) <!-- Trạng thái "Đã hủy" -->
                                            <button class="btn btn-danger btn-sm" disabled>Đã hủy</button>
                                        @else
                                            <a href="{{ url('/admin/orders/confirm/?key=' . $orderCode) }}" class="btn btn-success btn-sm">Xác nhận</a>
                                        @endif
                                    </td>
                                    <td rowspan="{{ $rowCount }}">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Xem</a>
                                    </td>
                                    <td rowspan="{{ $rowCount }}">
                                        <a href="{{ url('/admin/orders/delete/?key=' . $orderCode) }}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa các đơn hàng với mã: {{ $orderCode }}?')">Xóa</a>  
                                    </td>
                                @endif
                            </tr>
                            @endforeach
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

    <!-- JavaScript để thêm màu nền xen kẽ cho các nhóm đơn hàng -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let rows = document.querySelectorAll('#ordersTable tbody tr');
            let lastOrderCode = '';
            let isAlternate = false;

            rows.forEach((row) => {
                let currentOrderCode = row.getAttribute('data-order-code');
                if (currentOrderCode !== lastOrderCode) {
                    isAlternate = !isAlternate; // Chuyển đổi trạng thái xen kẽ
                    lastOrderCode = currentOrderCode;
                }
                
                if (isAlternate) {
                    row.style.backgroundColor = '#f9f9f9';
                } else {
                    row.style.backgroundColor = '#ffffff';
                }
            });
            // Tạo hiệu ứng hover cho các nhóm đơn hàng
            rows.forEach((row) => {
                row.addEventListener('mouseenter', function() {
                    let orderCode = row.getAttribute('data-order-code');
                    rows.forEach((r) => {
                        if (r.getAttribute('data-order-code') === orderCode) {
                            r.style.backgroundColor = '#e2e6ea';
                        }
                    });
                });

                row.addEventListener('mouseleave', function() {
                    let orderCode = row.getAttribute('data-order-code');
                    rows.forEach((r) => {
                        if (r.getAttribute('data-order-code') === orderCode) {
                            // Khôi phục màu nền xen kẽ ban đầu
                            let isAlternateRow = Array.from(rows).indexOf(r) % 2 === 0;
                            r.style.backgroundColor = isAlternateRow ? '#f9f9f9' : '#ffffff';
                        }
                    });
                });
            });
        });
    </script>

</body>
</html>
