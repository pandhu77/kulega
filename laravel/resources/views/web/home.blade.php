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

    .portfolio-overlay a{
      left: 58%;
    }

    .fconnect h2{
      margin-top: 0;
      font-size: 20px !important;
      margin-bottom: 10px !important;
      text-align: center;
      line-height: 29px;
    }

    .fconnect .watsappBg{
      background: #f4f4f4;
      padding: 22px 60px;
      height: 204px;
    }

    .fconnect .fbBg{
      background: #e7e7ee;
      padding: 22px 60px;
      height: 204px;
    }

    .fconnect .watsappBg .btn-whatsapp{
      background: #34af23;
      border-color: #88d67f;
      width: 100%;
      outline: none;
      color: #fff;
    }

    .fconnect .fbBg .btn-fb{
      background: #3a589b;
      border-color: #6b88c5;
      width: 100%;
      outline: none;
      color: #fff;
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
                  </div>

                  <div class="progress ">
                      <div id="campaignProgressRaised" class="progress-bar" style="width:<?php echo round((0/$campaign->target)*100); ?>%"></div>
                  </div>
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
        <h3 style="margin: 0px;font-family:'Noto Sans';">Browse Fundraisers</h3>
        <p class="text-center" style="color: #777;font-size: 16px;font-family:'Noto Sans'; margin: 0px;">The cause you believe in are all in here.</p>
      </div>
    </div>
    <div class="row section-content">

      <div id="oc-portfolio" class="owl-carousel portfolio-carousel carousel-widget" data-margin="1" data-loop="true" data-nav="true" data-pagi="false"data-items-xxs="1" data-items-xs="2" data-items-sm="3" data-items-md="4" data-items-lg="4">

        @foreach($getcate as $cate)
        <div class="oc-item">
          <div class="iportfolio">
            <div class="portfolio-image">
              <a href="#">
                <img src="{{ url($cate->kateg_image) }}" alt="Open Imagination">
              </a>
              <div class="portfolio-overlay">
                <a href="{{ url($cate->kateg_image) }}" class="left-icon" data-lightbox="image"><i class="icon-line-search"></i></a>
              </div>
            </div>
            <div class="portfolio-desc">
              <h3><a href="#">{{ $cate->kateg_name }}</a></h3>
              <span><a href="#">Media</a>, <a href="#">Icons</a></span>
            </div>
          </div>
        </div>
        @endforeach

      </div>

    </div>

  </div>
</section>
<!-- ./END PRODUCTS -->

<style media="screen">
  .heading-block ul li{
    font-size: 20px;
  }
</style>

<section class="section nobg notopmargin clearfix" style="padding: 20px 0;background-color:#f5f5f5 !important;">
  <div class="container clearfix">
    <div class="row clearfix">
      <div class="col-md-12">
        <div class="heading-block nobottomborder topmargin-sm nobottommargin">
          <h3 style="margin: 0px;font-family:'Noto Sans';text-align:center;margin-bottom:30px;">Asia's most visited and trusted crowdfunding platform</h3>
          <div class="row clearfix" style="text">
            <div class="col-sm-offset-3 col-sm-3">
              <ul class="iconlist nobottommargin">
                <li><i class="icon-ok"></i> 100% Assurance</li>
                <li><i class="icon-ok"></i> Hard Working</li>
                <li><i class="icon-ok"></i> Trustworthy</li>
              </ul>
            </div>
            <div class="col-sm-3">
              <ul class="iconlist nobottommargin">
                <li><i class="icon-ok"></i> Intelligent</li>
                <li><i class="icon-ok"></i> Always Curious</li>
                <li><i class="icon-ok"></i> Perfectionists</li>
              </ul>
            </div>
          </div>
          <div class="line line-sm"></div>
        </div>
        <div class="row clearfix" style="text-align:center;">
          <div class="col-sm-4">
            <div>
              <div class="counter counter-small color"><span data-from="10" data-to="1136" data-refresh-interval="50" data-speed="1000"></span>+</div>
              <h5 class="color t600 nott notopmargin" style="font-size: 16px;">Happy Customers</h5>
            </div>
          </div>

          <div class="col-sm-4">
            <div>
              <div class="counter counter-small" style="color: #22c1c3;"><span data-from="10" data-to="145" data-refresh-interval="50" data-speed="700"></span>+</div>
              <h5 class="t600 nott notopmargin" style="color: #22c1c3; font-size: 16px;">Pets Hosted</h5>
            </div>
          </div>

          <div class="col-sm-4">
            <div>
              <div class="counter counter-small" style="color: #BD3F32;"><span data-from="10" data-to="50" data-refresh-interval="85" data-speed="1200"></span>+</div>
              <h5 class="t600 nott notopmargin" style="color: #BD3F32; font-size: 16px;">Professionals</h5>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<div class="section nobg notopmargin clearfix" style="margin:0px;padding:0px;">
  <div class="container clearfix">

    <div class="col-md-12" style="margin-bottom:50px;">
      <h3 style="margin: 0px;font-family:'Noto Sans';text-align:center;">How To Go About It</h3>
      <p class="text-center" style="color: #777;font-size: 16px;font-family:'Noto Sans'; margin: 0px;font-style:italic;">Decided to raise funds? Pat yourself on the back. Still have doubts? Read these!</p>
    </div>

    <div class="col_one_third">
      <div class="feature-box fbox-plain">
        <div class="fbox-icon">
          <a href="#"><img src="{{ url('template/demos/business/images/icons/24help.svg') }}" alt=""></a>
        </div>
        <h3 class="nott t600 ls0">Responsive Layout</h3>
        <p>Powerful Layout with Responsive functionality that can be adapted to any screen size.</p>
      </div>
    </div>

    <div class="col_one_third">
      <div class="feature-box fbox-plain">
        <div class="fbox-icon">
          <a href="#"><img src="{{ url('template/demos/business/images/icons/barcode.svg') }}" alt=""></a>
        </div>
        <h3 class="nott t600 ls0">Retina Ready Graphics</h3>
        <p>Looks beautiful &amp; ultra-sharp on Retina Displays with Retina Icons, Fonts &amp; Images.</p>
      </div>
    </div>

    <div class="col_one_third col_last">
      <div class="feature-box fbox-plain">
        <div class="fbox-icon">
          <a href="#"><img src="{{ url('template/demos/business/images/icons/buy.svg') }}" alt=""></a>
        </div>
        <h3 class="nott t600 ls0">Powerful Performance</h3>
        <p>Optimized code that are completely customizable and deliver unmatched fast performance.</p>
      </div>
    </div>

    <div class="clear"></div>

    <div class="container" style="text-align:center;">
      <a href="{{ url('/products?category=all') }}" class="button button-small nomargin">Sign Up For Free</a>
    </div>

  </div>
</div>

<div class="section nomargin clearfix" style="padding:20 0px;margin-top:30px !important;background-color:#f5f5f5;">
  <h3 class="center">What makes us do, what we do</h3>

  <div class="fslider testimonial testimonial-full noshadow noborder nopadding divcenter" data-animation="fade" data-arrows="false" style="max-width: 700px;">
    <div class="flexslider">
      <div class="slider-wrap">
        <div class="slide">
          <div class="testi-content">
            <p>Similique fugit repellendus expedita excepturi iure perferendis provident quia eaque. Repellendus, vero numquam?</p>
            <div class="testi-meta">
              Steve Jobs
              <span>Apple Inc.</span>
            </div>
          </div>
        </div>
        <div class="slide">
          <div class="testi-content">
            <p>Natus voluptatum enim quod necessitatibus quis expedita harum provident eos obcaecati id culpa corporis molestias.</p>
            <div class="testi-meta">
              Collis Ta'eed
              <span>Envato Inc.</span>
            </div>
          </div>
        </div>
        <div class="slide">
          <div class="testi-content">
            <p>Incidunt deleniti blanditiis quas aperiam recusandae consequatur ullam quibusdam cum libero illo rerum!</p>
            <div class="testi-meta">
              John Doe
              <span>XYZ Inc.</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="section nomargin clearfix" style="padding: 80px 0;margin-top:0px;background-color:#fff;">

  <h3 style="margin: 0px;font-family:'Noto Sans';text-align:center;margin-bottom:50px;">Featured In</h3>

  <div id="oc-clients-full" class="owl-carousel owl-carousel-full image-carousel carousel-widget" data-margin="0" data-nav="false" data-pagi="false" data-loop="true" data-autoplay="3000" data-items-xxs="2" data-items-xs="3" data-items-sm="5" data-items-md="5" data-items-lg="5">

    <div class="oc-item"><a href="#"><img src="{{url('template/demos/business/images/clients/linkedin.svg')}}" style="height: 24px" alt="Brands"></a></div>
    <div class="oc-item"><a href="#"><img src="{{url('template/demos/business/images/clients/nat-geo.svg')}}" style="height: 24px" alt="Brands"></a></div>
    <div class="oc-item"><a href="#"><img src="{{url('template/demos/business/images/clients/jetblue.svg')}}" style="height: 24px" alt="Brands"></a></div>
    <div class="oc-item"><a href="#"><img src="{{url('template/demos/business/images/clients/zillow.svg')}}" style="height: 24px" alt="Brands"></a></div>
    <div class="oc-item"><a href="#"><img src="{{url('template/demos/business/images/clients/amazon.svg')}}" style="height: 24px" alt="Brands"></a></div>

  </div>
</div>

<div class="container-fluid text-center fconnect" id="fConnect" style="padding-left: 0px;
			padding-right: 0px;">

		<div class="col-md-12">

				<div class="col-md-6 col-xs-12" style="padding-left:0px;padding-right:0px;">
		<div id="connectFb" class="watsappBg">
				<h2>Click on "Subscribe" to receive stories of people who need nothing more than your voice - a simple share</h2>
				<p>Add us to your contacts to receive stories every Tuesday &amp; Friday</p>
				<a href="https://api.whatsapp.com/send?phone=918291379122&amp;text=Count%20me%20in%21%20I%20want%20to%20subscribe%20to%20Ketto%20Voice." target="_blank">
				<button class="btn btn-lg btn-whatsapp" data-title="home_page">
				<i class="fa fa-whatsapp custom_whatsaapp_icon"></i>&nbsp;Subscribe to Whatsapp
				</button>
				</a>
			</div>
		</div>

		<div class="col-md-6 col-xs-12" style="padding-left:0px;padding-right:0px;">
		<div id="connectFb" class="fbBg">
				<h2>We post stories of patients who need help to afford lifesaving treatment everyday</h2>
				<p>Follow us on Facebook to pull them out of the clutches of death</p>
				<a target="_blank" href="http://www.facebook.com/ketto.org">
				<button class="btn btn-lg btn-fb" data-title="home_page">
				<i class="fa fa-facebook fa-inverse"></i>&nbsp;Follow us on Facebook
				</button>
				</a>
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
