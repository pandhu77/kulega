@extends('web.app')
@section('content')

<?php $website = DB::table('cms_config')->first(); ?>
<title>About | {{ $website->site_name }}</title>

<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>About</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="active">About</li>
        </ol>
    </div>

</section><!-- #page-title end -->

@foreach($html as $htm)
    @include('themes.'.$websetting.'.module.'.$htm)
@endforeach

<!-- ADD-ONS JS FILES -->
<script type="text/javascript">

    // Topbar Hide
    $('#top-bar').on('click','#close-bar',function(){
        $(this).parents('#top-bar').slideUp(300);
        $('body').css('padding-top',0);
    })

    // Custom Carousel
    $('.owl-carousel').owlCarousel({
        items: 1,
        dotsContainer: '#item-color-dots',
        loop: true,
    });
</script>

@stop
