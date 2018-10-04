@extends('frontend/member/menu')
@section('isi')

<style>
    font-family: 'Lato', sans-serif;
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

    .no-orders {
      border: 1px dashed #B2203D;
      padding: 15px;
      color: #B2203D;
      display: table;
      width: 100%;
    }
    .nav > li > a:hover, .nav > li > a:focus {
      color: #B2203D;
    }
</style>
<title>{{web_name()}} | Order</title>
<div class="col-md-9 box-right" >
  <h2 style="margin-top:-10px;">Orders <span style="color:#B2203D">List</span>  </h2>
  <hr>
      @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
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
  <!-- <div class="row">
      <div class="col-md-12"> -->
        <ul class="nav nav-pills" style="text-align: center;">
            <li class="active"><a href="#progress" data-toggle="tab">Order List In Progress</a></li>
            <li><a href="#history" data-toggle="tab">Order List History </a></li>
            <li><a href="#canceled" data-toggle="tab">Order List Canceled </a></li>
        </ul>
      <!-- </div>
  </div> -->

  <div class="tab-content"style="margin-top:30px;">

      <!-- First tab -->
      <div class="tab-pane active" id="progress">
        @if(count($orderprogress) <= 0)
          <div class="row">
            <div class="no-orders ng-scope" ng-if="!orderListExist &amp;&amp; currentOrderType !== 'open-order'">
              <div class="ic-no-order"></div>
              <span>Now a days you do not have a recent orders.  <a href="{{url('/')}}" style="font-weight: bold;text-decoration: underline;color: #B2203D;">Let's order now!</a></span>
            </div>
        </div>
        @endif
        @foreach($orderprogress as $key => $orders)
          <section class="content invoice" style="margin-bottom: 10px;">
            <!-- info row -->
            <div class="row invoice-info" style="background-color:#f4f5f4;">
              <div class="col-sm-3 col-xs-6  invoice-col">
                Order Date
                <address>
                  <strong><?php echo date("d F Y",strtotime( $orders->order_date));?></strong>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-xs-6 invoice-col">
                Order Total
                <address>
                  <strong><span class="price_format">{{ $orders->order_total }}</span></strong>
                </address>
              </div>
              <div class="col-sm-3 col-xs-6 invoice-col">
                Payment: @if($orders->payment_service==2)Credit Card @else Bank Transfer @endif
                <address>
                  <strong>@if($orders->payment_status==2)<span class="label label-success">Payments accepted </span>@elseif($orders->payment_status==1)  <span class="label label-warning">Waiting for confirmation of payment</span>@elseif($orders->payment_status==3)  <span class="label label-danger">Failed</span> @else  <span class="label label-warning">Waiting for payment</span>  @endif</strong>
                </address>
                <br>
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-xs-6 invoice-col">
                <b>Invoice #{{ $orders->order_id }}</b>

                <br>
                <b>Order Status:</b> @if($orders->order_status==0)  <span class="label label-warning"> pending </span> @elseif($orders->order_status==1)<span class="label label-primary">  Processing </span> @elseif($orders->order_status==2) <span class="label label-primary"> Ready to Send </span> @elseif($orders->order_status==3) <span class="label label-primary"> In Delivery </span>  @elseif($orders->order_status==4) <span class="label label-success"> Completed(Send)  </span>  @endif
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

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
                          @if($details->order_id==$orders->order_id)
                        <tr>

                          <td data-label="Images"><img src="{{asset($details->front_image)}}" width="100%"></td>
                          <td data-label="Product" style="text-align:right;"><p>{{$details->prod_name}}@if($details->prod_size ==! null) ({{$details->prod_size}}) @endif @if($details->prod_color ==! null)({{$details->prod_color}}) @endif</p></td>
                          <td data-label="Qty" style="text-align:right;">{{$details->detail_qty}}</td>
                          <td data-label="Price"style="text-align:right;">@if($details->detail_disc == 0 || $details->detail_disc==null ) <span class="price_format">{{$details->price_item}}</span>  @else  <del><span class="price_format">{{$details->price_item}}</span> </del><br> @if($details->detail_disc <= 100){{$details->detail_disc}}% @else <span class="price_format">{{$details->detail_disc}} @endif OFF</span> <br>
                          <span class="price_format" style="color: #B2203D;font-weight: bold;">{{$details->detail_subtotal}}</span>  @endif</td>
                          <td data-label="Sub Total" style="text-align:right;"><?php $hit_subtotal=$details->detail_qty * $details->detail_subtotal; ?><span class="price_format">{{$hit_subtotal}}</span> </td>
                        </tr>
                        @endif
                    @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-xs-12">
                <!-- <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button> -->
                @if($orders->order_status==0 || $orders->order_status==null and $orders->payment_service == 1)
                <a href="{{ url('user/order/payment-confirmation/'.$orders->order_id)}}"style=" margin-left: 5px;" class="btn btn-warning btn-xs pull-right confirmation"><i class="fa fa-shopping-cart"></i> Payment Confirmation</a>
                @endif
                @if($orders->payment_service == 2 and $orders->payment_status==0 )
                <a href="{{url('payment/make-payment/'.$orders->order_id)}}"style=" margin-left: 5px;" class="btn btn-warning btn-xs pull-right confirmation"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Make Payment</a>
                @endif
                <a href="{{ url('user/order/detail/'.$orders->order_id)}}" class="btn btn-primary btn-xs pull-right back"><i class="ion ion-eye"> </i> Detail Order</a>
                <!-- <button class="btn btn-primary pull-right"><i class="ion ion-eye"></i> Details Order</button>
                <button class="btn btn-warning pull-right" style="margin-right: 5px;"><i class="fa fa-shopping-cart"></i> Payment Confirmation</button> -->
              </div>
            </div>
          </section>
          @endforeach
          {{ $orderprogress->links() }}

      </div>
      <div class="tab-pane col-sm-12" id="history">
        @if(count($orderhistory) <= 0)
          <div class="row">
            <div class="no-orders ng-scope" ng-if="!orderListExist &amp;&amp; currentOrderType !== 'open-order'">
              <div class="ic-no-order"></div>
              <span>Now a days you do not have a history orders.  <a href="{{url('/')}}" style="font-weight: bold;text-decoration: underline;color: #B2203D;">Let's order now!</a></span>
            </div>
        </div>
        @endif
          <!-- BEGIN HISTORY-->
          @foreach($orderhistory as $key => $orders)
            <section class="content invoice" style="margin-bottom: 10px;">
              <!-- info row -->
              <div class="row invoice-info" style="background-color:#f4f5f4;">
                <div class="col-sm-3 col-xs-6  invoice-col">
                  Order Date
                  <address>
                    <strong><?php echo date("d F Y",strtotime( $orders->order_date));?></strong>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6 invoice-col">
                  Order Total
                  <address>
                    <strong><span class="price_format">{{ $orders->order_total }}</span></strong>
                  </address>
                </div>
                <div class="col-sm-3 col-xs-6 invoice-col">
                  Payment: @if($orders->payment_service==2)Credit Card @else Bank Transfer @endif
                  <address>
                    <strong>@if($orders->payment_status==2)<span class="label label-success">Payments accepted </span>@elseif($orders->payment_status==1)  <span class="label label-warning">Waiting for confirmation of payment</span> @elseif($orders->payment_status==3)  <span class="label label-danger">Failed</span> @else  <span class="label label-warning">Waiting for payment</span>  @endif</strong>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6 invoice-col">
                  <b>Invoice #{{ $orders->order_id }}</b>

                  <br>
                  <b>Order Status:</b> @if($orders->order_status==0)  <span class="label label-warning"> pending </span> @elseif($orders->order_status==1)<span class="label label-primary">  Processing </span> @elseif($orders->order_status==2) <span class="label label-primary"> Ready to Send </span> @elseif($orders->order_status==3) <span class="label label-primary"> In Delivery </span>  @elseif($orders->order_status==4) <span class="label label-success"> Completed(Send)  </span>  @endif
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

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
                            @if($details->order_id==$orders->order_id)
                          <tr>

                            <td data-label="Images"><img src="{{asset($details->front_image)}}" width="100%"></td>

                            <td data-label="Product" style="text-align:right;"><p>{{$details->prod_name}}@if($details->prod_size ==! null) ({{$details->prod_size}}) @endif @if($details->prod_color ==! null)({{$details->prod_color}}) @endif</p></td>
                            <td data-label="Qty" style="text-align:right;">{{$details->detail_qty}}</td>
                            <td data-label="Price"style="text-align:right;">@if($details->detail_disc == 0 || $details->detail_disc==null ) <span class="price_format">{{$details->price_item}}</span>  @else  <del><span class="price_format">{{$details->price_item}}</span> </del><br> Discount      @if($details->detail_disc <= 100){{$details->detail_disc}}% @else <span class="price_format">{{$details->detail_disc}} @endif</span> <br>  <span class="price_format">{{$details->detail_subtotal}}</span>  @endif</td>

                            <td data-label="Sub Total" style="text-align:right;"><?php $hit_subtotal=$details->detail_qty * $details->detail_subtotal; ?><span class="price_format">{{$hit_subtotal}}</span> </td>
                          </tr>
                          @endif
                      @endforeach
                        </tbody>
                      </table>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-xs-12">

                  <a href="{{ url('user/order/detail/'.$orders->order_id)}}" class="btn btn-primary btn-xs pull-right back"><i class="ion ion-eye"> Detail Order</i></a>
                  <!-- <button class="btn btn-primary pull-right"><i class="ion ion-eye"></i> Details Order</button>
                  <button class="btn btn-warning pull-right" style="margin-right: 5px;"><i class="fa fa-shopping-cart"></i> Payment Confirmation</button> -->
                </div>
              </div>
            </section>
            @endforeach
          <!-- END HISTORY -->
           {{ $orderhistory->links() }}
      </div>

      <div class="tab-pane col-sm-12" id="canceled">
          <!-- BEGIN CANCEL-->
          @foreach($ordercancel as $key => $orders)
            <section class="content invoice" style="margin-bottom: 10px;">
              <!-- info row -->
              <div class="row invoice-info" style="background-color:#f4f5f4;">
                <div class="col-sm-3 col-xs-6  invoice-col">
                  Order Date
                  <address>
                    <strong><?php echo date("d F Y",strtotime( $orders->order_date));?></strong>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6 invoice-col">
                  Order Total
                  <address>
                    <strong><span class="price_format">{{ $orders->order_total }}</span></strong>
                  </address>
                </div>
                <div class="col-sm-3 col-xs-6 invoice-col">
                  Payment: @if($orders->payment_service==2)Credit Card @else Bank Transfer @endif
                  <address>
                    <strong>@if($orders->payment_status==2)<span class="label label-success">Payments accepted </span>@elseif($orders->payment_status==1)  <span class="label label-warning">Waiting for confirmation of payment</span> @elseif($orders->payment_status==3)  <span class="label label-danger">Failed</span> @else  <span class="label label-warning">Waiting for payment</span>   @endif</strong>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6 invoice-col">
                  <b>Invoice #{{ $orders->order_id }}</b>

                  <br>
                  <b>Order Status:</b> @if($orders->order_status==0)  <span class="label label-warning"> pending </span> @elseif($orders->order_status==1)<span class="label label-primary">  Processing </span> @elseif($orders->order_status==2) <span class="label label-primary"> Ready to Send </span> @elseif($orders->order_status==3) <span class="label label-primary"> In Delivery </span>  @elseif($orders->order_status==4) <span class="label label-success"> Completed(Send)  </span> @elseif($orders->order_status==5) <span class="label label-danger"> Canceled  </span>  @endif
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

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
                            @if($details->order_id==$orders->order_id)
                          <tr>

                            <td data-label="Images"><img src="{{asset($details->front_image)}}" width="100%"></td>
                            <td data-label="Product" style="text-align:right;"><p>{{$details->prod_name}}@if($details->prod_size ==! null) ({{$details->prod_size}}) @endif @if($details->prod_color ==! null)({{$details->prod_color}}) @endif</p></td>
                            <td data-label="Qty" style="text-align:right;">{{$details->detail_qty}}</td>
                            <td data-label="Price"style="text-align:right;">@if($details->detail_disc == 0 || $details->detail_disc==null ) <span class="price_format">{{$details->price_item}}</span>  @else  <del><span class="price_format">{{$details->price_item}}</span> </del><br> Discount      @if($details->detail_disc <= 100){{$details->detail_disc}}% @else <span class="price_format">{{$details->detail_disc}} @endif</span> <br>  <span class="price_format">{{$details->detail_subtotal}}</span>  @endif</td>

                            <td data-label="Sub Total" style="text-align:right;"><?php $hit_subtotal=$details->detail_qty * $details->detail_subtotal; ?><span class="price_format">{{$hit_subtotal}}</span> </td>
                          </tr>
                          @endif
                      @endforeach
                        </tbody>
                      </table>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->


              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-xs-12">
                  <!-- <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button> -->
                  <a href="{{ url('user/order/detail/'.$orders->order_id)}}" class="btn btn-primary btn-xs pull-right back"><i class="ion ion-eye"> Detail Order</i></a>
                  <!-- <button class="btn btn-primary pull-right"><i class="ion ion-eye"></i> Details Order</button>
                  <button class="btn btn-warning pull-right" style="margin-right: 5px;"><i class="fa fa-shopping-cart"></i> Payment Confirmation</button> -->
                </div>
              </div>
            </section>
            @endforeach
          <!-- END CANCEL -->
           {{ $ordercancel->links() }}
      </div>
  </div>
</div>
@endsection
