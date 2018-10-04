@extends('backend/app')
@section('content')
<title>System | Users</title>

<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Backend Users Management</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Users</h2>
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
                  <form class="form-horizontal" action="{{ url('backend/users/'.$row->id)}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="_method" value="PUT">
                      <div class="form-group">
                        <label class="col-sm-3  text-left"style="text-align:left;padding-left:0px;padding-right:0px;">User Access</label>
                        <div class="col-sm-9"style="text-align:left;padding-left:0px;padding-right:0px;">
                              <select  required name="access" class="form-control">
                              <option value="">--Select User Access--</option>
                              @foreach($access as $accesst)
                              <option value="{{$accesst->access_id}}"<?php if($row->access_id==$accesst->access_id){echo 'selected="selected"';} ?>>{{$accesst->access}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3  text-left"style="text-align:left;padding-left:0px;padding-right:0px;">User Name</label>
                        <div class="col-sm-9"style="text-align:left;padding-left:0px;padding-right:0px;">
                          <input type="text" class="form-control" name="username" value="{{$row->username}}">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="col-sm-3  text-left"style="text-align:left;padding-left:0px;padding-right:0px;">Name</label>
                        <div class="col-sm-9"style="text-align:left;padding-left:0px;padding-right:0px;">
                          <input type="text" class="form-control" name="name" value="{{$row->user_fullname}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3  text-left"style="text-align:left;padding-left:0px;padding-right:0px;">Email</label>
                        <div class="col-sm-9"style="text-align:left;padding-left:0px;padding-right:0px;">
                          <input type="text" class="form-control" name="email"  value="{{$row->email}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3  text-left"style="text-align:left;padding-left:0px;padding-right:0px;">Phone Number</label>
                        <div class="col-sm-9"style="text-align:left;padding-left:0px;padding-right:0px;">
                          <input type="text" class="form-control" name="phone"  value="{{$row->user_phone}}">
                        </div>
                      </div>
                      <div id="togglepass" style="display:none;">
                        <div class="form-group">
                          <label class="col-sm-3  text-left"style="text-align:left;padding-left:0px;padding-right:0px;">password</label>
                          <div class="col-sm-9"style="text-align:left;padding-left:0px;padding-right:0px;">
                            <input type="password" class="form-control" name="password" placeholder="new password">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3  text-left"style="text-align:left;padding-left:0px;padding-right:0px;">password Confirmation</label>
                          <div class="col-sm-9"style="text-align:left;padding-left:0px;padding-right:0px;">
                            <input type="password" class="form-control" name="password_confirmation"placeholder="new password confirmation" >
                          </div>
                        </div>
                     </div>

                     <div class="col-md-12" style="text-align:right;padding-left:0px;padding-right:0px;">
                       <a class="btn btn-danger btn-sm button-toggle"><i class="fa fa-edit m-right-xs"></i> New Password</a>
                       <div class="btn-group">

                         <a href="{{url('backend/users')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" onclick="return validate()" data-original-title="Back"><i class="fa fa-reply"></i> Back</a>
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
