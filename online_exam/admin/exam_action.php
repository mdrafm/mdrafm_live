<?php

//exam_action.php

include('database.php');

$object = new database();

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{

		// SELECT m.id,m.exam_title,f.name as faculty_name,p.prg_name as program_name,t.term,pm.paper_code,
		// m.exam_date_time,m.exam_duration,m.status,m.exam_code FROM `tbl_exam_master` m 
        //   JOIN `tbl_faculty_master` f ON m.examiner_id = f.id
        //   JOIN `tbl_program_master` p ON m.program_id = p.id
        //   JOIN `tbl_term_master` t ON m.term_id = t.id
        //   JOIN `tbl_paper_master` pm ON m.paper_id = pm.id;

		$order_column = array('m.id','m.exam_title', 'f.name', 'p.prg_name', 
		                't.term', 'pm.paper_code','m.exam_date_time','m.exam_duration','m.status','m.exam_code' );

		$output = array();

		echo $main_query = "
		   SELECT  m.id,m.exam_title,f.name as faculty_name,p.prg_name as program_name,t.term,pm.paper_code,m.exam_date_time,m.exam_duration,m.status,m.exam_code 
		   FROM `tbl_exam_master` m 
		   JOIN `tbl_faculty_master` f ON m.examiner_id = f.id
           JOIN `tbl_program_master` p ON m.program_id = p.id
           JOIN `tbl_term_master` t ON m.term_id = t.id
           JOIN `tbl_paper_master` pm ON m.paper_id = pm.id;
		";

		$search_query = 'WHERE m.exam_category =1';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= ' m.exam_title LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR f.name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR p.prg_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR pm.paper_code LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR m.exam_duration LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY m.id DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
       echo $main_query . $search_query . $order_query;
		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query;

		$result = $object->statement_result();

		$object->query = $main_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = html_entity_decode($row["exam_title"]);
			$sub_array[] = html_entity_decode($row["faculty_name"]);
			$sub_array[] = html_entity_decode($row["program_name"]);
			$sub_array[] = $row["term"];
			$sub_array[] = $row["paper_code"];
			$sub_array[] = $row["exam_date_time"];
			$sub_array[] = $row["exam_duration"] . ' Minute';

			// $exam_result_datetime = '';

			// if($row['exam_result_datetime'] == '0000-00-00 00:00:00')
			// {
			// 	$exam_result_datetime = 'Not Publish';
			// }
			// else
			// {
			// 	$exam_result_datetime = $row['exam_result_datetime'];
			// }

			// $sub_array[] = $exam_result_datetime;

			$status = '';
			$action_button = '';

			if($row['status'] == 1)
				{
					$status = '<span class="badge badge-warning">Pending</span>';
					$action_button = '
					<div align="center">
					<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["id"].'"><i class="fas fa-edit"></i></button>
					&nbsp;
					<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["id"].'"><i class="fas fa-times"></i></button>
					</div>
					';
				}

				if($row['status'] == 0)
				{
					$status = '<span class="badge badge-success">Created</span>';
					$action_button = '';
				}

				if($row['status'] == 'Started')
				{
					$status = '<span class="badge badge-primary">Started</span>';
					$action_button = '';
				}

				if($row['status'] == 'Completed')
				{
					$status = '<span class="badge badge-dark">Completed</span>';
					$action_button = '';
				}
	      

			$sub_array[] = $status;

			$sub_array[] = $action_button; 

			$data[] = $sub_array;
		}
		//echo $data;exit;
		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		//echo json_encode($output);

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
				':exam_title'		=>	$_POST["exam_title"],
				':examiner_id'		=>	$_POST["examiner_id"],
				':asst_examiner_id'		=>	$_POST["asst_examiner_id"],
				':program_id'		=>	$_POST["program_id"],
				':term_id'		    =>	$_POST["term_id"],
				':paper_id'		    =>	$_POST["paper_id"],
				':exam_date_time'	=>	$dt,
				':exam_duration'	=>	$_POST["exam_duration"],
				':total_question'	=>	$_POST["total_question"],
				':marks_per_right_answer'	=>	$_POST["marks_per_right_answer"],
				':marks_per_wrong_answer'	=>	$_POST["marks_per_wrong_answer"],
				':status'			=>	1,
				//':exam_created_on'		=>	$object->now,
				':exam_code'		=>	$code,
			);

			
			$object->query = "
			INSERT INTO tbl_exam_master 
			(exam_category,exam_title, examiner_id,asst_examiner_id, program_id, term_id, paper_id, exam_date_time,exam_duration,status,
			total_question,marks_per_right_answer,marks_per_wrong_answer,exam_code,financial_year) 
			VALUES ( '".$_POST["exam_category"]."','".$_POST["exam_title"]."','".$_POST["examiner_id"]."' ,'".$_POST["asst_examiner_id"]."' ,'".$_POST["program_id"]."','".$_POST["term_id"]."',
			'".$_POST["paper_id"]."','".$dt."','".$_POST["exam_duration"]."',1,'".$_POST["total_question"]."',
			'".$_POST["marks_per_right_answer"]."','".$_POST["marks_per_wrong_answer"]."' ,'".$code."',2)
			";

			$object->execute();

			$success = '<div class="alert alert-success">Exam Added </div>';

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}
	

	if($_POST["action"] == 'fetch_single')
	{
		$table = $_POST["table"];
		
		$object->query = "
		SELECT * FROM $table 
		WHERE id = '".$_POST["exam_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			//print_r($row);
			$data['exam_title'] = $row['exam_title'];
			$data['examiner_id'] = $row['examiner_id'];
			$data['program_id'] = $row['program_id'];
			$data['term_id'] = $row['term_id'];
			$data['paper_id'] = $row['paper_id'];
			$data['exam_date_time'] = $row['exam_date_time'];
			$data['exam_duration'] = $row['exam_duration'];
			$data['total_question'] = $row['total_question'];
			$data['marks_per_right_answer'] = $row['marks_per_right_answer'];
			$data['marks_per_wrong_answer'] = $row['marks_per_wrong_answer'];
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$error = '';
//print_r($_POST);
		$success = '';
        $dt = date("Y-m-d H:i", strtotime($_POST["exam_datetime"]));
		//echo $dt ;exit;
        $title = $_POST['exam_title'];
		$exam_data = array(
				':exam_title'		=>	$title,
				':examiner_id'		=>	$_POST["examiner_id"],
				':program_id'		=>	$_POST["program_id"],
				':term_id'		    =>	$_POST["term_id"],
				':paper_id'		    =>	$_POST["paper_id"],
				':exam_date_time'	=>	$dt,
				':exam_duration'	=>	$_POST["exam_duration"],
				':total_question'	=>	$_POST["total_question"],
				':marks_per_right_answer'	=>	$_POST["marks_per_right_answer"],
				
			);
    
		$object->query = "
		UPDATE tbl_exam_master 
		SET exam_title = '".$title."',
		examiner_id = '".$_POST["examiner_id"]."' ,
		program_id = '".$_POST["program_id"]."',
		term_id = '".$_POST["term_id"]."',
		paper_id = '".$_POST["paper_id"]."',
		exam_date_time = '".$dt."',
		exam_duration = '".$_POST["exam_duration"]."',
		total_question = '".$_POST["total_question"]."',
		marks_per_right_answer = '".$_POST["marks_per_right_answer"]."'   
		      
		WHERE id = '".$_POST['hidden_id']."'
		";

		$object->execute();

		$success = '<div class="alert alert-success">Exam Updated</div>';
		
		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_result_publish_data')
	{
		$object->query = "
		SELECT * FROM exam_soes 
		WHERE exam_id = '".$_POST["exam_id"]."'
		";

		$result = $object->get_result();

		$exam_result_datetime = '';

		foreach($result as $row)
		{
			$exam_result_datetime = $row['exam_result_datetime'];
		}

		if($exam_result_datetime == '0000-00-00 00:00:00')
		{
			$exam_result_datetime = '';
		}

		echo $exam_result_datetime;
	}

	if($_POST['action'] == 'Result Publish')
	{
		$success = '';

		$data = array(
			':exam_result_datetime'		=>	$_POST["exam_result_publish_datetime"],
			':exam_id'					=>	$_POST["hidden_exam_id"]
		);

		$object->query = "
		UPDATE exam_soes 
		SET exam_result_datetime = :exam_result_datetime 
		WHERE exam_id = :exam_id
		";

		$object->execute($data);

		$output = array(
			'success'		=>	'Exam Result has been Publish'
		);
		echo json_encode($output);
	}

	if($_POST["action"] == 'delete')
	{

		$object->query = "
		DELETE FROM tbl_exam_master 
		WHERE id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Exam Deleted</div>';
	}

	
	if($_POST["action"] == 'remove_exam')
	{
        // echo "SELECT * FROM tbl_trainee_exam_info 
		// WHERE exam_id = '".$_POST["id"]."' ";

		$object->query = "
		SELECT * FROM tbl_trainee_exam_info 
		WHERE exam_id = '".$_POST["id"]."'
		";
		$result = $object->get_result();
		//print_r($result);
		foreach ($result as $res) {
			print_r($res);
			$object->query = "
			DELETE FROM tbl_exam_question_answer 
			WHERE trainee_exam_info_id = '".$res["id"]."'
			";

			$object->execute();
			
			$object->query = "
			DELETE FROM tbl_trainee_exam_info 
			WHERE id = '".$res["id"]."'
			";

			$object->execute();
		}

		$object->query = "
			DELETE FROM tbl_exam_master 
			WHERE id = '".$_POST["id"]."'
			";
		$object->execute();
		echo "success";
		
	}
	
	if($_POST["action"] == 'approval')
	{

		$object->query = "
		UPDATE tbl_exam_master 
		SET status = 2
		WHERE id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Exam Send To Tranning Inchaarge for Approval</div>';
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

}

?>