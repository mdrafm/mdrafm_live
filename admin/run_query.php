<?php 
  
  include 'database.php';
  $db = new Database();

  $select_faculty =  $db->select('tbl_mid_trainee_registration',"*",null,"program_id =29",null,null);
  $select_faculty_res = $db->getResult() ;

  foreach($select_faculty_res as $faculty){
    //print_r($faculty);
    
      $name = $faculty['name'];
      $designation = $faculty['designation'];
      $office_name = $faculty['office_name'];
      $email = $faculty['email'];
      $phone = $faculty['phone'];
      //exit;
      
 $db->insert_sql("INSERT INTO `mdrafm`.`tbl_dept_trainee_registration` (`id`, `roll_no`, `user_id`, `program_id`, `trng_type`, `name`, `hrms_id`, `designation`, `office_name`, `email`, `phone`, `mdrafm_status`, `exam_result_status`, `crt_no`, `status`, `mail_status`) VALUES (NULL, NULL, '', '29', '4', '".$name."' , '0', '".$designation."' , '".$office_name."' , '".$email."' , '".$phone."' , '1', '0', '0', '1', '1')");
  $ressult = $db->getResult() ;

  if($ressult){
    echo 'success';
  }
}
	


  ?>