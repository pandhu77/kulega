

<?php


    // include ("vendor/PHPMailer/class.phpmailer.php");
    //       include ("vendor/PHPMailer/class.smtp.php");
          require 'vendor/PHPMailer/PHPMailerAutoload.php';

               //PHPMailer Object
               $mail = new PHPMailer;
               // whereas if using SMTP you would have
               $mail->isSMTP();
               //Set SMTP host name
               $mail->Host = " srv2.niagahoster.com";
               //Set this to true if SMTP host requires authentication to send email
               $mail->SMTPAuth = true;
               //Provide username and password
               $mail->Username = "system@vakanesia.com";
               $mail->Password = "123456";
               //If SMTP requires TLS encryption then set it
               $mail->SMTPSecure = "ssl";
               //Set TCP port to connect to
               $mail->Port = 465;

               $mail->From = "system@vakanesia.com";
               $mail->FromName = "Vakanesia";

               $mail->addAddress("febrielven@gmail.com");

               $mail->isHTML(true);

               $mail->Subject = "test vakanesia";
               $mail->Body = "apa kabar";
               $mail->AltBody = "ini link anda plan";

               if(!$mail->send())
               {
                   echo "gagal";
                   echo "Mailer Error: " . $mail->ErrorInfo;
               }
               {

                 echo "sukses";
               }

?>
