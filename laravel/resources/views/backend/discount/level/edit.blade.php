@extends('backend/app')
@section('content')
<title>System | Level</title>
<script src="{{asset('template/vendors/jquery/dist/jquery.min.js')}}"></script>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Discount Level Management</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Discount Level</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">

          <!-- CONTENT MAIL -->
            <div class="col-sm-6 mail_list_column">
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
                  <form class="form-horizontal" action="{{url('backend/discount-level/'.$row->disc_level_id)}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden"name="_method"value="PUT">
                      <div class="form-group">
                        <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Public</label>
                        <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                            <input type="checkbox" name="enable"<?php if($row->disc_status==1){echo "checked";}?>> Enable
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Level Name</label>
                        <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                          <select name="level_name" class="form-control"required>
                                  <option value="Silver" <?php if($row->level_name=='Silver'){ echo 'selected="selected"';}?>> Silver </option>
                                  <option value="Gold"<?php if($row->level_name=='Gold'){ echo 'selected="selected"';}?>> Gold </option>
                          </select>

                        </div>
                      </div>
                      <div class="form-group">
                          <label for="inputEmail3"  style="padding-left:0px;padding-right:0px;"class="col-sm-3 text-left">Requirement Value</label>
                          <div class="col-sm-4" style="padding-left:0px;padding-right:0px;">
                              <input   type="number" class="form-control" placeholder="Min" name="min_value" id="rf" value="{{$row->min_value}}" required>
                          </div>
                          <label for="inputEmail3"style="padding-left:0px;padding-right:0px;" class="col-sm-1 text-center" style="height: 34px; padding: 0px; ">-</label>
                          <div class="col-sm-4"style="padding-left:0px;padding-right:0px;">
                              <input  type="number" class="form-control" placeholder="Max" name="max_value" id="ru" value="{{$row->maxs_value}}" required>
                          </div>
                      </div>

                        <div class="form-group">
                           <label for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Percentage Value(%)</label>
                           <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                               <input  type="number" class="form-control" placeholder="" name="disc_value" value="{{$row->disc_value}}" required>
                           </div>
                       </div>

                       <div class="form-group">
                         <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Birth Day Percentage(%)</label>
                         <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                           <input type="number"  class="form-control" name="disc_value_uth"placeholder="" style=""value="{{$row->disc_value_uth}}" required>
                         </div>
                       </div>
                       <div class="form-group">
                         <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Birth Day Limit( day H + )</label>
                         <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                           <input type="number"  class="form-control" name="disc_limit_uth"placeholder="" style=""value="{{$row->disc_limit_uth}}" required>
                         </div>
                       </div>

                       <div class="col-md-12" style="text-align:right;padding-left:0px;padding-right:0px;">
                         <div class="btn-group">
                           <a href="{{url('backend/discount-level')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" onclick="return validate()" data-original-title="Back"><i class="fa fa-reply"></i> Back</a>
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
