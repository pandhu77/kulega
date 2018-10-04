<?php
  use Illuminate\Support\Str;
  class HelperEmail{

        //   BARANG KIRIM
          static function emailNotifikasi($row ,$members,$status){
              if(count($row)>0){
                $detail=DB::table('tmp_order_detail')
                        ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                        ->get();
              }

            $bank=DB::table('ms_bank')->where('bank_enable','=',1)->get();
            $site= DB::table('cms_config')->first();
            $social=DB::table('cms_socialmedia')->where('enable',1)->get();

            $url=urldomain();
            if(count($row) >0){

                $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sonia</title>
        <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        img {height: auto;}
        .content {width: 100%; max-width: 600px;}
        .header {padding: 20px 20px 20px 20px;}
        .innerpadding {padding: 30px 30px 30px 30px;}
        .borderbottom {border-bottom: 2px solid #fef2f2;}
        .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
        .h1, .h2, .bodycopy {color: #000; font-family: sans-serif;}
        .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
        .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
        .bodycopy {font-size: 15px; line-height: 22px;}
        .button {text-align: center; font-size: 15px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
        .button a {color: #ffffff; text-decoration: none;}
        .footer {padding: 30px;}
        .footercopy {font-family: sans-serif; font-size: 15px; color: #000;}
        .footercopy a {color: #000; text-decoration: none;}

        .table-striped {
            background-color: #fff;
            border: 1px solid #ddd;
            border-spacing: 0px;
        }
        .table-striped {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
        .table-striped > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            padding-top:5px;
            padding-bottom:0px;
            padding-left:5px;
            padding-right: 5px;
            font-size: 15px;
            line-height: 1.42857143;
            vertical-align: top;
            border: 0px solid #fff;
        }
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #000;
        }
        .table-striped > tbody > tr >td{
            border: 0px;
        }

        .black-none a{
            text-decoration:none;
            color:black;
        }

        @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
            body[yahoo] .hide {display: none!important;}
            body[yahoo] .buttonwrapper {background-color: transparent!important;}
            body[yahoo] .button {padding: 0px!important;}
            body[yahoo] .button a {background-color: #b2203d; padding: 15px 15px 13px!important;}
            body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}

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
                font-size: 15px;
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
            .table-payment{
                width: 100%;max-width: 100%;float:right
            }

        }

        /*@media only screen and (min-device-width: 601px) {
        .content {width: 600px !important;}
        .col425 {width: 425px!important;}
        .col380 {width: 380px!important;}
        }*/



        </style>
    </head>

    <body yahoo bgcolor="#fbf7ee">
        <table width="100%" bgcolor="#fbf7ee" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td bgcolor="#fff" class="header" style="background-color:#fff;text-align:center;padding-left: 0px;padding-right: 0px;padding-top: 0px;">
                                <img class="fix" src="'.$url.'/assets/img/banners/banner.jpg" width="100%"   border="0" alt="" style="margin:auto;"/>
                            </td>
                        </tr>

                        <tr>
                            <td bgcolor="#fff" class="header borderbottom" style="background-color:#fff;text-align:center;">
                                <img class="fix" src="'.$url.'/assets/img/logo/sonia-logo.png" width="130px;"   border="0" alt="" style="margin:auto;"/>
                            </td>
                        </tr>

                        <tr>
                          <td class="bodycopy borderbottom" style="padding-left:20px;padding-right:20px;font-size:14px;text-align:center;padding-bottom:40px">
                          <p>Hi '.$members.',</p>
                          <p class="black-none">
                            Great news! <br>
                            Your order #'.$row->order_id.' has been dispatched.
                          </p>
                          <p>
                            The tracking details of your order is as follows:
                          </p>
                          <p style="font-weight:600">
                            '.$row->no_resi.'
                          </p>
                          <p>
                            For local deliver, your order will reach you in 2 – 4 business days <br>
                            from now. You may check the delivery status <a href="http://sicepat.com/cek-resi" style="font-weight:600;text-decoration:none;color:#000;">here</a>.
                          </p>
                          <p>
                            Please allow some time for the shipment status to be updated.
                          </p>
                          <p>
                            Thank you for shopping with I Am Addicted!
                          </p>

                          </td>
                         </tr>


                <tr>
                    <td class="footer " bgcolor="#fff" style="background-color:#fff;color:#000;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" class="footercopy" style="color:#000;font-size:12px;">
                                      SONIA
                                </td>
                            </tr>
                            <tr>
                                <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;text-decoration:none !important;">
                                    Email : '.$site->email.' | Phone : '.$site->telp.' |  '.$site->address.'
                                </td>
                            </tr>
                            <tr>
                                <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;">
                                    #Sonia
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td bgcolor="#fff" class="header" style="background-color:#fff;text-align:center;padding-left: 0px;padding-right: 0px;padding-bottom: 0px;">
                        <img class="fix" src="'.$url.'/assets/img/banners/banner.jpg" width="100%"   border="0" alt="" style="margin:auto;"/>
                    </td>
                </tr>
            </table>
        </body>
    </html>
    ';

            return $html;
          }
          }

        //   CHECK OUT
           static function emailOrder($orderid){
             $row=DB::table('sum_orders')->where('sum_orders.order_id','=',$orderid)->first();
             if(count($row)>0){
               $detail=DB::table('tmp_order_detail')
                       ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                       ->get();
               $pickup=DB::table('sum_orders')
                       ->leftjoin('tmp_pickup','sum_orders.pickup_point','=','tmp_pickup.id')
                       ->join('ms_pickup','ms_pickup.pick_id','=','tmp_pickup.pick_id')
                       ->where('sum_orders.order_id','=',$orderid)
                       ->first();
             }
             $bank=DB::table('ms_bank')->where('bank_enable','=',1)->get();
             $site= DB::table('cms_config')->first();
             $social=DB::table('cms_socialmedia')->where('enable',1)->get();
             $vouchercode = DB::table('ms_voucher')->where('voucher_code',$row->voucher_code)->first();
             $url=urldomain();

            $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>IamAddicted</title>
    <style type="text/css">
    body {margin: 0; padding: 0; min-width: 100%!important;}
    img {height: auto;}
    .content {width: 100%; max-width: 600px;}
    .header {padding: 20px 20px 20px 20px;}
    .innerpadding {padding: 30px 30px 30px 30px;}
    .borderbottom {border-bottom: 2px solid #fef2f2;}
    .subhead {font-size: 16px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
    .h1, .h2, .bodycopy {color: #000; font-family: sans-serif;}
    .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
    .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
    .bodycopy {font-size: 14px; line-height: 22px;}
    .button {text-align: center; font-size: 14px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
    .button a {color: #ffffff; text-decoration: none;}
    .footer {padding: 30px;}
    .footercopy {font-family: sans-serif; font-size: 12px; color: #000;}
    .footercopy a {color: #000; text-decoration: none;}

    .table-striped {
        background-color: #fff;
        border: 1px solid #ddd;
        border-spacing: 0px;
    }
    .table-striped {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }
    .table-striped > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding-top:5px;
        padding-bottom:0px;
        padding-left:5px;
        padding-right: 5px;
        font-size: 14px;
        line-height: 1.42857143;
        vertical-align: top;
        border: 0px solid #fff;
    }
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
    .table-striped > tbody > tr >td{
        border: 0px;
    }
    .header-top a{
        text-decoration: none;
        color:#000;
    }

    @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
        body[yahoo] .hide {display: none!important;}
        body[yahoo] .buttonwrapper {background-color: transparent!important;}
        body[yahoo] .button {padding: 0px!important;}
        body[yahoo] .button a {background-color: #b2203d; padding: 15px 15px 13px!important;}
        body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}

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
            font-size: 14px;
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
        .table-payment{
            width: 100%;max-width: 100%;float:right
        }

    }

    /*@media only screen and (min-device-width: 601px) {
    .content {width: 600px !important;}
    .col425 {width: 425px!important;}
    .col380 {width: 380px!important;}
    }*/



    </style>
</head>

<body yahoo bgcolor="#fbf7ee">
    <table width="100%" bgcolor="#fbf7ee" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td bgcolor="#fff" class="header" style="background-color:#fff;text-align:center;padding-left: 0px;padding-right: 0px;padding-top: 0px;">
                        <img class="fix" src="'.$url.'/assets/img/banners/banner.jpg" width="100%"   border="0" alt="" style="margin:auto;"/>
                    </td>
                </tr>

                <tr>
                    <td bgcolor="#fff" class="header borderbottom" style="background-color:#fff;text-align:center;">
                        <img class="fix" src="'.$url.'/assets/img/logo/sonia-logo.png" width="130px;"   border="0" alt="" style="margin:auto;"/>
                    </td>
                </tr>
                    <tr style="text-align:center;">
                        <td class="bodycopy innerpadding borderbottom">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="" style="font-size:16px;">
                                        Hi <b>'.$row->billing_name.'</b>,
                                        <p style="font-size:14px;">
                                            Thank you for shopping with us! <br>
                                            Here’s the summary of your order and payment instruction <br>
                                        </p>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class=" bodycopy innerpadding borderbottom">
                            <table class="table header-top" style="width:100%;margin-left:-5px;">
                                <tbody>
                                    <tr>
                                        <th  style="text-align:left; width:30%">No Invoice</th>
                                        <td style="text-align:left;">'.$row->order_id.'</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left; width:30%">Order Date</th>
                                        <td style="text-align:left;">'.date("l, d F Y H:i",strtotime( $row->order_date)).'</td>
                                    </tr>

                                </tbody>
                            </table>

                        </td>
                    </tr>
        <tr>
            <td class="bodycopy innerpadding borderbottom">
                <table class="table table-striped table tableresponsive" style="margin-top:15px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;" width="10%"></th>
                            <th style="text-align:left;padding-top:15px;padding-bottom:15px;" width="">Products from your order</span></th>
                            <th style="text-align:right;padding-top:15px;padding-bottom:15px;padding-right:15px;">Price</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($detail as $details){
                        if($details->order_id==$row->order_id){
                $html .= '   <tr>
                                <td data-label="" style="padding-bottom:5px;min-width:100px;">
                                    <img src="'.$url.'/'.$details->front_image.'" width="100%">
                                </td>
                                <td class="td-product" data-label="Products from  your Order" >
                                    <div class="isi-card" style="">
                                        <p style="font-weight:bold;">'.$details->prod_name.'</p>
                                        <p>Quantity: '.$details->detail_qty.'</p>
                                        <p>Color: '.$details->prod_color.'</p>
                                        <p>Size: '.$details->prod_size.'</p>
                                    </div>
                                </td>
                                    <td data-label="Sub Total" style="text-align:right;">
                                    <p><b> IDR '.number_format($details->detail_subtotal,0,",",".").'</p> </b>
                                </td>
                            </tr>';
                            }
                        }
            $html .= ' </tbody>
                    </table>

                    <table class="table table-payment"style=" width: 100% ">
                        <tbody>
                            <tr>
                                <th style="text-align:left; width:50%;font-weight: 100;">Subtotal</th>
                                <td style="text-align:right;">IDR '.number_format($row->sub_total,0,",",".").'</td>
                            </tr>
                            <tr>
                                <th  style="text-align:left; width:50%;font-weight: 100;">Shipping(+)</th>
                                <td style="text-align:right;">IDR '.number_format($row->shipping_cost,0,",",".").'</td>
                            </tr>
                            <tr>
                                <th  style="text-align:left; width:50%;font-weight: 100;">Voucher(-)</th>';
                                if(count($vouchercode) > 0){
                                    if($vouchercode->voucher_type == 2){
                                        $html .= '<td style="text-align:right;">'.number_format($row->voucher_value,0,",",".").' %</td>';
                                    } else {
                                        $html .= '<td style="text-align:right;">IDR '.number_format($row->voucher_value,0,",",".").'</td>';
                                    }
                                } else {
                                    $html .= '<td style="text-align:right;">IDR '.number_format($row->voucher_value,0,",",".").'</td>';
                                }

            $html .= '      </tr>';
                            if($row->payment_service == 2){
            $html .= '      <tr>
                              <th  style="text-align:left; width:50%;font-weight: 100;">CC Charge(+3%)</th>
                              <td style="text-align:right;">IDR '.number_format($row->disc_reward,0,",",".").'</td>
                            </tr>';
                            }
            $html .= '      <tr>
                                <th  style="text-align:left; width:50%;font-weight: 100;">Payment Code(+)</th>
                                <td style="text-align:right;">IDR '.number_format($row->payment_code,0,",",".").'</td>
                            </tr>
                            <tr style="border-top: 1px solid #333;">
                                <th  style="text-align:left; width:50%"><span>Grand Total:</span></th>
                                <th style="text-align:right;"> <span>IDR '.number_format($row->order_total,0,",",".").'</span></th>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td class=" bodycopy innerpadding borderbottom" style="padding-top:15px;text-align:left;">
                    <table class="table table-payment" style="width: 100%">
                        <tbody>
                            <tr>
                                <td style="font-size:14px;">
                                    <p style="font-size:16px;font-weight:600;">Payment & Shipping Information</p>
                                    Payment : ';

                                    if ($row->payment_service == 1) {
                                        $html .= 'Bank Transfer';
                                    } else {
                                        $html .= 'Midtrans';
                                    }

            $html .=                '<br>
                                    Shipping / Courier : '.$row->shipping_courier.'
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td class=" bodycopy innerpadding borderbottom" style="padding-top:15px;text-align:left;">
                    <table class="table table-payment" style="width: 100%">
                        <tbody>
                            <tr>
                                <td style="font-size:14px;">
                                    <p style="font-size:16px;font-weight:600;">Billing Address</p>
                                    '.$row->billing_address.'<br>
                                    '.$row->billing_district.'<br>
                                    '.$row->billing_city.'<br>
                                    '.$row->billing_province.'<br>
                                    '.$row->billing_poscode.'<br>
                                </td>
                                <td style="font-size:14px;">
                                    <p style="font-size:16px;font-weight:600;">Delivery Address</p>
                                    '.$row->customer_address.'<br>
                                    '.$row->order_district.'<br>
                                    '.$row->order_city.'<br>
                                    '.$row->order_province.'<br>
                                    '.$row->order_poscode.'<br>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="innerpadding borderbottom" style="padding-bottom:0px;">
                    <table class="col380" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom:20px;">';
                    foreach ($bank as $banks) {
            $html .= '   <tr>
                            <td style="padding-bottom:20px;font-family: sans-serif">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr style="background-color:#ddd">
                                        <td class="bodycopy" style="padding:10px;">
                                            <img src="'.$url.'/'.$banks->bank_image.'" width="50px">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px 0 0 0;font-size:12px;">
                                            <b>Bank Name:</b> '.$banks->bank_name.'  &nbsp;   &nbsp;  <b> Acc Number:</b>  '.$banks->bank_noreg.'   &nbsp;   &nbsp;   <b>Acc Holder:  </b>  '.$banks->bank_holder.'
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>';
                    }
    $html .= '      </table>
                </td>
            </tr>

            <tr>
                <td class=" bodycopy innerpadding borderbottom" style="padding-top:15px;text-align:center;">
                    <!-- We will verify your transaction for a minimum of 24 hours. If you need assistance, please call the contact below. -->
                    <p style="font-size:14px;">
                    <strong>If you have made payment via credit/debit card, please ignore this email.</strong><br>
                    If you choose to pay with bank transfer, please wire transfer the amount owed within 24 hours from the transaction time.<br>
                    Once the payment is completed, please continue by clicking the button below to confirm your payment:<br>
                    </p>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <a href="'.$url.'/user/order/payment-confirmation/'.$row->order_id.'" target="_blank" style="background-color: #000;color: #fff;text-decoration: none;padding: 10px;">CONFIRM PAYMENT</a>
                    </table>
                    <p style="font-size:14px;">
                    If our system does not receive any confirmation within 24 hours,<br>
                    the transaction will be automatically cancelled.
                    </p>
                </td>
            </tr>

            <tr>
                <td class="footer " bgcolor="#fff" style="background-color:#fff;color:#000;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;font-size:12px;">
                                  SONIA
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;text-decoration:none !important;">
                                Email : '.$site->email.' | Phone : '.$site->telp.' |  '.$site->address.'
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;">
                                #Sonia
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td bgcolor="#fff" class="header" style="background-color:#fff;text-align:center;padding-left: 0px;padding-right: 0px;padding-bottom: 0px;">
                    <img class="fix" src="'.$url.'/assets/img/banners/banner.jpg" width="100%"   border="0" alt="" style="margin:auto;"/>
                </td>
            </tr>

        </table>
    </body>
</html>
';

            return $html;
           }
           static function emailForgotPassword($email,$code){
            $site= DB::table('cms_config')->first();
            $social=DB::table('cms_socialmedia')->where('enable',1)->get();
            $url=urldomain();
            $html ='
            <!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> -->
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
              <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
              <title>E-Commerce Djaring.id</title>
              <style type="text/css">
              body {margin: 0; padding: 0; min-width: 100%!important;}
              img {height: auto;}
              .content {width: 100%; max-width: 600px;}
              .header {padding: 10px 10px 10px 10px;}
              .innerpadding {padding: 30px 30px 30px 30px;}
              .borderbottom {border-bottom: 1px solid #f2eeed;}
              .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
              .h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
              .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
              .h2 {padding: 0 0 15px 0; font-size: 18px; line-height: 28px; font-weight: bold;}
              .bodycopy {font-size: 13px; line-height: 20px;}
              .button {text-align: center; font-size: 15px; font-family: sans-serif; font-weight: bold; padding: 0 15px 0 15px;}
              .button a {color: #ffffff; text-decoration: none;}
              .footer {padding: 20px 30px 15px 30px;}
              .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
              .footercopy a {color: #ffffff; text-decoration: underline;}

              @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
              body[yahoo] .hide {display: none!important;}
              body[yahoo] .buttonwrapper {background-color: transparent!important;}
              body[yahoo] .button {padding: 0px!important;}
              body[yahoo] .button a {background-color: #b2203d; padding: 15px 15px 13px!important;}
              body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
              }
              </style>
            </head>

            <body yahoo bgcolor="#f6f8f1">
            <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>
                <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td style="background-color:#b2203d;" class="header">
                      <img class="fix" src="'.$url.'/'.$site->logo.'" width="150px;"  border="0" alt="" style="margin:auto;"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="innerpadding borderbottom">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="h2">
                          Welcome to '.$site->site_name.'
                          </td>
                        </tr>
                        <tr>
                          <td class="bodycopy">

                          <p>Dear '.$email.' , </p>
                          <p>To continue the process to change your password, please click on the link below to proceed</p>
                          </td>
                        </tr>
                        <tr>
                          <td style="padding: 20px 0 0 0;">
                            <table class="buttonwrapper" bgcolor="#b2203d" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td class="button" height="35">
                                  <a href="'.$url.'/user/reset-password/'.$code.'">Reset Password</a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td class="footer" bgcolor="#fff">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="center" class="footercopy" style="color:#153643">
                            Adresss:'.$site->address.' Website: <a href="'.$site->domain.'"><font color="#b2203d">'.$site->domain.'</font></a>,<br/>

                            <span class="hide">Telp. 021-0303-3434 Email . <a href="mailto:'.$site->email.'"><font color="#b2203d">'.$site->email.'</font></a></span>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" style="padding: 20px 0 0 0;">
                            <table border="0" cellspacing="0" cellpadding="0">
                              <tr>';


                            $html.='
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
                </td>
              </tr>
            </table>
            </body>
            </html>
            ';
          return $html;
          }

          static function emailRegistration($memberid,$fullname,$activation_code,$passworduser){
            $site= DB::table('cms_config')->first();
            $social=DB::table('cms_socialmedia')->where('enable',1)->get();
            $url=urldomain();

            $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>IamAddicted</title>
    <style type="text/css">
    body {margin: 0; padding: 0; min-width: 100%!important;}
    img {height: auto;}
    .content {width: 100%; max-width: 600px;}
    .header {padding: 20px 20px 20px 20px;}
    .innerpadding {padding: 30px 30px 30px 30px;}
    .borderbottom {border-bottom: 2px solid #fef2f2;}
    .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
    .h1, .h2, .bodycopy {color: #000; font-family: sans-serif;}
    .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
    .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
    .bodycopy {font-size: 15px; line-height: 22px;}
    .button {text-align: center; font-size: 15px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
    .button a {color: #ffffff; text-decoration: none;}
    .footer {padding: 30px;}
    .footercopy {font-family: sans-serif; font-size: 15px; color: #000;}
    .footercopy a {color: #000; text-decoration: none;}

    .table-striped {
        background-color: #fff;
        border: 1px solid #ddd;
        border-spacing: 0px;
    }
    .table-striped {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }
    .table-striped > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding-top:5px;
        padding-bottom:0px;
        padding-left:5px;
        padding-right: 5px;
        font-size: 15px;
        line-height: 1.42857143;
        vertical-align: top;
        border: 0px solid #fff;
    }
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #000;
    }
    .table-striped > tbody > tr >td{
        border: 0px;
    }



    @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
        body[yahoo] .hide {display: none!important;}
        body[yahoo] .buttonwrapper {background-color: transparent!important;}
        body[yahoo] .button {padding: 0px!important;}
        body[yahoo] .button a {background-color: #b2203d; padding: 15px 15px 13px!important;}
        body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}

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
            font-size: 15px;
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
        .table-payment{
            width: 100%;max-width: 100%;float:right
        }

    }

    /*@media only screen and (min-device-width: 601px) {
    .content {width: 600px !important;}
    .col425 {width: 425px!important;}
    .col380 {width: 380px!important;}
    }*/



    </style>
</head>

<body yahoo bgcolor="#fbf7ee">
    <table width="100%" bgcolor="#fbf7ee" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td bgcolor="#fff" class="header" style="background-color:#fff;text-align:center;padding-left: 0px;padding-right: 0px;padding-top: 0px;">
                            <img class="fix" src="'.$url.'/assets/img/banners/banner.jpg" width="100%"   border="0" alt="" style="margin:auto;"/>
                        </td>
                    </tr>

                    <tr>
                        <td bgcolor="#fff" class="header borderbottom" style="background-color:#fff;text-align:center;">
                            <img class="fix" src="'.$url.'/assets/img/logo/sonia-logo.png" width="130px;"   border="0" alt="" style="margin:auto;"/>
                        </td>
                    </tr>

                    <tr>
                      <td class="bodycopy" style="padding-left:20px;padding-right:20px;font-size:14px;text-align:center;">
                      <p>Dear Customer, </p>
                      <p>
                      Thanks for signing in '.$site->site_name.'<br>
                      Your account has now been created. <br>
                      Your account is :<br>
                      Email : '.$memberid.'<br>
                      Password : '.$passworduser.'<br>
                      You can log in by using your email address and password <br>
                      at our website <a href="'.url('').'">'.url('').'</a> or simply click the button below:
                      </p>

                      </td>
                     </tr>

                <tr>
                   <td class="borderbottom" style="padding: 20px;text-align:center;padding-bottom:50px;">
                     <a href="'.$url.'/user/activation/'.$activation_code.'" style="color: #fff;background-color: #000;text-decoration: none;padding: 10px 20px;">
                      Activation Here
                     </a>
                   </td>
                 </tr>


            <tr>
                <td class="footer " bgcolor="#fff" style="background-color:#fff;color:#000;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;font-size:12px;">
                                  SONIA
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;text-decoration:none !important;">
                                Email : '.$site->email.' | Phone : '.$site->telp.' |  '.$site->address.'
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;">
                                #Sonia
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td bgcolor="#fff" class="header" style="background-color:#fff;text-align:center;padding-left: 0px;padding-right: 0px;padding-bottom: 0px;">
                    <img class="fix" src="'.$url.'/assets/img/banners/banner.jpg" width="100%"   border="0" alt="" style="margin:auto;"/>
                </td>
            </tr>
        </table>
    </body>
</html>
';
          return $html;

          }

        //   CONTACT EMAIL
        static function emailcontact($message){

            $bank=DB::table('ms_bank')->where('bank_enable','=',1)->get();
            $site= DB::table('cms_config')->first();
            $social=DB::table('cms_socialmedia')->where('enable',1)->get();
            $url=urldomain();

                $html='
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>E-Commerce Djaring.id</title>
                <style type="text/css">
                body {margin: 0; padding: 0; min-width: 100%!important;}
                img {height: auto;}
                .content {width: 100%; max-width: 900px;}
                .header {padding: 20px 20px 20px 20px;}
                .innerpadding {padding: 30px 30px 30px 30px;}
                .borderbottom {border-bottom: 1px solid #f2eeed;}
                .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
                .h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
                .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
                .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
                .bodycopy {font-size: 16px; line-height: 22px;}
                .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
                .button a {color: #ffffff; text-decoration: none;}
                .footer {padding: 20px 30px 15px 30px;}
                .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
                .footercopy a {color: #ffffff; text-decoration: underline;}

                .table-striped {
                    background-color: #fff;
                    border: 1px solid #ddd;
                    border-spacing: 0px;
                }
                .table-striped {
                    width: 100%;
                    max-width: 100%;
                    margin-bottom: 20px;
                }
                .table-striped > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
                    padding-top:5px;
                    padding-bottom:0px;
                    padding-left:5px;
                    padding-right: 5px;
                    font-size: 12px;
                    line-height: 1.42857143;
                    vertical-align: top;
                    border: 0px solid #fff;
                }
                .table-striped > tbody > tr:nth-of-type(odd) {
                    background-color: #f9f9f9;
                }
                .table-striped > tbody > tr >td{
                    border: 0px;
                }



                @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
                    body[yahoo] .hide {display: none!important;}
                    body[yahoo] .buttonwrapper {background-color: transparent!important;}
                    body[yahoo] .button {padding: 0px!important;}
                    body[yahoo] .button a {background-color: #b2203d; padding: 15px 15px 13px!important;}
                    body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}

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
                    .table-payment{
                        width: 100%;max-width: 100%;float:right
                    }

                }

                /*@media only screen and (min-device-width: 601px) {
                    .content {width: 600px !important;}
                    .col425 {width: 425px!important;}
                    .col380 {width: 380px!important;}
                }*/



                </style>
                </head>

                <body yahoo bgcolor="#f6f8f1">
                <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
                <tr>
                <td>
                <!--[if (gte mso 9)|(IE)]>
                <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                <td>
                <![endif]-->
                <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                <td bgcolor="#fff" class="header">
                <img class="fix" src="'.$url.'/'.$site->logo.'" width="150px;"  border="0" alt="" style="margin:auto;"/>
                <!--[if (gte mso 9)|(IE)]>
                <table width="425" align="left" cellpadding="0" cellspacing="0" border="0">
                <tr>
                <td>
                <![endif]-->

                <!--[if (gte mso 9)|(IE)]>
                </td>
                </tr>
                </table>
                <![endif]-->
                </td>
                </tr>
                <tr>
                <td class=" bodycopy innerpadding borderbottom">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>

                </tr>
                <tr>
                <td class="">

                <p>'.$message.'</p>

                </td>
                </tr>

                </table>
                </td>
                </tr>
                <tr>
                <td class="footer " bgcolor="#fff">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td align="center" class="footercopy" style="color:#153643">
                Adresss:'.$site->address.' Website: <a href="'.$site->domain.'"><font color="#b2203d">'.$site->domain.'</font></a>,<br/>

                <span class="hide">Telp. 021-0303-3434 Email . <a href="mailto:'.$site->email.'"><font color="#b2203d">'.$site->email.'</font></a></span>
                </td>
                </tr>
                <tr>
                <td align="center" style="padding: 20px 0 0 0;">
                <table border="0" cellspacing="0" cellpadding="0">
                <tr>';


                $html.='
                </tr>
                </table>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                </table>
                </body>
                </html>

                ';
                return $html;
        }

        // PAYMENT CONFIRM
        static function paymentnotif($order_id,$memberid){
            $member = DB::table('ms_members')->where('member_id',$memberid)->first();
            $row=DB::table('sum_orders')->where('order_id',$order_id)->first();
            $detail=DB::table('tmp_order_detail')
                    ->leftjoin('ms_products','ms_products.prod_id','=','tmp_order_detail.prod_id')
                    ->get();
            $bank=DB::table('ms_bank')->where('bank_enable','=',1)->get();
            $site= DB::table('cms_config')->first();
            $social=DB::table('cms_socialmedia')->where('enable',1)->get();
            $url=urldomain();

            $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>IamAddicted</title>
    <style type="text/css">
    body {margin: 0; padding: 0; min-width: 100%!important;}
    img {height: auto;}
    .content {width: 100%; max-width: 600px;}
    .header {padding: 20px 20px 20px 20px;}
    .innerpadding {padding: 30px 30px 30px 30px;}
    .borderbottom {border-bottom: 2px solid #fef2f2;}
    .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
    .h1, .h2, .bodycopy {color: #000; font-family: sans-serif;}
    .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
    .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
    .bodycopy {font-size: 15px; line-height: 22px;}
    .button {text-align: center; font-size: 15px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
    .button a {color: #ffffff; text-decoration: none;}
    .footer {padding: 30px;}
    .footercopy {font-family: sans-serif; font-size: 15px; color: #000;}
    .footercopy a {color: #000; text-decoration: none;}

    .table-striped {
        background-color: #fff;
        border: 1px solid #ddd;
        border-spacing: 0px;
    }
    .table-striped {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }
    .table-striped > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding-top:5px;
        padding-bottom:0px;
        padding-left:5px;
        padding-right: 5px;
        font-size: 15px;
        line-height: 1.42857143;
        vertical-align: top;
        border: 0px solid #fff;
    }
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #000;
    }
    .table-striped > tbody > tr >td{
        border: 0px;
    }



    @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
        body[yahoo] .hide {display: none!important;}
        body[yahoo] .buttonwrapper {background-color: transparent!important;}
        body[yahoo] .button {padding: 0px!important;}
        body[yahoo] .button a {background-color: #b2203d; padding: 15px 15px 13px!important;}
        body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}

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
            font-size: 15px;
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
        .table-payment{
            width: 100%;max-width: 100%;float:right
        }

    }

    /*@media only screen and (min-device-width: 601px) {
    .content {width: 600px !important;}
    .col425 {width: 425px!important;}
    .col380 {width: 380px!important;}
    }*/



    </style>
</head>

<body yahoo bgcolor="#fbf7ee">
    <table width="100%" bgcolor="#fbf7ee" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td bgcolor="#fff" class="header" style="background-color:#fff;text-align:center;padding-left: 0px;padding-right: 0px;padding-top: 0px;">
                            <img class="fix" src="'.$url.'/assets/img/banners/banner.jpg" width="100%"   border="0" alt="" style="margin:auto;"/>
                        </td>
                    </tr>

                    <tr>
                        <td bgcolor="#fff" class="header borderbottom" style="background-color:#fff;text-align:center;">
                            <img class="fix" src="'.$url.'/assets/img/logo/sonia-logo.png" width="130px;"   border="0" alt="" style="margin:auto;"/>
                        </td>
                    </tr>

                    <tr>
                      <td class="bodycopy borderbottom" style="padding-left:20px;padding-right:20px;font-size:14px;text-align:center;">
                      <p>Hi '.$member->member_fullname.',</p>
                      <p style="text-align: center;color: #000;">
                      Thank you for confirming your payment. <br>
                      We will check the details and process your order soon. <br>
                      You will receive a confirmation e-mail within the next 48 – 72 hours. <br>
                      It will contain information about the airway bill to help you <br>
                      check the shipping status of your order.
                      </p>

                      </td>
                     </tr>


            <tr>
                <td class="footer " bgcolor="#fff" style="background-color:#fff;color:#000;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;font-size:12px;">
                                  SONIA
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;text-decoration:none !important;">
                                Email : '.$site->email.' | Phone : '.$site->telp.' |  '.$site->address.'
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;">
                                #Sonia
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td bgcolor="#fff" class="header" style="background-color:#fff;text-align:center;padding-left: 0px;padding-right: 0px;padding-bottom: 0px;">
                    <img class="fix" src="'.$url.'/assets/img/banners/banner.jpg" width="100%"   border="0" alt="" style="margin:auto;"/>
                </td>
            </tr>
        </table>
    </body>
</html>
';

            return $html;
        }


        // PAYMENT CONFIRM
        static function contactnotif($name,$email,$phone,$subject,$message){
            $bank=DB::table('ms_bank')->where('bank_enable','=',1)->get();
            $site= DB::table('cms_config')->first();
            $social=DB::table('cms_socialmedia')->where('enable',1)->get();
            $url=urldomain();

            $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>IamAddicted</title>
        <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        img {height: auto;}
        .content {width: 100%; max-width: 600px;}
        .header {padding: 20px 20px 20px 20px;}
        .innerpadding {padding: 30px 30px 30px 30px;}
        .borderbottom {border-bottom: 2px solid #fef2f2;}
        .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
        .h1, .h2, .bodycopy {color: #000; font-family: sans-serif;}
        .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
        .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
        .bodycopy {font-size: 15px; line-height: 22px;}
        .button {text-align: center; font-size: 15px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
        .button a {color: #ffffff; text-decoration: none;}
        .footer {padding: 30px;}
        .footercopy {font-family: sans-serif; font-size: 15px; color: #000;}
        .footercopy a {color: #000; text-decoration: none;}

        .table-striped {
        background-color: #fff;
        border: 1px solid #ddd;
        border-spacing: 0px;
        }
        .table-striped {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
        }
        .table-striped > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding-top:5px;
        padding-bottom:0px;
        padding-left:5px;
        padding-right: 5px;
        font-size: 15px;
        line-height: 1.42857143;
        vertical-align: top;
        border: 0px solid #fff;
        }
        .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #000;
        }
        .table-striped > tbody > tr >td{
        border: 0px;
        }



        @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
        body[yahoo] .hide {display: none!important;}
        body[yahoo] .buttonwrapper {background-color: transparent!important;}
        body[yahoo] .button {padding: 0px!important;}
        body[yahoo] .button a {background-color: #b2203d; padding: 15px 15px 13px!important;}
        body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}

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
            font-size: 15px;
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
        .table-payment{
            width: 100%;max-width: 100%;float:right
        }

        }

        /*@media only screen and (min-device-width: 601px) {
        .content {width: 600px !important;}
        .col425 {width: 425px!important;}
        .col380 {width: 380px!important;}
        }*/



        </style>
        </head>

        <body yahoo bgcolor="#fbf7ee">
        <table width="100%" bgcolor="#fbf7ee" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td bgcolor="#fff" class="header" style="background-color:#fff;text-align:center;padding-left: 0px;padding-right: 0px;padding-top: 0px;">
                            <img class="fix" src="'.$url.'/assets/img/banners/banner.jpg" width="100%"   border="0" alt="" style="margin:auto;"/>
                        </td>
                    </tr>

                    <tr>
                        <td bgcolor="#fff" class="header borderbottom" style="background-color:#fff;text-align:center;">
                            <img class="fix" src="'.$url.'/assets/img/logo/sonia-logo.png" width="130px;"   border="0" alt="" style="margin:auto;"/>
                        </td>
                    </tr>

                    <tr>
                      <td class="bodycopy borderbottom" style="padding-left:20px;padding-right:20px;font-size:14px;text-align:center;">
                      <p>You Got New Message,</p>
                      <p style="text-align: center;color: #000;">
                      Name : '.$name.' <br>
                      Email : '.$email.' <br>
                      Phone : '.$phone.' <br>
                      Subject : '.$subject.' <br>
                      Message : '.$message.' <br>
                      </p>

                      </td>
                     </tr>


            <tr>
                <td class="footer " bgcolor="#fff" style="background-color:#fff;color:#000;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;font-size:12px;">
                                  SONIA
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;text-decoration:none !important;">
                                Email : '.$site->email.' | Phone : '.$site->telp.' |  '.$site->address.'
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;">
                                #Sonia
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td bgcolor="#fff" class="header" style="background-color:#fff;text-align:center;padding-left: 0px;padding-right: 0px;padding-bottom: 0px;">
                    <img class="fix" src="'.$url.'/assets/img/banners/banner.jpg" width="100%"   border="0" alt="" style="margin:auto;"/>
                </td>
            </tr>
        </table>
        </body>
        </html>
        ';

            return $html;
        }

    }
