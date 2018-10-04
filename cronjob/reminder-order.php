<?php

require 'PHPMailer/PHPMailerAutoload.php';

$servername = "localhost";
$username   = "admin_iama";
$password   = "iama123";
$dbname     = "admin_iama";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//check order yang exp
// $datenow = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
// $datenow->format('Y-m-d H:i:s');
$datesekarang = time();
// $datenow    = date('Y-m-d H:i:s', strtotime('+7 hours', $datesekarang));
$datenow    = date('Y-m-d H:i:s');
$site       = "SELECT * FROM cms_config limit 1";
$siteex     = $conn->query($site);
$url        = 'http://iamaddicted.id';

$order_exp  = "SELECT * FROM sum_orders JOIN ms_members ON ms_members.member_id = sum_orders.member_id WHERE order_status = 0 AND payment_status = 0 AND order_generate = 0";
$check_order_exp = $conn->query($order_exp);

 if ($check_order_exp->num_rows > 0) {
    foreach ($check_order_exp as $key => $exp) {

        // echo 'Jam Sekarang : '.$datenow.'<br>';
        // echo 'Jam Order : '.date('Y-m-d H:i:s',strtotime($exp['order_date'].'+1 days')).'<br>';
        // echo 'Jam Order : '.date('Y-m-d H:i:s',strtotime($exp['order_date'].'+21 hours')).'<br>';
        // exit;

        if ($datenow >= date('Y-m-d H:i:s',strtotime($exp['order_date'].'+21 hours'))) {

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
                                        Hi <b>'.$exp['billing_name'].'</b>,
                                        <p style="font-size:14px;">
                                            This is an automatic reminder about your order ID #'.$exp['order_id'].' <br>
                                            is about to expire in 3 hours. <br>
                                            We`re wondering if you`re still interested. <br>
                                            <br>
                                            Please follow the instruction as follow :
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
                                        <td style="text-align:left;">'.$exp['order_id'].'</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left; width:30%">Order Date</th>
                                        <td style="text-align:left;">'.date("l, d F Y H:i",strtotime($exp['order_date'])).'</td>
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

                    $order_detail  = "SELECT * FROM tmp_order_detail JOIN ms_products ON ms_products.prod_id = tmp_order_detail.prod_id";
                    $check_order_det = $conn->query($order_detail);

                     if ($check_order_det->num_rows > 0) {
                        foreach($check_order_det as $details){
                            if($details['order_id']==$exp['order_id']){
                            $html .= '   <tr>
                                            <td data-label="" style="padding-bottom:5px;min-width:100px;">
                                                <img src="'.$url.'/'.$details['front_image'].'" width="100%">
                                            </td>
                                            <td class="td-product" data-label="Products from  your Order" >
                                                <div class="isi-card" style="">
                                                    <p style="font-weight:bold;">'.$details['prod_name'].'</p>
                                                    <p>Quantity: '.$details['detail_qty'].'</p>
                                                </div>
                                            </td>
                                                <td data-label="Sub Total" style="text-align:right;">
                                                <p><b> IDR '.number_format($details['detail_subtotal'],0,",",".").'</p> </b>
                                            </td>
                                        </tr>';
                                }
                            }
                        }
            $html .= ' </tbody>
                    </table>

                    <table class="table table-payment"style=" width: 100% ">
                        <tbody>
                            <tr>
                                <th style="text-align:left; width:50%;font-weight: 100;">Subtotal</th>
                                <td style="text-align:right;">IDR '.number_format($exp['sub_total'],0,",",".").'</td>
                            </tr>
                            <tr>
                                <th  style="text-align:left; width:50%;font-weight: 100;">Shipping(+)</th>
                                <td style="text-align:right;">IDR '.number_format($exp['shipping_cost'],0,",",".").'</td>
                            </tr>
                            <tr>
                                <th  style="text-align:left; width:50%;font-weight: 100;">Voucher(-)</th>';

                                $vouchercode = "SELECT * FROM ms_voucher WHERE voucher_code = ".$exp['voucher_code'];
                                $check_voc = $conn->query($vouchercode);

                                 if ($check_voc->num_rows > 0) {
                                    foreach($check_voc as $voc){
                                        if($voc['voucher_type'] == 2){
                                            $html .= '<td style="text-align:right;">'.number_format($voc['voucher_value'],0,",",".").' %</td>';
                                        } else {
                                            $html .= '<td style="text-align:right;">IDR '.number_format($voc['voucher_value'],0,",",".").'</td>';
                                        }
                                    }
                                }else {
                                    $html .= '<td style="text-align:right;">IDR '.number_format($voc['voucher_value'],0,",",".").'</td>';
                                }

            $html .= '      </tr>';
                            if($exp['payment_service'] == 2){
            $html .= '      <tr>
                                <th  style="text-align:left; width:50%;font-weight: 100;">CC Charge(+3%)</th>
                                <td style="text-align:right;">IDR '.number_format($exp['disc_reward'],0,",",".").'</td>';
                            }
            $html .= '      <tr>
                                <th  style="text-align:left; width:50%;font-weight: 100;">Payment Code(+)</th>
                                <td style="text-align:right;">IDR '.number_format($exp['payment_code'],0,",",".").'</td>
                            </tr>
                            <tr style="border-top: 1px solid #333;">
                                <th  style="text-align:left; width:50%"><span>Grand Total:</span></th>
                                <th style="text-align:right;"> <span>IDR '.number_format($exp['order_total'],0,",",".").'</span></th>
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

                                    if ($exp['payment_service'] == 1) {
                                        $html .= 'Bank Transfer';
                                    } else {
                                        $html .= 'Midtrans';
                                    }

            $html .=                '<br>
                                    Shipping / Courier : '.$exp['shipping_courier'].'
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
                                    '.$exp['billing_address'].'<br>
                                    '.$exp['billing_district'].'<br>
                                    '.$exp['billing_city'].'<br>
                                    '.$exp['billing_province'].'<br>
                                    '.$exp['billing_poscode'].'<br>
                                </td>
                                <td style="font-size:14px;">
                                    <p style="font-size:16px;font-weight:600;">Delivery Address</p>
                                    '.$exp['customer_address'].'<br>
                                    '.$exp['order_district'].'<br>
                                    '.$exp['order_city'].'<br>
                                    '.$exp['order_province'].'<br>
                                    '.$exp['order_poscode'].'<br>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="innerpadding borderbottom" style="padding-bottom:0px;">
                    <table class="col380" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom:20px;">';

                    $bank = "SELECT * FROM ms_bank WHERE bank_enable = 1";
                    $check_bank = $conn->query($bank);

                     if ($check_bank->num_rows > 0) {
                    foreach ($check_bank as $banks) {
                    $html .= '   <tr>
                                    <td style="padding-bottom:20px;font-family: sans-serif">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr style="background-color:#ddd">
                                                <td class="bodycopy" style="padding:10px;">
                                                    <img src="'.$url.'/'.$banks['bank_image'].'" width="50px">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0 0 0;font-size:12px;">
                                                    <b>Bank Name:</b> '.$banks['bank_name'].'  &nbsp;   &nbsp;  <b> Acc Number:</b>  '.$banks['bank_noreg'].'   &nbsp;   &nbsp;   <b>Acc Holder:  </b>  '.$banks['bank_holder'].'
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>';
                            }
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
                        <a href="'.$url.'/user/order/payment-confirmation/'.$exp['order_id'].'" target="_blank" style="background-color: #000;color: #fff;text-decoration: none;padding: 10px;">CONFIRM PAYMENT</a>
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
                                  Sonia
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;text-decoration:none !important;">
                                Email : hello@iamaddicted.id | Phone : +6287777300879 |  Line : @iamaddicted
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

          	$mail = new PHPMailer;

    		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

    		$mail->isSMTP();                                      // Set mailer to use SMTP
    		$mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    		$mail->SMTPAuth   = true;                               // Enable SMTP authentication
    		$mail->Username   = 'hello@iamaddicted.id';                 // SMTP username
    		$mail->Password   = 'iama123456';                           // SMTP password
    		$mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
    		$mail->Port       = 587;                                    // TCP port to connect to

    		$mail->setFrom('hello@sonia.co.id', 'Sonia');


    		$mail->addAddress($exp['customer_email'], '');     // Add a recipient


    		// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    		$mail->isHTML(true);                                  // Set email format to HTML

    		$mail->Subject = 'Payment Reminder - You still have 3 hours left. '.$datenow;
    		$mail->Body    = $html;
    		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    		if(!$mail->send()) {
    		    echo 'Message could not be sent.';
    		    echo 'Mailer Error: ' . $mail->ErrorInfo;
    		} else {
                $updateorder= "UPDATE sum_orders SET order_generate = 1 WHERE order_id = ".$exp['order_id'];
                $exeupdate  = $conn->query($updateorder);
              echo 'Message has been sent<br>';
    		}
        } else {
            echo "passed";
        }
    }

 }else{
     echo "0 results";
 }
$conn->close();

?>
