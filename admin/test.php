<?php 



include 'database.php';

$db = new Database();
//echo 123;exit;

 $db->select('tbl_new_recruite',"*",null,"batch_id =14",null,null);
 
foreach ($db->getResult() as $row) {
 // print_r($row);
  $email = $row['email'];
  $phone = $row['phone'];

  $db->update('tbl_new_recruite',["email" =>$phone,"phone"=> $email],'id='.$row['id']);
   $res = $db->getResult();
          print_r($res);

}


?>