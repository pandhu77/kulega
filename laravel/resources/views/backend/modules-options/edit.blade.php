@extends('backend/app')
@section('content')
<title>Module Management</title>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Update <?= strtoupper($module_name) ?></h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Module<small>management</small></h2>
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
                  <form class="form-horizontal" action="{{url('backend/module-opt/'.$module_name)}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                    @foreach($module_all as $mod)
                    <div class="form-group">
                      <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px; text-transform:capitalize;">{{ $mod->code }}</label>
                      <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                          @if($mod->code == 'image')
                            <input type="text" class="form-control" name="{{ $mod->code }}" id="imgvalue" placeholder="assets/img/{{ $mod->module }}/" value="{{ $mod->value }}">
                            <input type="hidden" class="form-control" id="img" value="{{ $mod->value }}" onchange="validurl()">
                            <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img')}}" class="btn iframe-btn btn-danger" type="button" style="margin-bottom:10px;">
                                <i class="fa fa-camera"> Upload</i>
                            </a>
                            <span style="color:red">*Upload Image in folder {{ $mod->module }} and then input the image name to Form</span>
                            <br/>
                            <img src="{{asset($mod->value)}}" id="viewimg" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>
                          @elseif($mod->code == 'description')
                            <input type="text" class="form-control texteditor" name="{{ $mod->code }}" value="{{ $mod->value }}">
                          @else
                            <input type="text" class="form-control" name="{{ $mod->code }}" placeholder="{{ $mod->placeholder }}" value="{{ $mod->value }}">
                            @if($mod->module == 'instagram')
                                <br>
                                <a href="https://instagram.com/oauth/authorize/?client_id=8e1a1c07c3314f74b05c35deeadcbd9a&redirect_uri=http://iamaddicted.id/&response_type=token&scope=likes+comments+relationships+basic" target="_blank" class="btn btn-warning">GET NEW ACCESS TOKEN</a>
                            @else

                            @endif
                          @endif
                      </div>
                    </div>
                    @endforeach

                </div>
                <div class="col-md-12" style="text-align:right;">
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


<script type="text/javascript">
    function validurl(){
        var url_now     = '{{ url('') }}';
        var getlength   = parseInt(url_now.length) + 1;
        var image       = $('#img').val();

        var geturl      = image.substr(getlength);
        $('#imgvalue').val(geturl);
    }
</script>


@endsection
