@extends('backend/app')
@section('content')
<title>Update | Shipping</title>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Update Shipping</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Shipping<small>management</small></h2>
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


                      @if($errors->all())
                      <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h4>
                        @foreach($errors->all() as $error)
                        <?php echo $error."</br>";?>
                        @endforeach
                      </div>
                      @endif
                  <form class="form-horizontal" action="{{url('backend/shipping/'.$row->id)}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="form-group">
                      <label class="control-label col-sm-2"style="padding-left:0px;padding-right:0px;" for="first-name">Public <span class="required">*</span>
                      </label>
                      <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <input type="checkbox" name="enable" <?php if($row->enable==1){echo "checked";}?>> Enable
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Code</label>
                      <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                        <input type="text" class="form-control" name="code" placeholder="Code" value="{{ $row->code }}" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Name</label>
                      <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $row->name }}" >
                      </div>
                    </div>

                </div>
                <div class="col-md-12" style="text-align:right;">
                  <div class="btn-group">
                    <button class="btn btn-sm btn-success" type="submit" data-original-title="Submit"><i class="fa fa-save"></i> Save</button>
                    <a href="{{url('backend/shipping')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
                  </div>
                </form>
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

@endsection
