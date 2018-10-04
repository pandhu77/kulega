@extends('backend/app')
@section('content')
  <title>System | Reply Contact </title>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Form Reply</h3>
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
            <h2>Message</h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form action="#" method="post" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
              <input type="hidden"name="_method" value="PUT">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" readonly="" value="{{ $row->name }}" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" readonly="" value="{{ $row->email }}" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Phone
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" readonly="" value="{{ $row->phone }}" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Subject
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" readonly="" value="{{ $row->subject }}" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="message" rows="6" class="form-control" readonly="">{{ $row->message }}</textarea>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Reply Message</h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form action="{{url('backend/contact/'.$row->id)}}" method="post" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
              <input type="hidden"name="_method" value="PUT">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Subject <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="subject" required="required" value="{{ old('subject') }}" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="message" rows="6" class="form-control">{{ old('message') }}</textarea>
                </div>
              </div>

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <a href="{{url('backend/contact')}}" class="btn btn-default">Cancel</a>
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
