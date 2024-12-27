<!DOCTYPE html>
<html lang="en">


<head>
    <?php
    //header("Cache-Control: no cache");
    // session_cache_limiter("private_no_expire");
    include('header_link.php');
    include('../config.php');
    include 'database.php';
    include 'helper.php';

    //echo 123;
    $db = new Database();
    $hp = new Helper($db);
    $prog_name = '';
    $program_table = '';

    $trng_type = $_POST['trng_type'];

    if ($trng_type == 1 || $trng_type == 2) {

        $program_table = 'tbl_program_master';
    } elseif ($trng_type == 3 || $trng_type == 7) {

        $program_table = 'tbl_mid_program_master';
    } elseif ($trng_type == 4 || $trng_type == 5) {

        $program_table = 'tbl_short_program_master';
    } elseif ($trng_type == 8) {

        $program_table = 'tbl_oneday_program_master';
    }
    ?>

    <style type="text/css">
        #frm_newTranee {

            width: 60%;
            /* margin: 0 auto; */
            border: 1px solid #cdcdcd;
            padding: 20px;
            border-radius: 10px;
            background-color: #f1fbfd;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }

        .line {
            width: 95%;
            height: 1px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 28px;
            background-color: #b7d0e2;
        }
    </style>

</head>

<body class="user-profile">

    <!-- Google Tag Manager (noscript) -->
    <!-- End Google Tag Manager (noscript) -->

    <div class="wrapper ">

        <?php include('sidebar.php'); ?>

        <div class="main-panel" id="main-panel">
            <?php include('navbar.php'); ?>

            <div class="panel-header panel-header-sm">


            </div>


            <div class="content">

                <div class="row">
                    <div class="col-md-4">
                        <div id="alert_msg" class="alert alert-success">added successfully</div>
                    </div>
                   
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> Program Detail</h4>

                            </div>
                            <div class="card-body">
                                <div id="detail" class="">
                                    <?php
                                    switch ($_POST['trng_type']) {
                                        case '1':

                                            $sql = "SELECT p.id,p.prg_name,t.type,s.descr,d.course_director,d.asst_course_director,p.provisonal_Sdate,p.provisonal_Edate,p.dt_publication,p.dt_completion 
                                            FROM `tbl_program_master` p JOIN `tbl_training_type` t 
                                            ON p.trng_type=t.id
                                            JOIN `tbl_sylabus_master` s 
                                            ON p.syllabus_id=s.id
                                            JOIN `tbl_program_directors` d ON p.course_director_id = d.id
                                            WHERE p.id = '" . $_POST['id'] . "' ";
                                            break;
                                        case '2':
                                            $sql = "SELECT p.id,p.prg_name,t.type,s.descr,d.course_director,d.asst_course_director,f.name,p.provisonal_Sdate,p.provisonal_Edate,p.dt_publication,p.dt_completion 
                                                FROM `tbl_program_master` p JOIN `tbl_training_type` t 
                                                ON p.trng_type=t.id
                                                JOIN `tbl_mid_syllabus` s 
                                                ON p.syllabus_id=s.id
                                                JOIN `tbl_program_directors` d ON p.course_director_id = d.id
                                                WHERE p.id = '" . $_POST['id'] . "' ";
                                            break;
                                        case '3':
                                            $sql = "SELECT p.id,p.prg_name,t.type,d.course_director,d.asst_course_director,p.start_date,p.end_date,p.status
                                            FROM $program_table p 
                                            JOIN `tbl_training_type` t ON p.trng_type=t.id
                                            JOIN `tbl_program_directors` d ON p.course_director_id = d.id
                                            WHERE p.id = '" . $_POST['id'] . "' ";
                                            break;
                                        case '4':
                                            $sql = "SELECT p.id,p.prg_name,t.type,d.course_director,d.asst_course_director,p.start_date,p.end_date,p.status
                                                    FROM $program_table p 
                                                    JOIN `tbl_training_type` t ON p.trng_type=t.id
                                                    JOIN `tbl_program_directors` d ON p.course_director_id = d.id
                                                    WHERE p.id = '" . $_POST['id'] . "' ";
                                            break;
                                        case '8':
                                            $sql = "SELECT p.id,p.prg_name,t.type,p.course_director,p.asst_course_director,p.start_date,p.status
                                                    FROM $program_table p 
                                                    JOIN `tbl_training_type` t ON p.trng_type=t.id
                                                    WHERE p.id = '" . $_POST['id'] . "' ";
                                            break;
                                    }
                                    //  echo $sql;
                                    $coDir = '';
                                    $asst_coDir = '';

                                    $db->select_sql($sql);
                                    ///print_r($db->getResult());
                                    foreach ($db->getResult() as $row) {
                                        //  print_r($row);
                                        $prog_name = $row['prg_name'];
                                        if ($row['course_director'] != 0) {

                                            $db->select('tbl_faculty_master', 'name,desig', null, 'id=' . $row['course_director'], null, null);
                                            foreach ($db->getResult() as $res_coDir) {
                                                $coDir =  $res_coDir['name'];
                                                $desig =  $res_coDir['desig'];
                                            }

                                            $db->select('tbl_faculty_master', 'name,desig', null, 'id=' . $row['asst_course_director'], null, null);
                                            foreach ($db->getResult() as $res_asst_coDir) {
                                                $asst_coDir =  $res_asst_coDir['name'];
                                                $asst_desig =  $res_asst_coDir['desig'];
                                            }
                                        }


                                    ?>
                                        <div style="width: 100%; background-color: #ffd1478c; padding: 5px;border: 2px solid #f7c377;box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">

                                            <div style="width:33%;float:left;">
                                                Program Name : <?php echo $row['prg_name']; ?></br>
                                                Program Type : <?php echo $row['type']; ?> </br>
                                                <!-- Course Director :<?php echo $row['name']; ?> -->

                                            </div>
                                            <div style="width:33%;float:left;">
                                                <?php
                                                if ($trng_type == 1 || $trng_type == 2) {
                                                ?>
                                                    Start Date
                                                    :<?php echo date("d/m/Y", strtotime($row['provisonal_Sdate'])); ?><br>
                                                    End Date:<?php echo date("d/m/Y", strtotime($row['provisonal_Edate']));  ?>
                                                <?php
                                                } else {
                                                ?>
                                                    Start Date :<?php echo date("d/m/Y", strtotime($row['start_date'])); ?><br>
                                                    <?php
                                                    if (isset($row['end_date'])) {
                                                    ?>
                                                        End Date:<?php echo date("d/m/Y", strtotime($row['end_date']));  ?>
                                                    <?php
                                                    }
                                                    ?>

                                                <?php
                                                }
                                                ?>

                                            </div>
                                            <div style="width:33%;float:left;">

                                                Course Director :
                                                <?php echo ($row['course_director'] != 0) ? $coDir : 'NA'; ?></br>
                                                Asst Course Director :
                                                <?php echo ($row['course_director'] != 0) ? $asst_coDir : 'NA'; ?></br>
                                            </div>

                                            <div style="clear:both;background-color: #ffb75b;">

                                            </div>

                                        </div>

                                    <?php
                                    }

                                    ?>



                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">

                            </div>
                            <div class="card-body">
                                <!-- Nav pills -->

                                <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item" style="display:<?php if ($_POST['trng_type'] == 1 || $_POST['trng_type'] == 2) {
                                                                            echo "none";
                                                                        } ?>">
                                        <a class="nav-link active" data-toggle="pill" href="#menu1">Add Trainee</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link <?php if ($_POST['trng_type'] == 1 || $_POST['trng_type'] == 2) {
                                                                echo 'active';
                                                            } ?> " data-toggle="pill" href="#TrraineeList">Trainee List</a>
                                    </li>
                                    <li class="nav-item" >
                                        <a class="nav-link" data-toggle="pill" href="#import">Import Trainee</a>
                                    </li>
                                    <li class="nav-item" style="display:<?php if ($_POST['trng_type'] == 1 || $_POST['trng_type'] == 8) {
                                                                            echo "none";
                                                                        } ?>">
                                        <a class="nav-link" data-toggle="pill" href="#menu2">Action</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#menu2">tab3</a>
                                    </li> -->
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <!-- menue 1 -->
                                    <div id="menu1" class="container tab-pane <?php if ($_POST['trng_type'] == 3 || $_POST['trng_type'] == 4 || $_POST['trng_type'] == 8) {
                                                                                    echo 'active';
                                                                                } ?>">
                                        <div class="action-wrap d-flex justify-content-around">
                                            <h5 class="">Add New Tranee </h5><br>
                                            <!-- <button class="btn btn-primary sm" >Import Trainee</button> -->
                                        </div>

                                        <div class="trainee-wrap d-flex">
                                           <?php include "forms/trainneRegFrm.php"  ?>

                                            <div id="traineeDetail" style="display: none;width: 30%;
                                                                        background: bisque;
                                                                        margin-left: 5%;
                                                                        padding: 10px 20px;">
                                                <div>

                                                    <p class="text-center">Registred Trainee Details </p>
                                                </div>
                                                <hr>
                                                <div class="row d-flex justify-content-between">
                                                    <label for="">Name: </label>
                                                    <p id="trnName"></p>
                                                </div>
                                                <div class="row d-flex justify-content-between">
                                                    <label for="">Phone: </label>
                                                    <p id="trnPhone"></p>
                                                </div>
                                                <div class="row d-flex justify-content-between">
                                                    <label for="">Email : </label>
                                                    <p id="trnEmail"></p>
                                                </div>
                                                <div class="row btnAdd">

                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $rules = array(
                                            'name' => 'required',
                                            'hrms_id' => 'required',
                                            'designation' => 'required',
                                            'title' => 'required',
                                            "office_name" => "required",
                                            "email" => "email|unique:tbl_dept_trainee_registration:" . $_POST['id'] . ":" . $_POST['trng_type'],
                                            "phone" => "contactNumber|unique:tbl_dept_trainee_registration:" . $_POST['id'] . ":" . $_POST['trng_type'],

                                        );

                                        ?>
                                        <div class="d-flex justify-content-center ">
                                            <button type="submit" class="btn btn-primary" name="submit" value="Save" id="save" disabled onclick='add("new tranee","frm_newTranee","tbl_dept_trainee_registration",<?php echo json_encode($rules)  ?>,displayMessage)'>Save</button>
                                        </div>

                                   
                                    <?php

                                        if ($_POST['trng_type'] == 1 || $_POST['trng_type'] == 2) {

                                            include "long_term_trainee_template.php";
                                        } elseif ($_POST['trng_type'] == 3 || $_POST['trng_type'] == 4 || $_POST['trng_type'] == 8) {

                                            //include "mid_term_trainee_template.php";
                                            //

                                          $res =  $hp->fetchTrineeData($_POST['id'],$_POST['trng_type']  );
                                          //print_r($res);

                                           include "view_trainee_template.php";
                                        }
                                        ?>
                                         </div>
                                    <!-- end menu1 -->

                                    <!-- import -->
                                    <div id="import" style="float:none;margin:auto;line-height:1px" class="col-lg-10 tab-pane fade">
                                        <div class="import-worp">
                                            <div class="card mt-5">
                                                <div class="card-header">
                                                    <h4 class="card-title">Import Trainee From Another Program</h4>
                                                </div>
                                                <div class="card-body">
                                                   
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label><strong>Training Type</strong></label>
                                                                    <select class="custom-select mr-sm-2 mt-2" name="traning_type" id="traning_type">
                                                                        <option selected>Select Type</option>
                                                                        <?php
                                                                        $db = new Database();
                                                                        $count = 0;
                                                                        $db->select('tbl_training_type', "*", null, null, null, null);
                                                                        // print_r( $db->getResult());
                                                                        foreach ($db->getResult() as $row) {
                                                                            //print_r($row);
                                                                            $count++
                                                                        ?>
                                                                            <option value="<?php echo $row['id'] ?>">
                                                                                <?php echo $row['type'] ?>
                                                                            </option>

                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label><strong>Program</strong></label>
                                                                    <select class="custom-select mr-sm-2 mt-2" name="program_id" id="programId">
                                                                        <option selected>Select Program</option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button class="btn btn-primary" onclick="showTraine()" >Show</button>
                                                            </div>

                                                        </div>
                                                       
                                                  
                                                    <input type="hidden" name="update_id" id="update_id" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card mt-5">
                                                <div class="card-header">
                                                    <h4 class="card-title">Trainee Details</h4>
                                                </div>
                                                <div class="card-body">
                                                      <div id="trainne_dtl"></div>
                                                    <input type="hidden" name="update_id" id="update_id" />
                                                </div>
                                            </div>
                                    </div>
                                    <!--end import -->
                                    <div id="TrraineeList" style="float:none;margin:auto;line-height:1px" class="col-lg-10 tab-pane"  <?php if ($_POST['trng_type'] == 1) {
                                                                                                                                    echo 'active';
                                                                                                                                } ?>>
                                        <br>

                                        <div id="term2" class=" table table-responsive table-striped table-hover">
                                            <?php

                                            if ($_POST['trng_type'] == 1 || $_POST['trng_type'] == 2) {

                                                include "long_term_trainee_template.php";
                                            } elseif ($_POST['trng_type'] == 3 || $_POST['trng_type'] == 4 || $_POST['trng_type'] == 8) {

                                                // include "mid_term_trainee_template.php";
                                                include "view_trainee_template.php";
                                            }
                                            ?>

                                            <input type="button" class="btn btn-primary" name="send_email" id="send_email" style="display:none" value="Send Email" />
                                            <div class="loader">
                                                <img src="assets/img/loader.gif" alt="Loading" style="width: 300px;height: 90px;float: right;" />
                                            </div>
                                        </div>

                                    </div>

                                    <div id="menu2" class="container tab-pane fade"><br>
                                        <div id="mid_trainee_list" class=" table table-responsive table-striped table-hover">
                                            <table class=" term table" id="tranee_tbl">
                                                <thead class="" style="background: #315682;color:#fff;font-size: 11px;">


                                                    <th>Sl No</th>

                                                    <th> Name</th>
                                                    <th>Designation</th>
                                                    <th>Name of the Office</th>
                                                    <th>Email</th>
                                                    <th style="text-align:center;">Phone</th>
                                                    <th style="text-align:center;">

                                                        <input class="form-check-input checkAll2" type="checkbox" id="checkAll">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Send All
                                                    </th>
                                                    <th></th>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $count = 0;

                                                    $db->select(
                                                        'tbl_dept_trainee_registration',
                                                        "*",
                                                        null,
                                                        "trng_type = '" . $_POST['trng_type'] . "' AND program_id =" . $_POST['id'],
                                                        null,
                                                        null
                                                    );


                                                     // $res2 =  $hp->fetchTrineeData($_POST['id'],$_POST['trng_type']  );

                                                    foreach ($db->getResult() as $row) {

                                                        $count++
                                                    ?>
                                                        <tr>

                                                            <td><?php echo $count; ?></td>

                                                            <td> <?php echo $row['name']  ?></td>
                                                            <td> <?php echo $row['designation']  ?></td>
                                                            <td> <?php echo $row['office_name']  ?></td>
                                                            <td> <?php echo $row['email']  ?></td>
                                                            <td style="text-align:center;"><?php echo $row['phone']; ?>
                                                            </td>
                                                            <td style="text-align:center;">
                                                                <div class="form-check form-check-inline">


                                                                    <label class="form-check-label" for="inlineCheckbox1">Send Email</label>
                                                                    <input class="form-check-input" type="checkbox" name="sent" id="sent" value="1" <?php echo ($row['mail_status'] == 1) ? 'checked' : '' ?> style="opacity: 1;visibility: visible;">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="tranee_id" id="tranee_id" value="<?php echo $row['id']; ?>">
                                                            </td>

                                                        </tr>
                                                    <?php
                                                    }


                                                    ?>

                                                </tbody>
                                            </table>
                                            <input type="button" class="btn btn-primary" value="Send Email" onclick="show_email_div()" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>


    </div>

    </div>

    </div>

    </div>



    <!-- msgBox Modal Modal HTML -->
    <div id="emailModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content" style="width:130%; margin:120px -60px">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="m_title" style="text-align:center;">Email Login Credentials to
                            Trainee </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Subject : </label>
                            <input type="text" class="form-control col-sm-8" name="subject" id="subject" placeholder="Enter subject">

                        </div>
                        <div class="form-group">
                            <label> Email Content : </label>
                            <textarea class="form-control" name="email_body" id="email_body" rows="5" style="border: 1px solid black;max-height: 140px;"></textarea>
                        </div>
                        <div class="form-group">
                            <label> Attachments : </label>
                            <div id="attatchment">

                            </div>
                        </div>
                        <div class="loader">
                            <img src="assets/img/loader.gif" alt="Loading" style="width: 300px;height: 90px;" />
                        </div>
                    </div>
                    <div class="modal-footer" id="mailbtn">
                        <?php
                        //echo  $_POST['id'] ;

                        $latter = '';
                        $anx1 = '';
                        $anx2 = '';
                        $anx3 = '';
                        $file_path = "/mdrafm/admin/email_doc/";
                        $path = $_SERVER['DOCUMENT_ROOT'] . $file_path;
                        $db->select('tbl_email_doc', "*", null, "program_id =" . $_POST['id'], null, null);

                        foreach ($db->getResult() as  $value) {
                            //print_r($value);
                            $latter = $value['latter'];
                            $anx1 = $value['anx1'];
                            $anx2 = $value['anx2'];
                            $anx3 = $value['anx3'];
                        }

                        ?>
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="button" class="btn btn-primary" value="Send" onclick="handle_mail('<?php echo $latter ?>','<?php echo $anx1 ?>','<?php echo $anx2 ?>','<?php echo $anx3 ?>')">

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- msgBox Modal Modal HTML -->


    <!-- msgBox Modal Modal HTML -->
    <div id="traineeDetailModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content" style="width:200%;margin-left:-35%">
              
                    <div class="modal-header">
                        <h5 class="modal-title" id="m_title" style="text-align:center;color:#0905eb">Trainee Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="detail_body"></div>
                        <div id="modalContent"></div>
                    </div>
                    <div class="modal-footer" id="dtl_footer">


                    </div>
                
            </div>
        </div>
    </div>

    <!-- msgBox Modal Modal HTML -->
    <div id="cnfacceptModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="m_title" style="text-align:center;">Accept Trainee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="warning">
                            <p>Are you sure you want to Accept?</p>

                        </div>
                        <p id="m_body"></p>
                    </div>
                    <div class="modal-footer" id="accept_footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">


                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <div id="traineeDetailModal2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="m_title" style="text-align:center;">Trainee Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body" id="trainee_body">
                       
                    </div>
                    <div class="modal-footer" id="accept_footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">


                    </div>
                </form>
            </div>
        </div>
    </div> -->

    <div class="modal fade bd-example-modal-lg p_model" id="traineeDetailModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="overflow-y: auto;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Document</h5>
                    <button type="button" class="close btn_close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="trainee_body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_close">Close</button>
                </div>
            </div>
        </div>
    </div>


    <?php include('common_script.php') ?>


</body>

</html>

<script type="text/javascript">
    function showDetail(id) {
        console.log(id);
        $('#trainee_body').html('');
        $('#trainee_body').html(` <embed src="uploads/${id}" frameborder="0" width="100%" height="500px">`);
        $('#traineeDetailModal2').modal('show');
    }

    $("#checkAll").click(function() {
        // alert(123);
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $("#checkAll2").click(function() {
        // alert(123);
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('input[type="checkbox"]').on('change', function() {
        var checkedValue = $(this).prop('checked');
        // uncheck sibling checkboxes (checkboxes on the same row)
        $(this).closest('tr').find('input[type="checkbox"]').each(function() {
            $(this).prop('checked', false);
        });
        $(this).prop("checked", checkedValue);

    });

    $('#traning_type').on('change', function() {
    var type = $('#traning_type').val();

    $.ajax({
        type: "POST",
        url: "ajax_master.php",
        data: {
            action: "timeTable_prgram",
            type: type,

        },
        success: function(res) {
            console.log(res);
            $('#programId').html(res);

        }
    })
})

function showTraine(){
    let trng_type = $('#traning_type').val();
    let program_id = $('#programId').val();

    $.ajax({
            url: 'ajax_trainee.php',
            type: "POST",
            data: {
                action: 'showTraine',
                'prgram_id': program_id,
                'trng_type': trng_type
                
            },

            success: function(data) {
                console.log(data);
                $('#trainne_dtl').html(data);

               
            }
        });

}
    function show_email_div() {

        let prgram_id = <?php echo $_POST['id'] ?>;

        $.ajax({
            url: 'upload_email_doc.php',
            type: "POST",
            data: {
                'prgram_id': prgram_id,
                'action': 'select_Email_attatch'
            },

            success: function(data) {
                console.log(data);
                $('#attatchment').html(data);

                $('#emailModal').modal('show');
            }
        });

    }

    async function handle_mail(latter, anx1, anx2, anx3) {


        TableData = storeTblValues();
        // TableData = JSON.stringify(TableData);
        const emailStatus = TableData.map(async data => {
            console.log(data);
            if (data.send == 1) {
                const Status = await sendEmail(data.email, data.phone, data.trnee_id, data.name, latter,
                    anx1, anx2, anx3);
                const smsStatus = await handleSms(data.phone);
                return [Status, smsStatus];
            }


        })


        const results = await Promise.all(emailStatus);

        /// console.log(results);
    }

    async function doAjax(ajaxurl, args) {
        let result;

        try {
            result = await $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: args
            });

            return result;
        } catch (error) {
            console.error(error);
        }
    }

    async function sendEmail(email, phone, traine_id, name) {

        let subject = $('#subject').val();
        let email_body = $('#email_body').val();
        let program_id = <?php echo $_POST['id'] ?>;

        let args = {
            'action': 'register_trainee',
            subject,
            email_body,
            email,
            program_id,
            phone,
            traine_id,
            name
        }
        let url = 'action_controller.php';

        const stuff = await doAjax(url, args);
        console.log(stuff);
        return stuff;



    }

    // function sendEmail(email, phone, trnee_id, name, latter, anx1, anx2, anx3) {


    //     let subject = $('#subject').val();
    //     let email_body = $('#email_body').val();
    //     let program_id = <?php echo $_POST['id'] ?>;
    //     $.ajax({
    //         url: 'mid_term_send_mail.php',
    //         type: "POST",
    //         data: {
    //             program_id: program_id,
    //             subject: subject,
    //             email_body: email_body,
    //             email: email,
    //             phone: phone,
    //             traine_id: trnee_id,
    //             name: name,
    //             latter: latter,
    //             anx1: anx1,
    //             anx2: anx2,
    //             anx3: anx3
    //         },

    //         beforeSend: function() {
    //             $('.loader').show();
    //               $('#send_email').prop('disabled', true);
    //         },

    //         success: function(data) {
    //             $('.loader').hide();
    //             console.log(data);
    //             // if(data == 'success'){
    //             //     sessionStorage.message = "Email Sent Successfully";
    //             //     sessionStorage.type = "success";
    //             //     location.reload();
    //             // }
    //         }
    //     });


    // }

    async function handleSms(phone) {
        var otp = "Registration Complete for Sensitization workshop on Odisha General Financial Rules 2023";
        var content = otp + "- Reminder to view the mail received from MDRAFM Govt. of Odisha.";
        const url = "https://govtsms.odisha.gov.in/api/api.php";
        const options = {
            method: 'POST',
            headers: {
                Accept: 'text/plain'
            },
            body: new URLSearchParams({
                action: 'singleSMS',
                department_id: 'D018001',
                template_id: '1007847089437214478',
                sms_content: `${otp} - Reminder to view the mail received from MDRAFM Govt. of Odisha.`,
                phonenumber: phone
            })
        };

        try {
            const response = await fetch(url, options);

            if (response.ok) {
                const result = await response.json();
                console.log(result);
            }
        } catch (err) {
            console.error(err);
        }

    }

    function storeTblValues() {
        var TableData = new Array();
        $('#tranee_tbl tr').each(function(row, tr) {
            TableData[row] = {

                "trnee_id": $(tr).find('#tranee_id').val(),
                "name": $(tr).find('td:eq(1)').text(),
                "email": $(tr).find('td:eq(4)').text(),
                "phone": $(tr).find('td:eq(5)').text(),
                "send": ($(tr).find('input[type="checkbox"]:checked').val() == 1) ? "1" : "0",

            }
        });
        TableData.shift(); // first row will be empty - so remove
        return TableData;
    }

    function upload_email_doc(doc_id) {

        let prgram_id = <?php echo $_POST['id'] ?>;
        var name = document.getElementById(doc_id).files[0].name;
        var form_data = new FormData();
        var ext = name.split('.').pop().toLowerCase();
        if (jQuery.inArray(ext, ['pdf', 'docx']) == -1) {
            alert("Invalid Image File");
        }
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById(doc_id).files[0]);
        var f = document.getElementById(doc_id).files[0];
        var fsize = f.size || f.fileSize;
        if (fsize > 2000000) {
            alert("Image File Size is very big");
        } else {
            form_data.append("file", document.getElementById(doc_id).files[0]);
            form_data.append("action", "email_doc");
            form_data.append("type", doc_id);
            form_data.append("program_id", prgram_id);

            console.log(form_data);
            $.ajax({
                url: "upload_email_doc.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
                },
                success: function(res) {
                    let elm = res.split('#');
                    console.log(res);
                    if (elm[0] == "success") {
                        sessionStorage.message = "Document" + ' ' + elm[1];
                        sessionStorage.type = "success";
                        $.ajax({
                            url: 'upload_email_doc.php',
                            type: "POST",
                            data: {
                                'prgram_id': prgram_id,
                                'action': 'select_Email_attatch'
                            },

                            success: function(data) {
                                console.log(data);
                                $('#attatchment').html(data);

                                $('#emailModal').modal('show');
                            }
                        });
                    }
                    return false;
                }
            });
        }
    }

    function remove(id, field) {
        //alert(id);
        let prgram_id = <?php echo $_POST['id'] ?>;
        $.ajax({
            type: 'POST',
            url: 'upload_email_doc.php',
            data: {
                id: id,
                field: field,
                action: "remove_report"
            },
            success: function(res) {
                console.log(res);
                let elm = res.split('#');
                //console.log(elm[0]);
                if (elm[0] == "success") {
                    //print_r$("#email_div").load(" #email_div");
                    $.ajax({
                        url: 'upload_email_doc.php',
                        type: "POST",
                        data: {
                            'prgram_id': prgram_id,
                            'action': 'select_Email_attatch'
                        },

                        success: function(data) {
                            console.log(data);
                            $('#attatchment').html(data);

                            $('#emailModal').modal('show');
                        }
                    });
                }
            }
        })
    }

    function view_trainee_dtl(user_id, status, id) {
        //alert(status);
        $('#dtl_footer').html('');
        $.ajax({
            type: "POST",
            url: "ajax_trainee.php",

            data: {
                action: 'view_trainee_dtl',
                user_id: user_id
            },
            success: function(res) {
                console.log(res);
                $('#detail_body').html(res);
                if (status == 0) {
                    $('#dtl_footer').html(` <input type="button" class="btn btn-primary" name="accept" value="Accept"
                                            onclick="cnftrainee(${id})" style="margin: 0 auto;" />
                                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">   
                                            `);
                } else {
                    $('#dtl_footer').html(` <input type="button" class="btn btn-success" name="accept" value="Accepted"
                                            style="margin: 0 auto;" />
                                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">   
                                            `);
                }


                $('#traineeDetailModal').modal('show');
            }
        })


    }

    var delay = (function() {
        var timer = 0;
        return function(callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();


    function verifyUser() {
        let phone_no = $('.phone').val();

        delay(function() {
            chkTrainee(phone_no);
        }, 1000);

    }

    function chkTrainee(phone_no) {
        $.ajax({
            type: "POST",
            url: "ajax_trainee.php",
            dataType: 'json',
            data: {
                'action': 'chkUser',
                'phone_no': phone_no
            },
            success: function(res) {
                console.log(res);
                //traineeDetail
                if (res.status == 'success') {
                    $('#traineeDetail').show();
                    $('.phoneErr').text('This Phone Number Is Allready Regestred');
                    $('#save').attr('disabled', true);
                    $('#trnName').text(res.result.name);
                    $('#trnPhone').text(res.result.phone);
                    $('#trnEmail').text(res.result.email);
                    $('.btnAdd').html(`<button class="btn btn-primary btn-sm" onclick="addTarinee(${res.result.id},${res.result.user_id})" >Add Trainee</button>`)
                } else {
                    $('#traineeDetail').hide();
                    $('.phoneErr').text('');
                    $('#save').attr('disabled', false);
                }
            }
        })
    }
   
    function addTarinee(traineeId,userId){
        let programId =  <?php echo $_POST['id']; ?>;
        let trngType =  <?php echo $_POST['trng_type']; ?>;
   
        $.ajax({
            type: "POST",
            url: "ajax_trainee.php",
            dataType:'json',
            data:{
                'action': 'saveRegistredTrainee',
                'traineeId': traineeId,
                'userId': userId,
                'programId': programId,
                'trngType': trngType
            },
            success: function(res) {
                console.log(res);
                if(res.status == 'success'){
                   // location.reload();
                   sessionStorage.message =  res.msg;
                    sessionStorage.type = "success";
                    location.reload();
                }else{
                    sessionStorage.message =  res.msg;
                    sessionStorage.type = "error";
                    location.reload();
                }
            }
        })
    }
    //$('#phone).on('kyeup',function(){});

    // $('#phone2').on('kyeup', function() {
    //     // let phone_no = '';
    //     //alert(123);
    //     // setTimeout(()=>{
    //     //     phone_no = $('#phone').val();
    //     // },2000);
    //     // console.log(phone_no);
    //      console.log(123);
    // });

    function add(str, frm, tbl, rules, callback) {

        var update_id = $('#update_id').val();
        let programId =  <?php echo $_POST['id']; ?>;
        let trngType =  <?php echo $_POST['trng_type']; ?>;

        $.ajax({
            type: "POST",
            url: "ajax_trainee.php",

            data: $('#' + frm).serialize() + '&' + $.param({
                'action': 'saveTrainee',
                'table': tbl,
                'program_id': programId,
                'trng_type': trngType,
                 rules: rules
                
            }),
            success: function(res) {
                console.log(res);
                callback(res);
            }
        })

    }
  $('.editBtn').on('click',function(){
     // let id = $(this).data("id");
     let id = $(this).attr("data-id")
      //alert(id);
      getFrom("modalContent", "./forms/trainneRegFrm.php");
      $.ajax({
            type: "POST",
            url: "ajax_trainee.php",
            dataType:'json',
            data: {'action': 'fetchTrainee', 'id': id},
            success: function(res) {
                console.log(res);
                
                // $('#dtl_footer').html(`<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                //                    <button type="button" class="btn btn-primary update" name="submit" value="Save" id="save"
                //                    onclick="update('new tranee','frm_newTranee_update','tbl_trainee_details',${id})">Update</button>`);
               
     
            $('#dtl_footer').html(`<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                   <button type="button" class="btn btn-primary update" name="submit" value="Save" id="save" data-id=${id}
                                  ">Update</button>`);

                 $('.name').val(res.name);
                 $('.hrms_id').val(res.hrms_id);
                 $('.designation').val(res.designation);
                 $('.office_name').val(res.office_name);
                 $('.email').val(res.email);
                 $('.phone').val(res.phone);
            $('#traineeDetailModal').modal('show');
              //  callback(res);
            }
        })
      
    
  })

  function getFrom(contentId,pageUrl){
    var xhr = new XMLHttpRequest();
    
      xhr.onreadystatechange = function() {
       
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // On success, inject the HTML page content into the modal
            document.getElementById(contentId).innerHTML = xhr.responseText;
          } else {
            // Handle error
            console.error("Error fetching HTML page:", xhr.status);
          }
        }
      };
      xhr.open("GET",pageUrl, true);
      xhr.send();
  }
  
  $(document).on('click','.update',function(){

    var closestForm = $(this).parent().parent().children();
    var form = closestForm.find('.frmTranee');

    var name = form.find('.name').val();
    var hrms_id = form.find('.hrms_id').val();
    var designation = form.find('.designation').val();
    var office_name = form.find('.office_name').val();
    var email = form.find('.email').val();
    var phone = form.find('.phone').val();
    var id = $(this).attr('data-id');

    $.ajax({
            type: "POST",
            url: "ajax_trainee.php",
            //data:{'action': 'editTrainee'},
            data: {
                'name': name,
                'hrms_id': hrms_id,
                'designation': designation,
                'office_name': office_name,
                'email': email,
                'phone': phone,
                'action': 'editTrainee',
                'table': 'tbl_trainee_details',
                'update_id': id
            },
            success: function(res) {
                console.log(res);
               let elm = res.split('#');
                if (elm[0] == "success") {
                    sessionStorage.message = elm[1];
                    sessionStorage.type = "success";
                    location.reload();
                }
            }
        })
           
           
})


    function cnfBox(id) {
        //alert(id);
        $('#m_footer').empty();
        var html =
            `<input type="button" class="btn btn-danger btn-dlt" value="Delete" onclick="delete_record(${id},'tbl_tranee_registration')" />`;
        $('#m_footer').append(html);
        $('#cnfModal').modal('show');
    }

    function delete_record(id, tbl) {

        $.ajax({
            type: "POST",
            url: "ajax_master.php",
            data: {

                action: "delete",
                id: id,
                table: tbl
            },
            success: function(res) {
                console.log(res);
                if (res == "success") {
                    sessionStorage.message = "record deleted successfully";
                    sessionStorage.type = "success";
                    location.reload();
                }
            }
        })
    }

    function send_record(id, tbl) {

        $.ajax({
            type: "POST",
            url: "ajax_master.php",
            data: {

                action: "send",
                id: id,
                table: tbl
            },
            success: function(res) {
                console.log(res);
                if (res == "success") {
                    sessionStorage.message = "Send to MDRAFM Successfully";
                    sessionStorage.type = "success";
                    location.reload();
                }
            }
        })
    }


    function cnftrainee(id) {
        //alert(id);
        $('#traineeDetailModal').modal('hide');
        $('#m_footer').empty();
        var html =
            `<input type="button" class="btn btn-danger btn-dlt" value="Accept" onclick="Accept_trainee(${id},'tbl_trainee_info')" />`;
        $('#accept_footer').append(html);
        $('#cnfacceptModal').modal('show');
    }


    function Accept_trainee(id, tbl) {

        $.ajax({
            type: "POST",
            url: "ajax_trainee.php",
            data: {

                action: "accept_trainee",
                id: id,
                table: tbl
            },
            success: function(res) {
                console.log(res);
                if (res == "success") {
                    sessionStorage.message = "Accepted successfully";
                    sessionStorage.type = "success";
                    location.reload();
                }
            }
        })
    }


    function datapost(path, params, method) {
        //alert(path);
        method = method || "post"; // Set method to post by default if not specified.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);
        for (var key in params) {
            if (params.hasOwnProperty(key)) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);
                form.appendChild(hiddenField);
            }
        }
        document.body.appendChild(form);
        form.submit();
    }
</script>