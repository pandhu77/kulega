@extends('web.master')
@section('title','KULEGA')
@section('content')

@push('css')
<link rel="stylesheet" href="{{ asset('template/web/plugins/OwlCarousel2-2.2.1/dist/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/web/plugins/OwlCarousel2-2.2.1/dist/assets/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset('laravel/resources/views/themes/batik-female/css/kulega.css') }}">
<link rel="stylesheet" href="{{ asset('template/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/css/star-rating.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('template/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/themes/krajee-svg/theme.css') }}"> -->

<style media="screen">
    .home-btn-shop{
        margin-left: 100px;
    }

    #main-slide-show .owl-theme .owl-nav [class*=owl-]:hover{
        background: transparent !important;
    }

    @media(max-width:1028px){
        .home-btn-shop{
            margin-left: 85px;
        }
    }

    @media(max-width:767px){
        .home-btn-shop{
            margin-top: 20px;
            margin-left: 60px;
        }
    }

    @media(max-width:425px){
        .home-btn-shop{
            font-size: 7px;
            margin-left: 45px;
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

    .campaign-profile img{
      width: 30px;
      height: 30px;
      border-radius: 50px;
      display: inline;
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

    .imgprod{
        height:350px;
        object-fit:scale-down;
    }

    @media(max-width:991px){
        #stock-notif{
            margin-top: 85px;
        }

        .add-to-cart{
            margin-top: 0px !important;
        }
    }

    @media(max-width:479px){
        .imgprod{
            height:200px;
        }
    }
</style>

@endpush
<!-- BEGIN MAIN SLIDE SHOW -->
<section id="main-slide-show" style="margin-top:0px;">
  <div class="owl-carousel owl-theme">

    @foreach($slider as $slide)
      <div class="item">
        <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}">
        <div class="caption">
          <!-- <div class="text">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
          </div> -->
          <!-- <a href="{{ url('products?category=brush-set&view=20') }}" class="btn btn-default home-btn-shop">SHOP NOW</a> -->
        </div>
      </div>
    @endforeach

  </div>
</section><!--./ END MAIN SLIDE SHOW -->

<section id="main-products" class="mainslick" style="padding-top:0px;padding-bottom: 0px;background-color: #f5f5f5">
  <div class="container">
    <div class="section-title text-center">
      <div class="col-md-12">
        <h3 style="margin: 0px;font-family:'Noto Sans';">Trending Now</h3>
        <p class="text-center" style="color: #777;font-size: 16px;font-family:'Noto Sans'; margin: 0px;">View the fundraisers that are most active right now</p>
      </div>
      <div style="clear: both;"></div>
    </div>
    <section class="regular slider">
      @foreach($campaign as $campaign)
      <div class="col-md-4 kulega" style="padding: 0px !important; margin-bottom: 20px; background-color: #fff;" onclick="window.location.href='{{ url('/campaign/'.$campaign->kateg_url.'/'.$campaign->url) }}'">
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

              <div class="campaign-profile">
                <img src="{{ url($campaign->image) }}" class="img-responsive">
                <span>by Creator</span>
              </div>

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
      @endforeach

    </section>

  </div>
</section>
<!-- BEGIN CATEGORY
    @foreach($slick as $slicks)

    @endforeach
END CATEGORY -->

<!-- BEGIN PRODUCTS -->
<section id="main-products" style="padding-top:0px;">
  <div class="container">
    <div class="row section-title text-center">
      <div class="col-md-12">
        <h3>Our New Products</h3>
      </div>
    </div>
    <div class="row section-content">

      @foreach($products as $product)
      <div class="col-xs-6 col-sm-4 col-md-3" style="margin-bottom:20px;">
          <div class="product clearfix">
              <div class="product-image">
                  <a href="{{ url('/products/'.$product->prod_url) }}?category=all">
                      <img src="{{ asset($product->front_image) }}" alt="{{ $product->prod_title }}" class="imgprod" style="height:340px;">
                  </a>
              </div>
              <div class="product-desc" style="text-align:center;padding-top:5px;">
                  <div class="product-title" style="margin-bottom:3px;">
                      <h4 style="width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:0px;">
                          <a href="{{ url('/products/'.$product->prod_url) }}?category=all">{{ $product->prod_title }}</a>
                      </h4>
                  </div>
                  <div class="product-price" style="font-weight:400;font-size:16px;">Rp <?php echo number_format($product->prod_price,0,',','.'); ?></div>
              </div>
          </div>
      </div>
      @endforeach

    </div>

    <div class="container" style="text-align:center;">
      <a href="{{ url('/products?category=all') }}" class="button button-small nomargin">View More</a>
    </div>

  </div>
</section>
<!-- ./END PRODUCTS -->


<!-- BEGIN BANNER -->
<style media="screen">
.banner-img{
    display: none;
}

@media(max-width:991px) {
    .banner-img{
        display: block;
    }

    .banner-bg{
        display: none;
    }
}
</style>

@foreach($banners as $banner)
<div class="banner-bg" style="display:none;">
    <section id="subscribe-form" style="background:url('{{ asset('assets/img/banners/banner2.jpg') }}'); background-position: center center;

        background-repeat: no-repeat;">
      <div class="container text-center">
        <div class="middle">
          <div class="inner">

              <!-- <div class="row">
                <div class="col-md-12">
                  <h4><strong>SUBSCRIBE</strong></h4>
                  <p class="mt-15 mb-25">Receive exclusive news and updates from us.</p>
                </div>
              </div>

              <form class="" action="{{ url('subscriberstore') }}" method="post">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">

              <div class="row">
                <div class="col-md-3 col-md-offset-1">
                  <div class="form-group">
                    <label class="sr-only" >First Name</label>
                    <input type="text" class="form-control" placeholder="First Name" name="first_name">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="sr-only" >Last Name</label>
                    <input type="text" class="form-control" placeholder="Last Name" name="last_name">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="sr-only" >Email address</label>
                    <input type="email" class="form-control" placeholder="Email address" name="email">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" name="button" class="btn btn-default">SUBSCRIBE</button>
                </div>
              </div>

            </form> -->

          </div>
        </div>
      </div>
    </section>
</div>

<div class="banner-img">
    <img src="{{ asset('assets/img/banners/banner2.jpg') }}" class="img-responsive">
</div>
@endforeach
<!-- ./END BANNER -->



<!-- BEGIN INSTAGRAM FEED -->
@if($instagram == 'gagal bray')

@else

<div class="container" style="margin-top:5%;margin-bottom:5%;">
    <h3 style="text-align:center;margin-bottom:20px;">#IAABABES</h3>

    <div class="col-md-offset-2 col-md-8">

        @foreach($instagram as $key => $insta)
            @if($key < 6 )
                <div class="col-xs-4" style="padding-left:5px;padding-right:5px;padding-bottom:10px;">
                    <a href="{{ $insta->link }}" target="_blank">
                        <div class="insta-bg" style="width:100%;background:url({{ $insta->images->low_resolution->url }});background-size:cover;background-position:center center;background-repeat:no-repeat;" >
                        </div>
                    </a>
                </div>
            @endif
        @endforeach

    </div>

    <style media="screen">
        .btn-insta{
            background-color:transparent;
            border-color:transparent;
            color:#000;
            font-weight:600;
            font-family: 'Lato', sans-serif !important;
            text-transform: uppercase;
            white-space: normal;
        }

        .btn-insta:hover{
            background-color: #D19E9A;
            color: #fff;
            border-color: #D19E9A;
        }
    </style>

    <div class="clearfix"></div>
    <div class="col-md-12" style="text-align:center;margin-top:20px;">
        <a href="http://instagram.com/{{ $instagram[0]->user->username }}" target="_blank" class="btn btn-primary btn-insta">
            <i class="fa fa-instagram"></i> TAG US FOR A CHANCE TO BE FEATURED <?php echo "@".$instagram[0]->user->username; ?>
        </a>
    </div>
</div>

@endif

<!-- ./END INSTAGRAM FEED  -->


<!-- BEGIN CONTACT INFOMATION -->
<!-- <section id="main-contact-information">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="form-inline">
          <div class="form-group">
            <label><i class="fa fa-map-marker"></i></label>
            <p class="form-control-static">Lorem Ipsum, 10
              Jakarta, Indonesia</p>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="form-inline">
          <div class="form-group">
            <label><i class="fa fa-envelope"></i></label>
            <p class="form-control-static">hello@iamaddicted.com</p>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="form-inline">
          <div class="form-group">
            <label><i class="fa fa-phone"></i></label>
            <p class="form-control-static">Tel. +62 123 4567</p>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <ul class="social-media">
          <li><a href="#"><i class="fa fa-facebook"></i></a></li>
          <li><a href="#"><i class="fa fa-twitter"></i></a></li>
          <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
          <li><a href="#"><i class="fa fa-instagram"></i></a></li>
        </ul>
      </div>

    </div>
  </div>
</section> -->
<!-- ./END CONTACT INFOMATION  -->

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
<script type="text/javascript" src="{{ asset('template/web/plugins/OwlCarousel2-2.2.1/dist/owl.carousel.min.js') }}"></script>
<script type="text/javascript">

$(document).on('ready',function(e){
    $(".regular").slick({
      dots: false,
      infinite:true,
      slidesToShow:3,
      slidesToScroll:1,
      autoplay:false,
      autoplaySpeed:5000,
      responsive:[{
      breakpoint:1023,
      settings:{slidesToShow:2,slidesToScroll:1}},
      {breakpoint:767,
      settings:{arrows:false,centerMode:true,centerPadding:'40px',slidesToShow:1,slidesToScroll:1}
      }]
    });

    e.preventDefault();
    $('#main-slide-show .owl-carousel').owlCarousel({
    loop:true,
    // animateOut: 'fadeOut',
    margin:0,
    nav:true,
    dots:true,
    items:1,
    autoplay:true,
    autoplaySpeed:2000,
    autoplayTimeout:6000,
    autoplayHoverPause:true,
    navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>',
              '<i class="fa fa-angle-right" aria-hidden="true"></i>']
  });
});
</script>

<script type="text/javascript" src="{{ asset('template/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/js/star-rating.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('template/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/themes/krajee-svg/theme.min.js') }}"></script> -->
<script type="text/javascript">
$(".rating").rating().unbind();
</script>

<script type="text/javascript">
    var width = $('.insta-bg').width();
    $('.insta-bg').height(width);
</script>

@if(Session::has('success-subs'))
<script type="text/javascript">
    swal("Success !", "{{ Session::get('success-subs') }}", "success");
</script>
@endif

@if(Session::has('already-subs'))
<script type="text/javascript">
    swal("Error !", "{{ Session::get('already-subs') }}", "error");
</script>
@endif

@if(Session::has('fail-subs'))
<script type="text/javascript">
    swal("Error !", "{{ Session::get('fail-subs') }}", "error");
</script>
@endif

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
    function addtocart(){
        var prodid      = $('[name=prod_id]').val();
        var prodname    = $('[name=prod_name]').val();
        var qty         = $('[name=quantity]').val();
        var price       = $('[name=prod_price]').val();
        var image       = $('[name=front_image]').val();
        var url         = $('[name=prod_url]').val();

        var datapost = {
            "_token"    : '{{ csrf_token() }}',
            "prodid"    : prodid,
            "prodname"  : prodname,
            "qty"       : qty,
            "price"     : price,
            "image"     : image,
            "url"       : url
        }

        $.ajax({
            type    : "POST",
            url     : "{{ url('ajax/addcart') }}",
            data    : datapost,
            dataType: "json",
            beforeSend : function(){
                $('#buttonadd').attr('onclick','false');
                $('#buttonadd').html('Loading');
            },
            success : function(data){
                if (data[1] == 1) {
                    // alert('Add To Cart Successed');
                    // swal("Success !", "Success Add To Cart", "success");
                    $('#successadd').html(data[5]);
                    $('#detailprod').modal('hide');
                    $('#myModal').modal('show');

                    $('.cart-count').html('('+data[2]+')');
                    // $(".top-cart-items").html(data[3]);
                    // $(".top-cart-action").html(data[4]);
                } else if(data[1] == 2) {
                    // alert('Add To Cart Failed');
                    swal("Error !", "Stock Not Available", "error");
                    // $('#stock-notif').html( '<div class="alert alert-danger" style="margin-bottom:0px;">'+
                    //                             '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
                    //                             'Out Of Stock'+
                    //                         '</div>');
                } else {
                    // alert('Add To Cart Failed');
                    swal("Error !", "Error Add To Cart", "error");
                }

                $('#buttonadd').attr('onclick','addtocart()');
                $('#buttonadd').html('Add to cart');
            }
        })
    }
</script>

<script type="text/javascript">
    localStorage.removeItem('jsvouchervalue');
    localStorage.removeItem('jsvouchertype');
</script>

@endpush

@endsection
