<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            margin: 0 0 15px;
            line-height: 1.6;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tfoot tr {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            text-align: center;
            border-radius: 0 0 8px 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="https://i.imgur.com/GdDnzAw.png" alt="Ảnh minh họa" style="max-width: 100%; height: auto;">
        <h1>Xác nhận đơn hàng #{{ $orders[0]->order_code }}</h1>
        <p><strong>Kính gửi quý khách:</strong> {{ $orders[0]->customer_name }},</p>
        
        <p><strong>Địa chỉ giao hàng:</strong> {{ $orders[0]->shipping_address }}</p>
        
        <p><strong>Phương thức thanh toán:</strong> 
            @if (strpos($orders[0]->order_code, 'COD') !== false)
                Thanh toán khi nhận hàng
            @elseif (strpos($orders[0]->order_code, 'VNPAY') !== false)
                Thanh toán trực tuyến
            @else
                Chưa xác định
            @endif
        </p>
        <p>Cảm ơn quý khách đã đặt hàng tại cửa hàng của chúng tôi. Chúng tôi xác nhận đơn hàng của quý khách với thông tin chi tiết như sau:</p>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Thời gian đặt</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $stt = 1;
                    $S = 0;
                @endphp
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $stt }}</td>
                        <td>{{ $order->product_name }}</td>
                        <td>{{ number_format($order->product_price) }}đ</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ number_format($order->total_price) }}đ</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    @php
                        $S += $order->total_price;
                        $stt++;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Tổng cộng:</td>
                    <td colspan="2">{{ number_format($S) }}đ</td>
                </tr>
            </tfoot>
        </table>
        
        <p>Xin chân thành cảm ơn và mong được phục vụ quý khách trong tương lai.</p>
        <p>Trân trọng,</p>
        <p>Đội ngũ cửa hàng QuanMobilePhone của chúng tôi</p>
        <div class="footer">
            Cảm ơn quý khách đã mua sắm tại cửa hàng của chúng tôi!
        </div>
    </div>
</body>
</html>
