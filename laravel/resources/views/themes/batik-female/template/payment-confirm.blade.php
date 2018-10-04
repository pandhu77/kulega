@extends('web.app')
@section('content')

<link rel="stylesheet" href="{{ asset('template/admin/datepicker/datepicker3.css') }}">

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

              <section class="content invoice" style="margin-bottom: 10px;">
                <div class="row invoice-info" style="background-color:#f4f5f4;">

                    <table class="table" style="padding-bottom:0px;">
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
              </section>
              <br>
              @if(Session::has('success'))
                  <div class="alert alert-success alert-dismissable col-sm-12" style="background-color:#f1f1f1;">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <!-- <h4>  <i class="icon fa fa-check"></i> Alert!</h4> -->
                      {{ Session::get('success') }}
                  </div>
                  @endif
             @if(Session::get('error_get'))
               <div class="alert alert-dange col-md-12 col-sm-12" style="background-color:#f1f1f1;">
                 <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                 {{ Session::get('error_get') }}</div>
             @endif
             @if($errors->all())
              <div class="alert alert-danger col-md-12 col-sm-12" style="background-color:#f1f1f1;">
                 <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  @foreach($errors->all() as $error)
                      <?php echo $error."</br>";?>
                  @endforeach
              </div>
            @endif
            <br>
              <section class="content invoice" style="margin-bottom: 10px;">
                <!-- info row -->
                <div class="row">
                  <form action="{{ url('user/order/payment-confirmation')}}" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                     <div class="col-md-12">

                     <div class="form-group">
                          <label for="email">Order ID *</label>
                          <input type="text" class="form-control"  name="order_id" required="" value="<?php if($parameter != 'confirm'){echo $parameter;} ?>">
                      </div>
                       <div class="form-group">
                            <label for="email">Bank Name *</label>
                            <input type="text" class="form-control"  name="payment_bank" required="" value="{{ old('payment_bank') }}">
                        </div>
                       <div class="form-group">
                            <label for="email">Account Name *</label>
                            <input type="text" class="form-control"  name="account_name" required="" value="{{ old('account_name') }}">
                        </div>
                        <div class="form-group">
                             <label for="email">Account Number *</label>
                             <input type="text" class="form-control"name="account_number" required="" value="{{ old('account_number') }}">
                         </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control" name="payment_email" required="" value="{{ old('payment_email') }}">
                        </div>
                        <div class="form-group valid">
                           <label for="Date">Transfer Date *</label>
                           <input id="getdate" class="date-picker form-control" placeholder="Date" value="{{ old('transfer_date') }}" data-validation-format="yyyy-mm-dd" name="transfer_date" type="text">
                           <input type="hidden" name="" value="" id="triggerdate2">
                        </div>

                        <div class="form-group">
                            <label for="email">Transfer Ammount  <span id="viewammount">*</span> </label>
                            <input type="number" class="form-control" id="inttransfer" onkeyup="gettransfer()" name="transfer_ammount" required="" value="{{ old('transfer_ammount') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Evidence of Transfer *</label>
                            <input type="file" class="filestyle pull-right" name="payment_image" id="img" required="" data-buttonName="btn-default">
                        </div>

                        <div class="form-group">
                            <label for="email">Notes</label>
                            <textarea class="form-control"name="payment_notes"  value="">{{ old('payment_notes') }}</textarea>
                        </div>

                    </div>

                </div>
                <!-- this row will not appear when printing -->
                <div class="row no-print"style="padding-top:5px;padding-bottom:5px;">
                  <div class="col-xs-12" style="text-align:right;">
                      <!-- <a id="pay-button" class="btn button-red nobottommargin" style="color:#fff;" onclick="getpayment()">
                          <i class="icon-star3"></i> Gateway Payment
                      </a> -->
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
<script src="{{ asset('template/admin/datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
    $("#getdate").datepicker();
</script>

<!-- <script>
    function gettransfer(){
      var data=$('#inttransfer').val();

      $('#viewammount').html(
        '<span class="price_format">'+data+'</span>'
      );
      $('.price_format').priceFormat();

    }
</script> -->

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
