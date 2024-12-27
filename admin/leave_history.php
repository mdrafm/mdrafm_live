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
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="wrapper ">

        <?php include('sidebar.php'); ?>

        <div class="main-panel" id="main-panel">
            <?php include('navbar.php'); ?>
            <div class="panel-header panel-header-sm">
            </div>


            <div class="content" style="margin-top: 50px;">

                <div class="col-md-4">
                    <div id="alert_msg" class="alert alert-success"></div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">Leave Applications Report</div>
                            <div class="card-body">
                                <div class="table table-responsive table-striped table-hover">
                                    <table class="table">
                                        <thead style="background: #315682;color:#fff;font-size: 11px;">
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Program</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Leave Type</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                                <th>Application</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $sql = "SELECT l.*,f.name FROM `tbl_leave` l
                                 JOIN `tbl_program_directors` d ON l.program_id = d.program_id 
                                 JOIN `tbl_faculty_master` f ON d.course_director = f.id 
                                 WHERE f.user_id =" . $_SESSION['user_id'];

                                            $db->select_sql($sql);
                                            $res = $db->getResult();
                                            $cnt = 0;
                                            foreach ($res as $row) {
                                                $cnt++;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $cnt++ ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $programm_tbl = '';

                                                        switch ($row['trng_type']) {
                                                            case '4':
                                                                $programm_tbl = 'tbl_short_program_master';
                                                                break;
                                                            case '3':
                                                                $programm_tbl = 'tbl_mid_program_master';
                                                                break;
                                                            default:
                                                                $programm_tbl = 'tbl_program_master';
                                                                break;
                                                        }

                                                        $program_sql = " SELECT * FROM  $programm_tbl Where id =" . $row['program_id'];
                                                        $db->select_sql($program_sql);
                                                        foreach ($db->getResult() as $program) {
                                                            echo $program['prg_name'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $program_sql = " SELECT name FROM  tbl_user Where id =" . $row['user_id'];
                                                        $db->select_sql($program_sql);
                                                        foreach ($db->getResult() as $user) {
                                                            echo $user['name'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['mobile_no'] ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        switch ($row['leave_type_id']) {
                                                            case '1':
                                                                echo 'EL';
                                                                break;
                                                            case '2':
                                                                echo 'CL';
                                                                break;
                                                            case '3':
                                                                echo 'Head Quarter Leave';
                                                                break;
                                                            default:
                                                                # code...
                                                                break;
                                                        }

                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php echo date("d/m/Y", strtotime($row['from_dt'])); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo date("d/m/Y", strtotime($row['to_dt'])); ?>
                                                    </td>
                                                    <td>
                                                        <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                                     view
                                                    </button> -->
                                                        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal_<?php echo $row['id'] ?>">view</a>
                                                        <!-- The Modal -->
                                                        <div class="modal" id="myModal_<?php echo $row['id'] ?>">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content" style="width: 180%; margin-left:-20%" >

                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">View Application</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <!-- Modal body -->
                                                                    <div class="modal-body">
                                                                        <div id="application">
                                                                        <img src="leave_doc/application/<?php echo $row['application'] ?>" class="img-fluid" alt="Modal Image">
                                                                       
                                                                        </div>
                                                                   

                                                                    </iframe>
                                                                    </div>

                                                                    <!-- Modal footer -->
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal">Close</button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </td>
                                                    <td>
                                                        <?php 
                                                      
                                                          switch ($row['status']) {
                                                            case '2':
                                                               echo 'Approved';
                                                                break;
                                                            case '3':
                                                                echo 'Rejected';
                                                                    break;
                                                            default:
                                                                # code...
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



    <?php include('common_script.php') ?>

</body>

</html>

<script>


    

</script>