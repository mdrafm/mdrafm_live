<?php 
//include 'database.php';

//include required phpmailer files
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';
// Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Utility{
    
    public function mail($email,$subject,$body,$attch=array()){
                
                // create instance of phpmailer
            $mail = new PHPMailer();
            // set mailer to use smtp
            $mail->isSMTP();
            //define smtp host
           $mail->Host = "";
             //enable smtp authentication
             $mail->SMTPAuth ="true";
             //set type of encryption(ssl/tls)
             $mail-> Port = "25";
             $mail->SMTPSecure = "tls";
             //set gmail Username
             $mail->Username = "";
             //set gmail password
             $mail->Password = "";

            
             //Set sender email
             $mail->setFrom("");
             $mail->FromName = "MDRAFM";
             //$mail->SMTPDebug  = 1;

            //Attachments
            //$mail->addAttachment($latter);         //Add attachments
            //$mail->addAttachment($anx1, 'anx1');    //Optional name


            //Enable HTML
            $mail->isHTML(true);
            //Unescape the string values in the JSON array
            $mail->Subject = $subject;
            $mail->Body = $body;
            //add recipients
            $mail->addAddress($email);
            //finaly send emailHelp
            if($mail->Send()){
                //echo "email Sent";
                return true;
            }else{
                return false;
            }
                
    }
    
    public function updateTbl($tbl,$updateData=array(),$where) {
        $db = new Database();
        $db->update($tbl, $updateData, $where);
        $res = $db->getResult();
        if ($res) {
            echo "success";
        }
    }
}

?>
