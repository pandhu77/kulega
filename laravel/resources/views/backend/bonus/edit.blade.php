@extends('backend/app')
@section('content')
<title>System | bonus</title>
<script src="{{asset('template/vendors/jquery/dist/jquery.min.js')}}"></script>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Bonus Management</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Create Bonus</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">

          <!-- CONTENT MAIL -->
            <div class="col-sm-6 mail_list_column">
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
                  <form class="form-horizontal" action="{{url('backend/bonus/'.$row->bonus_id)}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="_method" value="PUT">

                      <div class="form-group">
                        <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Name</label>
                        <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                          <input type="text"  class="form-control" name="bonus_name"placeholder="" style=""value="{{$row->bonus_name}}" required>
                        </div>
                      </div>
                       <div class="form-group">
                           <label for="inputEmail3 "style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Reward</label>
                           <div class="col-sm-9" style="padding-left:0px;padding-right:0px;" >
                               <select id="selcate" name="bonus_reward" class="form-control" onchange="checktype()" required>
                                   <option value="">-- Select Reward --</option>
                                   <option value="precent"<?php if($row->bonus_reward=='precent'){echo "selected='selected'";}?>> Percentage(%) </option>
                                   <option value="nominal"<?php if($row->bonus_reward=='nominal'){echo "selected='selected'";}?>> Nominal(IDR) </option>

                               </select>
                           </div>
                       </div>
                        <div class="form-group">
                           <label for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Bonus Value</label>
                           <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                               <input id="bonusvalue" type="text" class="form-control" placeholder="" name="bonus_value" value="{{$row->bonus_value}}"required>
                           </div>
                       </div>

                       <div class="form-group">
                         <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Point</label>
                         <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                           <input type="number"  class="form-control" name="bonus_poin"placeholder="" style=""value="{{$row->bonus_poin}}" required>
                         </div>
                       </div>

                       <div class="col-md-12" style="text-align:right;padding-left:0px;padding-right:0px;">
                         <div class="btn-group">
                           <a href="{{url('backend/bonus')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" onclick="return validate()" data-original-title="Back"><i class="fa fa-reply"></i> Back</a>
                           <button class="btn btn-sm btn-success" type="submit" data-original-title="Submit"><i class="fa fa-share"></i> Submit</button>
                         </div>
                       </form>
                       </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    function checktype(){
      $('#bonusvalue').val('');
    }

</script>


@endsection
