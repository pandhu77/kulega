<style media="screen">
    #header{
        position: fixed;
        z-index: 100;
        width: 100%;
        background-color: #fff;
        border-bottom: transparent;
    }

    #primary-menu ul li:hover a{
        color: #d8ab6c !important;
    }

    #primary-menu ul li a{
        color: #000;
    }

    .standard-logo img{
        -webkit-transition: all 200ms ease-in-out !important;
        -moz-transition: all 200ms ease-in-out !important;
        -ms-transition: all 200ms ease-in-out !important;
        -o-transition: all 200ms ease-in-out !important;
        transition: all 200ms ease-in-out !important;
    }

    #sf-js-enabled > li > a{
        -webkit-transition: all 200ms ease-in-out !important;
        -moz-transition: all 200ms ease-in-out !important;
        -ms-transition: all 200ms ease-in-out !important;
        -o-transition: all 200ms ease-in-out !important;
        transition: all 200ms ease-in-out !important;
    }

    .header-menu{
        -webkit-transition: all 200ms ease-in-out !important;
        -moz-transition: all 200ms ease-in-out !important;
        -ms-transition: all 200ms ease-in-out !important;
        -o-transition: all 200ms ease-in-out !important;
        transition: all 200ms ease-in-out !important;
    }

    #logo{
        border-right: none !important;
        max-width: 200px;
        vertical-align: middle;
        height: 100px;
    }

    #logo a{
        height: 100%;
    }

    #logo a img{
        height: 100%;
        width: 100%;
        object-fit: scale-down;
    }

    .header-menu{
        border-left: none !important;
    }

    .header-menu a{
        color: #d8ab6c !important;
        font-size: 17px !important;
    }

    @media(max-width:768px){
        #logo{
            max-width: 100px;
        }
    }
</style>

<?php $site = DB::table('cms_config')->first(); ?>

<!-- Header
============================================= -->
<header id="header" class="full-header no-sticky clearfix">

    <div id="header-wrap">

        <div class="col-md-offset-1 col-md-10 clearfix">

            <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

            <!-- Logo
            ============================================= -->
            <div id="logo">
                <a href="{{ url('/') }}" class="standard-logo"><img src="{{ asset($site->logo) }}" alt="{{ $site->site_name }} Logo"></a>
                <a href="{{ url('/') }}" class="retina-logo"><img src="{{ asset($site->logo) }}" alt="{{ $site->site_name }} Logo"></a>
            </div><!-- #logo end -->

            <!-- Primary Navigation
            ============================================= -->
            <nav id="primary-menu" class="style-ecommerce">

                <ul>
                    <?php $main = DB::table('cms_menu')->where('enable',1)->where('type','Main')->where('parent',0)->orderBy('order_row','ASC')->get(); ?>
                    @foreach($main as $ma)
                        @if($ma->menu == 'Shop')
                            @if($site->type == 'ecommerce')
                                <li><a href="{{ url($ma->url) }}"><div>{{ $ma->menu }}</div></a></li>
                            @endif
                        @else
                            <li><a href="{{ url($ma->url) }}"><div>{{ $ma->menu }}</div></a></li>
                        @endif
                    @endforeach
                </ul>

                @if($site->type == 'ecommerce')
                <!-- Top Search
                ============================================= -->
                <div id="top-search" class="header-menu">
                    <a href="#" id="top-search-trigger"><i class="icon-line2-magnifier"></i><i class="icon-line-cross"></i></a>
                    <form action="{{ url('products') }}" method="get">
                        <input type="text" name="search" class="form-control" value="" placeholder="Type &amp; Hit Enter.." style="height:auto;">
                    </form>
                </div><!-- #top-search end -->

                <!-- Top Cart
                ============================================= -->
                <div id="top-cart" class="header-menu">
                    <a href="#" id="top-cart-trigger">
                        <i class="icon-line2-handbag"></i><span style="background-color:#d8ab6c;"><?= Cart::count(); ?></span>
                    </a>
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
                                    <a href="{{ url('products/'.$cart->options['url']) }}" class="t400">{{ $cart->name }}</a>
                                    <span class="top-cart-item-price"><?= number_format($cart->price,0,',','.'); ?></span>
                                    <span class="top-cart-item-quantity">x {{ $cart->qty }}</span>
                                </div>
                            </div>
                            <?php $totalcart = $totalcart + ($cart->price*$cart->qty); ?>
                            @endforeach

                        </div>
                        <div class="top-cart-action clearfix">
                            <span class="fleft top-checkout-price t600 font-secondary" style="color: #333;"><?php if(!empty($totalcart)){echo number_format($totalcart,0,',','.');}else{echo "0";} ?></span>
                            <a href="{{ url('cart') }}" class="button button-dark button-circle button-small nomargin fright" style="font-size:12px !important;color:#fff !important;background-color:#D8AB6C !important;">View Cart</a>
                        </div>
                    </div>
                </div><!-- #top-cart end -->

                <!-- Top Account
                ============================================= -->
                <div id="top-account" class="header-menu">
                    <?php if(Session::has('memberid')){ ?>
                        <a href="{{ url('user/login') }}"><i class="icon-user"></i></a>
                    <?php }else{ ?>
                        <a href="{{ url('user/login') }}"><i class="icon-line2-user"></i></a>
                    <?php } ?>
                </div><!-- #top-account end -->
                @endif

            </nav><!-- #primary-menu end -->

        </div>

    </div>

</header><!-- #header end -->

@push('js')

<script type="text/javascript">
    $( window ).scroll(function() {
        if($(window).width() >= 992){
            if ($(this).scrollTop() > 100) {
                // $('.standard-logo').find('img').css('width','150px');
                // $('.standard-logo').find('img').css('height','auto');
                $('#logo').css('height','64px');
                $('.header-menu').css('padding','12px 30px');
                $('.sf-js-enabled').find('a').css('margin','12px 15px');
                $('#header-wrap').css('height','auto');
                $('#header').css('height','auto');
                $('.top-cart-content').css('top','65px');
            } else {
                // $('.standard-logo').find('img').css('width','233px');
                // $('.standard-logo').find('img').css('height','100px');
                $('#logo').css('height','100px');
                $('.header-menu').css('padding','30px 30px');
                $('.sf-js-enabled').find('a').css('margin','30px 15px');
                $('#header-wrap').css('height','100px');
                $('#header').css('height','100px');
                $('.top-cart-content').css('top','100px');
            }
        }
    });
</script>

@endpush
