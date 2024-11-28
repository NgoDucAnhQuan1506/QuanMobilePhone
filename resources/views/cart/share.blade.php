<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Kết Chia Sẻ Giỏ Hàng</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-cart.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    .btn-primary {
        display: inline-block;
        padding: 12px 20px;
        font-size: 18px;
        color: white;
        background-color: #3498db;
        border: none;
        border-radius: 25px;
        text-decoration: none;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s, transform 0.2s;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        transform: scale(1.05);
        text-decoration: none;
    }

    .btn-primary:active {
        transform: scale(0.95);
    }

    .countdown {
        text-align: center;
        font-size: 20px;
        margin-top: 10px;
        color: red;
    }
</style>
<body>
    <div class="container">
        <!-- Header -->
        @include('layout.header')

        <!-- Nội dung -->
        <div class="full-hd">
            <div class="content">
                <h2 style="text-align: center; color: brown; background-color: white; padding: 10px; border-radius: 15px;">
                    <i class="fas fa-link"></i> Liên Kết Chia Sẻ Giỏ Hàng
                </h2>
                <div class="alert alert-info" style="margin-top: 20px;">
                    <p>Sao chép liên kết bên dưới và gửi cho bạn bè của bạn:</p>
                    <input type="text" class="form-control" value="{{ $shareLink }}" readonly onclick="this.select();">
                    <small>Liên kết này sẽ hết hạn sau 60 phút.</small>
                    <div class="countdown" id="countdown"></div>
                </div>
                <div style="text-align: center; margin-top: 20px;">
                    <a href="{{ route('cart.index') }}" class="btn-primary">
                        <i class="fas fa-arrow-left"></i> Quay lại Giỏ Hàng
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('layout.footer')
    </div>

    <script>
        // Thời gian đếm ngược (60 phút tính bằng giây)
        var countDownTime = 60 * 60;

        function startCountdown() {
            var countdownElement = document.getElementById('countdown');

            var interval = setInterval(function () {
                var minutes = Math.floor(countDownTime / 60);
                var seconds = countDownTime % 60;

                // Định dạng số giây để luôn có 2 chữ số
                seconds = seconds < 10 ? '0' + seconds : seconds;

                countdownElement.textContent = 'Thời gian còn lại: ' + minutes + ':' + seconds;

                if (countDownTime <= 0) {
                    clearInterval(interval);
                    countdownElement.textContent = 'Liên kết đã hết hạn!';
                    // Có thể thêm hành động khi hết hạn, ví dụ: ẩn liên kết hoặc chuyển hướng
                    // window.location.href = "{{ route('cart.index') }}";
                }

                countDownTime--;
            }, 1000);
        }

        // Bắt đầu đếm ngược khi trang được tải
        window.onload = startCountdown;
    </script>
</body>
</html>
