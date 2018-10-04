<!-- Slider
============================================= -->

@if($slidersfull[0]->type == 0)
<section id="slider" class="clearfix">

    <div class="owl-carousel owl-theme owl-carousel-slider">
        @foreach($slidersfull as $sli)
            @if($sli->type == 0)
                <div class="item slider-image">
                    <a href="{{ url($sli->url) }}">
                        <img src="{{ asset($sli->image) }}" class="ims-responsive" style="margin:auto;" alt="{{ $sli->title }}">
                    </a>
                </div>
            @endif
        @endforeach
    </div>

</section><!-- #Slider End -->
@elseif($slidersfull[0]->type == 1)

<style media="screen">
    .jumbotron{
        position: relative;
        padding: 0px !important;
    }

    #video-background{
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
        z-index: -100;
        width:100%;
    }
</style>

<div class="jumbotron">
    <video id="video-background" preload muted autoplay loop>
        <source src="http://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
    </video>
</div>
@else
    <iframe style="width:100%;height:100vh;" src="http://www.youtube.com/embed/{{ $slidersfull[0]->url }}?autoplay=1" frameborder="0" allowfullscreen></iframe>
@endif

@push('js')
<script type="text/javascript">
$('.owl-carousel-slider').owlCarousel({
    loop:true,
    margin:10,
    nav:false,
    items:1
})
</script>
@endpush
