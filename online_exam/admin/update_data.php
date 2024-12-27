<?php

//exam_subject_question_action.php

include('database.php');

$object = new database();

$object->query = "
SELECT exam_subject_question_id FROM `surprise_test_question` " ;

$res_data = $object->get_result();
//print_r($res_data);
$cnt = 0;
foreach ($res_data as $row) {
    $cnt++;
    //echo $cnt;
    //print_r($row);
    $object->query = "
    UPDATE surprise_test_question 
    SET exam_subject_question_id = $cnt
    WHERE exam_subject_question_id = '".$row["exam_subject_question_id"]."'
    ";
echo "surprise_test_question update";
    $object->execute();

    $object->query = "
    UPDATE surprise_question_option 
    SET exam_subject_question_id = $cnt
    WHERE exam_subject_question_id = '".$row["exam_subject_question_id"]."'
    ";

    $object->execute();
    echo "surprise_question_option update";
    $object->query = "
    UPDATE tbl_exam_question_answer 
    SET exam_question_id = $cnt
    WHERE exam_question_id = '".$row["exam_subject_question_id"]."'
    ";

    $object->execute();
    echo "tbl_exam_question_answer update";
}

?>