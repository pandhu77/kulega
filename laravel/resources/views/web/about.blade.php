@extends('web.master')
@section('title','www.kulega.com')
@section('content')

@push('css')
<!-- <link rel="stylesheet" href="{{ asset('templates/web/plugins/OwlCarousel2-2.2.1/dist/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('templates/web/plugins/OwlCarousel2-2.2.1/dist/assets/owl.theme.default.min.css') }}"> -->

<!-- <link rel="stylesheet" href="{{ asset('templates/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/themes/krajee-svg/theme.css') }}"> -->

@endpush
<section class="about-us" style="background-color:#fff;">
  <div class="container">
    <div class="row">
      <div class="col-md-6 pt-50 pb-50">
        <img src="{{ asset($about[1]->value) }}" alt="{{ $about[2]->value }}" class="img-responsive">
      </div>
      <div class="col-md-6 pt-50 pb-50 text-center">
          <h2 style="color:#1ABC9C;">{{ $about[2]->value }}</h2>
          <div class="text" style="color:#9c9c9c;">
            <?= nl2br($about[0]->value) ?>
          </div>
      </div>
    </div>
  </div>
</section>

@push('js')
<!-- <script type="text/javascript" src="{{ asset('templates/web/plugins/OwlCarousel2-2.2.1/dist/owl.carousel.min.js') }}"></script>
<script type="text/javascript">

$(document).on('ready',function(e){
    e.preventDefault();
    $('#main-slide-show .owl-carousel').owlCarousel({
    loop:true,
    // animateOut: 'fadeOut',
    margin:0,
    nav:true,
    dots:true,
    items:1,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>',
              '<i class="fa fa-angle-right" aria-hidden="true"></i>']
  });
});
</script>-->
<!--
<script type="text/javascript" src="{{ asset('templates/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/js/star-rating.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('templates/web/plugins/kartik-v-bootstrap-star-rating-ca43ee3/themes/krajee-svg/theme.min.js') }}"></script> -
<script type="text/javascript">
$(".rating").rating().unbind();
</script> -->
@endpush

@endsection
