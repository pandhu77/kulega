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
<title>Order Check | {{ $website->site_name }}</title>

<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Check Order</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="active">Check Order</li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="col-sm-offset-4 col-sm-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="orderid" placeholder="Order ID / Email">
                    <span class="input-group-btn">
                        <a href="javascript:void(0)" class="btn btn-default" onclick="getorderinfo()">Search !</a>
                    </span>
                </div><!-- /input-group -->
            </div>

            <div class="col-md-12" style="padding-top:50px;">
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable col-sm-12" style="text-align:center;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <!-- <h4>  <i class="icon fa fa-check"></i> Alert!</h4> -->
                        {{ Session::get('success') }}
                    </div>
                    @endif
               @if(Session::get('error_get'))
                 <div class="alert alert-dange col-md-12 col-sm-12" style="text-align:center;">
                   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                   {{ Session::get('error_get') }}</div>
               @endif
               @if($errors->all())
                <div class="alert alert-danger col-md-12 col-sm-12" style="text-align:center;">
                   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    @foreach($errors->all() as $error)
                        <?php echo $error."</br>";?>
                    @endforeach
                </div>
              @endif
            </div>

            <div class="col-md-12" id="resultorder" style="padding-top:50px;">

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
    function getorderinfo(){
        var orderid     = $('[name=orderid]').val();
        var datapost    = {
            '_token' : '{{ csrf_token() }}',
            'orderid': orderid
        }

        $.ajax({
            type: "POST",
            url : "{{ url('ajax/check/order') }}",
            data: datapost,
            success:function(data){
                if (data == 0) {
                    $('#resultorder').html('<h3 style="text-align:center;">Empty<h3>');
                } else {
                    $('#resultorder').html(data);
                    getheight();
                }

            }
        });
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

<script type="text/javascript">
    getheight();

    function getheight(){
        var w_choose = $('.choosepay').width();
        $('.choosepay').height(w_choose);
    }
</script>

@stop
