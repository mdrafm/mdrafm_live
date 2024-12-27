<?php

//exam_action.php

include('database.php');

$object = new database();
//print_r($_POST);

if (isset($_POST["action"])) {
	if ($_POST["action"] == 'fetch') {

		// SELECT m.id,m.exam_title,f.name as faculty_name,p.prg_name as program_name,t.term,pm.paper_code,
		// m.exam_date_time,m.exam_duration,m.status,m.exam_code FROM `tbl_exam_master` m 
		//   JOIN `tbl_faculty_master` f ON m.examiner_id = f.id
		//   JOIN `tbl_program_master` p ON m.program_id = p.id
		//   JOIN `tbl_term_master` t ON m.term_id = t.id
		//   JOIN `tbl_paper_master` pm ON m.paper_id = pm.id;

		$order_column = array(
			'm.id', 'm.exam_title', 'f.name', 'p.prg_name',
			't.term', 'pm.paper_code', 'm.exam_date_time', 'm.exam_duration', 'm.status', 'm.exam_code'
		);

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

		if (isset($_POST["search"]["value"])) {
			$search_query .= ' m.exam_title LIKE "%' . $_POST["search"]["value"] . '%" ';
			$search_query .= 'OR f.name LIKE "%' . $_POST["search"]["value"] . '%" ';
			$search_query .= 'OR p.prg_name LIKE "%' . $_POST["search"]["value"] . '%" ';
			$search_query .= 'OR pm.paper_code LIKE "%' . $_POST["search"]["value"] . '%" ';
			$search_query .= 'OR m.exam_duration LIKE "%' . $_POST["search"]["value"] . '%" ';
		}

		if (isset($_POST["order"])) {
			$order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$order_query = 'ORDER BY m.id DESC ';
		}

		$limit_query = '';

		if ($_POST["length"] != -1) {
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

		foreach ($result as $row) {
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

			if ($row['status'] == 1) {
				$status = '<span class="badge badge-warning">Pending</span>';
				$action_button = '
					<div align="center">
					<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="' . $row["id"] . '"><i class="fas fa-edit"></i></button>
					&nbsp;
					<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="' . $row["id"] . '"><i class="fas fa-times"></i></button>
					</div>
					';
			}

			if ($row['status'] == 0) {
				$status = '<span class="badge badge-success">Created</span>';
				$action_button = '';
			}

			if ($row['status'] == '5') {
				$status = '<span class="badge badge-primary">Started</span>';
				$action_button = '';
			}

			if ($row['status'] == '6') {
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
	function generateRandomString($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	if ($_POST["action"] == 'Add') {
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

			':paper_id'		    =>	$_POST["paper_id"],
			':exam_date_time'	=>	$dt,
			':exam_duration'	=>	$_POST["exam_duration"],
			':total_question'	=>	$_POST["total_question"],
			':marks_per_right_answer'	=>	$_POST["marks_per_right_answer"],
			':marks_per_wrong_answer'	=>	$_POST["marks_per_wrong_answer"],
			':status'			=>	4,
			//':exam_created_on'		=>	$object->now,
			':exam_code'		=>	$code,
		);


		$object->query = "
			INSERT INTO tbl_exam_master 
			(exam_category,exam_title, examiner_id,asst_examiner_id, program_id, paper_id, exam_date_time,exam_duration,status,
			total_question,marks_per_right_answer,marks_per_wrong_answer,exam_code,financial_year) 
			VALUES ( '" . $_POST["exam_category"] . "','" . $_POST["exam_title"] . "','" . $_POST["examiner_id"] . "' ,'" . $_POST["asst_examiner_id"] . "' ,'" . $_POST["program_id"] . "',
			'" . $_POST["paper_id"] . "','" . $dt . "','" . $_POST["exam_duration"] . "',4,'" . $_POST["total_question"] . "',
			'" . $_POST["marks_per_right_answer"] . "','" . $_POST["marks_per_wrong_answer"] . "' ,'" . $code . "',2)
			";

		$object->execute();

		$success = '<div class="alert alert-success">Exam Added </div>';

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);
	}


	if ($_POST["action"] == 'fetch_single') {
		$table = $_POST["table"];

		$object->query = "
		SELECT * FROM $table 
		WHERE id = '" . $_POST["exam_id"] . "'
		";

		$result = $object->get_result();

		$data = array();

		foreach ($result as $row) {
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

	if ($_POST["action"] == 'Edit') {
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
		SET exam_title = '" . $title . "',
		examiner_id = '" . $_POST["examiner_id"] . "' ,
		program_id = '" . $_POST["program_id"] . "',
		term_id = '" . $_POST["term_id"] . "',
		paper_id = '" . $_POST["paper_id"] . "',
		exam_date_time = '" . $dt . "',
		exam_duration = '" . $_POST["exam_duration"] . "',
		total_question = '" . $_POST["total_question"] . "',
		marks_per_right_answer = '" . $_POST["marks_per_right_answer"] . "'   
		      
		WHERE id = '" . $_POST['hidden_id'] . "'
		";

		$object->execute();

		$success = '<div class="alert alert-success">Exam Updated</div>';

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);
	}


	if ($_POST['action'] == 'add_extra_time') {
		//  print_r($_POST);
		//  exit;

		 $exam_id = $_POST["exam_id"];
		$tableData = stripcslashes($_POST['tableData']);
		
		$tableData = json_decode($tableData,TRUE);

		foreach($tableData as $data){
            $success = '';
			$trainee_id = $data['trainee_id'];
			$exam_duration = '';
			$object->query = "
			SELECT id,exam_duration  FROM `tbl_trainee_exam_info` WHERE `exam_id` = $exam_id AND trainee_id = $trainee_id " ;
			
			$res_data = $object->get_result();

			foreach($res_data as $row_data)
		    {
                 $exam_duration = $row_data['exam_duration'];
			}

			$new_exam_duration = $_POST['exam_extra_time'] + $exam_duration;
			$data = array(
				':exam_duration'		=>	$new_exam_duration,
				':id'				=>	$row_data['id'],

			);

			$object->query = "
			UPDATE tbl_trainee_exam_info 
			SET exam_duration = :exam_duration 
			WHERE id = :id
			";

			$object->execute($data);

			$output = array(
				'success'		=>	'Extra Time Given'
			);
			
		}

		echo json_encode($output);
		exit;
	}

	if ($_POST["action"] == 'exam_trainee_list') {
		$exam_id = $_POST["exam_id"];
		$action_type = $_POST["action_type"];

?>
		<table class="table table-bordered" id="trainne_table" width="100%" cellspacing="0">

			<thead>
				<tr>
					<th>Sl No</th>
					<th>Name</th>
					<th>Phone</th>
					<th>exam_duration</th>

					<?php
					echo ($action_type == 'extra_time') ? "<th>Action  <label class='form-check-label'> All</label>
					 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input class='form-check-input checkAll2' type='checkbox' id='checkAll'> </th>" : "<th>Action</th> <th>Exam Status</th>";
					?>

			<tbody>
				<?php
				$object->query = "
							 SELECT i.exam_id,i.trainee_id,u.username,u.name,i.exam_duration,i.exam_status FROM `tbl_trainee_exam_info` i 
							 JOIN `tbl_user` u ON i.trainee_id = u.id WHERE i.exam_id = $exam_id ";

				$res_data = $object->get_result();
				// print_r($res_data);
				$count = 0;
				$action_button = '';
				foreach ($res_data as $row) {

					$count++;
					$trainee_id = $row['trainee_id'];
					if ($row['exam_status'] == 1) {
						$action_button = '
									<div  align="center">
									<button type="button" id="set_qstn" class="btn btn-success allow_agn  btn-sm" 
									data-exam_id="' . $row["exam_id"] . '" data-trainee_id="' . $row["trainee_id"] . '" >Allow</button>
									</div>
									';
					}
				?>
					<tr>
						<td><?php echo $count; ?>
							<input type="hidden" name="trainne_id" id="trainne_id" value="<?php echo $row["trainee_id"]; ?>">
						</td>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['username']; ?></td>
						<td><?php echo $row['exam_duration'].' Minutes' ?></td>
						<?php
						if ($action_type == 'extra_time') {
						?><td>
								<div class='atten' id="trainee<?php echo  $row['exam_id'] ?>">
									<div class="form-check form-check-inline">
										<label class="form-check-label" for="inlineCheckbox1">select</label>
										&nbsp;&nbsp;
										<input class="form-check-input" type="checkbox" name="trainne" id="trainne" value="1" style="opacity: 1;visibility: visible;">
									</div>

								</div>
							</td>
						<?php
						} else {
						?>
							<td><?php echo ($row['exam_status'] == 1) ? 'Complite' : 'Not'; ?></td>
							<td><?php echo $action_button; ?> </td>
						<?php
						}
						?>

					</tr>




				<?php
					$action_button = '';
				}
				?>
			</tbody>

			</tr>
			</thead>
		</table>
<?php
	}


if ($_POST["action"] == 'active_trainee') {
	$exam_id = $_POST["exam_id"];
	$trainee_id = $_POST["trainee_id"];
    

	$data = array(
		':exam_status' => 0,
		':exam_id'		=>	$exam_id,
		':trainee_id'   =>	$trainee_id,

	);

	$object->query = "
	UPDATE tbl_trainee_exam_info 
	SET exam_status = :exam_status 
	WHERE exam_id = :exam_id AND trainee_id= :trainee_id
	";

	$object->execute($data);

	$output = array(
		'success'		=>	'success'
	);
exit;
}

	if ($_POST["action"] == 'delete') {

		$object->query = "
		DELETE FROM tbl_exam_master 
		WHERE id = '" . $_POST["id"] . "'
		";

		$object->execute();

		echo '<div class="alert alert-success">Exam Deleted</div>';
	}


	if ($_POST["action"] == 'remove_exam') {
		// echo "SELECT * FROM tbl_trainee_exam_info 
		// WHERE exam_id = '".$_POST["id"]."' ";

		$object->query = "
		SELECT * FROM tbl_trainee_exam_info 
		WHERE exam_id = '" . $_POST["id"] . "'
		";
		$result = $object->get_result();
		//print_r($result);
		foreach ($result as $res) {
			print_r($res);
			$object->query = "
			DELETE FROM tbl_exam_question_answer 
			WHERE trainee_exam_info_id = '" . $res["id"] . "'
			";

			$object->execute();

			$object->query = "
			DELETE FROM tbl_trainee_exam_info 
			WHERE id = '" . $res["id"] . "'
			";

			$object->execute();
		}

		$object->query = "
			DELETE FROM tbl_exam_master 
			WHERE id = '" . $_POST["id"] . "'
			";
		$object->execute();
		echo "success";
	}

	if ($_POST["action"] == 'approval') {

		$object->query = "
		UPDATE tbl_exam_master 
		SET status = 2
		WHERE id = '" . $_POST["id"] . "'
		";

		$object->execute();

		echo '<div class="alert alert-success">Exam Send To Tranning Inchaarge for Approval</div>';
	}

	if ($_POST["action"] == 'select_paper') {

		$object->query = " SELECT p.id,p.paper_code,p.paper_title FROM `tbl_mid_program_master`mp JOIN `tbl_mid_paper_master` p ON mp.syllabus_id = p.syllabus_id

		WHERE mp.id = '" . $_POST["program_id"] . "' ";

		$result = $object->get_result();

		echo '<option value="0" >Select term</option>';
		foreach ($result as $row) {
			echo '<option value="' . $row['id'] . '">' . $row['paper_code'] . '-' . $row['paper_title'] . '</option>';
		}
	}
}

?>
<script>
	function add_extra_time(exam_id, exam_duration) {
      let  exam_extra_time = $('#exam_extra_time').val();
		TableData = storeTblValues();
		TableData = JSON.stringify(TableData);
		//console.log(storeTblValues());

		$.ajax({
			url: 'mid_term_exam_action.php',
			type: "POST",
			data: {
				'action': 'add_extra_time',
				'tableData': TableData,
				'exam_id': exam_id,
				'exam_duration': exam_duration,
				'exam_extra_time':exam_extra_time

			},

			success: function(data) {
				console.log(data)
				// if (data.trim() == 'success') {
				//     $('#traineeAttendanceModal').modal('hide');
				//     location.reload();
				// }
			}
		});
	}

	

	function storeTblValues() {
		var TableData = new Array();
		$('#trainne_table tr').each(function(row, tr) {
			let trainee_id = $(tr).find('input[type="checkbox"]:checked').val();
			if (trainee_id == 1) {
				TableData[row] = {
					"trainee_id": $(tr).find('input[type="hidden"]').val(),
					"trainee_list": $(tr).find('input[type="checkbox"]:checked').val()

				}
			}
		});
		TableData.shift(); // first row will be empty - so remove
		return TableData;
	}
</script>