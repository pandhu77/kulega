@extends('web.master')
@section('title','Sonia')
@section('content')

@push('css')
<style media="screen">
    .choosepay{
        display: table;
    }

    .choosepay a{
        display: table-cell;
        vertical-align: middle;
    }

    .choosepay:hover{
        background-color: #D19E9A;
    }

    .choosepay:hover a{
        color: #fff;
    }

    .col_full{
        margin-bottom:20px;
    }
</style>
@endpush

<!-- BEGIN PRODUCTS -->
<section id="main-products">
  <div class="container">
    <div class="row section-title text-center">
      <div class="col-md-12">
        <h3>CHECKOUT</h3>
      </div>
    </div>
  </div>
</section>
<!-- ./END PRODUCTS -->

<section id="content">
    <div class="content-wrap" style="padding-top:0px;">
        <div class="container clearfix">

            <?php if(!Session::get('memberid')){ ?>
    <div class="col-sm-12">
        <a href="{{ url('user/login')}}?redirect={{url('checkout')}}"><h4>Already have an account ? <u>Login</u></h4></a>
        <hr>
    </div>
<?php } ?>

<form id="form-submit" name="billing-form" class="nobottommargin" action="{{ url('checkout') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="col-md-6 hidden">
        <h3>Billing Address</h3>

        @if(Session::has('orderid1'))
            <?php
                $getorder = DB::table('sum_orders')->where('order_id',Session::get('orderid1'))->first();
            ?>
        @endif

        <div class="col_full">
            <label for="billing-form-name">Name</label>
            <input type="text" readonly id="billing-form-name" name="billing_name" value="<?php

            if(Session::has('billing_name')){
                echo Session::get('billing_name');
            }else{
                if(Session::get('memberid')){
                    echo $member->member_fullname;
                }elseif(Session::has('orderid1')){
                    echo $getorder->billing_name;
                }
            }

            ?>" class="sm-form-control" />
            @if($errors->has('billing_name'))
                <label class="control-label" for="inputError" style="color:red;">
                    <i class="fa fa-times-circle-o"></i>
                    {{ $errors->first('billing_name') }}
                </label>
            @endif
        </div>

        <div class="col_full">
            <label for="shipping-form-message">Address</label>
            <textarea readonly class="sm-form-control" id="shipping-form-message" name="billing_address" rows="6" cols="30"><?php

            if(Session::has('billing_address')){
                echo Session::get('billing_address');
            }else{
                if(Session::get('memberid')){
                    echo $member->member_address;
                }elseif(Session::has('orderid1')){
                    echo $getorder->billing_address;
                }
            }

            ?></textarea>
            @if($errors->has('billing_address'))
                <label class="control-label" for="inputError" style="color:red;">
                    <i class="fa fa-times-circle-o"></i>
                    {{ $errors->first('billing_address') }}
                </label>
            @endif
        </div>

        <div class="col_half">
            <label for="billing-form-email">Email Address</label>
            <input type="email" readonly id="billing-form-email" name="billing_email" value="<?php

            if(Session::has('billing_email')){
                echo Session::get('billing_email');
            }else{
                if(Session::get('memberid')){
                    echo $member->member_email;
                }elseif(Session::has('orderid1')){
                    echo $getorder->billing_email;
                }
            }

            ?>" class="sm-form-control" />
            @if($errors->has('billing_email'))
                <label class="control-label" for="inputError" style="color:red;">
                    <i class="fa fa-times-circle-o"></i>
                    {{ $errors->first('billing_email') }}
                </label>
            @endif
        </div>

        <div class="col_half col_last">
            <label for="billing-form-phone">Phone</label>
            <input type="text" readonly id="billing-form-phone" name="billing_phone" value="<?php

            if(Session::has('billing_phone')){
                echo Session::get('billing_phone');
            }else{
                if(Session::get('memberid')){
                    echo $member->member_phone;
                }elseif(Session::has('orderid1')){
                    echo $getorder->billing_phone;
                }
            }

            ?>" class="sm-form-control" />
            @if($errors->has('billing_phone'))
                <label class="control-label" for="inputError" style="color:red;">
                    <i class="fa fa-times-circle-o"></i>
                    {{ $errors->first('billing_phone') }}
                </label>
            @endif
        </div>
    </div>

    <div class="col-md-6 hidden">
        <h3 style="width:50%;">Shipping Address</h3>

        <div class="col_full">
            <label for="shipping-form-name">Name</label>
            <input type="text" readonly id="shipping-form-name" name="shipping_name" value="<?php

            if(Session::has('shipping_name')){
                echo Session::get('shipping_name');
            }else{
                if(Session::has('orderid1')){
                    echo $getorder->customer_name;
                }
            }

            ?>" class="sm-form-control" />
            @if($errors->has('shipping_name'))
                <label class="control-label" for="inputError" style="color:red;">
                    <i class="fa fa-times-circle-o"></i>
                    {{ $errors->first('shipping_name') }}
                </label>
            @endif
        </div>

        <div class="col_full">
            <label for="shipping-form-message">Address</label>
            <textarea readonly class="sm-form-control" id="shipping-form-message" name="shipping_address" rows="6" cols="30"><?php

            if(Session::has('shipping_address')){
                echo Session::get('shipping_address');
            }else{
                if(Session::has('orderid1')){
                    echo $getorder->customer_address;
                }
            }

            ?></textarea>
            @if($errors->has('shipping_address'))
                <label class="control-label" for="inputError" style="color:red;">
                    <i class="fa fa-times-circle-o"></i>
                    {{ $errors->first('shipping_address') }}
                </label>
            @endif
        </div>

        <div class="col_half">
            <label for="billing-form-email">Email Address</label>
            <input type="email" readonly id="billing-form-email" name="shipping_email" value="<?php

            if(Session::has('shipping_email')){
                echo Session::get('shipping_email');
            }else{
                if(Session::has('orderid1')){
                    echo $getorder->customer_email;
                }
            }

            ?>" class="sm-form-control" />
            @if($errors->has('shipping_email'))
                <label class="control-label" for="inputError" style="color:red;">
                    <i class="fa fa-times-circle-o"></i>
                    {{ $errors->first('shipping_email') }}
                </label>
            @endif
        </div>

        <div class="col_half col_last">
            <label for="billing-form-phone">Phone</label>
            <input type="text" readonly id="billing-form-phone" name="shipping_phone" value="<?php

            if(Session::has('shipping_phone')){
                echo Session::get('shipping_phone');
            }else{
                if(Session::has('orderid1')){
                    echo $getorder->customer_phone;
                }
            }

            ?>" class="sm-form-control" />
            @if($errors->has('shipping_phone'))
                <label class="control-label" for="inputError" style="color:red;">
                    <i class="fa fa-times-circle-o"></i>
                    {{ $errors->first('shipping_phone') }}
                </label>
            @endif
        </div>

        <input type="hidden" name="payment_service" value="1">

    </div>
</form>

<div class="clearfix"></div>
<hr>

<div class="col-md-6 hidden">
    <h3 style="width:50%;">Shipping Information</h3>

    <div class="col_full">
        <label for="shipping-form-name">Province</label>
        <input type="text" readonly id="shipping-form-name" value="{{ Session::get('province') }}" class="sm-form-control" />
    </div>

    <div class="col_full">
        <label for="shipping-form-message">City</label>
        <input type="text" readonly id="shipping-form-name" value="{{ Session::get('city') }}" class="sm-form-control" />
    </div>

    <div class="col_full">
        <label for="billing-form-email">District</label>
        <input type="text" readonly id="billing-form-email" value="{{ Session::get('district') }}" class="sm-form-control" />
    </div>
</div>

<div class="col-md-6">
    <h3 style="width:50%;">Payment Information</h3>

    <div class="col_full">
        <label for="shipping-form-name">Payment Method</label>
        <input type="text" readonly id="shipping-form-name" value="<?php if(Session::get('paymethod') == 1){echo "Bank Transfer";}else{echo "Credit / Debit Card";} ?>" class="sm-form-control" />
    </div>

    @if(Session::get('paymethod') == 1)
    <div class="col_full">
        <label for="shipping-form-name">Bank Name</label>
        <input type="text" readonly id="shipping-form-name" value="{{ $bank->bank_name }}" class="sm-form-control" />
    </div>
    @endif


</div>

<div class="col-md-6">
    <h3 style="width:50%;">Courier Information</h3>

    <div class="col_full">
        <label for="shipping-form-name">Courier</label>
        <input type="text" readonly id="shipping-form-name" value="<?php
            if(Session::has('orderid1')){
                echo $getorder->shipping_courier;
            }else{
                echo Session::get('courier');
            }
        ?>" class="sm-form-control" />
    </div>

</div>

<div class="clearfix"></div>
<hr>

<div class="clear bottommargin"></div>
<div class="col-md-6">
    <div class="table-responsive clearfix">
        <h4>Your Orders</h4>

        <table class="table cart">
            <thead>
                <tr>
                    <th class="cart-product-thumbnail">&nbsp;</th>
                    <th class="cart-product-name">Product</th>
                    <th class="cart-product-quantity">Quantity</th>
                    <th class="cart-product-subtotal">Total</th>
                </tr>
            </thead>
            <tbody>

                @if(Session::has('orderid1'))
                    <?php
                        $getdetail= DB::table('tmp_order_detail')
                                    ->leftJoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                                    ->where('tmp_order_detail.order_id',Session::get('orderid1'))
                                    ->get();
                    ?>

                    @foreach($getdetail as $detail)
                    <tr class="cart_item">
                        <td class="cart-product-thumbnail">
                            <a href="{{ url('products/'.$detail->prod_url) }}">
                                <img width="64" height="64" src="{{ asset($detail->front_image) }}" alt="{{ $detail->prod_name }}">
                            </a>
                        </td>

                        <td class="cart-product-name">
                            <a href="{{ url('products/'.$detail->prod_url) }}">{{ $detail->prod_name }}</a><br>
                            {{ $detail->prod_color }}<br>
                            {{ $detail->prod_size }}
                        </td>

                        <td class="cart-product-quantity">
                            <div class="quantity clearfix">
                                {{ $detail->detail_qty }}
                            </div>
                        </td>

                        <td class="cart-product-subtotal">
                            <span class="amount"><?= number_format($detail->detail_subtotal,0,',','.') ?></span>
                        </td>
                    </tr>
                    @endforeach
                @else
                    @foreach($carts as $cart)
                    <tr class="cart_item">
                        <td class="cart-product-thumbnail">
                            <a href="{{ url('products/'.$cart->options['url']) }}"><img width="64" height="64" src="{{ asset($cart->options['image']) }}" alt="{{ $cart->name }}"></a>
                        </td>

                        <td class="cart-product-name">
                            <a href="{{ url('products/'.$cart->options['url']) }}">{{ $cart->name }}</a><br>
                            {{ $cart->options['color'] }}<br>
                            {{ $cart->options['size'] }}
                        </td>

                        <td class="cart-product-quantity">
                            <div class="quantity clearfix">
                                {{ $cart->qty }}
                            </div>
                        </td>

                        <td class="cart-product-subtotal">
                            <span class="amount"><?= number_format($cart->qty*$cart->price,0,',','.') ?></span>
                        </td>
                    </tr>
                    @endforeach
                @endif

            </tbody>

        </table>

    </div>
</div>
<div class="col-md-6">
    <div class="table-responsive">
        <h4>Cart Totals</h4>

        <table class="table cart">
            <tbody>
                <tr class="cart_item">
                    <td class="notopborder cart-product-name">
                        <strong>Cart Subtotal</strong>
                    </td>

                    <td class="notopborder cart-product-name">
                        <span class="amount">
                            <?php
                                if(Session::has('orderid1')){
                                    echo number_format($getorder->sub_total,0,',','.');
                                }else{
                                    echo number_format(Session::get('subtotal'),0,',','.');
                                }
                            ?>
                        </span>
                    </td>
                </tr>
                <tr class="cart_item">
                    <td class="cart-product-name">
                        <strong>Shipping</strong>
                    </td>

                    <td class="cart-product-name">
                        <span class="amount">
                            <?php
                                if(Session::has('orderid1')){
                                    echo number_format($getorder->shipping_cost,0,',','.');
                                }else{
                                    echo number_format(Session::get('cost'),0,',','.');
                                }
                            ?>
                        </span>
                    </td>
                </tr>
                <tr class="cart_item">
                    <td class="cart-product-name">
                        <strong>Voucher(-)</strong>
                    </td>

                    <td class="cart-product-name">
                        <span class="amount">
                            <?php
                                if(Session::has('orderid1') && Session::has('voucher_code')){
                                    $getvoucher = DB::table('ms_voucher')->where('voucher_code',$getorder->voucher_code)->first();
                                    if($getvoucher->voucher_type == 3){
                                        echo "Free Shipping";
                                    } else {
                                        echo number_format($getorder->shipping_cost,0,',','.');
                                        if ($getvoucher->voucher_type == 2) {
                                            echo "%";
                                        }
                                    }
                                }else{
                                    if(Session::get('voucher_type') == 3){
                                        echo number_format(Session::get('voucher_value'),0,',','.');
                                    } else {
                                        echo number_format(Session::get('voucher_value'),0,',','.');
                                        if(Session::get('voucher_type') == 2){
                                            echo "%";
                                        }
                                    }
                                }
                            ?>
                        </span>
                    </td>
                </tr>
                <?php if(Session::has('charge')){ ?>
                  <tr class="cart_item">
                      <td class="cart-product-name">
                          <strong>CC Charge(+3%)</strong>
                      </td>

                      <td class="cart-product-name">
                          <span class="amount">
                              <?php
                              if(Session::has('orderid1')){
                                  echo number_format($getorder->disc_reward,0,',','.');
                              }else{
                                  echo number_format(Session::get('charge'),0,',','.');
                              }
                              ?>
                          </span>
                      </td>
                  </tr>
                <?php } ?>
                <tr class="cart_item">
                    <td class="cart-product-name">
                        <strong>Payment Code</strong>
                    </td>

                    <td class="cart-product-name">
                        <span class="amount">
                            <?php
                            if(Session::has('orderid1')){
                                echo number_format($getorder->payment_code,0,',','.');
                            }else{
                                echo number_format(Session::get('paycode'),0,',','.');
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
                        <span class="amount color lead" style="color:#1ABC9C !important;">
                            <strong>
                                <?php
                                    if(Session::has('orderid1')){
                                        echo number_format($getorder->order_total,0,',','.');
                                    }else{
                                        if (Session::has('voucher_type')) {
                                            if (Session::get('voucher_type') == 3) {
                                                echo number_format(Session::get('total')+Session::get('paycode'),0,',','.');
                                            } else {
                                                echo number_format(Session::get('total')+Session::get('paycode'),0,',','.');
                                            }
                                        }else {
                                            echo number_format(Session::get('total')+Session::get('paycode'),0,',','.');
                                        }
                                    }
                                ?>
                            </strong>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- <div class="accordion clearfix">
        <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Direct Bank Transfer</div>
        <div class="acc_content clearfix">Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</div>

        <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Payment Gateway</div>
        <div class="acc_content clearfix">Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum.</div>
    </div>
    <a href="javascript:void(0)" class="button button-3d fright" onclick="submitcheckout()">Place Order</a> -->
</div>

<div class="container">
    <!-- <div class="col-md-12" style="margin-top:70px;text-align:center;padding:0px;">
        <h4 style="margin-bottom:0px;">MAKE A PAYMENT</h4>
        <p style="width:100%;">Choose your payment method</p>
        <div class="col-sm-offset-3 col-sm-3 col-xs-6 choosepay" style="border:1px solid #eee;">
            <a href="javascript:void(0)"><i class="fa fa-university fa-4x" aria-hidden="true"></i><br><br>Bank Transfer</a>
        </div>
        <div class="col-sm-3 col-xs-6 choosepay" style="border:1px solid #eee;">
            <a href="javascript:void(0)"><i class="fa fa-cc fa-4x" aria-hidden="true"></i><br><br>Credit Card</a>
        </div>
    </div>

    <div class="col-md-12" style="text-align:center;">
        @if($errors->has('payment_service'))
            <label class="control-label" for="inputError" style="color:red;">
                <i class="fa fa-times-circle-o"></i>
                {{ $errors->first('payment_service') }}
            </label>
        @endif
    </div> -->

    <div class="col-sm-offset-3 col-sm-6" style="margin-top:30px;text-align:center;">
        @if(!Session::has('orderid1'))
            <a href="javascript:void(0)" class="btn btn-success" style="border-radius:0px;background-color:#000;border-color:#000;" onclick="submitcheckout()" id="orderbtn">PLACE ORDER</a>
        @else
            <a href="javascript:void(0)" class="btn btn-success" style="border-radius:0px;background-color:#000;border-color:#000;" onclick="getsnap()" id="paybtn">PAY NOW</a>
        @endif
    </div>
</div>

<form id="payment-form" method="post" action="{{ url('snapfinish') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="result_type" id="result-type" value=""></div>
    <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

        </div>
    </div>
</section><!-- #content end -->

@push('js')

<script type="text/javascript">
    function getbill(){
        if ($('[name=samebill]').is(':checked')) {
            $('[name=shipping_name]').val($('[name=billing_name]').val());
            $('[name=shipping_address]').val($('[name=billing_address]').val());
            $('[name=shipping_email]').val($('[name=billing_email]').val());
            $('[name=shipping_phone]').val($('[name=billing_phone]').val());

            $('[name=shipping_name]').attr('readonly',true);
            $('[name=shipping_address]').attr('readonly',true);
            $('[name=shipping_email]').attr('readonly',true);
            $('[name=shipping_phone]').attr('readonly',true);
        }else {
            $('[name=shipping_name]').val('');
            $('[name=shipping_address]').val('');
            $('[name=shipping_email]').val('');
            $('[name=shipping_phone]').val('');

            $('[name=shipping_name]').attr('readonly',false);
            $('[name=shipping_address]').attr('readonly',false);
            $('[name=shipping_email]').attr('readonly',false);
            $('[name=shipping_phone]').attr('readonly',false);
        }
    }
</script>

<script type="text/javascript">
    getheight();

    function getheight(){
        var w_choose = $('.choosepay').width();
        $('.choosepay').height(w_choose);
    }
</script>

<script type="text/javascript">
    $('.choosepay').on('click',function(){
        $('.choosepay').css('background-color','');
        $('.choosepay').find('a').css('color','');
        $('.choosepay').removeClass('active');
        $(this).css('background-color','#D19E9A');
        $(this).find('a').css('color','#fff');
        $(this).addClass('active');

        if ($(this).find('a').text() == 'Bank Transfer') {
            $('[name=payment_service]').val(1);
        }else {
            $('[name=payment_service]').val(2);
        }
    });
</script>

<script type="text/javascript">
    function submitcheckout(){
        $('#orderbtn').attr('onclick','');
        $('#orderbtn').html('Loading');
        $('#form-submit').submit();
    }
</script>

@if(Session::has('error_stock'))
<script type="text/javascript">
    swal("Stock Error !", "{{ Session::get('error_stock') }} Stock not available", "error");
</script>
@endif

@if(Session::has('error_voucher'))
<script type="text/javascript">
    swal("Voucher Error !", "Voucher {{ Session::get('error_voucher') }} not valid", "error");
</script>
@endif

@if(Session::has('voucher_code'))
    @if(Session::get('voucher_type') == 3)
        <script type="text/javascript">
            swal("Congratulation !", "You Got Promotion", "success");
        </script>
    @endif
@endif

@if(Session::has('orderid1'))
    <script type="text/javascript">
        $(document).ready(function(){
            getsnap();
        });
    </script>

    <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="<CLIENT-KEY>"></script>

    <script type="text/javascript">
        function getsnap(){
            $.ajax({
                url: "{{ url('snaptoken') }}",
                cache: false,
                beforeSend: function(){
                    $('.loading').fadeIn('slow');
                },
                success: function(data) {
                    $('.loading').fadeOut('slow');
                    //location = data;
                    console.log('token = '+data);

                    var resultType = document.getElementById('result-type');
                    var resultData = document.getElementById('result-data');
                    function changeResult(type,data){
                        $("#result-type").val(type);
                        $("#result-data").val(JSON.stringify(data));
                        //resultType.innerHTML = type;
                        //resultData.innerHTML = JSON.stringify(data);
                    }
                    snap.pay(data, {

                        onSuccess: function(result){
                            changeResult('success', result);
                            console.log(result.status_message);
                            console.log(result);
                            $("#payment-form").submit();
                        },
                        onPending: function(result){
                            changeResult('pending', result);
                            console.log(result.status_message);
                            $("#payment-form").submit();
                        },
                        onError: function(result){
                            changeResult('error', result);
                            console.log(result.status_message);
                            $("#payment-form").submit();
                        }
                    });
                }
            });
        }
    </script>
@endif

<!-- @if(Session::has('validate')) -->

    <!-- <script type="text/javascript">
        if($('[name=payment_service]').val() == 1){
            $('.choosepay').first().click();
        }else {
            $('.choosepay').last().click();
        }
    </script>

    <script type="text/javascript">
        var paymentmethod = $('[name=payment_service]').val();
        if (paymentmethod == 1) {
            location.href = "{{ url('user/order/payment-confirmation/') }}/{{ Session::get('orderid1') }}";
        }else {
            getsnap();
        }
    </script> -->
<!-- @endif -->
@endpush

@endsection
