<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,700i,900" rel="stylesheet">
  <!-- START BAWAHAN TEMPLATE-->
  <!-- Bootstrap -->
  <link href="{{asset('template/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{asset('template/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <!-- NProgress -->
  <link href="{{asset('template/vendors/nprogress/nprogress.css')}}" rel="stylesheet">

  <!-- bootstrap-progressbar -->
  <link href="{{asset('template/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
  <!-- JQVMap -->
  <link href="{{asset('template/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
  <!-- bootstrap-daterangepicker -->
  <link href="{{asset('template/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="{{asset('template/build/css/custom.min.css')}}" rel="stylesheet">

  <!-- NProgress -->
  <link href="{{asset('template/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
  <!-- iCheck -->
  <link href="{{asset('template/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
  <!-- Datatables -->
  <link href="{{asset('template/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

  <!-- bootstrap-wysiwyg -->
  <link href="{{asset('template/vendors/google-code-prettify/bin/prettify.min.css')}}" rel="stylesheet">

<!-- END BAWAHAN TEMPLATE -->

  <!-- Select2 -->
  <link href="{{asset('template/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
  <!-- Switchery -->
  <link href="{{asset('template/vendors/switchery/dist/switchery.min.css')}}" rel="stylesheet">
  <!-- starrr -->
  <link href="{{asset('template/vendors/starrr/dist/starrr.css')}}" rel="stylesheet">
  <!-- bootstrap-daterangepicker -->
  <link href="{{asset('template/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
  <link href="{{asset('assets/fancybox/jquery.fancybox.css')}}" rel="stylesheet">
  <!-- ALERT DELETE -->
  <link href="{{asset('assets/css/sweetalert.css')}}" rel="stylesheet">
  <!-- META TAG -->
  <!-- <link href="{{asset('assets/css/tag/jquery.tagit.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/tag/tagit.ui-zendesk.css')}}" rel="stylesheet"> -->
  <!-- SELECT bootstrap-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
  <!-- datepicker-->
  <link rel="stylesheet" href="{{ asset('template/admin/colorpicker/bootstrap-colorpicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/admin/datepicker/datepicker3.css') }}">
  <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
  <link href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"rel="Stylesheet" type="text/css" />

    <style>
          html, body{
              font-family: 'Lato', sans-serif;
              height: 100%;
          }
          @media (min-width: 768px){
            .form-horizontal .control-label {
                padding-top: 7px;
                margin-bottom: 0;
                text-align: left;
            }
          }

          @media(max-width:768px){
            .col-xs-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4,
            .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6,
            .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8,
            .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10,
            .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {

                float: none;

            }
            .col-left{
            padding-left:0px;padding-right:0px;
            }

        }
        .parsley-errors-list{
          display: none!important;
        }
        .parsley-required{
         display: none!important;
        }
        /*.btn {
          border-radius: 0!important;
        }*/
        .btn-group > .btn, .btn-group-vertical > .btn {
            position: relative;
            float: left;
        }
        .btn-group-sm>.btn, .btn-sm {
            position: relative;
            float: left;
        }
        .btn-group .btn+.btn, .btn-group .btn+.btn-group, .btn-group .btn-group+.btn, .btn-group .btn-group+.btn-group {
            margin-left: -1px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        /*.btn-success {
            background: #d9534f;
            border: 1px solid #c66;
        }
        .btn-success:hover, .btn-success:focus, .btn-success:active, .btn-success.active, .open .dropdown-toggle.btn-success {
              background: #d9534f;
              border: 1px solid #c66;
        }
        .btn-danger {
          color: #fff;
          background-color: #2A3F54;
          border-color: #555;
        }
        .btn-danger.active.focus, .btn-danger.active:focus, .btn-danger.active:hover, .btn-danger:active.focus, .btn-danger:active:focus, .btn-danger:active:hover, .open>.dropdown-toggle.btn-danger.focus, .open>.dropdown-toggle.btn-danger:focus, .open>.dropdown-toggle.btn-danger:hover {
            color: #fff;
            background-color: #2A3F54;
            border-color: #555;
        }
        .btn-danger:hover {
            color: #fff;
            background-color: #2A3F54;
            border-color: #555;
        }

        .btn-success.active.focus, .btn-success.active:focus, .btn-success.active:hover, .btn-success:active.focus, .btn-success:active:focus, .btn-success:active:hover, .open>.dropdown-toggle.btn-success.focus, .open>.dropdown-toggle.btn-success:focus, .open>.dropdown-toggle.btn-success:hover {
            color: #fff;
            background-color: #d9534f;
            border-color: #c66;
        }*/

        @media screen and (max-width: 1200px) {
          .over{
              overflow:auto;
              padding-bottom: 20px;
          }
        }
        .over2{

            overflow:auto;
            padding-bottom: 20px;
        }
        .ui-widget.ui-widget-content {
            z-index: 9999!important;
        }

        .ui-sortable-handle{
            cursor: move !important;
        }

        .table td{
            vertical-align: middle !important;
        }
    </style>
    <script src="{{asset('template/vendors/jquery/dist/jquery.min.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

    <!-- MultiSelect -->
    <script src="{{ asset('template/admin/js/bootstrap-multiselect.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('template/admin/css/bootstrap-multiselect.css') }}">

</head>

<body class="nav-md">
<div class="container body">
  <div class="main_container">
    <div class="col-md-3 left_col">
      <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
          <a href="{{url('')}}" class="site_title"> <span><?php echo web_name();?></span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <!-- <div class="profile clearfix">
          <div class="profile_pic">
            <img src="{{ asset('assets/img/ava.png') }}" alt="..." class="img-circle profile_img">
          </div>
          <div class="profile_info">
            <span>Welcome,</span>
            <h2>{{auth::user()->user_fullname}}</h2>
          </div>
        </div> -->
        <!-- /menu profile quick info -->

        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
          <div class="menu_section">
            <!-- <h3>General</h3> -->
            <ul class="nav side-menu">
                <!-- <?php #echo access_menu_backend(); ?> -->
                <ul class="nav side-menu" style="">

                    <li><a href="{{ url('') }}/backend/dashboard"><i class="fa fa-home"></i>Dashboard</a>
                    </li>
                    <!-- <li>
                        <a href="{{ url('') }}/backend/page"><i class="fa fa-columns"></i> Page Management </a>

                    </li> -->
                    <li>
                        <a><i class="fa fa-cube"></i> Product Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('') }}/backend/product">Products</a></li>
                            <li><a href="{{ url('') }}/backend/product-category">Category</a></li>
                            <!-- <li><a href="{{ url('') }}/backend/brand">Brand</a></li> -->
                        </ul>
                    </li>
                    <li>
                        <a><i class="fa fa-cube"></i> Stock Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('') }}/backend/product-best-seller?showed=10">Best Seller</a></li>
                            <li><a href="{{ url('') }}/backend/product-low-stock?remaining=5">Low Stock</a></li>
                            <li><a href="{{ url('') }}/backend/product-sold-out">Sold Out</a></li>
                        </ul>
                    </li>

                    <?php $websetting = DB::table('cms_config')->first(); ?>
                    @if($websetting->type == 'ecommerce')
                    <li>
                        <a><i class="fa fa-shopping-bag"></i> Order Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('') }}/backend/recent-order">Recent Order</a></li>
                            <li><a href="{{ url('') }}/backend/history-order">History Order</a></li>
                            <li><a href="{{ url('') }}/backend/report-order">Report</a></li>
                        </ul>
                    </li>
                    @endif
                    <li>
                        <a><i class="fa fa-th-large"></i> Modules <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{ url('') }}/backend/slider">Slideshow</a>
                            </li>
                            <!-- <li>
                                <a href="{{ url('') }}/backend/content">Blog</a>
                            </li> -->
                            <li>
                                <a href="{{ url('') }}/backend/banner">Banner</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/gallery">Gallery</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/shipping">Shipping</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/module-opt/midtrans">Midtrans</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/module-opt/instagram">Instagram</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/module-opt/aboutus">About Us</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/module-opt/mail">Mail</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/module-opt/shipping">Shipping Info</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/module-opt/returnpolicy">Return & Refund Policy</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a><i class="fa fa-television"></i> Preferences <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">

                            <li>
                                <a href="{{ url('') }}/backend/bank">Bank Management</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/social-media">Social Media</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/contact">Contact Us</a>
                            </li>
                            <!-- <li>
                                <a href="{{ url('') }}/backend/subscribers">Subscribers</a>
                            </li> -->

                        </ul>
                    </li>
                    <li>
                        <a><i class="fa fa-television"></i> Voucher Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">

                            <li>
                                <a href="{{ url('') }}/backend/voucher">Voucher List</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/voucher-log">Voucher Log</a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li>
                        <a><i class="fa fa-gear"></i> Jurnal Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{ url('') }}/backend/jurnal-intro">Introduction</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/jurnal-access">Access Token</a>
                            </li>
                        </ul>
                    </li> -->
                    <li>
                        <a href="{{ url('') }}/backend/frontend-menu"><i class="fa fa-list"></i> Menu Management </a>

                    </li>
                    <li>
                        <a href="{{ url('') }}/backend/site-config"><i class="fa fa-gears"></i> Site Configuration</a>
                    </li>
                    <li>
                        <a><i class="fa fa-user"></i> User Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{ url('') }}/backend/users">Admin</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/customer-list">Member</a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li>
                        <a><i class="fa fa-gear"></i> Website Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{ url('') }}/backend/themes-setting">Theme Setting</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/themes-module">Theme Module</a>
                            </li>
                            <li>
                                <a href="{{ url('') }}/backend/themes-pages">Theme Pages</a>
                            </li>
                        </ul>
                    </li> -->
                </ul>
            </ul>
          </div>


        </div>
        <!-- /sidebar menu -->

      </div>
    </div>

    <!-- top navigation -->
    <div class="top_nav">
      <div class="nav_menu">
        <nav>
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>

          <ul class="nav navbar-nav navbar-right">
            <li class="">
              <a href="javascript:void(0)" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('assets/img/ava.png') }}" alt="">{{auth::user()->user_fullname}}
                <span class=" fa fa-angle-down"></span>
              </a>
              <ul class="dropdown-menu dropdown-usermenu pull-right">
                <li><a href="{{url('backend/myprofile')}}">My Profile</a></li>
                <li><a href="{{url('backend/change-password')}}">Change Password</a></li>
                <li><a href="{{url('backend/logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
              </ul>
            </li>

            <!-- <li role="presentation" class="dropdown">
              <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-envelope-o"></i>
                <span class="badge bg-green">6</span>
              </a>
              <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                <li>
                  <a>
                    <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                    <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                    <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                  </a>
                </li>
                <li>
                  <a>
                    <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                    <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                    <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                  </a>
                </li>
                <li>
                  <a>
                    <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                    <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                    <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                  </a>
                </li>
                <li>
                  <a>
                    <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                    <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                    <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                  </a>
                </li>
                <li>
                  <div class="text-center">
                    <a>
                      <strong>See All Alerts</strong>
                      <i class="fa fa-angle-right"></i>
                    </a>
                  </div>
                </li>
              </ul>
            </li> -->
          </ul>
        </nav>
      </div>
    </div>
    <!-- /top navigation -->

    <!-- content -->
    <!-- page content -->
    <div class="right_col" role="main">
      @yield('content')
    </div>
    <!-- / end content-->

    <!-- footer content -->
    <footer>
      <div class="pull-right">
        Admistrator - <?php echo web_name();?></a>
      </div>
      <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->
  </div>
</div>


<!--START BAWAAN TEMPLATE -->
<!-- jQuery -->

<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<!-- Bootstrap -->
<script src="{{asset('template/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('template/vendors/fastclick/lib/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{asset('template/vendors/nprogress/nprogress.js')}}"></script>
<!-- Chart.js -->
<script src="{{asset('template/vendors/Chart.js/dist/Chart.min.js')}}"></script>
<!-- gauge.js -->
<script src="{{asset('template/vendors/gauge.js/dist/gauge.min.js')}}"></script>
<!-- bootstrap-progressbar -->
<script src="{{asset('template/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('template/vendors/iCheck/icheck.min.js')}}"></script>
<!-- Skycons -->
<script src="{{asset('template/vendors/skycons/skycons.js')}}"></script>
<!-- Flot -->
<script src="{{asset('template/vendors/Flot/jquery.flot.js')}}"></script>
<script src="{{asset('template/vendors/Flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('template/vendors/Flot/jquery.flot.time.js')}}"></script>
<script src="{{asset('template/vendors/Flot/jquery.flot.stack.js')}}"></script>
<script src="{{asset('template/vendors/Flot/jquery.flot.resize.js')}}"></script>
<!-- Flot plugins -->
<script src="{{asset('template/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
<script src="{{asset('template/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
<script src="{{asset('template/vendors/flot.curvedlines/curvedLines.js')}}"></script>
<!-- DateJS -->
<script src="{{asset('template/vendors/DateJS/build/date.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('template/vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
<script src="{{asset('template/vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
<script src="{{asset('template/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{asset('template/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{asset('template/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

<!-- Custom Theme Scripts -->
<script src="{{asset('template/build/js/custom.min.js')}}"></script>

<!-- Datatables -->
<script src="{{asset('template/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('template/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('template/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('template/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('template/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('template/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('template/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('template/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('template/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('template/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('template/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
<!-- <script src="{{asset('template/vendors/datatables.net-scroller/js/datatables.scroller.min.js')}}"></script> -->
<script src="{{asset('template/vendors/jszip/dist/jszip.min.js')}}"></script>
<script src="{{asset('template/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('template/vendors/pdfmake/build/vfs_fonts.js')}}"></script>


<!-- END BAWAAN TEMPLATE -->

<!-- bootstrap-daterangepicker -->
<script src="{{asset('template/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap-wysiwyg -->
<script src="{{asset('template/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js')}}"></script>
<script src="{{asset('template/vendors/jquery.hotkeys/jquery.hotkeys.js')}}"></script>
<script src="{{asset('template/vendors/google-code-prettify/src/prettify.js')}}"></script>
<!-- jQuery Tags Input -->
<script src="{{asset('template/vendors/jquery.tagsinput/src/jquery.tagsinput.js')}}"></script>
<!-- Switchery -->
<script src="{{asset('template/vendors/switchery/dist/switchery.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('template/vendors/select2/dist/js/select2.full.min.js')}}"></script>
<!-- Parsley -->
<script src="{{asset('template/vendors/parsleyjs/dist/parsley.min.js')}}"></script>
<!-- Autosize -->
<script src="{{asset('template/vendors/autosize/dist/autosize.min.js')}}"></script>
<!-- jQuery autocomplete -->
<script src="{{asset('template/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js')}}"></script>
<!-- starrr -->
<script src="{{asset('template/vendors/starrr/dist/starrr.js')}}"></script>

<!--Text Editor-->

  <script src="{{ asset('assets/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<!--Price format-->
<!-- <script src="{{ asset('admin/plugins/priceformat/jquery.price_format.2.0.js') }}"></script> -->

<script type="text/javascript" src="{{ asset('/assets/fancybox/jquery.fancybox.pack.js')}}"></script>
<script type="text/javascript" src="{{ asset('/assets/filemanager/js/script.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/jquery.price_format.2.0.js') }}"></script>
<!-- ALERT DELETE-->
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<!-- select bootstrap-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
<script src="{{ asset('assets/js/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- Js Meta Tag -->
<!-- <script src="{{asset('assets/js/tag/tag-it.js') }}" type="text/javascript" charset="utf-8"></script> -->

<!--select2-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>\


<!-- bootstrap color picker -->
<script src="{{ asset('template/admin/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<!-- bootstrap date picker -->
<!-- <script src="{{ asset('template/admin//datepicker/bootstrap-datepicker.js') }}"></script> -->

 <script type="text/javascript">
       $(document).ready(function() {
           $('#multiselect2').multiselect({
               enableClickableOptGroups: true,
               enableCollapsibleOptGroups: true,
               enableFiltering: true,
               includeSelectAllOption:true,
               maxHeight: 350
           });
       });
 </script>

 <script type="text/javascript">
 $(".select2").select2(
     {
       placeholder: "Select One",
       allowClear: true
     }
     );
 </script>

 <script type="text/javascript">
 $(".select2pro").select2(
     {
       placeholder: "Select products",
       allowClear: true
     }
     );
 </script>

 <script type="text/javascript">
 $(".select2cat").select2(
     {
       placeholder: "Select categories",
       allowClear: true
     }
     );
 </script>

 <script type="text/javascript">
 $(".select2bra").select2(
     {
       placeholder: "Select brands",
       allowClear: true
     }
     );
 </script>
<script type="text/javascript">
    $(document).ready(function() {
      $(".js-example-basic-single").select2();
    });
</script>
<script>
    //Price Format
    $('.price_format').priceFormat();
</script>

<script type="text/javascript">
  i=0;

  $('#trigger1').click(function(){
    j=++i;

    $('#var'+j).removeClass('hidden');
  });

  $('#deltrigger1').click(function(){
    $('#var'+j).remove();
  });
</script>


<script type="text/javascript">
  tinymce.init({
    selector: '.texteditor',
    plugins      : ["advlist autolink lists textcolor link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste responsivefilemanager"],
    toolbar      : "insertfile undo redo | styleselect fontsizeselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager",
    image_advtab : true,
    relative_urls: false,

    external_filemanager_path:"{!! str_finish(asset('assets/filemanager'),'/') !!}",
    filemanager_title        :"File Manager" , // bisa diganti terserah anda
    external_plugins         : { "filemanager" : "{{ asset('assets/filemanager/plugin.min.js') }}"},
    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 20pt 22pt 24pt 30pt 36pt',
    height:480
  });

</script>
<script type="text/javascript">
  tinymce.init({
    selector: '.texteditordetail',
    plugins      : ["advlist autolink lists textcolor link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste responsivefilemanager"],
    toolbar      : "insertfile undo redo | styleselect fontsizeselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager",
    image_advtab : true,
    relative_urls: false,

    external_filemanager_path:"{!! str_finish(asset('assets/filemanager'),'/') !!}",
    filemanager_title        :"File Manager" , // bisa diganti terserah anda
    external_plugins         : { "filemanager" : "{{ asset('assets/filemanager/plugin.min.js') }}"},
    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 20pt 22pt 24pt 30pt 36pt',
    height:150
  });
</script>
<script type="text/javascript">
  tinymce.init({
    selector: '.texteditorspek',
    plugins      : ["advlist autolink lists textcolor link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste responsivefilemanager"],
    toolbar      : "insertfile undo redo | styleselect fontsizeselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager",
    image_advtab : true,
    relative_urls: false,

    external_filemanager_path:"{!! str_finish(asset('assets/filemanager'),'/') !!}",
    filemanager_title        :"File Manager" , // bisa diganti terserah anda
    external_plugins         : { "filemanager" : "{{ asset('assets/filemanager/plugin.min.js') }}"},
    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 20pt 22pt 24pt 30pt 36pt',
    height:150
  });
</script>

<!-- Date TWO / Range  -->
<script type="text/javascript">
    $(function () {
        $("#txtFrom").datepicker({
            numberOfMonths: 2,
            dateFormat: 'yy/mm/dd',
            onSelect: function (selected) {
                var dt = new Date(selected);
                dt.setDate(dt.getDate() + 1);
                $("#txtTo").datepicker("option", "minDate", dt);
            }


        });
        $("#txtTo").datepicker({
            numberOfMonths: 2,
            dateFormat: 'yy/mm/dd',
            onSelect: function (selected) {
                var dt = new Date(selected);
                dt.setDate(dt.getDate() - 1);
                $("#txtFrom").datepicker("option", "maxDate", dt);
            }
        });
    });
</script>

<script>
$(document).ready(function(){
  $('.button-toggle').click(function(){
    $('#togglepass').toggle();
  });
});
</script>
<script>
$(document).ready(function(){
  $('#button-composer').click(function(){
    $('#newemail').toggle();
  });
});
</script>
<script type="text/javascript">
    $("#dimensionTable").on('change', function () {
        var length = $('#lengthVal').val();
        var width = $('#widthVal').val();
        var height = $('#heightVal').val();
        //alert(length,width,height);
        var volume = length * width * height;
        //alert(volume);
        $('#volumeVal').val(volume);
    });
</script>

<script>
    $("#title").on('keyup', function() {
        var repl = $('#title').val().replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '').toLowerCase();
        var rep2 = repl.replace(/\s+/gi, '-').toLowerCase();
        $('#url').val(rep2);
        var full_url = "{{url('')}}/pages/"+rep2;

        $('#full-url').html(full_url);
    });
</script>

<script>
    $("#title2").on('keyup', function() {
        var repl = $('#title2').val().replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '').toLowerCase();
        var rep2 = repl.replace(/\s+/gi, '-').toLowerCase();
        $('#url2').val(rep2);
        var full_url = "{{url('')}}/pages/"+rep2;

        $('#full-url2').html(full_url);
    });
</script>
  <script>
      $(document).ready(function(){

        $('.selectpicker').selectpicker({
          style: '',
          size: 10,
        });

      });
    </script>
  <script>
      $('.iframe-btn').fancybox({

          'width'		: 1261,
          'height'	: 600,
          'type'		: 'iframe',
          'autoScale'    	: false
      });
  </script>

<script>
    function responsive_filemanager_callback(field_id){

        var image=$('#'+field_id).val();
        $('#'+"view"+field_id).attr('src',image);

        var image2=$('#'+field_id).val();
        $('#'+"view"+field_id).attr('src',image2);

        $('fancybox-wrap').hide(750);
        $('#fancybox-overlay').hide(750);

    };
</script>
<!--BAWAHAN TEMPLATE -->

<!-- Datatables -->
<script>
    $(document).ready(function() {
        var handleDataTableButtons = function() {
            if ($("#datatable-buttons").length) {
                $("#datatable-buttons").DataTable({
                    dom: "Bfrtip",
                    buttons: [
                        {
                            extend: "copy",
                            className: "btn-sm"
                        },
                        {
                            extend: "csv",
                            className: "btn-sm"
                        },
                        {
                            extend: "excel",
                            className: "btn-sm"
                        },
                        {
                            extend: "pdfHtml5",
                            className: "btn-sm"
                        },
                        {
                            extend: "print",
                            className: "btn-sm"
                        },
                    ],
                    responsive: true
                });
            }
        };

        TableManageButtons = function() {
            "use strict";
            return {
                init: function() {
                    handleDataTableButtons();
                }
            };
        }();

        $('#datatable').dataTable();
        $('.table-bordered').dataTable();


        $('#datatable-keytable').DataTable({
            keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
            ajax: "js/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });

        $('#datatable-fixed-header').DataTable({
            fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

            $datatable.dataTable({
            'order': [[ 1, 'desc' ]],
            'columnDefs': [
                { orderable: false, targets: [0] }
            ]
        });
        $datatable.on('draw.dt', function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_flat-green'
            });
        });

        TableManageButtons.init();
    });
</script>
<!-- /Datatables -->

<!-- /gauge.js -->
<!-- bootstrap-daterangepicker -->
<script>
    // $(document).ready(function() {
        $('#datepicker').daterangepicker({
          locale: {
              format: 'YYYY/MM/DD',
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

    // });
</script>
<!-- /bootstrap-daterangepicker -->

<!-- bootstrap-wysiwyg -->
<script>
    $(document).ready(function() {
        function initToolbarBootstrapBindings() {
            var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                    'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                    'Times New Roman', 'Verdana'
                ],
                fontTarget = $('[title=Font]').siblings('.dropdown-menu');
            $.each(fonts, function(idx, fontName) {
                fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
            });
            $('a[title]').tooltip({
                container: 'body'
            });
            $('.dropdown-menu input').click(function() {
                return false;
            })
                .change(function() {
                    $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
                })
                .keydown('esc', function() {
                    this.value = '';
                    $(this).change();
                });

            $('[data-role=magic-overlay]').each(function() {
                var overlay = $(this),
                    target = $(overlay.data('target'));
                overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
            });

            if ("onwebkitspeechchange" in document.createElement("input")) {
                var editorOffset = $('#editor').offset();

                $('.voiceBtn').css('position', 'absolute').offset({
                    top: editorOffset.top,
                    left: editorOffset.left + $('#editor').innerWidth() - 35
                });
            } else {
                $('.voiceBtn').hide();
            }
        }

        function showErrorAlert(reason, detail) {
            var msg = '';
            if (reason === 'unsupported-file-type') {
                msg = "Unsupported format " + detail;
            } else {
                console.log("error uploading file", reason, detail);
            }
            $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }

        initToolbarBootstrapBindings();

        $('#editor').wysiwyg({
            fileUploadError: showErrorAlert
        });

        window.prettyPrint;
        prettyPrint();
    });
</script>
<!-- /bootstrap-wysiwyg -->

<!-- Select2 -->
<script>
    $(document).ready(function() {
        $(".select2_single").select2({
            placeholder: "Select a state",
            allowClear: true
        });
        $(".select2_group").select2({});
        $(".select2_multiple").select2({
            maximumSelectionLength: 4,
            placeholder: "With Max Selection limit 4",
            allowClear: true
        });
    });
</script>
<!-- /Select2 -->

<!-- jQuery Tags Input -->
<script>
    function onAddTag(tag) {
        alert("Added a tag: " + tag);
    }

    function onRemoveTag(tag) {
        alert("Removed a tag: " + tag);
    }

    function onChangeTag(input, tag) {
        alert("Changed a tag: " + tag);
    }

    $(document).ready(function() {
        $('#tags_1').tagsInput({
            width: 'auto'
        });
    });
</script>
<!-- /jQuery Tags Input -->

<!-- Parsley -->
<script>
    // $(document).ready(function() {
    //     $.listen('parsley:field:validate', function() {
    //         validateFront();
    //     });
    //     $('#demo-form .btn').on('click', function() {
    //         $('#demo-form').parsley().validate();
    //         validateFront();
    //     });
    //     var validateFront = function() {
    //         if (true === $('#demo-form').parsley().isValid()) {
    //             $('.bs-callout-info').removeClass('hidden');
    //             $('.bs-callout-warning').addClass('hidden');
    //         } else {
    //             $('.bs-callout-info').addClass('hidden');
    //             $('.bs-callout-warning').removeClass('hidden');
    //         }
    //     };
    // });

    $(document).ready(function() {
        $.listen('parsley:field:validate', function() {
            validateFront();
        });
        $('#demo-form2 .btn').on('click', function() {
            $('#demo-form2').parsley().validate();
            validateFront();
        });
        var validateFront = function() {
            if (true === $('#demo-form2').parsley().isValid()) {
                $('.bs-callout-info').removeClass('hidden');
                $('.bs-callout-warning').addClass('hidden');
            } else {
                $('.bs-callout-info').addClass('hidden');
                $('.bs-callout-warning').removeClass('hidden');
            }
        };
    });
    try {
        hljs.initHighlightingOnLoad();
    } catch (err) {}
</script>
<!-- /Parsley -->

<!-- Autosize -->
<script>
    $(document).ready(function() {
        autosize($('.resizable_textarea'));
    });
</script>
<!-- /Autosize -->

<!-- jQuery autocomplete -->
<script>
    $(document).ready(function() {
        var countries = { AD:"Andorra",A2:"Andorra Test",AE:"United Arab Emirates",AF:"Afghanistan",AG:"Antigua and Barbuda",AI:"Anguilla",AL:"Albania",AM:"Armenia",AN:"Netherlands Antilles",AO:"Angola",AQ:"Antarctica",AR:"Argentina",AS:"American Samoa",AT:"Austria",AU:"Australia",AW:"Aruba",AX:"Åland Islands",AZ:"Azerbaijan",BA:"Bosnia and Herzegovina",BB:"Barbados",BD:"Bangladesh",BE:"Belgium",BF:"Burkina Faso",BG:"Bulgaria",BH:"Bahrain",BI:"Burundi",BJ:"Benin",BL:"Saint Barthélemy",BM:"Bermuda",BN:"Brunei",BO:"Bolivia",BQ:"British Antarctic Territory",BR:"Brazil",BS:"Bahamas",BT:"Bhutan",BV:"Bouvet Island",BW:"Botswana",BY:"Belarus",BZ:"Belize",CA:"Canada",CC:"Cocos [Keeling] Islands",CD:"Congo - Kinshasa",CF:"Central African Republic",CG:"Congo - Brazzaville",CH:"Switzerland",CI:"Côte d’Ivoire",CK:"Cook Islands",CL:"Chile",CM:"Cameroon",CN:"China",CO:"Colombia",CR:"Costa Rica",CS:"Serbia and Montenegro",CT:"Canton and Enderbury Islands",CU:"Cuba",CV:"Cape Verde",CX:"Christmas Island",CY:"Cyprus",CZ:"Czech Republic",DD:"East Germany",DE:"Germany",DJ:"Djibouti",DK:"Denmark",DM:"Dominica",DO:"Dominican Republic",DZ:"Algeria",EC:"Ecuador",EE:"Estonia",EG:"Egypt",EH:"Western Sahara",ER:"Eritrea",ES:"Spain",ET:"Ethiopia",FI:"Finland",FJ:"Fiji",FK:"Falkland Islands",FM:"Micronesia",FO:"Faroe Islands",FQ:"French Southern and Antarctic Territories",FR:"France",FX:"Metropolitan France",GA:"Gabon",GB:"United Kingdom",GD:"Grenada",GE:"Georgia",GF:"French Guiana",GG:"Guernsey",GH:"Ghana",GI:"Gibraltar",GL:"Greenland",GM:"Gambia",GN:"Guinea",GP:"Guadeloupe",GQ:"Equatorial Guinea",GR:"Greece",GS:"South Georgia and the South Sandwich Islands",GT:"Guatemala",GU:"Guam",GW:"Guinea-Bissau",GY:"Guyana",HK:"Hong Kong SAR China",HM:"Heard Island and McDonald Islands",HN:"Honduras",HR:"Croatia",HT:"Haiti",HU:"Hungary",ID:"Indonesia",IE:"Ireland",IL:"Israel",IM:"Isle of Man",IN:"India",IO:"British Indian Ocean Territory",IQ:"Iraq",IR:"Iran",IS:"Iceland",IT:"Italy",JE:"Jersey",JM:"Jamaica",JO:"Jordan",JP:"Japan",JT:"Johnston Island",KE:"Kenya",KG:"Kyrgyzstan",KH:"Cambodia",KI:"Kiribati",KM:"Comoros",KN:"Saint Kitts and Nevis",KP:"North Korea",KR:"South Korea",KW:"Kuwait",KY:"Cayman Islands",KZ:"Kazakhstan",LA:"Laos",LB:"Lebanon",LC:"Saint Lucia",LI:"Liechtenstein",LK:"Sri Lanka",LR:"Liberia",LS:"Lesotho",LT:"Lithuania",LU:"Luxembourg",LV:"Latvia",LY:"Libya",MA:"Morocco",MC:"Monaco",MD:"Moldova",ME:"Montenegro",MF:"Saint Martin",MG:"Madagascar",MH:"Marshall Islands",MI:"Midway Islands",MK:"Macedonia",ML:"Mali",MM:"Myanmar [Burma]",MN:"Mongolia",MO:"Macau SAR China",MP:"Northern Mariana Islands",MQ:"Martinique",MR:"Mauritania",MS:"Montserrat",MT:"Malta",MU:"Mauritius",MV:"Maldives",MW:"Malawi",MX:"Mexico",MY:"Malaysia",MZ:"Mozambique",NA:"Namibia",NC:"New Caledonia",NE:"Niger",NF:"Norfolk Island",NG:"Nigeria",NI:"Nicaragua",NL:"Netherlands",NO:"Norway",NP:"Nepal",NQ:"Dronning Maud Land",NR:"Nauru",NT:"Neutral Zone",NU:"Niue",NZ:"New Zealand",OM:"Oman",PA:"Panama",PC:"Pacific Islands Trust Territory",PE:"Peru",PF:"French Polynesia",PG:"Papua New Guinea",PH:"Philippines",PK:"Pakistan",PL:"Poland",PM:"Saint Pierre and Miquelon",PN:"Pitcairn Islands",PR:"Puerto Rico",PS:"Palestinian Territories",PT:"Portugal",PU:"U.S. Miscellaneous Pacific Islands",PW:"Palau",PY:"Paraguay",PZ:"Panama Canal Zone",QA:"Qatar",RE:"Réunion",RO:"Romania",RS:"Serbia",RU:"Russia",RW:"Rwanda",SA:"Saudi Arabia",SB:"Solomon Islands",SC:"Seychelles",SD:"Sudan",SE:"Sweden",SG:"Singapore",SH:"Saint Helena",SI:"Slovenia",SJ:"Svalbard and Jan Mayen",SK:"Slovakia",SL:"Sierra Leone",SM:"San Marino",SN:"Senegal",SO:"Somalia",SR:"Suriname",ST:"São Tomé and Príncipe",SU:"Union of Soviet Socialist Republics",SV:"El Salvador",SY:"Syria",SZ:"Swaziland",TC:"Turks and Caicos Islands",TD:"Chad",TF:"French Southern Territories",TG:"Togo",TH:"Thailand",TJ:"Tajikistan",TK:"Tokelau",TL:"Timor-Leste",TM:"Turkmenistan",TN:"Tunisia",TO:"Tonga",TR:"Turkey",TT:"Trinidad and Tobago",TV:"Tuvalu",TW:"Taiwan",TZ:"Tanzania",UA:"Ukraine",UG:"Uganda",UM:"U.S. Minor Outlying Islands",US:"United States",UY:"Uruguay",UZ:"Uzbekistan",VA:"Vatican City",VC:"Saint Vincent and the Grenadines",VD:"North Vietnam",VE:"Venezuela",VG:"British Virgin Islands",VI:"U.S. Virgin Islands",VN:"Vietnam",VU:"Vanuatu",WF:"Wallis and Futuna",WK:"Wake Island",WS:"Samoa",YD:"People's Democratic Republic of Yemen",YE:"Yemen",YT:"Mayotte",ZA:"South Africa",ZM:"Zambia",ZW:"Zimbabwe",ZZ:"Unknown or Invalid Region" };

        var countriesArray = $.map(countries, function(value, key) {
            return {
                value: value,
                data: key
            };
        });

        // initialize autocomplete with custom appendTo
        $('#autocomplete-custom-append').autocomplete({
            lookup: countriesArray
        });
    });
</script>
<!-- /jQuery autocomplete -->

<!-- Starrr -->
<script>
    $(document).ready(function() {
        $(".stars").starrr();

        $('.stars-existing').starrr({
            rating: 4
        });

        $('.stars').on('starrr:change', function (e, value) {
            $('.stars-count').html(value);
        });

        $('.stars-existing').on('starrr:change', function (e, value) {
            $('.stars-count-existing').html(value);
        });
    });
</script>
<!-- /Starrr -->

<!-- ADD CATEGORY -->
<script type="text/javascript">

</script>

<!-- ADD VARIANT -->
<script>
    //  $(document).ready(function(){
          var z=0;
          $('#addvarian').click(function(){
               $('#dynamic_field_varian').append(   '<tr id="row'+z+'">'+
                                                        '<td>'+
                                                            '<input type="text" class="form-control" name="size[]" id="varsize'+z+'">'+
                                                        '</td>'+
                                                        '<td>'+
                                                            '<input type="text" class="form-control" id="varcolor'+z+'" name="color[]" >'+
                                                        '</td>'+
                                                        '<td>'+
                                                            '<input type="color" class="form-control" name="color_hex[]" id="varhex'+z+'" style="padding:0px;" >'+
                                                        '</td>'+
                                                        '<td>'+
                                                            '<input type="number" class="form-control" name="stock[]" min="0" value="0">'+
                                                        '</td>'+
                                                        '<td width="5%">'+
                                                            '<button type="button" name="remove" id="'+z+'" class="btn btn-sm btn-danger btn_remove">Delete</button>'+
                                                        '</td>'+
                                                    '</tr>');
               z++;
          });
          $(document).on('click', '.btn_remove', function(){
               var button_id = $(this).attr("id");
               $('#row'+button_id+'').remove();
          });

    //  });
</script>

<!-- ADD IMAGE -->
<script>
    //  $(document).ready(function(){
          var i=100;
          $('#add').click(function(){
               $('#dynamic_field').append(  '<tr id="row'+i+'">'+
                                                '<td>'+
                                                    '<img src="" id="viewimgpen'+i+'" width="100" />'+
                                                    '<input type="hidden" readonly name="image['+i+']"class="form-control name_list" id="imgpen'+i+'"/>'+
                                                '</td>'+
                                                '<td width="5%">'+
                                                    '<a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=imgpen')}}'+i+'" class="btn iframe-btn btn btn-sm btn-primary" title="Open">'+
                                                        '<i class="fa fa-camera"></i> Image'+
                                                    '</a>'+
                                                '</td>'+
                                                '<td width="5%" style="text-align:center;">'+
                                                    '<input type="radio" name="primary_image" value="'+i+'"/> Primary'+
                                                '</td>'+
                                                '<td width="5%">'+
                                                    '<button type="button" name="remove" id="'+i+'" class="btn btn-sm btn-danger btn_remove">Delete</button>'+
                                                '</td>'+
                                            '</tr>');
                i++;
          });
          $(document).on('click', '.btn_remove', function(){
               var button_id = $(this).attr("id");
               $('#row'+button_id+'').remove();
          });
     //
    //  });
</script>
</body>
</html>
