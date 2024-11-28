<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thông tin người dùng</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-cart.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-userInfo.css') }}">
    <!-- Thêm link tới Font Awesome nếu chưa có -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        @include('layout.header')
        <div class="full-hd">
            <div class="content">
                <!-- Thông báo thành công hoặc lỗi -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <!-- Thông tin người dùng -->
                @if(Auth::guard('acuser')->check())
                @php
                    $user = Auth::guard('acuser')->user();
                @endphp
                <div class="user-info">
                    <h3><i class="fas fa-info-circle"></i> Thông tin khách hàng</h3>
                    <form action="{{ route('update.user.info') }}" method="POST">
                        @csrf
                        <p><strong>Họ tên:</strong> <input type="text" name="us_name" value="{{ old('us_name', $user->us_name) }}" required></p>
                        <p><strong>Số điện thoại:</strong> <input type="text" name="Sdt" value="{{ old('Sdt', $user->Sdt) }}" required></p>
                        <p><strong>Email:</strong> <input type="email" name="email" value="{{ old('email', $user->email) }}" required></p>
                        <p><strong>Địa chỉ giao hàng:</strong> <input type="text" name="dc_nhanhang" value="{{ old('dc_nhanhang', $user->dc_nhanhang) }}" required></p>
                        <div class="form-group">
                            <label for="thanhpho" style="font-size: 18px">Tỉnh thành phố:</label>
                            <select id="thanhpho" name="thanhpho" class="form-control" style="font-size: 15px; height: 50px;">
                                <option value="">Chọn tỉnh thành phố</option>
                                @php
                                    $cities = [
                                        'An Giang', 'Bà Rịa - Vũng Tàu', 'Bắc Giang', 'Bắc Kạn', 'Bạc Liêu',
                                        'Bắc Ninh', 'Bến Tre', 'Bình Định', 'Bình Dương', 'Bình Phước',
                                        'Bình Thuận', 'Cà Mau', 'Cao Bằng', 'Đắk Lắk', 'Đắk Nông',
                                        'Điện Biên', 'Đồng Nai', 'Đồng Tháp', 'Gia Lai', 'Hà Giang',
                                        'Hà Nam', 'Hà Tĩnh', 'Hải Dương', 'Hậu Giang', 'Hòa Bình',
                                        'Hưng Yên', 'Khánh Hòa', 'Kiên Giang', 'Kon Tum', 'Lai Châu',
                                        'Lâm Đồng', 'Lạng Sơn', 'Lào Cai', 'Long An', 'Nam Định',
                                        'Nghệ An', 'Ninh Bình', 'Ninh Thuận', 'Phú Thọ', 'Quảng Bình',
                                        'Quảng Ngãi', 'Quảng Ninh', 'Quảng Trị', 'Sóc Trăng', 'Sơn La',
                                        'Tây Ninh', 'Thái Bình', 'Thái Nguyên', 'Thanh Hóa', 'Thừa Thiên Huế',
                                        'Tiền Giang', 'Trà Vinh', 'Tuyên Quang', 'Vĩnh Long', 'Vĩnh Phúc',
                                        'Yên Bái', 'Phú Yên', 'Tp.Cần Thơ', 'Tp.Đà Nẵng', 'Tp.Hải Phòng',
                                        'Tp.Hà Nội', 'TP HCM'
                                    ];
                                @endphp
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ $user->thanhpho == $city ? 'selected' : '' }}>{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                    </form>
                </div>

                <!-- Form đổi mật khẩu -->
                <div class="change-password">
                    <h3 id="toggle-password-form" style="cursor: pointer;">
                        <i class="fas fa-pencil-alt"></i> Đổi mật khẩu
                    </h3>
                    <form id="password-form" action="{{ route('user.change.password') }}" method="POST" style="display: none;">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Mật khẩu hiện tại:</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Mật khẩu mới:</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">Xác nhận mật khẩu mới:</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                    </form>
                </div>

                <script>
                    document.getElementById('toggle-password-form').addEventListener('click', function() {
                        var form = document.getElementById('password-form');
                        // Kiểm tra trạng thái hiển thị và chuyển đổi
                        if (form.style.display === 'none' || form.style.display === '') {
                            form.style.display = 'block';
                        } else {
                            form.style.display = 'none';
                        }
                    });
                </script>
                <!-- Danh sách đơn hàng của khách hàng -->
                <div class="user-orders">
                    <h3><i class="fas fa-box"></i> Đơn hàng của bạn</h3>
                    <table class="table text-center order-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã đơn hàng</th>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1; // Biến đếm để đánh số thứ tự các đơn hàng
                                $groupedOrders = $orders->groupBy('order_code'); // Nhóm các đơn hàng theo mã đơn hàng
                            @endphp
                            @foreach($groupedOrders as $orderCode => $group)
                                @php
                                    $rowCount = $group->count(); // Số lượng sản phẩm trong nhóm
                                    $totalPrice = $group->sum('total_price'); // Tổng tiền các sản phẩm trong đơn hàng
                                @endphp
                                @foreach($group as $key => $order)
                                <tr>
                                    @if ($key == 0)  <!-- Chỉ hiển thị các thông tin đơn hàng một lần cho sản phẩm đầu tiên trong nhóm -->
                                        <td rowspan="{{ $rowCount }}">{{ $i++ }}</td>
                                        <td rowspan="{{ $rowCount }}">{{ $order->order_code }}</td>
                                    @endif
                                    <td>{{ $order->product_name }}</td>
                                    <td>{{ number_format($order->product_price) }} VND</td>
                                    <td>{{ $order->quantity }}</td>
                                    @if ($key == 0)
                                        <td rowspan="{{ $rowCount }}">{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td rowspan="{{ $rowCount }}">{{ number_format($totalPrice) }} VND</td>
                                        <td rowspan="{{ $rowCount }}">
                                            @if ($order->status == 0)
                                                <span class="badge bg-warning">Chờ xử lý</span>
                                            @elseif ($order->status == 1)
                                                <span class="badge bg-info">Đang giao hàng</span>
                                            @elseif ($order->status == 2)
                                                <span class="badge bg-success">Đã giao hàng</span>
                                            @else
                                                <span class="badge bg-danger">Đã hủy</span>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
        @include('layout.footer')
    </div>
</body>
</html>
