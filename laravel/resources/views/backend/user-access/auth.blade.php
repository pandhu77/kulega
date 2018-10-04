@extends('backend/app')
@section('content')
<title>System | User Auth</title>
<!-- <script src="{{asset('template/vendors/jquery/dist/jquery.min.js')}}"></script> -->
<!-- <link rel="stylesheet" href="{{asset('assets/multiselect/css/style.css') }}"> -->

<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>User Auth Management</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{$ace->access}} Access</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">

          <!-- CONTENT MAIL -->
            <div class="col-sm-8 mail_list_column">
            <div class="inbox-body">
              <div class="mail_heading row">

                <div class="col-md-12" style="padding-left:0px;padding-right">
                  @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      {{ Session::get('success') }}
                    </div>
                    @endif

                    @if(Session::has('errors-data'))
                      <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('errors-data') }}
                      </div>
                      @endif

                      @if(Session::has('no-delete'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h4>
                            {{ Session::get('no-delete') }}
                        </div>
                      @endif
                      @if($errors->all())
                      <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h4>
                        @foreach($errors->all() as $error)
                        <?php echo $error."</br>";?>
                        @endforeach
                      </div>
                      @endif
                  <form class="form-horizontal"  action="{{action('Backend\AuthController@authUpdate')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <!-- <input type="hidden" name="_method" value="PUT"> -->
                  <input type="hidden" name="access_id" value="{{$ace->access_id}}">
                  <div class="form-group">
                     <div class="col-sm-5">
                         <select name="from[]" id="optgroup" class="form-control" size="30" multiple="multiple">
                            @foreach($mainmenu as $main)
                              @if($main->parent == 0)
                                <option value="<?php echo $main->menu_id;?>">{{$main->menu}}</option>
                              @else

                              <optgroup value="<?php echo $main->menu_id;?>" label="{{$main->menu}}">
                                @foreach($submenu as $sub)
                                  @if($main->menu_id == $sub->group)
                                  <option value="<?php echo $sub->menu_id;?>">{{$sub->menu}}</option>
                                  @endif
                                @endforeach
                              </optgroup>

                              @endif
                            @endforeach

                         </select>
                     </div>

                     <div class="col-sm-2">
                         <button type="button" id="optgroup_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                         <button type="button" id="optgroup_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                         <button type="button" id="optgroup_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                         <button type="button" id="optgroup_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                     </div>

                     <div class="col-sm-5">
                         <select name="to[]" id="optgroup_to" class="form-control" size="30" multiple="multiple">
                           @foreach($authmainmenu as $main)
                             @if($main->parent == 0 and $main->group==0)
                               <option value="<?php echo $main->menu_id;?>">{{$main->menu}}</option>
                             @endif
                           @endforeach
                           @foreach($authmaingroup as $group)
                                <?php $menu=DB::table('menu_admin')->where('menu_admin.group','=',0)->where('menu_id',$group->group)->first();?>
                                     <optgroup value="<?php echo $menu->menu_id;?>" label="{{$menu->menu}}">
                                       @foreach($authsubmenu as $sub)
                                         @if($menu->menu_id == $sub->group)
                                         <option value="<?php echo $sub->menu_id;?>">{{$sub->menu}}</option>
                                         @endif
                                       @endforeach
                                     </optgroup>
                            @endforeach

                         </select>
                       </div>
                     </div>

                     <div class="col-md-12" style="text-align:right;">
                       <div class="btn-group">
                         <a href="{{url('backend/user-access')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" onclick="return validate()" data-original-title="Back"><i class="fa fa-reply"></i> Back</a>
                         <button class="btn btn-sm btn-success" type="submit" data-original-title="Submit"><i class="fa fa-share"></i> Submit</button>
                       </div>
                     </form>
                     </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{asset('assets/multiselect/js/multiselect.min.js')}}"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $("#optgroup").multiselect();
});
</script>
@endsection
