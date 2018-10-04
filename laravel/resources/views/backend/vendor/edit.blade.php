@extends('backend/app')
@section('content')
<title>System | Vendors</title>

<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Backend Vendors Management</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Create Vendors</h2>
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
                  <form class="form-horizontal" action="{{ url('backend/vendor/'.$row->vendor_id)}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="_method" value="PUT">

                        <div class="form-group">
                            <label class="col-sm-3 control-label"style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Status</label>
                            <div class="col-sm-9"style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">
                                  <input type="checkbox" name="status" <?php if($row->vendor_status==1){echo 'checked';}?>> Enable
                            </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;" >Full Name</label>
                              <div class="col-sm-9"style="padding-left:0px;padding-right:0px;">
                                <input type="text" class="form-control" name="vendor_fullname" value="{{$row->vendor_fullname}}">
                              </div>
                            </div>
                            <div id="togglepass" style="display:none;">
                              <div class="form-group">
                                <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Password</label>
                                <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                                  <input type="password" class="form-control" name="vendor_password" placeholder="new password">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Password Confirmation</label>
                                <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                                  <input type="password" class="form-control" name="password_confirmation"placeholder="new password confirmation">
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Email</label>
                              <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                                <input type="email" class="form-control" name="vendor_email" value="{{$row->vendor_email}}">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Phone Number</label>
                              <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                                <input type="text" class="form-control" name="vendor_phone" value="{{$row->vendor_phone}}">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Address</label>
                              <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                               <textarea class="form-control" name="vendor_address" rows="3"><?php echo $row->vendor_address;?></textarea>
                              </div>
                            </div>


                    <div class="col-md-12" style="text-align:right;padding-left:0px;padding-right:0px;">
                      <a class="btn btn-danger btn-sm button-toggle"><i class="fa fa-edit m-right-xs"></i> New Password</a>
                      <div class="btn-group">
                        <a href="{{url('backend/vendor')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" onclick="return validate()" data-original-title="Back"><i class="fa fa-reply"></i> Back</a>
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
