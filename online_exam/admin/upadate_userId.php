<?php
include('database.php');

$object = new database();


$object->query = "
SELECT u.id as user_id,d.id as trainee_id,u.username FROM `tbl_user` u JOIN `tbl_dept_trainee_registration` d ON u.username = d.phone 
WHERE d.program_id = 3 AND d.trng_type=3 " ;

$res = $object->get_result();

foreach ($res as $row) {

    $object->query = " UPDATE tbl_dept_trainee_registration SET user_id = '".$row['user_id']."'
                        WHERE id = '".$row['trainee_id']."' " ;

     $object->execute();

     echo "success";

}
?>