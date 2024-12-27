<?php
include('database.php');
$object = new database();
 
$object->query = "SELECT i.*,d.name,d.phone FROM `tbl_trainee_exam_info` i 
JOIN `tbl_dept_trainee_registration` d ON i.trainee_id = d.user_id WHERE i.exam_id = 63";

$exam_result = $object->get_result();
    foreach($exam_result as $mark_row){
       
       // print_r($mark_row);exit;

        $object->query = " SELECT a.id,a.trainee_exam_info_id,a.exam_question_id,a.trainee_ans_option,q.exam_subject_question_id,q.exam_subject_question_answer  FROM `tbl_exam_question_answer` a 
                        JOIN surprise_test_question q ON a.exam_question_id = q.exam_subject_question_id
                        WHERE a.`trainee_exam_info_id` =".$mark_row['id'];
                        $given_ans = $object->get_result();
                        foreach($given_ans as $row_ans){
                              if($row_ans['trainee_ans_option'] == $row_ans['exam_subject_question_answer']){
                                  
                                $object->query = "
                                UPDATE tbl_exam_question_answer 
                                   SET  
                                   marks = 1 
                                   WHERE id='".$row_ans['id']."'
                                ";
                            $object->execute();

                            //exit;
                              }
                        }
    }
  
?>