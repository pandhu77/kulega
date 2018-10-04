@extends('app')
@section('content')
    <link rel="stylesheet" href="{{asset('template/frontend/checkout2.css')}}" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap-wizard/1.2/jquery.bootstrap.wizard.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>


    <title>{{web_name()}} | Checkout </title>
    <div class="container">
    <form action="{{action('CheckoutController@store')}}" method="post" enctype="multipart/form-data" id="installationForm" class="form-horizontal">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
        <ul class="nav nav-pills" style="text-align: center;">
            <li class="active"><a href="#basic-tab" data-toggle="tab">Checkout Information</a></li>
            <li><a href="#review" data-toggle="tab"  onclick="checkvalidation()">Review & Payment Information</a></li>
        </ul>

        <div class="tab-content">

            <!-- First tab -->
            <div class="tab-pane active" id="basic-tab">
                <div class="col-sm-12">
                  <h3>Delivery Method</h3>


                  <div class="form-group">
                      <div class="col-sm-12" style="">
                        <input type="radio" onclick="newshipping()" checked   name="delivery_method" id="ship" value="ship" required="" /> Shipping Method
                        <input type="radio" onclick="newpickup()"  name="delivery_method" id="pick" value="pick" required="" /> Pickup Method
                        </div>
                  </div>
                </div>
                <div class="col-md-6" id="billing">
                  <div id="methodshipid" >
                    <h3>Shipping Address</h3>

                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-sm-6 col-xs-7 col-new" style="padding-left: 0px;">
                         @if(count($address)>0)
                          <select name="" class="form-control shipaddress" id="soflowsize"  onchange="shipadd()">
                            <option value="" selected="">Choose address</option>
                            @foreach($address as $addr)
                            <option value="{{$addr->adress_id}}">{{$addr->title}}</option>
                            @endforeach
                          </select>
                         @else
                           <a href="{{url('user/my-shipping')}}" class="plus-address">Add Shipping</a>
                         @endif

                        </div>
                          <div class="col-sm-6 col-xs-5 button-new" style="">
                            <a class="btn btn-submit btn-default add-new" onclick="newaddr()">
                              New Address
                            </a>
                          </div>
                        </div>

                        <div id="shipupdate" style="">
                          <input type="hidden" name="idadd" id="" value="">
                          <div class="form-group valid ">
                            <label for="email">Title *</label>

                            <input type="text" class="form-control" id="titlebook" placeholder="Title" name="titlebook" onkeyup="gettitlebook_sm()" required="" value="">
                          </span>
                          </div>
                          <div class="form-group valid">
                            <label for="email">Recipient Name *</label>

                            <input type="text" class="form-control" id="fullnamebook" placeholder="Name" name="reciptnamebook" onkeyup="getnamebook_sm()" required="" value="">
                          </div>
                          <div class="form-group valid">
                            <label for="pwd">Phone Number *</label>
                            <input type="text" class="form-control" id="phonebook"  placeholder="Phone"name="phonebook" onkeyup="getphonebook_sm()"  required="" value="">
                          </div>
                          <div class="form-group valid">
                              <label for="pwd">Email *</label>
                              <input type="email" class="form-control"  id="emailbook" placeholder="Email" name="emailbook"  onkeyup="getemailbook_sm()" required="">
                          </div>
                          <div class="form-group valid">
                            <label for="pwd">Address *</label>
                            <textarea name="addressbook"id="addressbook" class="form-control input-flat" placeholder="Address" onkeyup="getaddressbook_sm()"  style="resize: vertical;" required="" value=""></textarea>
                          </div>
                          <div class="form-group valid">
                            <label for="pwd">Postal Code *</label>
                            <input type="text" class="form-control" id="postcodebook"  placeholder="Postal Code"name="postcodebook" onkeyup="getpostbook_sm()" required="" value="">
                          </div>


                          <div class="form-group valid">
                            <div class="row" id="loadingprovimg" style="display: none;" >
                              <div class="col-md-12 text-center">
                                <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                              </div>
                            </div>
                            <div id="shippingprovince">
                              <div class="row" id="loadingprov" >
                                <div class="col-md-12 text-center">
                                  <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                                    <input type="hidden" class="form-control"  placeholder=""name="province"  required="" value="">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group valid">
                            <div class="row" id="loadingcitimg" style="display: none;">
                              <div class="col-md-12 text-center">
                                <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                              </div>
                            </div>

                            <div id="shippingcity">
                              <div class="row" id="loadingcit" style="display: none;">
                                <div class="col-md-12 text-center">
                                  <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                                  <input type="hidden" class="form-control"  placeholder=""name="city"  required="" value="">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group valid">
                            <div class="row" id="loadingsubimg" style="display: none;">
                              <div class="col-md-12 text-center">
                                <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                              </div>
                            </div>

                            <div id="shippingsubdistrict">
                              <div class="row" id="loadingsub" style="display: none;">
                                <div class="col-md-12 text-center">
                                  <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                                    <input type="hidden" class="form-control"  placeholder=""name="subdistrict"  required="" value="">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group valid" id="valid">
                            <div class="row" id="loadingcostimg" id="valid" style="display: none;">
                              <div class="col-md-12 text-center">
                                <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                              </div>
                            </div>
                            <!-- <input type="hidden" class="form-control"  placeholder=""name="ongkirvalid" id="ongkirvalid" required=""> -->

                            <div id="shippingcost">
                              <div class="row" id="loadingcost" id="valid" style="display: none;">
                                <div class="col-md-12 text-center">
                                  <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                                  <input type="hidden" class="form-control"  placeholder=""name="ongkir"  required="" value="">
                                </div>
                              </div>
                            </div><br>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>Billing Address</h3>

                    <div class="col-md-12">
                        <div class="form-group valid">
                            <label><input type="checkbox"  id="cebox" name="cebox" onclick="checkbiling()"> Same as Shipping Address</label>

                        </div>
                        <div id="biladdress">
                        <div class="form-group checkvalid valid" >
                          <label for="email">Title *</label>
                          <input type="text" class="form-control" id="titlebil" placeholder="Title" name="titlebil" value="">
                        </div>
                        <div class="form-group checkvalid valid">
                            <label for="email">Recipient Name *</label>
                            <input type="text" class="form-control" id="fullnamebil" name="reciptnamebil"  placeholder="Name"required="" >
                        </div>

                        <div class="form-group checkvalid valid">
                            <label for="pwd">Phone Number *</label>
                            <input type="text" class="form-control" id="phonebil" name="phonebil" placeholder="Phone" >
                        </div>
                        <div class="form-group checkvalid valid">
                            <label for="pwd">Email *</label>
                            <input type="email" class="form-control" id="emailbil" name="emailbil" placeholder="Email">
                        </div>
                        <div class="form-group checkvalid valid">
                            <label for="pwd">Address *</label>
                            <textarea name="addressbil" class="form-control input-flat" id="addressbil" placeholder="Address" style="resize: vertical;" required=""></textarea>
                        </div>
                        <div class="form-group checkvalid valid">
                            <label for="pwd">Postal Code *</label>
                            <input type="text" class="form-control" id="postcodebil" name="postcodebil" placeholder="Postal Code" >
                        </div>
                        <div class="form-group checkvalid valid">
                            <div id="bilingprovince">
                                <div class="row" id="loadingprov" >
                                    <div class="col-md-12 text-center">
                                        <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                                        <input type="hidden" class="form-control"  placeholder="Postal Code"name="bilprovince"   value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group checkvalid valid">
                            <div id="bilingcity">
                                <div class="row" id="loadingcit" style="display: none;">
                                    <div class="col-md-12 text-center">
                                        <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                                        <input type="hidden" class="form-control"  placeholder="Postal Code"name="bilcity"  required="" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group checkvalid valid">
                            <div id="bilingsubdistrict">
                                <div class="row" id="loadingsub" style="display: none;">
                                    <div class="col-md-12 text-center">
                                        <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                                        <input type="hidden" class="form-control"  placeholder="Postal Code"name="bildistrict"  required="" value="">
                                    </div>
                                </div>
                            </div>
                       </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-button">
                    <ul class="pager wizard">
                        <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                        <li class="next"><a href="javascript: void(0);" onclick="checkvalidation()">Next</a> </li>
                    </ul>
               </div>
            </div>

            <!-- Second tab -->
            <div class="tab-pane col-sm-12" id="review">
              <div class="row" style="padding-bottom:50px;">
                <div class="col-md-12 ">
                  <div class="col-sm-6" id="viewleft" style="padding-left:0px; padding-right:0px;">

                  </div>
                  <div class="col-sm-6" id="viewright" style="padding-left:0px; padding-right:0px;">

                  </div>

                </div>
              </div>

            <div class="row">
              <div class="col-md-12 shopping-cart1" style="padding-bottom:10px;">
                <table class="table table-striped table tableresponsive" style="border:1px solid #ddd;">
                  <thead>
                    <tr>
                      <th style="text-align:center;" width="10%">Images</th>
                      <th style="text-align:center;">Product</th>
                      <th width="15%" style="text-align:center;">Qty</th>
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
                      <td data-label="Qty"  style="text-align:left;">{{ $cart->qty}}
                      </td>
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
                      <td data-label="Sub Total" style="text-align:right;"><span class="price_format">{{$cart->subtotal}}</span> </td>
                    </tr>
                   <?php $i++;
                      $subtot=$cart->price * $cart->qty ;

                    ?>

                    <?php $total[] = $subtot;?>
                    @endforeach
                  </tbody>
                </table>

                  <div class="col-sm-5" style="padding-left:0px; padding-right:0px; text-align:left;">
                      <!-- <h3>Voucher Code</h3>
                    <div class="input-group" style="margin-bottom: 10px; padding-top:15px;">
                        <input type="text" id="vouchercode" class="form-control" placeholder="Voucher Code">
                        <span class="input-group-btn">
                        <button class="btn btn-danger" type="button" onclick="usevoucher()">Use</button>
                        </span>

                    </div>
                    <div id="error-coupon"></div>
                    <div id="error-use"></div>
                    <div id="error-limit"></div>
                    <div id="error-date"></div>
                    <div id="error-total"></div>
                    <div id="success-coupon"></div>

                      <br> -->
                      <h3>Payment Method</h3>
                    <div class="input-group" style="">
                      <input type="radio"name="payment_method"  onclick="getmethodBank()"  id="payment_method" value="1" required="" /> Bank Transfer
                      <input type="radio"name="payment_method"  onclick="getmethodCart()" id="payment_method" value="2" required="" /> Credit Card
                    </div>

                 </div>

                  <div class="col-sm-7"  style="padding-left:0px; padding-right:0px;">

                    <div class="totals" style="">
                          <h3>Payment Information</h3>
                        <div class="totals-item" style="">
                            <label class="label-payment">Subtotal</label>
                            <div class="totals-value" id="cartsubtotal">IDR <?php echo number_format(Session::get('subtotal1'),0,",",".") ?>
                              <?php $subtotal=Session::get('subtotal1');?>
                            </div>
                        </div>

                        <div class="totals-item totals-item-total">
                           <label class="label-payment">Discount Shopping </label>
                           <div class="totals-value" id="disccart"> IDR <?php echo  number_format( Session::get('disccart1'),0,",",".")?>
                           </div>
                         </div>

                        <div class="totals-item totals-item-total">
                           <label class="label-payment">Members Discount(<span id ="levelname"></span>)</label>
                           <div id="dislevel">
                             <div class="col-md-12 text-center">
                               <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                             </div>
                           </div>
                         </div>
                         <?php if(!empty(Session::get('discvoc'))) {?>
                         <div class="totals-item totals-item-total">
                            <label class="label-payment">Voucher</label>
                            <div class="totals-value" id="voucher"> IDR <?php echo  number_format( Session::get('discvoc'),0,",",".")?>
                            </div>
                          </div>
                          <? } ?>
                          <?php if(!empty(Session::get('bonusreward1'))) {?>
                          <div class="totals-item totals-item-total">
                             <label class="label-payment">Reward</label>
                             <div class="totals-value" id="bonusreward"> IDR <?php echo  number_format( Session::get('bonusreward1'),0,",",".")?>
                             </div>
                           </div>
                          <? } ?>
                        <div class="totals-item totals-item-total">
                           <label class="label-payment">Shipping (+)</label>
                           <div id="getshipping">
                             <div class="col-md-12 text-center">
                               <img src="{{ asset('assets/img/web/small_loading.gif') }}" alt="loading">
                             </div>
                           </div>
                         </div>
                         <!-- <div class="totals-item totals-item-total">
                            <label class="label-payment">Unique Code (+)</label>
                            <div class="totals-value" id="unitcode"> IDR <?php echo  number_format( Session::get('coderandom1'),0,",",".")?>
                            </div>
                          </div> -->

                        <!-- <div class='totals-item totals-item-total'>
                           <label class="label-payment">Service Charge (CC)</label>
                           <div id="loadcartservice"  style="display:none;text-align:right;">
                               <img src="{{asset('assets/icon/load2.gif')}}" style="">
                           </div>
                           <div id="cartservice"><div class="totals-value price_format">0</div></div>

                       </div> -->
                        <div id="loadcartvoucher"  style="display:none;text-align:right;">
                            <img src="{{asset('assets/icon/load2.gif')}}" style="">
                        </div>
                        <div id="cartvoucher">

                        </div>
                         <div class='totals-item totals-item-total'>
                         <label class="label-payment" style="font-weight:bold;">Grand Total</label>
                         <div id="loadcarttotals"  style="display:none;text-align:right;">
                             <img src="{{asset('assets/icon/load2.gif')}}" style="">
                         </div>
                         <div id="carttotals" style="font-weight:bold;"><div class="totals-value price_format">0</div></div>

                        </div>
                        <p style="text-align:right"><span style="color:#B2203D;">Note</span>: 2 Numbers back of grand total is a unique code(<?php echo Session::get('coderandom1');?>) for easy transaction.<p/>
                    </div>
                 </div>
                 <div class="col-sm-12" style="padding-right:0px;padding-left:0px;">
                   <div id="bank-detail" class="" style="display:none;">
                     <h3 style="text-align:left">Bank Transfer Detail</h3><br>
                     @foreach($bank as $banks)

                        <div class="col-sm-6"style="padding-right:5px;padding-left:5px; text-align:left; margin-bottom: 10px;" >
                          <div class="col-md-12" style="border: 1px solid #999; border-radius: 10px; padding-bottom:10px;">
                           <div class="col-sm-12" style="border-radius: 0px; margin-top: 10px;padding-right:0px;padding-left:0px;">
                              <img src="{{asset($banks->bank_image)}}" style="width: 80px;">
                           </div>
                              <b> <span>{{$banks->bank_name}}:</b></span>  &nbsp;
                                  <span>{{$banks->bank_noreg}}</span>  &nbsp;</span><span class="hidden-lg hidden-sm"><br></span>
                              <b> Holder:</b> <span>{{$banks->bank_holder}}</span>&nbsp;
                         </div>
                       </div>
                     @endforeach
                   </div>
                 </div>
              </div>
            </div>
            <div class="clearfix">
            </div>
            <div class="col-sm-12 col-button">
                <ul class="pager wizard">
                    <li class="previous"><a href="javascript: void(0);" style="margin-left: -15px;">Previous</a></li>
                    <li class="next"><button class="add-cart" type="submit">Payment</button></li>
                </ul>
           </div>
            </div>
            <!-- Previous/Next buttons -->
        </div>
    </form>
</div>

<script>
  function getmethodBank(){

   var token ="{{csrf_token()}}";
   var subtotal="{{$subtotal}}";
   var ongkir=$("[name='ongkir']:checked").val();
   var dataString='_token='+ token +'&subtotal='+subtotal+'&ongkir='+ongkir;
   $.ajax({
       type:"GET",
       dataType:'json',
       url:"{{url('ajax/checkout/getmethodBank')}}",
       data:dataString,
       beforeSend: function(){
         //service cart
          // $('#loadcartservice').css('display','block');
          // $('#cartservice').css('display','none');
          //total cart
          $('#loadcarttotals').css('display','block');
          $('#carttotals').css('display','none');
       },
        success:function(data){
         setTimeout(function(){
          //  $('#loadcartservice').css('display','none');
          //  $('#cartservice').css('display','block');
          //  $("#cartservice").html(data.htmlcart);

           $('#loadcarttotals').css('display','none');
           $('#carttotals').css('display','block');
           $("#carttotals").html(data.htmltotal);
           $('.price_format').priceFormat();

           $('#bank-detail').css('display','block');
         },500);
       }


   });
  }
</script>

<script>
  function getmethodCart(){

   var token ="{{csrf_token()}}";
   var subtotal="{{$subtotal}}";
   var ongkir=$("[name='ongkir']:checked").val();
   var dataString='_token='+ token +'&subtotal='+subtotal+'&ongkir='+ongkir;
   $.ajax({
       type:"GET",
       dataType:'json',
       url:"{{url('ajax/checkout/getmethodCart')}}",
       data:dataString,
       beforeSend: function(){
         //service cart
          // $('#loadcartservice').css('display','block');
          // $('#cartservice').css('display','none');
          //total cart
          $('#loadcarttotals').css('display','block');
          $('#carttotals').css('display','none');
       },
        success:function(data){
         setTimeout(function(){
          //  $('#loadcartservice').css('display','none');
          //  $('#cartservice').css('display','block');
          //  $("#cartservice").html(data.htmlcart);

           $('#loadcarttotals').css('display','none');
           $('#carttotals').css('display','block');
           $("#carttotals").html(data.htmltotal);
           $('.price_format').priceFormat();
           $('#bank-detail').css('display','none');
         },500);
       }

   });
  }
</script>

<script>
  function usevoucher(){

  var token   = "{{csrf_token()}}";
  var kode    =$("#vouchercode").val();
  var ongkir=$("[name='ongkir']:checked").val();
  // var tripid  =$("#tripid").val();
  // var datein  =$("#datein").val();
  // var qty    = $("#qty").val();

  var dataString= '_token='+ token + '&kode=' + kode+'&ongkir='+ ongkir ;


  $.ajax({
    type:"GET",

    //JSON UNTUK MEMECAH DATA
    dataType:'json',
    url:"{{url('ajax/checkout/getVoucher')}}",
    data:dataString,

    beforeSend: function(data){
      //vocher cart
      if(data.status == 0){
       $('#loadcartvoucher').css('display','block');
       $('#cartvoucher').css('display','none');
       //total cart
       $('#loadcarttotals').css('display','block');
       $('#carttotals').css('display','none');
     }
    },

    success: function(data){
        setTimeout(function(){
          if(data.status == 0){
            $('#loadcartvoucher').css('display','none');
            $('#cartvoucher').css('display','block');

            $('#loadcarttotals').css('display','none');
            $('#carttotals').css('display','block');

            $("#success-coupon").html(data.alert);
            $("#cartvoucher").html(data.htmlvoucher);
            $("#carttotals").html(data.htmltotal);

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
     },500);
    }

  });
  }
</script>
<script>
  function checkvalidation(){
    $( ".valid" ).each(function() {
      // alert($(this).find('input').val());
      if ($(this).find('input').val() == '') {
          $(this).addClass('has-error');
      }else if ($(this).find('select').val() == '') {
          $(this).addClass('has-error');
      }else if($(this).find('select').val()=='0'){
          $(this).addClass('has-error');
      }else if ($(this).find('textarea').val()=='') {
          $(this).addClass('has-error');
      }
      else {
        $(this).removeClass('has-error')
      }

    });
    //
    var hitung=[];

    $('.ongkir').each(function(){
       if($(this).prop('checked')==true){
           hitung.push(1);
       }
    });

    // var liat = $('.ongkir:checked').length;
    // console.log(liat);
    // alert(liat);
     if(hitung[0]=='1'){
       $('#valid').removeClass('has-error');
     }else{
       $('#valid').addClass('has-error');
     }


    //  ongkir=$("[name='ongkir']:checked").val();
    // if ($('.valid').hasClass('has-error')) {
    //   // alert('harap isi semua form');
    // }else {
    var token ="{{csrf_token()}}";
    var delivery=$("[name='delivery_method']:checked").val();
    var fullnamebil=$('#fullnamebil').val();
    var phonebil=$('#phonebil').val();
    var emailbil=$('#emailbil').val();
    var addressbil=$('#addressbil').val();
    var postcodebil=$('#postcodebil').val();
    var bilprovince=$('#bilprovince option:selected').text();
    var bilcity=$('#bilcity option:selected').text();
    var bildistrict=$('#bildistrict option:selected').text();
    var subtotal="{{$subtotal}}";
    if(delivery=='ship'){
      //shipping
      var fullnamebook=$('#fullnamebook').val();
      var phonebook=$('#phonebook').val();
      var emailbook=$('#emailbook').val();
      var addressbook=$('#addressbook').val();
      var postcodebook=$('#postcodebook').val();
      var province=$('#province option:selected').text();
      var city=$('#city option:selected').text();
      var subdistrict=$('#subdistrict option:selected').text();
      var ongkir=$("[name='ongkir']:checked").val();

      // var token ="{{csrf_token()}}";
      // var subtotal="{{$subtotal}}";
      // var ongkir=$("[name='ongkir']:checked").val();
      // var dataString='_token='+ token +'&subtotal='+subtotal+'&ongkir='+ongkir;
      // alert(dataString);
      // $.ajax({
      //     type:"GET",
      //     url:"{{url('ajax/gettotal')}}",
      //     data:dataString,
      //     success: function(data){
      //       $("#cart-total").html(data);
      //       $("#carttotal").html('{{ Session::get("grandtotal1") }}');
      //     }
      //
      // });


      $('#viewleft').html(
                '<h3>Shipping Address Information</h3>'+
                '<div class="col-md-12 "  style="">'+
                '<div class="form-group">'+
                '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Recipient Name '+
                '</label>'+
                '<div class="col-sm-9 " style ="padding:0px; ">'+
                ''+fullnamebook+''+
                '</div>'+
                '</div>'+
                '</div>'+

                '<div class="col-md-12 "  style="">'+
                '<div class="form-group">'+
                '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Phone Number '+
                '</label>'+
                '<div class="col-sm-9 " style ="padding:0px; ">'+
                ''+phonebook+''+
                '</div>'+
                '</div>'+
                '</div>'+

                '<div class="col-md-12 "  style="">'+
                '<div class="form-group">'+
                '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Email '+
                '</label>'+
                '<div class="col-sm-9 " style ="padding:0px; ">'+
                ''+emailbook+''+
                '</div>'+
                '</div>'+
                '</div>'+
                '<div class="col-md-12 "  style="">'+
                '<div class="form-group">'+
                '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Address '+
                '</label>'+
                '<div class="col-sm-9 " style ="padding:0px; ">'+
                ''+addressbook+', '+city+', '+province+', '+postcodebook+' ' +
                '</div>'+
                '</div>'+
                '</div>'


      );
          if (document.getElementById('cebox').checked){

                }else{
                  $('#viewright').html(
                            '<h3>Billing Address Information</h3>'+
                            '<div class="col-md-12 "  style="">'+
                            '<div class="form-group">'+
                            '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Recipient Name '+
                            '</label>'+
                            '<div class="col-sm-9 " style ="padding:0px; ">'+
                            ''+fullnamebil+''+
                            '</div>'+
                            '</div>'+
                            '</div>'+

                            '<div class="col-md-12 "  style="">'+
                            '<div class="form-group">'+
                            '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Phone Number '+
                            '</label>'+
                            '<div class="col-sm-9 " style ="padding:0px; ">'+
                            ''+phonebil+''+
                            '</div>'+
                            '</div>'+
                            '</div>'+

                            '<div class="col-md-12 "  style="">'+
                            '<div class="form-group">'+
                            '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Email '+
                            '</label>'+
                            '<div class="col-sm-9 " style ="padding:0px; ">'+
                            ''+emailbil+''+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<div class="col-md-12 "  style="">'+
                            '<div class="form-group">'+
                            '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Address '+
                            '</label>'+
                            '<div class="col-sm-9 " style ="padding:0px; ">'+
                            ''+addressbil+', '+bilprovince+', '+bilcity+', '+bildistrict+' ' +
                            '</div>'+
                            '</div>'+
                            '</div>'


                  );
                }


      // var dataString = '_token=' + token+ '&fullnamebook=' + fullnamebook + '&phonebook=' + phonebook
      //                 + '&emailbook=' + emailbook +'&addressbook=' + addressbook + '&emailbook=' + emailbook +;


    }else if(delivery=='pick'){
      var fullnamebook=$('#fullnamebook').val();
      var phonebook=$('#phonebook').val();
      var emailbook=$('#emailbook').val();
      var addressbook=$('#addressbook').val();
      var postcodebook=$('#postcodebook').val();
      var province=$('#province option:selected').text();
      var city=$('#city option:selected').text();
      var subdistrict=$('#subdistrict option:selected').text();
      var pickdate=$("[name='delivery_date']").val();
      var pickpoint=$('#pickpoint option:selected').text();
      var pointid=$('#pickpoint option:selected').val();

      $('#viewleft').html(
                '<h3>Pickup Address Information</h3>'+
                '<div class="col-md-12 "  style="">'+
                '<div class="form-group">'+
                '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Recipient Name '+
                '</label>'+
                '<div class="col-sm-9 " style ="padding:0px; ">'+
                ''+fullnamebook+''+
                '</div>'+
                '</div>'+
                '</div>'+

                '<div class="col-md-12 "  style="">'+
                '<div class="form-group">'+
                '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Phone Number '+
                '</label>'+
                '<div class="col-sm-9 " style ="padding:0px; ">'+
                ''+phonebook+''+
                '</div>'+
                '</div>'+
                '</div>'+

                '<div class="col-md-12 "  style="">'+
                '<div class="form-group">'+
                '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Email '+
                '</label>'+
                '<div class="col-sm-9 " style ="padding:0px; ">'+
                ''+emailbook+''+
                '</div>'+
                '</div>'+
                '</div>'+
                '<div class="col-md-12 "  style="">'+
                '<div class="form-group">'+
                '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Address '+
                '</label>'+
                '<div class="col-sm-9 " style ="padding:0px; ">'+
                ''+addressbook+', '+province+', '+city+', '+subdistrict+' ' +
                '</div>'+
                '</div>'+
                '</div>'+

                '<div class="col-md-12 "  style="">'+
                '<div class="form-group">'+
                '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Pickup Date / Time '+
                '</label>'+
                '<div class="col-sm-9 " style ="padding:0px; ">'+
                ''+pickdate+'' +
                '</div>'+
                '</div>'+
                '</div>'+

                '<div class="col-md-12 "  style="">'+
                '<div class="form-group">'+
                '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Pickup Point'+
                '</label>'+
                '<div class="col-sm-9 " style ="padding:0px; ">'+
                '<span id="pickcity">  </span> <span> - </span> '+pickpoint+'' +
                '</div>'+
                '</div>'+
                '</div>'


      );
          if (document.getElementById('cebox').checked){

                }else{
                  $('#viewright').html(
                            '<h3>Billing Address Information</h3>'+
                            '<div class="col-md-12 "  style="">'+
                            '<div class="form-group">'+
                            '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Recipient Name '+
                            '</label>'+
                            '<div class="col-sm-9 " style ="padding:0px; ">'+
                            ''+fullnamebil+''+
                            '</div>'+
                            '</div>'+
                            '</div>'+

                            '<div class="col-md-12 "  style="">'+
                            '<div class="form-group">'+
                            '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Phone Number '+
                            '</label>'+
                            '<div class="col-sm-9 " style ="padding:0px; ">'+
                            ''+phonebil+''+
                            '</div>'+
                            '</div>'+
                            '</div>'+

                            '<div class="col-md-12 "  style="">'+
                            '<div class="form-group">'+
                            '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Email '+
                            '</label>'+
                            '<div class="col-sm-9 " style ="padding:0px; ">'+
                            ''+emailbil+''+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<div class="col-md-12 "  style="">'+
                            '<div class="form-group">'+
                            '<label class="control-label col-sm-3 "style ="padding:0px; text-align:left;">Address '+
                            '</label>'+
                            '<div class="col-sm-9 " style ="padding:0px; ">'+
                           ''+addressbil+', '+bilprovince+', '+bilcity+', '+bildistrict+' ' +
                            '</div>'+
                            '</div>'+
                            '</div>'


                  );
                }

      //check pickpoint
      checkPickup(pointid);
      }

      //billing
      var token ="{{csrf_token()}}";
      var subtotal="{{$subtotal}}";
      var ongkir=$("[name='ongkir']:checked").val();

      var dataString='_token='+ token +'&subtotal='+subtotal+'&ongkir='+ongkir+'&province='+province+'&city='+city+'&subdistrict='+subdistrict+ '&bilprovince='+bilprovince+'&bilcity='+bilcity+ '&bildistrict='+bildistrict;

      $("#getshipping").html('<div class="totals-value price_format">'+ongkir+'</div>');
      $('.price_format').priceFormat();
      // alert(dataString);
      $.ajax({
          type:"GET",
          dataType:'json',
          url:"{{url('ajax/checkout/gettotal')}}",
          data:dataString,
          success: function(data){
             $("#dislevel").html(data.htmldislevel);
             $("#levelname").html(data.htmllevelname);
             $("#carttotals").html(data.htmltotal);
             $('.price_format').priceFormat();
          }

      });
    // }
  }
</script>

<script>

function checkPickup(pointid){
  var tokenpoint ="{{csrf_token()}}";
  var dataString1='_token='+ tokenpoint + '&pointid='+ pointid ;

  $.ajax({
      type:"GET",
      url:"{{url('ajax/checkPickup')}}",
      data:dataString1,
      success: function(data){
        $("#pickcity").html(data);
      }

  });

}
</script>

<script type="text/javascript">
   function forget(){
     var token ="{{csrf_token()}}";
     var dataString='_token='+ token ;

     $.ajax({
         type:"GET",
         url:"{{url('ajax/checkout/forgetdata')}}",
         data:dataString,
         success: function(data){
         }

     });

   }
</script>

<script>
  function newpickup(){
      forget();

      $('#methodshipid').html(
            '<div class="col-md-12">'+
            '  <div class="form-group">'+
            '  <h3>Pickup Point</h3>'+
            '  </div>'+
            '  <div class="form-group valid">'+
            '    <label for="Date">Pickup Date / Time *</label>'+
            '    <input id="datepicker" class="date-picker form-control " placeholder="Date"  value="" data-validation-format="yyyy-mm-dd" name="delivery_date" type="text">'+
            '  <input type="hidden" name="" value="" id="triggerdate">'+
            '  </div>'+
            '  <div class="form-group valid">'+
            '    <label for="Point">Pickup Point *</label>'+
            '    <select class="form-control js-example-basic-single" name="pickpoint" id="pickpoint"  required tabindex="-1" aria-hidden="true">'+
            '    <option value="" selected disable>Choose One</option>'+
            '    @foreach($getpick as $pick)'+
            '  <optgroup label="{{$pick->city}}">'+
            '    @foreach($detailpick as $detailpicks)'+
            '  @if($pick->pick_id == $detailpicks->pick_id)'+
            '  <option value="{{$detailpicks->id}}">{{$detailpicks->location}}</option>'+
            '  @endif'+
            '  @endforeach'+
            '  </optgroup>'+
            '  @endforeach'+
            '  </select>'+
            '  </div>'+
            '  <div class="form-group valid">'+
            '    <label for="Date">Address Book *</label>'+

            '  </div>'+
            '<div class="form-group">'+
              '<div class="col-sm-6 col-xs-7 col-new" style="padding-left: 0px;">'+
                    '@if(count($address) > 0)'+
                        '<select name="" class="form-control shipaddress" id="soflowsize"  onchange="pickadd()">'+
                          '<option value=""  selected="">Choose address</option>'+
                          '@foreach($address as $addr)'+
                          '<option value="{{$addr->adress_id}}">{{$addr->title}}</option>'+
                          '@endforeach'+
                        '</select>'+
                    '@else'+
                    '<a href="{{$urldomain}}/user/my-shipping" class="plus-address">Add Shipping</a>'+
                    '@endif'+
                '</div>'+
                '<div class="col-sm-6 col-xs-5 button-new">'+
                  '<a class="btn btn-submit btn-default add-new" onclick="newpickup()">'+
                    'New Address'+
                  '</a>'+
                '</div>'+
              '</div>'+
            '<div id="pickupdate" style="">'+
            '<input type="hidden" name="idadd" id="" value="">'+
            '<div class="form-group valid">'+
            '  <label for="email">Title *</label>'+
            '   <input type="text" class="form-control" id="titlebook" placeholder="Title" ng-model="titlebook" name="titlebook" onkeyup="gettitlebook_sm()" required="" value="">'+
           '  </div>'+
            '<div class="form-group valid">'+
              '<label for="email">Recipient Name *</label>'+
              '<input type="text" class="form-control" id="fullnamebook" placeholder="Name" name="reciptnamebook" onkeyup="getnamebook_sm()" required="" value="">'+
            '</div>'+
            '<div class="form-group valid">'+
              '<label for="pwd">Phone Number *</label>'+
              '<input type="text" class="form-control" id="phonebook"  placeholder="Phone"name="phonebook" onkeyup="getphonebook_sm()"  required="" value="">'+
            '</div>'+
            '<div class="form-group valid">'+
                '<label for="pwd">Email *</label>'+
                '<input type="email" class="form-control"  id="emailbook" placeholder="Email" name="emailbook"  onkeyup="getemailbook_sm()" required="">'+
            '</div>'+
            '<div class="form-group valid">'+
              '<label for="pwd">Address *</label>'+
              '<textarea name="addressbook"id="addressbook" class="form-control input-flat" placeholder="Address" onkeyup="getaddressbook_sm()"  style="resize: vertical;" required="" value=""></textarea>'+
            '</div>'+
            '<div class="form-group valid">'+
              '<label for="pwd">Postal Code *</label>'+
              '<input type="text" class="form-control" id="postcodebook"  placeholder="Postal Code"name="postcodebook" onkeyup="getpostbook_sm()" required="" value="">'+
            '</div>'+

            '<div class="form-group valid">'+
            '<div class="row" id="loadingprovimg" style="display: none;" >'+
              '<div class="col-md-12 text-center">'+
              '  <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
              '</div>'+
            '</div>'+
              '<div id="shippingprovince">'+
                '<div class="row" id="loadingprov" >'+
                  '<div class="col-md-12 text-center">'+
                  '  <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                  '<input type="hidden" class="form-control"  placeholder=""name="province"  required="" value="">'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'+

            '<div class="form-group valid">'+
            '<div class="row" id="loadingcitimg" style="display: none;">'+
              '<div class="col-md-12 text-center">'+
                ' <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
              '</div>'+
            '</div>'+
              '<div id="shippingcity">'+
                '<div class="row" id="loadingcit" style="display: none;">'+
                  '<div class="col-md-12 text-center">'+
                    ' <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                    '<input type="hidden" class="form-control"  placeholder=""name="city"  required="" value="">'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'+

            '<div class="form-group valid">'+
            '<div class="row" id="loadingsubimg" style="display: none;">'+
              '<div class="col-md-12 text-center">'+
                ' <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
              '</div>'+
            '</div>'+
              '<div id="shippingsubdistrict">'+
                '<div class="row" id="loadingsub" style="display: none;">'+
                  '<div class="col-md-12 text-center">'+
                    ' <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                      '<input type="hidden" class="form-control"  placeholder=""name="subdistrict"  required="" value="">'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '</div>'+

            '  </div>'
          );

          getdatepicker();
          getprovince();
          get_city();
          getSubDistrict();

          // var app = angular.module('myApp', []);
          // app.controller('validateCtrl', function($scope) {
          //     $scope.user = 'John Doe';
          //     $scope.email = 'john.doe@gmail.com';
          //     $scope.titlebook = 'test';
          // });

  }
  </script>


  <script>
        function newshipping(){
          $('#methodshipid').html(
                  '<h3>Shipping Address</h3>'+
                  '<div class="col-md-12">'+
                    '<div class="form-group">'+
                      '<div class="col-sm-6 col-xs-7 col-new" style="padding-left: 0px;">'+
                            '@if(count($address) > 0)'+
                                '<select name="" class="form-control shipaddress" id="soflowsize"  onchange="shipadd()">'+
                                  '<option value="" disabled="" selected="">Choose address</option>'+
                                  '@foreach($address as $addr)'+
                                  '<option value="{{$addr->adress_id}}">{{$addr->title}}</option>'+
                                  '@endforeach'+
                                '</select>'+
                            '@else'+
                            '<a href="{{$urldomain}}/user/my-shipping" class="plus-address">Add Shipping</a>'+
                            '@endif'+
                        '</div>'+
                        '<div class="col-sm-6 col-xs-5 button-new">'+
                          '<a class="btn btn-submit btn-default add-new" onclick="newaddr()">'+
                            'New Address'+
                          '</a>'+
                        '</div>'+
                      '</div>'+
                      '<div id="shipupdate" style="">'+
                        '<input type="hidden" name="idadd" id="" value="">'+
                        '<div class="form-group valid">'+
                        '  <label for="email">Title *</label>'+
                        '  <input type="text" class="form-control" id="titlebook" placeholder="Title" name="titlebook" onkeyup="gettitlebook_sm()" required="" value="">'+
                       '  </div>'+
                        '<div class="form-group valid">'+
                          '<label for="email">Recipient Name *</label>'+
                          '<input type="text" class="form-control" id="fullnamebook" placeholder="Name" name="reciptnamebook" onkeyup="getnamebook_sm()" required="" value="">'+
                        '</div>'+
                        '<div class="form-group valid">'+
                          '<label for="pwd">Phone Number *</label>'+
                          '<input type="text" class="form-control" id="phonebook"  placeholder="Phone"name="phonebook" onkeyup="getphonebook_sm()"  required="" value="">'+
                        '</div>'+
                        '<div class="form-group valid">'+
                            '<label for="pwd">Email *</label>'+
                            '<input type="email" class="form-control"  id="emailbook" placeholder="Email" name="emailbook"  onkeyup="getemailbook_sm()" required="">'+
                        '</div>'+
                        '<div class="form-group valid">'+
                          '<label for="pwd">Address *</label>'+
                          '<textarea name="addressbook"id="addressbook" class="form-control input-flat" placeholder="Address" onkeyup="getaddressbook_sm()"  style="resize: vertical;" required="" value=""></textarea>'+
                        '</div>'+
                        '<div class="form-group valid">'+
                          '<label for="pwd">Postal Code *</label>'+
                          '<input type="text" class="form-control" id="postcodebook"  placeholder="Postal Code"name="postcodebook" onkeyup="getpostbook_sm()" required="" value="">'+
                        '</div>'+

                        '<div class="form-group valid" >'+
                          '<div class="row" id="loadingprovimg" style="display: none;">'+
                            '<div class="col-md-12 text-center">'+
                            '  <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                            '</div>'+
                          '</div>'+
                          '<div id="shippingprovince">'+
                            '<div class="row" id="loadingprov" >'+
                              '<div class="col-md-12 text-center">'+
                              '  <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                              '</div>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+

                        '<div class="form-group valid">'+
                          '<div class="row" id="loadingcitimg" style="display: none;">'+
                            '<div class="col-md-12 text-center">'+
                              ' <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                            '</div>'+
                          '</div>'+
                          '<div id="shippingcity">'+
                            '<div class="row" id="loadingcit" style="display: none;">'+
                              '<div class="col-md-12 text-center">'+
                                ' <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                              '</div>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group valid">'+
                          '<div class="row" id="loadingsubimg" style="display: none;">'+
                            '<div class="col-md-12 text-center">'+
                              ' <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                            '</div>'+
                          '</div>'+
                          '<div id="shippingsubdistrict">'+
                            '<div class="row" id="loadingsub" style="display: none;">'+
                              '<div class="col-md-12 text-center">'+
                                ' <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                              '</div>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group valid" id="valid">'+
                          '<div class="row" id="loadingcostimg" style="display: none;">'+
                            '<div class="col-md-12 text-center">'+
                              ' <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                            '</div>'+
                          '</div>'+
                        '  <div id="shippingcost">'+
                            '<div class="row" id="loadingcost" style="display: none;">'+
                              '<div class="col-md-12 text-center">'+
                                ' <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                              '</div>'+
                            '</div>'+
                          '</div><br>'+
                        '</div>'+
                      '</div>'+
                    '</div>'
          );
          getprovince();
          get_city();
          getSubDistrict();
        }
  </script>


    <!-- START script BILLING -->
    <script>
      function gettitlebook_sm(){
        if(document.getElementById('cebox').checked){
          var titlebook=$('#titlebook').val();
          $('#titlebil').val(titlebook);
        }
      }
      function getnamebook_sm(){
        if (document.getElementById('cebox').checked){
          var namebook=$('#fullnamebook').val();
          $('#fullnamebil').val(namebook);
        }
      }
      function getphonebook_sm(){
        if (document.getElementById('cebox').checked){
          var phonebook=$('#phonebook').val();
          $('#phonebil').val(phonebook);
        }
      }

      function getemailbook_sm(){
        if (document.getElementById('cebox').checked){
          var emailbook=$('#emailbook').val();
          $('#emailbil').val(emailbook);
        }
      }
      function getaddressbook_sm(){
        if (document.getElementById('cebox').checked){
          var addressbook=$('#addressbook').val();
          $('#addressbil').val(addressbook);
        }
      }
      function getpostbook_sm(){
        if (document.getElementById('cebox').checked){
          var postcodebook=$('#postcodebook').val();
          $('#postcodebil').val(postcodebook);
        }
      }

      function checkbiling(){

          if (document.getElementById('cebox').checked){
              $('#biladdress').hide();
              $('.checkvalid').removeClass('valid');
              $('.checkvalid').removeClass('has-error');

              var titlebook=$('#titlebook').val();
              $('#titlebil').val(titlebook);
              var namebook=$('#fullnamebook').val();
              $('#fullnamebil').val(namebook);

              var phonebook=$('#phonebook').val();
              $('#phonebil').val(phonebook);

              var emailbook=$('#emailbook').val();
              $('#emailbil').val(emailbook);

              var addressbook=$('#addressbook').val();
              $('#addressbil').val(addressbook);

              var postcodebook=$('#postcodebook').val();
              $('#postcodebil').val(postcodebook);

              var province=$('#province option:selected').val();
              $('#bilprovince').val(province);

              get_bilingcity();

              var city=$("[name='city'] option:selected").val();
              $('#bilcity').val(city);

              get_bilingdistrict();

              var subdistrict=$("[name='subdistrict'] option:selected").val();
              $('#bildistrict').val(subdistrict);

              // checkbiling2();
              // checkbiling3();


          }else {
                $('.checkvalid').addClass('valid');
                $('#biladdress').show();


          }
        }
        function checkbiling1(){
          var province=$('#province option:selected').val();
          $('#bilprovince').val(province);
        }
        function checkbiling2(){

          var city=$("[name='city']").val();
          $('#bilcity').val(city);
          checkbiling3();
          var subdistrict=$("[name='subdistrict']").val();
          $('#bildistrict').val(subdistrict);

        }
        function checkbiling3(){
          var subdistrict=$("[name='subdistrict']").val();
          $('#bildistrict').val(subdistrict);
        }

    </script>
    <!-- END BILLING -->

    <!-- START AJAX PICKUP-->
    <script>
      function methodpickup(){
           $('#methodshipid').hide();
           $('#methodpickid').show();
      }
      function methodship(){
          $('#methodpickid').hide();
          $('#methodshipid').show();
      }
    </script>
    <!-- END AJAX PICKUP -->


    <!-- START AJAX BILLING -->
    <script type="text/javascript">

      function pickadd(){

          var idadd = $('.shipaddress').val();

          var token = "{{csrf_token()}}";
          var dataString = '_token=' + token+ '&idadd=' + idadd;
          $.ajax({
              type: "POST",
              url: "{{ url('ajax/pickaddr') }}",
              data: dataString,
              success: function (data) {
                  $('#pickupdate').html(data);
                  getprovince2();
                  get_city2();
              }
          });
      }
  </script>

    <script>
    $(document).ready(function() {
        //Fungsi untuk Shipping
        var token = "{{ csrf_token() }}";
        var dataString = '_token=' + token;
        //var dataString = '_token='+token +' &k_tujuan=' + k_tujuan;
        $.ajax({
            type: "POST",
            url: "{{ url('ajax/bilingprovince') }}",
            data: dataString,

            success: function(data) {
                $('#bilingprovince').html(data);
                get_bilingcity();
                get_bilingdistrict();
                $('#methodpickid').hide();

            }
        });
        //settimeout();
    });
    </script>

    <script>
    function get_bilingprovince() {
      var token = "{{ csrf_token() }}";
      var dataString = '_token=' + token;
      //var dataString = '_token='+token +' &k_tujuan=' + k_tujuan;
      $.ajax({
          type: "POST",
          url: "{{ url('ajax/bilingprovince') }}",
          data: dataString,

          success: function(data) {
              $('#bilingprovince').html(data);
              get_bilingcity();
              get_bilingdistrict();
          }
      });
    }

    //Ajax untuk nampilkan kota
    function get_bilingcity() {

        $('#loadingcit').fadeIn();
        //Fungsi untuk Shipping
        var token = "{{ csrf_token() }}";
        var province = $('#bilprovince').val();
        var provincename = $("#bilprovince").find('option:selected').attr("data-name");
        var dataString = '_token=' + token + '&province=' + province + '&provincename=' + provincename;


        // var dataString = '_token='+ token +' &province=' + province;
        $.ajax({
            type: "POST",
            url: "{{ url('ajax/bilingcity') }}",
            data: dataString,
            success: function(data) {
                $('#bilingcity').html(data);
                get_bilingdistrict();
            }
        });
    }
    //Ajax untuk mempilkan harga


    //Ajax untuk mempilkan city
    function get_bilingdistrict() {
        $('#loadingsub').fadeIn();
        var token ="{{ csrf_token() }}";
        var city = $('#bilcity').val();
        var cityname = $("#bilcity").find('option:selected').attr("data-name");
        var dataString = '_token=' + token + '&city=' + city + '&cityname=' + cityname;
        $.ajax({
            type: "POST",
            url: "{{ url('ajax/bilingsubdistrict') }}",
            data: dataString,
            success: function(data) {
                $('#bilingsubdistrict').html(data);
            }
        });
    }
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#alamat').change(function(){

            });
        });
    </script>

    <!-- START AJAX SHIPPING -->
    <script>
    $(document).ready(function() {
      // getprovince2();
      // get_city2();
      getprovince();
      get_city();
      getSubDistrict();
    });
    </script>
    <script>
      function newaddr(){
          $('#shipupdate').html(
                              '<input type="hidden" name="idadd" id="" value="">'+
                              '<div class="form-group valid">'+
                              '  <label for="email">Title *</label>'+
                              '  <input type="text" class="form-control" id="titlebook" placeholder="Title" name="titlebook" onkeyup="gettitlebook_sm()" required="" value="">'+
                             '  </div>'+
                              ' <div class="form-group valid">'+
                              '  <label for="email">Recipient Name *</label>'+

                              '  <input type="text" class="form-control" placeholder="Name" id="fullnamebook" name="reciptnamebook"onkeyup="getnamebook_sm()"  required="" >'+
                              ' </div>'+
                              '  <div class="form-group valid">'+
                              '  <label for="pwd">Phone Number *</label>'+
                              '   <input type="text" class="form-control" placeholder="Phone" id="phonebook" name="phonebook" onkeyup="getphonebook_sm()" required="">'+
                              ' </div>'+
                                '<div class="form-group valid">'+
                              '  <label for="pwd">Email *</label>'+
                              '  <input type="email" class="form-control" placeholder="Email"  id="emailpickupbook" name="emailpickup"  onkeyup="getemailbook_sm()" required="">'+
                              '  </div>'+
                              '  <div class="form-group valid">'+
                              '      <label for="pwd">Address *</label>'+
                              '     <textarea name="addressbook" id="addressbook" class="form-control input-flat" placeholder="Address" style="resize: vertical;" required=""onkeyup="getaddressbook_sm()"  value=""></textarea>'+
                              ' </div>'+
                              '  <div class="form-group valid">'+
                              '      <label for="pwd">Postal Code *</label>'+
                              '     <input type="text" class="form-control" placeholder="Postal Code" id="postcodebook" name="postcodebook" required="" onkeyup="getpostbook_sm()" value="">'+
                              ' </div>'+
                              ' <div class="form-group valid">'+
                              '   <div id="shippingprovince">'+
                              '     <div class="row" id="loadingprov" >'+
                              '       <div class="col-md-12 text-center">'+
                              '          <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                              '      </div>'+
                              '  </div>'+
                              ' </div>'+
                              ' </div>'+

                              '  <div class="form-group valid">'+
                              '   <div id="shippingcity">'+

                              '   <div class="row" id="loadingcit" style="display: none;">'+
                              '   <div class="col-md-12 text-center">'+
                              '          <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                              '  </div>'+
                              ' </div>'+
                              '  </div>'+
                              ' </div>'+
                              ' <div class="form-group valid">'+

                              '   <div id="shippingsubdistrict">'+

                              '     <div class="row" id="loadingsub" style="display: none;">'+
                              '     <div class="col-md-12 text-center">'+
                              '          <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                              '   </div>'+
                              '  </div>'+
                              ' </div>'+
                              '</div>'+
                              '<div class="form-group valid" id="valid">'+
                              '    <div id="shippingcost">'+
                              '    <div class="row" id="loadingcost" style="display: none;">'+
                              '      <div class="col-md-12 text-center">'+
                              '          <img src="{{$urldomain}}/assets/img/web/small_loading.gif" alt="loading">'+
                              '    </div>'+
                              '  </div>'+
                              ' </div><br><br>'+
                              ' </div>');
                              getprovince();
                              get_city();
                              getSubDistrict();

      }
    </script>

    <script type="text/javascript">

      function shipadd(){

          var idadd = $('.shipaddress').val();

          var token = "{{csrf_token()}}";
          var dataString = '_token=' + token+ '&idadd=' + idadd;
          $.ajax({
              type: "POST",
              url: "{{ url('ajax/shipaddr') }}",
              data: dataString,
              success: function (data) {
                  $('#shipupdate').html(data);
                      getprovince2();
                      get_city2();
              }
          });
      }
  </script>
    <script>
        function getprovince(){
          //Fungsi untuk Shipping
          var token = "{{ csrf_token() }}";
          var dataString = '_token=' + token;
          //var dataString = '_token='+token +' &k_tujuan=' + k_tujuan;
          $.ajax({
              type: "POST",
              url: "{{ url('ajax/shippingprovince') }}",
              data: dataString,

              success: function(data) {
                  $('#shippingprovince').html(data);
                  get_city();
              }
          });
          //settimeout();
        }
        function getprovince2(){

          //Fungsi untuk Shipping
          var token = "{{ csrf_token() }}";
          var addid =$('[name=idadd]').val();
          var dataString = '_token=' + token;
          //var dataString = '_token='+token +' &k_tujuan=' + k_tujuan;
          $.ajax({
              type: "POST",
              url: "{{ url('ajax/shippingprovince2') }}"+"/"+addid,
              data: dataString,

              success: function(data) {
                  $('#shippingprovince').html(data);
                  get_city2();
              }
          });
          //settimeout();
        }
        function get_city2() {

            $('#loadingcit').fadeIn();
            //Fungsi untuk Shipping
            var token = "{{ csrf_token() }}";
            var province = $('#province').val();

            var provincename = $("#province").find('option:selected').attr("data-name");
            var dataString = '_token=' + token + '&province=' + province + '&provincename=' + provincename;
            var addid =$('[name=idadd]').val();
            // var dataString = '_token='+ token +' &province=' + province;
            $.ajax({
                type: "POST",
                url: "{{ url('ajax/shippingcity2') }}"+"/"+addid,
                data: dataString,
                success: function(data) {
                    $('#shippingcity').html(data);
                    getSubDistrict2();
                }
            });
        }


        //Ajax untuk mempilkan city
        function getSubDistrict2() {
            $('#loadingsub').fadeIn();
            var token ="{{ csrf_token() }}";
            var city = $('#city').val();
            var cityname = $("#city").find('option:selected').attr("data-name");
            var dataString = '_token=' + token + '&city=' + city + '&cityname=' + cityname;
            var addid =$('[name=idadd]').val();
            $.ajax({
                type: "POST",
                url: "{{ url('ajax/shippingsubdistrict2') }}"+"/"+addid,
                data: dataString,
                success: function(data) {
                    $('#shippingsubdistrict').html(data);
                    // alert(data);
                    get_cost();
                }
            });
        }
        //Ajax untuk nampilkan kota
        function get_city() {

            $('#loadingcit').fadeIn();
            //Fungsi untuk Shipping
            var token = "{{ csrf_token() }}";
            var province = $('#province').val();
            var provincename = $("#province").find('option:selected').attr("data-name");

            var dataString = '_token=' + token + '&province=' + province + '&provincename=' + provincename;
            // var dataString = '_token='+ token +' &province=' + province;
            $.ajax({
                type: "POST",
                url: "{{ url('ajax/shippingcity') }}",
                data: dataString,

                beforeSend: function(){
                 $('#loadingcitimg').css('display','block');
                 $('#shippingcity').css('display','none');

                 $('#loadingsubimg').css('display','block');
                 $('#shippingsubdistrict').css('display','none');

                 $('#loadingcostimg').css('display','block');
                 $('#shippingcost').css('display','none');
                },
                success: function(data) {
                  setTimeout(function () {
                      $('#loadingcitimg').css('display','none');
                      $('#shippingcity').css('display','block');

                      $('#loadingsubimg').css('display','none');
                      $('#shippingsubdistrict').css('display','block');

                      $('#loadingcostimg').css('display','none');
                      $('#shippingcost').css('display','block');

                      $('#shippingcity').html(data);
                      $('#shippingcity1').html(data);
                      getSubDistrict();
                  },500);
                }
            });
        }
        //Ajax untuk mempilkan harga


        //Ajax untuk mempilkan city
        function getSubDistrict() {
            $('#loadingsub').fadeIn();
            var token ="{{ csrf_token() }}";
            var city = $('#city').val();
            var cityname = $("#city").find('option:selected').attr("data-name");

            var dataString = '_token=' + token + '&city=' + city + '&cityname=' + cityname;
            $.ajax({
                type: "POST",
                url: "{{ url('ajax/shippingsubdistrict') }}",
                data: dataString,
                beforeSend: function(){

                 $('#loadingsubimg').css('display','block');
                 $('#shippingsubdistrict').css('display','none');

                 $('#loadingcostimg').css('display','block');
                 $('#shippingcost').css('display','none');
                },
                success: function(data) {
                    setTimeout(function () {
                      $('#loadingsubimg').css('display','none');
                      $('#shippingsubdistrict').css('display','block');

                      $('#loadingcostimg').css('display','none');
                      $('#shippingcost').css('display','block');

                      $('#shippingsubdistrict').html(data);
                      $('#shippingsubdistrict1').html(data);
                      // alert(data);
                      get_cost();
                    },500);
                }
            });
        }

        var weight = 1000;
        function get_cost() {
            $('#loadingcost').fadeIn();
            //Fungsi untuk Shipping
            var package = $("#ongkir1").attr("package-name");
            var ongkir = $('input[name="ongkir"]:checked').val();
            var token = "{{ csrf_token() }}";
            var city = $('#city').val();

            var cityname = $("#city").find('option:selected').attr("data-name");
            var subdistrict = $('#subdistrict').val();
            var subdistrictname = $("#subdistrict").find('option:selected').attr("data-name");
            // $('.totalWeightCart').each(function(index, element) {

            //     weight = 1000; //weight + parseFloat($(element).val());
            // });
            var cityname = $("#city").find('option:selected').attr("data-name");
            var dataString = '_token=' + token + '&subdistrict=' + subdistrict + '&subdistrictname=' + subdistrictname + '&city=' + city + '&weight=' + weight + '&cityname=' + cityname;
            $.ajax({
                type: "POST",
                url: "{{ url('ajax/shippingcost') }}",
                data: dataString,
                beforeSend: function(){

                 $('#loadingcostimg').css('display','block');
                 $('#shippingcost').css('display','none');

                },

                success: function(data) {
                    setTimeout(function () {
                      $('#loadingcostimg').css('display','none');
                      $('#shippingcost').css('display','block');

                        $('#shippingcost').html(data);
                        set_ongkir(ongkir, package);
                    },500);
                }
            });
        }

        function set_ongkir(ongkir, package) {
            //Fungsi untuk Shipping
            var token = "{{ csrf_token() }}";
            var province = $('#province').val();

            var city = $('#city').val();
            var subdistrict = $("#subdistrict").find('option:selected').attr("data-name");
            if($('input[name="ongkir"]:checked').val() != 0) {
                $('#byReq').prop('disabled', true);
                var ongkir = $('input[name="ongkir"]:checked').val();
                var paket = package + ' RP ' + ongkir;
                var kurir = "JNE";
                setOngkir(token, province, subdistrict, city, ongkir, paket, kurir);
            } else {
                $('#byReq').prop('disabled', false);
                var kurir = " ";
                var paket = "Staff kami akan menghubungi anda untuk mengkonfirmasi PAKET yang akan anda gunakan melalui telepon.";
                var ongkir2 = 0;
                setOngkir(token, province, subdistrict, city, ongkir2, paket, kurir);
                $('#byReq').on('change', function() {
                    var kurir = $('#byReq').val();
                    var ongkir3 = 0;
                    var paket = "Staff kami akan menghubungi anda untuk mengkonfirmasi PAKET yang akan anda gunakan melalui telepon.";
                    setOngkir(token, province, subdistrict, city, ongkir3, paket, kurir);
                });
            }
        }

        function setOngkir(token, province, city, subdistrict, ongkir, paket, kurir) {
            var dataString = '_token=' + token
                + '&province=' + province
                + '&city=' + city
                + '&subdistrict=' + subdistrict
                + '&ongkir=' + ongkir
                + '&paket=' + paket
                + '&kurir=' + kurir;
            $.ajax({
                type: "POST",
                url: "{{ url('ajax/shippingongkir') }}",
                data: dataString,
                success: function(data) {
                    $('#shipping_cost').load(location.href + ' #shipping_cost ', function() {
                        $('.price_format').priceFormat();
                    });
                    $('#total').load(location.href + ' #total ', function() {
                        $('.price_format').priceFormat();
                    });
                    $('#checkoutbtn').load(location.href + ' #checkoutbtn');
                }
            });
        }
    </script>

    <!-- END AJAX SHIPPING-->


    <script>
      $(document).ready(function() {
          // You don't need to care about this function
          // It is for the specific demo
          function adjustIframeHeight() {
              var $body   = $('body'),
                  $iframe = $body.data('iframe.fv');
              if ($iframe) {
                  // Adjust the height of iframe
                  $iframe.height($body.height());
              }
          }

          $('#installationForm')
              .formValidation({
                  framework: 'bootstrap',
                  icon: {
                      valid: 'glyphicon glyphicon-ok',
                      invalid: 'glyphicon glyphicon-remove',
                      validating: 'glyphicon glyphicon-refresh'
                  },
                  // This option will not ignore invisible fields which belong to inactive panels
                  // excluded: ':disabled',
                  fields: {

                      email: {
                          validators: {
                              notEmpty: {
                                  message: 'The email address is required'
                              },
                              emailAddress: {
                                  message: 'The email address is not valid'
                              }
                          }
                      },

                  }
              })
              .bootstrapWizard({
                  tabClass: 'nav nav-pills',
                  onTabClick: function(tab, navigation, index) {


                      return validateTab(index);

                  },
                  onNext: function(tab, navigation, index) {

                      var numTabs    = $('#installationForm').find('.tab-pane').length,
                          isValidTab = validateTab(index - 1);
                      if (!isValidTab) {
                          return false;
                      }
                      if (index === numTabs) {
                      }
                      return true;
                  },
                  onPrevious: function(tab, navigation, index) {


                      return validateTab(index + 1);
                  },
                  onTabShow: function(tab, navigation, index) {


                      // Update the label of Next button when we are at the last tab
                      var numTabs = $('#installationForm').find('.tab-pane').length;
                      $('#installationForm')
                          .find('.next')
                          .removeClass('disabled')    // Enable the Next button
                          .find('a')

                          .html(index === numTabs - 1 ? 'Install' : 'Next');

                        if(index === numTabs - 1){
                            // $("#next1").show();
                            // $("#col-next1").show();
                            // $("#col-next2").show();


                        }else{
                          // $("#next1").hide();
                          // $("#col-next1").hide();
                          // $("#col-next2").hide();

                        }

                      adjustIframeHeight();
                  }
              });

          function validateTab(index) {
            if ($('.valid').hasClass('has-error')) {
              // alert('harap isi semua form');
              var fv   = $('#installationForm').data('formValidation'), // FormValidation instance
                  // The current tab
                  $tab = $('#installationForm').find('.tab-pane').eq(index);
              // Validate the container
              fv.validateContainer($tab);

              var isValidStep = fv.isValidContainer($tab);
              if (isValidStep === false || isValidStep === null) {
                  // Do not jump to the target tab
                  return false;
              }
                return false;
            }else {

                var fv   = $('#installationForm').data('formValidation'), // FormValidation instance
                    // The current tab
                    $tab = $('#installationForm').find('.tab-pane').eq(index);
                // Validate the container
                fv.validateContainer($tab);

                var isValidStep = fv.isValidContainer($tab);
                if (isValidStep === false || isValidStep === null) {
                    // Do not jump to the target tab
                    return false;
                }

                return true;
            }
          }
      });
  </script>
    <script>
     function getdatepicker(){
        $('#datepicker').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: 'DD/MM/YYYY h:mm A',
          },
          singleDatePicker: true,
          calender_style: "picker_4",
        },
        function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });

        if ($('#triggerdate').val() == '') {
          $("#datepicker").val('');
        }

        $("#datepicker").focus(function(){
          if ($("#datepicker").val() == '') {
            $('.table-condensed tbody tr td').removeClass('active');
          }

        });

        $("#datepicker").focusout(function(){
          if ($('.table-condensed tbody tr td').hasClass('active')) {

          }else {
            $("#datepicker").val('');
          }
        });

        var date = $('#datepicker');
        date.on('keydown', function() {
          var key = event.keyCode || event.charCode;
          if( key == 8 || key == 46 )
          $("#datepicker").val('');
          $('.table-condensed tbody tr td').removeClass('active');
        });
      }
    </script>



@endsection
