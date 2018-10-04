@extends('web.app')
@section('content')


<?php $website = DB::table('cms_config')->first(); ?>
<title>Home | {{ $website->site_name }}</title>

@foreach($html as $htm)
    @include('themes.'.$websetting.'.module.'.$htm)
    <div class="clearfix"></div>
@endforeach

<style media="screen">
#header{
    background-color: transparent;
}
</style>

<!-- ADD-ONS JS FILES -->
<script type="text/javascript">

    // Topbar Hide
    $('#top-bar').on('click','#close-bar',function(){
        $(this).parents('#top-bar').slideUp(300);
        $('body').css('padding-top',0);
    })

    // Custom Carousel
    // $('.owl-carousel').owlCarousel({
    //     items: 1,
    //     dotsContainer: '#item-color-dots',
    //     loop: true,
    // });
</script>

@push('js')
<script type="text/javascript">
if($(window).width() > 425){
    $('.body-content').css('margin-top','0px');
}else {
    $('#header').css('background-color','#fff');
}
</script>

<script type="text/javascript">
    $( window ).scroll(function() {
        if($(window).width() >= 992){
            if ($(this).scrollTop() > 100) {
                $('#logo').css('height','64px');
                $('.header-menu').css('padding','12px 30px');
                $('.sf-js-enabled').find('a').css('margin','12px 15px');
                $('#header-wrap').css('height','auto');
                $('#header').css('height','auto');
                $('#header').css('background-color','#fff');
                $('.top-cart-content').css('top','65px');
            } else {
                $('#logo').css('height','100px');
                $('.header-menu').css('padding','30px 30px');
                $('.sf-js-enabled').find('a').css('margin','30px 15px');
                $('#header-wrap').css('height','100px');
                $('#header').css('height','100px');
                $('#header').css('background-color','transparent');
                $('.top-cart-content').css('top','100px');
            }
        } else if($(window).width() <= 425){
            $('#header').css('background-color','#fff');
        } else {
            if ($(this).scrollTop() > 100) {
                $('#header').css('background-color','#fff');
            } else {
                $('#header').css('background-color','transparent');
            }
        }
    });
</script>
@endpush

@stop
