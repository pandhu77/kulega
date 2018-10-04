@extends('backend/app')
@section('content')

<link rel=stylesheet href="{{ asset('assets/codemirror-5.30.0/doc/docs.css') }}">
<link rel="stylesheet" href="{{ asset('assets/codemirror-5.30.0/lib/codemirror.css') }}">
<script src="{{ asset('assets/codemirror-5.30.0/lib/codemirror.js') }}"></script>
<script src="{{ asset('assets/codemirror-5.30.0/mode/xml/xml.js') }}"></script>
<script src="{{ asset('assets/codemirror-5.30.0/addon/selection/active-line.js') }}"></script>
<style type="text/css">
    .CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black;}
</style>

<title>Module</title>
<div class="page-title">
    <div class="title_left">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3>Create Module</h3>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <form class="form-horizontal" action="{{ url('backend/themes-module') }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
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
                                        @if($errors->all())
                                        <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h4>
                                            @foreach($errors->all() as $error)
                                            <?php echo $error."</br>";?>
                                            @endforeach
                                        </div>
                                        @endif

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Module Name</label>
                                            <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Function</label>
                                            <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                                <textarea name="m_function" class="form-control" rows="10" required></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Return</label>
                                            <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                                <input type="text" name="m_return" class="form-control" value="{{ old('m_return') }}" required>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /CONTENT MAIL -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Sub Module<small>management</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">

                        <!-- CONTENT MAIL -->
                        <div class="col-sm-12 mail_view">
                            <div class="inbox-body">
                                <div class="mail_heading row">
                                    <div class="col-md-12" id="content-submod">

                                        <div class="submod-row">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Sub Module Name</label>
                                                <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                                    <input type="text" class="form-control" name="sub_name[]" value="{{ old('sub_name') }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">HTML</label>
                                                <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                                    <input type="text" name="det_html[]" class="form-control" value="{{ old('det_html') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-offset-2 col-md-6" style="text-align:left;">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-info" type="button" onclick="addsubmod()">Add Sub Module</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="text-align:right;">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-success" type="submit" data-original-title="Submit"><i class="fa fa-save"></i> Save</button>
                                            <a href="{{url('backend/themes-module')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /CONTENT MAIL -->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    var nonEmpty = false;
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        mode: "application/xml",
        styleActiveLine: true,
        lineNumbers: true,
        lineWrapping: true
    });
</script>

<script type="text/javascript">
    var i = 1;
    function addsubmod(){
        $('#content-submod').append('   <div class="submod-row'+i+'">'+
                                    '       <div class="form-group">'+
                                    '           <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Sub Module Name</label>'+
                                    '           <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">'+
                                    '               <input type="text" class="form-control" name="sub_name[]" value="{{ old("sub_name") }}" required>'+
                                    '           </div>'+
                                    '           <div class="col-sm-1" style="padding-left:0px;padding-right:0px;">'+
                                    '               <button type="button" class="btn btn-danger" onclick="removesubmod('+i+')">Delete</button>'+
                                    '           </div>'+
                                    '       </div>'+
                                    '       <div class="form-group">'+
                                    '           <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">HTML</label>'+
                                    '           <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">'+
                                    '               <input type="text" name="det_html[]" class="form-control" value="{{ old("det_html") }}" required>'+
                                    '           </div>'+
                                    '       </div>'+
                                    '   </div>');

        i++;
    }

    function removesubmod(rowid){
        $('.submod-row'+rowid).remove();
    }
</script>

@endsection
