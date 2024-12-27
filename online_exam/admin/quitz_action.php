<?php 
include('database.php');

$object = new database();
//print_r($_POST);

if(isset($_POST["action"]))
{
	function generateRandomString($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	if($_POST["action"] == 'Add_quiz')
	{
		//print_r($_POST);
		$error = '';

		$success = '';
		
		$code = generateRandomString(5);
			$dt = date("Y-m-d H:i", strtotime($_POST["exam_datetime"]));
			//echo $dt;exit;
			
			$exam_data = array(
                ':exam_category'    => $_POST["exam_category"], 
				':exam_title'		=>	$_POST["exam_title"],
				':examiner_id'		=>	$_POST["examiner_id"],
				':asst_examiner_id'	=>	$_POST["asst_examiner_id"],
				':program_id'		=>	$_POST["program_id"],
				':paper_id'		    =>	$_POST["paper_id"],
				':exam_date_time'	=>	$dt,
				':exam_duration'	=>	$_POST["exam_duration"],
				':total_question'	=>	$_POST["total_question"],
				':marks_per_right_answer'	=>	$_POST["marks_per_right_answer"],
				':marks_per_wrong_answer'	=>	$_POST["marks_per_wrong_answer"],
				':status'			=>	4,
				//':exam_created_on'		=>	$object->now,
				':exam_code'		=>	$code,
                ':financial_year'=>2,

			);

			
			$object->query = "
			INSERT INTO tbl_exam_master 
			(exam_category,exam_title, examiner_id,asst_examiner_id,program_id,paper_id, exam_date_time,exam_duration,status,
			total_question,marks_per_right_answer,marks_per_wrong_answer,exam_code,financial_year) 
			VALUES (:exam_category,:exam_title,:examiner_id,:asst_examiner_id,:program_id,:paper_id,:exam_date_time,:exam_duration,:status,
                    :total_question,:marks_per_right_answer,:marks_per_wrong_answer,:exam_code,:financial_year);
			";

			$object->execute($exam_data);

			$success = '<div class="alert alert-success">Exam Added </div>';

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);
exit;
	}

    if($_POST["action"] == 'Add')
	{
		//print_r($_POST);
		$error = '';

		$success = '';
			
			$exam_data = array(
                ':exam_id'    => $_POST["exam_id"], 
				':group_name'		=>	$_POST["group_name"],
				':status'			=>	1
				
			);

			
			$object->query = "
			INSERT INTO tbl_exam_group_master 
			(exam_id,group_name, status) 
			VALUES (:exam_id,:group_name,:status);
			";

			$object->execute($exam_data);

			$success = '<div class="alert alert-success">Group Added </div>';

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

}

?>