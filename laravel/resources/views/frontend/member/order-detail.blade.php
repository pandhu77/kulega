@extends('frontend/member/menu')
@section('isi')

<style>
    .tab-content {
        margin-top: 50px;
    }
    .nav-pills {
        /*background-color: #f4f5f4;*/
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


/*Start Wizard*/

.bootstrapWizard {
    display: block;
    list-style: none;
    padding: 0;
    position: relative;
    width: 100%
}

.bootstrapWizard a:hover,.bootstrapWizard a:active,.bootstrapWizard a:focus {
    text-decoration: none
}

.bootstrapWizard li {
    display: block;
    float: left;
    width: 25%;
    text-align: center;
    padding-left: 0
}

.bootstrapWizard li:before {
    border-top: 3px solid #55606E;
    content: "";
    display: block;
    font-size: 0;
    overflow: hidden;
    position: relative;
    top: 11px;
    right: 1px;
    width: 100%;
    z-index: 1
}

.bootstrapWizard li:first-child:before {
    left: 50%;
    max-width: 50%
}

.bootstrapWizard li:last-child:before {
    max-width: 50%;
    width: 50%
}

.bootstrapWizard li.complete .step {
    background: #0aa66e;
    padding: 1px 6px;
    border: 3px solid #55606E
}

.bootstrapWizard li .step i {
    font-size: 10px;
    font-weight: 400;
    position: relative;
    top: -1.5px
}

.bootstrapWizard li .step {
    background: #B2B5B9;
    color: #fff;
    display: inline;
    font-size: 15px;
    font-weight: 700;
    line-height: 12px;
    padding: 7px 13px;
    border: 3px solid transparent;
    border-radius: 50%;
    line-height: normal;
    position: relative;
    text-align: center;
    z-index: 2;
    transition: all .1s linear 0s
}

.bootstrapWizard li.active .step,.bootstrapWizard li.active.complete .step {
    background: #0091d9;
    color: #fff;
    font-weight: 700;
    padding: 7px 13px;
    font-size: 15px;
    border-radius: 50%;
    border: 3px solid #55606E
}

.bootstrapWizard li.complete .title,.bootstrapWizard li.active .title {
    color: #2B3D53
}

.bootstrapWizard li .title {
    color: #bfbfbf;
    display: block;
    font-size: 13px;
    line-height: 15px;
    max-width: 100%;
    position: relative;
    table-layout: fixed;
    text-align: center;
    top: 20px;
    word-wrap: break-word;
    z-index: 104
}

.wizard-actions {
    display: block;
    list-style: none;
    padding: 0;
    position: relative;
    width: 100%
}

.wizard-actions li {
    display: inline
}

.tab-content.transparent {
    background-color: transparent
}
#clockdiv{
	color: #b2203d;
	display: inline-block;
	font-weight: 100;
	text-align: center;
	font-size: 20px;
}
#expdiv{
 color: #b2203d;
}

#clockdiv > div{
	padding: 10px;
	border-radius: 3px;
  background: rgba(226, 220, 221, 0.3);
	display: inline-block;
}

#clockdiv div > span{
	padding: 15px;
	border-radius: 3px;
	 background: rgba(226, 220, 221, 0.9);
	display: inline-block;
}

.smalltext{
	padding-top: 5px;
	font-size: 16px;
}

/*End Wizard*/

</style>
<title>{{web_name()}} | Order Detail</title>
<div class="col-md-9 box-right">
<h2 style="margin-top:-10px;">Order <span style="color:#B2203D">Detail</span> </h2>
<hr>
  <div class="tab-content">

      <!-- First tab -->
      <div class="tab-pane active" id="basic-tab">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <!-- <h4>  <i class="icon fa fa-check"></i> Alert!</h4> -->
                {{ Session::get('success') }}
            </div>
            @endif
       @if(Session::get('error_get'))
         <div class="alert alert-danger col-md-12 col-sm-12">
           <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
           {{ Session::get('error_get') }}</div>
       @endif


          <section class="content invoice" style="margin-bottom: 10px;">
            <!-- info row -->
            <div class="row">
              <div class="col-xs-12 invoice-header">
                <h1>
                    <i class="fa fa-globe"></i> Invoice #{{$row->order_id}}
                    <small class="pull-right">Date: <?php echo date("l, d F Y H:i",strtotime( $row->order_date));?></small>
                </h1>


              </div>
              <div class="col-xs-12 invoice-header"style="text-align:center;">
                  @if($row->payment_status <= 1)  <p  style="color:#f0ad4e;">Please make the payment at the latest on  <?php echo date("d F Y H:i",strtotime( $row->date_exp));?></p><br>@endif
              </div>
              <div class="col-xs-12 invoice-header"style="text-align:center;">
                  @if($row->payment_status == 0 or $row->payment_status == '')<p id="expdate"></p>@endif
              </div>

              <!-- /.col -->
            </div>

            <div class="row invoice-info" style="background-color:#f4f5f4;">

              <div class="col-sm-4 col-xs-12  invoice-col">
               DILIVERY METHOD
                <address>
                  <strong> @if($row->dilivery_method=='ship') Sipping @elseif ($row->dilivery_method=='pick') Pickup   @endif </strong>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 col-xs-12 invoice-col">

                PAYMENT: @if($row->payment_service==2)CREDIT CARD @else BANK TRANSFER @endif
                <address>
                    <strong>@if($row->payment_status==2)<span class="label label-success">Payments accepted </span>@elseif($row->payment_status==1)  <span class="label label-warning">Waiting for confirmation</span> @elseif($row->payment_status==3)  <span class="label label-danger">Cancelled</span> @else  <span class="label label-warning">Waiting for payment</span>  @endif</strong>

                </address>


              </div>
              <!-- /.col -->
              <div class="col-sm-4 col-xs-12 invoice-col">
                ORDER TOTAL
                <address>
                  <strong><span class="price_format" style="color:#b2203d">{{ $row->order_total }}</span></strong>
                </address>
              </div>

            </div>
            <!-- /.row -->
            <div class="row invoice-info">

              <div class="col-sm-6 col-xs-6  invoice-col">

                @if($row->dilivery_method=='ship') SHIPPING ADDRESS @elseif ($row->dilivery_method=='pick')  ADDRESS  @endif

                <address>
                  <strong>{{$row->customer_name}}</strong>
                  <br>
                  {{$row->customer_email}}
                  <br>
                  {{$row->customer_phone}}
                  <br>
                  {{$row->customer_address}}, {{$row->order_district}}, {{$row->order_city}}, {{$row->order_province}}, Post:{{$row->order_poscode}}
                </address>

              </div>
              <!-- /.col -->
              <div class="col-sm-6 col-xs-6 invoice-col">

                BILIING ADDRESS
                @if($row->bil_status==0)
                <address>
                  <strong>{{$row->billing_name}}</strong>
                  <br>
                  {{$row->billing_email}}
                  <br>
                  {{$row->billing_phone}}
                  <br>
                  {{$row->billing_address}}, {{$row->billing_district}}, {{$row->billing_city}}, {{$row->billing_province}}, Post:{{$row->billing_poscode}}
                </address>
                @else
                <address>
                  <strong>Same as shipping address</strong>

                </address>
                @endif
              </div>
              <!-- /.col -->



            </div>

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

                          <td data-label="Product" style="text-align:left;"><p>{{$details->prod_name}}@if($details->prod_size ==! null) ({{$details->prod_size}}) @endif @if($details->prod_color ==! null)({{$details->prod_color}}) @endif</p></td>
                          <td data-label="Qty" style="text-align:center;">{{$details->detail_qty}}</td>
                          <td data-label="Price"style="text-align:right;">
                            @if($details->detail_disc == 0 || $details->detail_disc==null ) <span class="price_format">{{$details->price_item}}</span>
                            @else  <del><span class="price_format">{{$details->price_item}}</span> </del><br>
                               @if($details->detail_disc <= 100){{$details->detail_disc}}%  @else <span class="price_format">{{$details->detail_disc}} @endif OFF</span>
                               <br>  <span class="price_format" style="color:#B2203D;font-weight:bold;"  >{{$details->detail_subtotal}}</span>
                           @endif</td>

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

            <div class="row">
             <!-- accepted payments column -->
             <div class="col-sm-7">
               <p class="lead">Payment Methods: @if($row->payment_service==1) (Transfer Via Bank)  @elseif ($row->payment_service==2) (Credit Card) @endif  </p>

               <div id="bank-detail" class="" style="<?php if($row->payment_service == 1){ ?>display:block;<?php }else{ echo "display:none";} ?>">
                 @foreach($bank as $banks)
                    <div class="col-sm-12 "style="padding-right:0px;padding-left:0px;border: 1px solid #ddd; border-radius:0px; margin-bottom:15px;padding-bottom:10px;">
                       <div class=" text-muted well well-sm no-shadow"style="padding-right:5px;padding-left:5px;border-bottom: 1px solid #ddd; border-radius:0px; padding-top:0px;padding-bottom:0px;">
                            <img src="{{asset($banks->bank_image)}}" style="width: 80px;"><br>
                        </div>
                        <div class="" style="text-align: left; margin-top: -15px;padding-left:10px; padding-right:10px;">
                            &nbsp;<span><b>{{$banks->bank_name}}:</b></span>
                            &nbsp; <span>{{$banks->bank_noreg}} </span><span class="hidden-lg hidden-sm"><br></span>
                            &nbsp;<b>Holder:</b>&nbsp;   <span>{{$banks->bank_holder}}</span><br>
                            &nbsp;<b>Detail:</b>&nbsp;   <span>{{$banks->bank_desc}}</span>
                            <br>
                        </div>

                   </div>
                 @endforeach



               </div>
               <!-- <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                 Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
               </p> -->
             </div>
             <!-- /.col -->
             <div class="col-sm-5">
               <p class="lead">Summary Of Payment</p>

               <!-- <div class="table-responsive"> -->
                 <table class="table"style="width: 100%;max-width: 100%;">
                   <tbody>
                     <tr>
                       <th style="width:50%">Subtotal</th>
                       <td style="text-align:right;"><span class="price_format">{{ $row->sub_total }}</span></td>
                     </tr>
                   @if(!empty($row->disc_cart))
                     <tr>
                       <th>Discount Shipping(-)</th>
                       <td style="text-align:right;"><span class="price_format">{{ $row->disc_cart }}</span></td>
                     </tr>
                   @endif
                   @if(!empty($row->order_disc))
                     <tr>
                       <th>Member Discount (-)</th>
                       <td style="text-align:right;"><span class="price_format">{{ $row->order_disc }}</span></td>
                     </tr>
                    @endif

                     @if($row->voucher_value !==null )
                     <tr>
                       <th>Voucher(-)</th>
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
                       <th style="text-align:right;"><span class="price_format" style="color:#333">{{ $row->order_total }}</span></th>
                     </tr>
                   </tbody>
                 </table>
               <!-- </div> -->
             </div>
             <!-- /.col -->
           </div>
           <!-- /.row -->
            <p style="text-align:right"><span style="color:#B2203D;">Note</span>: 2 Numbers back of grand total is a unique code(<?php echo $row->order_generate;?>) for easy transaction.<p/>

           <div class="row invoice-info" style="background-color:#f4f5f4;margin-bottom:50px;">

               <div class="col-sm-6 col-xs-12  invoice-col">
                @if($row->dilivery_method=='ship')
                     RESI NUMBER
                    <address>
                     <strong>@if($row->no_resi==null) - @else {{$row->no_resi}} @endif</strong>
                   </address>
                 @endif
               </div>


              <!-- /.col -->
              <div class="col-sm-6 col-xs-12 invoice-col">
               @if($row->dilivery_method=='pick')
                  ORDER STATUS
                 <address>
                  <strong>@if($row->order_status==0) - @elseif($row->order_status==1)  Processing @elseif($row->order_status==2)  Ready to Pickup @elseif($row->order_status==3)  In Pickup  @elseif($row->order_status==4)  Completed(Send)  @elseif($row->order_status==5) <span class="label label-danger"> Canceled  </span>     @endif</strong>

                 </address>
                  @elseif($row->dilivery_method=='ship')
                  ORDER STATUS
                  <address>
                   <strong>@if($row->order_status==0) - @elseif($row->order_status==1)  Processing @elseif($row->order_status==2)  Ready to Send @elseif($row->order_status==3)  In Delivery  @elseif($row->order_status==4)  Completed(Send)  @elseif($row->order_status==5) <span class="label label-danger"> Canceled  </span>     @endif</strong>

                  </address>
                  @endif
              </div>
              <!-- /.col -->
          </div>

          <div class="row invoice-info" style="background-color:#f4f5f4;margin-bottom:50px;">

            <div class="col-sm-6 col-xs-12  invoice-col">
            @if($row->dilivery_method=='pick')
                PICKUP DATE
                <address>
                  <strong>   Date:   {{$row->pickup_date}} </strong>
                </address>
             @elseif($row->dilivery_method=='ship')
                 DELIVERY DATE
                  <address>
                    <strong> @if($row->delivery_date==null) @else <?php echo date("d F Y",strtotime( $row->delivery_date));?>@endif </strong>
                  </address>
             @endif

            </div>
            <div class="col-sm-6 col-xs-12  invoice-col">
            @if($row->dilivery_method=='pick')
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


             @elseif($row->dilivery_method=='ship')
               SHIPPING COURIER
                <address>
                  <strong> {{$row->shipping_courier}} </strong>
                </address>
             @endif

            </div>

          </div>

           <!-- /.row -->
           <div class="row invoice-info" style="margin-bottom:50px;">
             <div class="<?php if($row->dilivery_method=='pick') {?>col-sm-8 col-md-push-3<?php }else{?> col-md-12  <?php }?> invoice-col ">
               <ul class="bootstrapWizard form-wizard">
                 <li <?php if($row->order_status==1) {?>class="active"<?php }?> data-target="#step1">

                   <a href="#tab1"> <span class="step"><i class="fa fa-spinner" aria-hidden="true"></i></span> <span class="title">Processing</span> </a>
                 </li>
                 <li data-target="#step2" <?php if($row->order_status==2) {?>class="active"<?php }?>>
                   <a href="#tab2">  <span class="step">  @if($row->dilivery_method=='ship')<i class="fa fa-paper-plane-o" aria-hidden="true"></i> @else <i class="fa fa-university" aria-hidden="true"></i> @endif </span> <span class="title">Ready to    @if($row->dilivery_method=='ship')Send @else  Pickup   @endif</span> </a>
                 </li>
                 @if($row->dilivery_method=='ship')
                 <li data-target="#step3" <?php if($row->order_status==3) {?>class="active"<?php }?>>
                   <a href="#tab3"> <span class="step"><i class="fa fa-bus" aria-hidden="true"></i></span> <span class="title">In   @if($row->dilivery_method=='ship') Delivery  @else Pickup @endif</span> </a>
                 </li>
                 @endif
                 <li data-target="#step4" <?php if($row->order_status==4) {?>class="active"<?php }?>>
                   <a href="#tab4"> <span class="step"><i class="fa fa-check-square-o" aria-hidden="true"></i></span> <span class="title">Completed(Send)</span> </a>
                 </li>
               </ul>
             </div>
             <!-- /.col -->
           </div>
           <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-xs-12" style="text-align:right">
                <!-- <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button> -->
                <div class="btn-group">
                    <a href="{{url('user/order')}}" class="btn  btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Back"><i class="fa fa-share"></i> Back</a>
                    @if($row->order_status==0 || $row->order_status==null and $row->payment_service == 1)
                    <a href="{{ url('user/order/payment-confirmation/'.$row->order_id)}}"style="" class="btn btn-warning pull-right"><i class="fa fa-shopping-cart"> Payment Confirmation</i></a>
                    @endif
                    @if($row->payment_service == 2 and $row->payment_status==0 )
                    <a href="{{url('payment/make-payment/'.$row->order_id)}}"class="btn btn-warning pull-right"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Make Payment</a>
                    @endif
                </div>

              </div>
            </div>
          </section>

      </div>
  </div>
</div>
<input type="hidden" id="month" value="<?php echo date("m",strtotime( $row->date_exp));?>">
<input type="hidden" id="day" value="<?php echo date("d",strtotime( $row->date_exp));?>">
<input type="hidden" id="thn" value="<?php echo date("Y",strtotime( $row->date_exp));?>">
<input type="hidden" id="hours" value="<?php echo date("H",strtotime( $row->date_exp));?>">
<input type="hidden" id="minutes" value="<?php echo date("i",strtotime( $row->date_exp));?>">
<input type="hidden" id="seconds" value="<?php echo date("s",strtotime( $row->date_exp));?>">
<script>
// Set the date we're counting down to

var  intmonth = $('#month').val();
var  intday = $('#day').val();
var  intthn = $('#thn').val();
var  inthours = $('#hours').val();
var  intminutes = $('#minutes').val();
var  intseconds = $('#seconds').val();

var countDownDate = new Date(intmonth +","+ intday + ","+ intthn + ","+ inthours +":"+ intminutes +":"+ intseconds).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Output the result in an element with id="demo"
    $('#expdate').html(
      '<div id="clockdiv">'+
      '  <div>'+
      '  <span class="days">'+ days +'</span>'+
      '  <div class="smalltext">Days</div>'+
      '  </div>'+
      '  <div>'+
      '    <span class="hours">'+ hours +'</span>'+
      '    <div class="smalltext">Hours</div>'+
      '  </div>'+
      '  <div>'+
      '    <span class="minutes">'+ minutes +'</span>'+
      '    <div class="smalltext">Minutes</div>'+
      '  </div>'+
      '  <div>'+
      '    <span class="seconds">'+ seconds +'</span>'+
      '  <div class="smalltext">Seconds</div>'+
      '</div>'+
      '</div>'
    );
    // document.getElementById("expdate").innerHTML = days + "d " + hours + "h "
    // + minutes + "m " + seconds + "s ";

    // If the count down is over, write some text
    if (distance < 0) {
        clearInterval(x);
        $('#expdate').html(
          '<div id="expdiv">'+
            'EXPIRED'+
          '</div>'
        );
    }
}, 1000);
</script>

@endsection
