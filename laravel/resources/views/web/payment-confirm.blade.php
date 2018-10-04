@extends('web.master')
@section('title','Sonia')
@section('content')

@push('css')
<link rel="stylesheet" href="{{ asset('template/admin/datepicker/datepicker3.css') }}">

<style media="screen">
    .form-control{
        border-radius: 0px;
    }

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        padding: 15px;
    }
</style>

@endpush

<!-- BEGIN PRODUCTS -->
<section id="main-products">
  <div class="container">
    <div class="row section-title text-center">
      <div class="col-md-12">
        <h3>Payment Confirmation</h3>
      </div>
    </div>
  </div>
</section>
<!-- ./END PRODUCTS -->

<section id="content">

    <div class="content-wrap" style="padding-top:0px;">

        <div class="container clearfix">

            <div class="col-md-6 box-right">
              <!-- @if(Session::has('success'))
                  <div class="alert alert-success alert-dismissable col-sm-12" style="background-color:#f1f1f1;">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4>  <i class="icon fa fa-check"></i> Alert!</h4>
                      {{ Session::get('success') }}
                  </div>
                  @endif -->
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
            <form action="{{ url('user/order/payment-confirmation') }}" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <section class="content invoice" style="margin-bottom: 10px;">
                <!-- info row -->
                <div class="row">

                     <div class="col-md-12" style="padding-left:0px;padding-right:0px;">

                     <div class="form-group">
                          <label for="email">Order ID *</label>
                          <!-- <input type="text" class="form-control"  name="order_id" required="" value="<?php if($parameter != 'confirm'){echo $parameter;} ?>"> -->
                          <select class="form-control" name="order_id">
                              <option value="" selected="" disabled="">Select Order ID</option>
                              @foreach($row as $ro)
                                <option value="{{ $ro->order_id }}">{{ $ro->order_id }}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="form-group">
                           <label for="email">Transfer To *</label>
                           <!-- <input type="text" class="form-control" name="payment_bank" required="" value="{{ old('payment_bank') }}"> -->
                           <select class="form-control" name="payment_bank" required="">
                               <option selected disabled>Choose</option>
                               <option value="BCA">BCA</option>
                               <option value="Mandiri">Mandiri</option>
                               <option value="Other Bank">Other Bank</option>
                           </select>
                       </div>
                      <div class="form-group">
                           <label for="email">Account Holder Bank / Transfer dari rekening *</label>
                           <input type="text" class="form-control" name="sender_bank" required="" value="{{ old('sender_bank') }}">
                       </div>
                       <div class="form-group">
                            <label for="email">Account Holder Name / Transfer atas nama *</label>
                            <input type="text" class="form-control"  name="account_name" required="" value="{{ old('account_name') }}">
                        </div>
                        <!-- <div class="form-group">
                             <label for="email">Account Number *</label>
                             <input type="text" class="form-control"name="account_number" required="" value="{{ old('account_number') }}">
                         </div> -->

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control" name="payment_email" required="" value="{{ old('payment_email') }}">
                        </div>

                        <div class="form-group valid">
                           <label for="Date">Transfer Date / Tanggal transfer *</label>
                           <input id="getdate" class="date-picker form-control" placeholder="Date" value="{{ old('transfer_date') }}" data-validation-format="yyyy-mm-dd" name="transfer_date" type="text">
                           <input type="hidden" name="" value="" id="triggerdate2">
                        </div>

                        <div class="form-group">
                            <label for="email">Transfer Ammount / Nominal transfer  <span id="viewammount">*</span> </label>
                            <input type="number" class="form-control" id="inttransfer" onkeyup="gettransfer()" name="transfer_ammount" required="" value="{{ old('transfer_ammount') }}">
                        </div>
                        <!-- <div class="form-group">
                            <label for="email">Evidence of Transfer *</label>
                            <input type="file" class="filestyle pull-right" name="payment_image" id="img" required="" data-buttonName="btn-default">
                        </div> -->
                        <div class="form-group">
                            <label for="email">Notes</label>
                            <textarea class="form-control"name="payment_notes"  value="">{{ old('payment_notes') }}</textarea>
                        </div>

                    </div>

                </div>
                <!-- this row will not appear when printing -->
                <div class="row no-print"style="padding-top:5px;padding-bottom:5px;">
                  <div class="col-xs-12" style="text-align:right;padding-right:0px;">
                      <!-- <a id="pay-button" class="btn button-red nobottommargin" style="color:#fff;" onclick="getpayment()">
                          <i class="icon-star3"></i> Gateway Payment
                      </a> -->
                    <!-- <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button> -->
                    <div class="btn-group">
                      <a href="{{ url('user/profile') }}" class="btn btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back" style="border-radius:0px;background-color:#1ABC9C;border-color:#1ABC9C;"><i class="fa fa-share"></i> Back</a>
                      <button class="btn pull-right" style="background-color: #000; color: white;border-radius:0px;" type="submit" data-original-title=""><i class="fa fa-save"></i> Save</button>
                    </div>

                  </div>
                </div>
              </section>
              </form>

            </div>

            <style media="screen">
                .box-detail{
                    border:1px solid #f1f1f1;
                    padding: 15px;
                }
            </style>

            <div class="col-md-offset-1 col-md-5">
                <section class="content invoice" style="margin-bottom: 10px;">
                  <div class="row invoice-info" style="background-color:#f4f5f4;">

                      <h3 style="margin-bottom: 0px;text-align: center;padding: 19px 0;">Bank Information</h3>

                      <table class="table" style="padding-bottom:0px;margin-bottom:0px;">
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
            </div>

        </div>

    </div>

</section><!-- #content end -->

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

<script type="text/javascript">
    localStorage.removeItem('jsvouchervalue');
    localStorage.removeItem('jsvouchertype');
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

@endsection
