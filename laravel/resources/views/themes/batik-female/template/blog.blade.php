@extends('web.app')
@section('content')

<?php $website = DB::table('cms_config')->first(); ?>
<title>Blog | {{ $website->site_name }}</title>

<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Blog</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="active">Blog</li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->

<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            @foreach($html as $htm)
                @include('themes.'.$websetting.'.module.'.$htm)
                <div class="clearfix"></div>
            @endforeach

        </div>

    </div>

</section><!-- #content end -->

@stop
