<?php 
  
  
include 'database.php';
$db = new Database();

$db->select("tbl_mid_trainee_registration", "*", null, "program_id= 21 AND trng_type = 4 ", null, null);
$res1 = $db->getResult();
      if ($res1) {
         
        
          foreach ($res1 as $row){
            //print_r($row);exit;
            $sql = "INSERT INTO `tbl_mid_trainee_registration` 
            (`id`, `program_id`, `trng_type`, `name`, `hrms_id`, `designation`, `office_name`, `email`, `phone`, `status`, `mail_status`) VALUES 
            (NULL, '29', '4', '".$row['name']."', '0', '".$row['designation']."', '".$row['office_name']."', '".$row['email']."', '".$row['phone']."', '0', '1')
            ";

            $db->insert_sql($sql);

            $res = $db->getResult();
            print_r(($res));
          }
      }

?>