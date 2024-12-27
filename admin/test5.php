<?php
include 'database.php';

$db = new Database();

$sql = "SELECT * FROM `tbl_dept_trainee_registration` WHERE program_id =21";
$db->select_sql($sql);
$res_tranie = $db->getResult();
//print_r($res_faculty);
foreach($res_tranie as $data)

 {
    
        $insert_sql = "INSERT INTO `mdrafm`.`tbl_trainee_details` (`id`, `user_id`, `flag`, `name`, `hrms_id`, `designation`, `office_name`, `age`, `sex`, `category`, `edu_qualification`, `dob`, `joining_date`, `email`, `phone`, `previous_industry`, `status`) VALUES (NULL, '0', '2', '".$data['name']."', '".$data['hrms_id']."', '".$data['designation']."', '".$data['office_name']."', '', '0', '0', '', '', NULL, '".$data['email']."', '".$data['phone']."', '', '1')";
       $db->insert_sql($insert_sql);
      $res = $db->getResult();

     $last_insert_id = $res['0'];

      $db->update('tbl_dept_trainee_registration', ["trainee_detail_id" => $last_insert_id], 'id=' . $data['id']);
       $res2 = $db->getResult();
  //print_r($res2);
   echo $cnt;

   //exit;

 }

?>