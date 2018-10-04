@extends('backend/app')
@section('content')
  <title>System | Product Brand </title>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Form Brand</h3>
      </div>

      <div class="title_right">

      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      @if($errors->all())
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h4>
        @foreach($errors->all() as $error)
        <?php echo $error."</br>";?>
        @endforeach
      </div>
      @endif
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Brand</h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form action="{{url('backend/brand/'.$row->brand_id)}}" method="post" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
              <input type="hidden"name="_method" value="PUT">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Public <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="checkbox" <?php if($row->brand_enable==1){echo "checked";}?> class="flat" name="enable"> Enable
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="name" required="required" value="{{$row->brand_name}}" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Url <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text"id="url"  name="brand_url" value="{{$row->brand_url}}" required="required" readonly class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Logo</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img')}}" class="btn iframe-btn btn-success" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Image</i></a><br/>
                    <img src="{{asset($row->brand_logo)}}" id="viewimg" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>
                    <input type="hidden" name="image" value="{{asset($row->brand_logo)}}" class="form-control" id="img">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Banner</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img2')}}" class="btn iframe-btn btn-danger" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Image</i></a><br/>
                    <img src="<?php if($row->brand_banner ==! null ){?>{{asset($row->brand_banner)}}<?php }?>" id="viewimg2" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>
                    <input type="hidden" name="brand_banner" value="{{asset($row->brand_banner)}}" class="form-control" id="img2">
                </div>
              </div>


              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <a href="{{url('backend/brand')}}" class="btn btn-default">Cancel</a>
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
