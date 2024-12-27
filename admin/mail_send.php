<?php
 include 'utility.php';
 $utl = new Utility;

 $subject = $_POST['subject'];
 $email_body = $_POST['email_body'];
 $email = $_POST['email'];
 $attachment = array();

  $res = $utl->mail($email, $subject, $email_body, $attachment);
  if($res){
    echo 'success';
  }else{
    echo 'error';
  }
  



?>