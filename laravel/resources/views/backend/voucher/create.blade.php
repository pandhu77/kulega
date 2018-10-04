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
                  <form class="form-horizontal" action="{{action('Backend\VoucherController@store')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Public</label>
                      <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                          <input type="checkbox" name="enable" checked=""> Enable
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Code</label>
                      <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                        <input type="text"  class="form-control" name="voucher_code"placeholder="" style=""value="{{ old('voucher_code') }}" >
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
                        <input type="text"  class="form-control" name="voucher_name"placeholder="" style=""value="" required>
                      </div>
                    </div>


                       <div class="form-group">
                           <label for="inputEmail3 "style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Type</label>
                           <div class="col-sm-9" style="padding-left:0px;padding-right:0px;" >
                               <select id="selcate" name="voucher_type" class="form-control"  required onchange="checktype()">
                                   <option value="">-- Select Type --</option>
                                   <option value="1"> Nominal(IDR) </option>
                                   <option value="2"> Percentage(%) </option>
                                   <option value="3"> Minimal Shopping(IDR) </option>
                               </select>
                           </div>
                       </div>
                        <div class="form-group">
                           <label for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Voucher Value</label>
                           <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                               <input id="vouchervalue" type="number" class="form-control" placeholder="" name="voucher_value" required>
                               <label for="" style="color:red;">Leave blank if want to full Free Shipping</label>
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="inputEmail3"  style="padding-left:0px;padding-right:0px;"class="col-sm-3 text-left">Requirement Value</label>
                           <div class="col-sm-4" style="padding-left:0px;padding-right:0px;">
                               <input type="number" class="form-control" placeholder="Min" name="voucher_min_value" id="rf">
                           </div>
                           <label for="inputEmail3"style="padding-left:0px;padding-right:0px;" class="col-sm-1 text-center" style="height: 34px; padding: 0px; ">-</label>
                           <div class="col-sm-4"style="padding-left:0px;padding-right:0px;">
                               <input type="number" class="form-control" placeholder="Max" name="voucher_max_value" id="ru">
                           </div>
                       </div>

                       <div class="form-group">
                           <label for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Validity</label>
                           <div class="col-sm-4" style="padding-left:0px;padding-right:0px;">
                                 <input type="text" class="form-control" id="txtFrom"   placeholder="From"  name="voucher_start_date" required>
                           </div>
                           <label for="inputEmail3"style="padding-left:0px;padding-right:0px;" class="col-sm-1 text-center" style="height: 34px; padding: 0px; ">-</label>
                           <div class="col-sm-4"style="padding-left:0px;padding-right:0px;">
                                 <input type="text" class="form-control" id="txtTo"  placeholder="Until" name="voucher_end_date" required>
                           </div>
                       </div>
                       <div class="form-group">
                         <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Use Limit per User</label>
                         <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                           <input type="number"  class="form-control" name="voucher_limit_user"placeholder="" style=""value="" required>
                         </div>
                       </div>
                       <div class="form-group">
                         <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Limit Usage</label>
                         <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                           <input type="number"  class="form-control" name="voucher_limit_usage"placeholder="" style=""value="" required>
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
