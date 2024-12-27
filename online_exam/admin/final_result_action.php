<?php

//exam_action.php

include('database.php');

$object = new database();
//print_r($_POST);

if (isset($_POST["action"])) {
    if ($_POST["action"] == 'fetch_programs') {
        $prog_type = $_POST['prog_type'];
        $object->query = "
		SELECT e.program_id,m.prg_name FROM `tbl_exam_master` e 
        JOIN `tbl_mid_program_master` m ON e.program_id = m.id
        WHERE e.exam_category = '" . $prog_type . "' GROUP BY e.program_id";

        $result = $object->get_result();
        // print_r($result);
        $html = '<option value="0">Select Program</option>';

        foreach ($result as $row) {
            $html .= '<option value="' . $row['program_id'] . '">' . $row['prg_name'] . '</option>';
        }


        echo $html;
    }

    if ($_POST["action"] == 'trainne_list') {

        $prog_type = $_POST['prog_type'];
        $prog_id = $_POST['prog_id'];

        $count = 0;


        ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="exam_result" width="100%" cellspacing="0">
                <thead>
                    <tr class="" style="background-color:#167F92;color:white">
                        <th rowspan="2">Sl No</th>
                        <th rowspan="2" style="width: 5rem"> Roll No</th>
                        <th rowspan="2">Name </th>
                        <th rowspan="2">Designation/Office Name</th>

                        <?php

                        $object->query = "SELECT m.id,m.paper_id,p.paper_code, p.total_mark  FROM `tbl_exam_master` m
                            JOIN `tbl_mid_paper_master` p ON m.paper_id = p.id
                            WHERE m.exam_category ='" . $prog_type . "' AND m.program_id = '" . $prog_id . "'";


                        $paper_result = $object->get_result();

                        foreach ($paper_result as $row) {
                            echo '<th colspan="4">' . $row['paper_code'] . ' </br> Total Mark( ' . $row['total_mark'] . ') 
                               
                                     </th>';
                        }
                        ?>

                        <th rowspan="2">Status</th>
                        <th rowspan="2">Action</th>
                    </tr>

                    <tr>
                        <?php
                        $object->query = "SELECT m.id,m.paper_id,p.total_mark  FROM `tbl_exam_master` m
                            JOIN `tbl_mid_paper_master` p ON m.paper_id = p.id
                            WHERE m.exam_category ='" . $prog_type . "' AND m.program_id = '" . $prog_id . "'";


                        $paper_result2 = $object->get_result();
                        foreach ($paper_result2 as $row2) {
                            echo '<th >online</th>
                                 <th >P.P</th>
                                 <th >S.T</th>
                                 <th >Total</th>
                                 ';
                        }
                        ?>
                        <!-- <th>online</th>
                           <th>Presentation</th>
                           <th>Surprise</th> -->


                    </tr>

                </thead>
                <tbody style="background-color:#eaf3f3">
                    <?php




                    // print_r($result);
                    // exit;
                    $object->query = "SELECT d.id,d.roll_no,d.user_id,d.program_id,d.trng_type,d.name,d.designation,d.office_name,i.exam_status  FROM `tbl_dept_trainee_registration` d
                                        JOIN `tbl_trainee_exam_info` i ON d.user_id = i.trainee_id
                                        WHERE d.`program_id` =  '" . $prog_id . "' AND (d.`trng_type` = 3 OR d.`trng_type` = 7) GROUP BY i.trainee_id  ";
                    $trainee_result = $object->get_result();

                    foreach ($trainee_result as $trainee_row) {
                        print_r($trainee_row);
                        $count++;
                        $result = 0;
                        $exam_status = $trainee_row['exam_status'];
                        $user_id = $trainee_row["user_id"];
                        $object->query = "SELECT *  FROM `tbl_mid_final_result`  WHERE program_id = '" . $prog_id . "' AND user_id = '" . $user_id . "'";

                        $object->execute();
                        $result = $object->row_count();
                        $remark = array();
                    ?>
                        <tr style="background-color: <?php echo ($exam_status == 0) ? ' #e9afad;color: #4a4444' : "" ?>;color: <?php echo ($exam_status == 0) ? '#4a4444' : "" ?>">
                            <td><?php echo $count ?></td>
                            <td>
                                <input type="text" class="form-control" name="roll_no" id="roll_no" value="<?php echo $trainee_row['roll_no'] ?>" />
                                <input type="hidden" name="program_id" value='<?php echo $prog_id ?>'>
                                <input type="hidden" name="user_id" value='<?php echo $trainee_row['user_id'] ?>'>
                            </td>
                            <td><?php echo $trainee_row['name'] ?></td>
                            <td><?php echo $trainee_row['designation'] . ',' . $trainee_row['office_name'] ?></td>
                            <?php
                            if ($result > 0) {
                               

                                $object->query = "SELECT *  FROM `tbl_mid_final_result` WHERE program_id = '" . $prog_id . "' AND user_id = '" . $user_id . "'";
                                $num = 0;
                              
                                $exam_result = $object->get_result();
                                foreach ($exam_result as $result_row) {
                                    $paper_mark =  $object->Get_paper_total_mark($result_row["exam_id"], $trainee_row["user_id"]);
                                    $pass_mark =  $object->Get_paper_pass_mark($result_row["exam_id"]);

                                    //  echo $result_row["total_mark"];
                                    if ($result_row["total_mark"] >= $pass_mark) {
                                        array_push($remark, 'PASS');
                                    } else {
                                        array_push($remark, 'FAIL');
                                    }
                                    echo ' <td>
                                        <input type="text" class="form-control" name="paper_mark"  value=' . $paper_mark . ' disabled />
                                        <input type="hidden" name="exam_id" value="' . $result_row['exam_id'] . '" >
                                        </td>
                                        <td><input type="text" class="form-control" name="presentation_mark"  value=' . $result_row["presentation_mark"] . ' /></td>
                                        <td><input type="text" class="form-control" name="surprise_mark"  value=' . $result_row["surprise_mark"] . ' /></td> 
                                        <td><input type="text" class="form-control" name="total_mark"  value=' . $result_row["total_mark"] . ' /></td> ';
                                }
                            } else {
                                $object->query = "SELECT id  FROM `tbl_exam_master` WHERE exam_category ='" . $prog_type . "' AND program_id = '" . $prog_id . "'";
                                $exam_result = $object->get_result();
                                foreach ($exam_result as $result_row) {
                                    $paper_mark =  $object->Get_paper_total_mark($result_row["id"], $trainee_row["user_id"]);
                                    echo ' <td>
                                    <input type="text" class="form-control" name="paper_mark" id="paper_mark_' . $result_row["id"] . '" value=' . $paper_mark . ' disabled />
                                    <input type="hidden" name="exam_id" value="' . $result_row['id'] . '" >
                                    </td>
                                    <td><input type="text" class="form-control" name="presentation_mark"  value="0" /></td>
                                    <td><input type="text" class="form-control" name="surprise_mark"  value="0" /></td>
                                    <td><input type="text" class="form-control" name="total_mark"  value="0" /></td> ';
                                }
                            }



                            ?>

                            <td>

                                <input type="hidden" name="user_id" value="<?php echo $trainee_row['user_id'] ?>">
                                <input type="hidden" name="exam_status" value="<?php echo $exam_status ?>">

                                <?php
                                if (count($remark) > 0) {

                                    if (in_array("FAIL", $remark)) {
                                ?>
                                        <p class="text-danger">FAIL</p>

                                    <?php
                                    } else {
                                    ?>
                                        <p class="text-success">PASS</p>

                                    <?php
                                    }
                                } else {
                                    ?>
                                    <p style="display: <?php echo ($trainee_row['exam_status'] == 0) ? 'none' : 'block' ?>;">Complite</p>

                                    <p style="display: <?php echo ($trainee_row['exam_status'] == 0) ? '' : 'none' ?>;">Absent</p>
                                <?php
                                }
                                ?>



                            </td>
                            <td>
                                <?php
                                if (count($remark) > 0) {

                                ?>
                                    <button type="button" class="btn btn-warning save_result" onclick="update($(this))">Update</button>
                                <?php

                                } else {
                                ?>
                                    <button type="button" class="btn btn-success save_result" onclick="save($(this))">Save</button>
                                <?php
                                }
                                ?>

                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>


        </div>
<?php

        //print_r($_POST);



    }

    if ($_POST["action"] == 'pass_trainne_list') {

        $prog_type = $_POST['prog_type'];
        $prog_id = $_POST['prog_id'];

        $count = 0;


        ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="exam_result" width="100%" cellspacing="0">
                <thead>
                    <tr class="" style="background-color:#167F92;color:white">
                    <th>
                     <input class="form-check-input checkAll2 ml-2 mb-3" type="checkbox" style="margin-top: -23px"  id="checkAll">
                                                           
                    </th>
                        <th> Sl No</th>
                        <th style="width: 5rem"> Roll No</th>
                        <th>Name </th>
                        <th>Designation/Office Name</th>
                        
                        <th>Crt No</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                   

                </thead>
                <tbody style="background-color:#eaf3f3">
                    <?php

                    $object->query = "SELECT d.id,d.roll_no,d.user_id,d.program_id,d.trng_type,d.name,d.designation,d.office_name,d.exam_result_status,d.crt_no,i.exam_status  FROM `tbl_dept_trainee_registration` d
                                        JOIN `tbl_trainee_exam_info` i ON d.user_id = i.trainee_id
                                        WHERE d.`program_id` =  '" . $prog_id . "' AND d.exam_result_status = 1 AND (d.`trng_type` = 3 OR d.`trng_type` = 7) GROUP BY i.trainee_id  ";
                    $trainee_result = $object->get_result();

                    foreach ($trainee_result as $trainee_row) {
                        $count++;
                        $result = 0;
                        $exam_status = $trainee_row['exam_status'];
                        $user_id = $trainee_row["user_id"];
                        $trng_type = $trainee_row["trng_type"];
                        
                    ?>
                        <tr style="background-color: <?php echo ($exam_status == 0) ? ' #e9afad;color: #4a4444' : "" ?>;color: <?php echo ($exam_status == 0) ? '#4a4444' : "" ?>">
                          <td>
                          <div class="form-check form-check-inline">
                               
                               <input class="form-check-input" type="checkbox"
                                   name="sent" id="sent" value="1"
                                  
                                   style="opacity: 1;visibility: visible;">
                           </div>
                          </td>  
                          <td><?php echo $count ?></td><td>
                            
                                <input type="text" class="form-control" name="roll_no" id="roll_no" value="<?php echo $trainee_row['roll_no'] ?>" />
                                <input type="hidden" name="program_id" value='<?php echo $prog_id ?>'>
                                <input type="hidden" name="dept_reg_id" value='<?php echo $trainee_row['id'] ?>'>
                                <input type="hidden" name="user_id" value='<?php echo $trainee_row['user_id'] ?>'>
                            </td>
                            <td><?php echo $trainee_row['name'] ?></td>
                            <td><?php echo $trainee_row['designation'] . ',' . $trainee_row['office_name'] ?></td>
                            <td> <?php echo ($trainee_row['crt_no'] == '')?'NA':$trainee_row['crt_no'] ?></td>
                            <td> <?php echo  ($trainee_row['exam_result_status'] = 1)?'PASS':'FAIL' ?> </td>

                            
                            <td>
                                <?php
                                if ($trainee_row['crt_no'] =='' ) {

                                ?>
                                    <button type="button" class="btn btn-warning save_result" onclick="update($(this))">Generate Crt No</button>
                                <?php

                                } else {
                                ?>
                                    <!-- <button type="button" class="btn btn-success save_result" onclick="generate_crt(<?php echo $prog_id ?>)">Print Crt</button> -->
                                    <button type="button" class="btn btn-primary" style="float: right;"
                                      onclick="datapost('print_crt_ind.php',{prog_id: <?php echo $prog_id ?>,trng_type:<?php echo $trng_type ?> })">Print</button>
                                <?php
                                }
                                ?>

                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

                <div class="genrt_crt_no">
                    <div class="btn btn-primary" onclick="generate_crtificate()" >Generate crt no</div>
                </div>
        </div>
<?php

        //print_r($_POST);

    }

    if ($_POST["action"] == 'save_trainee_crtificate') {
        $exam_type = $_POST['exam_type'];
        print_r($_POST);
        //$trng_type = $_POST['trng_type'];
       // $program_id = $_POST['program_id'];
        $prog_short_name = $_POST['prog_short_name'];
        $month = $_POST['month'];
        $fin_yr = $_POST['fin_yr'];
        $place = $_POST['place'];
        $cert_date = date("d-m-Y", strtotime($_POST['cert_date']));

        $tableData = stripcslashes($_POST['tableData']);

        $tableData = json_decode($tableData, TRUE);

        foreach ($tableData as $data) {
            //$object = new database();
           
                $num = $data['roll_no'];
                $roll_no = sprintf("%02d", $num);

                $cert_no =  $prog_short_name . '/' . $month . '/' . $fin_yr . '/' . $roll_no . '/' . $place . '/' . $cert_date;

               $object->query = "
               UPDATE tbl_dept_trainee_registration 
               SET crt_no = '" .$cert_no. "' 
               WHERE id = '" .$data['dept_reg_id'] . "'  ";
              
   
               $object->execute();
            
           
        }

        echo 'success';
    }

    if ($_POST["action"] == 'save_trainee_final_result') {

        $exam_data = json_decode(stripslashes($_POST['exam_data']));
        $paper_mark_data = json_decode(stripslashes($_POST['paper_mark_data']));
        $presentation_mark_data = json_decode(stripslashes($_POST['presentation_mark_data']));
        $surprise_mark_data = json_decode(stripslashes($_POST['surprise_mark_data']));

        $program_id = $_POST['program_id'];
        $user_id = $_POST['user_id'];
        $roll_no = $_POST['roll_no'];

         count($exam_data);
        for ($i = 0; $i < count($exam_data); $i++) {
            $totalmark = $paper_mark_data[$i] + $presentation_mark_data[$i] + $surprise_mark_data[$i];
            $pass_mark =  $object->Get_paper_pass_mark($exam_data[$i]);
            $data = array(
                ':program_id'    =>    $program_id,
                ':exam_id'    =>    $exam_data[$i],
                ':user_id'    =>    $user_id,
                ':subject_mark'    =>    $paper_mark_data[$i],
                ':presentation_mark' =>    $presentation_mark_data[$i],
                ':surprise_mark' =>    $surprise_mark_data[$i],
                ':total_mark' => $totalmark,
                ':status' => 1

            );

            $object->query = "
        INSERT INTO `tbl_mid_final_result` ( `program_id`,`exam_id`, `user_id`, `subject_mark`, `presentation_mark`, `surprise_mark`, `total_mark`, `status`) 
        VALUES (:program_id,:exam_id, :user_id,:subject_mark, :presentation_mark,:surprise_mark ,:total_mark , :status)
        ";

            $object->execute($data);
            $exam_status = '';
            //update exam status at dept_registration_tble 
            if ($totalmark >= $pass_mark) {
                $exam_status = 1;
            } else {
                $exam_status = 2;
            }

            $object->query = "
            UPDATE tbl_dept_trainee_registration 
            SET exam_result_status = '" .$exam_status. "' , roll_no = '" .$roll_no ."'
            WHERE program_id = '" .$program_id . "' AND user_id =  '" .$user_id . "' 
            ";

            $object->execute();

        }
    }
}

?>