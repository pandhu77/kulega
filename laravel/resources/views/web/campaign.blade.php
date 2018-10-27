@extends('web.master')
@section('title','www.kulega.com')
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
        /* font-family: 'Pacifico', cursive; */
        color: #1ABC9C;
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
/*
    .product{
        width: 100% !important;
    } */

    .product-title h4 a{
        color:#1ABC9C;
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
        height: 150px;
    }

    .section-title .col-sm-3{
        text-align: right;
    }

    .product-image img{
        height:350px;
        object-fit:scale-down;
    }

    .campaign-profile img{
      width: 30px;
      height: 30px;
      border-radius: 50px;
      display: inline;
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
<section class="banner" style="background:url('https://d1vdjc70h9nzd9.cloudfront.net/images/browse-header-img.jpg');">
    <div class="wrap-outer">
      <h3 style="margin: 0px;font-family:'Noto Sans';color:#fff;">Browse Fundraisers</h3>
      <p class="text-center" style="color: #fff;font-size: 16px;font-family:'Noto Sans'; margin: 0px;">The cause you believe in are all in here.</p>
    </div>
</section>
@endforeach
<!-- END BANNER -->

<section id="content" style="background: #eee;">

  <div class="content-wrap" style="padding-top:15px !important;">

    <div class="container clearfix">

      <div class="row section-title text-center">
        <div class="col-md-12" style="margin-bottom:20px;text-align:right;">
          Views:
          <select class="" name="view_item" style="width: 120px;height: 40px;padding-left: 10px;" onchange="changeview()">
              <option value="9" <?php if($view == 9){echo "selected";} ?>>9</option>
              <option value="12" <?php if($view == 12){echo "selected";} ?>>12</option>
              <option value="24" <?php if($view == 24){echo "selected";} ?>>24</option>
              <option value="36" <?php if($view == 36){echo "selected";} ?>>36</option>
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
      </div>

      <!-- Post Content
      ============================================= -->
      <div class="postcontent nobottommargin col_last">

        <!-- Shop
        ============================================= -->
        <div id="shop" class="shop product-3 grid-container clearfix">

          @foreach($products as $campaign)
          <div class="product cate{{ $campaign->parent }} col-xs-12 col-sm-6 col-md-4" style="padding: 0 15px 15px 15px;">
              <div class="col-md-12 kulega" style="padding: 0px !important; margin-bottom: 10px; background-color: #fff;" onclick="window.location.href='{{ url('/campaign/'.$campaign->url) }}<?php if(isset($_GET['category'])){echo "?category=".$_GET['category'];} ?>'">
                <div class="widget-container home_trending" style="background-color: #fff;">
                  <div class="image">
                    <img src="{{ url($campaign->image) }}" class="img-responsive">
                  </div>
                  <p class="small-badge">
                    <span id="campaignCause" class="label label-large label-color arrowed-right cat-tag cat-personal">{{ $campaign->kateg_name }}</span>
                  </p>
                  <div class="widget-details">
                    <div class="widget-mid">
                      <div class="product-title">
                        <h5 id="campaignTitle"><a href="{{ url('/campaign/'.$campaign->url) }}<?php if(isset($_GET['category'])){echo "?category=".$_GET['category'];} ?>" tabindex="0">{{ $campaign->name }}</a></h5>
                      </div>

                      <div class="campaign-profile">
                        @if(!empty($campaign->member_image))<img src="{{ $campaign->member_image }}" class="img-responsive">@endif
                        <span style="font-size: 14px; font-style: italic; color: #000;">by <span style="color: #00f">{{ $campaign->member_fullname }}</span></span>
                      </div>

                      <div id="campaignBlurb" class="campaign-desc"><?php echo $campaign->desc; ?></div>

                      <div class="widget-footter">
                          <div class="amt-raised clearfix product-price">
                              <span class="pull-left"><span style="font-size: 18px;font-weight: bold;">Rp</span> <span class="campaignAmountRaised"><?php echo number_format($campaign->target,0,',','.'); ?></span></span>
                              <ins style="display: none;"><?php echo $campaign->target; ?></ins>
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

        </div><!-- #shop end -->

      </div><!-- .postcontent end -->

      <!-- Sidebar
      ============================================= -->
      <div class="sidebar nobottommargin">
        <div class="sidebar-widgets-wrap">

          <div class="widget widget-filter-links clearfix">

            <h4>Select Category</h4>
            <ul class="custom-filter" data-container="#shop" data-active-class="active-filter">
              <li class="widget-filter-reset <?php if(!isset($category) || $category == 'all'){echo 'active-filter';} ?>"><a href="#" data-filter="*">Clear</a></li>
              @foreach($allcategory as $cate)
              <li <?php if($cate->kateg_url == $category){echo 'class="active-filter"';} ?>>
                <a href="#" data-filter=".cate{{ $cate->kateg_id }}">{{ $cate->kateg_name }}</a>
              </li>
              @endforeach
            </ul>

          </div>

          <div class="widget widget-filter-links clearfix">

            <h4>Sort By</h4>
            <ul class="shop-sorting">
              <li class="widget-filter-reset active-filter"><a href="#" data-sort-by="original-order">Clear</a></li>
              <li><a href="#" data-sort-by="name">Name</a></li>
              <li><a href="#" data-sort-by="price_lh">Target: Low to High</a></li>
              <li><a href="#" data-sort-by="price_hl">Target: High to Low</a></li>
            </ul>

          </div>

        </div>
      </div><!-- .sidebar end -->

    </div>

  </div>

</section><!-- #content end -->

@push('js')

<script type="text/javascript" src="{{ asset('template/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/js/star-rating.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('templates/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/themes/krajee-svg/theme.min.js') }}"></script> -->
<script type="text/javascript">
$(".rating").rating().unbind();
</script>

<script type="text/javascript">
    function changeview(){
        var view = $('[name=view_item]').val();
        location.href = "{{ url('/campaign') }}?category={{ $category }}&view="+view;
    }
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

<script>
  jQuery(document).ready( function($){
    $('#shop').isotope({
      transitionDuration: '0.65s',
      getSortData: {
        name: '.product-title',
        price_lh: function( itemElem ) {
          if( $(itemElem).find('.product-price').find('ins').length > 0 ) {
            var price = $(itemElem).find('.product-price ins').text();
          } else {
            var price = $(itemElem).find('.product-price').text();
          }

          return parseFloat( price );
        },
        price_hl: function( itemElem ) {
          if( $(itemElem).find('.product-price').find('ins').length > 0 ) {
            var price = $(itemElem).find('.product-price ins').text();
          } else {
            var price = $(itemElem).find('.product-price').text();
          }

          return parseFloat( price );
        }
      },
      sortAscending: {
        name: true,
        price_lh: true,
        price_hl: false
      }
    });

    $('.custom-filter:not(.no-count)').children('li:not(.widget-filter-reset)').each( function(){
      var element = $(this),
        elementFilter = element.children('a').attr('data-filter'),
        elementFilterContainer = element.parents('.custom-filter').attr('data-container');

      elementFilterCount = Number( jQuery(elementFilterContainer).find( elementFilter ).length );

      element.append('<span>'+ elementFilterCount +'</span>');

    });

    $('.shop-sorting li').click( function() {
      $('.shop-sorting').find('li').removeClass( 'active-filter' );
      $(this).addClass( 'active-filter' );
      var sortByValue = $(this).find('a').attr('data-sort-by');
      $('#shop').isotope({ sortBy: sortByValue });
      return false;
    });
  });
</script>

@endpush

@endsection
