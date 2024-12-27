 <?php
	include('database.php');
    $db = new Database();


//include required phpmailer files
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';
// Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// WHERE timestamp BETWEEN 
//         DATE_SUB(DATE(NOW()), INTERVAL 2 DAY)
//          AND DATE_SUB(DATE(NOW()), INTERVAL 1 DAY) 

     $db->select('tbl_book_details',"tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk_req.id as bk_req_id,tbl_bk_req.request_date,
    tbl_bk_req.status,tbl_user.name,tbl_fclty.desig,tbl_fclty.phone,tbl_fclty.email,tbl_trainee.phone as t_phone,tbl_trainee.email as t_email,tbl_bk_req.issue_date,tbl_bk_req.no_of_days, tbl_bk_req.return_date,
	tbl_bk_req.fine,tbl_bk_ref.reference_no,tbl_staff.phone as s_phone,tbl_staff.email as s_email,tbl_staff.desig as s_desig,tbl_dpt_trne.designation as d_desig,tbl_dpt_trne.phone as d_phone,tbl_dpt_trne.email as d_email",' 
    tbl_bk LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id left outer join tbl_book_reference_no tbl_bk_ref ON tbl_bk_ref.id =tbl_bk_req.bk_ref_id JOIN 
	tbl_user ON tbl_user.id =tbl_bk_req.user_id left outer join tbl_new_recruite as tbl_trainee 
    on tbl_trainee.user_id= tbl_bk_req.user_id left outer join tbl_faculty_master as tbl_fclty 
    on tbl_fclty.user_id= tbl_bk_req.user_id left outer join tbl_staf_master as tbl_staff
    on tbl_staff.user_id= tbl_bk_req.user_id left outer join tbl_dept_trainee_registration as tbl_dpt_trne on tbl_dpt_trne.user_id= tbl_bk_req.user_id','tbl_bk_req.status >= "1"
    GROUP BY tbl_bk_req.id',null,null); 
    $res_book = $db->getResult();
//echo "<pre>";
 //print_r($res_book);
    // $subject = " MDRAFM Library Alert !!!";
             
              
    //           $email_body = "Test mail2";
    //           $email = "sssmruti08@gmail.com";

    //           email($email,$subject,$email_body);

    foreach($res_book as $row){
       
         $cur_dt = date("Y-m-d");
         $return_dt = date('Y-m-d',strtotime($row['issue_date'].' + '.$row['no_of_days'].'days'));
    
        $alert_dt = date('Y-m-d',strtotime($return_dt.' - 2 days'));

        if($alert_dt != "" && ($cur_dt==$alert_dt)){
            // print_r($row);
//echo $return_dt;
              $subject = " MDRAFM Library Alert !!!";
             
              
              $email_body =     "<p>Dear ". $row['name'] . "</p> <br>"
                                ."<p>The following book should be returned before due date :</p><br>"
                                ."Title: ". $row['book_name']. "<br>"
                                ."Author Name: " . $row['author_name'] . "<br>"
                                ."Accession No: " . $row['reference_no'] ." <br>"
                                ."Due Date: " . date('d-m-Y',strtotime($return_dt)) ." <br><br><br><br>"
                                ."Thank You <br>"
                                ."Library, MDRAFM <br>";
								
							$f_email=$res['email'];
                            $t_email=$res['t_email'];
                            $s_email=$res['s_email'];
                            $d_email=$res['d_email'];
                            if(!empty($f_email))
                            {
                                $email=$f_email;
                            }
                            else if(!empty($t_email)){
                                $email=$t_email;
                            }
                            else if(!empty($s_email)){
                                $email=$s_email;
                            } 
                            else if(!empty($d_email)){
                                $email=$d_email;
                            }     					
						email($email,$subject,$email_body);

        }

    }


     function email($email,$subject,$body){
                
                // create instance of phpmailer
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

            
             //Set sender email
             $mail->setFrom("mdrafm@odishaone.gov.in");
             $mail->FromName = "MDRAFM";
             //$mail->SMTPDebug  = 1;


            //Enable HTML
            $mail->isHTML(true);
            //Unescape the string values in the JSON array
            $mail->Subject = $subject;
            $mail->Body = $body;
            //add recipients
            $mail->addAddress($email);
            //finaly send emailHelp
            //$mail->SMTPDebug  = 1;
            if($mail->Send()){
                echo "email Sent";
               // return true;
            }else{
               $mail->SMTPDebug  = 1;
            }
                
    }
 ?>
 