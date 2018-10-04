@extends('backend/app')
@section('content')
  <title>System | Content Category </title>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Form Page Category</h3>
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
            <h2>Update Page Category</h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form method="post" action="{{ url('backend/page-category/'.$row->kateg_id) }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <input type="hidden" value="PUT" name="_method">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Public <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="checkbox" class="flat" name="enable" <?php if($row->kateg_enable==1){echo "checked";}?>> Enable
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Name</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="kateg_name" required="required" value="{{$row->kateg_name}}" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Url</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="url" name="kateg_url" required="required" value="{{$row->kateg_url}}" readonly class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                  <a href="{{url('backend/page-category')}}" class="btn btn-default">Back</a>
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
