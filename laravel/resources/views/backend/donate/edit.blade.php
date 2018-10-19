@extends('backend/app')
@section('content')
  <title>System | Donate</title>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Form Update Donate</h3>
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
            <h2>Update Donate</h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form method="post" action="{{ url('backend/donate/edit/'.$row->id) }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <input type="hidden" name="id" value="{{ $row->id }}">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Name *</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="name" required="required" value="{{$row->name}}" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label" style="">Parent</label>
                <div class="col-sm-9" style="">
                    <select class="selectpicker input-flat" data-live-search="true" name="parent" required>
                        <option value="" selected disabled>Select One</option>
                       @foreach($kateg as $kategs)
                          <option value="{{$kategs->id}}" <?php if($row->parent==$kategs->id){echo 'selected="selected"';}?> data-tokens="">{{$kategs->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('parent'))
                    <div style="color:red;">
                        {{ $errors->first('parent') }}
                    </div>
                    @endif
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img')}}" class="btn iframe-btn btn-success" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Image</i></a><br/>
                    <img src="{{asset($row->image)}}" id="viewimg" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>
                    <input type="hidden" name="image" class="form-control" id="img" value="{{asset($row->image)}}">
                </div>
              </div>
              <div class="form-group">
                  <label class="control-label">Description *</label>
                  @if ($errors->has('desc'))
                  <div style="color:red;">
                      {{ $errors->first('desc') }}
                  </div>
                  @endif
                  <input type="text" class="form-control texteditor" name="desc" value="{{$row->desc}}">
              </div>

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                  <a href="{{url('backend/donate/show/')}}" class="btn btn-default">Cancel</a>
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
