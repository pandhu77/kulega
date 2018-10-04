@extends('web.master')
@section('title','Sonia')
@section('content')

@push('css')
<style media="screen">
    .icon-number{
        font-size: 17px;
        background-color: #666666;
        padding: 3px 12px 6px 13px;
        border-radius: 20px;
        color: #fff;
    }

    .express-title{
        background-color: #eee;
        padding: 10px 20px;
        font-size: 17px;
    }

    .button.button-3d:hover{
        background-color: #000 !important;
    }

    #addressmodal .form-control{
        margin-bottom: 10px;
        border-radius: 0px;
    }

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        border-top:none;
    }

    .shipping-cour{
      list-style-type: none;
    }

    .shipping-cour li {
      padding: 10px 20px;
      border: 1px solid #eee;
      margin-bottom: 10px;
    }

    .radio-green [type="radio"]:checked+label:after {
        border-color: #00C851;
        background-color: #00C851;
    }
    /*Gap*/

    .radio-green-gap [type="radio"].with-gap:checked+label:before {
        border-color: #00C851;
    }

    .radio-green-gap [type="radio"]:checked+label:after {
        border-color: #00C851;
        background-color: #00C851;
    }

    .panel-default{
        border-radius: 0px !important;
        border: transparent !important;
        -webkit-box-shadow: 0 0px 0px rgba(0,0,0,0) !important;
        box-shadow: 0 0px 0px rgba(0,0,0,0) !important;
        border-bottom: 1px solid #dedfde !important;
        padding: 10px 0px !important;
    }

    .panel-default>.panel-heading {
        color: #333;
        background-color: #fff;
        border-color: #e4e5e7;
        padding: 0;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .panel-default>.panel-heading a {
        display: block;
        padding: 10px 0px;
    }

    .panel-default>.panel-heading a:after {
        content: "";
        position: relative;
        top: 1px;
        display: inline-block;
        font-family: 'Glyphicons Halflings';
        font-style: normal;
        font-weight: 400;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        float: right;
        transition: transform .25s linear;
        -webkit-transition: -webkit-transform .25s linear;
    }

    .panel-default>.panel-heading a[aria-expanded="true"] {
        background-color: #fff;
    }

    .panel-default>.panel-heading a[aria-expanded="true"]:after {
        content: "\2212";
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
    }

    .panel-default>.panel-heading a[aria-expanded="false"]:after {
        content: "\002b";
        -webkit-transform: rotate(90deg);
        transform: rotate(90deg);
    }

    .accordion-option {
        width: 100%;
        float: left;
        clear: both;
        margin: 15px 0;
    }

    .accordion-option .title {
        font-size: 20px;
        font-weight: bold;
        float: left;
        padding: 0;
        margin: 0;
    }

    .accordion-option .toggle-accordion {
        float: right;
        font-size: 16px;
        color: #6a6c6f;
    }

    .accordion-option .toggle-accordion:before {
        content: "Expand All";
    }

    .accordion-option .toggle-accordion.active:before {
        content: "Collapse All";
    }

    .button-black:focus, .button-black:hover{
        color: #fff;
        background-color: #000;
    }

    @media (max-width: 479px){
      .container, #header.full-header .container, .container-fullwidth {
          width: auto !important;
      }
    }
</style>
@endpush

<!-- BEGIN PRODUCTS -->
<section id="main-products">
  <div class="container">
    <div class="row section-title text-center">
      <div class="col-md-12">
        <h3>CART</h3>
      </div>
    </div>
  </div>
</section>
<!-- ./END PRODUCTS -->

<section id="content">

    <div class="content-wrap" style="padding-top:0px;">

        <div class="container clearfix">

            <div class="table-responsive">
                <table class="table cart">
                    <thead>
                        <tr>
                            <th class="cart-product-remove"> </th>
                            <th class="cart-product-thumbnail"> </th>
                            <th class="cart-product-name">Product</th>
                            <th class="cart-product-size">Size</th>
                            <th class="cart-product-color">Color</th>
                            <th class="cart-product-price">Unit Price</th>
                            <th class="cart-product-quantity">Quantity</th>
                            <th class="cart-product-subtotal">Total</th>
                        </tr>
                    </thead>
                    <tbody id="cartbody">

                        <?php $totalcart  = 0; ?>
                        @foreach($carts as $cart)
                        <tr class="cart_item" id="{{ $cart->rowId }}">
                            <td class="cart-product-remove">
                                <a href="javascript:void(0)" class="remove" title="Remove this item" onclick="removerow('{{ $cart->rowId }}')"><i class="icon-trash2"></i></a>
                            </td>
                            <td class="cart-product-thumbnail">
                                <a href="{{ url('products/'.$cart->options['url']) }}"><img width="64" height="64" src="{{ asset($cart->options['image']) }}" alt="{{ $cart->name }}"></a>
                            </td>
                            <td class="cart-product-name">
                                <a href="{{ url('products/'.$cart->options['url']) }}">{{ $cart->name }}</a>
                            </td>
                            <td class="cart-product-size">
                                {{ $cart->options["size"] }}
                            </td>
                            <td class="cart-product-color">
                                {{ $cart->options["color"] }}
                            </td>
                            <td class="cart-product-price">
                                <span class="amount"><?= number_format($cart->price,0,',','.') ?></span>
                            </td>
                            <td class="cart-product-quantity">
                                <div class="quantity clearfix">
                                    <input type="button" value="-" class="minus" onclick="getquantity('{{ $cart->rowId }}','minus')">
                                    <input type="text" name="quantity" class="qty" value="{{ $cart->qty }}"/>
                                    <input type="button" value="+" class="plus" onclick="getquantity('{{ $cart->rowId }}','plus')">
                                </div>
                            </td>
                            <td class="cart-product-subtotal">
                                <span class="amount"><?= number_format($cart->qty*$cart->price,0,',','.') ?></span>
                            </td>
                        </tr>
                        <?php $totalcart = $totalcart + ($cart->price*$cart->qty); ?>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="col-sm-4" style="padding-left:0px;padding-right:0px;margin-top:20px;">
                <div class="col-xs-6 nopadding">
                    <input type="text" name="voucher_code" class="sm-form-control" placeholder="Enter Coupon Code.." value="{{ Session::get('voucher_code') }}"/>
                </div>
                <div class="col-xs-6">
                    <a href="javascript::void(0)" class="button button-3d button-black nomargin" onclick="checkvoucher()" id="btn-voucher">Apply Coupon</a>
                </div>
            </div>
            <div class="col-sm-offset-2 col-sm-6" style="padding-left:0px;padding-right:0px;margin-top:20px;">
              <div class="col_full" style="border:1px solid #CCCCCC;padding:20px;">
                <table class="table cart">
                    <tbody>
                        <tr class="cart_item">
                            <td class="cart-product-name">
                                <strong>Cart Subtotal</strong>
                            </td>
                            <td class="cart-product-name">
                                <span class="amount" id="cart-subtotal"></span>
                            </td>
                        </tr>
                        <tr class="cart_item">
                            <td class="cart-product-name">
                                <strong>Shipping</strong>
                            </td>
                            <td class="cart-product-name">
                                <span class="amount" id="shipping-price">0</span>
                            </td>
                        </tr>
                        <tr class="cart_item">
                            <td class="cart-product-name">
                                <strong>Voucher</strong>
                            </td>
                            <td class="cart-product-name">
                                <span class="amount" id="voucher-price">
                                    <?php
                                    if(Session::has("voucher_value")){
                                        if (Session::get('voucher_type') == 3) {
                                            echo "Free Shipping";
                                        } else {
                                            echo '-'.number_format(Session::get("voucher_value"),0,',','.');
                                            if(Session::get('voucher_type') == 2){
                                                echo "%";
                                            };
                                        }
                                    }else{
                                        echo '0';
                                    }
                                    ?>
                                </span>
                            </td>
                        </tr>
                        <tr class="cart_item">
                            <td class="cart-product-name">
                                <strong>Total</strong>
                            </td>
                            <td class="cart-product-name">
                                <span class="amount color lead" style="color:#1ABC9C !important;"><strong id="cart-total"></strong></span>
                            </td>
                        </tr>
                        <!-- <tr class="cart_item">
                            <td colspan="2">
                                <div class="row clearfix">
                                    <div class="col-md-12 col-xs-12 nopadding">
                                        <a href="javascript:void(0)" class="button button-3d notopmargin fright" onclick="gotocheckout()" id="btn-checkout" style="background-color:#D19E9A;">Proceed to Checkout</a>
                                    </div>
                                </div>
                            </td>
                        </tr> -->
                    </tbody>

                </table>
              </div>
            </div>

            <div class="clearfix"></div>


            <h3 class="express-title">EXPRESS CHECKOUT</h3>

            <div class="row clearfix">

                <div class="col-md-4 clearfix">
                    <h4><label class="icon-number">1</label> Shipping Address</h4>

                    <div class="col_full" style="border:1px solid #CCCCCC;padding:20px;">
                        <label>Choose Shipping Address</label>
                        <select class="sm-form-control" name="addressid" onchange="getaddrcontent()">
                            <option value="" selected="" disabled="">Select</option>
                            @foreach($addr as $add)
                                <option value="{{ $add->id }}">{{ $add->title }}</option>
                            @endforeach
                        </select>

                        <hr>
                        <div class="col_full" id="addr-content">

                        </div>

                        <div class="col_full" style="margin-bottom:0px;">
                            <a href="javascript:void(0)" class="btn btn-info" style="margin-bottom:0px;background-color:#000;border-color:#000;" onclick="addaddress()">Add Address</a>
                        </div>
                    </div>

                </div>

                <div class="col-md-4 clearfix">
                    <h4><label class="icon-number">2</label> Shipping Courier</h4>

                    <div class="col_full" style="border:1px solid #CCCCCC;padding:20px;">
                        <label>Choose Shipping Courier</label>

                        <ul class="shipping-cour">
                            <input type="radio" name="cost" class="hidden" value="0" checked>
                          Please Select Your Address.
                        </ul>

                    </div>

                </div>

                <div class="col-md-4 clearfix">
                    <div class="table-responsive">
                        <h4><label class="icon-number">3</label> Payment Method</h4>

                        <div class="col_full" style="border:1px solid #CCCCCC;padding:20px;">
                          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                              <div class="panel panel-default">
                                  <div class="panel-heading" role="tab" id="headingOne">
                                      <h4 class="panel-title">
                                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                              Bank Transfer
                                          </a>
                                      </h4>
                                  </div>

                                  <style media="screen">
                                    .bank-method{
                                      list-style-type:none;
                                      margin-bottom:0px;
                                    }

                                    .bank-method li:hover{
                                      background-color: #eee;
                                    }

                                    .bank-method li a{
                                      color: #000;
                                    }
                                  </style>

                                  <div id="collapseOne" class="panel-collapse in" role="tabpanel" aria-labelledby="headingOne">
                                      <div class="panel-body" style="border-top:none;padding-left:0px;padding-right:0px;">
                                          <ul class="bank-method">
                                            @if(count($banks) == 0)
                                              There's no enable bank account.
                                            @else
                                              @foreach($banks as $bank)
                                                <li style="padding:10px;">
                                                  <a href="javascript:void(0)" onclick="gotocheckout(1,{{ $bank->id }})">
                                                    <img src="{{ url($bank->bank_image) }}" class="img-responsive" width="100px;">
                                                    {{ $bank->bank_name }}
                                                  </a>
                                                </li>
                                              @endforeach
                                            @endif
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                              <div class="panel panel-default">
                                  <div class="panel-heading" role="tab" id="headingTwo">
                                      <h4 class="panel-title">
                                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="collapsed">
                                              Credit / Debit Card
                                          </a>
                                      </h4>
                                  </div>
                                  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                      <div class="panel-body" style="border-top:none;padding-left:0px;padding-right:0px;">
                                          <ul class="bank-method">
                                            @if(empty($midtrans->value))
                                              This method not ready yet.
                                            @else
                                            <li style="padding:10px;">
                                              <!-- <a href="javascript:void(0)" onclick="gotocheckout(2,1)"> -->
                                              <a href="javascript:void(0)">
                                                <img src="{{ url('assets/icon/midtrans.png') }}" class="img-responsive" width="100px;">
                                                <!-- MIDTRANS -->
                                                Under Maintenance
                                              </a>
                                            </li>
                                            @endif
                                          </ul>
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

</section><!-- #content end -->

<div id="addressmodal" class="modal fade" role="dialog" style="z-index:99999999;">
  <div class="modal-dialog modal-sm" style="margin-top:100px;">

    <!-- Modal content-->
    <div class="modal-content" style="border-radius:0px;">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Address</h4>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" name="title" placeholder="Title" required>
        <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
        <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
        <textarea name="address" rows="4" class="form-control" placeholder="Address" required></textarea>
        <select class="form-control" name="country" onchange="checkcountry()">
            <option value="" selected="" disabled="">Select Country</option>
        </select>

        <div id="indofield">
            <select class="form-control" name="province" onchange="shippingcity(1)">
                <option value="" selected="" disabled="">Select Province</option>
            </select>
            <select class="form-control" name="city" onchange="shippingdistrict(1)">
                <option value="" selected="" disabled="">Select City</option>
            </select>
            <select class="form-control" name="district">
                <option value="" selected="" disabled="">Select District</option>
            </select>
        </div>

        <input type="text" class="form-control" name="poscode" placeholder="Poscode" required>
        <input type="text" class="form-control" name="phone" placeholder="Phone" required>
      </div>
      <div class="modal-footer" style="border-top:none;">
        <button type="button" class="btn btn-default" onclick="insertnewaddress()" id="addnewaddress" style="border-radius:0px;background-color:#1ABC9C;border-color:#1ABC9C;">Add New</button>
      </div>
    </div>

  </div>
</div>

@push('js')

<script type="text/javascript">
    function addaddress(){
        $('#addressmodal').modal('show');
        shippingcountry();
        shippingprovince();
    }
</script>

<script type="text/javascript">
function checkcountry(){
    var country = $('[name=country]').val();
    var country_name = $('[name=country]  option:selected').attr('country');
    if (country == 0) {
        $('#indofield').html(   '<select class="form-control" name="province" onchange="shippingcity(1)">'+
                                    '<option value="" selected="" disabled="">Select Province</option>'+
                                '</select>'+
                                '<select class="form-control" name="city" onchange="shippingdistrict(1)">'+
                                    '<option value="" selected="" disabled="">Select City</option>'+
                                '</select>'+
                                '<select class="form-control" name="district">'+
                                    '<option value="" selected="" disabled="">Select District</option>'+
                                '</select>');
        shippingprovince();
    } else {
        $('#indofield').html(   '<select class="form-control hidden" name="province">'+
                                    '<option value="'+country_name+'" selected="" province="'+country_name+'">Select Province</option>'+
                                '</select>'+
                                '<select class="form-control hidden" name="city">'+
                                    '<option value="'+country_name+'" selected="" city="'+country_name+'">Select City</option>'+
                                '</select>'+
                                '<select class="form-control hidden" name="district">'+
                                    '<option value="'+country_name+'" selected="" district="'+country_name+'">Select District</option>'+
                                '</select>');
    }
}
</script>

<script type="text/javascript">
function shippingcountry(){
    var datapost = {
        "_token" : "{{ csrf_token() }}"
    }

    $.ajax({
        type : "POST",
        url : "{{ url('shipping/country') }}",
        data : datapost,
        beforeSend : function(){
            $('[name=country]').html('<option value="">Loading</option>');
        },
        success : function(data){
            $('[name=country]').html(data);
        }
    })
}
</script>

<script type="text/javascript">
function insertnewaddress(){
    var title       = $('[name=title]').val();
    var first_name  = $('[name=first_name]').val();
    var last_name   = $('[name=last_name]').val();
    var address     = $('[name=address]').val();
    var country     = $('[name=country]  option:selected').attr('country');
    var country_id  = $('[name=country]  option:selected').val();
    var province    = $('[name=province]  option:selected').attr('province');
    var city        = $('[name=city]  option:selected').attr('city');
    var district    = $('[name=district]  option:selected').attr('district');
    var district_id = $('[name=district]  option:selected').val();
    var poscode     = $('[name=poscode]').val();
    var phone       = $('[name=phone]').val();

    var valid_province    = $('[name=province]  option:selected').val();
    var valid_city        = $('[name=city]  option:selected').val();
    var valid_district    = $('[name=district]  option:selected').val();

    if (title == "" || first_name == "" || last_name == "" || address == "" || valid_province == "" || valid_city == "" || valid_district == "" || poscode == "" || phone == "") {
        // alert('Please select all shipping form');
        swal("Warning !", "Please fill all form", "warning");
    } else {

        var datapost = {
            "_token"    : "{{ csrf_token() }}",
            "title"     : title,
            "first_name": first_name,
            "last_name" : last_name,
            "address"   : address,
            "country_id": country_id,
            "country"   : country,
            "province"  : province,
            "city"      : city,
            "district"  : district,
            "district_id": district_id,
            "poscode"   : poscode,
            "phone"     : phone
        }

        $.ajax({
            type    : "POST",
            url     : "{{ url('user/ajax/insertaddress') }}",
            data    : datapost,
            beforeSend: function(){
                $('#addnewaddress').attr('onclick','false');
            },
            success: function(data){
                swal("Success !", "Success insert new address", "success");
                $('#body-address').html(data);
                $('#addnewaddress').attr('onclick','insertnewaddress()');
                $('#addressmodal').modal('hide');
                setTimeout(function(){
                   location.reload();
                 }, 3000);
            }
        })

    }
}
</script>

<script type="text/javascript">
    function getaddrcontent(){
        var addrid = $('[name=addressid]').val();
        var datapost = {
            "_token"    : "{{ csrf_token() }}",
            "addrid"    : addrid
        }

        $.ajax({
            type    : "POST",
            url     : "{{ url('cart/getaddr') }}",
            data    : datapost,
            beforeSend : function(data){
                $('#addr-content').html('Loading...');
            },
            success : function(data){
                $('#addr-content').html(data);
                shippingcost(1);
            }
        })
    }
</script>

<script type="text/javascript">

    shippingprovince();

    function checkvoucher(){
        var voucher_code = $('[name=voucher_code]').val();
        var datapost = {
            "_token"        : "{{ csrf_token() }}",
            "voucher_code"  : voucher_code
        }

        $.ajax({
            type    : "POST",
            url     : "{{ url('ajax/voucher') }}",
            data    : datapost,
            dataType: 'json',
            beforeSend : function(){
                $('#btn-voucher').html('Loading');
                $('#btn-voucher').attr('onclick','');
                $('#btn-voucher').attr('readonly',true);
            },
            success : function(data){
                if (data[0] == 0) {
                    swal("Error !", "Voucher Code Not Valid", "error");
                } else if (data[0] == 1) {
                    swal("Error !", "Voucher Code Expired", "error");
                } else if (data[0] == 2) {
                    swal("Error !", "Voucher Code Limited", "error");
                } else if (data[0] == 3) {
                    swal("Error !", "Voucher Code Limited", "error");
                } else if (data[0] == 4) {
                    $('#voucher-price').html(data[1]);
                    swal("Success !", "Success Add Voucher Code", "success");
                    localStorage.setItem('jsvouchervalue',data[2]);
                    localStorage.setItem('jsvouchertype',data[3]);
                    shippingcalculate();
                } else if (data[0] == 5) {
                    swal("Error !", "Voucher Code Not Valid", "error");
                }

                $('#btn-voucher').html('Apply Coupon');
                $('#btn-voucher').attr('onclick','checkvoucher()');
                $('#btn-voucher').attr('readonly','');
            }
        })
    }

    function shippingprovince(){
        var datapost = {
            "_token" : "{{ csrf_token() }}"
        }

        $.ajax({
            type : "POST",
            url : "{{ url('shipping/province') }}",
            data : datapost,
            beforeSend : function(){
                $('[name=province]').html('<option value="">Loading</option>');
                $('[name=city]').html('<option value="">Loading</option>');
                $('[name=district]').html('<option value="">Loading</option>');
                // $('[name=courier]').html('<option value="">Loading</option>');
                // $('[name=cost]').html('<option value="0">Loading</option>');
            },
            success : function(data){
                $('[name=province]').html(data);
                $('[name=city]').html('<option value="">Select City</option>');
                $('[name=district]').html('<option value="">Select District</option>');
                // $('[name=courier]').html('<option value="">Select</option>');
                // $('[name=cost]').html('<option value="0">Select</option>');

                var total_cart      = $('.top-checkout-price').text();
                $('#cart-subtotal').html(total_cart);
                $('#cart-total').html(total_cart);

                shippingcalculate();

                if ("{{ Session::get('city') }}") {
                    shippingcity(2);
                }
            }
        })
    }

    function shippingcity(trigger){
        var province = $('[name=province]').val();
        var datapost = {
            "_token"    : "{{ csrf_token() }}",
            "province"  : province,
            "trigger"   : trigger
        }

        $.ajax({
            type : "POST",
            url : "{{ url('shipping/city') }}",
            data : datapost,
            beforeSend : function(){
                $('[name=city]').html('<option value="">Loading</option>');
                $('[name=district]').html('<option value="">Loading</option>');
                // $('[name=courier]').html('<option value="">Loading</option>');
                // $('[name=cost]').html('<option value="0">Loading</option>');
            },
            success : function(data){
                $('[name=city]').html(data);
                $('[name=district]').html('<option value="">Select District</option>');
                // $('[name=courier]').html('<option value="false">Select Courier</option>');
                // $('[name=cost]').html('<option value="0">Select Cost</option>');

                shippingcalculate();

                if (trigger == 2) {
                    shippingdistrict(2);
                }
            }
        })
    }

    function shippingdistrict(trigger){
        var city = $('[name=city]').val();
        var datapost = {
            "_token"    : "{{ csrf_token() }}",
            "city"      : city,
            "trigger"   : trigger
        }

        $.ajax({
            type : "POST",
            url : "{{ url('shipping/district') }}",
            data : datapost,
            beforeSend : function(){
                $('[name=district]').html('<option value="">Loading</option>');
                // $('[name=courier]').html('<option value="">Loading</option>');
                // $('[name=cost]').html('<option value="0">Loading</option>');
            },
            success : function(data){
                $('[name=district]').html(data);
                // $('[name=courier]').html('<option value="false">Select Courier</option>');
                // $('[name=cost]').html('<option value="0">Select Cost</option>');

                shippingcalculate();

                if (trigger == 2) {
                    shippingcourier(2);
                }
            }
        })
    }

    function shippingcourier(trigger){
        var datapost = {
            "_token"    : "{{ csrf_token() }}",
            "trigger"   : trigger
        }

        $.ajax({
            type : "POST",
            url : "{{ url('shipping/courier') }}",
            data : datapost,
            beforeSend : function(){
                $('[name=courier]').html('<option value="">Loading</option>');
                $('[name=cost]').html('<option value="0">Loading</option>');
            },
            success : function(data){
                $('[name=courier]').html(data);
                $('[name=cost]').html('<option value="0">Select Cost</option>');

                shippingcalculate();

                if (trigger == 2) {
                    shippingcost(2);
                }
            }
        })
    }

    function shippingcost(trigger){
        // var district    = $('[name=district]').val();
        // var courier     = $('[name=courier]').val();
        var addressid = $('[name=addressid]').val();
        var datapost    = {
            "_token"    : "{{ csrf_token() }}",
            // "district"  : district,
            // "courier"   : courier,
            "addressid" : addressid,
            "trigger"   : trigger
        }

        $.ajax({
            type : "POST",
            url : "{{ url('shipping/cost') }}",
            data : datapost,
            beforeSend : function(){
                // $('[name=cost]').html('<option value="0">Loading</option>');
                $('.shipping-cour').html('Loading...');
            },
            success : function(data){
                // $('[name=cost]').html(data);
                $('.shipping-cour').html(data);

                if (trigger == 2) {
                    shippingcalculate();
                }
            }
        })
    }

    function shippingcalculate(){
        var total_cart      = $('.top-checkout-price').text().replace(/[^a-z0-9\s]/gi, '');
        // var shipping_cost   = $('[name=cost]').val();
        var shipping_cost   = $('[name=cost]:checked').val();
        var voucher_value   = localStorage.getItem('jsvouchervalue');
        var voucher_type    = localStorage.getItem('jsvouchertype');

        if (voucher_value == '' || voucher_value == null) {
            var voucher_cost = 0;
        } else {
            var voucher_cost = voucher_value;
        }

        if (voucher_type == '' || voucher_type == null) {
            var calculate   = parseInt(total_cart) + parseInt(shipping_cost);
        } else if (voucher_type == 1) {
            var calculate   = parseInt(total_cart) + parseInt(shipping_cost) - parseInt(voucher_cost);
        } else if (voucher_type == 2) {
            var discount    = parseInt(voucher_cost) * parseInt(total_cart) / 100;
            var calculate   = parseInt(total_cart) + parseInt(shipping_cost) - parseInt(discount);
        } else if (voucher_type == 3) {
            // var discount    = parseInt(shipping_cost);
            // var calculate   = parseInt(total_cart) + parseInt(shipping_cost) - parseInt(discount);
        }

        $('#shipping-price').html(shipping_cost.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
        $('#cart-total').html(calculate.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
    }

    function getquantity(rowId,trigger){
        var qty = $('#'+rowId).find('[name=quantity]').val();
        if (trigger == 'minus') {
            if (qty == 1) {
                removerow(rowId);
            } else {
                var count = parseInt(qty) - 1;
                $('#'+rowId).find('[name=quantity]').val(count);
                updaterow(rowId,qty);
            }
        } else if(trigger == 'plus') {
            var count = parseInt(qty) + 1;
            $('#'+rowId).find('[name=quantity]').val(count);
            updaterow(rowId,qty);
        }
    }

    function removerow(rowId){
        if (confirm('Are you sure ?')) {
            var datapost = {
                "_token": "{{ csrf_token() }}",
                "rowId" : rowId
            }

            $.ajax({
                type    : "POST",
                url     : "{{ url('ajax/removerow') }}",
                data    : datapost,
                dataType: "json",
                beforeSend : function(){

                },
                success : function(data){
                    $('#cartbody').html(data[2]);
                    $('.cart-count').html(data[1]);
                    $(".top-cart-items").html(data[3]);
                    $(".top-cart-action").html(data[4]);
                    $('#cart-subtotal').html($('.top-checkout-price').text());
                    $('#cart-total').html($('.top-checkout-price').text());
                    shippingcalculate();
                }
            })
        }
    }

    function removevoc(){
        var datapost = {
            "_token": "{{ csrf_token() }}"
        }

        $.ajax({
            type    : "POST",
            url     : "{{ url('voucher/remove') }}",
            data    : datapost,
            beforeSend : function(){

            },
            success : function(data){
                if(data == 1){
                    localStorage.removeItem('jsvouchervalue');
                    localStorage.removeItem('jsvouchertype');
                    location.reload();
                }
            }
        })
    }

    function updaterow(rowId,qtystart){
        var qty = $('#'+rowId).find('[name=quantity]').val();
        var datapost = {
            "_token": "{{ csrf_token() }}",
            "rowId" : rowId,
            "qty"   : qty
        }

        $.ajax({
            type    : "POST",
            url     : "{{ url('ajax/updaterow') }}",
            data    : datapost,
            dataType: "json",
            beforeSend : function(){

            },
            success : function(data){
                if (data[0] == 0) {
                    swal("Error !", "Stock Not Available", "error");
                    $('#'+rowId).find('[name=quantity]').val(qtystart);
                }else {
                    $('#'+rowId).html(data[2]);
                    $('.cart-count').html(data[1]);
                    $(".top-cart-items").html(data[3]);
                    $(".top-cart-action").html(data[4]);
                    $('#cart-subtotal').html($('.top-checkout-price').text());
                    $('#cart-total').html($('.top-checkout-price').text());
                    shippingcalculate();
                }
            }
        })
    }

</script>

<script type="text/javascript">
    function gotocheckout(paymethod,paybank){

        // var province    = $('[name=province]  option:selected').attr('province');
        // var city        = $('[name=city]  option:selected').attr('city');
        // var postalcode  = $('[name=city]  option:selected').attr('postalcode');
        // var district    = $('[name=district]  option:selected').attr('district');
        // var courier     = $('[name=courier]').val();
        var addressid   = $('[name=addressid]').val();
        var cost        = $('[name=cost]:checked').val();
        var idlabel     = $('[name=cost]:checked').attr('id');
        var services    = $('[for='+idlabel+']').text().replace(/ /g,'').replace(/\d+/g, '').replace('-','').replace('.','');
        var subtotal    = $('#cart-subtotal').text().replace(/[^a-z0-9\s]/gi, '');
        var total       = $('#cart-total').text().replace(/[^a-z0-9\s]/gi, '');
        var count       = '{{ Cart::count() }}';

        if (count == 0) {
            // alert('There`s no item in cart');
            swal("Warning !", "There`s no item in cart", "warning");
        } else {
            // if (cost == "false" || cost == null || cost == "" || cost == 0) {
            if (cost == "false" || cost == null || cost == "") {
                // alert('Please select all shipping form');
                swal("Warning !", "Please select shipping courier", "warning");
            } else {

                var datapost = {
                    "_token"    : "{{ csrf_token() }}",
                    // "province"  : province,
                    // "city"      : city,
                    // "postalcode": postalcode,
                    // "district"  : district,
                    // "courier"   : courier,
                    "paymethod" : paymethod,
                    "paybank"   : paybank,
                    "addressid" : addressid,
                    "cost"      : cost,
                    "subtotal"  : subtotal,
                    "total"     : total,
                    "services"  : services
                }

                $.ajax({
                    type    : "POST",
                    url     : "{{ url('shipping/gotocheckout') }}",
                    data    : datapost,
                    beforeSend: function(){
                        $('#btn-checkout').attr('onclick','false');
                    },
                    success: function(data){
                        if (data == 1) {
                            window.location.href = "{{ url('checkout') }}";
                        } else if (data == 2) {
                            swal("Error !", "Voucher Not Available For Shipping International", "error");
                            $('#btn-checkout').attr('onclick','gotocheckout()');
                        } else {
                            $('#btn-checkout').attr('onclick','gotocheckout()');
                        }
                    }
                })

            }
        }

    }
</script>
@endpush

@endsection
