<?php
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods:POST');

 //include required phpmailer files
  include 'PHPMailer/PHPMailer.php';
  include 'PHPMailer/SMTP.php';
  include 'PHPMailer/Exception.php';

  // Define name spaces
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;
  

  $data = json_decode(file_get_contents("php://input"), true);

  $subject = $data['subject'];
  $content = $data['content'];
  $email = $data['email'];
  $otp = $data['otp'];
   // echo json_encode(array('message'=>$data['subject'],'status'=>200));
   // exit;

   $mail = new PHPMailer();
     // set mailer to use smtp
     $mail->isSMTP();
     //define smtp host
     $mail->Host = "apps.odishaone.gov.in";
     //enable smtp authentication
     $mail->SMTPAuth ="true";
     //set type of encryption(ssl/tls)
     $mail-> Port = "25";
     $mail->SMTPSecure = "tls";
     //set gmail Username
     $mail->Username = "mdrafm@odishaone.gov.in";
     //set gmail password
     $mail->Password = "FHJ89#$@!31&&Q";

     //set email body
     $mail->Subject = "Test Email Using PHPmailer";
     //Set sender email
     $mail->setFrom("mdrafm@odishaone.gov.in");
     $mail->FromName = "MDRAFM";
      //$mail->SMTPDebug  = 2;


   //Enable HTML
   $mail->isHTML(true);
   //Unescape the string values in the JSON array
   $mail->Subject = $subject;
   
   $mail->Body ="<br><h3>Otp reset password</h3> </br><p>OTP: <strong>$otp</strong><p></br>";
   //add recipients
   $mail->addAddress($email);
   //finaly send emailHelp
   
   if($mail->Send()){
    echo json_encode(array('message'=>'Success','status'=>200));
   }else{
    echo json_encode(array('message'=>'error','status'=>401));
   }
   //Closing emtp Connections
   $mail->smtpClose();

  
  
//echo json_encode($data);
?>