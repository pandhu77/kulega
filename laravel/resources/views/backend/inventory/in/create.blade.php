@extends('backend/app')
@section('content')
<style media="screen">
.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
  width: 220px;
  position: absolute;
}
</style>
  <title>System | Product Inventory In </title>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Form Inventory In</h3>
      </div>

      <div class="title_right">

      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Create Inventory In</h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              @if(Session::has('success-create'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
                    {{ Session::get('success-create') }}
                </div>
               @endif

                @if(Session::has('success-delete'))
                  <div class="alert alert-info alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                      {{ Session::get('success-delete') }}
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
            <br />
            <form action="{{action('Backend\InventoryinController@store')}}" method="post" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
              <div class="row" style="padding-bottom:50px;">
                    <div class="col-md-6 col-backend" style="padding: 0px;">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" style="padding" for="first-name">Code In
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="code" id="inputCode" required readonly autocomplete="off" class="form-control" value="INV-<?php
                          if(strlen($getinv) == 1){
                              echo "00".$getinv;
                          }elseif (strlen($getinv) == 2) {
                              echo "0".$getinv;
                          }else{
                              echo $getinv;
                          }
                          ?>/{{ $full }}" placeholder="Code" data-validation="required" data-validation-error-msg="Harap Isi!" data-validation-allowing="float">
                        </div>
                      </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" style="padding" for="first-name">Date In
                          </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="datepicker" class="date-picker form-control" value="" data-validation-format="yyyy-mm-dd" name="date" required="required" type="text">
                            <input type="hidden" name="" value="" id="triggerdate"></strong>
                          </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-backend" style="padding: 0px;">
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Notes
                          </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea type="text" rows="5" name="notes" required="required" class="form-control"></textarea>

                          </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-backend">

                      <div class="table table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                  <th style="width:20%">Product Code  <a href="#" class="btn btn-default" title="Create New Product"  style="margin-bottom:0px;float:right;"data-toggle="modal" data-target="#quickModalcreate"><i class="fa fa-plus"></i></a></th>
                                  <th>Product Name</th>
                                  <th>Brand</th>
                                  <th>Varian Size</th>
                                  <th>Varian Color</th>
                                  <th>Qty</th>
                                  <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                  <td >
                                    <select class="js-example-basic-single" data-live-search="true" name="prodid" id="prodid" onchange="getprod();" style="position:absolute;" required>
                                          <option value="" selected disabled>Choose</option>
                                       @foreach($prod as $product)
                                          <option value="{{$product->prod_id}}" data-tokens="">{{$product->prod_code}} / {{$product->prod_name}}</option>
                                        @endforeach
                                    </select>

                                  </td>
                                  <td>
                                      <input name="prodname" type="text" id="valprodname" readonly="readonly" class="form-control">
                                  </td>
                                  <td>
                                      <input name="prodbrand" type="text" id="valprodbrand" readonly="readonly" class="form-control">
                                  </td>
                                  <td>
                                    <div id="loadsize"  style="display:none;text-align: -webkit-center; width:100%;">
                                      <img src="{{asset('assets/icon/load2.gif')}}" style="">
                                    </div>

                                    <div id="tampilsize" style="">
                                        <input name="prodsize" type="text" id="prodsize" value="" class="form-control" readonly>
                                   </div>

                                  </td>
                                  <td>
                                    <div id="loadcolor"  style="display:none;text-align: -webkit-center; width:100%;">
                                      <img src="{{asset('assets/icon/load2.gif')}}" style="">
                                    </div>

                                    <div id="tampilcolor" style="">
                                        <input name="prodcolor" type="text" id="prodcolor" value="" class="form-control" readonly>
                                   </div>
                                  </td>

                                  <td>
                                      <input name="qty" type="number" id="productqty" min="0"  style="text-align: right;" value="" class="form-control">
                                  </td>


                                  <td><button type="button" class="btn btn-primary" onclick="addtocart();" id="addprodbtn">Add</button></td>
                                <tr>

                            </body>
                        </table>
                     </div>

                     <div class="table table-responsive" id="prdlist">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th style="">ID</th>
                                        <th style="">Product Code</th>
                                        <th>Product Name</th>
                                        <th>Brand</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Qty</th>
                                        <th>Public Stock</th>
                                        <th style="text-align: center;" width="50px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                   </div>
                </div>
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;">
                <a href="{{url('backend/inventory/in')}}" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    </div>

    <div class="modal fade" id="quickModalcreate" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="border: none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create New Product</h4>
        </div>
        <div class="modal-body" style="border: none;height: 100%;">
          <form action="{{action('Backend\InventoryinController@NewProductstore')}}" method="post" enctype="multipart/form-data" id="eventForm" data-parsley-validate class="form-horizontal form-label-left">
            <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
            <div class="row" style="padding-bottom:50px;">
              <div class="col-md-12 col-left" >

                <div class="form-group">
                  <label class="col-sm-3 control-label" style="">Product Code</label>
                  <div class="col-sm-5" style="">

                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="CODE" id="intcode" onchange="getAutoCode()" name="first_code" required value="{{ old('first_code') }}">
                      <span class="input-group-addon" style="background:#fff;border-left: 0px;">
                        -
                      </span>
                      <span class="input-group-addon" style="padding:0px 6px;">
                        <input type="text"  name="codeotm" id="intcodeotm" style="height:32px;border: #fff;background:#eee;" value="{{ old('codeotm') }}" required readonly>
                      </span>


                    </div>
                    <input type="hidden" class="form-control"   name="prod_code" id="fullcode" value="{{ old('prod_code') }}" required>

                    @if ($errors->has('prod_code'))
                    <div style="color:red;">
                      {{ $errors->first('prod_code') }}
                    </div>
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" style="">Product Name</label>
                  <div class="col-sm-9" style="">
                    <input type="text" class="form-control" placeholder="Product Name" name="prod_name" value="{{ old('prod_name') }}">
                    @if ($errors->has('prod_name'))
                    <div style="color:red;">
                      {{ $errors->first('prod_name') }}
                    </div>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label" style="">Product Title</label>
                  <div class="col-sm-9" style="">
                    <input type="text" class="form-control" placeholder="Product Title" id="title" name="prod_title" value="{{ old('prod_title') }}" required>
                    @if ($errors->has('prod_title'))
                    <div style="color:red;">
                      {{ $errors->first('prod_title') }}
                    </div>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label" style="">Product Url</label>
                  <div class="col-sm-9" style="">
                    <input type="text" class="form-control" placeholder="Product Url" id="url" name="prod_url" value="{{ old('prod_url') }}" request readonly >
                    @if ($errors->has('prod_url'))
                    <div style="color:red;">
                      {{ $errors->first('prod_url') }}
                    </div>
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label" style="">Brand</label>
                  <div class="col-sm-9" style="">
                    <select class="selectpicker input-flat" data-live-search="true" name="prod_brand_id" required>
                      <option value="" selected disabled>Select One</option>
                      @foreach($brand as $brands)
                      <option value="{{$brands->brand_id}}" data-tokens="">{{$brands->brand_id}} - {{$brands->brand_name}}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('prod_brand_id'))
                    <div style="color:red;">
                      {{ $errors->first('prod_brand_id') }}
                    </div>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"style="" >Product Category</label>
                  <div class="col-sm-9">
                    <div class="col-sm-12 col-kateg" style="max-height:300px;overflow:auto;border:1px solid #D2D6DE;">
                      @foreach($categparent as $parent)
                      <div class="col-sm-12" style="padding-left:0%;">
                        <input type="checkbox" class="" name="prod_category[]" id="{{$parent->kateg_id}}" value="{{$parent->kateg_id}}">
                        <label class="control-label">{{$parent->kateg_name}} </label>
                      </div>
                      @foreach($categparent1 as $parent1)
                      @if($parent->kateg_id == $parent1->kateg_parent)
                      <div class="col-sm-12" style="padding-left:5%;">
                        <input type="checkbox" class="" name="prod_category[]" id="{{$parent1->kateg_id}}" value="{{$parent1->kateg_id}}">
                        <label class="control-label">{{$parent1->kateg_name}} </label>
                      </div>
                      @foreach($categparent2 as $parent2)
                      @if($parent1->kateg_id == $parent2->kateg_parent)
                      <div class="col-sm-12" style="padding-left:10%;">
                        <input type="checkbox" class="" name="prod_category[]"="{{$parent1->kateg_id}}" value="{{$parent2->kateg_id}}">
                        <label class="control-label">{{$parent2->kateg_name}} </label>
                      </div>
                      @endif
                      @endforeach
                      @endif
                      @endforeach
                      @endforeach
                    </div>
                  </div>
                </div>
              <div class="form-group">
                <label class="col-sm-3 text-left">Price</label>
                <div class="col-sm-6" id="price" style="">
                  <input type="number" class="form-control" name="prod_price" placeholder="Price" value="{{ old('prod_price') }}">
                  @if ($errors->has('prod_price'))
                  <div style="color:red;">
                    {{ $errors->first('prod_price') }}
                  </div>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 text-left">Variation</label>
                <div class="col-sm-9" id="price" style="">
                  <input type="radio" onclick="aFunction()"   name="prod_var_status" id="varyes" value="1" required /> Yes
                  <input type="radio" onclick="bFunction()"  name="prod_var_status" id="varno" value="0" required /> No
                </div>
              </div>

              <div class="form-group" id="groupvarian" style="display:none">
                <label class="col-sm-12 control-label" style="margin-top:20px;">Manage Variation</label>
                <div class="col-sm-12">
                  <div class="table-responsive">
                    <table class="table table-bordered" >
                      <tbody>
                        <tr>
                          <th>Size</th>
                          <th>Color</th>
                          <th>Color (Hex)</th>
                          <th>Action</th>
                        </tr>
                      </tbody>
                      <tbody id="dynamic_field_varian">
                        <tr>
                          <tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <button type="button" name="add" id="addvarian" class="btn btn-success">
                        <i class="fa fa-plus"></i> Variation
                      </button>
                   </div>
                 </div>
              </div>
        </div>
        <div class="modal-footer" style="border: none;">
          <div class="col-md-12">
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Add</button>
              </div>
            </div>
          </div>
         </form>
        </div>
      </div>
      </div>
    </div>
  </div>

    <script>
         $(document).ready(function(){
             var intcode = $('#intcode').val();
             if (intcode == '' )
               {
               }else{
                     getAutoCode();
               }
        });
    </script>
    <script>
        function getAutoCode(){
        var intcode =$('#intcode').val();
        var token ="{{csrf_token()}}";
        var dataString='_token='+token+ '&intcode='+intcode;

        $.ajax({
            type:"GET",
            url:"{{url('backend/ajax/generatecode')}}",
            data:dataString,
            success: function(data){
                $('#intcodeotm').val(data);
                $('#fullcode').val(intcode +'-'+ data);
            }
        });
        }
    </script>

    <script type="text/javascript">

    function aFunction() {

        var x = document.getElementById('groupvarian');

            x.style.display = 'block';
        var y = document.getElementById('groupstock');
            y.style.display='none';

    }
    function bFunction() {

        var x = document.getElementById('groupvarian');

            x.style.display = 'none';
        var y = document.getElementById('groupstock');
            y.style.display='block';

    }
    </script>
    <script>
        function getcolor(){
          var prodid= document.getElementById("prodid").value;
          var prodsize=document.getElementById("prodsize").value;
          var token ="{{csrf_token()}}";
          var dataString= '_token='+token+'&prodid='+prodid +'&prodsize='+prodsize;
          $.ajax({
            type:"GET",
            url:"{{url('backend/ajax/getvariancolor')}}",
            data:dataString,

            beforeSend: function(){
          // Handle the beforeSend event
              $('#loadcolor').css('display','block');
              $('#tampilcolor').css('display','none');


            },
            success:function(data){
                setTimeout(function () {
                  $('#loadcolor').css('display','none');
                  $('#tampilcolor').css('display','block');
                  $("#tampilcolor").html(data);
                  $(".js-example-basic-single").select2();
               },500);
            }
          });
          $('#productqty').val('');
        }
    </script>
    <script>
    function getprod(){

      document.getElementById("valprodname").value="loading....";
      document.getElementById("valprodbrand").value="loading....";
      ctr =1;

      var prodid= document.getElementById("prodid").value;
      var productqty = document.getElementById("productqty").value;
      var token ="{{csrf_token()}}";


      var http = new XMLHttpRequest();
      var url="{{url('backend/inventory/in/product')}}";
      var params = "_token={{ csrf_token() }}&prodid=" + prodid + "&productqty=" + productqty;


      http.open("POST", url, true);

      http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      // http.setRequestHeader("Content-length", params.length);
      // http.setRequestHeader("Connection", "close");
            http.onreadystatechange = function () {
                if (http.readyState == 4 && http.status == 200) {
                    var array = JSON.parse(http.responseText);

                    document.getElementById("valprodname").value = array['prod_name'];
                    document.getElementById("valprodbrand").value=array['brand_name'];
                }
            }
            http.send(params);


        var dataString= '_token='+token+'&prodid='+prodid;
        $.ajax({
          type:"GET",
          url:"{{url('backend/ajax/getvariansize')}}",
          data:dataString,

          beforeSend: function(){
        // Handle the beforeSend event
            $('#loadsize').css('display','block');
            $('#tampilsize').css('display','none');


          },
          success:function(data){
              setTimeout(function () {
                $('#loadsize').css('display','none');
                $('#tampilsize').css('display','block');
                $("#tampilsize").html(data);
                $(".js-example-basic-single").select2();
             },500);
          }
        });
      $('#prodcolor').val( $('#prodcolor').find("option[selected]").val() );
      $('#prodcolor').val( $('#prodcolor').find("option[selected]").val() );
      $('#prodcolor')
        .find('option')
        .remove()
        .end()
        .append('<option value="" selected disabled> Choose</option>')
        .val('');
      $('#productqty').val('');
    }
    </script>
    <script>

    function addtocart(){
      $('#prdlist tbody').html('loading...');

      var prodid=document.getElementById("prodid").value;
      var qty = document.getElementById("productqty").value;
      var prodsize = document.getElementById("prodsize").value;
      var prodcolor = document.getElementById("prodcolor").value;
      var http=new XMLHttpRequest();
      var url="{{url('backend/inventory/in/addtocart')}}";
      var params ="_token={{ csrf_token() }}&prodid="+ prodid + "&qty=" + qty + "&prodsize=" + prodsize + "&prodcolor="+ prodcolor;

      http.open("POST", url , true);
      //Send the proper header information along with the request
      http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      http.setRequestHeader("Content-length",params.length);
      http.setRequestHeader("Connection","close");

      if(productqty ==0){
        deletecart(prodid);
        return false;
      }

      http.onreadystatechange = function () {

          if (http.readyState == 4 && http.status == 200) {
              var alldata = JSON.parse(http.responseText);
              var htmldata = '';
             //  var totQty = 0;
             //  var totPv = 0;
             //  var totPrice = 0;
              $.each(alldata, function () {
                if(this.prodpublic ==1){
                    htmldata += '<tr><td>' + this.prodid + '</td><td>' + this.prodcode + '</td><td>' + this.prodname + '</td><td>' + this.prodbrand + '</td><td>' + this.prodsize + '</td><td>' + this.prodcolor + '</td><td style="text-align: right;">' + this.qty + '</td><td><input type="checkbox" checked name="statusname" id="statusid'+this.id+'" onClick="getpublic('+this.id+')"> Yes/No</td><td style="text-align: center;"><button type="button" class="btn btn-danger" style="padding: 1px 10px;" onClick="deletecart(\''+this.id+'\');">Delete</button></td></tr>';
                }else{
                     htmldata += '<tr><td>' + this.prodid + '</td><td>' + this.prodcode + '</td><td>' + this.prodname + '</td><td>' + this.prodbrand + '</td><td>' + this.prodsize + '</td><td>' + this.prodcolor + '</td><td style="text-align: right;">' + this.qty + '</td><td><input type="checkbox" name="statusname" id="statusid'+this.id+'" onClick="getpublic('+this.id+')"> Yes/No</td><td style="text-align: center;"><button type="button" class="btn btn-danger" style="padding: 1px 10px;" onClick="deletecart(\''+this.id+'\');">Delete</button></td></tr>';
                }
              });

              $("#prdlist tbody").html(htmldata);
          }
      }
      http.send(params);
    }
    </script>

    <script>
    function deletecart(prodid) {
           var http= new XMLHttpRequest();
           var url="{{url('backend/inventory/in/deletecart')}}";
           var params="_token={{csrf_token()}}&prodid="+ prodid;

           http.open("POST", url, true);
           http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
           http.setRequestHeader("Content-length", params.length);
           http.setRequestHeader("Connection", "close");

           http.onreadystatechange = function () {
               if (http.readyState == 4 && http.status == 200) {

                   var alldata = JSON.parse(http.responseText);
                   var htmldata = '';
                   // var totQty = 0;
                   // var totPv = 0;
                   // var totPrice = 0;
                   $.each(alldata, function () {
                     if(this.prodpublic ==1){
                         htmldata += '<tr><td>' + this.prodid + '</td><td>' + this.prodcode + '</td><td>' + this.prodname + '</td><td>' + this.prodbrand + '</td><td>' + this.prodsize + '</td><td>' + this.prodcolor + '</td><td style="text-align: right;">' + this.qty + '</td><td><input type="checkbox" checked name="statusname" id="statusid'+this.id+'" onClick="getpublic('+this.id+')"> Yes/No</td><td style="text-align: center;"><button type="button" class="btn btn-danger" style="padding: 1px 10px;" onClick="deletecart(\''+this.id+'\');">Delete</button></td></tr>';
                     }else{
                          htmldata += '<tr><td>' + this.prodid + '</td><td>' + this.prodcode + '</td><td>' + this.prodname + '</td><td>' + this.prodbrand + '</td><td>' + this.prodsize + '</td><td>' + this.prodcolor + '</td><td style="text-align: right;">' + this.qty + '</td><td><input type="checkbox" name="statusname" id="statusid'+this.id+'" onClick="getpublic('+this.id+')"> Yes/No</td><td style="text-align: center;"><button type="button" class="btn btn-danger" style="padding: 1px 10px;" onClick="deletecart(\''+this.id+'\');">Delete</button></td></tr>';
                     }

                     });

                   $("#prdlist tbody").html(htmldata);
               }
           }
           http.send(params);
       }
    </script>

    <script>
      function getpublic(idpub){
        var token = "{{ csrf_token() }}";
        var id = idpub;
        var status = $('#statusid'+idpub).val();
        var dataString = '_token=' + token + '&id=' + id + '&status=' + status;

        $.ajax({
          type: "POST",
          url: "{{url('backend/ajax/publicstock')}}",
          data: dataString,
          success: function (data) {

          }
        });
      }
    </script>

@endsection
