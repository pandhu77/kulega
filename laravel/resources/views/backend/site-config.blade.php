@extends('backend/app')
@section('content')
<!-- /*<style>
.tab-content {
    margin-top: 50px;
}
.nav-pills {
    background-color: #2A3F54;
}
.nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
    color: #fff;
    background-color: #B2203D;
    border-radius: 0px;
}
.nav-pills > li {
    float: none !important;
    width: auto !important;
    /* margin: 0 auto; */
}
.nav > li {
    position: relative;
    display: inline-block !important;
    /* margin: 0 auto; */
}
.pager li > a, .pager li > span {
    display: inline-block;
    padding: 12px 45px;
    background-color: #B2203D;
    border: 1px solid #ddd;
    border-radius: 0px;
    color: white;
  }

  .nav-pills li a{
    color: #ddd;
    font-weight: 400;
    letter-spacing: 1px;
  }

  a:focus, a:hover {
    color: #ddd;
    text-decoration: underline;
}
.x_title {
    border-bottom: 2px solid #E6E9ED;
    padding: 1px 0px 10px;
    margin-bottom: 10px;
}
</style>*/ -->
<title>System | Site Config</title>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Site Configuration</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">

      <div class="x_title">
          <ul class="nav nav-pills" style="text-align: center;">
            <li class="active" id="link1"><a href="#level1" data-toggle="tab">Contact Management</a></li>
            <li id="link2"><a href="#level2"  data-toggle="tab">Site Management</a></li>
          </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="row">

          <!-- CONTENT MAIL -->
          <div class="col-sm-12 mail_view">

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
                  @if(Session::has('success2'))
                    <div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      {{ Session::get('success2') }}
                    </div>
                    @endif

                    @if(Session::has('errors-data2'))
                      <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('errors-data2') }}
                      </div>
                      @endif


                  @if($errors->all())
                  <div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    @foreach($errors->all() as $error)
                    <?php echo $error."</br>";?>
                    @endforeach
                  </div>
                  @endif
                  <div class="tab-content"style="margin-top:30px;">
                    <!-- First tab -->
                    <div class="tab-pane active" id="level1">
                      <form class="form-horizontal" action="{{action('Backend\CmsConfigController@updatecontact')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden"name="pageid"  value="{{$row->id}}">
                        <div class="form-group">
                          <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Last Update</label>
                          <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <input type="text" readonly class="form-control" name="updated_at"placeholder="" style=""value="<?= date("d M Y H:i:s",strtotime($row->updated_at)) ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Site Name</label>
                          <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <input type="text" class="form-control" name="site_name"placeholder="Site Name"   style=""value="{{$row->site_name}}">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Domain Url</label>
                          <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <input type="text" class="form-control" name="domain"placeholder="Domain"   style=""value="{{$row->domain}}">
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Email</label>
                          <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <input type="text" class="form-control" name="email" placeholder="Email"  style=""value="{{$row->email}}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Telp</label>
                          <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <input type="text" class="form-control" name="telp"placeholder="Telp"   style=""value="{{$row->telp}}">
                          </div>
                        </div>
                        <!-- <div class="form-group">
                          <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Pax</label>
                          <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <input type="text" class="form-control" name="pax"placeholder="Pax"   style=""value="{{$row->pax}}">
                          </div>
                        </div> -->
                        <div class="form-group">
                          <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Address</label>
                          <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <textarea name="address" class="form-control"><?php echo $row->address?></textarea>
                          </div>
                        </div>

                        <!-- <div class="form-group">
                          <label class="col-sm-12 control-label" style="margin-top:20px;padding-left:0px;padding-right:0px;">Customer Care</label>
                          <div class="col-sm-12" style="padding-left:0px;padding-right:0px;">
                            <div class="table-responsive">
                              <table class="table table-bordered" >
                                <tbody>
                                  <tr>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                  </tr>
                                </tbody>
                                <tbody>
                                  <?php $i=100;?>
                                  @foreach($care as $car)
                                      <?php $j=$i++;?>
                                      <tr id="row{{$i}}">
                                        <td><input type="text" class="form-control" name="emailcare[]" id="emailcare{{$j}}" value="{{$car->care_email}}"></td>
                                        <td><input type="text" class="form-control" id="phonecare{{$j}}" name="phonecare[]"value="{{$car->care_phone}}" ></td>
                                        <td><input type="text" class="form-control" name="addresscare[]" id="addresscare{{$j}}" value="{{$car->care_address}}"style="padding:0px;" ></td>
                                        <td><input type="text" class="form-control" name="notecare[]" id="notecare{{$j}}" value="{{$car->care_note}}"></td>
                                        <td width="5%"><button type="button" name="remove" id="{{$i}}" class="btn btn-sm btn-danger btn_remove">Delete</button></td>
                                      </tr>

                                  @endforeach
                                </tbody>

                                <tbody id="dynamic_field_care">
                                  <tr><tr>
                                </tbody>
                                </table>
                              </div>

                              </div>
                              <div class="col-sm-12"style="padding-left:0px;padding-right:0px;">
                                <button type="button" name="add" id="addcare" class="btn btn-success">
                                  <i class="fa fa-plus"></i> Customer Care
                                </button>
                              </div>
                            </div> -->

                        <div class="col-md-12" style="text-align:right;">
                          <div class="btn-group">
                            <button class="btn btn-sm btn-success" type="submit" data-original-title="Submit"><i class="fa fa-save"></i> Save</button>
                            <a href="{{url('backend')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
                          </div>
                        </div>
                    </form>
                 </div>
                 <div class="tab-pane" id="level2">
                     <form class="form-horizontal" action="{{action('Backend\CmsConfigController@updatesite')}}" method="post" enctype="multipart/form-data">
                       <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                       <input type="hidden"name="sitepageid"  value="{{$row->id}}">
                       <div class="form-group">
                         <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Last Update</label>
                         <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                           <input type="text" readonly class="form-control" name="last_update"placeholder="" style=""value="<?= date("d M Y H:i:s",strtotime($row->updated_at)) ?>">
                         </div>
                       </div>
                       <div class="form-group">
                         <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Origin Province</label>
                         <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                             <select class="form-control" name="province" onchange="shippingcity(1)">
                                 <option value="">Select Province</option>
                             </select>
                         </div>
                       </div>
                       <div class="form-group">
                         <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Origin City</label>
                         <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                             <select class="form-control" name="city">
                                 <option value="">Select City</option>
                             </select>
                         </div>
                       </div>
                       <div class="form-group">
                         <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Logo</label>
                         <div class="col-sm-10" style="padding-left:0px;padding-right:0px;background-color:#eee;">
                             <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img')}}" class="btn iframe-btn btn-danger" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Logo</i></a><br/>
                             <img src="<?php if($row->logo ==! null ){?>{{asset($row->logo)}}<?php }?>" id="viewimg" class="img-responsive" style="max-width:300px;max-height:300px;"/><br/>
                             <input type="hidden" name="logo" value="{{asset($row->logo)}}" class="form-control" id="img">
                         </div>
                       </div>
                       <div class="form-group">
                         <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Meta Decsription</label>
                         <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                           <textarea name="meta" rows="3" class="form-control"  cols="80">{{$row->meta}}</textarea>
                         </div>
                       </div>

                       <!-- <h2>HOME PAGE</h2> -->
                       <!-- <div class="form-group">
                         <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Header(Banner)</label>
                         <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                             <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img')}}" class="btn iframe-btn btn-danger" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Image</i></a><br/>
                             <img src="<?php if($row->image_header_home ==! null ){?>{{asset($row->image_header_home)}}<?php }?>" id="viewimg" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>
                             <input type="hidden" name="image_header_home" value="{{asset($row->image_header_home)}}" class="form-control" id="img">
                         </div>
                       </div> -->
                       <!-- <div class="form-group">
                         <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Title  List Product</label>
                         <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                           <input type="text" class="form-control" name="title_product" value="{{$row->title_product}}">
                         </div>
                       </div>

                       <div class="form-group">
                         <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Title List Brand</label>
                         <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                           <input type="text" class="form-control" name="title_brand"   style=""value="{{$row->title_brand}}">
                         </div>
                       </div>
                       <div class="form-group">
                         <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Title List Blog</label>
                         <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                           <input type="text" class="form-control" name="title_blog"   style=""value="{{$row->title_blog}}">
                         </div>
                       </div> -->
                      <!-- <h2>CATEGORY PAGE</h2>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Header(Banner)</label>
                        <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img2')}}" class="btn iframe-btn btn-danger" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Image</i></a><br/>
                            <img src="<?php if($row->image_header_product ==! null ){?>{{asset($row->image_header_product)}}<?php }?>" id="viewimg2" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>
                            <input type="hidden" name="image_header_product" value="{{asset($row->image_header_product)}}" class="form-control" id="img2">
                        </div>
                      </div> -->

                       <div class="col-md-12" style="text-align:right;">
                         <div class="btn-group">
                           <button class="btn btn-sm btn-success" type="submit" data-original-title="Submit"><i class="fa fa-save"></i> Save</button>
                           <a href="{{url('backend')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
                         </div>
                       </div>
                   </form>
                 </div>
               </div>
              </div>
            </div>

          </div>
          <!-- /CONTENT MAIL -->
        </div>
      </div>
    </div>
   </div>
 </div>
</div>

<script type="text/javascript">
shippingprovince();

function shippingprovince(){
    var datapost = {
        "_token" : "{{ csrf_token() }}"
    }

    $.ajax({
        type : "POST",
        url : "{{ url('shipping/province') }}",
        data : datapost,
        beforeSend : function(){
            $('[name=province]').html('<option value="">Loading</option>');
            $('[name=city]').html('<option value="">Loading</option>');
        },
        success : function(data){
            $('[name=province]').html(data);
            $('[name=city]').html('<option value="">Select</option>');

            if ("{{ Session::get('city') }}") {
                shippingcity(2);
            }
        }
    })
}

function shippingcity(trigger){
    var province = $('[name=province]').val();
    var datapost = {
        "_token"    : "{{ csrf_token() }}",
        "province"  : province,
        "trigger"   : trigger
    }

    $.ajax({
        type : "POST",
        url : "{{ url('shipping/city') }}",
        data : datapost,
        beforeSend : function(){
            $('[name=city]').html('<option value="">Loading</option>');
        },
        success : function(data){
            $('[name=city]').html(data);
        }
    })
}
</script>

<script>
    $(document).ready(function () {
        if (window.location.hash == '#site') {
         $('#level1').removeClass('active');//remove active class
         $('#link1').removeClass('active');
         $('#level2').addClass('active');
         $('#link2').addClass('active');
        }
        if(window.location.hash=='#contact'){
            $('#level2').removeClass('active');//remove active class
            $('#link2').removeClass('active');
            $('#level1').addClass('active');
            $('#link1').addClass('active');
        }
    });
</script>
<!-- <script>
    //  $(document).ready(function(){
          var i=0;
          $('#addcare').click(function(){
              j=++i;
              //<td width="40%"><input type="text" class="form-control" name="varianname[]" id="varname'+ j +'"></td>
              // <td><input type="hidden" class="form-control" name="qty[]" id="varqty'+ j +'"></td>
               $('#dynamic_field_care').append('<tr id="row'+i+'"> <td><input type="text" class="form-control" name="emailcare[]" id="emailcare'+ j +'"></td><td><input type="text" class="form-control" id="phonecare'+ j +'" name="phonecare[]" ></td><td><input type="text" class="form-control" name="addresscare[]" id="addresscare'+ j +'" style="padding:0px;" ></td><td><input type="text" class="form-control" name="notecare[]" id="notecare'+ j +'"></td><td width="5%"><button type="button" name="remove" id="'+i+'" class="btn btn-sm btn-danger btn_remove">Delete</button></td></tr>');

          });
          $(document).on('click', '.btn_remove', function(){
               var button_id = $(this).attr("id");
               $('#row'+button_id+'').remove();
          });

    //  });
</script> -->
@endsection
