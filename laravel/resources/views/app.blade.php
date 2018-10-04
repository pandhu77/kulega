<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="description" content="@yield('meta-description','')" />
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <!-- START CSS-->
    <!-- bootstrap -->
    <!-- <link rel="stylesheet" href="{{asset('assets/css/full-slider.css')}}" type="text/css" /> -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,700i,900" rel="stylesheet">
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{asset('assets/css/owlcarousel2/owl.carousel.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/owlcarousel2/owl.carousel.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/owlcarousel2/owl.theme.default.min.css')}}" type="text/css" /> -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/fileinput.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/fontawesome-stars.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/ionicons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/datepicker3.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/mtree.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}" type="text/css">
    <link href="{{asset('template/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('template/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/paceloading.css')}}" type="text/css">
    <link href="{{asset('assets/css/sweetalert.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/ion.rangeSlider.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/ion.rangeSlider.skinFlat.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/normalize.css')}}" rel="stylesheet">
    <!-- END CSS-->
    <!-- START JS-->
    <script src="{{asset('assets/js/jquery.js') }}"></script>
    <script src="{{asset('assets/js/owl.carousel.min.js') }}" ></script>
    <script src="{{asset('assets/js/jquery.barrating.min.js') }}"></script>
    <script src="{{asset('assets/js/jquery.elevateZoom-3.0.8.min.js') }}"></script>
    <script src="{{asset('assets/js/paceloading.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.0/vue.js"></script>
    <!-- END JS-->

    <style>
        @font-face {font-family: 'Manus'; src: url({{asset('assets/fonts/MNS_TRIAL.ttf')}});        }
   </style>
    <!-- APP CSS -->
    <link rel="stylesheet" href="{{asset('template/frontend/app-min.css')}}" type="text/css" />
    <!-- END APP CSS -->
</head>
<body data-spy="scroll" data-target="#myScrollspy" data-offset="15">
<div class="loading"></div>
<input type="hidden" id="year" value="2016">
<div class="wrapper">
  <nav class="navbar navbar-default" style="border-radius: 0px !important; border-bottom: none;">
    <div class="container">
      <!-- Menu and toggle get grouped for better mobile display -->
      <div class="navbar-header">
          <button type="button" onclick="openNav()" class="navbar-toggle collapsed"  aria-expanded="false">
              <span class="sr-only" >Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>

          <a class="navbar-brand" href="{{ url('/')}}"><?php echo logo();?></a>
          <form class="searchbox hidden-sm hidden-md hidden-lg" action="{{url('search')}}" method="GET" role="search">
              <input type="search" placeholder="Search......" name="q" class="searchbox-input" onkeyup="buttonUp();" required>
              <input type="submit"  class="searchbox-submit" value="GO">
              <span class="searchbox-icon"><i class="glyphicon glyphicon-search"></i></span>
          </form>
      </div>
      <!-- Begin Menu Category -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
              <?php echo menucategory();?>
              <!-- <span class="search">
                   <button class="toggle"></button>
                   <form action="{{url('search')}}" method="GET" role="search">
                     <input type="search" class="form-control" name="q" placeholder="Search here..." />
                     <button type="submit"><i class="glyphicon glyphicon-search"></i></button>
                   </form>
             </span> -->
         </ul>
         <ul class="nav navbar-nav navbar-right">
            <?php if (Session::get('memberid')){ ?>
                <?php $nilai=strlen(Session::get('membername'));?>
                @if($nilai > 12)
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="icon ion-android-person"></i>
                        <?php echo substr(Session::get('membername'),0,12);?>..
                    </a>
                @else
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="icon ion-android-person"></i>
                         <?php echo substr(Session::get('membername'),0,12);?>
                    </a>
                @endif
                    <ul class="dropdown-menu dropdown-user user_profile">
                        <li>
                            <a href="{{ url('user/profile') }}">ACCOUNT DETAILS</a>
                        </li>
                        <li>
                            <a href="{{ url('user/wishlist')}}">WISHLIST</a>
                        </li>
                        <li>
                            <a href="{{ url('user/order') }}">MY ORDERS</a>
                        </li>
                        <li>
                            <a href="{{ url('user/my-shipping') }}">MY SHIPPING</a>
                        </li>
                        <li>
                            <a href="{{ url('user/logout') }}">LOGOUT <i class="glyphicon glyphicon-off"></i></a>
                        </li>
                    </ul>
                </li>

            <?php }elseif(Session::get('vendorid')){?>
                <?php $nilai=strlen(Session::get('vendorname'));?>
                @if($nilai > 12)
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="icon ion-android-person"></i> <?php echo substr(Session::get('vendorname'),0,12);?>..
                    </a>
                @else
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="icon ion-android-person"></i>
                         <?php echo substr(Session::get('vendorname'),0,12);?>
                    </a>
                @endif
                    <ul class="dropdown-menu dropdown-user user_profile">
                        <li>
                            <a href="{{ url('vendor/profile') }}">ACCOUNT DETAILS</a>
                        </li>
                        <li>
                        <a href="{{url('vendor/product')}}">MY PRODUCT</a>
                        </li>
                        <li>
                            <a href="{{ url('vendor/logout') }}">LOGOUT <i class="glyphicon glyphicon-off"></i></a>
                        </li>
                    </ul>
                </li>

            <?php }else{ ?>
                <li>
                    <a href="{{ url('/user/login')}}" role="button" aria-haspopup="true" aria-expanded="false">Login </a>
                </li>
            <?php } ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Cart
                        <img src="{{asset('assets/img/web/Cart_icon.png')}}" alt="icon cart" >
                        <span class="badge"><?php echo count(Cart::content())?></span>
                    </a>
                    <ul class="dropdown-menu" style="width: auto;">
                        <div class="shopping-cart">
                        <?php $cart=Cart::content();?>
                            <div class="shopping-cart-header">
                                <i class="fa fa-shopping-cart cart-icon"></i>
                                <span class="badge"><?php echo count(Cart::content())?></span>
                                <div class="shopping-cart-total">
                                    <span class="lighter-text">Total:</span>
                                    <span class="main-color-text price_format"><?php echo substr( Cart::subtotal(),0,-3);?></span>
                                </div>
                            </div>

                        <ul class="shopping-cart-items">
                            @foreach($cart as $carts)
                                <?php echo $carts->name; ?>
                                <li class="clearfix">
                                    <img src="{{asset($carts->options['image_small'])}}"style="width:40px;" alt="item1" />
                                    <span class="item-price price_format">{{$carts->price}}</span>
                                    <span class="item-quantity">Qty: {{$carts->qty}}</span>
                                    <span class="item-quantity" style="float: right;">
                                        <a href="#" style="color:#000;" class="remove-product"onclick="if(confirm('Are you sure?')) href='http://chronosh.com/sentradiskon/delete-cart/<?php echo $carts->rowId;?>'">
                                            <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                        @if(count(Cart::count())>0)
                            <a href="{{url('shopping-cart')}}" class="button">CHECKOUT</a>
                        @endif
                        </div>
                    </ul>
                </li>
                <li>
                    <li class="hidden-xs">
                        <a href="#toggle-search"><i class="glyphicon glyphicon-search"></i></a>
                    </li>
                </li>
            </ul>
          </div>
        </div>
        <!-- /.End Menu Category -->
        <!-- Start Search -->
        <div class="default-search animate">
          <div class="container">
            <div class="col-sm-12">
              <form action="{{url('search')}}" method="GET" role="search">
                <div class="input-group">
                  <input type="text" class="form-control" name="q" placeholder="Search...">
                  <span class="input-group-btn">
                    <a class="btn btn-default btn-search " type="reset" style="font-size:xx-large;padding
                    :0px;"><span class="ion-ios-close-empty"></span></a>
                  </span>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.End Search -->
    </nav>
    <!-- Begin Mobile Menu -->
    <div id="mySidenav" class="sidenav">
      <!-- <a class="navbar-brand" href="{{ url('/')}}"><img src="{{asset('assets/img/web/LOGO.png') }}" class="logo"></a> -->
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div id="sidebar" class="sidebar">
          <ul class="menu-level1 no-style">
            <?php echo menucategorymobile(); ?>
            <li class="menu-toggle">
               <div class="menu-toggle-btns" >
                 <!-- Member-->
                 <?php if (Session::get('memberid')){ ?>
                       <?php $nilai=strlen(Session::get('membername'));?>
                       @if($nilai > 15)
                            <a href="{{ url('user/profile') }}"  class="menu-link"><i class="icon ion-android-person"></i> <?php echo substr(Session::get('membername'),0,15);?>..</a>
                       @else
                            <a href="{{ url('user/profile') }}"  class="menu-link"><i class="icon ion-android-person"></i> <?php echo substr(Session::get('membername'),0,15);?></a>
                       @endif
                 <?php } ?>
                       <!-- Vendor-->
                       <?php if (Session::get('vendorid')){ ?>
                         <?php $nilai=strlen(Session::get('vendorname'));?>
                         @if($nilai > 15)
                         <a href="{{ url('vendor/profile') }}"  class="menu-link"><i class="icon ion-android-person"></i> <?php echo substr(Session::get('vendorname'),0,15);?>..</a>
                         @else
                         <a href="{{ url('vendor/profile') }}"  class="menu-link"><i class="icon ion-android-person"></i> <?php echo substr(Session::get('vendorname'),0,15);?></a>
                         @endif
                 <?php } ?>
                </div>
             </li>

            <li class="menu-toggle">
               <div class="menu-toggle-btns" >
                <?php if (Session::get('memberid')){ ?>
                    <a href="{{ url('user/logout') }}"  class="menu-link">
                        <i class="glyphicon glyphicon-off"></i> Logout
                    </a>
                <?php }elseif(Session::get('vendorid')){?>
                    <a href="{{ url('vendor/logout') }}"  class="menu-link">
                        <i class="glyphicon glyphicon-off"></i> Logout
                    </a>
                <?php }else{ ?>
                    <a href="{{ url('/user/login')}}"  class="menu-link" role="button" aria-haspopup="true" aria-expanded="false">
                        Login
                    </a>
                <?php } ?>
                </div>
             </li>
             <li class="menu-toggle">
                 <div class="menu-toggle-btns">
                     <a href="{{url('shopping-cart')}}" role="button" aria-haspopup="true" aria-expanded="false" >
                         Cart
                         <span class="badge" style="background-color:#f4f5f4;font-size:15px; color:#333;">
                             <?php echo count(Cart::content())?>
                         </span>
                     </a>
                </div>
             </li>
          </ul>
      </div>
      <ul class="nav navbar-nav" style="text-align: center;"></ul>
    </div>
    <!-- // End Mobile Menu -->
    <div class="clearfix"></div>
    <!-- Begin Content -->
    <div class="main-content">
        @yield('content')
    </div>
    <!-- // End Content -->
    <div class="clearfix"></div>
    <div class="clearfix"></div>

    <div class="bottom">
        <div class="container">
        <!--bottom rows 1-->
        <div class="row">
            <!--Address-->
            <div class="adrss col-md-3" >
                <label class="footer-title">SENTRA STORE </label>
                <ul class="footer-item-list">
                <?php echo storesentra();?>
                </ul>
            </div>
            <!--./Address-->
            <!--Info-->
            <div class="col-md-3 col-sm-6">
                <label class="footer-title">SENTRA INFOMATION </label>
                <ul class="footer-item-list">
                <?php echo infosentra();?>
                </ul>
            </div>
            <!--./Info-->
            <!--Customer care-->
            <div class="col-md-3 col-sm-6">
                <?php echo customer_care();?>
            </div>
            <!--/-->
            <!--Right-->
            <div class="adrss col-md-3" >
                <div class="footer-title-3">
                    <a href="{{ url('/') }}" class="bottom-logo">
                    <img src="{{ asset('assets/img/web/logo-item.png') }}" width="200" alt="logo.png"></a>
                </div>
                <address>
                <ul class="footer-item-list-2">
                <?php echo address();?>
                </ul>
                </address>
                <div class="row">
                    <div class="col-md-12" style="padding:5px;">
                    <?php echo socialmedia();?>
                    </div>
                </div>
                <div class="row"  id="sendmessage" style="margin-top:10px;">
                    <h5 style="margin-left: 13px;"><strong>Be the first to know about new arrivals and receive exclusive access to our events.</strong></h5>
                    @if(Session::has('success-send'))
                    <div class="alert alert-success alert-dismissable col-sm-12">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('success-send') }}
                    </div>
                    @endif
                    @if(Session::get('error-send'))
                    <div class="alert alert-dange col-md-12 col-sm-12">
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        {{ Session::get('error-send') }}
                    </div>
                    @endif
                    <form action="{{action('HomeController@subscriberstore')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group col-sm-12 col-xs-12" >
                        <input id="msg_email" required class="form-control input-contact" type="email" placeholder="Email Address" name="msg_email">
                    </div>
                    <div class="form-group col-sm-12 ">
                        <button id="sub" type="submit" class="btn pull-right btn-send" >SEND</button>
                    </div>
                    </form>
                </div>
            </div>
            <!--./Right-->
            </div>
            <div class="row" >
                <div class="col-sm-12" style="text-align:center;">
                    &copy Powered by 2017. Created By Elven Digital Indonesia
                </div>
            </div>
        </div>
    </div>
  </div><!--/.Wrapper-->
  <script src="{{asset('assets/js/bootstrap.js') }}" ></script>
  <script src="{{asset('assets/js/select2.min.js') }}" ></script>
  <script src="{{asset('assets/js/fileinput.min.js') }}" ></script>
  <script src="{{asset('assets/js/ion.rangeSlider.js') }}" ></script>
  <script src="{{asset('assets/js/scriptbreaker-multiple-accordion-1.js') }}" ></script>
  <script src="{{asset('assets/js/bootstrap-filestyle.min.js') }}" ></script>
  <script src="{{asset('assets/js/bootstrap-datepicker.js') }}"></script>
  <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.elevatezoom.js')}}"></script>
  <script src="{{asset('assets/js/jquery.elevateZoom-3.0.8.min.js')}}"></script>
  <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
  <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
  <script type="text/javascript" src="{{ asset('assets/js/jquery.price_format.2.0.js') }}"></script>
  <script src="http://formvalidation.io/vendor/formvalidation/js/formValidation.min.js"></script>
  <script src="http://formvalidation.io/vendor/formvalidation/js/framework/bootstrap.min.js"></script>
  <script src="{{ asset('assets/js/jquery.price_format.2.0.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.steps.min.js') }}"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script> -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
  <!--script daterangepicker -->
  <script src="{{asset('template/vendors/moment/min/moment.min.js')}}"></script>
  <script src="{{asset('template/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

  <!--script select 2 -->
  <script type="text/javascript">
  $(document).ready(function() {
      $(".js-example-basic-single").select2();
  });
  </script>
  <!-- /end select 2 -->
  <!-- search Mobile -->
  <script>
  $(document).ready(function(){
      var submitIcon = $('.searchbox-icon');
      var inputBox = $('.searchbox-input');
      var searchBox = $('.searchbox');
      var isOpen = false;
      submitIcon.click(function(){
          if(isOpen == false){
              searchBox.addClass('searchbox-open');
              inputBox.focus();
              isOpen = true;
          } else {
              searchBox.removeClass('searchbox-open');
              inputBox.focusout();
              isOpen = false;
          }
      });
      submitIcon.mouseup(function(){
          return false;
      });
      searchBox.mouseup(function(){
          return false;
      });
      $(document).mouseup(function(){
          if(isOpen == true){
              $('.searchbox-icon').css('display','block');
              submitIcon.click();
          }
      });
  });

  function buttonUp(){
      var inputVal = $('.searchbox-input').val();
      inputVal = $.trim(inputVal).length;
      if( inputVal !== 0){
          $('.searchbox-icon').css('display','none');
      } else {
          $('.searchbox-input').val('');
          $('.searchbox-icon').css('display','block');
      }
  }
  </script>
  <script>
  var sidebar = (function() {
      "use strict";

      var $contnet         = $('#content'),
      $sidebar         = $('#sidebar'),
      $sidebarBtn      = $('#sidebar-btn'),
      $toggleCol       = $('body').add($contnet).add($sidebarBtn),
      sidebarIsVisible = false;

      $sidebarBtn.on('click', function() {

          if (!sidebarIsVisible) {
              bindContent();
          } else {
              unbindContent();
          }

          toggleMenu();
      });


      function bindContent() {

          $contnet.on('click', function() {
              toggleMenu();
              unbindContent();
          });
      }

      function unbindContent() {
          $contnet.off();
      }

      function toggleMenu() {

          $toggleCol.toggleClass('sidebar-show');
          $sidebar.toggleClass('show');

          if (!sidebarIsVisible) {
              sidebarIsVisible = true;
          } else {
              sidebarIsVisible = false;
          }
      }

      var $menuToggle = $sidebar.find('.menu-toggle');

      $menuToggle.each(function() {

          var $this       = $(this),
          $submenuBtn = $this.children('.menu-toggle-btns').find('.menu-btn'),
          $submenu    = $this.children('.submenu');

          $submenuBtn.on('click', function(e) {
              e.preventDefault();
              $submenu.slideToggle();
              $(this).toggleClass('active');
          });
      });
  })();
  </script>

  <script>
  $(function() {

      $('a[href="#toggle-search"], .navbar-default .default-search .input-group-btn > .btn[type="reset"]').on('click', function(event) {
          event.preventDefault();
          $('.navbar-default .default-search .input-group > input').val('');
          $('.navbar-default .default-search').toggleClass('open');
          $('a[href="#toggle-search"]').closest('li').toggleClass('active');

          if ($('.navbar-default .default-search').hasClass('open')) {
              /* I think .focus dosen't like css animations, set timeout to make sure input gets focus */
              setTimeout(function() {
                  $('.navbar-default .default-search .form-control').focus();
              }, 100);
          }
      });

      $(document).on('keyup', function(event) {
          if (event.which == 27 && $('.navbar-default .default-search').hasClass('open')) {
              $('a[href="#toggle-search"]').trigger('click');
          }
      });

  });
  </script>

  <!-- bootstrap-daterangepicker time -->
  <script>
  $(document).ready(function() {
      $('#datepicker').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
              format: 'DD/MM/YYYY h:mm A',
          },
          singleDatePicker: true,
          calender_style: "picker_4",

      },
      function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
      });

      if ($('#triggerdate').val() == '') {
          $("#datepicker").val('');
      }

      $("#datepicker").focus(function(){
          if ($("#datepicker").val() == '') {
              $('.table-condensed tbody tr td').removeClass('active');
          }

      });

      $("#datepicker").focusout(function(){
          if ($('.table-condensed tbody tr td').hasClass('active')) {

          }else {
              $("#datepicker").val('');
          }
      });

      var date = $('#datepicker');
      date.on('keydown', function() {
          var key = event.keyCode || event.charCode;
          if( key == 8 || key == 46 )
          $("#datepicker").val('');
          $('.table-condensed tbody tr td').removeClass('active');
      });

  });
  </script>
  <!-- /bootstrap-daterangepicker -->


  <!-- bootstrap-daterangepicker -->
  <script>
  $(document).ready(function() {
      $('#datepicker2').daterangepicker({

          locale: {
              format: 'YYYY/MM/DD',
          },
          singleDatePicker: true,
          calender_style: "picker_4",

      },
      function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
      });

      if ($('#triggerdate2').val() == '') {
          $("#datepicker2").val('');
      }

      $("#datepicker2").focus(function(){
          if ($("#datepicker2").val() == '') {
              $('.table-condensed tbody tr td').removeClass('active');
          }

      });

      $("#datepicker2").focusout(function(){
          if ($('.table-condensed tbody tr td').hasClass('active')) {

          }else {
              $("#datepicker2").val('');
          }
      });

      var date = $('#datepicker2');
      date.on('keydown', function() {
          var key = event.keyCode || event.charCode;
          if( key == 8 || key == 46 )
          $("#datepicker2").val('');
          $('.table-condensed tbody tr td').removeClass('active');
      });

  });
  </script>
  <!-- /bootstrap-daterangepicker -->



  <script>
  //Price Format
  $('.price_format').priceFormat();
  </script>
  <script>
  $(window).scroll(function () {
      var w = $(window).width();
      if (w > 768) {
          if ($(this).scrollTop() > 50) {
              $('.navbar').css("padding-top","0px");
              $('.navbar').css("padding-bottom","0px");
          } else {
              $('.navbar').css("padding-top","0px");
              $('.navbar').css("padding-bottom","0px");
          }
      }
  });
  </script>
  <script>
  //Price Format
  $('.price_format').priceFormat();
  $(document).ready(function(){
      $(".dropdown1").hover(
          function() {
              $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("400");
              $(this).toggleClass('open');
          },
          function() {
              $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("400");
              $(this).toggleClass('open');
          }
      );
  });
  /* Set the width of the side navigation to 250px */
  function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
  }
  /* Set the width of the side navigation to 0 */
  function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
  }
  </script>
  <script>
  (function(){

      $("#cart").on("click", function() {
          $(".shopping-cart").fadeToggle( "fast");
      });

  })();
  </script>
  <script type="text/javascript">
  $('.owl-carousel').owlCarousel({
      loop:true,
      margin:10,
      nav:false,
      dots:false,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:1
          },
          1000:{
              items:1
          }
      }
  });
  </script>
</body>
</html>
