@extends('web.app')
@section('content')

<?php $website = DB::table('cms_config')->first(); ?>
<title>Checkout Success | {{ $website->site_name }}</title>

<!-- Content
============================================= -->
<?php $getsetting = DB::table('t_theme_setting')->where('active',1)->first(); ?>

<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            @include('themes.'.$getsetting->name.'.module.checkout-success')

        </div>

    </div>

</section><!-- #content end -->

@stop
