<?php 
include 'database.php';
$db = new Database();
//include required phpmailer files
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';
// Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//dept email
$msg='';
$obj = stripcslashes($_POST['dept_email']); 
$m_email = json_decode($obj, true);
//dept Name
$obj1 = stripcslashes($_POST['dept_name']);
$m_dept_name = json_decode($obj1, true);
for($i=0;$i<count($m_email);$i++)
{  
  $dept_email=$m_email[$i];
  $dept_name=$m_dept_name[$i];
  $subject = $_POST['email_sub'];
  $email_body = $_POST['email_content'];
  $program_id = $_POST['id'];
  $table = $_POST['table'];
     $username = $dept_email;
     $newstring = substr($dept_email,0, 5);
     $year = date("Y"); 
     $newstring = ucfirst($newstring);
     $pass = $newstring.'@'.$year;
     $psw = trim($pass);
    // echo $psw ;
    
     //exit;
     // create instance of phpmailer
     $mail = new PHPMailer();
     // set mailer to use smtp
     $mail->isSMTP();
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

            
             //Set sender email
             $mail->setFrom("mdrafm@odishaone.gov.in");
             $mail->FromName = "MDRAFM";
             $mail->SMTPDebug  = 1;



     //Enable HTML
     $mail->isHTML(true);
     //Unescape the string values in the JSON array
     $mail->Subject = $subject;
     $mail->Body = $email_body."<br><h3>MDRAFM Login</h3> </br><p>User name: <strong>$username</strong><p></br><p>Password: <strong>$psw</strong><p>";
     //add recipients
     $mail->addAddress($dept_email , 'MDRAFM');
     //finaly send emailHelp
     $encryptedpass = password_hash($psw,PASSWORD_BCRYPT);
     if($mail->Send()){
       
         $db->update($table,["mail_status"=> 1,"status"=>"approve"],'id='.$program_id);
        
         $res = $db->getResult();
        
         if($res){
          $db->select('tbl_user','*',null,'username = "'.$dept_email.'" ',null,null);
          $res = $db->getResult();

          if($res){
           foreach($res as $row){
            $db->update('tbl_user',['password'=>$encryptedpass],"id=".$row['id']);
            $res1= $db->getResult();
            if($res1[0]==1){
            $db->update("tbl_mid_multiple_program_master", ['user_id' => $row['id'],'mail_status'=>1], "program_id='" . $program_id . "' AND email = '" . $dept_email . "'");
            $res_mul = $db->getResult();
           // echo "success";
            }
           }
          }else{
            $insert_sql = "INSERT INTO tbl_user (roll_id,username,name,email,password) VALUES ( 11,'$username','$dept_name','$dept_email','$encryptedpass' ) " ;
            $db->insert_sql($insert_sql);
            $res_ins=$db->getResult();
           // print_r($res_ins);
            $last_insert_id = $res_ins['0'];
            $db->update("tbl_mid_multiple_program_master", ['user_id' => $last_insert_id,'mail_status'=>1], "program_id='" . $program_id . "' AND email = '" . $dept_email . "'");
            $res_mul = $db->getResult();
            //print_r($res_mul);
          }

           
         }else{
           echo "Error";
         }
         $msg="success";
         //echo "success";
     }else{
      $db->update($table,["mail_status"=> 0,"status"=>"pendingAtIncharge"],'id='.$program_id);
      $res = $db->getResult();
         //echo "Error#".$dept_email;
         $msg="Error";
         
     }
     //Closing emtp Connections
   }
   echo $msg;
  $mail->smtpClose();
?>