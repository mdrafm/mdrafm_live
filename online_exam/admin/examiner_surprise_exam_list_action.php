<?php

//exam_subject_question_action.php 

include('database.php');

$object = new database();

if (isset($_POST["action"])) {
    if ($_POST["action"] == 'fetch') {
        $order_column = array('m.exam_title');

        $output = array();
        

        $main_query = "
				
         SELECT  m.id,m.program_id,m.exam_title,m.total_question,m.set_question_paper,m.exam_category,m.trng_type, f.name as faculty_name, 
          m.exam_date_time,m.exam_duration,m.status,m.exam_code,m.trainee_attandance FROM `tbl_exam_master` m 
         JOIN `tbl_faculty_master` f ON m.examiner_id = f.id
         WHERE   m.exam_category = 3 AND  f.phone = " . $_SESSION['username'];

        $search_query = '';

        $search_query = '';

        if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '') {
            $search_query .= ' AND m.exam_title LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR pm.paper_code "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR t.term LIKE "%' . $_POST["search"]["value"] . '%" ';
        }

        if (isset($_POST["order"])) {
            $order_query = ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_query = ' ORDER BY m.exam_date_time DESC ';
        }

        $limit_query = '';

        if ($_POST["length"] != -1) {
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

        foreach ($result as $row) {
            $sub_array = array();
            $sub_array[] = html_entity_decode($row["exam_title"]);
          
            $sub_array[] = $row['exam_date_time'];
            $sub_array[] = $row['exam_duration'] . ' Minutes';
            $sub_array[] = $row['total_question'] . ' Qustions';

            $exam_code = '';
            if ($row['trainee_attandance'] == 1) {
                $exam_code = $row['exam_code'];
            }

           
            $exam_category = $row["exam_category"];
            $status = '';
            $action_button = '';
            $exam_id = $row["id"];
            $program_id = $row["program_id"];
            $trng_type = $row["trng_type"];

            if ($row['status'] == 4) {


                if ($row['set_question_paper'] == 0) {
                    $action_button = '
                <div  align="center">
                 <button type="button" id="set_qstn" class="btn btn-success  btn-sm" 
                   data-id="' . $row["id"] . '"
                    onclick = "setQuestion(' . $exam_id . ',' . $program_id . ',' . $trng_type . ')" >Set Qustion</button>
                <button type="button" id="set_qstn" class="btn btn-warning  btn-sm mt-1" 
                   data-id="' . $row["id"] . '"
                    onclick = "modifyTime(' . $exam_id . ',' . $program_id . ')" >Modify Time</button>
                </div>
                <input type="hidden" name="exam_id" value = "' . $row["id"] . '" >
                ';
                } else {
                    $action_button = '
                <div  align="center">
                 <button type="button" id="set_qstn" class="btn btn-success  btn-sm" 
                   data-id="' . $row["id"] . '"
                    onclick = "takeAttendance(' . $exam_id . ',' . $program_id . ',' . $trng_type . ')" >Take Attendance</button>

                <button type="button" id="set_qstn" class="btn btn-warning  btn-sm mt-1" 
                    data-id="' . $row["id"] . '"
                     onclick = "modifyTime(' . $exam_id . ',' . $program_id . ')" >Modify Time</button>
                </div>
                <button type="button" class="btn btn-success  btn-sm" data-id="' . $row["id"] . '"
                 onclick = "setQuestionInd(' . $exam_id . ',' . $program_id . ',' . $trng_type . ')" >Set Question Ind</button>

                <input type="hidden" name="exam_id" value = "' . $row["id"] . '" >
                ';
                }
            }
            if ($row['status'] == 5) {
                $action_button = '
                <div  align="center">
                 <button type="button" id="set_qstn" class="btn btn-success  btn-sm" 
                   data-id="' . $row["id"] . '"
                    onclick = "takeAttendance(' . $exam_id . ',' . $program_id . ')" >Take Attendance</button>

                <button type="button" id="set_qstn" class="btn btn-warning  btn-sm mt-1" 
                    data-id="' . $row["id"] . '"
                     onclick = "modifyTime(' . $exam_id . ',' . $program_id . ')" >Modify Time</button>
                </div>
                <input type="hidden" name="exam_id" value = "' . $row["id"] . '" >
                ';
            }
            if ($row['status'] == 6) {
                $action_button = '
                <div  align="center">
                <button type="button" id="set_qstn" class="btn btn-success  btn-sm" 
                onclick = "view_result(' . $exam_id . ','.$exam_category.','.$trng_type.')" >View Result</button>

                ';
            }

            // if($exam_row['status'] == 1)
            // {
            //     $status = '<span class="badge badge-success">Created</span>';
            // }   
            if ($row['status'] == 4) {
                $status = '<span class="badge badge-warning">Upcoming</span>';
            }
            if ($row['status'] == 5) {
                $status = '<span class="badge badge-success">Started</span>';
            }
            if ($row['status'] == 6) {
                $status = '<span class="badge badge-danger">Completed</span>';
            }
            $sub_array[] = $status;

            $sub_array[] = $action_button;
            $sub_array[] = $exam_code;
            $data[] = $sub_array;
        }
//print_r($data);
        $output = array(
            "draw"                =>     intval($_POST["draw"]),
            "recordsTotal"        =>     $total_rows,
            "recordsFiltered"     =>     $filtered_rows,
            "data"                =>     $data
        );

        echo json_encode($output);
    }
    if ($_POST["action"] == 'set_question') {
        $tota_qstn = $object->Get_exam_total_question($_POST['exam_id']);
        $qustion_paer_detail = $object->Get_question_paper_detail($_POST['exam_id']);

         $syllabus_id = $qustion_paer_detail[0];
         $paper_id = $qustion_paer_detail[1];
        $trng_type = $_POST['trng_type'];

        // print_r($tota_qstn);
        // exit;

        //exit ;
try {
    //code...
    //   $object->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //   $object->connect->beginTransaction();

        $error = '';

        $success = '';
if($trng_type == 3 || $trng_type == 4){
    $object->query = "
    SELECT u.id as user_id,m.exam_date_time,m.exam_duration,m.total_question,m.status FROM `tbl_dept_trainee_registration` r 
    JOIN `tbl_user` u ON u.id =r.user_id
    JOIN `tbl_exam_master` m ON r.program_id = m.program_id
    WHERE m.id = '" . $_POST['exam_id'] . "' AND r.program_id = '" . $_POST['program_id'] . "' ";
  
}else{
    $object->query = "
    SELECT u.id as user_id,m.exam_date_time,m.exam_duration,m.total_question,m.status FROM `tbl_new_recruite` r 
    JOIN `tbl_user` u ON r.phone = u.username 
    JOIN `tbl_exam_master` m ON r.program_id = m.program_id
    WHERE m.id = '" . $_POST['exam_id'] . "' AND r.program_id = '" . $_POST['program_id'] . "' ORDER BY r.f_name ";
}
        

        $res_data = $object->get_result();
        //print_r($res_data);exit;
        foreach ($res_data as $row) {
           
            $data = array(
                ':exam_id'          =>    $_POST['exam_id'],
                ':trainee_id'       =>    $row["user_id"],
                ':exam_date_time'   =>    $row["exam_date_time"],
                ':exam_duration'    =>    $row["exam_duration"]

            );
            //insert exam details
            $object->query = "
            INSERT INTO tbl_trainee_exam_info 
            (exam_id,trainee_id, exam_date_time, exam_duration) 
            VALUES (:exam_id,:trainee_id, :exam_date_time, :exam_duration)
            ";

            $object->execute($data);

            $trainee_info_id = $object->connect->lastInsertId();

           //$object->connect->commit(); 
//            echo $trainee_info_id;
//            echo  $object->query;
//            print_r($data);
// exit;
            //update set_question_paper   

//exit;
            $object->query = "
                UPDATE tbl_exam_master 
                SET set_question_paper = 1
                WHERE id = '" . $_POST["exam_id"] . "'
                ";

            $object->execute();

            //print_r($row);
            //$object->connect->commit(); 

            $object->query = "
            SELECT exam_subject_question_id
            FROM `surprise_test_question` WHERE exam_id = '" . $_POST["exam_id"] . "'
            ORDER BY rand() ";

            $res_qstn = $object->get_result();
           // print_r($res_qstn);
           
            $cnt = 0;
            foreach ($res_qstn as $row_qstn) {
                $cnt++;
                $data = array(
                    ':trainee_exam_info_id'    =>    $trainee_info_id,
                    ':qstn_sl_no' =>  $cnt,
                   
                    ':exam_question_id'    =>    $row_qstn["exam_subject_question_id"]

                );

                $object->query = "
                INSERT INTO tbl_exam_question_answer 
                (trainee_exam_info_id,qstn_sl_no,exam_question_id) 
                VALUES (:trainee_exam_info_id,:qstn_sl_no,:exam_question_id)
                 ";

                $object->execute($data);
                
                $last_id = $object->connect->lastInsertId();
                // print_r($data);
                // exit;
               // $object->connect->commit();
            }
            //exit;
        }
        echo "success";

    } catch (Exception $e) {
       // $object->connect->rollback(); 
       echo $e->getMessage();
    }
    }

    if ($_POST["action"] == 'set_ind_question') {
        $tota_qstn = $object->Get_exam_total_question($_POST['exam_id']);
       // $qustion_paer_detail = $object->Get_question_paper_detail($_POST['exam_id']);

        // $syllabus_id = $qustion_paer_detail[0];
       //$paper_id = $qustion_paer_detail[1];
        $trng_type = $_POST['trng_type'];
        $dept_trainee_id = $_POST['dept_trainee_id'];
        // print_r($tota_qstn);
        // exit;

        //exit ;
try {
    //code...
    //   $object->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //   $object->connect->beginTransaction();

        $error = '';

        $success = '';
if($trng_type == 3 || $trng_type == 4 ||  $trng_type == 5){
    $object->query = "
    SELECT u.id as user_id,m.exam_date_time,m.exam_duration,m.total_question,m.status FROM `tbl_dept_trainee_registration` r 
    JOIN `tbl_user` u ON u.id =r.user_id
    JOIN `tbl_exam_master` m ON r.program_id = m.program_id
    WHERE m.id = '" . $_POST['exam_id'] . "' AND r.id = '" . $_POST['dept_trainee_id'] . "' ";
  
}else{
    $object->query = "
    SELECT u.id as user_id,m.exam_date_time,m.exam_duration,m.total_question,m.status FROM `tbl_new_recruite` r 
    JOIN `tbl_user` u ON r.phone = u.username 
    JOIN `tbl_exam_master` m ON r.program_id = m.program_id
    WHERE m.id = '" . $_POST['exam_id'] . "' AND r.program_id = '" . $_POST['program_id'] . "' ORDER BY r.f_name ";
}
        

        $res_data = $object->get_result();
        //print_r($res_data);exit;
        foreach ($res_data as $row) {
           
            $data = array(
                ':exam_id'          =>    $_POST['exam_id'],
                ':trainee_id'       =>    $row["user_id"],
                ':exam_date_time'   =>    $row["exam_date_time"],
                ':exam_duration'    =>    $row["exam_duration"]

            );
            //insert exam details
            $object->query = "
            INSERT INTO tbl_trainee_exam_info 
            (exam_id,trainee_id, exam_date_time, exam_duration) 
            VALUES (:exam_id,:trainee_id, :exam_date_time, :exam_duration)
            ";

            $object->execute($data);

            $trainee_info_id = $object->connect->lastInsertId();

           
            $object->query = "
            SELECT exam_subject_question_id
            FROM `surprise_test_question` WHERE exam_id = '" . $_POST["exam_id"] . "'
            ORDER BY rand() ";

            $res_qstn = $object->get_result();
           // print_r($res_qstn);
           
            $cnt = 0;
            foreach ($res_qstn as $row_qstn) {
                $cnt++;
                $data = array(
                    ':trainee_exam_info_id'    =>    $trainee_info_id,
                    ':qstn_sl_no' =>  $cnt,
                   
                    ':exam_question_id'    =>    $row_qstn["exam_subject_question_id"]

                );

                $object->query = "
                INSERT INTO tbl_exam_question_answer 
                (trainee_exam_info_id,qstn_sl_no,exam_question_id) 
                VALUES (:trainee_exam_info_id,:qstn_sl_no,:exam_question_id)
                 ";

                $object->execute($data);
                
                $last_id = $object->connect->lastInsertId();
                // print_r($data);
                // exit;
               // $object->connect->commit();
            }
            //exit;
        }
        echo "success";

    } catch (Exception $e) {
       // $object->connect->rollback(); 
       echo $e->getMessage();
    }
    }

    if ($_POST['action'] == "modify_exam_time") {

        //print_r($_POST);

        $object->query = "
    SELECT set_question_paper 
    FROM `tbl_exam_master` 
    WHERE id = '" . $_POST["exam_id"] . "' ";

        $set_question_paper = '';

        $res = $object->get_result();

        foreach ($res as $row) {
            $set_question_paper = $row['set_question_paper'];
        }

        $dt = date("Y-m-d H:i", strtotime($_POST["exam_datetime"]));
        $object->query = "
    UPDATE tbl_exam_master 
    SET reasion_modify_exam_time = '" . $_POST["time_modify_reseasion"] . "',
    exam_date_time = '" . $dt . "'
    WHERE id = '" . $_POST["exam_id"] . "'
    ";

        $object->execute();

        if ($set_question_paper == 1) {

            $object->query = "
        UPDATE tbl_trainee_exam_info 
        SET exam_date_time = '" . $dt . "'
        WHERE exam_id = '" . $_POST["exam_id"] . "'
        ";
            $object->execute();
        }

        echo 'success';
    }


    if ($_POST["action"] == 'trainee_atn') {
        $exam_id = $_POST["exam_id"];
        $program_id = $_POST["program_id"];
        $trng_type = $_POST["trng_type"];
        
        $object->query = " SELECT * FROM `tbl_exam_master` WHERE id =  $exam_id ";
        $result = $object->get_result();
        $exam_date_time = '';

        foreach ($result as $row_data) {

            $minutes_to_add = $row_data['exam_duration'];

            $time = new DateTime($row_data['exam_date_time']);
            $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

            $exam_date_time = $time->format('Y-m-d H:i');
        }


?>
        <table class="table table-bordered" id="trainne_attn_table" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Exam Date & Time</th>
                    <th>Exam Duration</th>
                    <th style="width:135px">Attendance <br>
                        <label class="form-check-label">Present All</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input class="form-check-input checkAll2" type="checkbox" id="checkAll">


                    </th>

                </tr>
            </thead>
            <tbody>
                <?php
                if($trng_type == 3 || $trng_type == 4){
                    $object->query = "
                    SELECT e.*,d.name as trainee_name,i.phone as mobile,e.attandance FROM `tbl_trainee_exam_info` e 
                    JOIN `tbl_dept_trainee_registration` i ON e.trainee_id = i.user_id
                    JOIN `tbl_trainee_details` d ON i.trainee_detail_id = d.id
                    WHERE e.exam_id = $exam_id  AND i.program_id = $program_id AND i.trng_type = $trng_type
                    ORDER BY trainee_name ";
                }else{
                    $object->query = "
                    SELECT e.*,CONCAT(i.first_name,' ',i.last_name)as trainee_name,i.mobile,d.photo,e.attandance FROM `tbl_trainee_exam_info` e 
                    JOIN `tbl_traniee_documents` d ON e.trainee_id = d.user_id 
                    JOIN `tbl_trainee_info` i ON e.trainee_id = i.user_id
                    WHERE e.exam_id = $exam_id
                    ORDER BY trainee_name ";
                }
                

                $res_data = $object->get_result();
                print_r($res_data);
                $count = 0;
                foreach ($res_data as $row) {

                    $count++;
                ?>
                    <tr>
                        <td>
                            <?php echo $count; ?>
                            <input type="hidden" name="trainne_info_id" id="trainne_info_id" value="<?php echo $row['id']; ?>">
                        </td>
                        <td>
                            <img src="<?php echo $object->base_url . '../admin/uploads/' . $row['photo']; ?>" alt="image" class="img-fluid img-thumbnail" width="75" height="75" />
                        </td>
                        <td><?php echo $row['trainee_name']; ?></td>
                        <td><?php echo $row['mobile']; ?></td>
                        <td><?php echo $row['exam_date_time']; ?></td>
                        <td><?php echo $row['exam_duration'] . ' Minutes'; ?></td>
                        <td style="width:135px">
                            <div class='atten' id="attendance_<?php echo  $row['exam_id'] ?>">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="inlineCheckbox1">Present</label>
                                    &nbsp;&nbsp;
                                    <input class="form-check-input" type="checkbox" name="atten" id="present" value="1" <?php echo ($row['attandance'] == 1) ? 'checked' : '' ?> style="opacity: 1;visibility: visible;">
                                </div>

                            </div>
                            </div>
                        </td>



                    </tr>
                <?php
                }
                ?>
            </tbody>
    <?php
    }

    if ($_POST["action"] == 'save_attandance') {
        $tableData = stripcslashes($_POST['tableData']);

        $object->query = "
		UPDATE tbl_exam_master 
		SET trainee_attandance = 1
		WHERE id = '" . $_POST["exam_id"] . "'
		";

        $object->execute();

        // Decode the JSON array
        $tableData = json_decode($tableData, TRUE);

        foreach ($tableData as $data) {
            //print_r($data);
            $attendance =  isset($data['attandance']) ? '1' : '0';

            if ($attendance == 1) {
                $object->query = "
                UPDATE tbl_trainee_exam_info 
                SET attandance = 1
                WHERE id = '" . $data['trainee_id'] . "'
                ";

                $object->execute();
            }
        }
        echo 'success';
    }

    if ($_POST["action"] == 'update_exam_status') {

        $object->query = "
		UPDATE tbl_exam_master 
		SET status = '" . $_POST["status"] . "'
		WHERE id = '" . $_POST["exam_id"] . "'
		";

        $object->execute();
        echo 'success';
    }
}

    ?>