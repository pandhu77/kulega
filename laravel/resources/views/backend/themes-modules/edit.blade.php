@extends('backend/app')
@section('content')

<title>Module</title>
<div class="page-title">
    <div class="title_left">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3>Edit Module</h3>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <form class="form-horizontal" action="{{ url('backend/themes-module/'.$module->id) }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" name="_method" value="PUT">
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
                                                <input type="text" class="form-control" name="name" value="{{ $module->name }}" required>
                                            </div>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Function</label>
                                            <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                                <textarea name="m_function" class="form-control" rows="10">{{ $module->m_function }}</textarea>
                                            </div>
                                        </div> -->

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

                                        <?php $i = 0; ?>
                                        @foreach($submodule as $sub)
                                        <div class="submod-row{{ $i }}">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Sub Module Name</label>
                                                <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                                                    <input type="text" class="form-control" name="sub_name[]" value="{{ $sub->name }}" required>
                                                </div>
                                                @if($i != 0)
                                                <div class="col-sm-1" style="padding-left:0px;padding-right:0px;">
                                                    <button type="button" class="btn btn-danger" onclick="removesubmod({{ $i }})">Delete</button>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">SQL Function</label>
                                                <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                                    <input type="text" name="det_function[]" class="form-control" value="{{ $sub->det_function }}" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">HTML</label>
                                                <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                                    <input type="text" name="det_html[]" class="form-control" value="{{ $sub->det_html }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Return</label>
                                                <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                                    <input type="text" name="det_return[]" class="form-control" value="{{ $sub->det_return }}" required>
                                                </div>
                                            </div><br><br>
                                        </div>

                                        <?php $i++; ?>
                                        @endforeach

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

<script type="text/javascript">
    var j = 100;
    function addsubmod(){
        $('#content-submod').append('   <div class="submod-row'+j+'">'+
                                    '       <div class="form-group">'+
                                    '           <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Sub Module Name</label>'+
                                    '           <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">'+
                                    '               <input type="text" class="form-control" name="sub_name[]" value="{{ old("sub_name") }}" required>'+
                                    '           </div>'+
                                    '           <div class="col-sm-1" style="padding-left:0px;padding-right:0px;">'+
                                    '               <button type="button" class="btn btn-danger" onclick="removesubmod('+j+')">Delete</button>'+
                                    '           </div>'+
                                    '       </div>'+
                                    '       <div class="form-group">'+
                                    '           <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">SQL Function</label>'+
                                    '           <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">'+
                                    '               <input type="text" name="det_function[]" class="form-control" value="{{ old("det_function") }}">'+
                                    '           </div>'+
                                    '       </div>'+
                                    '       <div class="form-group">'+
                                    '           <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">HTML</label>'+
                                    '           <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">'+
                                    '               <input type="text" name="det_html[]" class="form-control" value="{{ old("det_html") }}" required>'+
                                    '           </div>'+
                                    '       </div>'+
                                    '       <div class="form-group">'+
                                    '           <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Return</label>'+
                                    '           <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">'+
                                    '               <input type="text" name="det_return[]" class="form-control" value="{{ old("det_return") }}" required>'+
                                    '           </div>'+
                                    '       </div><br><br>'+
                                    '   </div>');

        j++;
    }

    function removesubmod(rowid){
        $('.submod-row'+rowid).remove();
    }
</script>

@endsection
