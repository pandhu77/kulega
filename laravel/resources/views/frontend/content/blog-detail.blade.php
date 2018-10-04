@extends('app')
@section('meta-description',nl2br($row->meta_desc))
@section('content')
 <link rel="stylesheet" href="{{asset('template/frontend/blog-detail.css')}}" type="text/css">
  <title>{{$row->title}} | {{web_name()}}</title>
  <div class="container-top header-top">
    <div class="header-image" style="background-image:url({{asset($row->image)}});"  aria-labelledby="{{$row->title}}">
        <img  src="{{asset($row->image)}}" alt="{{$row->tags}}" style="display:none;">
    </div>
    <div class="col-md-12 title-blog">
      {{$row->title}}
    </div>
  </div>
  <div class="container content-isi">
    <div class="col-md-6 col-xs-12 groupBy-left" >
      <?php $tag= explode(",",$row->tags);?>
      @foreach($tag as $tags)
        <a href="{{url('blog/tags/list/'.$tags)}}" class="label label-default" style="background-color:#b2203d;"> <?php echo "#".$tags;?></a>
      @endforeach
    </div>
    <div class="col-md-6 col-xs-12 groupBy" >
      <span>
        <i class="ion-ios-time-outline" aria-hidden="true"></i> <?php echo date('d F y',strtotime( $row->created_at));?>
      </span>

      <span>
        <i class="fa fa-folder-open-o" aria-hidden="true"></i> {{$row->view}}
      </span>
      <span>
        <i class="ion-person"></i> by   @foreach($user as $users) @if($users->id==$row->created_by) {{$users->user_fullname}} @endif @endforeach
      </span>
      <span>
      <a href="{{url('blog/'.$row->kateg_url)}}"> <i class="ion-android-clipboard" aria-hidden="true"></i> {{$row->kateg_name}}</a>
      </span>
    </div>


      <div class="col-md-12 content-text">
          <?php echo nl2br($row->content);?>
      </div>

      @if(count($blogprevious) >0 || count($blognext) >0)
        <div class="col-lg-12 col-sm-12 col-xs-12 list-line" >
          <hr>
        </div>

        <div class="col-xs-6 previous-post">
          @if(count($blogprevious) >0)
            <a class="button-left" href="{{url('blog/'.$blogprevious->kateg_url.'/'.$blogprevious->url)}}"> <i class="ion-chevron-left"></i></a>
            <div class="title-post">PREVIOUS POST</div>
            <div class="previous-title-blog">  {{$blogprevious->title}}</div>
          @endif
        </div>
        <div class="col-xs-6 next-post">
          @if(count($blognext) >0)
            <a class="button-right" href="{{url('blog/'.$blognext->kateg_url.'/'.$blognext->url)}}"> <i class="ion-chevron-right"></i></a>
            <div class="title-post">NEXT POST</div>
            <div class="previous-title-blog"> {{$blognext->title}}</div>
          @endif
        </div>
        <div class="col-lg-12 col-sm-12 col-xs-12">
          <hr>
        </div>
      @endif
      @if(count($blog) >0)
      <div class="col-lg-12 col-sm-12 col-xs-12">
        <h2 class="judul-kategori">Related Articles</h2>
      </div>

      <div class="col-lg-12 bloglist">
        @foreach($blog as $blogs)

          <div class="col-md-4">
            <a href="{{url('blog/'.$blogs->kateg_url.'/'.$blogs->url)}}">
            <div class="card">
              <div class="date">
                  <?php echo date('d F y',strtotime( $blogs->created_at));?>
              </div>
              <div class="hovereffect" style="background-image:url({{asset($blogs->image)}});"   aria-labelledby="{{$blogs->title}}"> </div>
              <!-- <img src="{{asset('assets/img/cewek4.png')}}" alt="Avatar" style="width:100%"> -->
              <div class="isi-card">
                <div class="col-md-12" style="text-align: center;">
                      <?php $tag= explode(",",$blogs->tags);?>
                      @foreach($tag as $tags)
                        <a href="{{url('blog/tags/list/'.$tags)}}" class="label label-default" style="background-color:#b2203d;"> <?php echo "#".$tags;?></a>
                      @endforeach
                  </p>
                </div>
                <div class="title-card">{{$blogs->title}}</div>
                <div class="col-md-3 col-xs-3 detail">
                  <span>
                    <i class="fa fa-folder-open-o" aria-hidden="true"></i>  {{$blogs->view}}
                  </span>
                </div>
                <div class="col-md-5 col-xs-5 detail">
                  <span>
                    <i class="ion-person"></i> by @foreach($user as $users) @if($users->id==$blogs->created_by) {{$users->user_fullname}} @endif @endforeach
                  </span>

                </div>
                <div class="col-md-4 col-xs-4 detail">
                  <span>
                    <a href="{{url('blog/'.$row->kateg_url)}}"> <i class="ion-android-clipboard" aria-hidden="true"></i> {{$blogs->kateg_name}}</a>
                  </span>
                </div>
              </div>
            </div>
            </a>
          </div>
        @endforeach
    </div>
    @endif
  </div>

  @endsection
