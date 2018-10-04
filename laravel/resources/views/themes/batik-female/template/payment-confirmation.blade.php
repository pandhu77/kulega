@extends('web.app')
@section('content')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<style media="screen">
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        border-top:transparent !important;
    }

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

<?php $website = DB::table('cms_config')->first(); ?>
<title>Payment Confirm | {{ $website->site_name }}</title>

<!-- Page Title
============================================= -->
<!-- <section id="page-title">

    <div class="container clearfix">
        <h1>Payment Confirm</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="active">Payment Confirm</li>
        </ol>
    </div>

</section> -->

<!-- Content
============================================= -->
<?php $getsetting = DB::table('t_theme_setting')->where('active',1)->first(); ?>

<section id="content">

    <div class="content-wrap" style="padding-top:40px;">

        <div class="container clearfix">

            <h3 style="text-align:center;margin-bottom:40px;">Your <span class="color">Order</span></h3>
            <hr>

            <div class="col-md-4">
                <h4>BILLING ADDRESS</h4>
                <table class="table">
                    <tbody>
                        <tr>
                            <td style="width:90px;">Name</td>
                            <td>:</td>
                            <td>{{ $order->billing_name }}</td>
                        </tr>
                        <tr>
                            <td style="width:90px;">Email</td>
                            <td>:</td>
                            <td>{{ $order->billing_email }}</td>
                        </tr>
                        <tr>
                            <td style="width:90px;">Phone</td>
                            <td>:</td>
                            <td>{{ $order->billing_phone }}</td>
                        </tr>
                        <tr>
                            <td style="width:90px;">Address</td>
                            <td>:</td>
                            <td>{{ $order->billing_address }}</td>
                        </tr>
                        <tr>
                            <td style="width:90px;">Poscode</td>
                            <td>:</td>
                            <td>{{ $order->billing_poscode }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <h4>SHIPPING ADDRESS</h4>
                <table class="table">
                    <tbody>
                        <tr>
                            <td style="width:90px;">Name</td>
                            <td>:</td>
                            <td>{{ $order->customer_name }}</td>
                        </tr>
                        <tr>
                            <td style="width:90px;">Email</td>
                            <td>:</td>
                            <td>{{ $order->customer_email }}</td>
                        </tr>
                        <tr>
                            <td style="width:90px;">Phone</td>
                            <td>:</td>
                            <td>{{ $order->customer_phone }}</td>
                        </tr>
                        <tr>
                            <td style="width:90px;">Address</td>
                            <td>:</td>
                            <td>{{ $order->customer_address }}</td>
                        </tr>
                        <tr>
                            <td style="width:90px;">Poscode</td>
                            <td>:</td>
                            <td>{{ $order->order_poscode }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <h4>ORDER</h4>
                <table class="table">
                    <tbody>
                        <tr>
                            <td style="width:120px;">Order Status</td>
                            <td>:</td>
                            <td>
                                <?php
                                    if ($order->payment_status == 0) {
                                        echo '<span class="label label-primary">Waiting</span>';
                                    } elseif($order->payment_status == 1) {
                                        echo '<span class="label label-warning">Waiting Confirm</span>';
                                    } elseif($order->payment_status == 2) {
                                        echo '<span class="label label-success">Completed</span>';
                                    } elseif($order->payment_status == 3) {
                                        echo '<span class="label label-danger">Cancelled</span>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:120px;">Order Date</td>
                            <td>:</td>
                            <td><?= date("d/M/Y H:i:s",strtotime($order->order_date)) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-12" style="margin-top:20px;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderdetail as $details)
                            <tr>
                                <td><?= $details->prod_name ?></td>
                                <td><?= number_format($details->prod_price,0,',','.') ?></td>
                                <td><?= $details->detail_qty ?></td>
                                <td style="text-align:right;"><?= number_format($details->detail_subtotal,0,',','.') ?></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" style="text-align:right;">Total</td>
                            <td style="text-align:right;"><?= number_format($order->sub_total,0,',','.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right;">Shipping Cost</td>
                            <td style="text-align:right;"><?= number_format($order->shipping_cost,0,',','.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right;"><strong>Grand Total</strong></td>
                            <td style="text-align:right;"><strong><?= number_format($order->order_total,0,',','.') ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($order->payment_status == 0)
            <div class="col-md-12" style="margin-top:70px;text-align:center;padding:0px;">
                <h4 style="margin-bottom:0px;">MAKE A PAYMENT</h4>
                <p style="width:100%;">Choose your payment method</p>
                <div class="col-sm-offset-3 col-sm-3 col-xs-6 choosepay" id="banktrans" style="border:1px solid #eee;">
                    <a href="javascript:void(0)" onclick="getpayinfo()"><i class="fa fa-university fa-4x" aria-hidden="true"></i><br><br>Bank Transfer</a>
                </div>
                <div class="col-sm-3 col-xs-6 choosepay" style="border:1px solid #eee;" onclick="getsnap()">
                    <a href="javascript:void(0)"><i class="fa fa-cc fa-4x" aria-hidden="true"></i><br><br>Credit Card</a>
                </div>
            </div>
            @endif

            <div class="hidden" id="bankpay">
                <div class="col-sm-offset-3 col-sm-6" style="margin-top:70px;text-align:center;border:1px solid #eee;padding-top:20px;padding-bottom:20px;">
                    <h3>Total<br>IDR <?= number_format($order->order_total,0,',','.') ?></h3>

                    <table class="table">
                        @foreach($bank as $ba)
                            <tr>
                                <td><img src="{{ url($ba->bank_image) }}" alt="{{ $ba->bank_name }}" style="max-width:50px;max-height:50px;"></td>
                                <td>{{ $ba->bank_holder }}</td>
                                <td>{{ $ba->bank_noreg }}</td>
                                <td>{{ $ba->bank_desc }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                <div class="col-sm-offset-3 col-sm-6" style="margin-top:30px;text-align:center;">
                    <a href="{{ url('user/order/payment-confirmation/'.$order->order_id) }}" class="btn btn-success" style="border-radius:0px;">Pay Now</a>
                </div>
            </div>

        </div>

    </div>

</section><!-- #content end -->

<form id="payment-form" method="post" action="{{ url('snapfinish') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="result_type" id="result-type" value=""></div>
    <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

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
    getheight();

    function getheight(){
        var w_choose = $('.choosepay').width();
        $('.choosepay').height(w_choose);
    }
</script>

<script type="text/javascript">

    function getpayinfo(){
        if ($('#bankpay').hasClass('hidden')) {
            $('#bankpay').removeClass('animated fadeOut');
            $('#banktrans').css('background-color','#00BED7');
            $('#banktrans a').css('color','#fff');
            $('#bankpay').addClass('animated fadeIn');
            $('#bankpay').removeClass('hidden');
        }else {
            $('#bankpay').removeClass('animated fadeIn');
            $('#banktrans').css('background-color','');
            $('#banktrans a').css('color','');
            $('#bankpay').addClass('animated fadeOut');
            $('#bankpay').addClass('hidden');
        }
    }

</script>

@stop
