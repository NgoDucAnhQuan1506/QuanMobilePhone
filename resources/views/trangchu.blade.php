<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Trang chủ</title>
</head>

<body>
<div class="container">
    <div class="container1">
                <div class="logo">
                    <a href="/">
                        <img src="../img/logo-removebg.png">
                    </a>
                </div>
                <div class="search-header" style="position: relative; left: 162px; top: 1px;">
                <form class="input-search" method="GET" action="{{ route('search.user') }}">
                    <div class="autocomplete">
                        <input id="search-box" name="search" autocomplete="off" type="text" placeholder="Nhập từ khóa tìm kiếm..." value="{{ request()->input('search') }}">
                        <button type="submit">
                            <i class="fa fa-search"></i>
                            Tìm kiếm
                        </button>
                        <ul id="product-list" style="display: none; position: absolute; top: 100%; left: 0; background: white; width: 100%; z-index: 1000; border: 1px solid #ccc; max-height: 200px; overflow-y: auto;">
                            <!-- Danh sách sản phẩm sẽ được thêm vào đây bằng JavaScript -->
                        </ul>
                    </div>
                </form>
                <div class="tags">
                    <strong>Từ khóa: </strong>
                    <a href="{{ url('/') }}?search=iPhone 15 Pro Max">iPhone 15 Pro Max</a> <a href="{{ url('/') }}?search=Samsung">Samsung</a><a href="{{ url('/') }}?search=iPhone">iPhone</a><a href="{{ url('/') }}?search=Oppo">Oppo</a><a href="{{ url('/') }}?search=Xiaomi">Xiaomi</a></div>
                </div>
                <div class="user">
                    <div class="logouser">
                        <a href="{{ route('userInfo') }}" class="full-link"> <!-- Thay đổi đường dẫn đến trang thông tin người dùng -->
                            <img src="../img/login/user.png" alt="User Icon">
                        </a>
                    </div>
                    @if (Auth::guard('acuser')->check())
                        <div class="login">
                            Xin chào, {{ Auth::guard('acuser')->user()->us_name }}
                            <a href="{{ route('logoutUser') }}">Đăng xuất</a>
                        </div>
                    @else
                        <div class="login">
                            <a href="{{ route('formLoginUser') }}">Đăng nhập</a>
                            <br>
                            <a href="{{ route('formSignupUser') }}">Đăng ký</a>
                        </div>
                    @endif
                </div>

            </div>
            <div class="containerMenu">
            <div class="Menu">
                    <ul>
                        <li><a href="/" title="Trang chủ"><img style="width: 20px; margin-right: 5px;" src="../img/icon_menu/home_icon.png">Trang chủ</a></li>
                        <li><a href="#" title="Sản phẩm"><img style="width: 20px; margin-right: 5px;" src="../img/icon_menu/dtdd_micon.png">Điện thoại</a>
                            <div class="Menu_sp">
                                <ul>
                                <strong><h4 style="padding-top: 20px;padding-left: 20px;">HÃNG SẢN XUẤT</h4></strong>
                                    @foreach ($list_brands as $brand )
                                    <li><a href="/show?hangsanxuat={{$brand->brand_id}}" title="{{$brand->brand_name}}">{{$brand->brand_name}}</a></li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}" title="Giỏ hàng">
                                <img style="width: 20px; margin-right: 5px;" src="../img/icon_menu/giohang_icon.png">
                                Cart
                                @php
                                    $cart = session('cart', []);
                                    $cartCount = array_sum(array_column($cart, 'quantity'));
                                @endphp

                                @if($cartCount > 0)
                                    <span class="cart-count">({{ $cartCount }})</span>
                                @else
                                    <span class="cart-count">(0)</span>
                                @endif
                            </a>
                        </li>
                        <li><a href="#" title="Giới thiệu"><img style="width: 20px; margin-right: 5px;" src="../img/icon_menu/gioithiu_icon.png">Giới thiệu</a></li>
                    </ul>
            </div>
    </div>
    <div class="full-hd">
        <div class="content">
            <div class="Banner">
                <div class="full">
                    <img src="img/banner/banner_new.png">
                </div>
            </div>

            <!-- Hiển thị tiêu đề cho kết quả tìm kiếm hoặc hãng sản xuất -->
            @if(request()->input('search'))
                <h2 style="color: brown;">Kết quả tìm kiếm cho: "{{ request()->input('search') }}"</h2>
            @elseif(request()->input('hangsanxuat'))
                @php
                    $brand = $list_brands->where('brand_id', request()->input('hangsanxuat'))->first();
                @endphp
                <h2 style="color: brown;">Sản phẩm của hãng: {{ $brand->brand_name }}</h2>
            @else
                <h2 style="color: brown;">SẢN PHẨM MỚI NHẤT</h2>
            @endif

            <div class="content-sp">
                @if($list_product->isEmpty())
                    <p style="color: red; font-weight: bold;">Không tìm thấy sản phẩm nào phù hợp.</p>
                @else
                @foreach ($list_product as $product)
                    <div class="sp-item">
                        <img style="width: 100px;" src="{{ asset('img/sanpham/' . $product->image) }}">
                        <h3><a href="/showsanpham?key={{$product->prd_id}}">{{$product->prd_name}}</a></h3>
                        <p class="price">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                        
                        @if($product->is_active == 0)
                            <button class="inactive-button" disabled>
                                <i class="fas fa-ban"></i> Ngừng kinh doanh
                            </button>
                        @else
                        <button type="button" class="add-to-cart-button" data-product-id="{{ $product->prd_id }}">
                            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
                        </button>
                        @endif
                    </div>
                @endforeach
                @endif
            </div>
            <div class="clear"></div>
        </div>     


  <!---Start TaggoAI--->
  <div data-taggo-botid="66fd5f908acf28e82b54d310"></div>
  <script async src="https://widget.taggo.chat/app.js"></script>
  <!---End TaggoAI--->
  
    </div>
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
</body>
<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        // Select all buttons with the class 'add-to-cart-button'
        const addToCartButtons = document.querySelectorAll('.add-to-cart-button');

        // Add click event listener to each button
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get the product ID from the data attribute
                const productId = this.getAttribute('data-product-id');
                addToCart(productId);
            });
        });
    });

    function addToCart(productId) {
        // Create the AJAX request
        fetch(`/addToCart2?key=${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: productId, soluong: 1 })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count without reloading the page
                document.querySelector('.cart-count').textContent = `(${data.cart_count})`;
                alert('Sản phẩm đã được thêm vào giỏ hàng!');
            } else {
                alert('Có lỗi xảy ra, vui lòng thử lại sau.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search-box').on('keyup', function() {
            let query = $(this).val();
            if (query.length > 1) {
                $.ajax({
                    url: "{{ route('ajax.search') }}",  // route được Laravel cung cấp
                    type: "GET",
                    data: { search: query },
                    success: function(data) {
                        $('#product-list').empty(); // Xóa các kết quả cũ
                        if (data.length > 0) {
                            data.forEach(product => {
                                // Định dạng giá tiền
                                let formattedPrice = new Intl.NumberFormat('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND',
                                    minimumFractionDigits: 0
                                }).format(product.price);
                                $('#product-list').append(`
                                    <li class="product-item">
                                        <a href="showsanpham?key=${product.prd_id}" class="product-link">
                                            <img src="img/sanpham/${product.image}" class="product-img">
                                            <div class="product-info">
                                                <span class="product-name">${product.prd_name}</span>
                                                <span class="product-price">${formattedPrice}</span>
                                            </div>
                                        </a>
                                    </li>
                                `);
                            });
                            $('#product-list').show(); // Hiển thị danh sách gợi ý
                        } else {
                            $('#product-list').hide(); // Ẩn danh sách nếu không có kết quả
                        }
                    },
                        error: function(xhr, status, error) {
                        console.error("Lỗi tìm kiếm:", error); // Bắt lỗi nếu có
                    }
                });
            } else {
                $('#product-list').hide();
            }
        });

        // Ẩn danh sách khi nhấp ra ngoài
        $(document).click(function(e) {
            if (!$(e.target).closest('#search-box').length) {
                $('#product-list').hide();
            }
        });
    });
</script>


</html>
