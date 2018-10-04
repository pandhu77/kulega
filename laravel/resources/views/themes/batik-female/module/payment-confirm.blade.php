@extends('web.app')
@section('content')

<?php $website = DB::table('cms_config')->first(); ?>
<title>Payment | {{ $website->site_name }}</title>

<!-- Page Title
============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>Payment Confirm</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/user/profile') }}">Profile</a></li>
            <li class="active">Payment</li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="col-md-9 box-right">
              <h2 style="margin-top:-10px;">Invoice #{{$row->order_id}}</h2>
              <hr>
                <section style="margin-bottom: 20px;">
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissable col-sm-12">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <!-- <h4>  <i class="icon fa fa-check"></i> Alert!</h4> -->
                            {{ Session::get('success') }}
                        </div>
                        @endif
                   @if(Session::get('error_get'))
                     <div class="alert alert-dange col-md-12 col-sm-12">
                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                       {{ Session::get('error_get') }}</div>
                   @endif
                   @if($errors->all())
                    <div class="alert alert-danger col-md-12 col-sm-12">
                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        @foreach($errors->all() as $error)
                            <?php echo $error."</br>";?>
                        @endforeach
                    </div>
                  @endif
                </section>
              <section class="content invoice" style="margin-bottom: 10px;">
                <div class="row invoice-info" style="background-color:#f4f5f4;">

                    @foreach($bank as $ba)
                  <div class="col-sm-6 col-xs-12  invoice-col">
                    {{ $ba->bank_name }}
                    <address>
                      <strong>{{ $ba->bank_noreg }}</strong><br>
                      <strong>{{ $ba->bank_holder }}</strong><br>
                    </address>
                  </div>
                  @endforeach

                </div>
              </section>
              <section class="content invoice" style="margin-bottom: 10px;">
                <!-- info row -->
                <div class="row">
                  <form action="{{ url('user/order/payment-confirmation/'.$row->order_id)}}" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                     <div class="col-md-12">

                       <div class="form-group">
                            <label for="email">Bank Name *</label>
                            <input type="text" class="form-control"  name="payment_bank" required="">
                        </div>
                       <div class="form-group">
                            <label for="email">Account Name *</label>
                            <input type="text" class="form-control"  name="account_name" required="">
                        </div>
                        <div class="form-group">
                             <label for="email">Account Number *</label>
                             <input type="text" class="form-control"name="account_number" required="">
                         </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control"name="payment_email" required="">
                        </div>
                        <div class="form-group valid">
                           <label for="Date">Transfer Date *</label>
                           <input id="datepicker2" class="date-picker form-control " placeholder="Date"  value="" data-validation-format="yyyy-mm-dd" name="transfer_date" type="text">
                           <input type="hidden" name="" value="" id="triggerdate2">
                        </div>

                        <div class="form-group">
                            <label for="email">Transfer Ammount  <span id="viewammount">*</span> </label>
                            <input type="number" class="form-control" id="inttransfer" onkeyup="gettransfer()" name="transfer_ammount" required="" >
                        </div>
                        <div class="form-group">
                            <label for="email">Evidence of Transfer *</label>
                            <input type="file" class="filestyle pull-right" name="payment_image" id="img" required="" data-buttonName="btn-default">
                        </div>

                        <div class="form-group">
                            <label for="email">Notes</label>
                            <textarea class="form-control"name="payment_notes"  value=""></textarea>
                        </div>

                    </div>

                </div>
                <!-- this row will not appear when printing -->
                <div class="row no-print"style="padding-top:5px;padding-bottom:5px;">
                  <div class="col-xs-12" style="text-align:right;">
                      <a id="pay-button" class="btn button-red nobottommargin" style="color:#fff;" onclick="getpayment()">
                          <i class="icon-star3"></i> Gateway Payment
                      </a>
                    <!-- <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button> -->
                    <div class="btn-group">
                      <a href="{{ url('user/profile') }}" class="btn  btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
                      <button class="btn pull-right" style="background-color: #000; color: white;" type="submit" data-original-title=""><i class="fa fa-save"></i> Save</button>
                    </div>

                  </div>
                </div>
              </section>
              </form>

            </div>

        </div>

    </div>

</section><!-- #content end -->

<script type="text/javascript" src="{{ asset('assets/web/js/jquery.js') }}"></script>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<CLIENT-KEY>"></script>

<form id="payment-form" method="post" action="{{ url('snapfinish') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="result_type" id="result-type" value=""></div>
    <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

@push('js')
<script>
    function gettransfer(){
      var data=$('#inttransfer').val();

      $('#viewammount').html(
        '<span class="price_format">'+data+'</span>'
      );
      $('.price_format').priceFormat();

    }
</script>

<script type="text/javascript">
function getpayment(){
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
};
</script>
@endpush

@stop
