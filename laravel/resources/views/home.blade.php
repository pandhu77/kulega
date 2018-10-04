@extends('app')
@section('meta-description',web_meta())
@section('content')
<link rel="stylesheet" href="{{asset('template/frontend/homes.css')}}" type="text/css" />
<title>{{web_name()}} | Home</title>
<div class="container">
    <div class="col-md-12" >
        @if(Session::get('success'))
        <div class="alert alert-success">
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            {{ Session::get('success') }}
        </div>
        @endif
    </div>
    <div class="col-md-12">
        @if(Session::get('signupsuccess'))
        <div class="alert alert-success">
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            {{ Session::get('signupsuccess') }}
        </div>
        @endif
        <!-- Begin.slider -->
        <div class="slider">
            <div class="slide_viewer">
                <div class="slide_group">
                    @foreach($slider as $sliders)
                    <div class="slide">
                        <div class="slide-images" style="background-image:url({{$sliders->image}});overflow:hidden;">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div><!-- End // .slider -->
        <div class="slide_buttons">
        </div>
    </div>
    <!-- Bengin Category -->
	@foreach($categ as $category)
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 " style="margin-top: 20px; height:250px; overflow:hidden;">
		<div class="hovereffect" style="background-image:url({{$category->kateg_image}});overflow:hidden;">
			<div class="hover-produk" style="height:250px; overflow:hidden;">
				<div class="judul-kat">
					<h3 style="color: white; font-weight: bold;">{{$category->kateg_name}}</h3>
					<a class="info" href="{{url('product/'.$category->kateg_url)}}">SHOP NOW</a>
				</div>
			</div>
		</div>
	</div>
	@endforeach
    <!-- End // .Category -->
    <!-- Begin Product -->
	<div class="col-lg-12  col-sm-12 col-xs-12">
		<h2 class="judul-kategori">{{$site->title_product}}</h2>
	</div>

	@foreach($prod as $product)
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6" style="margin-top: 20px;">
        <div class="hovereffect" style="background-image:url({{$product->front_image}});overflow:hidden;">
            <div class="hover-produk1" style="">
                <div class="judul-kat1">
                    <p style="color: white; font-weight: bold;">{{$product->prod_title}}</p>
                    <a class="info" href="{{url('product-detail/'.$product->prod_url)}}">SHOP NOW</a>
                </div>
            </div>
            <div class="diskon">
                <span style="position: relative; top: -30px; right: 0px; font-size: 12px;"><b>SALE</b></span>
            </div>
        </div>
    </div>
	@endforeach

	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6" style="">
		<div class="hovereffect" style="height:250px; overflow:hidden;">
			<div class="load-more" style="padding-top: 30px;">
				<div class="judul-kat1">
					<a class="load-red btn btn-danger" style="border-radius: 0px;" href="{{url('products')}}">LOAD MORE</a>
				</div>
			</div>
		</div>
	</div>
    <!-- End // .Product -->
    <!-- Begin Brand -->
	<div class="col-lg-12 col-sm-12 col-xs-12">
		<h2 class="judul-kategori">{{$site->title_brand}}</h2>
	</div>
    <div class="col-lg-12">
        @foreach($brand as $brands)
        <div class="col-md-6 col-brand" style="" >
            <a href="{{url('brand/'.$brands->brand_url)}}"><img src="{{asset($brands->brand_logo)}}" alt="" style="width: 100%;"></a>
        </div>
        @endforeach
        <div class="col-lg-12" style="margin-top: 50px; text-align: center;">
            <a class="read-more" href="{{url('brand')}}">SHOP NOW</a>
        </div>
    </div>
    <!-- End // Brand -->
    <!-- Begin Blog -->
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <h2 class="judul-kategori">{{$site->title_blog}}</h2>
    </div>
    <div class="col-lg-12">
        @foreach($blog as $blogs)
        <div class="col-md-4">
            <a href="{{url('blog/'.$blogs->kateg_url.'/'.$blogs->url)}}">
                <div class="card">
                    <div class="date">
                        <?php echo date('d F y',strtotime( $blogs->created_at));?>
                    </div>
                    <div class="hovereffect-blog" style="background-image:url({{asset($blogs->image)}});"> </div>
                    <div class="isi-card">
                        <div class="col-md-12" style="text-align: center;">
                            <?php $tag= explode(",",$blogs->tags);?>
                            @foreach($tag as $tags)
                            <a href="{{url('blog/tags/'.$tags)}}" class="label label-default" style="background-color:#b2203d;"> <?php echo "#".$tags;?></a>
                            @endforeach
                        </div>
                        <div class="title-card">{{$blogs->title}}</div>
                        <div class="col-md-3 col-xs-3 detail">
                            <span>
                                <i class="fa fa-folder-open-o" aria-hidden="true"></i> {{$blogs->view}}
                            </span>
                        </div>
                        <div class="col-md-5 col-xs-5 detail">
                            <span>
                                <i class="ion-person"></i> by  @foreach($user as $users) @if($users->id==$blogs->created_by) {{$users->user_fullname}} @endif @endforeach
                            </span>
                        </div>
                        <div class="col-md-4 col-xs-4 detail">
                            <span>
                                <a href="{{url('blog/'.$blogs->kateg_url)}}"> <i class="ion-android-clipboard" aria-hidden="true"></i> {{$blogs->kateg_name}}</a>
                            </span>
                        </div>
                        <div class="col-xs-12 detail-isi" >
                            <p class="lead"><?php echo nl2br(substr($blogs->content,0,170)) ; echo "...";?></p>
                        </div>
                        <div class="col-xs-12  detail-isi " style="text-align: center;">
                            <a class="read-more" href="{{url('blog/'.$blogs->kateg_url.'/'.$blogs->url)}}">READ MORE</a>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <!-- End // Blog -->
</div>
<script>
$('.slider').each(function() {
    var $this = $(this);
    var $group = $this.find('.slide_group');
    var $slides = $this.find('.slide');
    var bulletArray = [];
    var currentIndex = 0;
    var timeout;
    function move(newIndex) {
        var animateLeft, slideLeft;
        advance();
        if ($group.is(':animated') || currentIndex === newIndex) {
            return;
        }
        bulletArray[currentIndex].removeClass('active');
        bulletArray[newIndex].addClass('active');

        if (newIndex > currentIndex) {
            slideLeft = '100%';
            animateLeft = '-100%';
        } else {
            slideLeft = '-100%';
            animateLeft = '100%';
        }

        $slides.eq(newIndex).css({
            display: 'block',
            left: slideLeft
        });
        $group.animate({
            left: animateLeft
        }, function() {
            $slides.eq(currentIndex).css({
                display: 'none'
            });
            $slides.eq(newIndex).css({
                left: 0
            });
            $group.css({
                left: 0
            });
            currentIndex = newIndex;
        });
    }

    function advance() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            if (currentIndex < ($slides.length - 1)) {
                move(currentIndex + 1);
            } else {
                move(0);
            }
        }, 4000);
    }

    $('.next_btn').on('click', function() {
        if (currentIndex < ($slides.length - 1)) {
            move(currentIndex + 1);
        } else {
            move(0);
        }
    });

    $('.previous_btn').on('click', function() {
        if (currentIndex !== 0) {
            move(currentIndex - 1);
        } else {
            move(3);
        }
    });

    $.each($slides, function(index) {
        var $button = $('<a class="slide_btn">&bull;</a>');

        if (index === currentIndex) {
            $button.addClass('active');
        }
        $button.on('click', function() {
            move(index);
        }).appendTo('.slide_buttons');
        bulletArray.push($button);
    });

    advance();
});
</script>
@endsection
