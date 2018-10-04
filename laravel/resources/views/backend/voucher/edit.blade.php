@extends('backend/app')
@section('content')
<title>System | voucher</title>
<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Voucher Management</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Create Voucher</h2>
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
                  <form class="form-horizontal" action="{{url('backend/voucher/'.$row->voucher_id)}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Public</label>
                      <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                          <input type="checkbox" name="enable"  <?php if($row->voucher_status==1){echo 'checked';}?>> Enable
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Code</label>
                      <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                        <input type="text"  class="form-control" name="voucher_code"placeholder="" style=""value="{{$row->voucher_code}}" >
                        @if ($errors->has('voucher_code'))
                        <div style="color:red;">
                          {{ $errors->first('voucher_code') }}
                        </div>
                        @endif
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Name</label>
                      <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                        <input type="text"  class="form-control" name="voucher_name"placeholder="" style=""value="{{$row->voucher_name}}" required>
                      </div>
                    </div>


                       <div class="form-group">
                           <label for="inputEmail3 "style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Type</label>
                           <div class="col-sm-9" style="padding-left:0px;padding-right:0px;" >
                               <select id="selcate" name="voucher_type" class="form-control" required onchange="checktype()">
                                   <option value="">-- Select Type --</option>
                                   <option value="1"<?php if($row->voucher_type==1){echo "selected='selected'";}?>> Nominal(IDR) </option>
                                   <option value="2"<?php if($row->voucher_type==2){echo "selected='selected'";}?>> Percentage(%) </option>
                                   <option value="3"<?php if($row->voucher_type==3){echo "selected='selected'";}?>> Minimal Shopping(IDR) </option>
                               </select>
                           </div>
                       </div>
                        <div class="form-group">
                           <label for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Voucher Value</label>
                           <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                               <input id="vouchervalue" type="number" class="form-control" placeholder="" name="voucher_value" value="{{$row->voucher_value}}"required>
                               <label for="" style="color:red;">Leave blank if want to full Free Shipping</label>
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="inputEmail3"  style="padding-left:0px;padding-right:0px;"class="col-sm-3 text-left">Requirement Value</label>
                           <div class="col-sm-4" style="padding-left:0px;padding-right:0px;">
                               <input   type="number" class="form-control" placeholder="Min" name="voucher_min_value" id="rf"value="{{$row->voucher_min_value}}">
                           </div>
                           <label for="inputEmail3"style="padding-left:0px;padding-right:0px;" class="col-sm-1 text-center" style="height: 34px; padding: 0px; ">-</label>
                           <div class="col-sm-4"style="padding-left:0px;padding-right:0px;">
                               <input  type="number" class="form-control" placeholder="Max" name="voucher_max_value" id="ru" value="{{$row->voucher_max_value}}">
                           </div>
                       </div>

                       <div class="form-group">
                           <label for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Validity</label>
                           <div class="col-sm-4" style="padding-left:0px;padding-right:0px;">
                                 <input type="text" class="form-control" id="txtFrom" data-date-format="yyyy-mm-dd"  placeholder="From" value="{{$row->voucher_start_date}}" data-provide="datepicker" name="voucher_start_date" required>
                           </div>
                           <label for="inputEmail3"style="padding-left:0px;padding-right:0px;" class="col-sm-1 text-center" style="height: 34px; padding: 0px; ">-</label>
                           <div class="col-sm-4"style="padding-left:0px;padding-right:0px;">
                                 <input type="text" class="form-control" id="txtTo"  data-date-format="yyyy-mm-dd"  placeholder="Until" value="{{$row->voucher_end_date}}"data-provide="datepicker" name="voucher_end_date" required>
                           </div>
                       </div>
                       <div class="form-group">
                         <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Use Limit per User</label>
                         <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                           <input type="number"  class="form-control" name="voucher_limit_user"placeholder="" style=""value="{{$row->voucher_limit_user}}" required>
                         </div>
                       </div>
                       <div class="form-group">
                         <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Limit Usage</label>
                         <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                           <input type="number"  class="form-control" name="voucher_limit_usage"placeholder="" style=""value="{{$row->voucher_limit_usage}}" required>
                         </div>
                       </div>

                       <div class="col-md-12" style="text-align:right;padding-left:0px;padding-right:0px;">
                         <div class="btn-group">
                           <a href="{{url('backend/voucher')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" onclick="return validate()" data-original-title="Back"><i class="fa fa-reply"></i> Back</a>
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
      $('#vouchervalue').val('');
    }

</script>


@endsection
