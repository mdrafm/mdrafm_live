<?php 
include('database.php');

$object = new database();

if(isset($_POST["action"]))
{
    
    if($_POST["action"] == 'fetch')
	{
        
    }
    function generateRandomString($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
	}
    if($_POST["action"] == 'Add')
	{
		//print_r($_POST);
		$error = '';

		$success = '';

		// $data = array(
		// 	':program_id'	=>	$_POST["program_id"],
		// 	':paper_id'		=>	$_POST["paper_id"]
		// );

		// $object->query = "
		// SELECT * FROM tbl_exam_master 
		// WHERE program_id = :program_id 
		// AND paper_id = :paper_id
		// ";

		// $object->execute($data);

		// if($object->row_count() > 0)
		// {
		// 	$error = '<div class="alert alert-danger">Exam Already Exists for <b>'.$object->Get_program_name($_POST["program_id"],"tbl_program_master").'</b> Class</div>';
		// }
		// else
		// {
			
		// }

		$code = generateRandomString(5);
			$dt = date("Y-m-d H:i", strtotime($_POST["exam_datetime"]));
			//echo $dt;exit;
			
			$exam_data = array(
                ':exam_category'    => $_POST["exam_category"], 
				':exam_title'		=>	$_POST["exam_title"],
				':examiner_id'		=>	$_POST["examiner_id"],
				':asst_examiner_id'		=>	$_POST["asst_examiner_id"],
                ':trng_type'        =>	$_POST["trng_type"], 
				':program_id'		=>	$_POST["program_id"],
				':term_id'		    =>	isset($_POST['term_id'])?$_POST['term_id']:0,
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
			(exam_category,exam_title, examiner_id,asst_examiner_id,trng_type, program_id, term_id, paper_id, exam_date_time,exam_duration,status,
			total_question,marks_per_right_answer,marks_per_wrong_answer,exam_code,financial_year) 
			VALUES (:exam_category,:exam_title,:examiner_id,:asst_examiner_id,:trng_type,:program_id,:term_id,:paper_id,:exam_date_time,:exam_duration,:status,
                    :total_question,:marks_per_right_answer,:marks_per_wrong_answer,:exam_code,:financial_year);
			";

			$object->execute($exam_data);

			$success = '<div class="alert alert-success">Exam Added </div>';

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

    if($_POST["action"] == 'select_programme')
	{
        $program_type = $_POST["program_type"];

        if($program_type ==1){
            $prog_table = "tbl_program_master";
        }elseif($program_type ==3){
            $prog_table = "tbl_mid_program_master";
        }else{
        	$prog_table = "tbl_short_program_master";
        }

		$object->query = " SELECT id,prg_name FROM $prog_table  WHERE active  = 1 ";
		

        $result = $object->get_result();
		echo '<option value="0" >Select Programme</option>';
		foreach($result as $row)
		{
			echo '<option value="'.$row['id'].'">'.$row['prg_name'].'</option>';
		}


	}

    if($_POST["action"] == 'select_term')
	{

		$object->query = " SELECT t.id,t.term FROM `tbl_program_master` p JOIN `tbl_term_master` t ON p.syllabus_id = t.syllabus_id
		 WHERE p.id  = '".$_POST["program_id"]."' ";

        $result = $object->get_result();
		echo '<option value="0" >Select term</option>';
		foreach($result as $row)
		{
			echo '<option value="'.$row['id'].'">'.$row['term'].'</option>';
		}


	}
	if($_POST["action"] == 'select_paper')
	{
      // echo "SELECT * FROM `tbl_paper_master` term_id = '".$_POST["term_id"]."'";
		$object->query = " SELECT * FROM `tbl_paper_master` WHERE term_id = '".$_POST["term_id"]."' ";

        $result = $object->get_result();
        echo '<option value="0" >Select Paper</option>';
		foreach($result as $row)
		{
			echo '<option value="'.$row['id'].'">'.$row['paper_code'].'-'.$row['title'].'</option>';
		}


	}		

    if($_POST["action"] == 'select_mid_paper')
	{

        $program_id = $_POST["program_id"];
		$object->query = " SELECT pm.id,pm.paper_code,pm.paper_title FROM `tbl_mid_program_master` p JOIN `tbl_mid_paper_master` pm ON p.syllabus_id = pm.syllabus_id 
                           WHERE p.id = '".$_POST["program_id"]."' ";
          
        $result = $object->get_result();
       
        echo '<option value="0" >Select Paper</option>';
		foreach($result as $row)
		{
			echo '<option value="'.$row['id'].'">'.$row['paper_code'].'-'.$row['paper_title'].'</option>';
		}


	}		
}


?>