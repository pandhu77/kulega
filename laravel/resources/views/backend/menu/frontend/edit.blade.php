@extends('backend/app')
@section('content')
<title>Edit | Menu</title>
<script src="{{asset('template/vendors/jquery/dist/jquery.min.js')}}"></script>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Frontend Menu Management</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Menu</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">

          <!-- CONTENT MAIL -->
            <div class="col-sm-8 mail_list_column">
            <div class="inbox-body">
              <div class="mail_heading row">

                <div class="col-md-12">
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
                  <form class="form-horizontal"  action="{{url('backend/frontend-menu/'.$row->menu_id)}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="form-group">
                        <label class="col-sm-3 control-label"style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Public</label>
                        <div class="col-sm-9"style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">
                              <input type="checkbox" name="enable" <?php if($row->enable == 1){echo "checked";} ?>> Enable
                        </div>
                      </div>
                      <div class="form-group hidden" style="<?php if($row->fix == 1){echo "display:none";} ?>">
                          <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Type</label>
                          <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                              <select name="type" class="form-control" required>
                                <option value="">--Select One--</option>
                                <option value="Main" <?php if($row->type == 'Main'){echo "selected";} ?>>Main Menu</option>
                                <option value="Footer" <?php if($row->type == 'Footer'){echo "selected";} ?>>Footer Menu</option>
                              </select>
                          </div>
                      </div>

                      <div class="form-group hidden" style="<?php if($row->fix == 1){echo "display:none";} ?>">
                          <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Parent</label>
                          <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                              <select name="parent" class="form-control select2" required>
                                <option value="0" <?php if($row->parent == 0){echo "selected";} ?>>Parent</option>
                                @foreach($menu as $men)
                                    <option value="{{ $men->menu_id }}" <?php if($row->parent == $men->menu_id){echo "selected";} ?>>{{ $men->menu }}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>

                      <div class="form-group" style="<?php if($row->fix == 1){echo "display:none";} ?>">
                        <label class="col-sm-3 text-left"style="padding-left:0px;padding-right:0px;">Menu</label>
                        <div class="col-sm-9"style="padding-left:0px;padding-right:0px;">
                          <input type="text"  class="form-control" name="menu" value="{{ $row->menu }}" required>
                        </div>
                      </div>
                      <div class="form-group" style="<?php if($row->fix == 1){echo "display:none";} ?>">
                        <label class="col-sm-3 text-left"style="padding-left:0px;padding-right:0px;">Url</label>
                        <div class="col-sm-9"style="padding-left:0px;padding-right:0px;">
                            <input type="text" class="form-control" name="url" value="{{ $row->url }}" id="currenturl">
                          <input type="radio" name="geturl" onclick="getopturl(1)"> Select Page
                          <input type="radio" name="geturl" onclick="getopturl(2)" style="margin-left:10px;"> Custom URL
                          <div style="margin-top:10px;">
                              <select class="form-control hidden" id="selectpages">
                                  <option disabled selected>Select One</option>
                                  @foreach($pages as $pag)
                                    <option value="page/{{ $pag->url }}">{{ $pag->title }}</option>
                                  @endforeach
                              </select>
                              <input type="text" class="form-control hidden" value="http://" id="costumurl">
                          </div>
                        </div>
                      </div>

                      <script type="text/javascript">
                          function getopturl(id){
                              $('#currenturl').addClass('hidden');
                              $('#currenturl').attr('name',false);

                              if (id == 1) {
                                  $('#selectpages').removeClass('hidden');
                                  $('#selectpages').attr('name','url');

                                  $('#costumurl').addClass('hidden');
                                  $('#costumurl').attr('name',false);
                              }else {
                                  $('#selectpages').addClass('hidden');
                                  $('#selectpages').attr('name',false);

                                  $('#costumurl').removeClass('hidden');
                                  $('#costumurl').attr('name','url');
                              }

                              $(".select2").select2({
                                  placeholder: "Select One",
                                  allowClear: true
                              });
                          }
                      </script>

                       <div class="col-md-12" style="text-align:right;padding-left:0px;padding-right:0px;">
                         <div class="btn-group">
                           <a href="{{url('backend/frontend-menu')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" onclick="return validate()" data-original-title="Back"><i class="fa fa-reply"></i> Back</a>
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

@endsection
