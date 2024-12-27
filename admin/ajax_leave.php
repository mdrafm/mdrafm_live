<?php

include 'database.php';
include 'utility.php';

$db = new Database();
$utility = new Utility();


// Allowed file types 
$allowTypes = array('pdf', 'jpg', 'png', 'jpeg', 'JPEG');

// Default response 
$response = array(
    'status' => 0,
    'message' => 'Form submission failed, please try again.'
);
//print_r($_POST);exit;
if (isset($_POST['action']) && $_POST['action']=='add_leave') {
//echo json_encode($_POST); 
 //$date_diff = date_diff($_POST['from_dt'],$_POST['to_dt']);
// Creates DateTime objects
$date1 = strtotime($_POST['from_dt']);
$date2 = strtotime($_POST['to_dt']);

// Calculates the difference between DateTime objects
// Formulate the Difference between two dates
$diff = abs($date2 - $date1); 

// To get the year divide the resultant date into
  // total seconds in a year (365*60*60*24)
  $years = floor($diff / (365*60*60*24)); 
 
  // To get the month, subtract it with years and
  // divide the resultant date into
  // total seconds in a month (30*60*60*24)
  $months = floor(($diff - $years * 365*60*60*24)
                                 / (30*60*60*24));

 $days = floor(($diff - $years * 365*60*60*24 - 
               $months*30*60*60*24)/ (60*60*24));
$leave_days = $days+1;
$uploadedMedical_report = '';

$halfDayLeave = 0;
$no_of_child =0;

if(isset($_POST['half_day_leave']) && $_POST['half_day_leave'] != 0 ){
    $halfDayLeave = $_POST['half_day_leave'];
    $leave_days = 0.5;
}
if(isset($_POST['no_of_child'])){
    $no_of_child = $_POST['no_of_child'];
}
  
  $cd_email_sql = "SELECT f.name,f.email FROM `tbl_program_directors` d JOIN `tbl_faculty_master` f ON d.course_director = f.id WHERE d.program_id = '" .$_POST['program_id']. "' AND trng_type = '" . $_POST['trng_type'] . "' ";
   $db->select_sql($cd_email_sql);             
                           
  foreach($db->getResult() as $row4){
   // print_r($row4);
    $cd_email = $row4['email'];
  }
  //echo $cd_email;
// print_r($_POST);
// print_r($_FILES);
 //exit;

// If form is submitted 
//print_r($_FILES);exit;

    if (!empty($_FILES["application"]["name"])) {
        // File upload folder 
        $uploadDir = 'leave_doc/application/';
        // File path config 
        $fileName = basename($_FILES["application"]["name"]);

        $test = explode('.', $fileName);
        $text = end($test);
        $rand_name = gen_uuid();
        $ext=".".$text;
        $name = $rand_name.$ext;
       // $location = 'uploads/' . $name;

       // $md_referenceno = gen_uuid();
        $targetFilePath = $uploadDir . $name;
//echo $targetFilePath;exit;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats to upload 
        if (in_array($fileType, $allowTypes)) {
            // Upload file to the server 
            if (move_uploaded_file($_FILES["application"]["tmp_name"], $targetFilePath)) {
                $uploadedApplication = $name;
            } else {
                $uploadStatus = 0;
                $response['message'] = 'Sorry, there was an error uploading your file.';
            }
        } else {
            $uploadStatus = 0;
            $response['message'] = 'Sorry, only ' . implode('/', $allowTypes) . ' files are allowed to upload.';
        }
    }
    if (!empty($_FILES["medical_report"]["name"])) {
        // File upload folder 
        $uploadDir = 'leave_doc/medical_report/';
        // File path config 
        $fileName = basename($_FILES["medical_report"]["name"]);

        $test = explode('.', $fileName);
        $text = end($test);
        $rand_name = gen_uuid();
        $ext=".".$text;
        $name = $rand_name.$ext;
       // $location = 'uploads/' . $name;

       // $md_referenceno = gen_uuid();
        $targetFilePath = $uploadDir . $name;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
       
        // Allow certain file formats to upload 
        if (in_array($fileType, $allowTypes)) {
            // Upload file to the server 
            if (move_uploaded_file($_FILES["medical_report"]["tmp_name"], $targetFilePath)) {
                $uploadedMedical_report = $name;
            } else {
                $uploadStatus = 0;
                $response['message'] = 'Sorry, there was an error uploading your file.';
            }
        }else{
            $uploadStatus = 0;
            $response['message'] = 'Sorry, only' . implode('/', $allowTypes) . 'files are allowed to upload.';
        }
    }
    $holidays_prefix = 0;
    $holidays_suffix = 0;
    if (isset($_POST['holidays_prefix'])) {
        $holidays_prefix = $_POST['holidays_prefix'];
    }
    if (isset($_POST['holidays_suffix'])) {
        $holidays_suffix = $_POST['holidays_suffix'];
    }
    if($_POST['update_id'] == ''){
        //insert in leave table
        if($_POST['leave_type_id'] == 3){
            $insert_sql = "INSERT INTO `tbl_leave` (`id`, `user_id`, `program_id`, `trng_type`, `leave_apply_to`, `leave_type_id`, `from_dt`, `to_dt`,`leave_days`, `leave_reason`, `application`, `status`) VALUES 
            (NULL, '" . $_POST['user_id'] . "', '" . $_POST['program_id'] . "', '" . $_POST['trng_type'] . "', '" . $_POST['leave_apply_to'] . "', '" . $_POST['leave_type_id'] . "', '" . $_POST['from_dt'] . "', '" . $_POST['to_dt'] . "','" . $leave_days . "', '" . $_POST['leave_reason'] . "', '" . $uploadedApplication . "', '1')";
        }else{
            $insert_sql = "INSERT INTO `tbl_leave` (`id`, `user_id`, `program_id`, `trng_type`, `leave_apply_to`, `leave_type_id`, `half_day_leave`, `no_of_child`, `from_dt`, `to_dt`,`leave_days`, `holidays_prefix`, `hp_from_dt`, `hp_to_dt`, `holidays_suffix`, `hs_from_dt`, `hs_to_dt`, `medical_report`, `report`, `hq_leave`, `contact`, `leave_reason`, `application`, `status`) VALUES 
            (NULL, '" . $_POST['user_id'] . "', '" . $_POST['program_id'] . "', '" . $_POST['trng_type'] . "', '" . $_POST['leave_apply_to'] . "', '" . $_POST['leave_type_id'] . "', '" . $halfDayLeave . "', '" .$no_of_child. "', '" . $_POST['from_dt'] . "', '" . $_POST['to_dt'] . "','" . $leave_days . "','" . $holidays_prefix . "','" . $_POST['hp_from_dt'] . "','" . $_POST['hp_to_dt'] . "', '" . $holidays_suffix . "', '" . $_POST['hs_from_dt'] . "', '" . $_POST['hs_from_dt'] . "', '" . $_POST['report'] . "', '" . $uploadedMedical_report . "', '" . $_POST['hq_leave'] . "', '" . $_POST['contact'] . "', '" . $_POST['leave_reason'] . "', '" . $uploadedApplication . "', '1')";
        }
        // echo $insert_sql;
        // exit;
        $db->insert_sql($insert_sql);
    }else{
       // $update_array = array();

        //update in leave table
        if($_POST['leave_type_id'] == 3){
            $db->update('tbl_leave',['leave_apply_to'=>$_POST['leave_apply_to'],'leave_type_id'=>$_POST['leave_type_id'],'from_dt'=>$_POST['from_dt'],'to_dt'=> $_POST['to_dt'],'leave_days'=>$leave_days,'leave_reason'=>$_POST['leave_reason'],'application'=>$uploadedApplication], 'id=' . $_POST['update_id']);
        }else{
            $update_array = ['leave_apply_to'=>$_POST['leave_apply_to'],'leave_type_id'=>$_POST['leave_type_id'],'half_day_leave'=>$halfDayLeave,'no_of_child'=>$no_of_child,'from_dt'=>$_POST['from_dt'],'to_dt'=> $_POST['to_dt'],'leave_days'=>$leave_days,'holidays_prefix'=>$holidays_prefix,'hp_from_dt'=>$_POST['hp_from_dt'],'hp_to_dt'=>$_POST['hp_to_dt'],'holidays_suffix'=>$holidays_suffix,'hs_from_dt'=>$_POST['hs_from_dt'],'hs_to_dt'=>$_POST['hs_from_dt'],'medical_report'=>$_POST['report'],'hq_leave'=>$_POST['hq_leave'],'contact'=>$_POST['contact'],'leave_reason'=>$_POST['leave_reason']];
            if (!empty($_FILES["application"]["name"])) {
                
                $update_array['application'] = $uploadedApplication;
            }
            if (!empty($_FILES["medical_report"]["name"])) {
                
                $update_array['report'] = $uploadedMedical_report;
            }
            //print_r($update_array);
            $db->update('tbl_leave', $update_array, 'id=' . $_POST['update_id']);
        }
        
    }
    
    $res = $db->getResult();
    //print_r($res);
    if ($res) {
        // echo 123;
        $utility->mail($cd_email,'leave apporval','you have new leave approval in ITMS',null);
        $response['status'] = 1;
        $response['message'] = 'Form data submitted successfully!';
    }else {
        $response['status'] = 0;
        $response['message'] = 'Form not submitted!';
    }
    echo json_encode($response);


}

if (isset($_POST['action']) && $_POST['action']=='approve_leave') {
    $leave_id = $_POST['leave_id'];
   

    $db->update('tbl_leave',['status'=>2],'id='.$leave_id);
    $res = $db->getResult();
//print_r($res);
    if($res){
         
        echo "success#";
      }
      else{
      
          echo "error#".$res[0];
      }
}
if (isset($_POST['action']) && $_POST['action']=='reject_leave') {
    $leaveId = $_POST['leaveId'];
    $reject_reason = $_POST['reject_reason'];

    $db->update('tbl_leave',['status'=>3,'reject_reason'=>"'.$reject_reason.'"],'id='.$leaveId);
    $res = $db->getResult();
//print_r($res);
    if($res){
         
        echo "success#";
      }
      else{
      
          echo "error#".$res[0];
      }
}

if (isset($_POST['action']) && $_POST['action']=='leave_report') {
    $program_id = $_POST['program_id'];
    $trng_type = $_POST['trng_type'];
    $user_id = $_POST['user_id'];

    ?>
 <table class="table">
                                        <thead style="background: #315682;color:#fff;font-size: 11px;">
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>EL(30)</th>
                                                <th>CL(15)</th>
                                                <th>Head Quarter</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $sql = "SELECT f_name,l_name,phone,user_id FROM `tbl_new_recruite` WHERE program_id =" . $program_id;

                                            $db->select_sql($sql);
                                            $res = $db->getResult();
                                            $cnt = 0;
                                            foreach ($res as $row) {
                                                $cnt++;
                                                $userId = $row['user_id'];
                                                $el_total_leave = $db->getTotalLeave($userId,1);
                                                $cl_total_leave = $db->getTotalLeave($userId,2);
                                                $hq_total_leave = $db->getTotalLeave($userId,3);
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $cnt++ ?>
                                                    </td>
                                                    <td>
                                                    <?php echo $row['f_name'].' '.$row['l_name']; ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <?php echo $row['phone'] ?>
                                                    </td>
                                                   <td><?php echo $el_total_leave; ?></td>
                                                   <td><?php echo $cl_total_leave; ?></td>
                                                   <td><?php echo $hq_total_leave; ?></td>
                                                    
                                                </tr>
                                                <?php
                                            }

                                            ?>
                                        </tbody>
                                    </table>
    <?php
}
if( isset($_POST['action']) && $_POST['action'] == 'edit_leave'){
    $leaveId = $_POST['leaveId'];
    $sql = "SELECT * FROM `tbl_leave` WHERE id = $leaveId ";

    $db->select_sql($sql);
    $res = $db->getResult();
    echo json_encode($res[0]);
}

if( isset($_POST['action']) && $_POST['action'] == 'delete_medical_report'){
   
    $leaveId = $_POST['leaveId'];
    $medical_report = $_POST['report'];

    $file_path = "/mdrafm_exam/admin/leave_doc/report/".$medical_report;
    $path = $_SERVER['DOCUMENT_ROOT'].$file_path;

    if($path)
         {
             unlink($path);
           
             $db->update('tbl_leave',['report'=>'','medical_report'=>0], 'id=' . $leaveId);
    
             $res = $db->getResult();
             //print_r($res);
             if ($res) {
                 // echo 123;
                 $response['status'] = 1;
                 $response['message'] = 'Booking Updated successfully!';
             }else {
                 $response['status'] = 0;
                 $response['message'] = 'Something Wrong!';
             }
         }
         else
         {
            $response['status'] = 0;
            $response['message'] = 'File Not Found!';
         }

         echo json_encode($response);
}
if( isset($_POST['action']) && $_POST['action'] == 'delete_application'){
   
    $leaveId = $_POST['leaveId'];
     $application = $_POST['application'];

    $file_path = "/mdrafm_exam/admin/leave_doc/application/".$application;
    $path = $_SERVER['DOCUMENT_ROOT'].$file_path;

    if($path)
         {
             unlink($path);
           
             $db->update('tbl_leave',['application'=>''], 'id=' . $leaveId);
    
             $res = $db->getResult();
             //print_r($res);
             if ($res) {
                 // echo 123;
                 $response['status'] = 1;
                 $response['message'] = 'Booking Updated successfully!';
             }else {
                 $response['status'] = 0;
                 $response['message'] = 'Something Wrong!';
             }
         }
         else
         {
            $response['status'] = 0;
            $response['message'] = 'File Not Found!';
         }

         echo json_encode($response);
}

if( isset($_POST['action']) && $_POST['action'] == 'delete_leave'){
   
     $leaveId = $_POST['leaveId'];
     $application = $_POST['application'];
     $medicalreport = $_POST['medicalreport'];

     if($medicalreport != ''){
        $file_path = "/mdrafm_exam/admin/leave_doc/report/".$application;
        $path = $_SERVER['DOCUMENT_ROOT'].$file_path;
        unlink($path);
     }
     if($application != ''){
        $file_path = "/mdrafm_exam/admin/leave_doc/application/".$application;
        $path = $_SERVER['DOCUMENT_ROOT'].$file_path;
        unlink($path);
     }
     $db->delete('tbl_leave', 'id='.$leaveId);
     $res = $db->getResult();
     if ($res) {
       // echo 123;
       $response['status'] = 1;
       $response['message'] = 'Deleted successfully!';
       }else {
           $response['status'] = 0;
           $response['message'] = 'Something Wrong!';
       }
       echo json_encode($response);

   
}
function gen_uuid()
{
    $s = strtoupper(md5(uniqid(date("YmdHis"), true)));
    $guidText = substr($s, 0, 4) . "-" . substr($s, 4, 4) . "-";

    $date = date("his");
    return $guidText . $date;
}


?>