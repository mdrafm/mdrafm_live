<?php
$host = 'localhost';
$user = 'root';
$pass = 'MdR@6%&!#$1';

$db = 'mdrafm';


$connection = new mysqli($host, $user, $pass, $db);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$id = $_POST['id'];
$program_id = $_POST['program_id'];
$trng_type = $_POST['trng_type'];
$name = $_POST['name'];
$hrms_id =  $_POST['hrms_id'] !=''?$_POST['hrms_id'] : 0;
$designation = $_POST['designation'];
$office_name = $_POST['office_name'];
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$district_id = $_POST['district_id'];
$pin = $_POST['pin'];
$addrss_flag = $_POST['same_addr'] !=''?$_POST['same_addr'] : 0;
$per_address1 = ($same_addr==1)?$address1:$_POST['per_address1'];
$per_address2 = ($same_addr==1)?$address2:$_POST['per_address2'];
$per_pin = ($same_addr==1)?$pin:$_POST['per_pin'];
$perDistrict = ($same_addr==1)?$district_id:$_POST['pre_district_id'];

$sex = $_POST['sex'];



if($_POST['id'] != ''){
    //echo 123;
   // echo $query = "UPDATE tbl_dept_trainee_registration SET name='$name', hrms_id='$hrms_id', designation='$designation', office_name='$office_name', email='$email',phone = '$phone',address1 = '$address1',address2 = '$address2',pin='$pin',district_id = '$district_id',addrss_flag = '$addrss_flag',per_address1 = '$per_address1',per_address2 = '$per_address2',pre_pin = '$pre_pin',per_district_id = '$perDistrict',sex='$sex' WHERE id=$id";
  $query = "UPDATE tbl_dept_trainee_registration SET name='$name', hrms_id='$hrms_id', designation='$designation', office_name='$office_name', email='$email',phone = '$phone',address1 = '$address1',address2 = '$address2',pin='$pin',district_id = '$district_id',addrss_flag = '$addrss_flag',sex='$sex' WHERE id=$id";
  // exit;

    if ($connection->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }
}else{
    //echo 1235;

    $select_sql = "SELECT *  FROM `tbl_dept_trainee_registration` WHERE `trng_type` = '$trng_type' AND `phone` LIKE  '$phone'";
   // exit;
    $result2 = $connection->query($select_sql);
        $row2 = $result2->fetch_assoc();
    //print_r($row2);
    //exit;
    if(!empty($row2)){
        echo 'You Are Already Registred With '.$phone.' This Mobile Number';
    }else{
        
     $query="INSERT INTO `tbl_dept_trainee_registration` (`id`,`program_id`,`trng_type`,`name`, `hrms_id`, `designation`, `office_name`, `sex`, `email`, `phone`, `address1`, `address2`, `district_id`, `pin`, `addrss_flag`, `per_address1`, `per_address2`, `pre_pin`, `per_district_id`)
             VALUES (NULL,'$program_id','$trng_type', '$name', '$hrms_id', '$designation', '$office_name','$sex', '$email', '$phone','$address1','$address2','$district_id','$pin','$addrss_flag','$per_address1','$per_address2','$per_pin','$perDistrict')";
    
    if ($connection->query($query) === TRUE) {
        echo "Registred Successfully";
    } else {
        echo "Error updating record: " . $connection->error; 
    }
    }

   
}



$connection->close();
?>
