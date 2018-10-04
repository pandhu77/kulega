@extends('backend/app')
@section('content')
<style>
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
  /*border-bottom: 2px solid #ddd;*/
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

</style>
  <title>System | Order </title>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Form Order Management</h3>
      </div>

      <div class="title_right">

      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-sm-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>View Order</h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            @if(Session::has('success-create'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
                    {{ Session::get('success-create') }}
                </div>
              @endif
             @if(Session::has('success-update'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> Alert!</h4>
                    {{ Session::get('success-update') }}
                </div>
              @endif

              @if(Session::has('success-delete'))
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
                    {{ Session::get('success-delete') }}
                </div>
              @endif

              @if(Session::has('no-delete'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h4>
                    {{ Session::get('no-delete') }}
                </div>
              @endif
              @if($errors->all())
              <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h4>
                @foreach($errors->all() as $error)
                <?php echo $error."</br>";?>
                @endforeach
              </div>
              @endif

            <section class="content invoice" style="margin-bottom:20px;">
              <!-- title row -->
              <div class="row">
                <div class="col-sm-12 invoice-header">
                  <h1>
                    <i class="fa fa-globe"></i>Invoice : #{{$order->order_id}}
                    </h1>
                </div>
                <!-- /.col -->
              </div>
              <div class="row invoice-info" style="background-color:#f4f5f4;padding-top:15px;">

                <div class="col-sm-4 col-xs-12 invoice-col">
                 DELIVERY METHOD
                  <address>
                    <strong> @if($order->dilivery_method=='ship') Shipping @elseif ($order->dilivery_method=='pick') Pickup   @endif </strong>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 col-xs-12invoice-col">

                  PAYMENT: @if($order->payment_service==2)CREDIT CARD @else BANK TRANSFER @endif
                  <address>
                      <strong>@if($order->payment_status==2)<span class="label label-success">Payments accepted </span>@elseif($order->payment_status==1)  <span class="label label-default">Waiting for confirmation of payment</span> @elseif($order->payment_status==3)  <span class="label label-danger">Failed</span> @else  <span class="label label-warning">Waiting for payment</span>  @endif</strong>

                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 col-xs-12invoice-col">
                  ORDER TOTAL
                  <address>
                    <strong><span class="price_format" style="color:#b2203d">{{ $order->order_total }}</span></strong>
                  </address>
                </div>

              </div>
              <!-- /.row -->
              <div class="row invoice-info" style="margin-top:15px;">

                <div class="col-sm-6 col-xs-12 invoice-col">

                  @if($order->dilivery_method=='ship') SHIPPING ADDRESS @elseif ($order->dilivery_method=='pick')  ADDRESS  @endif

                  <address>
                  Name:  <strong>{{$order->customer_name}}</strong>
                    <br>
                  Email:    {{$order->customer_email}}
                    <br>
                  Phone:{{$order->customer_phone}}
                    <br>
                  Address: {{$order->customer_address}}, {{$order->order_district}}, {{$order->order_city}}, {{$order->order_province}}, Post:{{$order->order_poscode}}

                  </address>

                </div>
                <!-- /.col -->
                <div class="col-sm-6 col-xs-12invoice-col">

                  BILIING ADDRESS
                  @if($order->bil_status==0)
                  <address>
                    Name: <strong>{{$order->billing_name}}</strong>
                    <br>
                    Email: {{$order->billing_email}}
                    <br>
                    Phone: {{$order->billing_phone}}
                    <br>
                    Address: {{$order->billing_address}}, {{$order->billing_district}}, {{$order->billing_city}}, {{$order->billing_province}}, Post:{{$order->billing_poscode}}
                  </address>
                  @else
                  <address>
                    <strong>Same as shipping address</strong>

                  </address>
                  @endif
                </div>
                <!-- /.col -->
              </div>

            </section>

            <!-- Table row -->

                <div class="row">
                  <div class="col-xs-12 table">
                    <table class="table table-striped table tableresponsive">
                      <thead>
                        <tr>
                          <th style="text-align:center;" width="10%">Images</th>
                          <th style="text-align:left;">Product</th>
                          <th style="text-align:center;">Color</th>
                          <th style="text-align:center;">Size</th>
                          <th style="text-align:center;">Qty</th>
                          <th style="text-align:right;">Price</th>
                          <th style="text-align:right;">Sub Total</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach($detail as $details)
                          @if($details->order_id==$order->order_id)
                        <tr>
                          <td data-label="Images"><img src="{{asset($details->front_image)}}" width="100%"></td>
                          <td data-label="Product" style="text-align:left;"><p>{{$details->prod_name}}@if($details->prod_size ==! null) ({{$details->prod_size}}) @endif @if($details->prod_color ==! null)({{$details->prod_color}}) @endif</p></td>
                          <td data-label="Color" style="text-align:center;">{{$details->prod_color}}</td>
                          <td data-label="Size" style="text-align:center;">{{$details->prod_size}}</td>
                          <td data-label="Qty" style="text-align:center;">{{$details->detail_qty}}</td>
                          <td data-label="Price"style="text-align:right;">@if($details->detail_disc == 0 || $details->detail_disc==null ) <span class="price_format">{{$details->price_item}}</span>  @else  <del><span class="price_format">{{$details->price_item}}</span>/Unit </del><br> Discount {{$details->detail_disc}}% <br>  <span class="price_format">{{$details->detail_subtotal}}</span>/Unit  @endif</td>
                          <td data-label="Sub Total" style="text-align:right;"><?php $hit_subtotal=$details->detail_qty * $details->detail_subtotal; ?><span class="price_format">{{ $details->detail_subtotal }}</span> </td>
                        </tr>
                        @endif
                    @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

              <form action="{{url('backend/recent-order/'.$order->order_id)}}" method="post" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
              <input type="hidden"name="_method" value="PUT">

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-sm-8 invoice-col">
                    <h2>Shipping Information</h2>
                    <div class="col-sm-12 invoice-info" style="background-color:#f4f5f4;padding:0px;padding-top:15px;">
                       @if($order->dilivery_method=='ship')
                        <div class="col-sm-3 col-xs-12  invoice-col">
                            RESI NUMBER
                              <address>
                                <strong><input type="text" class="form-control" placeholder="No Resi" value="{{ $order->no_resi }}" name="no_resi" <?php if($order->order_status < 1){echo "readonly disabled"; } ?>></strong>
                              </address>
                        </div>
                       @endif

                        <div class="col-sm-3 col-xs-12  invoice-col">
                        @if($order->dilivery_method=='pick')
                            PICKUP DATE
                            <address>
                              <strong>   Date:   {{$order->pickup_date}} </strong>
                            </address>
                         @elseif($order->dilivery_method=='ship')
                             DELIVERY DATE

                              <address>
                                <strong> <input id="datepicker" class="date-picker form-control " value="{{$order->delivery_date}}" data-validation-format="yyyy-mm-dd" name="delivery_date" type="text"  <?php if($order->order_status < 1){echo "readonly disabled"; } ?>>
                                    <input type="hidden" name="" value="{{ $order->delivery_date }}" id="triggerdate"></strong>
                              </address>
                         @endif

                        </div>
                        <div class="col-sm-4 col-xs-12  invoice-col">
                        @if($order->dilivery_method=='pick')
                          PICKUP POINT
                           <address>
                            <strong>    City:   {{$pickup->city}} - {{$pickup->location}} </strong>
                          </address>
                          DETAILS ADDRESS
                            <address>
                            <strong>   {{$pickup->detail_location}}  </strong>
                           </address>
                          PHONE
                            <address>
                            <strong>  {{$pickup->pick_phone}} </strong>
                           </address>

                         @elseif($order->dilivery_method=='ship')
                           SHIPPING COURIER
                            <address>
                              <strong> {{$order->shipping_courier}} </strong>
                            </address>
                         @endif

                        </div>
                      <!-- /.col -->
                        <div class="col-sm-2 col-xs-12 invoice-col">
                         @if($order->dilivery_method=='pick')
                           PICKUP STATUS
                           <address>
                            <strong>@if($order->order_status==0) - @elseif($order->order_status==1)  Processing @elseif($order->order_status==2)  Ready to Pickup @elseif($order->order_status==3)  In Pickup  @elseif($order->order_status==4)  Completed(Send)  @elseif($order->order_status==5) <span class="label label-danger"> Canceled  </span>     @endif</strong>

                           </address>
                            @elseif($order->dilivery_method=='ship')
                            DELIVERY STATUS
                            <address>
                             <strong>  @if($order->order_status==0)
                                          <span class="label label-warning"> Pending </span>
                                       @elseif($order->order_status==1)
                                          <span class="label label-primary">  Processing </span>
                                        @elseif($order->order_status==2)
                                          <span class="label label-default"> Ready to Send </span>
                                        @elseif($order->order_status==3)
                                          <span class="label label-primary" style="background-color:#DA70D6"> In Delivery </span>
                                        @elseif($order->order_status==4) <span class="label label-success"> Completed(Send)  </span>
                                        @elseif($order->order_status==5) <span class="label label-danger"> Canceled  </span>   @endif </strong>

                            </address>
                            @endif
                        </div>
                      <!-- /.col -->
                      </div>
                    <!-- /.row -->

                  <div class="col-sm-12" style ="padding:0px; padding-top:10px;">
                    <div class="form-group">
                      <label class="control-label col-sm-3  "style ="padding:0px; ">Order Status
                      </label>
                      <div class="col-sm-9" style ="padding:0px; ">

                            <select class="selectpicker input-flat" data-live-search="true" name="order_status" required>
                                  <option value="" selected disabled>Select One</option>
                                  <option value="0" <?php if($order->order_status==0){echo 'selected="selected"';}?> data-tokens="">Pending</option>
                                  <option value="1"<?php if($order->order_status==1){echo 'selected="selected"';}?> data-tokens="">Processing</option>
                               @if($order->dilivery_method=='pick')
                                  <option value="2"<?php if($order->order_status==2){echo 'selected="selected"';}?> data-tokens="">Ready to Pickup </option>
                               @else
                                  <!-- <option value="2"<?php //if($order->order_status==2){echo 'selected="selected"';}?> data-tokens="">Ready to Send </option>
                                  <option value="3"<?php //if($order->order_status==3){echo 'selected="selected"';}?> data-tokens="">In Delivery</option> -->
                               @endif

                                  <option value="4"<?php if($order->order_status==4){echo 'selected="selected"';}?> data-tokens="">Completed(Send)</option>
                                  <option value="5"<?php if($order->order_status==5){echo 'selected="selected"';}?> data-tokens="">Canceled</option>
                            </select>

                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12" style ="padding:0px; padding-top:10px;">
                    <div class="form-group">
                      <label class="control-label col-sm-3  "style ="padding:0px; ">Manual Status Payment
                      </label>
                      <div class="col-sm-9" style ="padding:0px; ">

                            <select class="selectpicker input-flat" data-live-search="true" name="manaul_status_payment">
                                  <option value="0" <?php if($order->payment_status==0){echo 'selected="selected"';}?> data-tokens="">Waiting Payment</option>
                                  <option value="1"<?php if($order->payment_status==1){echo 'selected="selected"';}?> data-tokens="">Waiting Confirmation</option>
                                  <option value="2"<?php if($order->payment_status==2){echo 'selected="selected"';}?> data-tokens="">Accepted</option>
                                  <option value="3"<?php if($order->payment_status==3){echo 'selected="selected"';}?> data-tokens="">Failed</option>
                            </select>

                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 ">
                  <p class="lead">Summary Of Payment</p>

                  <!-- <div class="table-responsive"> -->
                    <table class="table"style="width: 100%;max-width: 100%;">
                      <tbody>
                        <tr>
                          <th style="width:50%">Subtotal</th>
                          <td style="text-align:right;"><span class="price_format">{{ $order->sub_total }}</span></td>
                        </tr>

                        @if(!empty($order->disc_cart))
                        <tr>
                          <th> Discount Shopping (-)</th>
                          <td style="text-align:right;"><span class="price_format">{{ $order->disc_cart }}</span></td>
                        </tr>
                        @endif
                        @if(!empty($order->order_disc))
                        <tr>
                          <th>Member Discount (-)</th>
                          <td style="text-align:right;"><span class="price_format">{{ $order->order_disc }}</span></td>
                        </tr>
                        @endif

                        @if($order->voucher_value !==null )
                        <tr>
                          <th>Voucher (-) ({{ $order->voucher_code }})</th>
                          <td style="text-align:right;"><span class="price_format">{{ $order->voucher_value }}</span></td>
                        </tr>
                        @endif
                        @if($order->disc_reward !==null )
                        <tr>
                          <th>Reward (-)</th>
                          <td style="text-align:right;"><span class="price_format">{{ $order->disc_reward }}</span></td>
                        </tr>
                        @endif

                        <tr>
                          <th>Shipping (+)</th>
                          <td style="text-align:right;">@if($order->shipping_cost == null)<span class="price_format">0</span> @endif<span class="price_format">{{ $order->shipping_cost }}</span></td>
                        </tr>
                        <tr>
                          <th>Payment Code (+)</th>
                          <td style="text-align:right;"><span class="price_format">{{ $order->payment_code }}</span></td>
                        </tr>
                        <!-- <tr>
                          <th>Service Charge (+)</th>
                          <td style="text-align:right;"><span class="price_format">@if ($order->service_cost ==null )0 @endif{{ $order->service_cost }}</span></td>
                        </tr> -->

                        <tr style="border-top: 1px solid #333; ">
                          <th>Grand Total:</th>
                          <th style="text-align:right;"><span class="price_format" style="color:#333">{{ $order->order_total }}</span></th>
                        </tr>
                      </tbody>
                    </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <!-- <p style="text-align:right"><span style="color:#B2203D;">Note</span>: 2 Numbers back of grand total is a unique code(<?php echo $order->order_generate;?>) for easy transaction.<p/> -->
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-sm-12">
                  <button class="btn btn-danger" type="button" onclick="printJS('printJS-form', 'html')"><i class="fa fa-print"></i> Print</button>
                  <button class="btn btn-success pull-right" type="submit"><i class="fa fa-credit-card"></i> Submit </button>
                  <a href="{{url('backend/recent-order')}}" class="btn btn-default pull-right">Back</a>
                </div>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- BEGIN HTML PRINT PDF--->
  <div style="display:none;">
     <div id="printJS-form">
          <div class="row" style="margin-bottom:20px;">
            <div class="col-xs-12 invoice-header">
              <h1>
                <i class="fa fa-globe"></i>Invoice : #{{$order->order_id}}
              </h1>
            </div>
            <!-- /.col -->
          </div>
          <div class="row invoice-info" style="background-color:#f4f5f4;">
            <div class="col-xs-6 invoice-col">
              DILIVERY METHOD
              <address>
                <strong> @if($order->dilivery_method=='ship') Sipping @elseif ($order->dilivery_method=='pick') Pickup   @endif </strong>
              </address>
            </div>
            <!-- /.col -->
            <div class="col-xs-6 invoice-col">
              PAYMENT:
              <address>
                <strong>@if($order->payment_service==2)Credit Card @else Bank Transfer @endif</strong>
              </address>
            </div>
            <!-- /.col -->
            <div class="col-xs-6 invoice-col">
              ORDER TOTAL
              <address>
                <strong><span class="price_format" style="color:#b2203d">{{ $order->order_total }}</span></strong>
              </address>
            </div>
            <div class="col-xs-6 invoice-col">
              PAYMENT STATUS
              <address>
                <strong>@if($order->payment_status==2)<span class="label label-success">Payments accepted </span>@elseif($order->payment_status==1)  <span class="label label-default">Waiting for confirmation of payment</span> @elseif($order->payment_status==3)  <span class="label label-danger">Failed</span> @else  <span class="label label-warning">Waiting for payment</span>  @endif</strong>
              </address>
            </div>

          </div>
          <!-- /.row -->
          <div class="row invoice-info">

            <div class="col-xs-6 invoice-col">

              @if($order->dilivery_method=='ship') SHIPPING ADDRESS @elseif ($order->dilivery_method=='pick')  ADDRESS  @endif

              <address>
                Name:  <strong>{{$order->customer_name}}</strong>
                <br>
                Email:    {{$order->customer_email}}
                <br>
                Phone:{{$order->customer_phone}}
                <br>
                Address: {{$order->customer_address}}, {{$order->order_district}}, {{$order->order_city}}, {{$order->order_province}}, Post:{{$order->order_poscode}}

              </address>

            </div>
            <!-- /.col -->
            <div class="col-xs-6 invoice-col">

              BILIING ADDRESS
              @if($order->bil_status==0)
              <address>
                Name: <strong>{{$order->billing_name}}</strong>
                <br>
                Email: {{$order->billing_email}}
                <br>
                Phone: {{$order->billing_phone}}
                <br>
                Address: {{$order->billing_address}}, {{$order->billing_district}}, {{$order->billing_city}}, {{$order->billing_province}}, Post:{{$order->billing_poscode}}
              </address>
              @else
              <address>
                <strong>Same as shipping address</strong>

              </address>
              @endif
            </div>
            <!-- /.col -->
          </div>
          <div class="row">
            <div class="col-xs-12 table">
              <table class="table table-striped table tableresponsive">
                <thead>
                  <tr>
                    <th style="text-align:center;" width="10%">Images</th>
                    <th style="text-align:left;">Product</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:center;">Price</th>
                    <th style="text-align:center;">Sub Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($detail as $details)
                  @if($details->order_id==$order->order_id)
                  <tr>
                    <td data-label="Images"><img src="{{asset($details->front_image)}}" width="100%"></td>
                    <td data-label="Product" style="text-align:left;"><p>{{$details->prod_name}} / {{$details->prod_code}} @if($details->prod_size ==! null) ({{$details->prod_size}}) @endif @if($details->prod_color ==! null)({{$details->prod_color}}) @endif</p></td>
                    <td data-label="Qty" style="text-align:center;">{{$details->detail_qty}}</td>
                    <td data-label="Price"style="text-align:right;">@if($details->detail_disc == 0 || $details->detail_disc==null ) <span class="price_format">{{$details->price_item}}</span>  @else  <del><span class="price_format">{{$details->price_item}}</span>/Unit </del><br> Discount {{$details->detail_disc}}% <br>  <span class="price_format">{{$details->detail_subtotal}}</span>/Unit  @endif</td>
                    <td data-label="Sub Total" style="text-align:right;"><?php $hit_subtotal=$details->detail_qty * $details->detail_subtotal; ?><span class="price_format">{{$hit_subtotal}}</span> </td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="col-xs-6" style="float:right">
                <div class="row">
                  <div class="col-xs-6">Subtotal </div>
                  <div class="col-xs-6" style="text-align:right"><span class="price_format">{{ $order->sub_total }}</span></div>
                </div>

                @if(!empty($order->disc_cart))
                <div class="row">
                  <div class="col-xs-6"> Discount Shopping (-)</div>
                  <div class="col-xs-6"  style="text-align:right"><span class="price_format">{{ $order->disc_cart }}</span></div>
                </div>
                @endif

                @if(!empty($order->order_disc))
                <div class="row">
                  <div class="col-xs-6">Member Discount (-)</div>
                  <div class="col-xs-6"  style="text-align:right"><span class="price_format">{{ $order->order_disc }}</span></div>
                </div>
                @endif

                @if($order->voucher_value !==null )
                <div class="row">
                  <div class="col-xs-6">Voucher (-) ({{ $order->voucher_code }})</div>
                  <div class="col-xs-6"><span class="price_format">{{ $order->voucher_value }}</span></div>
                </div>
                @endif
                @if($order->disc_reward !==null )
                <div class="row">
                  <div class="col-xs-6">Reward (-)</div>
                  <div class="col-xs-6"  style="text-align:right"><span class="price_format">{{ $order->disc_reward }}</span></div>
                </div>
                @endif

                <div class="row">
                  <div class="col-xs-6">Shipping (+)</div>
                  <div class="col-xs-6" style="text-align:right">@if($order->shipping_cost == null)<span class="price_format">0</span> @endif<span class="price_format">{{ $order->shipping_cost }}</span></div>
                </div>

                <div class="row">
                  <div class="col-xs-6"><b>Grand Total:</b></div>
                  <div class="col-xs-6" style="text-align:right"><b><span class="price_format" style="color:#333">{{ $order->order_total }}</span></b></div>
                </div>
          </div>
          <!-- /.row -->
      </div>
      <div class="row">
        <div class="col-xs-12 invoice-info" style="background-color:#f4f5f4;padding:0px;">
             <div class="col-xs-12 invoice-col">  <h3>Shipping Information</h3></div>
           @if($order->dilivery_method=='ship')
            @if($order->no_resi !==null)
            <div class="col-xs-6 invoice-col" >
                NUMBER RESI
                  <address>
                    <strong>{{ $order->no_resi }}</strong>
                  </address>
            </div>
            @endif
           @endif


            @if($order->dilivery_method=='pick')
              @if($order->pickup_date !==null)
               <div class="col-xs-6 invoice-col">
                PICKUP DATE
                <address>
                  <strong> Date: {{$order->pickup_date}} </strong>
                </address>
              </div>
              @endif
             @elseif($order->dilivery_method=='ship')
                @if($order->delivery_date !==null)
                 <div class="col-xs-6 invoice-col">
                     DELIVERY DATE
                      <address>
                        <strong>{{$order->delivery_date}}</strong>
                      </address>
                  </div>
                  @endif
             @endif


            <div class="col-xs-6 invoice-col">
            @if($order->dilivery_method=='pick')
              PICKUP POINT
               <address>
                <strong>    City:   {{$pickup->city}} - {{$pickup->location}} </strong>
              </address>
              DETAILS ADDRESS
                <address>
                <strong>   {{$pickup->detail_location}}  </strong>
               </address>
              PHONE
                <address>
                <strong>  {{$pickup->pick_phone}} </strong>
               </address>

             @elseif($order->dilivery_method=='ship')
               SHIPPING COURIER
                <address>
                  <strong> {{$order->shipping_courier}} </strong>
                </address>
             @endif

            </div>
          <!-- /.col -->
            <div class="col-xs-6 invoice-col">
             @if($order->dilivery_method=='pick')
               PICKUP STATUS
               <address>
                <strong>@if($order->order_status==0) - @elseif($order->order_status==1)  Processing @elseif($order->order_status==2)  Ready to Pickup @elseif($order->order_status==3)  In Pickup  @elseif($order->order_status==4)  Completed(Send)  @elseif($order->order_status==5) <span class="label label-danger"> Canceled  </span>     @endif</strong>

               </address>
                @elseif($order->dilivery_method=='ship')
                DILIVERY STATUS
                <address>
                 <strong>
                    @if($order->order_status==0)
                      <span class="label label-warning"> pending </span>
                    @elseif($order->order_status==1)
                      <span class="label label-primary">  Processing </span>
                    @elseif($order->order_status==2)
                      <span class="label label-default"> Ready to Send </span>
                    @elseif($order->order_status==3)
                      <span class="label label-primary" style="background-color:#DA70D6"> In Delivery </span>
                    @elseif($order->order_status==4) <span class="label label-success"> Completed(Send)  </span>
                    @elseif($order->order_status==5) <span class="label label-danger"> Canceled  </span>   @endif </strong>
                </address>
                @endif
            </div>
          <!-- /.col -->
          </div>
        <!-- /.row -->
      </div>
    </div>
  </div>
  <!-- END HTML PRINT PDF--->
@endsection
