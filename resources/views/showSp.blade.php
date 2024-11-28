<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{$list_product->prd_name}}</title>
	<link rel="stylesheet" type="text/css" href="css/style-sp.css">
</head>

<body>
	<div class="container">
	@include('layout.header')
		<div class="full-hd">
		<div class="content">
			<div class="Banner">
				<div class="full">
						<img src="../img/banner/saleS.png">
				</div>
			</div>
			@if (session('success'))
			<p class="alert alert-success">
				{{ session('success') }}
			</p>
			@endif
			<h2 style="width: 550px; color: brown; text-align: center; background-color: white; padding: 10px; border-radius: 15px;">{{$list_product->prd_name}}</h2>
			<div class="CT-item">
				<div class="anh-item">
				<img style="width: 60%;margin: 86px 86px;" src="{{ asset('img/sanpham/' . $list_product->image) }}">
				</div>
				<div class="mieuta-item">
					<p class="price"><img width="29px" src="../img/icon_ut/icon-gia.png"> {{ number_format($list_product->price, 0, ',', '.') }}₫</p>
					<div class="tt-sp">
						<h2>Thông tin sản phẩm</h2>
						<h3>{{$list_product->description}}</h2>
					</div>
					<div class="uytin">
						<h4><img width="22px" style="vertical-align: middle;" src="../img/icon_ut/loop-512.png"> Hư gì đổi nấy 12 tháng tại 20CT2 (miễn phí tháng đầu)</h4>
						<h4><img width="22px" style="vertical-align: middle;" src="../img/icon_ut/nice-212.png"> Bảo hành chính hãng điện thoại 1 năm tại các trung tâm bảo hành 20CT2</h4>
						<h4><img width="22px" style="vertical-align: middle;" src="../img/icon_ut/icon-full.png"> Phụ kiện kèm theo đầy đủ</h4>
					</div>
					<form action="/addToCart?key={{$list_product->prd_id}}" method="POST">
                    @csrf
                        @if($list_product->is_active == 0)
                            <h3 style="color: red;">SẢN PHẨM NGỪNG KINH DOANH</h3>
                        @else
                            @if($list_product->quantity == 0)
                                <h3 style="float: left;">Số Lượng: </h3>
                                <span style="vertical-align: middle;">
                                    <img width="120px" src="../img/Sold/sold-out-220x220.png">
                                </span>
                            @else
                                <h3 style="float: left;">Số Lượng: </h3>
                                <input style="vertical-align: middle;" type="number" name="soluong" min="1" max="{{$list_product->quantity}}" value="1" required>
                                <span id="soluong-error" style="color: red;"></span>
                                <br>
                                <input class="DH" style="margin-top:50px;padding: 20px; border-radius: 15px; cursor: pointer;" type="submit" name="addcart" value="Thêm vào giỏ hàng">
                            @endif
                        @endif
					</form>
				</div>
			</div>
		</div>
	</div>
	@include('layout.footer')
	</div>

  <!---Start TaggoAI--->
  <div data-taggo-botid="66fd5f908acf28e82b54d310"></div>
  <script async src="https://widget.taggo.chat/app.js"></script>
  <!---End TaggoAI--->
  
  
</body>
<script>
    const soluongInput = document.querySelector('input[name="soluong"]');
    const soluongError = document.querySelector('#soluong-error');
    soluongInput.addEventListener('input', function() {
        const soluongValue = parseInt(soluongInput.value);
        const maxQuantity = parseInt(soluongInput.getAttribute('max'));
        if (soluongValue > maxQuantity) {
            soluongError.textContent = 'Số lượng còn lại tối đa của của hàng là ' + maxQuantity+', vui lòng kiểm tra lại !';
        } 
		else if(soluongValue<=0){
			soluongError.textContent = 'Số lượng tối thiểu phải lớn hơn hoặc bằng 1, vui lòng kiểm tra lại !';
		}
		else {
            soluongError.textContent = '';
        }
    });
</script>

</html>