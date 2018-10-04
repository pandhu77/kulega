@extends('web.app')
@section('content')

<?php $website = DB::table('cms_config')->first(); ?>
<title>Checkout | {{ $website->site_name }}</title>

<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Checkout</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('products') }}">Shop</a></li>
            <li class="active">Checkout</li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->
<?php $getsetting = DB::table('t_theme_setting')->where('active',1)->first(); ?>

<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            @include('themes.'.$getsetting->name.'.module.checkout-billship')

        </div>

    </div>

</section><!-- #content end -->

@stop
