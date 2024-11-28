<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giỏ hàng của bạn</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-cart.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
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
                @endif
                <h2 style="width: 550px; color: brown; text-align: center; background-color: white; padding: 10px; border-radius: 15px;">
                <i class="fas fa-shopping-cart"></i> Giỏ hàng của bạn
                </h2>
                @if(session('cart') && count(session('cart')) > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach(session('cart') as $id => $details)
                                @php
                                    $subtotal = $details['quantity'] * $details['price'];
                                    $total += $subtotal;
                                    $product = $products->firstWhere('prd_id', $id);
                                @endphp
                                <tr>
                                    <td><img src="{{ asset('img/sanpham/' . $details['image']) }}" alt="{{ $details['name'] }}" style="width: 100px;"></td>
                                    <td>{{ $details['name'] }}</td>
                                    <td>
                                        <div class="quantity-container">
                                            <button class="btn btn-outline-primary btn-sm" onclick="updateCartQuantity('{{ $id }}', -1)">-</button>
                                            <input type="number" id="quantity-{{ $id }}" name="quantity[{{ $id }}]" value="{{ $details['quantity'] }}" min="1" max="{{ $product->quantity }}" readonly style="width: 60px; margin: 0 10px;">
                                            <button class="btn btn-outline-primary btn-sm" onclick="updateCartQuantity('{{ $id }}', 1)">+</button>
                                        </div>
                                    </td>
                                    <td>{{ number_format($details['price'], 0, ',', '.') }}₫</td>
                                    <td>{{ number_format($subtotal, 0, ',', '.') }}₫</td>
                                    <td>
                                        <a href="{{ route('remove.from.cart', $id) }}" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Xóa
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td colspan="4" class="text-right">Tổng cộng:</td>
                                <td>{{ number_format($total, 0, ',', '.') }}₫</td>
                                <td>
                                    <a href="{{ route('cart.clear') }}" class="btn btn-danger btn-sm cart-action">
                                        <i class="fas fa-times-circle"></i> Xóa giỏ hàng
                                    </a>
                                    <br><br>
                                    <a href="{{ route('cart.share') }}" class="btn btn-primary cart-action">
                                        <i class="fas fa-share-alt"></i> Chia sẻ giỏ hàng
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h3>Chọn phương thức thanh toán</h3>
                    <form action="{{ route('payment.create') }}" method="POST">
                        @csrf
                        <div class="payment-method">
                            <input type="radio" id="cod" name="payment_method" value="cod" checked>
                            <label for="cod">Thanh toán khi nhận hàng (COD)</label><br>

                            <input type="radio" id="vnpay" name="payment_method" value="vnpay">
                            <label for="vnpay">Thanh toán trực tuyến VNPAY</label><br>
                        </div>

                        <div class="form-group">
                            <label for="message_to_seller">Tin nhắn cho người bán:</label>
                            <textarea id="message_to_seller" name="message_to_seller" class="form-control" rows="4" placeholder="Nhập tin nhắn của bạn cho người bán..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Thanh toán</button>
                    </form>
                @else
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart" style="font-size: 100px; color: #ccc;"></i>
                        <p style="font-size: 18px; color: #888; margin-top: 20px;">Giỏ hàng của bạn hiện tại không có sản phẩm nào.</p>
                        <a href="{{ url('/') }}" class="btn btn-primary" style="margin-top: 20px;">Tiếp tục mua sắm</a>
                    </div>
                @endif
            </div>
        </div>
        @include('layout.footer')
    </div>
</body>
<script>
    function updateCartQuantity(id, change) {
        let quantityInput = document.getElementById('quantity-' + id);
        let currentQuantity = parseInt(quantityInput.value);
        let newQuantity = currentQuantity + change;

        // Kiểm tra giới hạn số lượng
        if (newQuantity >= parseInt(quantityInput.min) && newQuantity <= parseInt(quantityInput.max)) {
            quantityInput.value = newQuantity;

            // Gửi yêu cầu POST để cập nhật giỏ hàng
            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id', id);
            formData.append('quantity[' + id + ']', newQuantity);

            fetch('{{ route("cart.update") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật lại giao diện nếu cần, ví dụ tổng tiền
                    location.reload(); // Tải lại trang để cập nhật giao diện
                } else {
                    alert('Có lỗi xảy ra khi cập nhật giỏ hàng.');
                }
            });
        }
    }
</script>
</html>
