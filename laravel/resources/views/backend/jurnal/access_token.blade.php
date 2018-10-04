@extends('backend/app')
@section('content')
<title>Access Token | Jurnal</title>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>JURNAL</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Access Token</small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">

          <!-- CONTENT MAIL -->
          <div class="col-sm-12 mail_view">
            <div class="inbox-body">
              <div class="mail_heading row">

                <div class="col-sm-8">
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
                  <form class="form-horizontal" action="{{ url('backend/jurnal-access') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                    <div id="result">
                        <div class="form-group">
                          <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Access Token</label>
                          <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <input type="text" class="form-control" name="jurnal" placeholder="{{ $data->placeholder }}" value="{{ $data->default_value }}">
                          </div>
                        </div>

                  </div>

                </div>
                <div class="col-md-8" style="text-align:right;">
                  <div class="btn-group">
                    <button class="btn btn-sm btn-success" type="submit" data-original-title="Submit"><i class="fa fa-save"></i> Save</button>
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
