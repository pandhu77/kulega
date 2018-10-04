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

$order_exp  = "SELECT * FROM sum_orders JOIN ms_members ON ms_members.member_id = sum_orders.member_id  WHERE order_status = 0 AND payment_status = 0";
$check_order_exp = $conn->query($order_exp);

 if ($check_order_exp->num_rows > 0) {
    foreach ($check_order_exp as $key => $exp) {

        // echo 'Jam Sekarang : '.$datenow.'<br>';
        // echo 'Jam Order : '.date('Y-m-d H:i:s',strtotime($exp['order_date'].'+1 days')).'<br>';
        // exit;

        if ($datenow >= date('Y-m-d H:i:s',strtotime($exp['order_date'].'+1 days'))) {

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
                                <p>Hi '.$exp['customer_name'].',</p>
                                <p>
                                 Your order #'.$exp['order_id'].' has been cancelled automatically <br>
                                 because you have not confirmed the payment in the past 1x24 hours.
                                </p>
                                <p>
                                  1. If you have already transferred the amount, <br>
                                  please create a new order and confirm the payment immediately.
                                </p>
                                <p style="font-weight:600">
                                  2. If you still get this e-mail after you have completed the payment, <br>
                                  please contact our customer care by email: hello@iamaddicted.id
                                </p>
                                <p style="padding-top:50px;">
                                    Kind regards, <br>
                                    Customer Care Team
                                </p>

                                </td>
                               </tr>


                      <tr>
                          <td class="footer " bgcolor="#fff" style="background-color:#fff;color:#000;">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                      <td align="center" class="footercopy" style="color:#000;font-size:12px;">
                                             I AM ADDICTED - Your Beauty Tools Partner
                                      </td>
                                  </tr>
                                  <tr>
                                      <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;text-decoration:none !important;">
                                          Email : hello@iamaddicted.id | Phone : +6287777300879 |  Line : @iamaddicted
                                      </td>
                                  </tr>
                                  <tr>
                                      <td align="center" class="footercopy" style="color:#000;padding-top:15px;font-size:12px;">
                                          #IAABabes
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

    		$mail->Subject = 'Order has been canceled '.$datenow;
    		$mail->Body    = $html;
    		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    		if(!$mail->send()) {
    		    echo 'Message could not be sent.';
    		    echo 'Mailer Error: ' . $mail->ErrorInfo;
    		} else {
                $tmporder = "SELECT * FROM tmp_order_detail where order_id = ".$exp['order_id'];
                $check_tmporder = $conn->query($tmporder);
               if ($check_tmporder->num_rows > 0) {
                    foreach($check_tmporder as  $detail ){

                       $prodid= $detail['prod_id'];
                       $color = $detail['prod_color'];
                       $size  = $detail['prod_size'];
                       $qty   = $detail['detail_qty'];

                       if($prodid !=='' && $color=='' && $size ==''){

                                $stockprod="SELECT * FROM ms_products WHERE prod_id = $prodid";
                                $checkstock = $conn->query($stockprod);
                                       if ($checkstock->num_rows > 0) {
                                          foreach ($checkstock as $key => $stocks) {
                                            ///tambah stock
                                          $newstock   = $stocks["prod_stock"] + $qty;
                                          $updatestock= "UPDATE ms_products SET prod_stock = $newstock WHERE prod_id = $prodid";
                                          $exeupdate  = $conn->query($updatestock);

                                          $updatestatus = "UPDATE sum_orders SET order_status = 5, payment_status = 3 WHERE order_id =".$exp['order_id'];
                                          $exestatus=$conn->query($updatestatus);
                                          }
                                       }else{
                                        echo "0 results";
                                       }
                       }
                    }
               }

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
