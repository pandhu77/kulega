@extends('backend/app')
@section('content')
<title>Page Management</title>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Update Page</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Page<small>Management</small></h2>
        <!-- <div class="text-right" style="margin-bottom:20px;">
              <a href="{{ url('backend/page/create') }}" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>New Page</a>
              <a href="#" onclick="if(confirm('Are you sure?')) location.href='{{ URL::to('backend/page/delete/'.$page->id) }}'" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete </a>
        </div> -->
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
                  <form class="form-horizontal" action="{{action('Backend\CmsPageController@update')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden"name="pageid"  value="{{ $page->id }}">

                    <div class="form-group">
                        <label class="control-label col-sm-2"style="padding-left:0px;padding-right:0px;" for="first-name">Status
                        </label>
                        <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <input type="checkbox" name="enable" <?php if($page->enable == 1)echo "checked"; ?>> Publish
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Title</label>
                        <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <input type="text" class="form-control" name="title"placeholder="Title" id="title" value="{{ $page->title }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Slug</label>
                        <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <input type="text" class="form-control" name="url"placeholder="Url" id="url" value="{{ $page->url }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <b>Full URL : </b><span id="full-url">{{ url('page/'.$page->url) }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Meta Tag</label>
                        <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <?php $tag = explode(" , ",$page->meta_tag); ?>
                            <input id="tags_1" type="text" class="tags form-control" name="meta_tag[]" value="<?php foreach($tag as $tags){ echo $tags;} ?>" />
                            <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Meta Description</label>
                        <div class="col-sm-10"style="padding-left:0px;padding-right:0px;">
                            <textarea name="meta_desc" class="form-control"rows="3" cols="80">{{ $page->meta_desc }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Content</label>
                        <div class="col-sm-10"style="padding-left:0px;padding-right:0px;">
                            <input type="text" class="form-control texteditor" name="content" value="{{ $page->content }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Banner Image</label>
                        <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                            <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img')}}" class="btn iframe-btn btn-danger" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Image</i></a><br/>
                            <img src="<?php if($page->image ==! null ){?>{{asset($page->image)}}<?php }?>" id="viewimg" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>
                            <input type="hidden" name="image" value="{{asset($page->image)}}" class="form-control" id="img">
                        </div>
                    </div>


                </div>
                <div class="col-md-12" style="text-align:right;">
                  <div class="btn-group">
                    <button class="btn btn-sm btn-success" type="submit" data-original-title="Submit"><i class="fa fa-save"></i> Save</button>
                    <!-- <a href="{{url('backend')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a> -->

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
