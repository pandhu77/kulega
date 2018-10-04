@extends('web.app')
@section('content')

<?php $website = DB::table('cms_config')->first(); ?>
<title>Home | {{ $website->site_name }}</title>


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
