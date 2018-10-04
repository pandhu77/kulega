@extends('backend/app')
@section('content')
<title>Create | Content</title>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Content Management</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Content<small>management</small></h2>

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
                    @if(Session::has('success-delete'))
                      <div class="alert alert-info alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
                          {{ Session::get('success-delete') }}
                      </div>
                    @endif

                  @if(Session::has('errors-data'))
                    <div class="alert alert-danger alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      {{ Session::get('errors-data') }}
                    </div>
                    @endif
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
                  <form class="form-horizontal" action="{{url('backend/content/'.$row->blog_id)}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                   <input type="hidden"name="_method" value="PUT">
                    <div class="form-group">
                      <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Post Date</label>
                      <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                        <input type="text" readonly class="form-control" name="updated_at"placeholder="" style=""value="{{$row->created_at}}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2"style="padding-left:0px;padding-right:0px;" for="first-name">Public <span class="required">*</span>
                      </label>
                      <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <input type="checkbox" name="enable" <?php if($row->enable==1){echo "checked";}?>> Enable
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Category</label>
                        <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <select name="kateg" class="form-control" required>
                                  <option value="">--Select Category--</option>

                                @foreach($kateg as $kategs)
                                  <option value="{{$kategs->kateg_id}}"<?php if($row->categ_id==$kategs->kateg_id){echo 'selected="selected"';} ?>>{{$kategs->kateg_name}}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Title</label>
                      <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                        <input type="text" class="form-control" name="title"placeholder="Title" id="title"  style=""value="{{$row->title}}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Url</label>
                      <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                        <input type="text" readonly class="form-control" name="url"placeholder="Url" id="url"  style=""value="{{$row->url}}">
                      </div>
                    </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Meta Tag</label>
                        <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                          <?php
                          $tag= explode(" , ",$row->tags);
                          ?>
                          <input id="tags_1" type="text" class="tags form-control" name="meta_tag[]" value="<?php foreach($tag as $tags){
                            echo $tags;
                          }?>" />
                          <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>

                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Meta Description</label>
                        <div class="col-sm-10"style="padding-left:0px;padding-right:0px;">
                            <textarea name="meta_desc" class="form-control"rows="3" cols="80">{{$row->meta_desc}}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Content</label>
                        <div class="col-sm-10"style="padding-left:0px;padding-right:0px;">
                          <input type="text" class="form-control texteditor" name="content" value="{{$row->content}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Image</label>
                        <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                          <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img')}}" class="btn iframe-btn btn-danger" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Image</i></a><br/>
                          <img src="<?php if($row->image ==! null ){?>{{asset($row->image)}}<?php }?>" id="viewimg" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>
                          <input type="hidden" name="image" value="{{asset($row->image)}}" class="form-control" id="img">
                        </div>
                      </div>

                </div>
                <div class="col-md-12" style="text-align:right;">
                  <div class="btn-group">
                    <button class="btn btn-sm btn-success" type="submit" data-original-title="Submit"><i class="fa fa-save"></i> Save</button>
                    <a href="{{url('backend/content')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
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
