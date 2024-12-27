<?php
include('database.php');
$object = new database();

  if($_POST['action'] && $_POST['action'] == 'save'){
      
       $user_id = $_POST['user_id'];
       $trainee_info_id = $_POST['trainee_info_id'];
       $mark = $_POST['mark'];
       $exam_group = $_POST['exam_group'];

       $object->query="UPDATE `tbl_dept_trainee_registration` SET `exam_result_status` = 1,`mark`=$mark,`exam_group`=$exam_group WHERE `program_id`=68 AND `user_id` =".$user_id;
        $object->execute();

        echo 'success';
  }

  if($_POST['action'] && $_POST['action'] == 'remove'){
      
       $user_id = $_POST['user_id'];
       $trainee_info_id = $_POST['trainee_info_id'];
      
      

       $object->query="UPDATE `mdrafm`.`tbl_trainee_exam_info` SET `exam_status` = '0' WHERE `tbl_trainee_exam_info`.`id` = ".$trainee_info_id;
                                        $object->execute();

        echo 'success';
  }
?>