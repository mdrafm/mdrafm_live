<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include('header_link.php');

    include('../config.php');
    include 'database.php';
    ?>
    <!-- <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.4/dist/bootstrap-table.min.css"> -->
    <style>
        .card label {
            font-size: 1rem;
        }
    </style>
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
            <div class="row" style="margin-top:50px">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Select MCTP Programe</h4>
                            </div>
                            <div class="card-body">
                                <form id="frm_feedback">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>Training Type</strong></label>
                                                <select class="custom-select mr-sm-2" name="traning_type"
                                                    id="traning_type">
                                                    <option selected>Select Type</option>
                                                    <?php 
                                                                    $db = new Database();
                                                                    $count = 0;
                                                                    $db->select('tbl_training_type',"*",null,null,null,null);
                                                                    // print_r( $db->getResult());
                                                                    foreach($db->getResult() as $row){
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
                                                <select class="custom-select mr-sm-2" name="program_id" id="program_id">
                                                    <option selected>Select Program</option>

                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                  
                                </form>
                               
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h4 class="card-title">Send request to trainee for acceptance MCTP trainning</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="term3" class=" table table-responsive table-striped table-hover" style="width:100%;margin:0px auto">
                                    <table class="first_list table">
                                        <thead class="" style="background: #315682;color:#fff;font-size: 11px;">
                                            <th><input type="checkbox" id="checkAll" name="checkAll" value=""></th>
                                            <th>Sl No</th>
                                            <th>Name</th>
                                            <th>Office address</th>
                                            <th>Phone no</th>
                                            <th>Email</th>
                                            <th>DOJ</th>
                                            <th>Retired Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $db = new Database();
                                            $db->select('tbl_ofs_master', "*", null, "mctp_trainning_status = 0", "id", null);
                                            $res_set = $db->getResult();
                                            $new_array = array();
                                            foreach ($res_set as $row) {
                                                $retired_date = date('Y-m-d', strtotime($row['dob'] . ' + 60 years'));
                                                $curr_date = date('Y-m-d');
                                                $remaining_years = substr($retired_date, 0, 4) - substr($curr_date, 0, 4);
                                                $job_period = substr($curr_date, 0, 4) - substr($row['doj'], 0, 4);
                                                if (($remaining_years > 3) && ($job_period > 6 and $job_period < 13)) {
                                                    array_push($new_array, $row);
                                                }
                                            }
                                            $array_selected = array_slice($new_array, 0, 30);
                                            $array_awaited = array_slice($new_array, 30, 10);

                                            if (!empty($array_selected)) {
                                                $cnt = 1;
                                                foreach ($array_selected as $row1) {
                                                    // print_r($row1);
                                            ?>
                                                    <tr>
                                                        <td><input type="checkbox" id="chk" name="chk" class="check_all" value="1"></td>
                                                        <td><?php echo $cnt++; ?></td>
                                                        <td><?= isset($row1['name']) ? $row1['name'] : '' ?> </td>

                                                        <td><?= isset($row1['office_name']) ? $row1['office_name'] : '' ?> </td>
                                                        <td><?= isset($row1['mobile']) ? $row1['mobile'] : '' ?></td>
                                                        <td><?= isset($row1['email']) ? $row1['email'] : '' ?></td>
                                                        <td><?= isset($row1['doj']) ? $row1['doj'] : '' ?></td>
                                                        <td><?= isset($row1['dob']) ? date('Y-m-d', strtotime($row1['dob'] . ' + 60 years')) : '' ?></td>
                                                        <td>
                                                            <?php  
                                                             //  isset($row1['mail_id']) ? $row1['mail_id'] : '' 
                                                               switch ($row1['mctp_accept_ststus']) {
                                                                case '1':
                                                                   echo 'Pending';
                                                                    break;
                                                                case '2':
                                                                    echo 'Accept';
                                                                        break;
                                                                case '3':
                                                                    echo 'Rejected';
                                                                        break;
                                                                
                                                                default:
                                                                    # code...mctp_accept_ststus
                                                                    break;
                                                               }
                                                            ?>
                                                            
                                                        </td>

                                                                                                                    <td>
                                                            <?php
                                                            if($row1['mctp_accept_ststus'] == 3){
                                                                ?>
                                                                <input type="button" class="btn btn-sm" style="background:#3292a2" id="msg_<?php echo $row1['id']; ?>" onclick="view_msg('<?php echo $row1['reject_reason']; ?>');" value="View" />
                                                                <?php
                                                            }

                                                            ?>
                                                            <input type="hidden" name="ofs_id" class="ofs_id" value="<?php echo $row1['id']; ?>">
                                                            <a href="#EditModal_<?php echo $row1['id']; ?>" data-toggle="modal" style="color:#4164b3"><i class="far fa-edit " style="font-size:1.5rem;"></i></a>
                                                            &nbsp;
                                                            <div id="EditModal_<?php echo $row1['id']; ?>" class="modal fade">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">

                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="m_title" style="text-align:center;">Employee Details</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form id="ofs_frm1_<?php echo $row1['id']; ?>">
                                                                                <div class="employee_dtl" style="line-height: 1.7rem;">
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between ">

                                                                                            <label for="">Name</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="name" class="form-control" value="<?php echo $row1['name'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Employee id </label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="emp_id" class="form-control" value="<?php echo $row1['emp_id'] ?>">

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Gpf No</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="gpf_no" class="form-control" value="<?php echo $row1['gpf_no'] ?>">

                                                                                            </div>


                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Acct Type </label>
                                                                                            <div class="col-md-8">
                                                                                                <select class="custom-select mr-sm-2" name="acct_type" style="height: calc(1em + 0.75rem + 2px);padding:0px">

                                                                                                    <option>Select acct_type </option>
                                                                                                    <?php


                                                                                                    $db->select('tbl_acct_type_master', "id,name", null, 'status =1', null, null);
                                                                                                    // print_r( $db->getResult());
                                                                                                    foreach ($db->getResult() as $row6) {
                                                                                                        //print_r($row);

                                                                                                    ?>
                                                                                                        <option value="<?php echo $row6['id'] ?>" <?php echo ($row1['acct_type'] == $row6['id']) ? 'selected' : '' ?>>
                                                                                                            <?php echo $row6['name'] ?>
                                                                                                        </option>

                                                                                                    <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>


                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Deploy Type </label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="deploy_type" class="form-control" value="<?php echo $row1['deploy_type'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Religion</label>
                                                                                            <div class="col-md-8">
                                                                                                <select class="custom-select mr-sm-2" name="religion_id" style="height: calc(1em + 0.75rem + 2px);padding:0px">

                                                                                                    <option>Select acct_type </option>
                                                                                                    <?php


                                                                                                    $db->select('tbl_religion_master', "id,religion", null, 'status =1', null, null);
                                                                                                    // print_r( $db->getResult());
                                                                                                    foreach ($db->getResult() as $row7) {
                                                                                                        //print_r($row);

                                                                                                    ?>
                                                                                                        <option value="<?php echo $row7['id'] ?>" <?php echo ($row1['religion_id'] == $row7['id']) ? 'selected' : '' ?>>
                                                                                                            <?php echo $row7['religion'] ?>
                                                                                                        </option>

                                                                                                    <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>


                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Gender</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="gender" class="form-control" value="<?php echo ($row1['gender'] == 1) ? 'Male' : 'Femail'; ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Cader</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="cader" class="form-control" value="<?php echo $row1['cader'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Phone no</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="mobile" class="form-control" value="<?php echo $row1['mobile'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Email</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="email" class="form-control" value="<?php echo $row1['email'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Date of Birth</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="date" name="dob" class="form-control" value="<?php echo $row1['dob'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Date of Joining</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="date" name="doj" class="form-control" value="<?php echo $row1['doj'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Date of Retirement</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="date" name="dor" class="form-control" value="<?php echo $row1['dor'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Grade</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="grade" class="form-control" value="<?php echo $row1['grade'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Home Town</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="home_town" class="form-control" value="<?php echo $row1['home_town'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Category</label>
                                                                                            <div class="col-md-8">
                                                                                                <select class="custom-select mr-sm-2" name="category_id" style="height: calc(1em + 0.75rem + 2px);padding:0px">

                                                                                                    <option>Select Category </option>
                                                                                                    <?php


                                                                                                    $db->select('tbl_category_master', "id,category", null, 'status =1', null, null);
                                                                                                    // print_r( $db->getResult());
                                                                                                    foreach ($db->getResult() as $row8) {
                                                                                                        //print_r($row);

                                                                                                    ?>
                                                                                                        <option value="<?php echo $row8['id'] ?>" <?php echo ($row1['category_id'] == $row8['id']) ? 'selected' : '' ?>>
                                                                                                            <?php echo $row8['category'] ?>
                                                                                                        </option>

                                                                                                    <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>


                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Office Name</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="office_name" class="form-control" value="<?php echo $row1['office_name'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Office Address</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="office_address" class="form-control" value="<?php echo $row1['office_address'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Designation</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="designation" class="form-control" value="<?php echo $row1['designation'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Last year Passing</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="last_year_passing" class="form-control" value="<?php echo $row1['last_year_passing'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Qualification</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="qualification" class="form-control" value="<?php echo $row1['qualification'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Degree</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="degree" class="form-control" value="<?php echo $row1['degree'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                      

                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button class="btn btn-success" onclick="updateEmployee(<?php echo $row1['id'] ?>,'ofs_frm1')">Update</button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- <input type="button" class="btn " style="background:#3292a2" name="send" onclick="mail_compose();" value="Send Mail" /> -->
                                                        </td>

                                                    </tr>

                                            <?php
                                                }
                                            }

                                            ?>

                                        </tbody>
                                    </table>
                                    <input type="button" class="btn btn-primary" value="Send Mail" onclick="show_email_div('first_list')">

                                    <table class="awitingTbl2 table">
                                        <h6>Waiting List</h6>
                                        <thead class="" style="background:rgb(4 71 147);color:#fff;font-size: 11px;">
                                            <th><input type="checkbox" id="chkall" name="chkall" value=""></th>
                                            <th>Sl No</th>
                                            <th>Name</th>
                                            <th>Office address</th>
                                            <th>Phone no</th>
                                            <th>Email</th>
                                            <th>DOJ</th>
                                            <th>Retired Date</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </thead>
                                        <tbody>


                                            <?php
                                            $count = 1;
                                            // echo '<pre>';print_r($array_awaited);echo '</pre>';
                                            foreach ($array_awaited as $row) {

                                            ?>
                                                <tr>
                                                    <td><input type="checkbox" id="chk" name="chk" class="chk_all" value="1"></td>
                                                    <td><?php echo $count++; ?></td>
                                                    <td><?= isset($row['name']) ? $row['name'] : '' ?> </td>

                                                        <td><?= isset($row['office_name']) ? $row['office_name'] : '' ?> </td>
                                                        <td><?= isset($row['mobile']) ? $row['mobile'] : '' ?></td>
                                                        <td><?= isset($row['email']) ? $row['email'] : '' ?></td>
                                                        <td><?= isset($row['doj']) ? $row['doj'] : '' ?></td>
                                                        <td><?= isset($row['dob']) ? date('Y-m-d', strtotime($row['dob'] . ' + 60 years')) : '' ?></td>
                                                        <td>
                                                            <?php  
                                                             //  isset($row1['mail_id']) ? $row1['mail_id'] : '' 
                                                               switch ($row['mctp_accept_ststus']) {
                                                                case '1':
                                                                   echo 'Pending';
                                                                    break;
                                                                case '2':
                                                                    echo 'Accept';
                                                                        break;
                                                                case '3':
                                                                    echo 'Rejected';
                                                                        break;
                                                                
                                                                default:
                                                                    # code...mctp_accept_ststus
                                                                    break;
                                                               }
                                                            ?>
                                                            
                                                        </td>

                                                                                                                    <td>
                                                            <?php
                                                            if($row['mctp_accept_ststus'] == 3){
                                                                ?>
                                                                <input type="button" class="btn btn-sm" style="background:#3292a2" id="msg_<?php echo $row1['id']; ?>" onclick="view_msg('<?php echo $row1['reject_reason']; ?>');" value="View" />
                                                                <?php
                                                            }

                                                            ?>
                                                            <input type="hidden" name="ofs_id" class="ofs_id" value="<?php echo $row['id']; ?>">
                                                            <a href="#EditModal_<?php echo $row['id']; ?>" data-toggle="modal" style="color:#4164b3"><i class="far fa-edit " style="font-size:1.5rem;"></i></a>
                                                            &nbsp;
                                                            <div id="EditModal_<?php echo $row['id']; ?>" class="modal fade">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">

                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="m_title" style="text-align:center;">Employee Details</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form id="ofs_frm1_<?php echo $row['id']; ?>">
                                                                                <div class="employee_dtl" style="line-height: 1.7rem;">
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between ">

                                                                                            <label for="">Name</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="name" class="form-control" value="<?php echo $row['name'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Employee id </label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="emp_id" class="form-control" value="<?php echo $row['emp_id'] ?>">

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Gpf No</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="gpf_no" class="form-control" value="<?php echo $row['gpf_no'] ?>">

                                                                                            </div>


                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Acct Type </label>
                                                                                            <div class="col-md-8">
                                                                                                <select class="custom-select mr-sm-2" name="acct_type" style="height: calc(1em + 0.75rem + 2px);padding:0px">

                                                                                                    <option>Select acct_type </option>
                                                                                                    <?php


                                                                                                    $db->select('tbl_acct_type_master', "id,name", null, 'status =1', null, null);
                                                                                                    // print_r( $db->getResult());
                                                                                                    foreach ($db->getResult() as $row6) {
                                                                                                        //print_r($row);

                                                                                                    ?>
                                                                                                        <option value="<?php echo $row6['id'] ?>" <?php echo ($row1['acct_type'] == $row6['id']) ? 'selected' : '' ?>>
                                                                                                            <?php echo $row6['name'] ?>
                                                                                                        </option>

                                                                                                    <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>


                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Deploy Type </label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="deploy_type" class="form-control" value="<?php echo $row1['deploy_type'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Religion</label>
                                                                                            <div class="col-md-8">
                                                                                                <select class="custom-select mr-sm-2" name="religion_id" style="height: calc(1em + 0.75rem + 2px);padding:0px">

                                                                                                    <option>Select acct_type </option>
                                                                                                    <?php


                                                                                                    $db->select('tbl_religion_master', "id,religion", null, 'status =1', null, null);
                                                                                                    // print_r( $db->getResult());
                                                                                                    foreach ($db->getResult() as $row7) {
                                                                                                        //print_r($row);

                                                                                                    ?>
                                                                                                        <option value="<?php echo $row7['id'] ?>" <?php echo ($row1['religion_id'] == $row7['id']) ? 'selected' : '' ?>>
                                                                                                            <?php echo $row7['religion'] ?>
                                                                                                        </option>

                                                                                                    <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>


                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Gender</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="gender" class="form-control" value="<?php echo ($row6['gender'] == 1) ? 'Male' : 'Femail'; ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Cader</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="cader" class="form-control" value="<?php echo $row6['cader'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Phone no</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="mobile" class="form-control" value="<?php echo $row['mobile'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Email</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="email" class="form-control" value="<?php echo $row['email'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Date of Birth</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="date" name="dob" class="form-control" value="<?php echo $row['dob'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Date of Joining</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="date" name="doj" class="form-control" value="<?php echo $row['doj'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Date of Retirement</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="date" name="dor" class="form-control" value="<?php echo $row['dor'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Grade</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="grade" class="form-control" value="<?php echo $row['grade'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Home Town</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="home_town" class="form-control" value="<?php echo $row['home_town'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Category</label>
                                                                                            <div class="col-md-8">
                                                                                                <select class="custom-select mr-sm-2" name="category_id" style="height: calc(1em + 0.75rem + 2px);padding:0px">

                                                                                                    <option>Select Category </option>
                                                                                                    <?php


                                                                                                    $db->select('tbl_category_master', "id,category", null, 'status =1', null, null);
                                                                                                    // print_r( $db->getResult());
                                                                                                    foreach ($db->getResult() as $row8) {
                                                                                                        //print_r($row);

                                                                                                    ?>
                                                                                                        <option value="<?php echo $row8['id'] ?>" <?php echo ($row['category_id'] == $row8['id']) ? 'selected' : '' ?>>
                                                                                                            <?php echo $row8['category'] ?>
                                                                                                        </option>

                                                                                                    <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>


                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Office Name</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="office_name" class="form-control" value="<?php echo $row['office_name'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Office Address</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="office_address" class="form-control" value="<?php echo $row['office_address'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Designation</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="designation" class="form-control" value="<?php echo $row1['designation'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Last year Passing</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="last_year_passing" class="form-control" value="<?php echo $row['last_year_passing'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Qualification</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="qualification" class="form-control" value="<?php echo $row['qualification'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-6 d-flex justify-content-between">
                                                                                            <label for="">Degree</label>
                                                                                            <div class="col-md-8">
                                                                                                <input type="text" name="degree" class="form-control" value="<?php echo $row['degree'] ?>">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                      

                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button class="btn btn-success" onclick="updateEmployee(<?php echo $row['id'] ?>,'ofs_frm1')">Update</button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- <input type="button" class="btn " style="background:#3292a2" name="send" onclick="mail_compose();" value="Send Mail" /> -->
                                                        </td>

                                                </tr>
                                            <?php  }
                                            ?>
                                           
                                        </tbody>
                                    </table>

                                    <input type="button" class="btn btn-primary" value="Send Mail" onclick="show_email_div('awitingTbl2')">
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

    <!-- edit Modal HTML -->
    <div id="empDetailModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="m_title" style="text-align:center;">Employee Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="empDetails">


                </div>
                <div class="modal-footer" id="detaisFooter">
                </div>

            </div>
        </div>
    </div>
        <!-- end edit  Modal HTML -->

        <!-- msgBox Modal Modal HTML -->
        <div id="emailModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content" style="width:130%; margin:120px -60px">
                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title" id="m_title" style="text-align:center;">Email to accept MCTP Program </h5>
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

                            <div class="loader">
                                <img src="assets/img/loader.gif" alt="Loading" style="width: 300px;height: 90px;" />
                            </div>
                        </div>
                        <div class="modal-footer" id="mailbtn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- msgBox Modal Modal HTML -->

        <div id="rejectModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content" style="width:130%; margin:120px -60px">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="m_title" style="text-align:center;">Reject Reasone </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                <label style="margin-top: 2rem;"> Reject Reasone : </label>
                                </div>
                                <div class="col-md-8">
                                <textarea class="w-100" rows="5"  name="reason" id="reason" ></textarea>
                                </div>
                            </div>
                          
                            
                        </div>
                       
                    </div>
                    <div class="modal-footer" id="rejectbtn">
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
        <?php include('common_script.php') ?>

</body>

</html>
<script src="../ckeditor/ckeditor.js"> </script>
<!-- <script src="https://unpkg.com/bootstrap-table@1.22.4/dist/bootstrap-table.min.js"></script> -->
<script type="text/javascript">
    //$('#ofs_table').DataTable();
    //let table = new DataTable('#ofs_table');
    $(document).ready(function() {
        var mainurl = "getMctpData.php";
        $('#ofs_table').DataTable({
            "processing": true,
            "serverSide": true,
            scrollY: true,
            "ajax": {
                url: mainurl, // json
                type: "post", // type of method
                data: {
                    action: 'fetch'
                },

                "error": function(xhr, errorType, thrownError) {
                    console.log("AJAX error: " + errorType);
                    console.log(thrownError);
                }
            }
        });
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
            $('#program_id').html(res);

        }
    })
})

    $("#checkAll").click(function() {
        // alert(123);
        $('.first_list input:checkbox').not(this).prop('checked', this.checked);
    });

    $('input[type="checkbox"]').on('change', function() {
        var checkedValue = $(this).prop('checked');
        // uncheck sibling checkboxes (checkboxes on the same row)
        $(this).closest('tr').find('input[type="checkbox"]').each(function() {
            $(this).prop('checked', false);
        });
        $(this).prop("checked", checkedValue);

    });
function view_msg(msg){
  $('#reason').val(msg);
  $('#rejectModal').modal('show');

}
    function viewOfsList(ofs_id) {
        $.ajax({
            type: "POST",
            url: "getMctpData.php",
            // dataType:'json',
            data: {
                'action': 'fetchOfsList',
                'table': 'tbl_ofs_master',
                'id': ofs_id
            },
            success: function(res) {
                console.log(res);
                $('#empDetails').html(res);
                $('#empDetailModal').modal('show');
            }
        })
    }

    function editOfsList(ofs_id) {
        $.ajax({
            type: "POST",
            url: "getMctpData.php",
            // dataType:'json',
            data: {
                'action': 'edtOfsList',
                'table': 'tbl_ofs_master',
                'id': ofs_id
            },
            success: function(res) {
                console.log(res);
                $('#empDetails').html(res);
                $('#detaisFooter').html(`<button class="btn btn-success" onclick="updateEmployee(${ofs_id},'ofs_frm')">Update</button>`)
                $('#empDetailModal').modal('show');
            }
        })
    }



    function updateEmployee(id, frm) {


        var update_id = id;
        console.log(frm);
        $.ajax({
            type: "POST",
            url: "ajax_master.php",

            data: $(`#${frm}_${id}`).serialize() + '&' + $.param({
                'action': 'add',
                'table': 'tbl_ofs_master',
                'update_id': update_id
            }),
            success: function(res) {
                console.log(res);
                let elm = res.split('#');
                if (elm[0] == "success") {
                    sessionStorage.message = 'update' + ' ' + elm[1];
                    sessionStorage.type = "success";
                    location.reload();
                }
            }
        })

    }

    function show_email_div(tbl_id) {

        $('#emailModal').modal('show');
        $('#mailbtn').html(`<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="button" class="btn btn-primary" value="Send" onclick="handle_mail('${tbl_id}')">`)

    }

    async function handle_mail(tbl_id) {

      
        TableData = storeTblValues(tbl_id);
        console.log(TableData);
        // TableData = JSON.stringify(TableData);
        const emailStatus = TableData.map(async data => {
            // console.log(data);
            if (data.send == 1) {
                console.log(data.email);
                const Status = await sendEmail(data.email, data.phone, data.ofs_id, data.name);

                return Status;
            }


        })


        const results = await Promise.all(emailStatus);

        console.log(results);
    }

    async function sendEmail(email, phone, ofs_id, name) {

        let subject = $('#subject').val();
        let email_body = $('#email_body').val();
        let trng_type = $('#traning_type').val();
        let program_id = $('#program_id').val();

        let args = {
            'action': 'mctp_approval',
            subject,
            email_body,
            email,
            phone,
            ofs_id,
            name,
            trng_type,
            program_id
        }
        let url = 'action_controller.php';

        const stuff = await doAjax(url, args);
        console.log(stuff);
        return stuff;
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



    function storeTblValues(tbl_id) {
        var TableData = new Array();
        $(`.${tbl_id} tr`).each(function(row, tr) {

            TableData[row] = {

                "ofs_id": $(tr).find('.ofs_id').val(),
                "name": $(tr).find('td:eq(2)').text(),
                "email": $(tr).find('td:eq(5)').text(),
                "phone": $(tr).find('td:eq(4)').text(),
                "send": ($(tr).find('input[type="checkbox"]:checked').val() == 1) ? "1" : "0",

            }
        });
        TableData.shift(); // first row will be empty - so remove
        return TableData;
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