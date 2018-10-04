
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>

<div class="section clearfix"  style="background-color:white;margin-top:0px;">
    <div class="container clearfix">

        <div class="heading-block nobottomborder center">
            <h3 class="t400" style="font-size: 16px;">Gallery</h3>
        </div>

        <div class="row clearfix">
            <div class="owl-carousel owl-theme owl-carousel-gallery" id="gallery-slider">

            @foreach($galleryfullcolumn4 as $key => $gallery)
                <div class="item">
                    <a href="{{ url($gallery->image) }}" data-fancybox="images" data-caption="{{ $gallery->title }}">
                        <img src="{{ url($gallery->image) }}" alt="{{ $gallery->title }}">
                    </a>
                </div>
                <!-- <div class="item">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" onclick="getcontent({{ $gallery->id }})">
                        <img src="{{ url($gallery->image) }}" alt="{{ $gallery->title }}">
                    </a>
                </div> -->
            @endforeach

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
