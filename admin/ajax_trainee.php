<?php


include 'database.php';
include 'helper.php';
 

$db = new Database();
$hp = new Helper($db);

if (isset($_POST['action']) && $_POST['action'] == 'feedback') {

    // print_r($_POST);
    $attn_id = $_POST['id'];
    $feedback = $_POST['feedBack'];

    //echo  $feedback;exit;
    $db->insert('tbl_feedback', ['attendance_id' => $attn_id, 'feedback' => $feedback, 'status' => 1]);
    $res = $db->getResult();
    //print_r($res);
    if ($res) {
        echo "success";
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'post_feedback') {

    $trng_type = $_POST['trng_type'];
    $program_id = $_POST['program_id'];
    $username = $_POST['username'];
    $suggestion = $_POST['suggestion'];

    $db->insert('tbl_post_trng_feedback', ['program_id' => $program_id, 'trng_type' => $trng_type, 'username' => $username, 'suggestion' => $suggestion]);
    $res = $db->getResult();

    $last_insert_id = $res[0];
    // if($res){
    //     echo "success";
    // }

    $tableData = stripcslashes($_POST['tableData']);

    // Decode the JSON array
    $tableData = json_decode($tableData, TRUE);
    //print_r($tableData);

    foreach ($tableData as $row) {
        // print_r($row);
        if (!isset($row['feedback'])) {
            $feedback = 0;
        } else {
            $feedback = $row['feedback'];
        }

        $db->insert('tbl_post_trng_feedback_data', ['post_feedback_id' => $last_insert_id, 'feedback_name_id' => $row['feedback_name_id'], 'feedback' => $feedback]);
        $res2 = $db->getResult();
        if ($res2) {

            echo "success#";
        } else {

            echo "error#" . $res2[0];
        }

        // echo $field;

    }
}

if (isset($_POST['action']) && $_POST['action'] == 'update_post_feedback') {
    $edit_id = $_POST['edit_id'];
    $program_id = $_POST['program_id'];
    $suggestion = $_POST['suggestion'];

    $db->update('tbl_post_trng_feedback', ['suggestion' => $suggestion], 'id=' . $edit_id);
    $res = $db->getResult();

    if ($res) {

        echo "success#";
    } else {

        echo "error#" . $res[0];
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'mid_feedback') {

    // print_r($_POST);
    $time_tbl_id = $_POST['id'];
    $feedback = $_POST['feedBack'];
    $user_id = $_POST['user_id'];

    //echo  $feedback;exit;
    $db->insert('tbl_mid_cls_feedback', ['time_tbl_id' => $time_tbl_id, 'user_id' => $user_id, 'feedback' => $feedback, 'status' => 1]);
    $res = $db->getResult();
    //print_r($res);
    if ($res) {
        echo "success";exit;
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'mul_mid_feedback') {
    $user_id = $_POST['user_id'];
    $feedback = $_POST['feedBack'];
    $time_tbl_id = $_POST['time_table_id'];

    for ($i = 0; $i < count($time_tbl_id); $i++) {
        $db->insert('tbl_mid_cls_feedback', ['time_tbl_id' => $time_tbl_id[$i], 'user_id' => $user_id, 'feedback' => $feedback[$i], 'status' => 1]);
    }
    $res = $db->getResult();
    //echo  $feedback;exit;

    //print_r($res);
    if ($res) {
        echo "success";exit;
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'cls_feedback_suggest') {

    // print_r($_POST);
    $program_id = $_POST['program_id'];
    $trng_type = $_POST['trng_type'];
    $user_id = $_POST['user_id'];
    $suggestion = $_POST['suggestion'];

    //echo  $feedback;exit;
    $db->insert('tbl_mid_cls_suggestation', ['user_id' => $user_id, 'program_id' => $program_id, 'trng_type' => $trng_type, 'suggestion' => $suggestion]);
    $res = $db->getResult();
    //print_r($res);
    if ($res) {
        echo "success";exit;
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'edit_cls_feedback_suggest') {

    // print_r($_POST);

    $suggest_id = $_POST['suggest_id'];
    $suggestion = $_POST['suggestion'];

    //echo  $feedback;exit;
    $db->update('tbl_mid_cls_suggestation', ["suggestion" => $suggestion], 'id=' . $suggest_id);
    $res = $db->getResult();
    //print_r($res);
    if ($res) {
        echo "success";exit;
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'select_tranee_Email') {

    $tableData = stripcslashes($_POST['tableData']);

    // Decode the JSON array
    $tableData = json_decode($tableData, TRUE);
    foreach ($tableData as $data) {

        $db->update('tbl_new_recruite', ["email_status" => $data['send']], 'id=' . $data['trnee_id']);
        $res = $db->getResult();
        if ($res) {

            echo "success#";
        } else {

            echo "error#" . $res[0];
        }
        //print_r($data);
    }
}



if (isset($_POST['action']) && $_POST['action'] == 'select_topicWise') {


    $program_id = $_POST['program_id'];

    $sql = "SELECT DISTINCT(m.topic),m.id  FROM `tbl_time_table` t 
            JOIN `tbl_topic_master` m ON t.topic_id = m.id WHERE program_id = '" . $program_id . "' ORDER BY m.id";

    $db->select_sql($sql);
    $res = $db->getResult();

    if ($res) {
        echo '<option>Select Topic</option>';

        foreach ($res as $row) {
?>
            <option value=<?php echo $row['id'] ?>> <?php echo $row['topic'] ?> </option>
        <?php
        }
    } else {
        //print_r($db->getResult());
        echo '<option>No Class Taken By Faculty  </option>';
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'faculty_feedBack') {

    $program_id = $_POST['program_id'];

    $db->select_sql("SELECT a.taken_by,f.name FROM (SELECT DISTINCT(u.name),a.taken_by FROM `tbl_attendance`a JOIN `tbl_user` u ON a.taken_by = u.id)a JOIN `tbl_faculty_master` f ON a.name = f.id");

    $res = $db->getResult();

    if ($res) {
        echo '<option>Select Faculty</option>';

        foreach ($res as $row) {


        ?>
            <option value=<?php echo $row['taken_by'] ?>> <?php echo $row['name'] ?> </option>
        <?php
        }
    } else {
        //print_r($db->getResult());
        echo '<option>No Class Taken By Faculty  </option>';
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'fetch_tour_program') {

    $program_id = $_POST['program_id'];

    $db->select('tbl_tour_long_term_program', 'id,prg_name', null, null, null, null);

    $res = $db->getResult();

    if ($res) {
        echo '<option value = 0>Select Tour Program</option>';

        foreach ($res as $row) {


        ?>
            <option value=<?php echo $row['id'] ?>> <?php echo $row['prg_name'] ?> </option>
        <?php
        }
    } else {
        //print_r($db->getResult());
        echo '<option>No Program Found  </option>';
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'view_feedBack') {

    $program_id = $_POST['program_id'];
    $feedback_type = $_POST['feedback'];
    $faculty_type = $_POST['faculty_type'];
    $topic_id = $_POST['topic_id'];
    //print_r($_POST);exit;
    switch ($feedback_type) {
        case '1':

        ?>
            <table class="table table-striped table-sm" style="width:50%;margin:0px auto;">
                <thead style="font-size: 10px;background-color: rgb(59 67 84);color: #fff;">

                    <tr>
                        <th scope="col">Faculty Name</th>
                        <th scope="col">Avrage Feedback </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT AVG(u.feedback) as avrage,u.taken_by,t.faculty_type,t.faculty_id,g.name as faculty_name from (SELECT f.feedback,a.time_tbl_id,a.taken_by FROM `tbl_feedback` f JOIN `tbl_attendance` a ON f.attendance_id = a.id) u 
                     JOIN `tbl_time_table` t ON u.time_tbl_id = t.id
                     JOIN `tbl_faculty_master` g ON t.faculty_id = g.id
                     GROUP BY t.faculty_id ";

                    $db->select_sql($sql);
                    $res = $db->getResult();

                    foreach ($res as $feedback) {
                        // print_r( $feedback);
                    ?>
                        <tr>
                            <td><?php echo $feedback['faculty_name'] ?></td>
                            <td><?php echo number_format((float)$feedback['avrage'], 2, '.', '');  ?></td>
                        </tr>


                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
            break;
        case '3':
        ?>
            <table class="table table-striped table-sm" style="width:70%;margin:0px auto;">
                <thead style="font-size: 10px;background-color: rgb(59 67 84);color: #fff;">

                    <tr>
                        <th scope="col">Sl.No</th>
                        <th scope="col">Topic</th>
                        <th scope="col">Faculty Name</th>
                        <th scope="col">Avrage Feedback </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT AVG(u.feedback) as avrage,top.topic,u.taken_by,t.faculty_type,t.faculty_id,g.name as faculty_name from (SELECT f.feedback,a.time_tbl_id,a.taken_by FROM `tbl_feedback` f JOIN `tbl_attendance` a ON f.attendance_id = a.id) u 
                     JOIN `tbl_time_table` t ON u.time_tbl_id = t.id
                     JOIN `tbl_topic_master` top ON t.topic_id = top.id
                     JOIN `tbl_faculty_master` g ON t.faculty_id = g.id
                     WHERE t.topic_id = '" . $topic_id . "'
                     GROUP BY t.faculty_id";

                    $db->select_sql($sql);
                    $res = $db->getResult();
                    $count = 0;
                    foreach ($res as $feedback) {
                        // print_r( $feedback);
                        $count++;
                    ?>
                        <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $feedback['topic'] ?></td>
                            <td><?php echo $feedback['faculty_name'] ?></td>
                            <td><?php echo number_format((float)$feedback['avrage'], 2, '.', '');  ?></td>
                        </tr>


                    <?php
                    }
                    ?>
                </tbody>
            </table>
    <?php
            break;
        default:
            # code...
            break;
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'view_post_feedBack') {

    $program_id = $_POST['program_id'];
    $traning_type = $_POST['traning_type'];
    $feedback_type = $_POST['feedback_type'];
    $tour_id = $_POST['tour_id'];
    $prog_name = $_POST['prog_name'];
    $prog_id = '';
    $prog_table = '';
    $select_query = '';
    if ($traning_type == 1) {
        $prog_table = 'tbl_new_recruite';
        $select_query = " CONCAT(t.f_name,'',t.l_name) as name,f.suggestion,f.id ";
        if ($tour_id == 0) {
            $prog_id =  $program_id;
        } else {
            $prog_id = $tour_id;
        }
    } else if ($traning_type == 3) {
        $prog_id = $program_id;
        $prog_table = 'tbl_dept_trainee_registration';
        $select_query = 't.name,f.suggestion,f.id';
    } else {
        $prog_id = $program_id;
        $prog_table = 'tbl_dept_trainee_registration';
        $select_query = 't.name,f.suggestion,f.id';
    }
    //print_r($_POST);exit;

    switch ($feedback_type) {
        case '1':

    ?>
           

            <input type="button" class="printbtn" style="background:#3292a2;" onclick="datapost('post_program_feedback_pdf.php',{program_id: <?php echo $prog_id ?> ,prog_name: '<?php echo $prog_name ?>',traning_type:<?php echo $traning_type; ?>,
                       tour_id:<?php echo $tour_id; ?> })" value="Print" />
            <div class="feedback-heading">
                <p style="padding: 5px;">Post Program Trainee Feedback</p>
            </div>

            <table class="table table-striped table-sm" style="width:60%;margin-top: 50px">
                <thead style="font-size: 10px;background-color: rgb(59 67 84);color: #fff;">

                    <tr>
                        <th scope="col">Feedback Category</th>
                        <th scope="col">Avrage Feedback </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $db->select('tbl_feedback_master', '*', null, null, null, null);
                    foreach ($db->getResult() as $row1) {
                        $sql = "SELECT m.feedback as name,AVG(d.feedback) as avrage FROM `tbl_post_trng_feedback` p 
                            LEFT JOIN `tbl_post_trng_feedback_data` d ON p.id = d.post_feedback_id
                            JOIN `tbl_feedback_master` m ON d.feedback_name_id = m.id WHERE p.program_id = '" . $prog_id . "' AND 
                            p.trng_type = '" . $traning_type . "' AND m.feedback = '" . $row1['feedback'] . "' ";

                        $db->select_sql($sql);
                        $res = $db->getResult();

                        foreach ($res as $feedback) {
                            // print_r( $feedback);
                    ?>
                            <tr>
                                <td><?php echo $feedback['name'] ?></td>
                                <td><?php echo number_format((float)$feedback['avrage'], 1, '.', '');  ?></td>
                            </tr>


                    <?php
                        }
                    }

                    ?>
                </tbody>
            </table>
            <div class="feedback-heading" style="margin-top: 50px">
                <p style="padding: 5px;">Post Program Trainee Suggestion</p>
            </div>

            <table class="table table-striped table-sm" style="width:60%;">
                <thead style="font-size: 10px;background-color: rgb(59 67 84);color: #fff;">

                    <tr>
                        <th scope="col">Sl No</th>
                        <th scope="col">Name </th>
                        <th scope="col">Suggestions
                        <th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $sql = "SELECT t.name,f.suggestion,f.id FROM tbl_post_trng_feedback f 
                            JOIN $prog_table t ON f.username=t.phone 
                            WHERE f.program_id = $prog_id AND f.trng_type = $traning_type
                            GROUP BY f.id";

                    $db->select_sql($sql);
                    $res = $db->getResult();

                    $count = 0;
                    foreach ($res as $row2) {
                        // print_r( $feedback);
                        $count++;
                    ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row2['name'] ?></td>
                            <td><?php echo $row2['suggestion'] ?> </td>
                        </tr>


                    <?php
                    }


                    ?>
                </tbody>
            </table>

        <?php
            break;
        case '2':
        ?>
            <div class="feedback-heading" style="margin-top: 10px">
                <p style="padding: 5px;">Post Program Individual Trainee Feedback</p>
            </div>

            <?php
            // $db->select('tbl_post_trng_feedback',$select_query,' f JOIN '.$prog_table.' t ON f.username=t.phone',
            // "f.program_id = '".$prog_id."' AND  f.trng_type = '".$traning_type."'",null,null);


            $sql2 = "SELECT t.name,f.suggestion,f.id FROM tbl_post_trng_feedback f 
                        JOIN $prog_table t ON f.username=t.phone 
                        WHERE f.program_id = $prog_id AND f.trng_type = $traning_type
                        GROUP BY f.id";
            $db->select_sql($sql2);
            $res = $db->getResult();

            foreach ($res as $row3) {
                // print_r( $feedback);

            ?>
                <div class="feedback_div">
                    <div class="row ind-heading" style="margin-top: 50px">
                        <div class="col-md-2">Name :</div>
                        <div class="col-md-7"><?php echo $row3['name']; ?></div>

                    </div>

                    <table class="table table-striped table-sm" style="width:70%;margin-top: 30px">
                        <thead style="font-size: 10px;background-color: rgb(59 67 84);color: #fff;">

                            <tr>
                                <th scope="col">Sl.No</th>
                                <th scope="col">Feedback Category</th>
                                <th scope="col">Rating</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            $sql = "SELECT m.feedback as name,d.feedback as rating FROM `tbl_post_trng_feedback` p 
                                                   LEFT JOIN `tbl_post_trng_feedback_data` d ON p.id = d.post_feedback_id
                                                   JOIN `tbl_feedback_master` m ON d.feedback_name_id = m.id WHERE p.program_id = '" . $prog_id . "' AND 
                                                   p.trng_type = '" . $traning_type . "' AND d.post_feedback_id = '" . $row3['id'] . "' ";

                            $db->select_sql($sql);
                            $count = 0;
                            foreach ($db->getResult() as $rating) {
                                // print_r( $feedback);
                                $count++;
                            ?>
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td><?php echo $rating['name'] ?></td>
                                    <td><?php echo $rating['rating'] ?></td>

                                </tr>


                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="row" style="width: 70%;
                                background: #00802c24;
                                padding: 10px;
                                margin-left: 5px">
                        <div class="col-md-3" style="text-align: center;
                                    font-size: 1.2rem;
                                    font-weight: 600;
                                    color: #3851a5;">Suggestion</div>
                        <div class="col-md-9">
                            <textarea style="width: 80%;height: 100%;" row="3"> <?php echo $row3['suggestion'] ?> </textarea>
                        </div>
                    </div>
                </div>
                <!-- <hr> -->

            <?php
            }

            ?>


    <?php
            break;
        default:
            # code...
            break;
    }
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'view_trainee_dtl') {
    $user_id = $_POST['user_id'];

    ?>
    <div class="card">
        <div class="card-header">
            <h5 class="title">Form-I</h5>
        </div>
        <?php
        //print_r($_POST);
        $id = 0;
        $db->select('tbl_user', "id", null, " username =" . $user_id, null, null);
        $result = $db->getResult();
        if ($result) {
            foreach ($result as $new_row) {
                //print_r($new_row);
                $id = $new_row['id'];
            }
        } else {
            echo "Registration Not Yet Done By Trainee";
            exit;
        }

        // $sql2 = mysqli_query($db, "SELECT *  FROM `tbl_trainee_info` WHERE  status = 1 AND user_id =".$id);

        // $sql = "SELECT *  FROM `tbl_trainee_info` WHERE `user_id` =".$id;
        //echo $sql;exit;
        $db->select('tbl_trainee_info', "*", null, " status = 1 AND user_id =" . $id, null, null);
        $row1 =  $db->getResult();

        if ($row1) {

            // while($res = mysqli_fetch_array($sql2)) {
            foreach ($row1 as $res) {
                // print_r($res);
        ?>
                <div class="card-body">
                    <form>



                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Name of the Trainee</strong></label>
                                    <input type="text" disabled class="form-control" placeholder="<?php echo $res['first_name']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> &nbsp;</label>
                                    <input type="text" disabled class="form-control" placeholder="<?php echo $res['last_name']; ?>">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Father's Name</strong></label>
                                    <input type="text" disabled class="form-control" placeholder="<?php echo $res['father_name']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Mother's Name</strong></label>
                                    <input type="text" disabled class="form-control" placeholder="<?php echo $res['mother_name']; ?>">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong> Blood Group</strong></label>
                                    <input type="text" disabled class="form-control" name="t_name" placeholder="<?php echo $res['blood_group']; ?>">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Date of Birth</strong></label>
                                    <input type="text" disabled class="form-control" name="t_name" placeholder="<?php echo date("d-m-Y", strtotime($res['d_o_b'])); ?>">
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Educational Qualifications</strong></label>
                                    <input type="text" disabled class="form-control" name="t_name" placeholder="<?php echo $res['qualification']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Marital Status</strong></label>
                                    <input type="text" disabled class="form-control date-withicon" placeholder="<?php echo $res['marital_status']; ?>" />
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label style="padding-left: 43%;color:#0905eb"><strong>Contact
                                            Details</strong></label></br>
                                    <label><strong>Parmanent Address</strong></label>
                                    <input type="text" disabled class="form-control" placeholder="<?php echo $res['parmanent_addr']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-1">
                                <div class="form-group">
                                    <!-- <label><strong>State</strong></label> -->

                                    <input type="text" disabled class="form-control" placeholder="<?php echo $res['state_id']; ?>">

                                </div>
                            </div>
                            <div class="col-md-4 px-1">
                                <div class="form-group">
                                    <!-- <label><strong>District</strong></label> -->
                                    <input type="text" disabled class="form-control" placeholder="<?php echo $res['district_id']; ?>">
                                </div>
                            </div>
                            <div class="col-md-4 pl-1">
                                <div class="form-group">
                                    <!-- <label><strong>Pin Code</strong></label> -->
                                    <input type="number" disabled class="form-control" placeholder="<?php echo $res['pr_pin']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong>Present Address</strong></label>

                                    <input type="text" disabled class="form-control addr" placeholder="<?php echo $res['present_addr']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-1">
                                <div class="form-group">
                                    <!-- <label><strong>State</strong></label> -->
                                    <input type="text" disabled class="form-control addr" placeholder="<?php echo $res['p_state']; ?>">
                                </div>
                            </div>
                            <div class="col-md-4 px-1">
                                <div class="form-group">
                                    <!-- <label><strong>District</strong></label> -->
                                    <input type="text" disabled class="form-control addr" placeholder="<?php echo $res['p_dist']; ?>">
                                </div>
                            </div>
                            <div class="col-md-4 pl-1">
                                <div class="form-group">
                                    <!-- <label><strong>Pin Code</strong></label> -->
                                    <input type="number" disabled class="form-control addr" placeholder="<?php echo $res['p_pin']; ?>">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Mobile Number</strong></label>
                                    <input type="text" disabled class="form-control" name="t_name" placeholder="<?php echo $res['mobile']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Email</strong></label>
                                    <input type="text" disabled class="form-control" name="t_name" placeholder="<?php echo $res['email']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label style="padding-left: 43%;color:#0905eb"><strong>Bank Details</strong></label>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Bank Name</strong></label>
                                    <input type="text" disabled class="form-control" name="t_name" placeholder="<?php echo $res['bank_id']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Account No.</strong></label>
                                    <input type="text" disabled class="form-control" name="t_name" placeholder="<?php echo $res['account_num']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>IFSC Code</strong></label>
                                    <input type="text" disabled class="form-control" name="t_name" placeholder="<?php echo $res['ifsc_code']; ?>">
                                </div>
                            </div>


                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label style="padding-left: 43%;color:#0905eb"><strong>Health & Medical
                                            History(indicate if)</strong></label>

                                </div>
                            </div>
                            <div class="form-check">

                                <?php

                                //$sql3 = mysqli_query($db, "SELECT *  FROM `tbl_medical_info` WHERE `user_id` =".$id);
                                $db->select('tbl_medical_info', "*", null, "  user_id =" . $id, null, null);
                                $row3 =  $db->getResult();

                                if ($row3) {


                                    // while($res1 = mysqli_fetch_array($sql3)) {
                                    foreach ($row3 as $res1) {
                                        // print_r($res1);
                                        $medical = explode(',', $res1['reason']);

                                        foreach ($medical as $reason) {


                                            $db->select('tbl_medical_history', "*", null, "  id =" . $reason, null, null);
                                            $row4 =  $db->getResult();

                                            foreach ($row4 as $res2) {
                                                //print_r($res2);
                                ?>

                                                <input type="text" disabled class="form-control" name="t_name" placeholder="<?php  //echo isset($res2['medical_history'])?res2['medical_history']:'NO'; 
                                                                                                                            ?>" />

                                                </label></br>
                                        <?php    }
                                        }

                                        ?>

                                        <div class="row">

                                            <div class="col-md-6">

                                                <label for="photo" style="margin-left: 20px;"><strong>Any other
                                                        category/symptom as notified</strong></label>
                                                <input type="text" disabled class="form-control" name="t_name" placeholder="<?php echo $res1['other']; ?>">

                                            </div>
                                        </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="photo" style="margin-left: 20px;"><strong>Whether Differently
                                        Abled?</strong></label>
                                <input type="text" disabled class="form-control" name="t_name" placeholder="<?php echo $res1['diff_abled']; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="photo" style="margin-left: 20px;"><strong>Past Service
                                        experience(If any)</strong></label>
                                <input style="margin-right: 50%;" type="text" class="form-control" name="t_name" placeholder="<?php echo $res1['past_service']; ?>">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="photo" style="margin-left: 20px;"><strong>Hostel
                                        Accommodation</strong></label>
                                <input style="margin-right: 50%;" type="text" class="form-control" name="t_name" placeholder="<?php echo $res1['hostel_acc']; ?>">

                            </div>
                        </div>
                <?php }
                                }
                ?>
                <div class="row">
                    <div class="col-md-12">

                        <label style="padding-left: 43%;color:#0905eb"><strong>Upload Dcoumnets</strong></label>
                    </div>
                    <?php
                    //$sql5 = mysqli_query($db, "SELECT *  FROM `tbl_traniee_documents` WHERE `user_id` =".$id);
                    $db->select('tbl_traniee_documents', "*", null, "  user_id =" . $id, null, null);
                    $row5 =  $db->getResult();
                    if ($row5) {


                        // while($res5 = mysqli_fetch_array($sql5)) {

                        foreach ($row5 as $res5) {

                    ?>
                            <div class="col-md-6">

                                <label class="form-check-label" style="padding-top:5%;"><strong>Passport
                                        size Photo</strong>
                                </label>
                                <?php if (!empty($res5['photo'])) { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;" onclick="showDetail('<?php echo $res5['photo'] ?>')">
                                        <i class="far fa-file-pdf fa-lg"></i></span>
                                <?php } else { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;"> File Not Available </span>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-check-label" style="padding-top: 5%;"><strong>Joining
                                        report in OGFR II Form</strong></label>
                                <?php if (!empty($res5['joining_report'])) { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;" onclick="showDetail('<?php echo $res5['joining_report'] ?>')">
                                        <i class="far fa-file-pdf fa-lg"></i></span>
                                <?php } else { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;"> File Not Available </span>
                                <?php } ?>
                            </div>
                            <div class="line"></div>
                            <div class="col-md-6">

                                <label class="form-check-label" style="padding-top: 5%;"><strong>Character
                                        Certificate I & II</strong></label>
                                <?php if (!empty($res5['character_certificate'])) { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;" onclick="showDetail('<?php echo $res5['character_certificate'] ?>')">
                                        <i class="far fa-file-pdf fa-lg"></i></span>
                                <?php } else { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;"> File Not Available </span>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-check-label" style="padding-top: 5%;"><strong>HSC
                                        Certificate</strong></label>
                                <?php if (!empty($res5['hsc_certificate'])) { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;" onclick="showDetail('<?php echo $res5['hsc_certificate'] ?>')">
                                        <i class="far fa-file-pdf fa-lg"></i></span>
                                <?php } else { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;"> File Not Available </span>
                                <?php } ?>
                            </div>
                            <div class="line"></div>

                            <div class="col-md-6">

                                <label class="form-check-label" style="padding-top: 5%;"><strong>Id Proof Type</strong></label>

                                <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:#0905eb;font-weight:600">
                                    <?= isset($res5['idproof_type']) ? $res5['idproof_type'] : '' ?></span>
                            </div>
                            <div class="col-md-6">

                                <label class="form-check-label" style="padding-top: 5%;"><strong>Adhar
                                        Card/VoterID/PAN
                                        Card</strong></label>
                                <?php if (!empty($res5['PAN_card'])) { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;" onclick="showDetail('<?php echo $res5['PAN_card'] ?>')">
                                        <i class="far fa-file-pdf fa-lg"></i></span>
                                <?php } else { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;"> File Not Available </span>
                                <?php } ?>
                            </div>
                            <div class="line"></div>

                            <div class="col-md-6">
                                <label class="form-check-label" style="padding-top: 5%;"><strong>Non-employment
                                        Certificate</strong></label>
                                <?php if (!empty($res5['non_employment'])) { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;" onclick="showDetail('<?php echo $res5['non_employment'] ?>')">
                                        <i class="far fa-file-pdf fa-lg"></i></span>
                                <?php } else { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;"> File Not Available </span>
                                <?php } ?>
                            </div>

                            <div class="col-md-6">

                                <label class="form-check-label" style="padding-top: 5%;"><strong>Undertaking/Declaration</strong></label>
                                <?php if (!empty($res5['undertaking_declaration'])) { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;" onclick="showDetail('<?php echo $res5['undertaking_declaration'] ?>')">
                                        <i class="far fa-file-pdf fa-lg"></i></span>
                                <?php } else { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;"> File Not Available </span>
                                <?php } ?>
                            </div>
                            <div class="line"></div>
                            <div class="col-md-6">

                                <label class="form-check-label" style="padding-top: 5%;"><strong>First page
                                        of Bank Passbook/Cancelled Bank Cheque Leaf</strong></label>
                                <?php if (!empty($res5['bank_passbook'])) { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;" onclick="showDetail('<?php echo $res5['bank_passbook'] ?>')">
                                        <i class="far fa-file-pdf fa-lg"></i></span>
                                <?php } else { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;"> File Not Available </span>
                                <?php } ?>
                            </div>

                            <div class="col-md-6">

                                <label class="form-check-label" style="padding-top: 5%;"><strong>PRAN
                                        Card</strong></label>
                                <?php if (!empty($res5['PRAN_Card'])) { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;" onclick="showDetail('<?php echo $res5['PRAN_Card'] ?>')">
                                        <i class="far fa-file-pdf fa-lg"></i></span>
                                <?php } else { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;"> File Not Available </span>
                                <?php } ?>


                            </div>
                            <div class="line"></div>
                            <div class="col-md-6">

                                <label class="form-check-label" style="padding-top: 5%;"><strong>NPS
                                        Registration form</strong></label>
                                <?php if (!empty($res5['NPS_registration'])) { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;" onclick="showDetail('<?php echo $res5['NPS_registration'] ?>')">
                                        <i class="far fa-file-pdf fa-lg"></i></span>
                                <?php } else { ?>
                                    <span style="width:100%;margin-left: 48px;line-height: 37px;cursor:pointer;color:red;"> File Not Available </span>
                                <?php } ?>
                            </div>





                    <?php
                        }
                    } ?>




                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                </div>


                </form>


    </div>
    <div class="col-md-1">
    </div>
    </div>

    </div>

<?php

            }
        }

?>

</div>
<?php
}

if (isset($_POST['action']) && $_POST['action'] == 'accept_trainee') {


    $trainee_id = $_POST['id'];

    $table = $_POST['table'];

    $db->update($table, ['mdrafm_status' => 1], ' user_id=' . $trainee_id);
    $res = $db->getResult();
    if ($res) {
        echo "success";
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'accept_inservice_trainee') {


    $trainee_id = $_POST['id'];

    $table = $_POST['table'];

    $db->update($table, ['mdrafm_status' => 1], ' id=' . $trainee_id);
    $res = $db->getResult();
    if ($res) {
        echo "success";
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'check_inservice_trainee') {


    $trainee_id = $_POST['id'];


    $db->select("tbl_new_recruite", "email,phone", null, "id=" . $trainee_id, null, null);
    $res = $db->getResult();
    foreach ($res as $row) {
        if ($row['email'] == '') {
            $msg = "error#Please Update Email Before Accept ";
        } else if ($row['phone'] == '') {
            $msg = "error#Please Update Phone Number Before Accept ";
        } else {
            $msg = "success#";
        }
    }
    echo $msg;
    // if($res){
    //   echo "success#";
    // }
}


if (isset($_POST['action']) && $_POST['action'] == 'send_mdrafm') {


    $trainee_id = $_POST['id'];

    $table = $_POST['table'];

    $db->update($table, ['status' => 1], ' user_id=' . $trainee_id);
    $res = $db->getResult();
    if ($res) {
        echo "success";
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'showTraine') {
    // print_r($_POST);
    $prgram_id = $_POST['prgram_id'];
    $trng_type = $_POST['trng_type'];

    if ($trng_type == 1 || $trng_type == 2) {
        $db->select("tbl_new_recruite", "id,user_id,f_name,l_name,email,phone", null, "program_id=" . $prgram_id, null, null);
    }

    $res = $db->getResult();

?>
    <table class="table table-striped table-sm importTbl" style="width:70%;margin-top: 30px">
        <thead style="font-size: 10px;background-color: rgb(59 67 84);color: #fff;">

            <tr>
                <th scope="col">Sl.No</th>
                <th scope="col">Name</th>
                <th scope="col">Phone NO</th>
                <th>
                    <input class="form-check-input " type="checkbox" id="checkAll2">
                    Send All
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;

            foreach ($res as $row) {

                $count++;
            ?>
                <tr>
                    <td><?php echo $count ?></td>
                    <td><?php echo $row['f_name'] . '' . $row['l_name'] ?></td>
                    <td><?php echo $row['phone'] ?></td>
                    <td>
                        <input class="form-check-input" type="checkbox" name="sent" id="sent" value="1" style="opacity: 1;visibility: visible;">
                        <input type="hidden" name="trinee_tbl_id" value="<?php echo $row['id'] ?>">
                        <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>">
                    </td>

                </tr>


            <?php
            }
            ?>
        </tbody>
    </table>
<?php

}
if (isset($_POST['action']) && $_POST['action'] == 'fetchTrainee') {
     $id = $_POST['id'];
     
     $res= $hp->fetchDataById('tbl_trainee_details',$id);

     echo json_encode($res[0]);

}
if (isset($_POST['action']) && $_POST['action'] == 'saveTrainee') {

   

    $pos = array_search("action", array_keys($_POST));
    $frm_data = array_splice($_POST, 0, $pos);
    if (isset($frm_data['csrf_token'])) {
          unset($frm_data['csrf_token']);
        }
    // print_r($frm_data);
    // print_r($_POST);
    // exit;

    $table = $_POST['table'];
    $program_id = $_POST['program_id'];
    $trng_type =  $_POST['trng_type'];

      $db->insert('tbl_trainee_details', $frm_data);
      $res = $db->getResult();
      $lastInsertId = $res[0];

      if ($lastInsertId >0) {
        $db->insert('tbl_dept_trainee_registration', ['program_id'=>$program_id , 'trng_type'=>$trng_type,'trainee_detail_id'=>$lastInsertId]);

        $res2 = $db->getResult();

        if ($res2) {
            echo "success#" . $res2[1];
          } else {
           
            echo "error#" . $res2[0];
          }
      }
     
  }

  if (isset($_POST['action']) && $_POST['action'] == 'editTrainee') {
    
    $pos = array_search("action", array_keys($_POST));
    $frm_data = array_splice($_POST, 0, $pos);
    if (isset($frm_data['csrf_token'])) {
          unset($frm_data['csrf_token']);
        }

    $table = $_POST['table'];
    $update_id = $_POST['update_id'];
    
    if ($update_id != '') {
  
        $db->update($table, $frm_data, 'id=' . $update_id);
        $res = $db->getResult();
   
        if ($res) {
          echo "success#" . $res[1];
        } else {
    
          echo "error#" . $res[0];
        }
      }
  }

if (isset($_POST['action']) && $_POST['action'] == 'chkUser') {
    $phone_no = $_POST['phone_no'];

    $db->select('vw_all_trainee', "*", null, "phone =" . $phone_no, null, null);
    $res = $db->getResult();
    $data = array();

    if ($res) {
        $data['status'] = 'success';
        $data['result'] = $res[0];
        
    } else {
        $data['status'] = 'error';
       
    }
    echo json_encode($data);
}
if (isset($_POST['action']) && $_POST['action'] == 'saveRegistredTrainee') {

    $traineeId = $_POST['traineeId'];
    $userId = $_POST['userId'];
    $programId = $_POST['programId'];
    $trngType = $_POST['trngType'];

    $data = array();

    $isRegestred =  $hp->isUserRegistred('tbl_dept_trainee_registration', $programId, $traineeId);
    //echo count($isRegestred);
    if (count($isRegestred) > 0) {
        $data['status'] = 'error';
        $data['msg'] = 'Trainee Already Registred';
        // echo 123;
    } else {
        $insert_sql = "INSERT INTO `tbl_dept_trainee_registration` (`id`, `user_id`, `program_id`, `trng_type`, `trainee_detail_id`, `mdrafm_status`) 
                 VALUES (NULL, '" . $userId . "', '" . $programId . "', '" . $trngType . "', '" . $traineeId . "','1')";

        $db->insert_sql($insert_sql);
        $res = $db->getResult();

        if ($res[0] > 0) {
            $data['status'] = 'success';
            $data['msg'] = 'Trainee Registred Successfully';
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'Something Error';
        }
    }

    echo json_encode($data);
}
?>