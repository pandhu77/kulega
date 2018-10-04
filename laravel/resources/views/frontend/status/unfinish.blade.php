@extends('app')
@section('content')
<style>
.col-content{
  padding-top: 40px;
  padding-bottom: 20px;
  /*color: #666;*/
  font-size: 18px;
  font-weight: bold;

}
.page-title {
  display: block;
  font-size: 30px;
  font-family: "";
  color: #b2203d;
  text-align: center;
  margin-bottom: 13px;
  font-weight: 700;
  margin-top: 15px;
  line-height: 16px;
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
      border-bottom: none;
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
.back {
		border: 0;
		padding: 5px 15px;
		background-color: #333;
		color: #fff;
		font-size: 16px;
		border-radius: 3px;
}

.btn-primary:focus, .btn-primary.focus {
		color: #fff;
		background-color: #999;
		border-color: #999;
}
.btn-primary:hover {
		color: #fff;
		background-color: #999;
		border-color: #999;
}
.table .table {
    background-color: #fff;
    border: 1px solid #ddd;
}
.invoice{
  border: 1px solid #ddd;
  padding: 10px;
}
/*.table-striped > tbody > tr:nth-of-type(odd) {
     background-color: #fff;
}*/
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 5px;
    line-height: 1.42857143;
    vertical-align: top;
     border-top: 0px solid #fff;
}
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f9f9f9;
}
.table .table {
  border: none;

}
.table{
  margin-bottom: 0px;
}
.invoice-info .invoice-col{
  font-weight: 500;
  margin-bottom: 15px;
}
</style>
<title>{{web_name()}} | Unfinish Order</title>
  <div class="container">
      <div class="col-sm-12 list-outer-title text-center">
        <label class="page-title">Sorry, {{ $row->member_fullname}}</label>
          Transaction Invoice No: {{$row->order_id}} unfinished. Please make payment until finish.  <a href="{{url('payment/make-payment/'.$row->order_id)}}" style="color:#b2203d !important;">Make Payment</a>
      </div>
      <span class="sep"></span>
      <div class="col-sm-12" style="margin-top:50px;">
      <section class="content invoice" style="margin-bottom: 10px;">
        <div class="row invoice-info" style="background-color:#f4f5f4;padding:5px;">
          <div class="col-sm-12 col-xs-12 invoice-col" >
            <b>Invoice: #{{ $row->order_id }}</b>
          </div>
          <div class="col-sm-12 col-xs-12 invoice-col" >
            Order Date: <?php echo date("d F Y H:i",strtotime( $row->order_date));?>
          </div>

          <div class="col-sm-12 col-xs-12 invoice-col">
            Payment Method: @if($row->payment_service==2)Credit Card @else Bank Transfer @endif
          </div>
          <div class="col-sm-12 col-xs-12 invoice-col">
            Payment Status: @if($row->payment_status==2)<span class="label label-success">Payments accepted </span>@elseif($row->payment_status==1)  <span class="label label-warning">Waiting for confirmation of payment</span> >@elseif($row->payment_status==3)  <span class="label label-danger">Failed</span> @else  <span class="label label-warning">Waiting for payment</span> @endif
          </div>
          <!-- /.col -->

          <!-- /.col -->
        </div>
      </section>
      </div>
      <div class="col-sm-12 col-content">
          <p>Product you order </p>
          <hr>

      </div>
      <div class="col-sm-9">

          <section class="content invoice" style="margin-bottom: 10px;">
            <!-- Table row -->

                <div class="row">
                  <div class="col-xs-12 table">
                    <table class="table table-striped table tableresponsive">
                      <thead>
                        <tr>
                          <th style="text-align:center;" width="10%">Images</th>
                          <th style="text-align:center;">Product</th>
                          <th style="text-align:center;">Qty</th>
                          <th style="text-align:center;">Price</th>

                          <th style="text-align:center;">Sub Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($detail as $details)
                          @if($details->order_id==$row->order_id)
                        <tr>

                          <td data-label="Images"><img src="{{asset($details->front_image)}}" width="100%"></td>

                          <td data-label="Product" style="text-align:right;"><p>{{$details->prod_name}}@if($details->prod_size ==! null) ({{$details->prod_size}}) @endif @if($details->prod_color ==! null)({{$details->prod_color}}) @endif</p></td>
                          <td data-label="Qty" style="text-align:right;">{{$details->detail_qty}}</td>
                          <td data-label="Price"style="text-align:right;">@if($details->detail_disc == 0 || $details->detail_disc==null ) <span class="price_format">{{$details->price_item}}</span>  @else  <del><span class="price_format">{{$details->price_item}}</span> </del><br>  @if($details->detail_disc <= 100){{$details->detail_disc}}%  @else <span class="price_format">{{$details->detail_disc}} @endif OFF</span> <br>
                          <span class="price_format" style="color:#B2203D;font-weight:bold;">{{$details->detail_subtotal}}</span>  @endif</td>
                          <td data-label="Sub Total" style="text-align:right;"><?php $hit_subtotal=$details->detail_qty * $details->detail_subtotal; ?><span class="price_format">{{$hit_subtotal}}</span> </td>
                        </tr>
                        @endif
                    @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>

          </section>

      </div>
    <div class="col-sm-3">
      <section class="content invoice" style="margin-bottom: 10px;">
        <!-- info row -->
        <div class="row invoice-info" style="background-color:#f4f5f4;padding:5px;">
            <div class="col-sm-12 invoice-col">
              <p class="" style="margin:0px;font-weight:bold;">Summary Of Payment</p>
            </div>
        </div>


      <!-- <div class="table-responsive"> -->
        <table class="table"style="width: 100%;max-width: 100%;">
          <tbody>
            <tr>
              <th style="width:50%">Subtotal</th>
              <td style="text-align:right;"><span class="price_format">{{ $row->sub_total }}</span></td>
            </tr>

            <tr>
              <th>Discount Shipping(-)</th>
              <td style="text-align:right;"><span class="price_format">{{ $row->disc_cart }}</span></td>
            </tr>

            <tr>
              <th>Member Discount (-)</th>
              <td style="text-align:right;"><span class="price_format">{{ $row->order_disc }}</span></td>
            </tr>


            @if($row->voucher_value !==null )
            <tr>
              <th>Voucher(-)({{ $row->voucher_code }})</th>
              <td style="text-align:right;"><span class="price_format">{{ $row->voucher_value }}</span></td>
            </tr>
            @endif
            @if($row->disc_reward !==null )
            <tr>
              <th>Reward(-)</th>
              <td style="text-align:right;"><span class="price_format">{{ $row->disc_reward }}</span></td>
            </tr>
            @endif

            <tr>
              <th>Shipping(+)</th>
              <td style="text-align:right;">@if($row->shipping_cost == null)<span class="price_format">0</span> @endif<span class="price_format">{{ $row->shipping_cost }}</span></td>
            </tr>
            <!-- <tr>
              <th>Service Charge(+)</th>
              <td style="text-align:right;"><span class="price_format">@if ($row->service_cost ==null )0 @endif{{ $row->service_cost }}</span></td>
            </tr> -->

            <tr style="border-top: 1px solid #333; ">
              <th>Grand Total:</th>
              <th style="text-align:right;"><span class="price_format" style="color:#B2203D;font-weight:bold;">{{ $row->order_total }}</span></th>
            </tr>
          </tbody>
        </table>
      <!-- </div> -->
      </section>
      <p style="text-align:right"><span style="color:#B2203D;">Note</span>: Unique code(<?php echo $row->order_generate;?>)<p/>
    </div>

    <div class="col-sm-12" style="margin-top:50px;">
      Monitor your order status, please visit the  <a href="{{url('user/order/detail/'.$row->order_id)}}" style="color:#b2203d !important;">Order Status Page</a><br>
      View your booking history on the Transaction List page, please visit the  <a href="{{url('user/order')}}" style="color:#b2203d !important;">My Orders Page</a><br>
      Notice your order will be sent via email, If you need further information, please contact us.
    </div>



  </div>

  @endsection
