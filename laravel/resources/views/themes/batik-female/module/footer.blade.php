<style media="screen">
    #footer{
        color: #bbbbbb;
    }

    #footer li a{
        color:#bbbbbb;
    }

    .input-subs{
        border-top: none;
        border-right: none;
        border-left: none;
        background-color: transparent;
    }

    .btn-subs{
        float:right;
        margin-right:0px;
        margin-top:10px;
        font-size:12px;
    }
</style>

<!-- Footer
============================================= -->
<footer id="footer" class="nobg" style="background-color:#343333 !important;border-top:transparent;">
    <?php $website = DB::table('cms_config')->first(); ?>
    <div class="container clearfix">

        <!-- Footer Widgets
        ============================================= -->
        <div class="footer-widgets-wrap clearfix"  style="padding: 100px 0 100px;">

            <div class="col-md-4">
                <img src="{{ asset($website->logo) }}" class="img-responsive" alt="{{ $website->site_name }}" style="margin:auto;">
            </div>

            @if($website->type == 'ecommerce')
            <div class="col-md-2">
                <strong><?= strtoupper('order') ?></strong>
                <ul style="list-style:none;margin-top:20px;">
                    <li><a href="{{ url('check/order') }}">Check Order</a></li>
                    <li><a href="{{ url('user/order/payment-confirmation/confirm') }}">Confirm Payment</a></li>
                    <li><a href="{{ url('products') }}">Shop</a></li>
                </ul>
            </div>
            @endif

            <?php $footer = DB::table('cms_menu')->where('type','Footer')->where('parent',0)->orderBy('order_row','ASC')->get(); ?>
            @foreach($footer as $foot)
            <div class="col-md-2">
                <strong><?= strtoupper($foot->menu) ?></strong>
                <ul style="list-style:none;margin-top:20px;">
                    <?php $subfooter = DB::table('cms_menu')->where('type','Footer')->where('parent',$foot->menu_id)->orderBy('order_row','ASC')->get(); ?>
                    @foreach($subfooter as $sub)
                        <li><a href="{{ url($sub->url) }}">{{ $sub->menu }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach

            <div class="col-md-2">
                <div class="widget widget_links clearfix">
                    <strong>FOLLOW US</strong>

                    <div class="bottommargin-sm clearfix" style="margin-top:20px;">
                        <?php $sosmed = DB::table('cms_socialmedia')->get(); ?>

                        @foreach($sosmed as $sos)
                        <a href="{{ url($sos->url) }}" class="social-icon si-dark si-mini si-{{ $sos->name }}" title="{{ $sos->name }}">
                            <i class="{{ $sos->icon }}"></i>
                            <i class="{{ $sos->icon }}"></i>
                        </a>
                        @endforeach

                    </div>
                </div>

                <!-- <strong>NEWSLETTER</strong>
                <form class="" action="{{ url('subscriberstore') }}" method="post" style="margin-top:20px;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="email" name="news" placeholder="Enter your Email" class="form-control input-subs">
                    <button class="button button-black button-dark btn-subs" type="submit">Submit</button>
                </form> -->
            </div>

        </div><!-- .footer-widgets-wrap end -->

    </div>

    <div class="col-md-12" style="background-color:#99784a;text-align:center;color:#fff;padding-top:10px;padding-bottom:10px;font-size:11px;">
        COPYRIGHT &copy {{ $website->site_name }} <?= date('Y'); ?>, ALL RIGHTS RESERVED
    </div>

</footer><!-- #footer end -->
