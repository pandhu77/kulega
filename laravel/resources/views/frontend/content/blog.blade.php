@extends('app')
@section('content')
 <link rel="stylesheet" href="{{asset('template/frontend/blog.css')}}" type="text/css">
<title>Blog | {{web_name()}} </title>
  <div class="container">

    <div class="col-lg-12 col-sm-12 col-xs-12">
      <h2 class="title-al-blog">From The Blog</h2>
    </div>

      <div class="col-lg-12 bloglist">
        @foreach($blog as $blogs)
          @foreach($kateg as $kategs)
          @if($blogs->categ_id==$kategs->kateg_id)
        <div class="col-md-4 blog-items">
          <a href="{{url('blog/'.$kategs->kateg_url.'/'.$blogs->url)}}">
          <div class="card">
            <div class="date">
              <?php echo date('d F y',strtotime( $blogs->created_at));?>
            </div>
            <div class="hovereffect-blog" style="background-image:url({{asset($blogs->image)}});"   aria-labelledby="{{$blogs->title}}"> </div>
            <div class="isi-card">
              <div class="col-md-12" style="text-align: center;">
                <?php $tag= explode(",",$blogs->tags);?>
                @foreach($tag as $tags)
                  <a href="{{url('blog/tags/list/'.$tags)}}" class="label label-default" style="background-color:#b2203d;"> <?php echo "#".$tags;?></a>
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
                <a href="{{url('blog/'.$kategs->kateg_url)}}"> <i class="ion-android-clipboard" aria-hidden="true"></i> {{$kategs->kateg_name}}</a>
                </span>
              </div>
              <div class="col-xs-12 detail-isi" >
                <p class="lead"><?php echo nl2br(substr($blogs->content,0,170)) ; echo "...";?></p>
              </div>
              <div class="col-xs-12  detail-isi " style="text-align: center;">
          			<a class="read-more" href="{{url('blog/'.$kategs->kateg_url.'/'.$blogs->url)}}">READ MORE</a>
          		</div>
            </div>
          </div>
          </a>
        </div>
         @endif
        @endforeach
       @endforeach
      </div>
  </div>

  <script type="text/javascript">
  $(function(){
      $(".blog-items").slice(0,6).show();
      var win=$(window);

      win.scroll(function(){
            if($(document).height() - win.height() == win.scrollTop()){
                  $(".blog-items:hidden").slice(0, 3).slideDown();
            }
      });
  });

  </script>

  @endsection
