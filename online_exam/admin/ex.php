<?php
include('database.php');
$object = new database();
 
$object->query = "SELECT *  FROM `tbl_trainee_exam_info` WHERE `exam_id` = 122";
$cnt = 0;
$exam_result = $object->get_result();
    foreach($exam_result as $mark_row){
       
       // print_r($mark_row);exit;
        $cnt++;

       
                       
                                  
                $object->query = "DELETE FROM tbl_exam_question_answer  WHERE trainee_exam_info_id='".$mark_row['id']."' AND exam_question_id = 190";
                                
                                 
                                  
                               
                            $object->execute();

                            //exit;
                              echo $cnt;
                        
    }
  
?>