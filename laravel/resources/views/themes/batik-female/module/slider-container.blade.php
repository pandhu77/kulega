<?php if(count($sliderscontainer) > 0){ ?>

<!-- Slider
============================================= -->
<section id="slider" class="clearfix">

    <div class="container">
        <div class="owl-carousel owl-theme owl-carousel-slider">

                @foreach($sliderscontainer as $sli)
                <div class="item">
                    <a href="{{ url($sli->url) }}">
                        <img src="{{ url($sli->image) }}" class="ims-responsive" style="margin:auto;" alt="{{ $sli->title }}">
                    </a>
                </div>
                @endforeach


        </div>
    </div>

</section><!-- #Slider End -->

<?php } ?>

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
