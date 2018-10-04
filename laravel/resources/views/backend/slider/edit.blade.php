@extends('backend/app')
@section('content')
<title>Update | Slider</title>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Update Slider</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Slider<small>management</small></h2>
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
                  <form class="form-horizontal" action="{{url('backend/slider/'.$row->slider_id)}}" method="post" enctype="multipart/form-data">
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
                      <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Type</label>
                      <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                        <select class="form-control" name="type" onchange="getinputform()">
                            <option value="0" <?php if($row->type == 0){echo "selected";} ?>>Image</option>
                            <option value="1" <?php if($row->type == 1){echo "selected";} ?>>Video</option>
                            <option value="2" <?php if($row->type == 2){echo "selected";} ?>>Youtube</option>
                        </select>
                      </div>
                    </div>

                    <div id="result">
                        <?php if($row->type == 0){ ?>
                            <div class="form-group">
                              <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Title</label>
                              <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                <input type="text" class="form-control" name="title" placeholder="Title" value="{{ $row->title }}">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Url</label>
                              <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                <input type="text"  class="form-control" name="url" placeholder="Url" value="{{ $row->url }}">
                              </div>
                            </div>

                          <div class="form-group">
                            <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Image</label>
                            <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                              <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img')}}" class="btn iframe-btn btn-danger" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Image</i></a><br/>
                              <img src="{{ asset($row->image) }}" id="viewimg" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>
                              <input type="hidden" name="image" class="form-control" id="img" value="{{ url('') }}/{{ $row->image }}">
                            </div>
                          </div>
                      <?php }elseif($row->type == 1){ ?>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Title</label>
                            <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                              <input type="text" class="form-control" name="title" placeholder="Title" value="{{ $row->title }}">
                            </div>
                          </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Video</label>
                          <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <a href="{{asset('assets/filemanager/dialog.php?type=3&field_id=img')}}" class="btn iframe-btn btn-danger" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Video</i></a><br/>
                            <!-- <video width="320" height="240" controls>
                              <source src="{{ asset($row->image) }}" type="video/mp4" id="viewimg">
                            </video> -->
                            <input type="hidden" name="image" class="form-control" id="img" value="{{ url('') }}/{{ $row->image }}">
                          </div>
                        </div>
                      <?php }else{ ?>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Title</label>
                            <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                              <input type="text" class="form-control" name="title" placeholder="Title" value="{{ $row->title }}">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Embed Code</label>
                            <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                              <input type="text"  class="form-control" name="url" placeholder="Embed Code" value="{{ $row->url }}">
                              <!-- <iframe width="420" height="315" src="https://www.youtube.com/embed/{{ $row->url }}"></iframe> -->
                            </div>
                          </div>
                      <?php } ?>
                  </div>


                </div>
                <div class="col-md-12" style="text-align:right;">
                  <div class="btn-group">
                    <button class="btn btn-sm btn-success" type="submit" data-original-title="Submit"><i class="fa fa-save"></i> Save</button>
                    <a href="{{url('backend/slider')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
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
    function getinputform(){
        var choosentype = $('[name=type]').val();
        if (choosentype == 0) {
            getformimage();
        }

        if (choosentype == 1) {
            getformvideo();
        }

        if (choosentype == 2) {
            getformyoutube();
        }
    }

    function getformimage(){
        $('#result').html(' <div class="form-group">'+
                              '<label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Title</label>'+
                              '<div class="col-sm-10" style="padding-left:0px;padding-right:0px;">'+
                                '<input type="text" class="form-control" name="title" placeholder="Title">'+
                              '</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                              '<label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Url</label>'+
                              '<div class="col-sm-10" style="padding-left:0px;padding-right:0px;">'+
                                '<input type="text"  class="form-control" name="url" placeholder="Url" value="http://">'+
                              '</div>'+
                            '</div>'+
                          '<div class="form-group">'+
                            '<label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Image</label>'+
                            '<div class="col-sm-10" style="padding-left:0px;padding-right:0px;">'+
                              '<a href="{{asset("assets/filemanager/dialog.php?type=1&field_id=img")}}" class="btn iframe-btn btn-danger" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Image</i></a><br/>'+
                              '<img src="" id="viewimg" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>'+
                              '<input type="hidden" name="image" value="" class="form-control" id="img">'+
                            '</div>'+
                          '</div>');
    }

    function getformvideo(){
        $('#result').html(' <div class="form-group">'+
                              '<label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Title</label>'+
                              '<div class="col-sm-10" style="padding-left:0px;padding-right:0px;">'+
                                '<input type="text" class="form-control" name="title" placeholder="Title">'+
                              '</div>'+
                            '</div>'+
                          '<div class="form-group">'+
                            '<label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Video</label>'+
                            '<div class="col-sm-10" style="padding-left:0px;padding-right:0px;">'+
                              '<a href="{{asset("assets/filemanager/dialog.php?type=3&field_id=img")}}" class="btn iframe-btn btn-danger" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Video</i></a><br/>'+
                              '<img src="" id="viewimg" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>'+
                              '<input type="hidden" name="image" value="" class="form-control" id="img">'+
                            '</div>'+
                          '</div>');
    }

    function getformyoutube(){
        $('#result').html(' <div class="form-group">'+
                              '<label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Title</label>'+
                              '<div class="col-sm-10" style="padding-left:0px;padding-right:0px;">'+
                                '<input type="text" class="form-control" name="title" placeholder="Title">'+
                              '</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                              '<label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Embed Code</label>'+
                              '<div class="col-sm-10" style="padding-left:0px;padding-right:0px;">'+
                                '<input type="text"  class="form-control" name="url" placeholder="Embed Code" value="">'+
                              '</div>'+
                            '</div>');
    }
</script>

@endsection
