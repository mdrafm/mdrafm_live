<!DOCTYPE html>
<html lang="en">


<head>
    <?php 
    
    include('header_link.php');
    include('form1_header_link.php');
    include('../config.php');
    include 'database.php';
    $db = new Database();


$program_name = '';
    $first_name = '';
    $last_name = '';
    $dob='';
    $category = '';
    $sex = '';
    $email='';
    $phone = '';
    $period_of_training = '';
    $father_name = '';
    $mother_name = '';
    $blood_group = '';
    $qualification = '';
    $marital_status = '';
    
    $parmanent_addr = '';
    $present_addr = '';
    $state_id = '';
    $district_id = '';
    $pr_pin = '';
    $p_state = '';
    $p_dist = '';
    $p_pin = '';
    



    $user_id= $_SESSION['user_id'];
    $db->select('tbl_new_recruite',"*",null,"phone =".$_SESSION['username'],null,null);

    foreach($db->getResult() as $row){
       // print_r( $row);
          $db->select('tbl_program_master',"prg_name",null,'id ='.$row['program_id'],null,null);
       
         foreach($db->getResult() as $row1){
            $program_name = $row1['prg_name'];
         }
        $first_name = $row['f_name'];
        $last_name = $row['l_name'];
        $dob=$row['dob'];
        $category = $row['category'];
        $sex = $row['sex'];
        $email= $row['email'];
        $phone =$row['phone'];
        $dist =$row['district'];
       
    }
   // echo $_SESSION['user_id'];
    $db->select('tbl_trainee_info',"*",null,"user_id =".$user_id,null,null);
    foreach($db->getResult() as $row5){
        //print_r($row5);
        $period_of_training = $row5['period_of_training'];
        $father_name = $row5['father_name'];
        $mother_name = $row5['mother_name'];
        $blood_group = $row5['blood_group'];
        $qualification = $row5['qualification'];
        $marital_status = $row5['marital_status'];

        $parmanent_addr = $row5['parmanent_addr'];
        $present_addr = $row5['present_addr'];
        $state_id = $row5['state_id'];
        $district_id =$row5['district_id'];
        $pr_pin = $row5['pr_pin'];
        $p_state = $row5['p_state'];
        $p_dist = $row5['p_dist'];
        $p_pin = $row5['p_pin'];

        $bank_id = $row5['bank_id'];
        $account_num = $row5['account_num'];
        $ifsc_code = $row5['ifsc_code'];


        $row5 = $row1['prg_name'];
     }


if(isset($_POST['action']) && ($_POST['action'] =='add')){

    $id = $_POST['id'];
    $training = $_POST['training'];
    $period = $_POST['period'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $f_name = $_POST['f_name'];
    $m_name = $_POST['m_name'];
    $blood = $_POST['blood'];
    $dob = date("Y-m-d",strtotime($_POST['dob']));
    
    $edu = $_POST['edu'];
    $mrg = $_POST['mrg'];
      
      $update_dt = "UPDATE `tbl_new_recruite` SET dob = '".$dob."'  WHERE `user_id` = '".$id."' ";
      $db->update_dir($update_dt);
      
     //$db->select_sql("select * from `tbl_traniee_documents` WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'");
     $db->select_sql("select * from `tbl_trainee_info` WHERE `tbl_trainee_info`.`user_id` ='".$user_id."'");
   //mm print_r($photo_sql3);exit;
    $res1 = $db->getResult();
    //print_r($res1);exit;
    if($res1){

        $photo_sql = "UPDATE `tbl_trainee_info` SET training_name='".$training."',period_of_training='".$period."',first_name='".$first_name."',last_name='".$last_name."',father_name='".$f_name."',mother_name='".$m_name."',blood_group='".$blood."',d_o_b='".$dob."',qualification='".$edu."',marital_status='".$mrg."' 
        WHERE `user_id` ='".$id."'";
         //echo $photo_sql;
        $db->update_dir($photo_sql);
        $res2 = $db->getResult();
        if($res2){
            echo "success#".$res2[1];
        }
        else{
         
          echo "error#".$res2[0];
        }


    }else{


           $sql ="INSERT INTO `tbl_trainee_info` (`user_id`,`training_name`,`period_of_training`,`first_name`, `last_name`, `father_name`,`mother_name`,`blood_group`,`d_o_b`,`qualification`,`marital_status`) VALUES ('$id', '$training', '$period','$first_name','$last_name','$f_name','$m_name','$blood','$dob','$edu','$mrg')";
           $db->insert_sql( $sql);
           $res3 = $db->getResult();
           print_r($res3);

          if($res3){
              echo "success#".$res3[1];
          }
          else{
            //print_r($db->getResult());
            echo "error#".$res3[0];
          }

    }

}



if( isset($_FILES['file']) && $_FILES["file"]["name"] != '')
{

$test = explode('.', $_FILES["file"]["name"]);
$text = end($test);
$rand_name = gen_uuid();
$ext=".".$text;
$name = $user_id.'-'.$rand_name . $ext;
$location = 'uploads/' . $name;  
    
if( move_uploaded_file($_FILES["file"]["tmp_name"], $location));

if($_POST['type']=='file1'){

        $db->select_sql("select * from `tbl_traniee_documents` WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'");
        $res1 = $db->getResult();
        print_r($res1);

        if($res1){
        
        $db->update('tbl_traniee_documents',['photo'=>$name],'user_id='.$user_id);
            $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
                exit;
        }else{
        
        $db->insert('tbl_traniee_documents',['user_id'=>$user_id,'photo'=>$name]);
        $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
        }
    exit;
}

elseif ($_POST['type']=='file2') {
// $photo_sql = "UPDATE `tbl_traniee_documents` SET joining_report='".$name."' WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'";
// $calendar_sql_res = mysqli_query($db,$photo_sql);
     
$db->select_sql("select * from `tbl_traniee_documents` WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'");
        $res1 = $db->getResult();
       

        if($res1){
        
        $db->update('tbl_traniee_documents',['joining_report'=>$name],'user_id='.$user_id);
            $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
                exit;
        }else{
        
        $db->insert('tbl_traniee_documents',['user_id'=>$user_id,'joining_report'=>$name]);
        $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
        }
}

elseif ($_POST['type']=='file3') {
// $photo_sql = "UPDATE `tbl_traniee_documents` SET character_certificate='".$name."' WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'";
// $calendar_sql_res = mysqli_query($db,$photo_sql);

$db->select_sql("select * from `tbl_traniee_documents` WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'");
        $res1 = $db->getResult();
       

        if($res1){
        
        $db->update('tbl_traniee_documents',['character_certificate'=>$name],'user_id='.$user_id);
            $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
                exit;
        }else{
        
        $db->insert('tbl_traniee_documents',['user_id'=>$user_id,'character_certificate'=>$name]);
        $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
        }
}
elseif ($_POST['type']=='file4') {
    $type1= $_POST['type1'];
// $photo_sql = "UPDATE `tbl_traniee_documents` SET PAN_card='".$name."', idproof_type='".$type1."' WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'";
// $calendar_sql_res = mysqli_query($db,$photo_sql);

$db->select_sql("select * from `tbl_traniee_documents` WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'");
        $res1 = $db->getResult();
       

        if($res1){
        
        $db->update('tbl_traniee_documents',['idproof_type'=>$type1],'user_id='.$user_id);
        $db->update('tbl_traniee_documents',['PAN_card'=>$name],'user_id='.$user_id);
            $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
                exit;
        }else{
        
        $db->insert('tbl_traniee_documents',['user_id'=>$user_id,'idproof_type'=>$type1]);
        $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
        }
}

elseif ($_POST['type']=='file6') {
// $photo_sql = "UPDATE `tbl_traniee_documents` SET hsc_certificate='".$name."' WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'";
// $calendar_sql_res = mysqli_query($db,$photo_sql);

$db->select_sql("select * from `tbl_traniee_documents` WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'");
        $res1 = $db->getResult();
       

        if($res1){
        
        $db->update('tbl_traniee_documents',['hsc_certificate'=>$name],'user_id='.$user_id);
            $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
                exit;
        }else{
        
        $db->insert('tbl_traniee_documents',['user_id'=>$user_id,'hsc_certificate'=>$name]);
        $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
        }
}
elseif ($_POST['type']=='file7') {
// $photo_sql = "UPDATE `tbl_traniee_documents` SET non_employment='".$name."' WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'";
// $calendar_sql_res = mysqli_query($db,$photo_sql);

$db->select_sql("select * from `tbl_traniee_documents` WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'");
        $res1 = $db->getResult();
       

        if($res1){
        
        $db->update('tbl_traniee_documents',['non_employment'=>$name],'user_id='.$user_id);
            $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
                exit;
        }else{
        
        $db->insert('tbl_traniee_documents',['user_id'=>$user_id,'non_employment'=>$name]);
        $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
        }
}
elseif ($_POST['type']=='file8') {
// $photo_sql = "UPDATE `tbl_traniee_documents` SET undertaking_declaration='".$name."' WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'";
// $calendar_sql_res = mysqli_query($db,$photo_sql);

$db->select_sql("select * from `tbl_traniee_documents` WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'");
        $res1 = $db->getResult();
       

        if($res1){
        
        $db->update('tbl_traniee_documents',['undertaking_declaration'=>$name],'user_id='.$user_id);
            $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
                exit;
        }else{
        
        $db->insert('tbl_traniee_documents',['user_id'=>$user_id,'undertaking_declaration'=>$name]);
        $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
        }
}
elseif ($_POST['type']=='file9') {
// $photo_sql = "UPDATE `tbl_traniee_documents` SET bank_passbook='".$name."' WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'";
// $calendar_sql_res = mysqli_query($db,$photo_sql);

$db->select_sql("select * from `tbl_traniee_documents` WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'");
        $res1 = $db->getResult();
       

        if($res1){
        
        $db->update('tbl_traniee_documents',['bank_passbook'=>$name],'user_id='.$user_id);
            $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
                exit;
        }else{
        
        $db->insert('tbl_traniee_documents',['user_id'=>$user_id,'bank_passbook'=>$name]);
        $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
        }
}
elseif ($_POST['type']=='file10') {
// $photo_sql = "UPDATE `tbl_traniee_documents` SET PRAN_Card='".$name."' WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'";
// $calendar_sql_res = mysqli_query($db,$photo_sql);

$db->select_sql("select * from `tbl_traniee_documents` WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'");
        $res1 = $db->getResult();
       

        if($res1){
        
        $db->update('tbl_traniee_documents',['PRAN_Card'=>$name],'user_id='.$user_id);
            $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
                exit;
        }else{
        
        $db->insert('tbl_traniee_documents',['user_id'=>$user_id,'PRAN_Card'=>$name]);
        $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
        }
}
elseif ($_POST['type']=='file11') {
// $photo_sql = "UPDATE `tbl_traniee_documents` SET NPS_registration='".$name."' WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'";
// $calendar_sql_res = mysqli_query($db,$photo_sql);

$db->select_sql("select * from `tbl_traniee_documents` WHERE `tbl_traniee_documents`.`user_id` ='".$user_id."'");
        $res1 = $db->getResult();
       

        if($res1){
        
        $db->update('tbl_traniee_documents',['NPS_registration'=>$name],'user_id='.$user_id);
            $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
                exit;
        }else{
        
        $db->insert('tbl_traniee_documents',['user_id'=>$user_id,'NPS_registration'=>$name]);
        $res2 = $db->getResult();
                if($res2){
                    echo "success#".$res2[1];
                }
                else{
                
                echo "error#".$res2[0];
                }
        }
}


}

if(isset($_POST['action']) && ($_POST['action'] =='personal')){

$user_id1 = $_POST['id'];
$pr_addr= $_POST['pr_addr']; 
$pr_state =  $_POST['pr_state']; 
$pr_dist =  $_POST['pr_dist']; 
$pr_pin = $_POST['pr_pin']; 
$p_addr = $_POST['p_addr']; 
$p_state = $_POST['p_state']; 
$p_dist = $_POST['p_dist']; 
$p_pin = $_POST['p_pin']; 
$bank = $_POST['bank_id']; 
$ifsc = $_POST['ifsc']; 
$acc_no = $_POST['account'];
$mobile = $_POST['mobile']; 
$email = $_POST['email'];

 $per_info_sql = "UPDATE `tbl_trainee_info` SET parmanent_addr='".$pr_addr."',state_id ='".$pr_state."',district_id='".$pr_dist."',pr_pin='".$pr_pin."',present_addr='".$p_addr."',p_state='".$p_state."',p_dist='".$p_dist."',p_pin='".$p_pin."',mobile='".$mobile."',email ='".$email."',bank_id ='".$bank."',account_num='".$acc_no."',ifsc_code='".$ifsc."' WHERE `tbl_trainee_info`.`user_id` ='".$user_id1."'";
    $db->update_dir($per_info_sql);
    $res2 = $db->getResult();
    if($res2){
    echo "success#".$res2[1];
    }
    else{

    echo "error#".$res2[0];
    }
}

if(isset($_POST['action']) && ($_POST['action'] =='medical')){

$user  =$_POST['id'];
$diff  =$_POST['diff'];
$hostel =$_POST['host'];
$other = $_POST['othr'];
$experience =$_POST['pstexpr'];
$condition = implode(",",$_POST['selected_med']);


     $sql5 ="select * from `tbl_medical_info` WHERE `user_id` ='".$user_id."'";

     $db->select_sql($sql5);
  
     $res1 = $db->getResult();
    //print_r($res1);exit;
    if($res1){

        $medical_sql = "UPDATE `tbl_medical_info` SET reason='".$condition."',diff_abled='".$diff."',past_service='".$experience."',hostel_acc='".$hostel."',other='".$other."',
       
        WHERE `user_id` ='".$user."'";
         //echo $photo_sql;
        $db->update_dir($medical_sql);
        $res2 = $db->getResult();
        if($res2){
            echo "success#".$res2[1];
        }
        else{
         
          echo "error#".$res2[0];
        }


    }else{

           $sql ="INSERT INTO `tbl_medical_info` (`user_id`,`reason`,`diff_abled`,`past_service`, `hostel_acc`, `other`) VALUES ('$user', '$condition', '$diff','$experience','$hostel','$other')";
           
           $db->insert_sql( $sql);
           $res3 = $db->getResult();
           print_r($res3);

          if($res3){
              echo "success#".$res3[1];
          }
          else{
            //print_r($db->getResult());
            echo "error#".$res3[0];
          }

    }

}
?>
</head>

<body class="user-profile">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="wrapper ">

        <?php include('sidebar.php'); ?>

        <div class="main-panel" id="main-panel">
            <?php include('navbar.php'); ?>

            <div class="panel-header panel-header-sm">


            </div>





            <div class="container-fluid">
                <div class="row" style="width: 100%;padding-top: 1%;">

                    <div class="col-xl-12">
                        <div class="card" style="padding: 3%;">
                            <h3 class="title">Trainee Registration</h3>

                            <form id="msform">
                                <!-- progressbar -->
                                <ul id="progressbar">
                                    <li class="active" id="personal"><strong style=" font-size:16px;">Basic
                                            Information</strong></li>
                                    <li id="personal"><strong style=" font-size:16px;">Contact & Bank Details</strong>
                                    </li>
                                    <li id="personal"><strong style=" font-size:16px;">Medical History(indicate
                                            if)</strong></li>
                                    <li id="personal"><strong style=" font-size:16px;">Upload Dcoumnets</strong></li>
                                </ul>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div> <!-- fieldsets -->
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">User Information:</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">Step 1 - 4</h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">

                                                <label><strong>Name of the Training</strong></label>
                                                <input type="text" class="form-control"
                                                    placeholder=" Name of the Training" id="training"
                                                    value="<?php echo $program_name  ?>">

                                            </div>
                                            <div class="col-md-6">

                                                <label><strong>Period of training</strong></label>
                                                <input type="text" class="form-control"
                                                    placeholder=" Period of training" id="period"
                                                    value="<?php echo $period_of_training; ?>">

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">

                                                <label><strong>Name of the Trainee</strong></label>
                                                <input type="text" disabled class="form-control"
                                                    placeholder=" Enter First Name" id="first_name"
                                                    value="<?php echo $first_name  ?>">

                                            </div>
                                            <div class="col-md-6">

                                                <label><strong>&nbsp; </strong></label>
                                                <input type="text" disabled class="form-control"
                                                    placeholder=" Enter Last Name" id="last_name"
                                                    value="<?php echo $last_name  ?>">

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">

                                                <label><strong>Father's Name</strong></label>
                                                <input type="text" class="form-control"
                                                    placeholder=" Enter Father's Name" id="f_name"
                                                    value="<?php echo $father_name ?>">

                                            </div>
                                            <div class="col-md-6">

                                                <label><strong>Mother's Name</strong></label>
                                                <input type="text" class="form-control"
                                                    placeholder=" Enter Mother's Name" id="m_name"
                                                    value="<?php echo $mother_name ?>">

                                            </div>

                                        </div>


                                        <div class="row">

                                            <div class="col-md-6">

                                                <label><strong> Blood Group</strong></label>
                                                <select class="custom-select mr-sm-2" style="border-radius: 30px;"
                                                    id="blood">
                                                    <option value="">Select Blood Group</option>
                                                    <option value="A+"
                                                        <?php echo ($blood_group == "A+")?'selected':'' ?>>A+</option>
                                                    <option value="A-"
                                                        <?php echo ($blood_group == "A-")?'selected':'' ?>>A-</option>
                                                    <option value="B+"
                                                        <?php echo ($blood_group == "B+")?'selected':'' ?>>B+</option>
                                                    <option value="B-"
                                                        <?php echo ($blood_group == "B-")?'selected':'' ?>>B-</option>
                                                    <option value="AB+"
                                                        <?php echo ($blood_group == "AB+")?'selected':'' ?>>AB+</option>
                                                    <option value="AB-"
                                                        <?php echo ($blood_group == "AB-")?'selected':'' ?>>AB-</option>
                                                    <option value="O+"
                                                        <?php echo ($blood_group == "O+")?'selected':'' ?>>O+</option>
                                                    <option value="O-"
                                                        <?php echo ($blood_group == "O-")?'selected':'' ?>>O-</option>

                                                </select>

                                            </div>
                                            <div class="col-md-6">

                                                <label><strong>Date of Birth</strong></label>
                                                <input type="text" class="form-control date-withicon"
                                                    placeholder="Select Date" id="dob"
                                                    value="<?php echo date("d-m-Y",strtotime($dob));  ?>">

                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">

                                                <label><strong>Educational Qualifications</strong></label>
                                                <input type="text" class="form-control" name="edu"
                                                    placeholder="Educational Qualifications" id="edu"
                                                    value="<?php echo $qualification; ?>">

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <label for="photo" style="margin-left: 20px;"><strong>Marital
                                                            Status</strong></label></br>
                                                    <label class="form-check-label" for="inlineRadio1">
                                                        <input class="radio-button" type="radio" name="status"
                                                            value="Married"
                                                            <?php echo ($marital_status == 'Married')?'checked':'' ?>>
                                                        Married</label>
                                                    <label class="form-check-label" for="inlineRadio2">
                                                        <input class="radio-button" type="radio" name="status"
                                                            value="Unmarried"
                                                            <?php echo ($marital_status == 'Unmarried')?'checked':'' ?>>
                                                        Unmarried</label>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <input type="button" id="per_info" name="save" class="action-button" value="Save"
                                        onclick="save_data('<?php echo $user_id; ?>')" />
                                    <input type="button" id="next" name="next" class="next action-button"
                                        value="Next" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Personal Information:</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">Step 2 - 4</h2>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label style="padding-left: 43%;"><strong>Contact
                                                            Details</strong></label></br>
                                                    <label><strong>Permanent Address</strong></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Permanent Address" id="pr_addr"
                                                        value="<?php echo $parmanent_addr ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 pr-1">
                                                <div class="form-group">
                                                    <label><strong>State Name</strong></label>
                                                    <input type="text" class="form-control" placeholder="Enter State"
                                                        id="state" value="<?php echo $state_id ?>">

                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label><strong>District Name</strong></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter District" id="dist"
                                                            value="<?php echo $district_id  ?>">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-1">
                                                <div class="form-group">
                                                    <label><strong>Pin Code</strong></label>
                                                    <input type="number" class="form-control" placeholder="PIN Code"
                                                        id="pr_pin" value="<?php echo $pr_pin  ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><strong>Present Address</strong></label>
                                                    <label style="padding-left: 50px;"> <input class="form-check-input"
                                                            type="checkbox" value="1" id="p_address"
                                                            onchange="valueChanged()"> <strong>Same as Permanent
                                                            Address</strong></label>
                                                    <input type="text" class="form-control addr"
                                                        placeholder="Enter Present Address" id="p_addr"
                                                        value="<?php echo $present_addr  ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 pr-1">
                                                <div class="form-group">
                                                    <label><strong>State</strong></label>
                                                    <input type="text" class="form-control" placeholder="Enter State"
                                                        id="state1" value="<?php echo $p_state  ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                <div class="form-group">
                                                    <label><strong>District</strong></label>
                                                    <input type="text" class="form-control" placeholder="Enter District"
                                                        id="dist1" value="<?php echo $p_dist  ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-1">
                                                <div class="form-group">
                                                    <label><strong>Pin Code</strong></label>
                                                    <input type="text" class="form-control" placeholder="PIN Code"
                                                        id="p_pin" value="<?php echo $p_pin  ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Mobile Number</strong></label>
                                                    <input type="text" disabled class="form-control" name="phone_no"
                                                        placeholder="Phone Number" id="phone_no"
                                                        value="<?php echo $phone  ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Email</strong></label>
                                                    <input type="text" disabled class="form-control" name="email_id"
                                                        placeholder="Enter your Email" id="email_id"
                                                        value="<?php echo $email  ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">

                                                <label style="padding-left: 43%;"><strong>Bank Details</strong></label>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Bank Name</strong></label>
                                                    <select class="custom-select mr-sm-2" style="border-radius: 30px;"
                                                        id="bank">
                                                        <?php    
           
                $db->select( "master_bank",'*',null,null,null,null);
           ?>
                                                        <option value=''>Select Bank Name</option>
                                                        <?php foreach( $db->getResult() as $bank_res) { ?>
                                                        <option value="<?php echo $bank_res['bank_name']?>"
                                                            <?php echo ($bank_id == $bank_res['bank_name'])?'selected':'' ?>>
                                                            <?php echo $bank_res['bank_name']?> </option>
                                                        <?php } ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Account No.</strong></label>
                                                    <input type="text" class="form-control" name="acc_no"
                                                        placeholder="Enter Account No" id="acc_no"
                                                        value="<?php echo $account_num ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>IFSC Code</strong></label>
                                                    <input type="text" class="form-control" name="ifsc_code"
                                                        placeholder="Enter IFSC Code" id="ifsc_code"
                                                        value="<?php echo $ifsc_code ?>">
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <input type="button" id="per_info1" name="save" class="action-button" value="Save"
                                        onclick="save_details('<?php echo $user_id; ?>')" />
                                    <input type="button" name="next" class="next action-button" value="Next" id="next1"
                                        style="display: none;" />
                                    <input type="button" name="previous" class="previous action-button-previous"
                                        value="Previous" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Medical Information</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">Step 3 - 4</h2>
                                            </div>
                                        </div>


                                        <div class="form-check">

                                            <?php
   $med_resion = '';
   $med_diff_abled = '';
   $med_past_service = '';
   $med_hostel_acc = '';
   $med_other = '';

   $db->select('tbl_medical_info','*',null,'user_id='.$user_id,null,null);
   foreach($db->getResult() as $medical){
    //print_r($medical);
       $med_resion = $medical['reason'];
       $med_diff_abled = $medical['diff_abled'];
       $med_past_service = $medical['past_service'];
       $med_hostel_acc = $medical['hostel_acc'];
       $med_other = $medical['other'];
   }

   $sql3 = "SELECT * FROM `tbl_medical_history` ORDER BY `tbl_medical_history`.`id` ASC";

 $db->select_sql($sql3);
 $res6 = $db->getResult();
if($res6)
{
    foreach($res6 as $med){

?>
                                            <label class="form-check-label font-weight-bold" id="tblmed">
                                                <input class="form-check-input" type="checkbox"
                                                    value="<?php echo $med['id']; ?>"
                                                    <?php echo ($med_resion ==$med['id'])?'checked':'' ?> /><?php echo $med['medical_history'];?>
                                                <span class="form-check-sign ">
                                                    <span class="check"></span>
                                                </span>
                                            </label></br>
                                            <?php    }

}

 ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Any other category/symptom as
                                                            notified</strong></label>
                                                    <input type="text" class="form-control" name="oth_med"
                                                        placeholder="Please Specify" id="oth_med"
                                                        value="<?php echo $med_other ?>">
                                                </div>
                                            </div>

                                        </div>
                                        <label for="photo" style="margin-left: 20px;"><strong>Whether Differently
                                                Abled?</strong></label>
                                        <label><input type="radio" name="diff" class="radio-button" value="Yes"
                                                style="padding-left: 5px;"
                                                <?php echo ($med_diff_abled == "Yes")?'checked':'' ?>>Yes</label>
                                        <label><input type="radio" name="diff" class="radio-button" value="NO"
                                                style="padding-left: 5px;"
                                                <?php echo ($med_diff_abled == "NO")?'checked':'' ?>>NO</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="photo" style="margin-left: 20px;"><strong>Past Service
                                                        experience(If any)</strong></label>
                                            </div>

                                            <div class="col-md-6">
                                                <input style="margin-right: 50%;" type="text" class="form-control"
                                                    name="t_name" placeholder="Please Specify" id="pastexp"
                                                    value="<?php echo $med_past_service ?>">

                                            </div>
                                        </div>
                                        <div class="container">
                                            <label for="photo" style="margin-left: 20px;"><strong>Hostel
                                                    Accommodation</strong></label>
                                            <label><input type="radio" name="host" class="radio-button" value="Yes"
                                                    style="padding-left: 5px;"
                                                    <?php echo ($med_hostel_acc == "Yes")?'checked':'' ?>>Yes</label>
                                            <label><input type="radio" name="host" class="radio-button" value="NO"
                                                    style="padding-left: 5px;"
                                                    <?php echo ($med_hostel_acc == "No")?'checked':'' ?>>NO</label>
                                        </div>
                                    </div>

                                    <input type="button" id="per_info2" name="save" class="action-button" value="Save"
                                        onclick="save_medinfo('<?php echo $user_id; ?>')" />
                                    <input type="button" name="next" class="next action-button" value="Next" id="next2"
                                        style="display:none" />
                                    <input type="button" name="previous" class="previous action-button-previous"
                                        value="Previous" />
                                </fieldset>
                                <fieldset>
                                    <?php 
                                    $joining_report = '';
                                    $photo = '';
                                    $character_certificate = '';
                                    $idproof_type = '';
                                    $PAN_card = '';
                                    $undertaking_declaration = '';
                                    $bank_passbook = '';
                                    $PRAN_Card = '';
                                    $NPS_registration = '';
                                    $non_employment = '';

                                      $db->select('tbl_traniee_documents','*',null,'user_id='.$user_id,null,null);
                                      foreach($db->getResult() as $doc){
                                       //print_r($medical);
                                          $joining_report = $doc['joining_report'];
                                          $photo = $doc['photo'];
                                          $idproof_type = $doc['idproof_type'];
                                          $character_certificate = $doc['character_certificate'];
                                          $PAN_card = $doc['PAN_card'];
                                          $hsc_certificate = $doc['hsc_certificate'];
                                          $non_employment = $doc['non_employment'];
                                          $undertaking_declaration = $doc['undertaking_declaration'];
                                          $bank_passbook = $doc['bank_passbook'];
                                          $PRAN_Card = $doc['PRAN_Card'];
                                          $NPS_registration = $doc['NPS_registration'];
                                         
                                      }
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <label><strong>Upload Dcoumnets</strong></label>
                                        </div>

                                        <div class="col-md-6" id="pa_photo">

                                            <br />
                                            <label class="form-check-label"><strong>Passport size Photo</strong></label>
                                            <?php 
                                               if($photo=='') {
                                                ?>
                                                    <input type="file" name="file" id="file1" />
                                                    <button onclick="upload('file1')" type="button">Upload</button>
                                                     <br />
                                                <?php
                                               }else{
                                                 echo " Uploaded Successfully ";
                                               }
                                            
                                            ?>
                                            

                                        </div>
                                        <div class="col-md-6">

                                            <label class="form-check-label"><strong>Joining report in OGFR II
                                                    Form</strong></label>
                                                    <?php 

                                               if($joining_report=='') {
                                                ?>
                                                    <input type="file" name="file" id="file2" />
                                                    <button onclick="upload('file2')" type="button">Upload</button>
                                                     <br />
                                                <?php
                                               }else{
                                                 echo " Uploaded Successfully ";
                                               }
                                            
                                            ?>

                                           
                                        </div>
                                        <div class="col-md-6">

                                            <label class="form-check-label"><strong>Character Certificate I &
                                                    II</strong></label>
                                            <?php 

                                               if($character_certificate=='') {
                                                ?>
                                                    <input type="file" name="file" id="file3" />
                                                    <button onclick="upload('file3')" type="button">Upload</button>
                                                     <br />
                                                <?php
                                               }else{
                                                 echo " Uploaded Successfully ";
                                               }
                                            
                                            ?>
                                           
                                        </div>

                                        <div class="col-md-6">

                                            <select class="custom-select mr-sm-2" style="border-radius: 30px;"
                                                id="id_type">
                                                <option value="">Select ID Proof Type</option>
                                                <option value="Adhar Card" <?php echo ($idproof_type == "Adhar Card") ? "selected" :"" ?> >Adhar Card</option>

                                                <option value="PAN Card" <?php echo ($idproof_type == "PAN Card") ? "selected" :"" ?>>Pan Card</option>
                                                <option value="Voter ID" <?php echo ($idproof_type == "Voter ID") ? "selected" :"" ?>>Voter Id</option>


                                            </select>
                                            
                                            <?php 

                                               if($PAN_card=='') {
                                                ?>
                                                   <input type="file" name="file" id="file4" />

                                                    <button onclick="upload('file4')" type="button">Upload</button>
                                                     <br />
                                                <?php
                                               }else{
                                                 echo " Uploaded Successfully ";
                                               }
                                            
                                            ?>

                                            
                                        </div>



                                        <div class="col-md-6">

                                            <label class="form-check-label"><strong>HSC Certificate/Birth
                                                    Certificate</strong></label>
                                            
                                                    <?php 

                                               if($hsc_certificate=='') {
                                                ?>
                                                    <input type="file" name="file" id="file6" />
                                                    <button onclick="upload('file6')" type="button">Upload</button>
                                                     <br />
                                                <?php
                                               }else{
                                                 echo " Uploaded Successfully ";
                                               }
                                            
                                            ?>

                                           
                                        </div>
                                        <div class="col-md-6">

                                            <label class="form-check-label"><strong>Non-employment
                                                    Certificate</strong></label>
                                                
                                                    <?php 

                                               if($non_employment=='') {
                                                ?>
                                                    <input type="file" name="file" id="file7" />

                                                     <button onclick="upload('file7')" type="button">Upload</button>
                                                     <br />
                                                <?php
                                               }else{
                                                 echo " Uploaded Successfully ";
                                               }
                                            
                                            ?>
                                            
                                        </div>
                                        <div class="col-md-6">

                                            <label
                                                class="form-check-label"><strong>Undertaking/Declaration</strong></label>

                                                <?php 

                                               if($undertaking_declaration=='') {
                                                ?>
                                                    <input type="file" name="file" id="file8" />

                                                     <button onclick="upload('file8')" type="button">Upload</button>
                                                     <br />
                                                <?php
                                               }else{
                                                 echo " Uploaded Successfully ";
                                               }
                                            
                                            ?>
                                           
                                        </div>
                                        <div class="col-md-6">

                                            <label class="form-check-label"><strong>First page of Bank
                                                    Passbook/Cancelled Bank Cheque Leaf</strong></label>
                                                
                                                    <?php 

                                               if($bank_passbook=='') {
                                                ?>
                                                     <input type="file" name="file" id="file9" />

                                                     <button onclick="upload('file9')" type="button">Upload</button>
                                                     <br />
                                                <?php
                                               }else{
                                                 echo " Uploaded Successfully ";
                                               }
                                            
                                            ?>
                                           
                                        </div>
                                        <div class="col-md-6">

                                            <label class="form-check-label"><strong>PRAN Card</strong></label>
                                            <?php 

                                               if($PRAN_Card=='') {
                                                ?>
                                                     <input type="file" name="file" id="file10" />

                                                      <button onclick="upload('file10')" type="button">Upload</button>
                                                     <br />
                                                <?php
                                               }else{
                                                 echo " Uploaded Successfully ";
                                               }
                                            
                                            ?>

                                           
                                        </div>
                                        <div class="col-md-6">

                                            <label class="form-check-label"><strong>NPS Registration
                                                    form</strong></label>
                                                 <?php 

                                               if($NPS_registration=='') {
                                                ?>
                                                      <input type="file" name="file" id="file11" />

                                                      <button onclick="upload('file11')" type="button">Upload</button>
                                                     <br />
                                                <?php
                                               }else{
                                                 echo " Uploaded Successfully ";
                                               }
                                            
                                            ?>

                                           
                                        </div>



                                    </div>
                                    <input type="button" name="finish" value="Finish" onclick="reload_page()" />
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>

            </div>


        </div>

    </div>

    </div>

    </div>

    <div class="fixed-plugin">
        <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
                <li class="header-title"> Sidebar Background</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger background-color">
                        <div class="badge-colors text-center">
                            <span class="badge filter badge-yellow" data-color="yellow"></span>
                            <span class="badge filter badge-blue" data-color="blue"></span>
                            <span class="badge filter badge-green" data-color="green"></span>
                            <span class="badge filter badge-orange active" data-color="orange"></span>
                            <span class="badge filter badge-red" data-color="red"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>


            </ul>
        </div>
    </div>

    <!-- msgBox Modal Modal HTML -->
    <div id="cnfModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="m_title" style="text-align:center;">Delete Term</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="warning">
                            <p>Are you sure you want to delete this Record?</p>
                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                        </div>
                        <p id="m_body"></p>
                    </div>
                    <div class="modal-footer" id="m_footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">

                    </div>
                </form>
            </div>


        </div>
    </div>

    <?php include('common_script.php') ?>
<?php 
function gen_uuid() 
{ 
      $s = strtoupper(md5(uniqid(date("YmdHis"),true))); 
       $guidText =substr($s,0,4)."-".substr($s,4,4)."-" ;
       
       $date=date("his");
     return $guidText.$date;
}
?>
</body>

</html>




<script type="text/javascript">
$('#p_address').change(function() {
    if ($(this).is(":checked")) {

        var pr_addr = $('#pr_addr').val();
        var state = $('#state').val();
        var dist = $('#dist').val();
        var dist_name = $('#dist option:selected').text();
        var pr_pin = $('#pr_pin').val();

        $('#p_addr').val(pr_addr);
        $('#state1').val(state);
        $('#dist1').val(dist);
        $('#p_pin').val(pr_pin);


    }
})

function save_data(id) {

    var training = $("#training").val();
    var period = $("#period").val();
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var f_name = $("#f_name").val();
    var m_name = $("#m_name").val();

    var blood = $("#blood").val();
    var dob = $("#dob").val();
    var edu = $("#edu").val();
    var mrg = $('input[name="status"]:checked').val();

    if (training !== "" && period !== "" && first_name != "" && last_name !== "" && f_name !== "" && m_name !== "" &&
        blood !== "" && dob !== "") {

        $.post("new_form_one.php", {
            action: "add",
            id: id,
            training: training,
            period: period,
            first_name: first_name,
            last_name: last_name,
            f_name: f_name,
            m_name: m_name,
            blood: blood,
            dob: dob,
            edu: edu,
            mrg: mrg
        }, function(res) {
            console.log(res);
            if (res = "success") {

                $("#next").show();
                $("#per_info").hide();
            }
        });



    } else {
        alert("Field Can not be Blank!")
    }

}

function save_details(id) {

    var pr_addr = $("#pr_addr").val();
    var pr_state = $("#state").val();
    var pr_dist = $("#dist").val();
    var pr_pin = $("#pr_pin").val();

    var p_addr = $("#p_addr").val();
    var p_state = $("#state1").val();
    var p_dist = $("#dist1").val();
    var p_pin = $("#p_pin").val();

    var mobile = $("#phone_no").val();
    var email = $("#email_id").val();
    var bank_id = $("#bank").val();
    var ifsc = $("#ifsc_code").val();
    var account = $("#acc_no").val();
    if (bank_id !== "") {

        $.post("new_form_one.php", {
            action: "personal",
            id: id,
            pr_addr: pr_addr,
            pr_state: pr_state,
            pr_dist: pr_dist,
            pr_pin: pr_pin,
            p_addr: p_addr,
            p_state: p_state,
            p_dist: p_dist,
            p_pin: p_pin,
            mobile: mobile,
            email: email,
            bank_id: bank_id,
            ifsc: ifsc,
            account: account
        }, function(res) {
           console.log(res);
           console.log(123);
            if (res = "success") {

                $("#next1").show();
                $("#per_info1").hide();
            }
        });

    }
}

function valueChanged() {


}
</script>

<script>
function upload(fname) {
   // alert(fname);
    var id1 = fname;
    var name = document.getElementById(id1).files[0].name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'pdf']) == -1) {
        alert("Invalid Image File");
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById(id1).files[0]);
    var f = document.getElementById(id1).files[0];
    var fsize = f.size || f.fileSize;

    if (id1 === String("file4")) {
        var idtype = $("#id_type").val();
        form_data.append("file", document.getElementById(id1).files[0]);
        form_data.append("type", id1);
        form_data.append("type1", idtype);

        $.ajax({
            url: "new_form_one.php",
            method: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
            },
            success: function(data) {
                console.log(data);
                alert('Upload Successfully');
                //return false;
            }
        });


    } else {

        form_data.append("file", document.getElementById(id1).files[0]);
        form_data.append("type", id1);

        $.ajax({
            url: "new_form_one.php",
            method: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
            },
            success: function(data) {
                console.log(data);
                alert('Upload Successfully');
                return false;
            }
        });
       
    }
}

function save_medinfo(id) {

    var selected_med = new Array();

    $("#tblmed input[type=checkbox]:checked").each(function() {

        selected_med.push(this.value);

    });

    var diff = $('input[name="diff"]:checked').val();
    var host = $('input[name="host"]:checked').val();


    var othr = $("#oth_med").val();

    var pstexpr = $("#pastexp").val();

    $.post("new_form_one.php", {
        action: "medical",
        id: id,
        selected_med: selected_med,
        diff: diff,
        host: host,
        othr: othr,
        pstexpr: pstexpr
    }, function(res) {
        console.log(res);
        if (res = "success") {

            $("#next2").show();
            $("#per_info2").hide();
        }
    });
}

function reload_page() {


    window.location.href = "form_one_view.php";

}

</script>