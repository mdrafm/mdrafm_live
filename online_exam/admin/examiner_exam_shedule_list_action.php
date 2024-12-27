<?php

//exam_subject_question_action.php

include('database.php');

$object = new database();

if(isset($_POST["action"]))
{
    if($_POST["action"] == 'fetch')
	{
        $order_column = array('m.exam_title');

		$output = array();
        $trng_type = 0;
       $object->query  = "SELECT m.trng_type
        FROM `tbl_exam_master` m 
        JOIN `tbl_trainee_exam_info` i ON m.id = i.exam_id
        WHERE i.trainee_id = '".$_SESSION['user_id']."'";
        $object->execute();
        $trng_type_res = $object->get_result();
       //echo ($trng_type_res[0]['trng_type']);
        foreach($trng_type_res as $row_type)
        {
            //echo $row_type['trng_type'];
            $trng_type = $row_type['trng_type'];
        }

       
        if($trng_type == 4){
            $main_query = "
                     SELECT m.id,m.exam_title,i.exam_date_time,i.exam_duration,m.total_question,m.status,i.exam_status
                    FROM `tbl_exam_master` m 
                    JOIN `tbl_trainee_exam_info` i ON m.id = i.exam_id
                    WHERE i.trainee_id = '".$_SESSION['user_id']."'" ;
        }else{
            $main_query = "
         SELECT m.id,m.exam_title,i.exam_date_time,i.exam_duration,m.total_question,m.status,p.paper_code,p.title as paper_title ,i.exam_status
        FROM `tbl_exam_master` m 
        JOIN `tbl_paper_master` p ON m.paper_id = p.id
        JOIN `tbl_trainee_exam_info` i ON m.id = i.exam_id
        WHERE i.trainee_id = '".$_SESSION['user_id']."'" ;
        }
		 

		$search_query = '';

        $search_query = '';

		if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '' )
		{
			$search_query .= ' AND m.exam_title LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR p.paper_code "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR m.status LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = ' ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = ' ORDER BY m.exam_date_time DESC ';
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
     //print_r($result);

		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = html_entity_decode($row["exam_title"]);
            if($trng_type == 4){
                $sub_array[] = "NA";
            }else{
                $sub_array[] = html_entity_decode($row["paper_code"]);
            }
			
			
			$sub_array[] = $row['exam_date_time'];
			$sub_array[] = $row['exam_duration'].' Minutes';
			$sub_array[] = $row['total_question'].' Qustions';
			
            $status = '';
            $action_button = '';
            if($row['status'] == 4)
            {
                $status = '<span class="badge badge-warning">Upcoming</span>';
               
            }

            if($row['status'] == 4 )
            {
               if($row['exam_status'] == 1){
                // $action_button = '
                // <div  align="center">
                //  <button type="button" id="set_qstn" class="btn btn-danger  btn-sm" 
                //    data-id="'.$row["id"].'"
                //     onclick = "view_result('.$row["id"].')" >View Result</button>
                // </div>
                // ';
                 $status = '<span class="badge badge-success">Complete</span>';
               }else{
                $action_button = '
                <div  align="center">
                 <button type="button" id="set_qstn" class="btn btn-success  btn-sm" 
                   data-id="'.$row["id"].'"
                    onclick = "start_exam('.$row["id"].')" >Start exam</button>
                </div>
                ';
               }
               
                
            }

            // if($exam_row['status'] == 1)
            // {
            //     $status = '<span class="badge badge-success">Created</span>';
            // }   
            

            if($row['status'] == '5')
            {
                $status = '<span class="badge badge-dark">Started</span>';
                $action_button = '
                <div  align="center">
                 <button type="button" id="set_qstn" class="btn btn-success  btn-sm" 
                   data-id="'.$row["id"].'"
                    onclick = "start_exam('.$row["id"].')" >Start exam</button>
                </div>
                ';
                
            }
            if($row['status'] == '6')
            {
                $status = '<span class="badge badge-dark">Complete</span>';
                 $action_button = '
                // <div  align="center">
                //  <button type="button" id="set_qstn" class="btn btn-danger  btn-sm" 
                //    data-id="'.$row["id"].'"
                //     onclick = "view_result('.$row["id"].')" >View Result</button>
                // </div>
                ';
                
            }
            $sub_array[] = $status;

			$sub_array[] = $action_button;

			$data[] = $sub_array;
		}
print_r($data);
		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		//echo json_encode($output);

    }

    if($_POST["action"] == 'start_exam'){
       
        $exam_id = $_POST["exam_id"];
        $user_id = $_POST["user_id"];
        $secret_code = $_POST["secret_code"];
//exit;
        
        $object->query = "SELECT i.*,m.exam_code FROM `tbl_trainee_exam_info` i JOIN `tbl_exam_master` m ON i.exam_id = m.id 
        WHERE m.id = '".$exam_id."' AND i.trainee_id = ".$user_id;

       $object->execute();

       $result = $object->get_result();
       foreach ($result as $row){
        //print_r( $row);
        $error = '';
        $url = '';

        if($row['attandance'] == 0){
            $error = '<div class="alert alert-danger">Your Attandace not taken ! Please Contact to Examinner</div>';
        }
        else if($row['exam_code'] !== $secret_code){
            $error = '<div class="alert alert-danger">Exam Secret Code Does not Match ! Please Contact to Examinner</div>';
        }
        else{
            //$url = $object->base_url . 'admin/start_online_exam.php';
            $url = $object->base_url . 'admin/before_start_exam.php';
            $_SESSION['exam_id'] = $exam_id;
        }
        
        $output = array(
            'error'		=>	$error,
            'url'		=>	$url
        );

        echo json_encode($output);


       } 

    }
    
}

?>