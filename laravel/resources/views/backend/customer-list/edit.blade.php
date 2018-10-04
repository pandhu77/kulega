@extends('backend/app')
@section('content')
<title>System | Member </title>
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Customer Profile</h3>
    </div>

    <div class="title_right">
      <!-- <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">Go!</button>
          </span>
        </div>
      </div> -->
    </div>
  </div>

  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      @if($errors->all())
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h4>
        @foreach($errors->all() as $error)
        <?php echo $error."</br>";?>
        @endforeach
      </div>
      @endif
      <div class="x_panel">
        <div class="x_title">
          <h2>Data Customer <small></small></h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
            <div class="profile_img">
              <div id="crop-avatar">
                <!-- Current avatar -->
                @if($row->member_image== null)
                <img class="img-responsive" id="viewimg" src="{{ asset('assets/img/ava.png') }}" alt="">
                @else
                <img class="img-responsive avatar-view" src="{{asset($row->member_image)}}" alt="Avatar" title="Change the avatar">
                @endif

              </div>
            </div>
            <h3>{{$row->member_fullname}}</h3>

            <ul class="list-unstyled user_data">
              <li><i class="glyphicon glyphicon-envelope user-profile-icon"></i> {{$row->member_email}}
              </li>
              <li><i class="fa fa-phone user-profile-icon"></i> {{$row->member_phone}}
              </li>


              <li class="m-top-xs">
                <i class="fa fa-map-marker user-profile-icon"></i> {{$row->member_address}}

              </li>
            </ul>

            <a class="btn btn-danger button-toggle"><i class="fa fa-edit m-right-xs"></i> New Password</a>
            <br />

            <!-- start skills -->
            <!-- <h4>Level Goup</h4>
            <ul class="list-unstyled user_data">
              <li>
                  @if($row->member_level ==0 || $row->member_level ==null  ) - @else <b>{{$row->level_name}}</b> Group @endif
              </li>

            </ul> -->
            <!-- start skills -->
            <h4>Customer Status</h4>
            <ul class="list-unstyled user_data">
              <li>
                  @if($row->member_status ==1)<span class="label label-primary">Enable</span> @else <span class="label label-warning">Disable</span> @endif
              </li>

            </ul>
            <!-- end of skills -->

          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">

            <div class="profile_title">
              <div class="col-md-12">
                <h2>Edit Data Customer</h2>
              </div>

            </div>

              <div class="col-md-12 col-sm-12 col-xs-12">

                    <form action="{{action('Backend\MemberController@update')}}" method="post" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                      <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                      <input type="hidden"  name="member_id" required="required" value="{{$row->member_id}}" class="form-control col-md-7 col-xs-12" readonly>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="checkbox" <?php if($row->member_status==1){echo "checked";}?> class="" name="enable"> Enable
                        </div>
                      </div>

                      <!-- <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Username <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="member_username"  value="{{$row->member_username}}" class="form-control col-md-7 col-xs-12" readonly>

                        </div>
                      </div> -->

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Name
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="member_fullname"  value="{{$row->member_fullname}}" class="form-control col-md-7 col-xs-12" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="member_email" value="{{$row->member_email}}" class="form-control col-md-7 col-xs-12" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Phone
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="member_email"  value="{{$row->member_phone}}" class="form-control col-md-7 col-xs-12" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date of Birth
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="datepicker" class="date-picker form-control " data-validation-format="yyyy-mm-dd" name="member_dob" type="text" value="{{$row->member_dob}}" readonly>
                        </div>
                      </div>
                      <!-- <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Gender
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="radio" <?php //if($row->member_gender=='male'){echo "checked";}?>  name="member_gender"  value="male"  readonly />Male
                          <input type="radio" <?php //if($row->member_gender=='famale'){echo "checked";}?> name="member_gender"  value="famale"  readonly/> Famale
                        </div>
                      </div> -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Address
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea name="member_address" class="form-control col-md-7 col-xs-12" readonly><?php echo $row->member_address?></textarea>
                        </div>
                      </div>
                      <div class="form-group " id="togglepass" style="display:none;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password"  name="member_password"  value="" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>




                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 " style="text-align:right;">
                              <div class="ln_solid"></div>
                          <a href="{{url('backend/customer-list')}}" class="btn btn-default">Cancel</a>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
