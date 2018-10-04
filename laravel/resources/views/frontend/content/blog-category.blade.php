@extends('app')
@section('content')
<link rel="stylesheet" href="{{asset('template/frontend/blog-categ.css')}}" type="text/css">
<title>{{$urlkateg}} | {{web_name()}}</title>
  <div class="container">
      @foreach($blog as $blogs)
        <div class="col-lg-12 bloglist blog-items">
          <div class="col-md-3">
            <a href="{{url('blog/'.$blogs->kateg_url.'/'.$blogs->url)}}"  aria-labelledby="{{$blogs->title}}">
              <div class="card">
                <div class="date">
                <?php echo date('d M y',strtotime($blogs->created_at));?>
                </div>
                <div class="hovereffect-blog" style="background-image:url({{asset($blogs->image)}});"> </div>
              </div>
            </a>
          </div>
          <div class="col-md-9">
              <div class="isi-card">
                <div class="title-card">{{$blogs->title}}</div>
                <div class="col-md-6 col-xs-12 detail-left">
                  <p style="font-size: 12px; color: #bfbfbf;">
                    <?php $tag= explode(',',$blogs->tags);?>
                    @foreach($tag as $tags)
                    <a href="{{url('blog/tags/list/'.$tags)}}" class="label label-default" style="background-color:#b2203d;"><?echo "#".$tags ;?></a>
                    @endforeach
                  </p>
                </div>
                <div class="col-md-6 col-xs-12 detail-right">
                  <span>
                    <i class="fa fa-folder-open-o" aria-hidden="true"></i> {{$blogs->view}}
                  </span>
                  <span>
                    <i class="ion-person"></i> by @foreach($user as $users) @if($users->id ==$blogs->created_by){{$users->user_fullname}} @endif @endforeach
                  </span>
                  <span>
                    <a href="{{url('blog/'.$blogs->kateg_url)}}"> <i class="ion-android-clipboard" aria-hidden="true"></i> {{$blogs->kateg_name}}</a>
                  </span>
                </div>

                <div class="col-xs-12 detail-isi" >
                <p class="lead"><?php echo nl2br(substr($blogs->content,0,400)) ; echo "...";?></p>
                </div>
                <div class="col-lg-12  detail-isi">
                  <a class="read-more" href="{{url('blog/'.$blogs->kateg_url.'/'.$blogs->url)}}">READ MORE</a>
                </div>
            </div>
          </div>
      </div>
      @endforeach
  </div>

    <script>
    $(function(){
        $(".blog-items ").slice(0,9).show();
        var win=$(window);
        win.scroll(function(){
              if($(document).height() - win.height() == win.scrollTop()){
                    $(".blog-items:hidden").slice(0, 3).slideDown();
              }
        });
    });

  </script>
  @endsection
