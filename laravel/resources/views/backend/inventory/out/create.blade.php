@extends('backend/app')
@section('content')
<style media="screen">
.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
  width: 220px;
  position: absolute;
}
</style>
  <title>System | Product Inventory Out </title>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Form Inventory Out</h3>
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
            <h2>Create Inventory Out</h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form action="{{action('Backend\InventoryoutController@store')}}" method="post" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
              <div class="row" style="padding-bottom:50px;">
                    <div class="col-md-6 col-backend" style="padding: 0px;">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" style="padding" for="first-name">Code Out
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="code" id="inputCode" required readonly autocomplete="off" class="form-control" value="OTV-<?php
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" style="padding" for="first-name">Date Out
                          </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="datepicker" class="date-picker form-control" data-validation-format="yyyy-mm-dd" name="date" required="required" type="text">
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
                                  <th style="width: 250px">Product Code</th>
                                  <th>Product Name</th>
                                  <th>Brand</th>
                                  <th>Varian Size</th>
                                  <th>Varian Color</th>
                                  <th>Stock</th>
                                  <th>Qty</th>
                                  <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                  <td >
                                    <select class="selectpicker input-flat" data-live-search="true" name="prodid" id="prodid" onchange="getprod();" style="position: absolute;" required>
                                          <option value="" selected disabled></option>
                                       @foreach($prod as $product)
                                          <option value="{{$product->prod_id}}" data-tokens="">{{$product->prod_code}} - {{$product->prod_name}}</option>
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
                                    <div id="loadstock"  style="display:none;text-align: -webkit-center; width:100%;">
                                      <img src="{{asset('assets/icon/load2.gif')}}" style="">
                                    </div>
                                      <div id="tampilstock" style="">
                                        <input name="prodstock" type="text" id="prodstock" readonly="readonly" class="form-control">
                                      </div>
                                  </td>
                                  <td>
                                      <input name="qty" type="number" id="productqty" min="0"style="text-align: right;" value="" class="form-control">
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
                                        <th>ID</th>
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>Brand</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Qty</th>
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
                <a href="{{url('backend/inventory/out')}}" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

    <script>
        function getsisastock(){

          var prodid= document.getElementById("prodid").value;
          var prodsize=document.getElementById("prodsize").value;
          var prodcolor=document.getElementById("prodcolor").value;
          var token ="{{csrf_token()}}";
          var dataString= '_token='+token+'&prodid='+prodid +'&prodsize='+prodsize +'&prodcolor='+prodcolor;
          $.ajax({
            type:"GET",
            url:"{{url('backend/ajax/out/getprodstock')}}",
            data:dataString,

            beforeSend: function(){
          // Handle the beforeSend event
              $('#loadstock').css('display','block');
              $('#tampilstock').css('display','none');

            },
            success:function(data){
                setTimeout(function () {
                  $('#loadstock').css('display','none');
                  $('#tampilstock').css('display','block');
                  $("#tampilstock").html(data);
               },500);
            }
          });
          $('#productqty').val('');
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
            dataType:'json',
            url:"{{url('backend/ajax/out/getvariancolor')}}",
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
                  $("#tampilcolor").html(data.htmlcolor);
                  $("#tampilstock").html(data.htmlstock);
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
      var url="{{url('backend/inventory/out/product')}}"
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
                    document.getElementById("prodstock").value=array['productstock']
                }
            }
            http.send(params);

            var dataString= '_token='+token+'&prodid='+prodid;
            $.ajax({
              type:"GET",
              url:"{{url('backend/ajax/out/getvariansize')}}",
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


      var prodid=document.getElementById("prodid").value;
      var qty = document.getElementById("productqty").value;
      var prodsize = document.getElementById("prodsize").value;
      var prodcolor = document.getElementById("prodcolor").value;
      var prodstock = document.getElementById("prodstock").value;
      intqty=parseInt(qty) ;
      intstock=parseInt(prodstock) ;
      if(intqty > intstock){
        alert('Sorry, insufficient stock produt');
      }else{
          $('#prdlist tbody').html('loading...');
          var http=new XMLHttpRequest();
          var url="{{url('backend/inventory/out/addtocart')}}";
          var params ="_token={{ csrf_token() }}&prodid="+ prodid + "&qty=" + qty + "&prodsize=" + prodsize +'&prodcolor='+prodcolor;
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
                    htmldata += '<tr><td>' + this.prodid + '</td><td>' + this.prodcode + '</td><td>' + this.prodname + '</td><td>' + this.prodbrand + '</td><td>' + this.prodsize + '</td><td>' + this.prodcolor + '</td><td style="text-align: right;">' + this.qty + '</td><td style="text-align: center;"><button type="button" class="btn btn-danger" style="padding: 1px 10px;" onClick="deletecart(\''+this.id+'\');">Delete</button></td></tr>';
                  });

                  $("#prdlist tbody").html(htmldata);
              }
          }
          http.send(params);

      }
    }
    </script>
    <!-- <script>
        $(window).bind('keypress', function (e) {
             if (e.keyCode === 13) {
               addtocart();
               return false;
             }
           });
    </script> -->
    <script>
    function deletecart(prodid) {
           var http= new XMLHttpRequest();
           var url="{{url('backend/inventory/out/deletecart')}}";
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
                      htmldata += '<tr><td>' + this.prodid + '</td><td>' + this.prodcode + '</td><td>' + this.prodname + '</td><td>' + this.prodbrand + '</td><td>' + this.prodsize + '</td><td>' + this.prodcolor + '</td><td style="text-align: right;">' + this.qty + '</td><td style="text-align: center;"><button type="button" class="btn btn-danger" style="padding: 1px 10px;" onClick="deletecart(\''+this.id+'\');">Delete</button></td></tr>';
                     });

                   $("#prdlist tbody").html(htmldata);
               }
           }
           http.send(params);
       }
    </script>
@endsection
