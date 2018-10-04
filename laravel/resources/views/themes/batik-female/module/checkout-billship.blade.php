
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style media="screen">
.choosepay{
    display: table;
}

.choosepay a{
    display: table-cell;
    vertical-align: middle;
}

.choosepay:hover{
    background-color: #00BED7;
}

.choosepay:hover a{
    color: #fff;
}
</style>

<?php if(!Session::get('memberid')){ ?>
    <div class="col-sm-12">
        <a href="{{ url('user/login')}}?redirect={{url('checkout')}}"><h4>Already have an account ? <u>Login</u></h4></a>
        <hr>
    </div>
<?php } ?>

<form id="form-submit" name="billing-form" class="nobottommargin" action="{{ url('checkout') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="col-md-6">
        <h3>Billing Address</h3>

        @if(Session::has('orderid1'))
            <?php
                $getorder = DB::table('sum_orders')->where('order_id',Session::get('orderid1'))->first();
            ?>
        @endif

        <div class="col_full">
            <label for="billing-form-name">Name:</label>
            <input type="text" id="billing-form-name" name="billing_name" value="<?php

            if(!empty(old('billing_name'))){
                echo old('billing_name');
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
            <textarea class="sm-form-control" id="shipping-form-message" name="billing_address" rows="6" cols="30"><?php

            if(!empty(old('billing_address'))){
                echo old('billing_address');
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
            <label for="billing-form-email">Email Address:</label>
            <input type="email" id="billing-form-email" name="billing_email" value="<?php

            if(!empty(old('billing_email'))){
                echo old('billing_email');
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
            <label for="billing-form-phone">Phone:</label>
            <input type="text" id="billing-form-phone" name="billing_phone" value="<?php

            if(!empty(old('billing_phone'))){
                echo old('billing_phone');
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

    <div class="col-md-6">
        <h3 style="width:50%;">Shipping Address</h3>

        <div class="col_full">
            <label for="shipping-form-name">Name:</label>
            <input type="text" id="shipping-form-name" name="shipping_name" value="<?php

            if(!empty(old('shipping_name'))){
                echo old('shipping_name');
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
            <textarea class="sm-form-control" id="shipping-form-message" name="shipping_address" rows="6" cols="30"><?php

            if(!empty(old('shipping_address'))){
                echo old('shipping_address');
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
            <label for="billing-form-email">Email Address:</label>
            <input type="email" id="billing-form-email" name="shipping_email" value="<?php

            if(!empty(old('shipping_email'))){
                echo old('shipping_email');
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
            <label for="billing-form-phone">Phone:</label>
            <input type="text" id="billing-form-phone" name="shipping_phone" value="<?php

            if(!empty(old('shipping_phone'))){
                echo old('shipping_phone');
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

        <div class="col_full">
            <input type="checkbox" name="samebill" value="" onclick="getbill()"> Same With Billing
        </div>

        <input type="hidden" name="payment_service" value="{{ old('payment_service') }}">

    </div>
</form>

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
                            <a href="{{ url('products/'.$detail->prod_url) }}">{{ $detail->prod_name }}</a>
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
                            <a href="{{ url('products/'.$cart->options['url']) }}">{{ $cart->name }}</a>
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
                        <strong>Total</strong>
                    </td>

                    <td class="cart-product-name">
                        <span class="amount color lead">
                            <strong>
                                <?php
                                    if(Session::has('orderid1')){
                                        echo number_format($getorder->order_total,0,',','.');
                                    }else{
                                        echo number_format(Session::get('total'),0,',','.');
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
    <div class="col-md-12" style="margin-top:70px;text-align:center;padding:0px;">
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
    </div>

    <div class="col-sm-offset-3 col-sm-6" style="margin-top:30px;text-align:center;">
        <a href="javascript:void(0)" class="btn btn-success" style="border-radius:0px;" onclick="submitcheckout()">Pay Now</a>
    </div>
</div>

<form id="payment-form" method="post" action="{{ url('snapfinish') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="result_type" id="result-type" value=""></div>
    <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

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
        $(this).css('background-color','#00BED7');
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
        $('#form-submit').submit();
    }
</script>

@if(Session::has('error_stock'))
<script type="text/javascript">
    swal("Stock Error !", "{{ Session::get('error_stock') }} Stock not available", "error");
</script>
@endif

@if(Session::has('validate'))

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<CLIENT-KEY>"></script>

    <script type="text/javascript">
        function getsnap(){
            $.ajax({
                url: "{{ url('snaptoken') }}",
                cache: false,
                success: function(data) {
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

    <script type="text/javascript">
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
    </script>
@endif
