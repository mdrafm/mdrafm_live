<?php
include 'database.php'; 
$db = new Database(); 
$sql = "SELECT * FROM `tbl_new_recruite` WHERE program_id =15 ";
$db->select_sql($sql);
$res_tranie = $db->getResult();
//print_r($res_faculty);
foreach($res_tranie as $data)

 {
    $name = $data['f_name'].' ',$data['l_name'];

       $insert_sql = "INSERT INTO `tbl_dept_trainee_registration` (`id`,`roll_no`, `user_id`, `program_id`, `trng_type`, `flag`,`name`, `hrms_id`, `designation`, `email`, `phone`, `mdrafm_status`, `status`, `mail_status`) 
    VALUES (NULL,'0', '0', '61', '4', '1','".$name."', '0', 'OFS','".$data['email']."', '".$data['phone']."','1', '0', '1')";

        $db->insert_sql($insert_sql);
  $res = $db->getResult();
  print_r($res);
 echo $cnt;

 }

?>