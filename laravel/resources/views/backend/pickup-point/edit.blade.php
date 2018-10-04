@extends('backend/app')
@section('content')
<title>System | Pickup Point</title>
<script src="{{asset('template/vendors/jquery/dist/jquery.min.js')}}"></script>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Pickup Point Management</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Pickup Point</h2>
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
                  <form class="form-horizontal" action="{{url('backend/pickup-point/'.$row->pick_id)}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="_method" value="PUT" >
                    <div class="form-group">
                      <label class="col-sm-3 control-label"style="text-align:left;padding-left:0px;padding-right:0px;">Public</label>
                      <div class="col-sm-9"style="text-align:left;padding-left:0px;padding-right:0px;">
                            <input type="checkbox" name="status" <?php if($row->enable==1){echo "checked";}?>>  Enable
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label"style="text-align:left;padding-left:0px;padding-right:0px;">City</label>
                      <div class="col-sm-9"style="text-align:right;padding-left:0px;padding-right:0px;" >
                        <input type="text" name ="city" class="form-control"value="{{$row->city}}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-12 control-label" style="margin-top:20px;text-align:left;padding-left:0px;padding-right:0px;">Detail Point</label>
                      <div class="col-sm-12" style="text-align:left;padding-left:0px;padding-right:0px;">
                        <div class="table-responsive">
                              <table class="table table-bordered" >
                                <tbody>
                                <tr>
                                  <!-- <th>Name</th> -->
                                  <th>Point (Name Place)</th>
                                  <th>Address (Location)</th>
                                  <th>Phone Number</th>

                                  <th>Action</th>
                                </tr>
                              </tbody>
                              @if($point !==null)
                                <tbody>
                                  <?php $a=300;?>
                                  @foreach($point as $points)

                                    <tr id="row">
                                       <td>
                                          <input type="hidden" class="form-control" name="pointid[]" value="{{$points->id}}" id="pointid<?php echo $a;?>">
                                          <input type="text" class="form-control" name="location_update[]" id="location_update<?php echo $a;?>" value="{{$points->location}}">
                                       </td>
                                       <td><input type="text" class="form-control" id="dtlocation_update<?php echo $a;?>" name="dtlocation_update[]"value="{{$points->detail_location}}" ></td>
                                       <td><input type="text" class="form-control" name="phone_update[]" id="phone_update<?php echo $a;?>" style="padding:0px;" value="{{$points->pick_phone}}" ></td>
                                       <td width="5%"><button type="button" onclick="if(confirm('Are you sure?')) location.href='{{ URL::to('backend/pickup-point/delete/' . $points->id)}}'" name="remove" id="<?php echo $a;?>" class="btn btn-sm btn-danger btn_remove">Delete</button></td>
                                     </tr>
                                     <?php $a++;?>
                                   @endforeach
                                </tbody>
                                @endif
                                <tbody id="dynamic_field_point">
                                  <tr>

                                  <tr>
                                </tbody>
                              </table>
                      </div>

                      </div>
                      <div class="col-sm-12"style="text-align:left;padding-left:0px;padding-right:0px;">
                          <button type="button" name="add" id="addpoint" class="btn btn-success">
                            <i class="fa fa-plus"></i>Point
                          </button>
                      </div>
                      </div>

                     <div class="col-md-12" style="text-align:right;padding-left:0px;padding-right:0px;">
                       <div class="btn-group">
                         <a href="{{url('backend/pickup-point')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" onclick="return validate()" data-original-title="Back"><i class="fa fa-reply"></i> Back</a>
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

<!-- /Starrr -->
<script>
    //  $(document).ready(function(){
          var i=0;
          $('#addpoint').click(function(){
              j=++i;
              //<td width="40%"><input type="text" class="form-control" name="varianname[]" id="varname'+ j +'"></td>
              // <td><input type="hidden" class="form-control" name="qty[]" id="varqty'+ j +'"></td>
               $('#dynamic_field_point').append('<tr id="row'+i+'"> <td><input type="text" class="form-control" name="location[]" id="location'+ j +'"></td><td><input type="text" class="form-control" id="dtlocation'+ j +'" name="dtlocation[]" ></td><td><input type="text" class="form-control" name="phone[]" id="phone'+ j +'" style="padding:0px;" ></td><td width="5%"><button type="button" name="remove" id="'+i+'" class="btn btn-sm btn-danger btn_remove">Delete</button></td></tr>');

          });
          $(document).on('click', '.btn_remove', function(){
               var button_id = $(this).attr("id");
               $('#row'+button_id+'').remove();
          });

    //  });
</script>
@endsection
