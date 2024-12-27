<?php

//soes.php

class database
{
	public $base_url;
	public $connect;
	public $query;
	public $statement;
	public $now;

	function database()
	{
		if (file_exists(dirname(__DIR__) . '/install/credential.inc'))
		{
			include(dirname(__DIR__) . '/install/credential.inc');
			try{

				$this->connect = new PDO("mysql:host=$gdb_host;dbname=$gdb_name", $gdb_user_name, $gdb_password);
				
				//$this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				date_default_timezone_set('Asia/Kolkata');

				session_start();

				$this->now = date("Y-m-d H:i:s",  STRTOTIME(date('h:i:sa')));

				$this->base_url = $gbase_url;


				// if($this->if_table_exists())
				// {
				// 	if($this->if_master_exists())
				// 	{
				// 		return true;
				// 	}
				// 	else
				// 	{
				// 		header('location:'.$gbase_url.'install/set_up_master.php');
				// 	}
				// }
				

			}
			catch(PDOException $e){
				header('location:'.$gbase_url.'install/set_up.php');
			}
		}
		else
		{
			$dir_array = explode("/", dirname($_SERVER['PHP_SELF']));
			if(end($dir_array) == 'admin')
			{
				header('location:../install/set_up.php');
			}
			else
			{
				header('location:install/set_up.php');
			}
		}

		
	}

	function execute($data = null)
	{
		// print_r($this->query);
		// print_r($data);
		try{
			$this->statement = $this->connect->prepare($this->query);
			if($data)
			{
				//print_r($this->statement);;
				$this->statement->execute($data);
				//echo $this->statement->rowCount();
			}
			else
			{
				//print_r($this->statement);;
				$this->statement->execute();
			}	
		}
		catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		  }
			
	}

	function row_count()
	{
		return $this->statement->rowCount();
	}

	function statement_result()
	{
		return $this->statement->fetchAll();
	}

	function get_result()
	{
		//echo $this->query;
		return $this->connect->query($this->query, PDO::FETCH_ASSOC);
	}

	

	function is_login()
	{
		if(isset($_SESSION['user_id']))
		{
			return true;
		}
		return false;
	}

	function is_master_user()
	{
		if(isset($_SESSION['user_type']))
		{
			if($_SESSION["user_type"] == 'Master')
			{
				return true;
			}
			return false;
		}
		return false;
	}

	function is_student_login()
	{
		if(isset($_SESSION['student_id']))
		{
			return true;
		}
		return false;
	}

	function clean_input($string)
	{
	  	$string = trim($string);
	  	$string = stripslashes($string);
	  	$string = htmlspecialchars($string);
	  	return $string;
	}

	function Get_program_name($program_id,$table)
	{
		// echo $sql = "SELECT prg_name FROM $table 
		// WHERE id = '$program_id'";

		$this->query = "
		SELECT prg_name FROM $table 
		WHERE id = '$program_id'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["prg_name"];
		}
	}

	function Check_subject_already_added_in_exam($exam_id, $subject_id)
	{
		$this->query = "
		SELECT exam_subject_id FROM subject_wise_exam_detail 
		WHERE exam_id = '$exam_id' 
		AND subject_id = '$subject_id'
		";

		$this->execute();

		if($this->row_count() > 0)
		{
			return true;
		}
		return false;
	}

	function Get_exam_name($exam_id)
	{
		$this->query = "
		SELECT exam_title FROM exam_soes 
		WHERE exam_id = '$exam_id'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["exam_title"];
		}
	}

	function Get_exam_duration($exam_id)
	{
		$this->query = "
		SELECT exam_duration FROM exam_soes 
		WHERE exam_id = '$exam_id'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["exam_duration"];
		}
	}

	function Get_question_option_data($exam_subject_question_id, $option_number)
	{
		$this->query = "
		SELECT question_option_title FROM question_option 
		WHERE exam_subject_question_id = '$exam_subject_question_id' 
		AND question_option_number = '$option_number'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row['question_option_title'];
		}
	}

	function Get_exam_total_question($exam_id)
	{
		$this->query = "
		SELECT total_question FROM tbl_exam_master 
		WHERE id = '$exam_id'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row['total_question'];
		}
	}

	function Can_add_question_in_this_subject($exam_subject_id)
	{
		$this->query = "
		SELECT subject_total_question FROM subject_wise_exam_detail 
		WHERE exam_subject_id = '$exam_subject_id'
		";

		$allow_question = 0;

		$result = $this->get_result();
		foreach($result as $row)
		{
			$allow_question = $row["subject_total_question"];
		}

		$this->query = "
		SELECT * FROM exam_subject_question_soes 
		WHERE exam_subject_id = '$exam_subject_id'
		";

		$this->execute();

		$total_question = $this->row_count();

		if($total_question >= $allow_question)
		{
			return false;
		}

		return true;
	}


	function Get_Class_subject($class_id)
	{
		$this->query = "
		SELECT subject_name FROM subject_soes 
		WHERE class_id = '$class_id' 
		AND subject_status = 'Enable'
		";
		$result = $this->get_result();
		$data = array();
		foreach($result as $row)
		{
			$data[] = $row["subject_name"];
		}
		return $data;
	}

	function Get_user_name($user_id)
	{
		$this->query = "
		SELECT * FROM user_soes 
		WHERE user_id = '".$user_id."'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			if($row['user_type'] != 'Master')
			{
				return $row["user_name"];
			}
			else
			{
				return 'Master';
			}
		}
	}

	function Get_Subject_name($subject_id)
	{
		$this->query = "
		SELECT subject_name FROM subject_soes 
		WHERE subject_id = '$subject_id'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["subject_name"];
		}
	}

	function Get_student_question_answer_option($exam_question_id, $trainee_exam_info_id)
	{
		$this->query = "
		SELECT trainee_ans_option FROM tbl_exam_question_answer 
		WHERE trainee_exam_info_id = '".$trainee_exam_info_id."' 
		AND exam_question_id = '".$exam_question_id."'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["trainee_ans_option"];
		}
	}

	function Get_question_answer_option($question_id)
	{
		$this->query = "
		SELECT exam_subject_question_answer FROM exam_subject_question 
		WHERE exam_subject_question_id = '".$question_id."' 
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["exam_subject_question_answer"];
		}
	}

	function Get_question_right_answer_mark($exam_id)
	{
		$this->query = "
		SELECT marks_per_right_answer FROM tbl_exam_master 
		WHERE id = '".$exam_id."' 
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["marks_per_right_answer"];
		}
	}
	function Get_question_wrong_answer_mark($exam_id)
	{
		$this->query = "
		SELECT marks_per_wrong_answer FROM tbl_exam_master 
		WHERE id = '".$exam_id."' 
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["marks_per_wrong_answer"];
		}
	}

	function Get_exam_id($exam_code)
	{
		$this->query = "
		SELECT exam_id FROM exam_soes 
		WHERE exam_code = '$exam_code'
		";

		$result = $this->get_result();

		foreach($result as $row)
		{
			return $row['exam_id'];
		}
	}

	function Get_exam_subject_id($exam_subject_code)
	{
		$this->query = "
		SELECT exam_subject_id FROM subject_wise_exam_detail 
		WHERE subject_exam_code = '$exam_subject_code'
		";

		$result = $this->get_result();

		foreach($result as $row)
		{
			return $row['exam_subject_id'];
		}
	}

	function send_email($receiver_email, $subject, $body)
	{
		$mail = new PHPMailer;

		$mail->IsSMTP();

		$mail->Host = '';

		$mail->Port = '587';

		$mail->SMTPAuth = true;

		$mail->Username = '';

		$mail->Password = '';

		$mail->SMTPSecure = 'tls';

		$mail->From = 'info@webslesson.info';
		
		$mail->FromName = 'info@webslesson.info';

		$mail->AddAddress($receiver_email, '');

		$mail->WordWrap = 50;      
		
		$mail->IsHTML(true);

		$mail->Subject = $subject;

		$mail->Body = $body;

		$mail->Send();
	}

	
	function Get_total_classes()
	{
		$this->query = "
		SELECT COUNT(class_id) as Total 
		FROM class_soes 
		WHERE class_status = 'Enable'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["Total"];
		}
	}

	function Get_total_subject()
	{
		$this->query = "
		SELECT COUNT(subject_id) as Total 
		FROM subject_soes 
		WHERE subject_status = 'Enable'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["Total"];
		}
	}

	function Get_total_student()
	{
		$this->query = "
		SELECT COUNT(student_id) as Total 
		FROM student_soes 
		WHERE student_status = 'Enable'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["Total"];
		}
	}

	function Get_total_exam()
	{
		$this->query = "
		SELECT COUNT(exam_id) as Total 
		FROM exam_soes 
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["Total"];
		}
	}

	function Get_total_result()
	{
		$this->query = "
		SELECT COUNT(exam_id) as Total 
		FROM exam_soes 
		WHERE exam_result_datetime != '0000-00-00 00:00:00' 
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["Total"];
		}
	}

	// function if_table_exists()
	// {
	// 	$this->query = "
	// 	SHOW TABLES
	// 	";

	// 	$this->execute();

	// 	if($this->row_count() > 0)
	// 	{
	// 		return true;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
    // }

  
    function if_master_exists()
	{
		$this->query = "
		SELECT * FROM tbl_user 
		WHERE roll_id = '18' 
		AND status = '1'
		";
		$this->execute();
		if($this->row_count() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}


?>