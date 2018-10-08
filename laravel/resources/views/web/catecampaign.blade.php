@extends('web.master')
@section('title','KULEGA')
@section('content')

@push('css')
<link rel="stylesheet" href="{{ asset('template/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/css/star-rating.css') }}">
<link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/kulega.css') }}">
<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">

<style media="screen">
    .banner{
        width: 100%;
        display: table;
        text-align: center;
        background-position:bottom 0px left 0px !important;
    }

    .wrap-outer{
        display: table-cell;
        vertical-align: middle;
    }

    .wrap-outer h1{
        font-family: 'Pacifico', cursive;
        color: #D19E9A;
        font-style: italic;
        font-size: 70px;
    }

    .wrap-outer span{
        color: #727172;
        font-style: italic;
        font-size: 25px;
        letter-spacing: 2px;
    }

    .btn-link, .pagination > li > a, .pagination > li > span, .pagination > li > a:hover, .pagination > li > span:hover, .pagination > li > a:focus, .pagination > li > span:focus {
        color: #000 !important;
    }

    .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
        color: #FFF !important;
        background-color: #000 !important;
        border-color: #000 !important;
    }

    @media(max-width:767px){
        .banner{
            background-position:bottom 0px left -250px !important;
        }
    }

    .product{
        width: 100% !important;
    }

    .product-title h4 a{
        color:#D19E9A;
    }

    .product-title h5 a{
        color:#000;
    }

    .product-title h4 a:hover{
        color: #000;
    }

    .product-price ins {
        color: #000;
    }

    .add-to-cart{
        width:100%;
        margin-top:3px !important;
        background-color:#000;
        border-radius:5px;
    }

    .panel-default{
        border-radius: 0px !important;
        border: transparent !important;
        -webkit-box-shadow: 0 0px 0px rgba(0,0,0,0) !important;
        box-shadow: 0 0px 0px rgba(0,0,0,0) !important;
        border-bottom: 1px solid #dedfde !important;
        padding: 10px 0px !important;
    }

    .panel-default>.panel-heading {
        color: #333;
        background-color: #fff;
        border-color: #e4e5e7;
        padding: 0;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .panel-default>.panel-heading a {
        display: block;
        padding: 10px 0px;
    }

    .panel-default>.panel-heading a:after {
        content: "";
        position: relative;
        top: 1px;
        display: inline-block;
        font-family: 'Glyphicons Halflings';
        font-style: normal;
        font-weight: 400;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        float: right;
        transition: transform .25s linear;
        -webkit-transition: -webkit-transform .25s linear;
    }

    .panel-default>.panel-heading a[aria-expanded="true"] {
        background-color: #fff;
    }

    .panel-default>.panel-heading a[aria-expanded="true"]:after {
        content: "\2212";
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
    }

    .panel-default>.panel-heading a[aria-expanded="false"]:after {
        content: "\002b";
        -webkit-transform: rotate(90deg);
        transform: rotate(90deg);
    }

    .accordion-option {
        width: 100%;
        float: left;
        clear: both;
        margin: 15px 0;
    }

    .accordion-option .title {
        font-size: 20px;
        font-weight: bold;
        float: left;
        padding: 0;
        margin: 0;
    }

    .accordion-option .toggle-accordion {
        float: right;
        font-size: 16px;
        color: #6a6c6f;
    }

    .accordion-option .toggle-accordion:before {
        content: "Expand All";
    }

    .accordion-option .toggle-accordion.active:before {
        content: "Collapse All";
    }

    #stock-notif{
        margin-top:42px;
        padding-left:0px;
        padding-right:0px;
        text-align: center;
    }

    .alert-danger{
        padding-top:8px;
        padding-bottom: 8px;
        border-radius: 0;
    }

    @media(max-width:991px){
        #stock-notif{
            margin-top: 85px;
        }

        .add-to-cart{
            margin-top: 0px !important;
        }
    }

    .banner{
        min-height: 300px;
    }

    .section-title .col-sm-3{
        text-align: right;
    }

    .product-image img{
        height:350px;
        object-fit:scale-down;
    }

    @media(max-width:425px){
        #banner-text{
            font-size: 30px;
        }

        .banner{
            min-height: 150px;
        }

        .section-title .col-sm-3{
            text-align: right;
        }

        #main-products h3{
            text-align: center;
        }

        .product-image img{
            height:180px;
        }

        #main-products .col-xs-6{
            margin-bottom: 40px;
        }
    }

</style>

@endpush

<!-- BEGIN BANNER -->
@foreach($banners as $banner)
<section class="banner" style="background:url('{{ asset($banner->image) }}');">
    <div class="wrap-outer">
        <h1 id="banner-text">
            <?= ucwords(str_replace('-',' ',$category)); ?>
        </h1>
        <!-- <span>#iamaddicted{{ $category }}</span> -->
    </div>
</section>
@endforeach
<!-- END BANNER -->


<!-- BEGIN PRODUCTS -->
<section id="main-products" style="background-color: #efefef;">
  <div class="container">
    <div class="row section-title text-center">
    <div class="col-md-12">
      <div class="col-xs-6 col-md-6" style="text-align:left;margin-bottom:20px;">
        <h3 style="margin-bottom:0px;"><?= ucwords(str_replace('-',' ',$category)); ?></h3>
        <!-- <p>#iamaddicted{{ $category }}</p> -->
      </div>
      <div class="col-xs-6 col-md-6">
          <div class="col-sm-3 col-md-3" style="margin-bottom:10px;float: right;">
            Views:
            <select class="" name="view_item" style="width: 120px;height: 40px;padding-left: 10px;" onchange="changeview()">
                <option value="20" <?php if($view == 20){echo "selected";} ?>>20</option>
                @if($countall >= 20 && $countall <= 40)
                    <option value="40" <?php if($view == 40){echo "selected";} ?>>40</option>
                @endif
                @if($countall >= 40 && $countall <= 60)
                    <option value="60" <?php if($view == 60){echo "selected";} ?>>60</option>
                @endif
                @if($countall >= 60 && $countall <= 80)
                    <option value="80" <?php if($view == 80){echo "selected";} ?>>80</option>
                @endif
                @if($countall >= 80 && $countall <= 100)
                    <option value="100" <?php if($view == 100){echo "selected";} ?>>100</option>
                @endif
                <option value="all" <?php if($view == 'all'){echo "selected";} ?>>View All</option>
            </select>
          </div>
          <div class="col-sm-3 col-md-3" style="margin-bottom:10px;float: right;">
            Sort By:
            <select class="" name="" style="width: 120px;height: 40px;padding-left: 10px;float: right;">
                <option value="">DEFAULT</option>
            </select>
          </div>
      </div>
    </div>
    </div>
    <div class="row section-content">
    <div class="col-md-12 col-sm-6">

    <div class="col-md-3 sidebar hidden-xs hidden-sm" style="margin-right:20px;">
        <div class="campaignCausesFilter">
            <h3>Categories</h3>
            <div class="browse-categories">
                <ul id="filterCatDesk" class="cat-list">
                    @foreach($listcategory as $list)
                    <li class="cat-list-item">
                        <a data-category="health" href="{{ url('/campaign/'.$list->kateg_url.'/') }}">
                            <span class="pull-left icon-education icons-browse">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" width="15px" height="15px" viewBox="0 0 501.164 501.164" style="enable-background:new 0 0 306 306;" xml:space="preserve" y="10px">
                                <g>
                                    <g id="chevron-right">
                                        <polygon points="94.35,0 58.65,35.7 175.95,153 58.65,270.3 94.35,306 247.35,153   "/>
                                    </g>
                                </g>
                                </svg>
                            </span>
                            {{ $list->kateg_name }}
                        </a>
                    </li>
                    @endforeach   
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-9">

        <script type="text/javascript">
            function changeview(){
                var view = $('[name=view_item]').val();
                location.href = "{{ url('/products') }}?category={{ $category }}&view="+view;
            }
        </script>

      @foreach($products as $campaign)
      <div class="col-xs-12 col-sm-6 col-md-4">
          <div class="col-md-12 kulega" style="padding: 0px !important; margin-bottom: 20px; background-color: #fff;" onclick="window.location.href='{{ url('/campaign/'.$campaign->kateg_url.'/'.$campaign->url) }}'">
            <div class="widget-container home_trending" style="background-color: #fff;">
              <div class="image">
                <img src="{{ url($campaign->image) }}" class="img-responsive">
              </div>
              <p class="small-badge">
                <span id="campaignCause" class="label label-large label-color arrowed-right cat-tag cat-personal">{{ $campaign->kateg_name }}</span>
              </p>
              <div class="widget-details">
                <div class="widget-mid">
                  <h5 id="campaignTitle"><a href="{{ url('/campaign/'.$campaign->kateg_url.'/'.$campaign->url) }}" tabindex="0">{{ $campaign->name }}</a></h5>

                  <div id="campaignBlurb" class="campaign-desc"><?php echo $campaign->desc; ?></div>

                  <div class="widget-footter">
                      <div class="amt-raised clearfix">
                          <span class="pull-left"><span style="font-size: 18px;font-weight: bold;">Rp</span> <span class="campaignAmountRaised"><?php echo number_format($campaign->target, 2); ?></span></span>
                      </div><!-- .amt-raised -->

                      <div class="progress ">
                          <div id="campaignProgressRaised" class="progress-bar" style="width:<?php echo round((0/$campaign->target)*100); ?>%"></div>
                      </div><!-- .progress -->
                      <div class="footer-digits clearfix">
                          <span id="campaignPercentRaised" class="pull-left "><?php echo round((0/$campaign->target)*100); ?>%</span>
                          <span id="campaignEndDate" class="pull-right ">52 days left</span>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      @endforeach

    </div>

    </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="text-align:center;text-align: center;color: #969696;font-size: 16px;margin-top: 30px;">
            @if($view < $countall)
                {{ $view }} of {{ $countall }} Total
            @else
                {{ $countall }} of {{ $countall }} Total
            @endif
        </div>

        @if($view < $countall)
            <div class="col-md-12" style="text-align:center;margin-top:20px;">
                <a href="{{ url('/products') }}?category={{ $category }}&view=<?php echo $view+20; ?>" class="btn btn-primary" style="border-radius: 0;background-color: #000;">View More</a>
            </div>
        @endif
    </div>

  </div>
</section>
<!-- ./END PRODUCTS -->

<!-- MODAL DETAIL PRODUCT -->
<div class="modal fade" id="detailprod" role="dialog">
    <div class="modal-dialog modal-lg" style="background-color:#fff;">

      <!-- Modal content-->
      <div class="modal-content" style="border-radius:0px;background:url({{ asset('assets/bg-product.png') }});background-repeat:no-repeat;">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!-- <h4 class="modal-title">Modal Header</h4> -->
        </div>
        <div class="modal-body" id="prodcontent">

        </div>
      </div>

    </div>
</div>

<!-- MODAL ADD TO CART -->
<div class="modal fade" id="myModal" role="dialog" style="z-index:99999999999;">
  <div class="modal-dialog" style="background-color:#fff;">

    <!-- Modal content-->
    <div class="modal-content" style="border-radius:0px;background:url({{ asset('assets/bg-brush.png') }});background-repeat:no-repeat;">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
            <img src="{{ asset('assets/cart-success.png') }}" alt="Success Add Cart" class="img-responsive" style="margin:auto;height:100px;">
        </h4>
      </div>
      <div class="modal-body" style="padding:15px 50px;" id="successadd">

      </div>
      <div class="modal-footer" style="border-top:none;text-align:center;">
          <a href="{{ url('products/?category=') }}all&view=20" class="btn btn-default" style="border-radius:5px;padding:10px 30px;background-color:#000;border-color:#000;">Shop More</a>
          @if(Session::has('memberid'))
              <a href="{{ url('cart') }}" class="btn btn-default" style="border-radius:5px;padding:10px 30px;">Checkout</a>
          @else
              <a href="{{ url('user/login') }}?redirect={{ url('/cart') }}" class="btn btn-default" style="border-radius:5px;padding:10px 30px;">Checkout</a>
          @endif
      </div>
    </div>

  </div>
</div>


@push('js')

<script type="text/javascript" src="{{ asset('template/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/js/star-rating.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('templates/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/themes/krajee-svg/theme.min.js') }}"></script> -->
<script type="text/javascript">
$(".rating").rating().unbind();
</script>

<script type="text/javascript">
    function getproddetail(idprod){
        var datapost = {
            '_token' : '{{ csrf_token() }}',
            'idprod' : idprod
        }

        $.ajax({
            type : 'POST',
            url: "{{ url('ajax/getproduct') }}",
            data: datapost,
            beforeSend:function(){

            },
            success:function(data){
                $('#detailprod').modal('show');
                $('#prodcontent').html(data);
            }
        })

    }
</script>

<script type="text/javascript">
    function getquantity(trigger){
        var val_now = $('[name=quantity]').val();
        if (trigger == 'minus') {
            if (val_now == 1) { }else{
                var count = parseInt(val_now) - 1;
                $('[name=quantity]').val(count);
            }
        }else {
            var count = parseInt(val_now) + 1;
            $('[name=quantity]').val(count);
        }
    }
</script>

<script type="text/javascript">
    localStorage.removeItem('jsvouchervalue');
    localStorage.removeItem('jsvouchertype');
</script>

@endpush

@endsection
