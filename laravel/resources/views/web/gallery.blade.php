@extends('web.master')
@section('title','www.kulega.com')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>

<?php $website = DB::table('cms_config')->first(); ?>

<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Gallery</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="active">Gallery</li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            @foreach($getimage as $image)
            <!-- <div class="col-md-3">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" onclick="getcontent({{ $image->id }})">
                    <img src="{{ url($image->image) }}" alt="{{ $image->title }}">
                </a>
            </div> -->
            <div class="col-xs-6 col-sm-4 col-md-3" style="margin-bottom:20px;">
                <a href="#" data-fancybox="images" data-caption="{{ $image->title }}">
                    <img src="{{ url($image->image) }}" alt="{{ $image->title }}" class="imgprod" style="height:340px;">
                </a>
            </div>
            @endforeach

        </div>

    </div>

</section><!-- #content end -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin:100px auto !important">

    <!-- Modal content-->
    <div class="modal-content" style="border-radius:0px;">
      <div class="modal-header" style="border-bottom:transparent;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Loading...</h4>
      </div>
      <div class="modal-body">
          Loading...
      </div>
    </div>

  </div>
</div>

@push('js')
<script type="text/javascript">

function getcontent(id_image){
    var datapost = {
        '_token'    : '{{ csrf_token() }}',
        'id_image'  : id_image
    }

    $.ajax({
        type:"POST",
        url:"{{ url('module/get-gallery') }}",
        data:datapost,
        dataType:"json",
        beforeSend:function(){
            $('.modal-title').html('Loading...');
            $('.modal-body').html('Loading...');
        },
        success:function(data){
            $('.modal-title').html(data[0]);
            $('.modal-body').html(data[1]);
        }
    })
}

$('.owl-carousel-gallery').owlCarousel({
    loop:false,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:4
        }
    }
});
</script>
@endpush

@stop
