@extends('backend/app')
@section('content')
  <title>System | Product Category </title>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Form Product Category</h3>
      </div>

      <div class="title_right">

      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
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
        <div class="x_panel">
          <div class="x_title">
            <h2>Create Product Category</h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form method="post" action="{{ url('backend/product-category') }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="checkbox" class="flat" name="enable" checked> Enable
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Show <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="checkbox" class="flat" name="kateg_show" value="1"> Show
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label" style="">Parent</label>
                <div class="col-sm-9" style="">
                    <select class="selectpicker input-flat" data-live-search="true" name="kateg_parent" required>
                        <option value="" selected disabled>Select One</option>
                        <option value="0">No Parent</option>
                       @foreach($kateg as $kategs)
                          <option value="{{$kategs->kateg_id}}" data-tokens="">{{$kategs->kateg_name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('kateg_parent'))
                    <div style="color:red;">
                        {{ $errors->first('kateg_parent') }}
                    </div>
                    @endif
                </div>
            </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Name *</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="kateg_name" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Url *</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="url" name="kateg_url" required="required"  readonly class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img')}}" class="btn iframe-btn btn-success" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Image</i></a><br/>
                    <img src=" " id="viewimg" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>
                    <input type="hidden" name="image" class="form-control" id="img">
                </div>
              </div>

              <!-- <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Banner</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img2')}}" class="btn iframe-btn btn-danger" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Image</i></a><br/>
                    <img src="" id="viewimg2" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>
                    <input type="hidden" name="kateg_banner" class="form-control" id="img2">
                </div>
              </div> -->


              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <a href="{{url('backend/product-category')}}" class="btn btn-default">Cancel</a>
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
