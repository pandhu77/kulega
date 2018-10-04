@extends('app')
@section('content')
<link rel="stylesheet" href="{{asset('template/frontend/shopping-cart.css')}}" type="text/css" />
<title>{{web_name()}} | Cart</title>
<div class="container">

    <div class="shopping-cart1">
      <table class="table table-striped table tableresponsive" style="border:1px solid #ddd;">
        <thead>
          <tr>
            <th style="text-align:center;" width="10%">Images</th>
            <th style="text-align:center;">Product</th>
            <th width="15%" style="text-align:center;">Qty</th>
            <th style="text-align:center;">Remove</th>
            <th style="text-align:center;">Price</th>
            <th style="text-align:center;">Sub Total Product</th>

          </tr>
        </thead>
        <tbody>
          <?php $i=1;?>
          @foreach($content as $cart)
          <tr>
            <td width="" data-label="Images"><img class="img-product" src="{{asset($cart->options['image_small'])}}" width="100%"></td>

            <td class="td-product" data-label="Product" style=""><p>{{$cart->name}}</p><p> <span>@if($cart->options['color']==!null)Color:  {{$cart->options['color']}} @endif</span></p><p><span>@if($cart->options['size']==!null)Size:  {{$cart->options['size']}} @endif</span></p></td>
            <td data-label="Qty"  style="text-align:left;">
                <div class="input-group input-group-sm"style="margin-bottom:10px;">
                    <span class="input-group-btn">
                        <a class="btn btn-default buttl flat" onclick="change_item_qty('item_qty{{ $i }}', 'minus');"style="border-color:#c66;background-color:#d9534f;color:#fff;"><i class="fa fa-minus"></i></a>
                    </span>
                    <input type="number"class="form-control text-center select-input number" name="qty" id="item_qty{{ $i }}" value="{{ $cart->qty }}" onchange="check_qty('item_qty{{ $i }}');" data-id="id product">
                    <span class="input-group-btn">
                        <a class="btn btn-default buttl flat" onclick="change_item_qty('item_qty{{ $i }}', 'plus');"style="border-color:#c66;background-color:#d9534f;color:#fff;"><i class="fa fa-plus"></i></a>
                    </span>
                </div>
              <input type="hidden" name="cartid" id="cartitem_qty{{ $i }}" value="{{ $cart->rowId }}">

              @if(count($resultstock)>0)
                 @foreach ($resultstock as $key => $stock)
                    @if($cart->id ==$stock['stock_prodid'] and  $cart->options['color'] == $stock['stock_color'] and  $cart->options['size'] == $stock['stock_size'])

                        <div class="alert alert-danger" style="margin-bottom:0px;position:absolute;padding:5px">
                          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                          Sorry, stock products are not sufficient(max :{{$stock['stock_max']}})
                        </div>

                    @endif
                 @endforeach
              @endif
            </td>
            <td  data-label="Remove" class="td-remove hidden-xs"style="">  <a style="color:#000;" href="#" class="remove-product btn-sm" onclick="if(confirm('Are you sure?')) location.href='delete-cart/<?php echo $cart->rowId;?>'"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i></a></td>
            <td  data-label="Price"style="text-align:right;">
              @if($cart->options['proddisc'] == 0 || $cart->options['proddisc']==null )
                <span class="price_format">{{$cart->price}}</span>
              @else
                 <del><span class="price_format">{{$cart->options['prodprice']}}</span> </del>
                 <br> @IF($cart->options['proddisc'] <= 100) {{$cart->options['proddisc']}}%  @else <span class="price_format">{{$cart->options['proddisc']}}</span> @endif OFF
                  <br>  <span class="price_format" style="font-weight: bold; color: #B2203D;">{{$cart->price}}</span>
                  <span style="font-weight: bold; color: #B2203D;"></span>
              @endif

            </td>
            <td data-label="Sub Total" style="text-align:right;">
                <div id="loaditem_qty{{ $i }}"  style="display:none;text-align:right;">
                    <img src="{{asset('assets/icon/load2.gif')}}" style="">
                </div>
                <div id="subitem_qty{{ $i }}" >
                  <span class="price_format">{{$cart->subtotal}}</span>
                </div>
             </td>
            <td  data-label="Remove" class="td-remove hidden-md hidden-sm hidden-lg"style="">  <a style="color:#000;" href="#" class="remove-product btn-sm" onclick="if(confirm('Are you sure?')) location.href='delete-cart/<?php echo $cart->rowId;?>'"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i></a></td>
          </tr>

         <?php $i++; ?>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="shopping-cart1">
        <div class="totals">
            <div class="totals-item totals-item-total" >
              <div class="col-md-7" style="padding-left:0px; padding-right:0px;">
                <br>
              <span style="font-weight:bold">Voucher Code</span>
              <div class="input-group group-voucher" style="margin-bottom:20px;">
                  <input type="text" id="vouchercode" class="form-control" placeholder="Voucher Code">
                  <span class="input-group-btn">
                  <button class="btn btn-danger" type="button" onclick="usevoucher()">Use</button>
                  </span>

              </div>
              <!-- /input-group -->
              <div id="error-coupon"></div>
              <div id="error-use"></div>
              <div id="error-limit"></div>
              <div id="error-date"></div>
              <div id="error-total"></div>
              <div id="success-coupon"></div>

                <br>
              @if(count($bonus)>0)
              <span style="font-weight:bold">Have E-Commerce Djaring.id points (<span id="memberPoint">{{$tmppoint->point}} </span> points) <a href="#" style="color:#B2203D"> Exchange your points ?</a></span>
              <br>
              @endif
              <div class="input-group" style="margin-top:15px;">

                @foreach($bonus as $point)
                    <input type="checkbox" class="flat" name="point" id="{{$point->bonus_id}}" onclick="getbonus({{$point->bonus_id}})" value="{{$point->bonus_id}}"> {{$point->bonus_poin}} Point =  @if($point->bonus_reward =='nominal') <span class="price_format">{{$point->bonus_value}}</span> @else {{$point->bonus_value}} % @endif <br>
                @endforeach
                <div id="rewardfailed"></div>
              </div>
              </div>
              <table class="table table-total col-md-5"style="" >
                <tbody>
                  <?php $valuesub= substr( Cart::subtotal(),0,-3);?>
                  <?php $subtotal= str_replace(",", "", $valuesub);?>
                  <?php $resultcart=Helper::check_dicount_total_cart($subtotal);?>
                  <?php
                    $total_cart= $resultcart['total_cart'];
                    $disc_cart= $resultcart['disc_cart'];
                    $disc_reward= $resultcart['disc_reward'];
                    $disc_percent= $resultcart['disc_percent'];
                  ?>
                  <tr>
                    <th  style="border-top: 1px solid #fff;padding-right:0px;padding-left:0px;">Sub Total:</th>
                    <th style="text-align:right;border-top: 1px solid #fff;padding-right:0px;padding-left:0px;">
                      <div id="loadsubtotal"  style="display:none;text-align:right;">
                          <img src="{{asset('assets/icon/load2.gif')}}" style="">
                      </div>
                      <div id="viewtotal" >
                        <span class="price_format" style="color:#333"><?php echo substr( Cart::subtotal(),0,-3);?></span>
                      </div>
                    </th>
                  </tr>
                  <tr style="border-bottom: 1px solid #333; ">
                    <th  style="border-top: 1px solid #fff;padding-right:0px;padding-left:0px;">Discount Cart @if($disc_reward=='percent')({{$disc_percent}}%) @endif:</th>
                    <th style="text-align:right;border-top: 1px solid #fff;padding-right:0px;padding-left:0px;">
                      <div id="loaddisc"  style="display:none;text-align:right;">
                          <img src="{{asset('assets/icon/load2.gif')}}" style="">
                      </div>
                      <div id="viewdisc_cart" >
                         <span class="price_format" style="color:#333">{{$disc_cart}}</span>
                      </div>
                    </th>
                  </tr>
                  <?php $memberid=Session::get('memberid');?>
                  <?php $resultlevel=Helper::check_dicount_member_level($total_cart,$memberid,$subtotal, $disc_cart);?>
                  <?php


                    $level=  $resultlevel['levelname'] ;
                    $disclevel=  $resultlevel['disc_level'];
                    $discvalue=  $resultlevel['disc_value'] ;
                    $valuesub= substr( Cart::subtotal(),0,-3);
                    $subtotal= str_replace(",", "", $valuesub);

                    Session::set('subtotal1',$subtotal);
                    Session::set('disccart1',$disc_cart);
                    Session::set('disclevel1',$disclevel);
                    Session::set('grandtotal1',$resultlevel['total_level']);
                    Session::set('levelname1',$level);
                    $grandtotal=Session::get('grandtotal1');
                  ?>

                  <tr style="border-bottom: 1px solid #333; ">
                    <th  style="border-top: 1px solid #fff;padding-right:0px;padding-left:0px;">Discount Members ({{$level}}:{{$discvalue}}%):</th>
                    <th style="text-align:right;border-top: 1px solid #fff;padding-right:0px;padding-left:0px;">
                      <div id="loadlevel"  style="display:none;text-align:right;">
                          <img src="{{asset('assets/icon/load2.gif')}}" style="">
                      </div>
                      <div id="viewdisclevel" >
                         <span class="price_format" style="color:#333">{{$disclevel}}</span>

                      </div>
                    </th>
                  </tr>
                    <tr style="border-bottom: 1px solid #333; ">
                      <th  style="border-top: 1px solid #fff;padding-right:0px;padding-left:0px;">Voucher:</th>
                      <th style="text-align:right;border-top: 1px solid #fff;padding-right:0px;padding-left:0px;">
                        <div id="loadcartvoucher"  style="display:none;text-align:right;">
                            <img src="{{asset('assets/icon/load2.gif')}}" style="">
                        </div>
                        <div id="cartvoucher">
                             <span class="price_format" style="color:#333">0</span>
                        </div>

                      </th>
                    </tr>
                @if(count($bonus)>0)
                      <tr style="border-bottom: 1px solid #333; ">
                        <th  style="border-top: 1px solid #fff;padding-right:0px;padding-left:0px;">Rewards:</th>
                        <th style="text-align:right;border-top: 1px solid #fff;padding-right:0px;padding-left:0px;">
                          <div id="loadreward"  style="display:none;text-align:right;">
                              <img src="{{asset('assets/icon/load2.gif')}}" style="">
                          </div>
                          <div id="viewreward" >
                             <span class="price_format" style="color:#333">0</span>
                          </div>
                        </th>
                      </tr>
                @endif
                  <tr style="border-bottom: 1px solid #333; ">
                    <th  style="border-top: 1px solid #fff;padding-right:0px;padding-left:0px;">Grand Total:</th>
                    <th style="text-align:right;border-top: 1px solid #fff;padding-right:0px;padding-left:0px;">
                      <div id="loadtotal"  style="display:none;text-align:right;">
                          <img src="{{asset('assets/icon/load2.gif')}}" style="">
                      </div>
                      <div id="viewtotalcart" >
                         <span class="price_format" style="color:#333">{{$grandtotal}}</span>
                      </div>
                    </th>
                  </tr>
                </tbody>
              </table>
        </div>
        <form action="{{ url('/updtqty') }}" method="post" id="submitqty">
            <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="idcart" id="idrow">
            <input type="hidden" name="qtycart" id="qtyrow">
        </form>
        <a href="{{url('/')}}"><button class="back">Back To Shopping</button></a>
        <?php $check=Cart::count(); ?>
        @if($check > 0)
        <a href="{{url('checkout')}}" class="checkout">Checkout</a>
        @endif
    </div>
   </div>
  </div>
    <script src="{{asset('assets/js/bootstrap-number-input.js') }}" ></script>

    <script>
      function getbonus(id){
        var token = "{{csrf_token()}}";

        if($('#'+id).is(":checked")) {
              var status=1;
         } else {
              var status=0;
         }
         var dataString= '_token='+ token + '&id=' + id +'&status='+ status ;
        $.ajax({
          type:"GET",
          //JSON UNTUK MEMECAH DATA
          dataType:'json',
          url:"{{url('ajax/cart/getBonus')}}",
          data:dataString,
          success: function(data){
          if(data.status == 1){
            $("#viewreward").html(data.htmlreward);
            $("#viewtotalcart").html(data.htmltotal);
            $("#memberPoint").html(data.htmlpoint);
          }else{
            $("#rewardfailed").html(data.html);
          }

          }

        });
        }

    </script>
    <script>
      function usevoucher(){

      var token   = "{{csrf_token()}}";
      var kode    =$("#vouchercode").val();
      // var tripid  =$("#tripid").val();
      // var datein  =$("#datein").val();
      // var qty    = $("#qty").val();

      var dataString= '_token='+ token + '&kode=' + kode ;
      $.ajax({
        type:"GET",

        //JSON UNTUK MEMECAH DATA
        dataType:'json',
        url:"{{url('ajax/checkout/getVoucher')}}",
        data:dataString,

        beforeSend: function(){

       },

        success: function(data){
          if(data.status == 0){
              $('#loadcartvoucher').css('display','block');
              $('#cartvoucher').css('display','none');
              //total cart
              $('#loadtotal').css('display','block');
              $('#viewtotalcart').css('display','none');
          }

            setTimeout(function(){
              if(data.status == 0){
                $('#loadcartvoucher').css('display','none');
                $('#cartvoucher').css('display','block');

                $('#loadtotal').css('display','none');
                $('#viewtotalcart').css('display','block');

                $("#success-coupon").html(data.alert);
                $("#cartvoucher").html(data.htmlvoucher);
                $("#viewtotalcart").html(data.htmltotal);

                $('.price_format').priceFormat();


              }else if(data.status == 2){
                $("#error-date").html(data.html);


              }else if(data.status == 3){
                $("#error-limit").html(data.html);


              }else if(data.status == 4){
                $("#error-coupon").html(data.html);

              }else if(data.status == 5){
                $("#error-total").html(data.html);
             }else if(data.status == 6){
              $("#error-use").html(data.html);
            }
         },1000);
        }

      });
      }
    </script>
    <script>
    // Remember set you events before call bootstrapSwitch or they will fire after bootstrapSwitch's events
    $("[name='checkbox2']").change(function() {
      if(!confirm('Do you wanna cancel me!')) {
          this.checked = true;
      }
    });

    $('#after').bootstrapNumber();
    $('#prodqty').bootstrapNumber({
      upClass: 'danger',
      downClass: 'danger'

    });
    </script>

    <script>

    function gettotal(id){
        var getid= id;
        var qty = $('#'+id).val();
        var id = $('#cart'+id).val();
        $('#idrow').val(id);
        $('#qtyrow').val(qty);

        // cari tau dulu id nya, qty
        // ajax ke controller kirim id dan qty

        // $('#cart-detail').load({{ url('cart-detail/') }});

        var token = $('#token').val();
        var dataString = '_token=' + token+ '&qty=' + qty + '&id=' + id;

        $.ajax({
            type: "POST",
            url: "{{ url('ajax/getqty') }}",
            data: dataString,
            beforeSend: function(){
            // Handle the beforeSend event
                $('#load'+getid).css('display','block');
                $('#sub'+getid).css('display','none');

                $('#loadsubtotal').css('display','block');
                $('#viewtotal').css('display','none');
            },
            success:function(data){
                setTimeout(function () {

                  $('#load'+getid).css('display','none');
                  $('#sub'+getid).css('display','none');
                  $('#loadsubtotal').css('display','block');
                  $('#viewtotal').css('display','none');
                  if (data == '1') {
                      $('#submitqty').submit();
                  }
               },600);
            }

        });
    }
    </script>
    <script>
        function change_item_qty(id,type){

            var qty = $('#' + id).val();
            if(type == "plus"){
                qty = parseInt(qty) + 1;
                $('#' + id).val(qty);
            }
            else{
                if(qty <= 1){
                    $('#' + id).val(1);
                }
                else{
                    qty = parseInt(qty) - 1;
                    $('#' + id).val(qty);
                }
            }
            gettotal(id);

        }

        function check_qty(id){
            var qty = $('#' + id).val();
            if(qty <= 1){
                $('#' + id).val(1);
            }
            gettotal(id);
        }

    </script>

@endsection
