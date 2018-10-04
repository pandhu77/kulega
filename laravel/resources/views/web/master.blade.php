<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('template/web/plugins/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/web/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/web/fonts/ionicons-2.0.1/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/web/css/helper.css') }}">
    <link rel="stylesheet" href="{{ asset('template/web/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('template/web/css/master.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert.css') }}">

    <link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/dark.css') }}">
    <link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/font-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/fonts/font-icons.ttf') }}">
    <link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/fonts/font-icons.woff') }}">

    <style media="screen">
        .loading{
            width: 100%;
            height: 100vh;
            background-color: #000;
            position: fixed;
            z-index: 99;
        }

        .navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:focus, .navbar-default .navbar-nav>.open>a:hover{
            background-color: #D19E9A;
        }

        .dropdown-menu{
            border-radius: 0px;
            background-color: #fff;
        }

        @media(max-width:767px){
            .top-menu{
                display: none !important;
            }
        }

        @media(max-width:991px){
            .navbar-default .container{
                width: 100% !important;
            }
        }
    </style>

    @stack('css')
  </head>
  <body>

      <div class="loading">

      </div>

	  <?php $site = DB::table('cms_config')->first(); ?>

    <header id="header" class="full-header">

			<div id="header-wrap">

				<div class="container clearfix">

					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

					<!-- Logo
					============================================= -->
					<div id="logo" style="border-right:none;">
						<a href="{{ url('/') }}" class="standard-logo" data-dark-logo="{{ asset($site->logo) }}">
							<img src="{{ asset($site->logo) }}" alt="{{ $site->site_name }}">
						</a>
						<a href="{{ url('/') }}" class="retina-logo" data-dark-logo="{{ asset($site->logo) }}">
							<img src="{{ asset($site->logo) }}" alt="{{ $site->site_name }}">
						</a>
					</div><!-- #logo end -->

					<!-- Primary Navigation
					============================================= -->
					<nav id="primary-menu">

						<ul style="border-right:none;">
							<li><a href="{{ url('/') }}"><div>Home</div></a></li>
							<li><a href="{{ url('/about') }}"><div>About</div></a></li>
							<li><a href="{{ url('/products') }}"><div>Products</div></a></li>
              <li><a href="{{ url('/gallery') }}"><div>Lookbook</div></a></li>
							@if(Session::has('memberid'))
								<!-- <li><a href="{{ url('user/order/payment-confirmation/1') }}"><div>Confirm Payment</div></a></li> -->
                <li><a href="{{ url('user/login') }}"><div>Halo, {{ Session::get('membername') }}</div></a></li>
              @else
								<!-- <li><a href="{{ url('user/login') }}?redirect={{ url('user/order/payment-confirmation/1') }}"><div>Confirm Payment</div></a></li> -->
                <li><a href="{{ url('user/login') }}"><div>Sign In</div></a></li>
              @endif
						</ul>

						<!-- Top Cart
						============================================= -->
						<div id="top-cart">
							@if(Session::has('memberid'))
								<a href="{{ url('/cart') }}" id="top-cart-trigger"><i class="icon-shopping-cart"></i><span class="cart-count"><?= Cart::count(); ?></span></a>
							@else
								<a href="{{ url('user/login') }}?redirect={{ url('/cart') }}" id="top-cart-trigger"><i class="icon-shopping-cart"></i><span class="cart-count"><?= Cart::count(); ?></span></a>
							@endif
							<div class="top-cart-content">
								<div class="top-cart-title">
									<h4>Shopping Cart</h4>
								</div>
								<div class="top-cart-items">
									<?php
											$carts = Cart::content();
											$totalcart = 0;
									?>

									@foreach($carts as $cart)
									<div class="top-cart-item clearfix">
										<div class="top-cart-item-image">
											<a href="{{ url('products/'.$cart->options['url']) }}"><img src="{{ asset($cart->options['image']) }}" alt="{{ $cart->name }}" /></a>
										</div>
										<div class="top-cart-item-desc">
											<a href="{{ url('products/'.$cart->options['url']) }}">{{ $cart->name }}</a>
											<span class="top-cart-item-price"><?= number_format($cart->price,0,',','.'); ?></span>
											<span class="top-cart-item-quantity">x {{ $cart->qty }}</span>
										</div>
									</div>
                  <?php $totalcart = $totalcart + ($cart->price*$cart->qty); ?>
									@endforeach

								</div>
								<div class="top-cart-action clearfix">
									<span class="fleft top-checkout-price"><?php if(!empty($totalcart)){echo number_format($totalcart,0,',','.');}else{echo "0";} ?></span>
									<a href="{{ url('cart') }}" class="button button-3d button-small nomargin fright">View Cart</a>
								</div>
							</div>
						</div><!-- #top-cart end -->

						<!-- Top Search
						============================================= -->
						<div id="top-search">
							<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
							<form action="{{ url('products') }}" method="get">
								<input type="text" name="search" class="form-control" value="" placeholder="Search...">
							</form>
						</div><!-- #top-search end -->

					</nav><!-- #primary-menu end -->

				</div>

			</div>

		</header><!-- #header end -->

    <main>
      @yield('content')
    </main>

    <style media="screen">
        footer li a:focus{
            color: #fff;
        }
    </style>

    <footer style="background-color:#f6f6f6;">
      <div class="container">
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-3">

            <a href="{{ url('/') }}">
              <img src="{{ asset($site->logo) }}" alt="{{ $site->site_name }}">
            </a>

            <?php $socialmedia = DB::table('cms_socialmedia')->where('enable',1)->get(); ?>
            <ul class="social-media">
                @foreach($socialmedia as $sosmed)
                    <li style="border: 2px solid #f6f6f6;">
                      <a href="{{ $sosmed->url }}" style="color:#000;"><i class="{{ $sosmed->icon }}"></i>
                      </a>
                    </li>
                @endforeach
            </ul>

          </div>
          <div class="col-xs-6 col-sm-6 col-md-3">
            <h3> Company Info </h3>
            <ul>
                <li> <a href="{{ url('/about') }}"> About Us </a> </li>
                <li> <a href="{{ url('/contact') }}"> Contact Us </a> </li>
                <!-- <li> <a href="{{ url('check/order') }}"> Check Order </a> </li> -->
                <!-- <li> <a href="{{ url('/magazine') }}"> Magazine </a> </li> -->
            </ul>
          </div> <!-- ./col -->
          <div class="col-xs-6 col-sm-6 col-md-3">
            <h3> Our Products </h3>

            <?php $footercate = DB::table('lk_product_category')->where('kateg_enable',1)->get(); ?>

            <ul>
                @foreach($footercate as $foot)
                    <li> <a href="{{ url('/products?category='.$foot->kateg_url) }}"> {{ $foot->kateg_name }} </a> </li>
                @endforeach
            </ul>
          </div> <!-- ./col -->
          <div class="col-xs-6 col-sm-6 col-md-3">
            <h3> CUSTOMER CARE </h3>

            <?php $menu = DB::table('cms_menu')->where('enable',1)->where('type','Footer')->orderBy('order_row','ASC')->get(); ?>

            <ul>
                @foreach($menu as $men)
                    <li> <a href="{{ url($men->url) }}"> {{ $men->menu }} </a> </li>
                @endforeach
                @if(Session::has('memberid'))
  								<li><a href="{{ url('user/order/payment-confirmation/1') }}"><div>Confirm Payment</div></a></li>
                @else
  								<li><a href="{{ url('user/login') }}?redirect={{ url('user/order/payment-confirmation/1') }}"><div>Confirm Payment</div></a></li>
                @endif
            </ul>
          </div> <!-- ./col -->
          <!-- <div class="col-xs-12 col-sm-6 col-md-6">
            <h3> SUBSCRIBE NOW </h3>
            <form class="form-inline" action="{{ url('/doSubscribe') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group ">
                <input type="email" class="form-control" placeholder="your email..." name="email" value="{{ old('email') }}">
              </div>
              <button type="submit" class="btn btn-default">Send</button>
            </form>

            <p class="copyright"> © 2017 I am Addicted | Right Reserved</p>
          </div> <!-- ./col -->
        </div> <!-- ./  row -->
      </div> <!--/. container -->
    </footer>


    <script type="text/javascript" src="{{ asset('template/web/plugins/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template/web/plugins/bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template/web/js/master.js') }}"></script>

    <script type="text/javascript" src="{{ asset('laravel/resources/views/themes/batik-female/js/plugins.js') }}"></script>
    <script type="text/javascript" src="{{ asset('laravel/resources/views/themes/batik-female/js/functions.js') }}"></script>
    <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>

    <script type="text/javascript">
        $(window).on('load',function(){
            $('.loading').fadeOut('slow');
        });
    </script>

    <script type="text/javascript">
        function opendropdown(id,dropan){
            if ($('#'+dropan+id).hasClass('open')) {
                $('#'+dropan+id).removeClass('open');
            } else {
                $('#'+dropan+id).addClass('open');
            }
        }
    </script>

    @stack('js')
  </body>
</html>
