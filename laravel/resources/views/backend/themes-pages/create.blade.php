@extends('backend/app')
@section('content')

<title>Pages</title>
<div class="page-title">
    <div class="title_left">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3>Create Pages</h3>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <form class="form-horizontal" action="{{ url('backend/themes-pages') }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Pages<small>management</small></h2>
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
                                            <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Pages Name</label>
                                            <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
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
                    <h2>Module<small>management</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">

                        <!-- CONTENT MAIL -->
                        <div class="col-sm-12 mail_view">
                            <div class="inbox-body">
                                <div class="mail_heading row">
                                    <div class="col-md-12" id="content-mod">

                                        <div class="mod-row">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Module Name</label>
                                                <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                                    <select class="form-control" name="module[]" onchange="submod(0)" id="module0" required>
                                                        <option value="" selected="" disabled="">Select</option>
                                                        @foreach($module as $mod)
                                                            <option value="{{ $mod->id }}">{{ $mod->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" style="padding-left:0px;padding-right:0px;">Sub Module</label>
                                                <div class="col-sm-10" style="padding-left:0px;padding-right:0px;">
                                                    <select class="form-control" name="submodule[]" id="submodule0" required>
                                                        <option value="" selected="" disabled="">Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                        </div>

                                    </div>

                                    <div class="col-md-offset-2 col-md-6" style="text-align:left;">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-info" type="button" onclick="addmod()">Add Module</button>
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
    var j = 1;
    function addmod(){
        $.get("{{ url('backend/themespages/addmodule') }}/"+j, function(data, status){
            $('#content-mod').append(data);
        });
        j++;
    }

    function submod(rowid){
        var module_id = $('#module'+rowid).val();
        var datapost = {
            '_token'    : '{{ csrf_token() }}',
            'module_id' : module_id
        }

        $.ajax({
            type    : "POST",
            url     : "{{ url('backend/themespages/getsubmodule') }}",
            data    : datapost,
            beforeSend : function(){
                $('#submodule'+rowid).html('<option value="" selected="" disabled="">Loading</option>');
            },
            success : function(data){
                $('#submodule'+rowid).html(data);
            }
        })
    }

    function delrowmod(rowid){
        $('.mod-row'+rowid).remove();
    }
</script>

@endsection
