@extends('backend/app')
@section('content')
  <title>System | Cammpaign Buyyer</title>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Form Create Campaign Buyer</h3>
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
            <h2>Create Cammpaign Buyyer</h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form method="post" action="{{ url('backend/campaignbuy/create/') }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Name *</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="name" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label" style="">Member *</label>
                <div class="col-sm-9" style="">
                    <select class="selectpicker input-flat" data-live-search="true" name="member" required>
                        <option value="" selected disabled>Select Member</option>
                       @foreach($member as $kategs)
                          <option value="{{$kategs->member_id}}" data-tokens="">{{$kategs->member_email}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('member'))
                    <div style="color:red;">
                        {{ $errors->first('member') }}
                    </div>
                    @endif
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Target *</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" id="idtarget" name="target" min="0" value="0" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">PDF Upload</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" name="m12">
                  <input type="file" id="myPdf" name="myPdf" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="form-group">
                  <label class="control-label">Description *</label>
                  @if ($errors->has('desc'))
                  <div style="color:red;">
                      {{ $errors->first('desc') }}
                  </div>
                  @endif
                  <input type="text" class="form-control texteditor" name="desc" value="{{ old('desc') }}">
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
