@extends('backend/app')
@section('content')
<title>System | Discount</title>

<div class="page-title">
  <div class="title_left">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <h3>Discount Management</h3>
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Discount</h2>
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
                  <form class="form-horizontal" action="{{url('backend/discount/'.$row->disc_id)}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden"name="_method" value="PUT">

                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Public</label>
                      <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                          <input type="checkbox" name="enable" <?php if($row->disc_enable==1){echo 'checked';}?> >Enable
                      </div>
                    </div>
                    <!-- <div class="form-group">
                      <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Code</label>
                      <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                        <input type="text"  class="form-control" name="code"placeholder="" style=""value="">
                      </div>
                    </div> -->
                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Name</label>
                      <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                        <input type="text"  class="form-control" name="name"placeholder="" style=""value="{{$row->disc_name}}" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" style="padding-left:0px;padding-right:0px;">Type</label>
                      <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                        <select id="sortby" name="type" class="form-control" onchange="sortBy()" required>
                                <option value="catalog"<?php if($row->disc_type=='catalog'){echo 'selected="selected"';}?>> Catalog </option>
                                <option value="cart"<?php if($row->disc_type=='cart'){echo 'selected="selected"';}?>> Cart </option>
                        </select>
                      </div>
                    </div>
                    <script>
                           function sortBy() {
                               var by = document.getElementById('sortby').value;
                               if (by == "catalog") {
                                   document.getElementById("req").style.display = "none";
                                   document.getElementById("rf").required = false;
                                   document.getElementById("ru").required = false;
                               }
                               else if (by == "cart") {
                                   document.getElementById("req").style.display = "inline";
                                   document.getElementById("rf").required = true;
                                   document.getElementById("ru").required = true;
                                   $('#rf').val('');
                                   $('#ru').val('');
                               }
                           }
                       </script>


                    <div id="req" style="<?php if($row->disc_type=='cart'){echo 'display: block';}else{echo 'display: none';}?>">
                       <div class="form-group">
                           <label  for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Discount Requirement</label>
                           <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                               <select  name="requirement"  class="form-control" >
                                   <option value="-">-- Select Requirement --</option>
                                   <!-- <option value="quantity"<?php if($row->disc_req=='quantity'){echo 'selected="selected"';}?>> Quantity </option> -->
                                   <option value="total-shopping"<?php if($row->disc_req=='total-shopping'){echo 'selected="selected"';}?>> Total Shopping Cart Nominal </option>
                               </select>
                           </div>
                       </div>

                       <div class="form-group">
                           <label for="inputEmail3"  style="padding-left:0px;padding-right:0px;"class="col-sm-3 text-left">Requirement Value</label>
                           <div class="col-sm-4" style="padding-left:0px;padding-right:0px;">
                               <input type="number"  class="form-control" placeholder="From" name="rfValue" id="rf" value="{{$row->disc_min}}" >
                           </div>
                           <label for="inputEmail3"style="padding-left:0px;padding-right:0px;" class="col-sm-1 text-center" style="height: 34px; padding: 0px; ">-</label>
                           <div class="col-sm-4"style="padding-left:0px;padding-right:0px;">
                               <input  type="number" class="form-control" placeholder="Until" name="ruValue" id="ru" value="{{$row->disc_max}}" >
                           </div>
                       </div>
                 </div>
                       <div class="form-group">
                           <label for="inputEmail3 "style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Discount Reward</label>
                           <div class="col-sm-9" style="padding-left:0px;padding-right:0px;" required>
                               <select id="selcate" name="reward" class="form-control" onchange="checkreward()">
                                   <option value="">-- Select Reward --</option>
                                   <option value="percent"<?php if($row->disc_reward=='percent'){echo 'selected="selected"';}?>> Percentage(%) </option>
                                   <option value="nominal"<?php if($row->disc_reward=='nominal'){echo 'selected="selected"';}?>> Nominal(IDR) </option>
                               </select>
                           </div>
                       </div>

                        <div class="form-group">
                           <label for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Reward Value</label>
                           <div class="col-sm-9" style="padding-left:0px;padding-right:0px;">
                               <input id="discvalue" type="number" class="form-control" placeholder="Discount Reward" name="rValue" value="{{$row->disc_reward_value}}" required>
                           </div>
                       </div>

                       <div class="form-group">
                           <label for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Validity</label>
                           <div class="col-sm-4" style="padding-left:0px;padding-right:0px;">
                                 <input type="text" class="form-control" id="txtFrom" data-date-format="yyyy-mm-dd"  placeholder="From" data-provide="datepicker" name="fromDate" value="{{$row->disc_start_date}}" required>
                           </div>
                           <label for="inputEmail3"style="padding-left:0px;padding-right:0px;" class="col-sm-1 text-center" style="height: 34px; padding: 0px; ">-</label>
                           <div class="col-sm-4"style="padding-left:0px;padding-right:0px;">
                                 <input type="text" class="form-control" id="txtTo" data-date-format="yyyy-mm-dd"  placeholder="Until" data-provide="datepicker" name="untilDate" value="{{$row->disc_end_date}}" required>
                           </div>
                       </div>

                       <div class="form-group">
                          <label for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-3 text-left">Stack</label>
                          <div class="col-sm-3" style="padding-left:0px;padding-right:0px;">
                              <input type="checkbox" name="stacki" value="itself"  <?php if($row->disc_stacked=='itself'){echo 'checked';}?><?php if($row->disc_stacked=='itselfother'){echo 'checked';}?>> With itself
                          </div>
                          <div class="col-sm-3" style="padding-left:0px;padding-right:0px;">
                              <input type="checkbox" name="stacko" value="other" <?php if($row->disc_stacked=='other'){echo 'checked';}?><?php if($row->disc_stacked=='itselfother'){echo 'checked';}?>> With other
                          </div>
                      </div>
                </div>

              </div>
            </div>

          </div>
          <!-- /CONTENT MAIL -->
          <div class="col-md-6 mail_view">
            <div class="inbox-body">
              <div class="mail_heading row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="inputEmail3" style="padding-left:0px;padding-right:0px;" class="col-sm-12 text-left">Select Product</label>
                      <div class="col-sm-12" style="padding-left:0px;padding-right:0px;">
                        <select class="select2pro" multiple="multiple" style="width: 100%" name="pro[]">
                          <?php
                          $disc_prod= explode(", ",$row->disc_prod_id);
                          ?>
                          @foreach ($prod as $p)

                          <option value="{{ $p->prod_id }}"
                            <?php
                              foreach($disc_prod as $disc_prods){
                                    if($p->prod_id==$disc_prods){
                                        echo 'selected="selected"';
                                    }
                                  }
                              ?>
                           >{{$p->prod_title}}</option>

                          @endforeach
                        </select>

                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3"style="padding-left:0px;padding-right:0px;" class="col-sm-12 text-left">Select Category</label>
                      <div class="col-sm-12" style="padding-left:0px;padding-right:0px;">
                        <select class="select2cat"  multiple="multiple" style="width: 100%" name="cat[]">
                          <?php
                          $disc_kateg= explode(", ",$row->disc_kateg_id);
                          ?>
                          @foreach ($kateg as $c)
                          <option value="{{ $c->kateg_id }}"
                            <?php
                              foreach($disc_kateg as $disc_kategs){
                                    if($c->kateg_id==$disc_kategs){
                                        echo 'selected="selected"';
                                    }
                                  }
                              ?>
                          >{{$c->kateg_name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3"style="padding-left:0px;padding-right:0px;" class="col-sm-12 text-left">Select Brand</label>
                      <div class="col-sm-12" style="padding-left:0px;padding-right:0px;">
                        <select class="select2bra" multiple="multiple" style="width: 100%" name="bra[]">
                          <?php
                          $disc_brand= explode(", ",$row->disc_brand_id);
                          ?>
                          @foreach ($brand as $b)
                          <option value="{{ $b->brand_id }}"
                            <?php
                              foreach($disc_brand as $disc_brands){
                                    if($b->brand_id==$disc_brands){
                                        echo 'selected="selected"';
                                    }
                                  }
                              ?>
                          >{{$b->brand_name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

              </div>
            </div>
          </div>
          <div class="col-md-12" style="text-align:right;">
            <div class="btn-group">
              <a href="{{url('backend/discount')}}" class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" onclick="return validate()" data-original-title="Back"><i class="fa fa-reply"></i> Back</a>
              <button class="btn btn-sm btn-success" type="submit" data-original-title="Submit"><i class="fa fa-share"></i> Submit</button>
            </div>
          </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
    function checkreward(){
      $('#discvalue').val('');
    }

</script>
<script>

    function validate() {

        var type = document.forms["disc-form"]["type"].value;
        var reward = document.forms["disc-form"]["reward"].value;
        if(type == "Cart") {
            var req = document.forms["disc-form"]["requirement"].value;
            if(req == 0) {
                alert("pilih requirement");
                return false;
            }
            else {
                var rfValue = document.forms["disc-form"]["rfValue"].value;
                var ruValue = document.forms["disc-form"]["ruValue"].value;
                if(ruValue < rfValue) {
                    alert("until lebih kecil dari from");
                    return false;
                }
            }

        }

        if(reward == 0) {
            alert("pilih reward");
            return false;
        }
        if(reward == "Percentage") {
            var rValue = document.forms["disc-form"]["rValue"].value;
            if(rValue < 1 || rValue > 100) {
                alert("wrong percentage");
                return false;
            }

        }
        var fromDate = document.forms["disc-form"]["fromDate"].value;
        var untilDate = document.forms["disc-form"]["untilDate"].value;
        var date = fromDate.substr(3, 2);
        var month = fromDate.substr(0, 2);
        var year = fromDate.substr(6, 4);
        var date2 = untilDate.substr(3, 2);
        var month2 = untilDate.substr(0, 2);
        var year2 = untilDate.substr(6, 4);
        if(year > year2) {
            alert("wrong year");
            return false;
        }
        else {
            if(month > month2 && year==year2) {
                alert("wrong month");
                return false;
            }
            else {
                if(date > date2 && year==year2 && month==month2) {
                    alert("wrong date");
                    return false;
                }
            }
        }


        var bra = document.forms["disc-form"]["bra[]"].value;
        var cat = document.forms["disc-form"]["cat[]"].value;
        var pro = document.forms["disc-form"]["pro[]"].value;
        if(bra == "" && cat == "" && pro == "") {
            alert("insert atleast 1 product, brand, or category");
            return false;
        }
    }
</script>

@endsection
