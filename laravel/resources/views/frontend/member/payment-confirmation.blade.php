@extends('frontend/member/menu')
@section('isi')

<style>
    .tab-content {
        margin-top: 50px;
    }
    .nav-pills {
        background-color: #f4f5f4;
    }
    .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
        color: #fff;
        background-color: #B2203D;
        border-radius: 0px;
    }
    .nav-pills > li {
        float: none !important;
        width: auto !important;
        /* margin: 0 auto; */
    }
    .nav > li {
        position: relative;
        display: inline-block !important;
        /* margin: 0 auto; */
    }
    .pager li > a, .pager li > span {
        display: inline-block;
        padding: 12px 45px;
        background-color: #B2203D;
        border: 1px solid #ddd;
        border-radius: 0px;
        color: white;
      }
      a{
        color: #666;
        font-weight: 400;
        letter-spacing: 1px;
      }
      @media screen and (max-width: 900px) {
    .tableresponsive {
        border: 0;
    }

    .tableresponsive thead,tfoot {
        display: none;
    }

    .tableresponsive tr {
        margin-bottom: 10px;
        display: block;
        border-bottom: 2px solid #ddd;
    }

    .tableresponsive td {
        display: block;
        text-align: right;
        font-size: 13px;
        border-bottom: 0px dotted #ccc;
    }

    .tableresponsive td:last-child {
        border-bottom: 0;
    }

    .tableresponsive td:before {
        content: attr(data-label);
        float: left;
        text-transform: uppercase;
        font-weight: bold;
    }

}
.invoice{
  border: 1px solid #ddd;
  padding: 10px;
}
.table-striped > tbody > tr:nth-of-type(odd) {
     background-color: #fff;
}
</style>
<title>{{web_name()}} | Payment Confirmation</title>
<div class="col-md-9 box-right">
  <h2 style="margin-top:-10px;">Payment <span style="color:#B2203D"> Confirmation</span> - Invoice #{{$row->order_id}}</h2>
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
    <!-- info row -->
    <div class="row invoice-info" style="background-color:#f4f5f4;">
      <div class="col-sm-3 col-xs-6  invoice-col">
        Order Date
        <address>
          <strong><?php echo date("d F Y",strtotime( $row->order_date));?></strong>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-3 col-xs-6 invoice-col">
        Order Total
        <address>
          <strong><span class="price_format">{{ $row->order_total }}</span></strong>
        </address>
      </div>
      <div class="col-sm-3 col-xs-6 invoice-col">
        Payment: @if($row->payment_service==2)Credit Cart @else Bank Transfer @endif
        <address>
            <strong>@if($row->payment_status==2)<span class="label label-success">Payments accepted </span>@elseif($row->payment_status==1)  <span class="label label-warning">Waiting for confirmation of payment</span> @else  <span class="label label-warning">Waiting for payment</span>  @endif</strong>

        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-3 col-xs-6 invoice-col">
        <b>Invoice #{{ $row->order_id }}</b>

        <br>
        <b>Order Status:</b> @if($row->order_status==0)  <span class="label label-warning"> pending </span> @elseif($row->order_status==1)<span class="label label-primary">  Processing </span> @elseif($row->order_status==2) <span class="label label-primary"> Ready to Send </span> @elseif($row->order_status==3) <span class="label label-primary"> In Delivery </span>  @elseif($row->order_status==4) <span class="label label-success"> Completed(Send)  </span>  @endif
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
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
    <div class="row no-print"style="background-color:#f4f5f4;padding-top:5px;padding-bottom:5px;">
      <div class="col-xs-12" style="text-align:right;">
        <!-- <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button> -->
        <div class="btn-group">
          <a href="{{url('user/order')}}" class="btn  btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
          <button class="btn pull-right" style="background-color: #B2203D; color: white;" type="submit" data-original-title=""><i class="fa fa-save"></i> Save</button>
        </div>

      </div>
    </div>
  </section>
  </form>

</div>
<script>
    function gettransfer(){
      var data=$('#inttransfer').val();

      $('#viewammount').html(
        '<span class="price_format">'+data+'</span>'
      );
      $('.price_format').priceFormat();

    }
</script>
@endsection
