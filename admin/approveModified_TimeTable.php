<!DOCTYPE html>
<html lang="en">


<head>
    <?php

    include('header_link.php');
    include('../config.php');
    include 'database.php';
    $db = new Database();
    ?>

</head>

<body class="user-profile">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="wrapper ">

        <?php include('sidebar.php'); ?>

        <div class="main-panel" id="main-panel">
            <?php include('navbar.php'); ?>

            <div class="panel-header panel-header-sm">


            </div>


            <div class="content" style="margin-top: 50px;">

                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="card-title"> Modified Time Table Approval</h4>
                                    </div>

                                </div>


                            </div>
                            <div class="card-body">
                                <div id="term2" class=" table table-responsive table-striped table-hover" style="width:100%;margin:0px auto">
                                    <table class=" term table" id="tbl_attandance">
                                        <thead class="" style="background: #315682;color:#fff;font-size: 11px;">


                                            <th style="width: 70px;">Sl No</th>
                                            <th style="text-align:center;width: 105px;">Program Name</th>
                                            <th style="text-align:center;width: 105px;">Time Table Name</th>
                                            <th style="text-align:center;width: 105px;">Session No</th>
                                            <th style="text-align:center;width: 250px;">Existing Details</th>
                                            <th style="text-align:center;width: 250px;">Modify Details</th>
                                            <th style="text-align:center;width: 105px;">Action</th>

                                        </thead>
                                        <tbody>
                                            <?php
                                            $time_table = '';
                                            $program_table = '';
                                            $count = 0;
                                            $db->select('tbl_modifytimetable', '*', null, " trng_type != 0 AND ( status = 2 OR status = 3 )", null, null);
                                            $res2 = $db->getResult();
                                            foreach ($res2 as $res) {
                                                $trng_type = $res['trng_type'];
                                               // print_r($trng_row);
                                                if ($trng_type == 0 || $trng_type == 1 || $trng_type == 2) {
                                                    $time_table = 'tbl_time_table';
                                                    $program_table = 'tbl_program_master';
                                                    $subject_tbl = 'tbl_subject_master';
                                                } elseif ($trng_type == 3 || $trng_type == 8) {

                                                    $program_table = 'tbl_mid_program_master';
                                                    $subject_tbl = 'tbl_mid_syllabus';
                                                } elseif ($trng_type == 4 || $trng_type == 5) {

                                                    $program_table = 'tbl_short_program_master';
                                                }

                                                if ($trng_type == 3 || $trng_type == 4) {

                                                    $time_table = "tbl_inhouse_time_table";
                                                } else if ($trng_type == 5 || $trng_type == 8) {

                                                    $time_table = "tbl_sponsored_time_table.php";
                                                }
                                               
                                                //$db->select('tbl_modifytimetable',"*",null,"status = 1",null,null);
                                                // $sql = "SELECT m.* ,r.program_id,r.name
                                                //     FROM `tbl_modifytimetable` m JOIN $time_table t ON m.time_table_id = t.id 
                                                //     JOIN `tbl_time_table_range` r ON t.table_range_id = r.id 
                                                //     ";

                                                   // $db->select_one(`tbl_time_table_range`, "program_id", $trng_row['trng_type']);

                                                   $sql = "SELECT r.program_id,r.name FROM `tbl_time_table_range` r 

                                                            JOIN `tbl_inhouse_time_table` t ON r.id=t.table_range_id 
                                                            WHERE t.id= '".$res['time_table_id']."' AND t.trng_type ='".$res['trng_type']."'";
                                                   $db->select_sql($sql);

                                                    foreach ($db->getResult() as $row4) {
                                                      
                                                         $program_id = $row4['program_id'];
                                                         $timetable_name   = $row4['name'];
                                                    } 

                                                    //
                                                    $count++;
                                                  ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <td>
                                                            <?php
                                                            $db->select_one($program_table, "id,prg_name", $row4['program_id']);

                                                            foreach ($db->getResult() as $row1) {
                                                                echo $prog_name = $row1['prg_name'];
                                                                $prog_id   = $row1['id'];
                                                            }

                                                            ?>

                                                        </td>
                                                        <td><?php echo $timetable_name ?></td>
                                                        <td><?php echo $res['session_no']; ?></td>
                                                        <td>
                                                            <?php
                                                            echo '<div><p>' . 'Class time - ' . $res['class_start_time'] . ' - ' . $res['class_end_time'] . '</div></p>';

                                                            if ($res['trng_type'] == 1 || $res['trng_type'] == 2) {
                                                                if ($res['period_type'] == 2) {
                                                                    echo ($res['break_time'] == 1) ? 'Tea Break' : 'Lunch Break';
                                                                }
                                                                if ($res['session_type'] == 1) {

                                                                    if ($res['paper_covered'] != '') {
                                                                        echo  $res['paper_covered'] . '<br>';
                                                                    } else {
                                                                        $db->select_one('tbl_topic_master', "topic", $res['topic_id']);

                                                                        foreach ($db->getResult() as $row3) {
                                                                            echo  $row3['topic'] . '<br>';
                                                                        }
                                                                    }
                                                                    $db->select_one('tbl_paper_master', "paper_code", $res['paper_id']);

                                                                    foreach ($db->getResult() as $row4) {

                                                                        echo 'Paper - ' . $row4['paper_code'] . '<br>';
                                                                    }

                                                                    $faculty_id = explode(',', $res['faculty_id']);

                                                                    foreach ($faculty_id as $faculty) {
                                                                        $db->select_one('tbl_faculty_master', "name", $faculty);

                                                                        foreach ($db->getResult() as $row1) {
                                                                            echo $row1['name'];
                                                                            echo '<br>';
                                                                        }
                                                                    }
                                                                } else {
                                                                    echo '<div style="margin-top: 10px;font-weight: 600;">';
                                                                    if ($res['class_remark'] == '') {

                                                                        $db->select_one('other_topic', "name", $res['other_class']);

                                                                        foreach ($db->getResult() as $row3) {
                                                                            echo  $row3['name'];
                                                                        }
                                                                    } else {
                                                                        echo $res['class_remark'];
                                                                    }
                                                                }
                                                                echo '</div>';
                                                            } else if ($res['trng_type'] == 3 || $res['trng_type'] == 4) {
                                                                switch ($res['break_time']) {
                                                                    case '1':
                                                                        echo '<p>Tea Break<p>';
                                                                        break;
                                                                    case '2':
                                                                        echo '<p>Lunch Break<p>';
                                                                        break;
                                                                    default:

                                                                        // echo '<div><p>'.'Class time - '. $res['class_start_time'] .' - '. $res['class_end_time'].'</div></p>';

                                                                        if ($res['session_type'] == 1) {
                                                                            if ($res['paper_covered'] != '') {
                                                                                echo '<p>' . $res['paper_covered'] . '</p>';
                                                                            } else {
                                                                                $db->select_one($subject_tbl, "subject", $res['subject_id']);

                                                                                foreach ($db->getResult() as $row3) {
                                                                                    echo '<p>' . $row3['subject'] . '</p>';
                                                                                }
                                                                            }



                                                                            $faculty_id = explode(',', $res['faculty_id']);

                                                                            foreach ($faculty_id as $faculty) {
                                                                                $db->select_one("tbl_faculty_master", "name", $faculty);

                                                                                foreach ($db->getResult() as $row1) {
                                                                                    if ($row1['name'] == 'NA') {
                                                                                        echo $res['guest_faculty_name'];
                                                                                        echo '<br>';
                                                                                    } else {
                                                                                        echo $row1['name'];
                                                                                        echo '<br>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        } else {

                                                                            if ($res['class_remark'] == '') {

                                                                                $db->select_one('other_topic', "name", $res['other_class']);

                                                                                foreach ($db->getResult() as $row3) {
                                                                                    echo '<p>' . $row3['name'] . '</p>';
                                                                                }
                                                                            } else {
                                                                                echo $res['class_remark'];
                                                                            }
                                                                        }
                                                                        break;
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            echo '<div><p>' . 'Class time - ' . $res['new_class_start_time'] . ' - ' . $res['new_class_end_time'] . '</div></p>';

                                                            if ($res['trng_type'] == 1 || $res['trng_type'] == 2) {
                                                                if ($res['new_session_type'] == 1) {
                                                                    if ($res['new_paper_covered'] != '') {
                                                                        echo '<p>' . $res['new_paper_covered'] . '</p>';
                                                                    } else {
                                                                        $db->select_one('tbl_topic_master', "topic", $res['new_topic_id']);

                                                                        foreach ($db->getResult() as $row3) {
                                                                            echo '<p>' . $row3['topic'] . '</p>';
                                                                        }
                                                                    }
                                                                    $db->select_one('tbl_paper_master', "paper_code", $res['new_paper_id']);

                                                                    foreach ($db->getResult() as $row4) {

                                                                        echo '<p>' . 'Paper - ' . $row4['paper_code'] . '</p>';
                                                                    }

                                                                    $faculty_id = explode(',', $res['new_faculty_id']);

                                                                    foreach ($faculty_id as $faculty) {
                                                                        $db->select_one('tbl_faculty_master', "name", $faculty);

                                                                        foreach ($db->getResult() as $row1) {
                                                                            echo $row1['name'];
                                                                            echo '<br>';
                                                                        }
                                                                    }
                                                                } else {
                                                                    if ($res['new_class_remark'] == '') {

                                                                        $db->select_one('other_topic', "name", $res['new_other_class']);

                                                                        foreach ($db->getResult() as $row3) {
                                                                            echo '<p>' . $row3['name'] . '</p>';
                                                                        }
                                                                    } else {
                                                                        echo $res['new_class_remark'];
                                                                    }
                                                                }
                                                            } else {
                                                                if ($res['new_session_type'] == 1) {
                                                                    if ($res['new_paper_covered'] != '') {
                                                                        echo '<p>' . $res['new_paper_covered'] . '</p>';
                                                                    } else {

                                                                        $db->select_one($subject_tbl, "subject", $res['new_subject_id']);

                                                                        foreach ($db->getResult() as $row3) {
                                                                            echo '<p>' . $row3['subject'] . '</p>';
                                                                        }
                                                                    }
                                                                    $db->select_one('tbl_mid_paper_master', "paper_code,paper_title", $res['new_paper_id']);

                                                                    foreach ($db->getResult() as $row4) {

                                                                        echo '<p>' . $row4['paper_code'] . '-' . $row4['paper_title'] . '</p>';
                                                                    }

                                                                    $faculty_id = explode(',', $res['new_faculty_id']);

                                                                    foreach ($faculty_id as $faculty) {
                                                                        $db->select_one('tbl_faculty_master', "name", $faculty);

                                                                        foreach ($db->getResult() as $row1) {
                                                                            echo $row1['name'];
                                                                            echo '<br>';
                                                                        }
                                                                    }
                                                                } else {
                                                                    if ($res['new_class_remark'] == '') {

                                                                        $db->select_one('other_topic', "name", $res['new_other_class']);

                                                                        foreach ($db->getResult() as $row3) {
                                                                            echo '<p>' . $row3['name'] . '</p>';
                                                                        }
                                                                    } else {
                                                                        echo $res['new_class_remark'];
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            switch ($res['status']) {
                                                                case '2':
                                                            ?>
                                                                    <button type="submit" class="btn btn-info mt-2" onclick="approve(<?php echo $res['time_table_id'] ?>,<?php echo $res['session_no'] ?>,'<?php echo $res['training_dt']  ?>',<?php echo $_SESSION['user_id']; ?>,<?php echo $trng_type ?>)">Approve</button>
                                                                <?php
                                                                    break;
                                                                case '3':
                                                                ?>
                                                                    <button type="button" class="btn btn-success">Already Approved </button>
                                                            <?php
                                                                    break;
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
    <div id="cnfModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="m_title" style="text-align:center;"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="warning">
                            <p class="wrn_msg"></p>

                        </div>
                        <div id="m_body" style="display:none">
                            <div class="form-group">
                                <label> Remark : </label>
                                <textarea class="form-control cancel_comment" style="border: 1px solid black;" id="reject_comment" rows="3"></textarea>
                            </div>
                        </div>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer" id="m_footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- msgBox Modal Modal HTML -->
    <div id="timetableModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content" style="width:200%; margin:20px -150px">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="timeTable_title" style="text-align:center;"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div id="time_Table"></div>

                    </div>
                    <div class="modal-footer" id="t_footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">

                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include('common_script.php') ?>

</body>

</html>

<script type="text/javascript">
    // status code 1->pending,2->approve,3->reject


    function approve(tbl_id, session_no, trng_dt, user_id, trng_type) {
        $('#m_body').hide();
        $('#m_footer').html('');

        $('#m_title').html(`Approve Modified Time Table`);
        $('.wrn_msg').html(`Hello Sir, Are you sure you want to Approve this Time Table?`);
        var html =
            `<input type="button" class="btn btn-success btn-dlt" value="Approve" onclick="approve_record(${tbl_id},${session_no},'${trng_dt}',${user_id},${trng_type})" />`;
        $('#m_footer').append(html);
        $('#cnfModal').modal('show');
    }

    function reject(id, title) {
        $('#m_footer').html('');
        $('#timetableModal').modal('hide');
        $('#m_title').html(`${title} Time Table`);
        $('.wrn_msg').html(`Hello Sir,Please Write Remark For  ${title} Time Table?`);
        var html =
            `<input type="button" class="btn btn-danger btn-dlt" value="Reject" onclick="reject_record(${id},'tbl_time_table_range')" />`;
        $('#m_body').show();
        $('#m_footer').append(html);
        $('#cnfModal').modal('show');
    }

    function approve_record(tbl_id, session_no, trng_dt, user_id, trng_type) {

        $.ajax({
            type: "POST",
            url: "ajax_master.php",
            data: {

                action: "approve_modified_timeTable",
                tbl_id: tbl_id,
                session_no: session_no,
                trng_dt: trng_dt,
                user_id: user_id,
                trng_type:trng_type
            },
            success: function(res) {
                console.log(res);
                let elm = res.split('#');
                    if (elm[0] == "success") {
                        sessionStorage.message = str + ' ' + elm[1];
                        sessionStorage.type = "success";
                        location.reload();
                    }
            }
        })
    }



    function cnfBox(id) {
        //alert(id);
        $('#m_footer').empty();
        var html =
            `<input type="button" class="btn btn-danger btn-dlt" value="Delete" onclick="delete_record(${id},'tbl_program_master')" />`;
        $('#m_footer').append(html);
        $('#cnfModal').modal('show');
    }

    function sendToApprove(id, tbl) {

        $.ajax({
            type: "POST",
            url: "ajax_master.php",
            data: {

                action: "send_to_approve",
                id: id,
                table: tbl
            },
            success: function(res) {
                console.log(res);
                if (res == "success") {
                    sessionStorage.message = " Successfully Send to Director for Approval";
                    sessionStorage.type = "success";
                    location.reload();
                }
            }
        })
    }
</script>