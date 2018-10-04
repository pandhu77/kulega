@extends('app')
@if($page !==null)
@section('meta-description',nl2br($page->meta_desc))
@endif
@section('content')

<link rel="stylesheet" href="{{asset('template/frontend/page-min.css')}}" type="text/css" />
<title>{{web_name()}} | @if($page !==null) {{$page->title}}  @endif  @if($care !==null) Customer Care @endif </title>
  <div class="container">
      <span class="sep"></span>

      <div class="col-sm-3 sideMenu hidden-lg hidden-md hidden-sm ">
          <div class="hidden-lg hidden-md hidden-sm" style="width:100%; text-align: center;background-color:#333;padding-top: 10px;padding-bottom: 10px; ">
              <a class="hidden-lg hidden-md hidden-sm collapsed" data-toggle="collapse" data-target="#submenu" style="font-size: 12pt; text-decoration: none;text-align: center;color: #fff"><span> MENU LIST <i class="fa fa-caret-down" aria-hidden="true"></i></span></a>

          </div>
          <div  class="collapse navbar-collapse collapse"id="submenu">

              <ul class="menu">

                  <li>SENTRA STORE</li>
                   @foreach($menu as $menus)
                    @if($menus->group=='store')
                    <li><a href="{{url($menus->url)}}">{{$menus->menu}}</a></li>
                    @endif
                   @endforeach
              </ul>

              <ul class="menu">
                  <li>SENTRA INFOMATION</li>
                  @foreach($menu as $menus)
                   @if($menus->group=='info')
                   <li><a href="{{url($menus->url)}}">{{$menus->menu}}</a></li>
                   @endif
                  @endforeach
              </ul>
          </div>

      </div>

      <div class="col-sm-3 sideMenu hidden-xs">
          <h1 class="menu-title">M E N U L I S T </h1>

          <ul class="menu">

              <li>SENTRA STORE</li>
               @foreach($menu as $menus)
                @if($menus->group=='store')
                <li><a href="{{url($menus->url)}}">{{$menus->menu}}</a></li>
                @endif
               @endforeach
          </ul>

          <ul class="menu">
              <li>SENTRA INFOMATION</li>
              @foreach($menu as $menus)
               @if($menus->group=='info')
               <li><a href="{{url($menus->url)}}">{{$menus->menu}}</a></li>
               @endif
              @endforeach
          </ul>

      </div>

      <div class="col-sm-9 col-content">
          @if($page !==null)
              <div class="col-sm-12 list-outer-title text-center">
                <label class="page-title">{{$page->title}}</label>
                    <svg height="30" width="80">
                        <polyline points="0,10 10,0 20,10 30,0 40,10 50,0 60,10  70,0 80,10" style="fill:rgba(0,0,0,0);stroke:#fff;stroke-width:1" />
                    </svg>
              </div>
             @if(!empty($page->image))
                <div class=" col-profile_img">
                    <img class="img-responsive avatar-view"  style="width:100%"src="{{asset($page->image)}}" alt="{{$page->title}}" >
                </div>

             @endif
            <?php echo nl2br($page->content);?>
         @endif

         @if($care !== null)
             <div class="col-sm-12 list-outer-title text-center">
               <label class="page-title">Customer Care</label>
                   <svg height="30" width="80">
                       <polyline points="0,10 10,0 20,10 30,0 40,10 50,0 60,10  70,0 80,10" style="fill:rgba(0,0,0,0);stroke:#fff;stroke-width:1" />
                   </svg>
             </div>
             <div class="col-sm-12 list-outer-title text-center">
               <label class="page-title-2">I NEED YOU HELP ?</label>
                   <svg height="30" width="80">
                       <polyline points="0,10 10,0 20,10 30,0 40,10 50,0 60,10  70,0 80,10" style="fill:rgba(0,0,0,0);stroke:#fff;stroke-width:1" />
                   </svg>
             </div>
             <table class="table table-striped table tableresponsive">
                 <!-- <thead>
                   <tr>
                     <th style="text-align:center;">Note</th>
                     <th style="text-align:center;">Email</th>
                     <th style="text-align:center;">Phone</th>
                     <th style="text-align:center;">Address</th>

                   </tr>
                 </thead> -->
               <tbody>
                   @foreach($care as $cares)
                   <tr>
                         <td data-label="" style="text-align:left;">{{$cares->care_note}}</td>
                         <td data-label="" style="text-align:left;">{{$cares->care_email}}</td>
                         <td data-label="" style="text-align:left;">{{$cares->care_phone}}</td>
                         <td data-label="" style="text-align:left;">{{$cares->care_address}}</td>
                   </tr>
                   @endforeach
                </tbody>
               </table>
         @endif
      </div>


  </div>

  @endsection
