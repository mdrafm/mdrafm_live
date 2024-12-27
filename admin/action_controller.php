<?php 
  
  include 'utility.php';
  include 'database.php';

  $db = new Database();
  $utl = new Utility;

  //print_r($_POST);
  
  if ( isset($_POST['action']) && $_POST['action'] == 'register_trainee'){
      
    $subject = $_POST['subject']; 
    $email_body = $_POST['email_body'];
    $email = $_POST['email'];

    $name = $_POST['name'];
    $newstring = substr($_POST['phone'], 5);
    $username = trim($_POST['phone']);
    $pass = "Mdrafm@".$newstring;
    $psw = trim($pass);
    $encryptedpass = password_hash($psw,PASSWORD_BCRYPT);

    $msg = '';
    
    $db->update('tbl_dept_trainee_registration',["mail_status"=> 1],'id='.$_POST['traine_id']);
   $res4= $db->getResult();
   //print_r($res);
    if($res4){

        $db->select('tbl_user','*',null,'username = "'.$username.'" ',null,null);
        $res = $db->getResult();
        //  print_r($res);
        //  exit;
        if($res){
            $roll_id = 4;
          foreach($res as $row){

            $rolls = explode(',', $row['roll_id']);
            if(in_array('4',$rolls)){
              $roll = $row['roll_id'];
            }else{
              $roll = $row['roll_id'].','.$roll_id;
            }
            $db->update('tbl_dept_trainee_registration',["user_id"=> $row['id']],'id='.$_POST['traine_id']);
            $res8= $db->getResult();

            $db->update('tbl_user',['roll_id'=>$roll,'password'=>$encryptedpass,'status'=>1],"id=".$row['id']);
            $res1= $db->getResult();
            if($res1){
                $attachment = array();
                $email_body =  $email_body."<br><h3>MDRAFM Login</h3> </br><p>User name: <strong>$username</strong><p></br><p>Password: <strong>$pass</strong><p> <br><br><br><br> <p> For any technical help contact  </p> <p> Smruti Ranjan - 8249527287 </p>";
                $res = $utl->mail($email, $subject, $email_body, $attachment);
                if($res){
                    $msg  = 'success';
                }else{
                    $msg= 'error';
                }
            }
           }
        }
        else{
            
          $insert_sql = "INSERT INTO tbl_user (roll_id,username,name,email,password) VALUES ( 4,'$username','$name','$email','$encryptedpass' ) " ;
          $db->insert_sql($insert_sql);
          $res2= $db->getResult();
          if($res2){
            $db->update('tbl_dept_trainee_registration',["user_id"=> $res[0]],'id='.$_POST['traine_id']);
            $res5= $db->getResult();
            print_r($res5);
            
                $attachment = array();
                $email_body =  $email_body."<br><h3>MDRAFM Login</h3> </br><p>User name: <strong>$username</strong><p></br><p>Password: <strong>$pass</strong><p>";
                $res = $utl->mail($email, $subject, $email_body, $attachment);
                if($res){
                    $msg  = 'success';
                }else{
                    $msg= 'error';
                }
          }else{
            $msg= 'error';
        }
        }
   }else{
     echo "Error";
   }

   echo  $msg;
    
  }
  if ( isset($_POST['action']) && $_POST['action'] == 'mctp_approval'){
    // print_r($_POST);exit;
    $subject = $_POST['subject']; 
    $email_body = $_POST['email_body'];
    $email = $_POST['email'];
    $trng_type = $_POST['trng_type'];
    $program_id = $_POST['program_id'];

    $name = $_POST['name'];
    $newstring = substr($_POST['phone'], 5);
    $username = trim($_POST['phone']);
    $pass = "Mdrafm@".$newstring;
    $psw = trim($pass);
    $encryptedpass = password_hash($psw,PASSWORD_BCRYPT);

    $msg = '';
    
    $db->update('tbl_ofs_master',["mail_status"=> 1],'id='.$_POST['ofs_id']);
   $res4= $db->getResult();
   //print_r($res);
    if($res4){

        $db->select('tbl_user','*',null,'username = "'.$username.'" ',null,null);
        $res = $db->getResult();
        //  print_r($res);
        //  exit;
        if($res){
            $roll_id = 4;
          foreach($res as $row){

            $rolls = explode(',', $row['roll_id']);
            if(in_array('4',$rolls)){
              $roll = $row['roll_id'];
            }else{
              $roll = $row['roll_id'].','.$roll_id;
            }
            $db->update('tbl_ofs_master',["mctp_accept_ststus"=> 1,"trng_type"=>$trng_type,'program_id'=>$program_id],'id='.$_POST['ofs_id']);
            $res8= $db->getResult();

            $insert_sql2 = "INSERT INTO `tbl_mctp_approve` (`id`, `ofs_id`, `mctp_trainning_status`, `mail_status`, `mctp_accept_ststus`, `trng_type`, `program_id`, `reject_reason`, `status`) 
                                            VALUES (NULL, '".$_POST['ofs_id']."', '1', '1', '1','".$trng_type."' ,'".$program_id."' , '', '1')";
           $db->insert_sql($insert_sql2);
            $db->update('tbl_user',['roll_id'=>$roll,'password'=>$encryptedpass,'mctp_status'=>1,'status'=>1],"id=".$row['id']);
            $res1= $db->getResult();
            if($res1){
                $attachment = array();
                $email_body =  $email_body."<br><h3>MDRAFM Login</h3> </br><p>User name: <strong>$username</strong><p></br><p>Password: <strong>$pass</strong><p>";
                $res = $utl->mail($email, $subject, $email_body, $attachment);
                if($res){
                    $msg  = 'success';
                }else{
                    $msg= 'error';
                }
            }
           }
        }
        else{

            
          $insert_sql = "INSERT INTO tbl_user (roll_id,username,name,email,password,mctp_status) VALUES ( 4,'$username','$name','$email','$encryptedpass',1 ) " ;
          $db->insert_sql($insert_sql);
          $res2= $db->getResult();
          if($res2){
            $db->update('tbl_ofs_master',["user_id"=> $res2[0],"mctp_accept_ststus"=> 1,"trng_type"=>$trng_type,"trng_type"=>$trng_type,'program_id'=>$program_id],'id='.$_POST['ofs_id']);
            $insert_sql3 = "INSERT INTO `tbl_mctp_approve` (`id`, `ofs_id`, `mctp_trainning_status`, `mail_status`, `mctp_accept_ststus`, `trng_type`, `program_id`, `reject_reason`, `status`) 
                            VALUES (NULL, '".$_POST['ofs_id']."', '1', '1', '1','".$trng_type."' ,'".$program_id."' , '', '1')";
            $db->insert_sql($insert_sql3);

            $res5= $db->getResult();
            print_r($res5);
            
                $attachment = array();
                $email_body =  $email_body."<br><h3>MDRAFM Login</h3> </br><p>User name: <strong>$username</strong><p></br><p>Password: <strong>$pass</strong><p>";
                $res = $utl->mail($email, $subject, $email_body, $attachment);
                if($res){
                    $msg  = 'success';
                }else{
                    $msg= 'error';
                }
          }else{
            $msg= 'error';
        }
        }
   }else{
     echo "Error";
   }

   echo  $msg;
  }

  if ( isset($_POST['action']) && $_POST['action'] == 'accept_mctp'){
      $id = $_POST['id'];
      $ofs_id = $_POST['ofs_id'];

      $db->update('tbl_ofs_master',["mctp_accept_ststus"=> 2],'id='.$_POST['ofs_id']);
      $db->update('tbl_mctp_approve',["mctp_accept_ststus"=> 2],'id='.$_POST['id']);


      $sql = "SELECT m.id,m.trng_type,m.program_id,o.* FROM `tbl_mctp_approve` m 
      JOIN `tbl_ofs_master` o ON m.ofs_id = o.id
      WHERE o.id = ".$ofs_id;
      $db->select_sql($sql);
        $res = $db->getResult();

        foreach($res as $data){
        // print_r($data);

         $insert_sql = "INSERT INTO `tbl_dept_trainee_registration` (`id`,`roll_no`, `user_id`, `program_id`, `trng_type`, `name`, `hrms_id`, `designation`, `office_name`,`sex`,`category`,`edu_qualification`, `email`, `phone`,`previous_industry`, `mdrafm_status`, `status`, `mail_status`) 
         VALUES (NULL,'0', '".$data['user_id']."', '".$data['program_id']."', '".$data['trng_type']."', '".$data['name']."', '0', '".$data['designation']."', '".$data['office_name']."','".$data['gender']."','".$data['category_id']."','".$data['degree']."','".$data['email']."', '".$data['mobile']."','', '1', '0', '0')";
     
        $db->insert_sql($insert_sql);
        $res = $db->getResult();
        if($res){
          echo 'success';
        }else{
          echo 'error';
        }
        }


  }
  if ( isset($_POST['action']) && $_POST['action'] == 'reject_mctp'){
    $id = $_POST['id'];
    $ofs_id = $_POST['ofs_id'];
    $reason = $_POST['reason'];

    $db->update('tbl_ofs_master',["mctp_accept_ststus"=> 3,'reject_reason'=>$reason],'id='.$_POST['ofs_id']);

    $db->update('tbl_mctp_approve',["mctp_accept_ststus"=> 3,'reject_reason'=>$reason],'id='.$_POST['id']);
    
    $res = $db->getResult();
      if($res){
        echo 'success';
      }else{
        echo 'error';
      }
      


}

?>