@extends('backend/app')
@section('content')
  <title>System | Campaign </title>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Form Campaign</h3>
      </div>

      <div class="title_right">

      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
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
        <div class="x_panel">
          <div class="x_title">
            <h2>Update Campaign</h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form method="post" action="{{ url('backend/campaign/'.$row->id) }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <input type="hidden" value="PUT" name="_method">
              <form method="post" action="{{ url('backend/campaign') }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label" style="">Campaign Buyyer</label>
                <div class="col-sm-9" style="">
                    <select class="selectpicker input-flat" id="selectBuyyer" data-live-search="true" name="buyyer">
                        <option value="" selected disabled>Select One</option>
                       @foreach($buyyer as $buyyers)
                          <option value="{{$buyyers->id}}" data-tokens="" <?php if($row->buyyerid==$buyyers->id){echo 'selected="selected"';}?>>{{$buyyers->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('parent'))
                    <div style="color:red;">
                        {{ $errors->first('parent') }}
                    </div>
                    @endif
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label" style="">Category</label>
                <div class="col-sm-9" style="">
                    <select class="selectpicker input-flat" data-live-search="true" name="parent" required>
                        <option value="" selected disabled>Select One</option>
                       @foreach($kateg as $kategs)
                          <option value="{{$kategs->kateg_id}}" <?php if($row->parent==$kategs->kateg_id){echo 'selected="selected"';}?> data-tokens="">{{$kategs->kateg_name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('parent'))
                    <div style="color:red;">
                        {{ $errors->first('parent') }}
                    </div>
                    @endif
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="checkbox" class="flat" name="enable" <?php if($row->enable==1){echo "checked";}?>> Enable
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Show <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="checkbox" class="flat" name="show" value="1" <?php if($row->show==1){echo "checked";}?>> Show
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Name *</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="name" required="required" value="{{$row->name}}" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Url *</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="url" name="url" required="required" value="{{$row->url}}" readonly class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label" style="">Member</label>
                <div class="col-sm-9" style="">
                    <select class="selectpicker input-flat" data-live-search="true" id="idmember" name="member" required>
                        <option value="" selected disabled>Select One</option>
                        @foreach($member as $members)
                          <option value="{{$members->member_id}}" <?php if($row->memberid==$members->member_id){echo 'selected="selected"';}?> data-tokens="">{{$members->member_username}} {{$members->member_email}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('parent'))
                    <div style="color:red;">
                        {{ $errors->first('parent') }}
                    </div>
                    @endif
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="{{asset('assets/filemanager/dialog.php?type=1&field_id=img')}}" class="btn iframe-btn btn-success" type="button" style="margin-bottom:10px;"><i class="fa fa-camera"> Image</i></a><br/>
                    <img src="{{asset($row->image)}}" id="viewimg" class="img-responsive" style="max-width:1000px;max-height:300px;"/><br/>
                    <input type="hidden" name="image" class="form-control" id="img" value="{{asset($row->image)}}">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Target *</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" id="idtarget" name="target" min="0" value="{{$row->target}}" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                  <label class="control-label">Description *</label>
                  @if ($errors->has('desc'))
                  <div style="color:red;">
                      {{ $errors->first('desc') }}
                  </div>
                  @endif
                  <input type="text" class="form-control texteditor" name="desc" value="{{$row->desc}}">
              </div>

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                  <a href="{{url('backend/campaign')}}" class="btn btn-default">Cancel</a>
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
$(document).ready(function(){
    $('#selectBuyyer').change(function(){
      var _id = $(this).val();
      $.ajax({
          url : "{{ url('/backend/campaign/getbuyyer/') }}",
          method : "POST",
          data : { id : _id,_token : "{{ csrf_token() }}" }
      }).success(function(response){
          if("OK" === response.Result)
          {
              $('#title').val(response.Title);
              $('#title').keyup();
              $('#idtarget').val(response.Target);
              $('#iddesc').val(response.Desc);
          }
          else
          {
              swal("Oooops",'Something went wrong.','error');
          }
      });
    });
});
</script>
@endsection
