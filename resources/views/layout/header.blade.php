<div class="container1">
			<div class="logo">
				<a href="/">
					<img src="../img/logo-removebg.png">
				</a>
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
