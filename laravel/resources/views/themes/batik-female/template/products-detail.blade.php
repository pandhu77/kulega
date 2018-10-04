@extends('web.app')
@section('content')

<?php $website = DB::table('cms_config')->first(); ?>
<title>Shop Detail | {{ $website->site_name }}</title>

<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>{{ $products->prod_name }}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('products') }}">Products</a></li>
            <li class="active">Product Detail</li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->
<?php $getsetting = DB::table('t_theme_setting')->where('active',1)->first(); ?>

<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            @include('themes.'.$getsetting->name.'.module.product-detail')

            <div class="clear"></div><div class="line"></div>

            @include('themes.'.$getsetting->name.'.module.product-related')

        </div>

    </div>

</section><!-- #content end -->

@stop
