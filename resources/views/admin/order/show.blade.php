<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
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

        .order-details {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .order-details h2 {
            margin-bottom: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .order-details .item {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .order-details .item:last-child {
            border-bottom: none;
        }

        .item strong {
            display: inline-block;
            width: 200px;
        }

        .back-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .btn-back {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #0056b3;
            text-decoration: none;
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
        <a href="/admin" >
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="/admin/sanpham/danhsach">
            <i class="fas fa-box"></i> Sản phẩm
        </a>
        <a href="/admin/user/danhsach">
            <i class="fas fa-users"></i> Người dùng
        </a>
        <a href="/admin/orders/danhsach" class="active">
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
        <div class="container">

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

            <!-- Chi tiết đơn hàng -->
            <div class="order-details">
                <h2>Chi tiết đơn hàng #{{ $order->order_code }}</h2>
                <div class="item">
                    <strong>Mã đơn hàng:</strong> {{ $order->order_code }}
                </div>
                <div class="item">
                    <strong>Tên khách hàng:</strong> {{ $order->customer_name }}
                </div>
                <div class="item">
                    <strong>Số điện thoại:</strong> {{ $order->customer_phone }}
                </div>
                <div class="item">
                    <strong>Email:</strong> {{ $order->customer_email }}
                </div>
                <div class="item">
                    <strong>Địa chỉ nhận hàng:</strong> {{ $order->shipping_address }}
                </div>
                <div class="item">
                    <strong>Ghi chú của khách hàng:</strong> {{ $order->customer_note }}
                </div>
                <div class="item">
                    <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="item">
                    <strong>Trạng thái:</strong>
                    @if ($order->status == 0)
                        <span class="badge bg-warning">Chờ xử lý</span>
                    @elseif ($order->status == 1)
                        <span class="badge bg-primary">Đang giao hàng</span>
                    @elseif ($order->status == 2)
                        <span class="badge bg-success">Đã giao hàng</span>
                    @else
                        <span class="badge bg-danger">Hủy</span>
                    @endif
                </div>
            </div>

            <!-- Danh sách sản phẩm trong đơn hàng -->
            <div class="order-details">
                <h2>Danh sách sản phẩm</h2>
                @php
                    // Khởi tạo biến để lưu tổng tiền
                    $calculatedTotalPrice = 0;
                @endphp
                @foreach($products as $product)
                    @php
                        // Tính thành tiền cho từng sản phẩm
                        $itemTotal = $product->product_price * $product->quantity;
                        // Cộng thêm vào tổng tiền của đơn hàng
                        $calculatedTotalPrice += $itemTotal;
                    @endphp
                    <div class="item">
                        <strong>Tên sản phẩm:</strong> {{ $product->product_name }}
                    </div>
                    <div class="item">
                        <strong>Số lượng:</strong> {{ $product->quantity }}
                    </div>
                    <div class="item">
                        <strong>Giá sản phẩm:</strong> {{ number_format($product->product_price) }} VND
                    </div>
                    <div class="item">
                        <strong>Thành tiền:</strong> {{ number_format($itemTotal) }} VND
                    </div>
                @endforeach
                <div class="item">
                    <strong>Tổng tiền đơn hàng:</strong> {{ number_format($calculatedTotalPrice) }} VND
                </div>
            </div>

            <!-- Nút quay lại -->
            <div class="back-button">
                <a href="{{ url()->previous() }}" class="btn-back">Quay lại</a>
            </div>
             <!-- Print Button -->
             <div class="text-center my-3">
                <button class="btn btn-primary" onclick="printInvoice()">In hóa đơn</button>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Trường Đại học Kiến trúc Đà Nẵng</p>
        <p>Đồ án tốt nghiệp: Ngành Công nghệ thông tin - Sinh viên: Ngô Đức Anh Quân - MSSV: 2051220163</p>
    </footer>

    <!-- Hidden iframe for printing -->
    <iframe id="printFrame" style="display: none;"></iframe>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function printInvoice() {
            const printContent = `
                <html>
                <head>
                    <title>Hóa đơn - QuanMobilePhone</title>
                    <style>
                        body { font-family: Arial, sans-serif; color: #333; margin: 20px; }
                        h2, h3 { color: #007bff; text-align: center; }
                        .container { max-width: 700px; margin: auto; }
                        .header { text-align: center; margin-bottom: 20px; }
                        .header h2 { margin: 0; }
                        .header p { font-size: 14px; color: #555; }
                        .section { margin: 20px 0; }
                        .section h3 { border-bottom: 2px solid #007bff; padding-bottom: 5px; }
                        .item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; }
                        .item strong { color: #555; }
                        .total { font-size: 18px; font-weight: bold; color: #007bff; }
                        .thank-you { text-align: center; font-style: italic; margin-top: 30px; color: #007bff; }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="header">
                            <h2>QuanMobilePhone</h2>
                            <p>Ngày xuất hóa đơn: ${new Date().toLocaleDateString('vi-VN')}</p>
                        </div>
                        <div class="section">
                            <h3>Thông tin đơn hàng</h3>
                            <div class="item"><strong>Mã đơn hàng:</strong> {{ $order->order_code }}</div>
                            <div class="item"><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</div>
                            <div class="item"><strong>Tên khách hàng:</strong> {{ $order->customer_name }}</div>
                            <div class="item"><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</div>
                            <div class="item"><strong>Email:</strong> {{ $order->customer_email }}</div>
                            <div class="item"><strong>Địa chỉ nhận hàng:</strong> {{ $order->shipping_address }}</div>
                        </div>
                        <div class="section">
                            <h3>Chi tiết sản phẩm</h3>
                            ${`@foreach($products as $product)
                                <div class="item">
                                    <strong>Sản phẩm:</strong> {{ $product->product_name }}
                                </div>
                                <div class="item">
                                    <strong>Số lượng:</strong> {{ $product->quantity }}
                                </div>
                                <div class="item">
                                    <strong>Giá:</strong> {{ number_format($product->product_price) }} VND
                                </div>
                                <div class="item">
                                    <strong>Thành tiền:</strong> {{ number_format($product->product_price * $product->quantity) }} VND
                                </div>
                            @endforeach`}
                            <div class="item total">
                                <strong>Tổng tiền đơn hàng:</strong> {{ number_format($calculatedTotalPrice) }} VND
                            </div>
                        </div>
                        <p class="thank-you">Cảm ơn bạn đã mua sắm tại QuanMobilePhone! Hẹn gặp lại quý khách.</p>
                    </div>
                </body>
                </html>
            `;

            // Write content to the iframe and print
            const printFrame = document.getElementById('printFrame').contentWindow;
            printFrame.document.open();
            printFrame.document.write(printContent);
            printFrame.document.close();
            printFrame.focus();
            printFrame.print();
        }
    </script>
</body>
</html>
