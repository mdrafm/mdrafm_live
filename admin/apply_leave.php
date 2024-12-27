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


                <div class="row" style="margin-top:20px">
                    <div class="col-md-12">
                         
                        <div class="card">
                           <div class="card-header">Leave Summery</div>
                            <div class="card-body">
                            <div class="statusMsg"></div>
                              <div class="row">
                                <div class="col-md-6">
                                     <table class="table table-responsive table-striped table-hover" >
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Leave Type</th>
                                            <th>Total Leave</th>
                                            <th>Leave Taken</th>
                                            <th>Remaining Leave </th>
                                    
                                        </tr>
                                        <?php
                                        //print_r($_SESSION);
                                        
                                        $sql = "SELECT l.type_name,m.leave_type_id,m.total_leave FROM `tbl_leave_master` m JOIN `tbl_leave_type_master` l ON m.leave_type_id = l.id";
                                        $db->select_sql($sql);
                                        $res = $db->getResult();
                                        $cnt = 0;
                                        foreach ($res as $row) {

                                            $cnt++;
                                            $total_leave_sql = "SELECT COUNT(id) as taken_leave FROM `tbl_leave` WHERE user_id = '" . $_SESSION['user_id'] . "' AND status = 2 AND leave_type_id =" . $row['leave_type_id'];
                                            $db->select_sql($total_leave_sql);
                                            $taken_leave_res = $db->getResult($total_leave_sql);
                                            // print_r($taken_leave_res);
                                            if (count($taken_leave_res) == 0) {
                                                $total_leave = 0;
                                            } else {
                                                $total_leave = $taken_leave_res[0]['taken_leave'];
                                            }
                                            //print_r($taken_leave_res);
                                            $remaining_leave = $row['total_leave'] - $total_leave;
                                            ?>
                                                    <tr>
                                                        <td><?php echo $cnt; ?></td>
                                                        <td><?php echo $row['type_name']; ?></td>
                                                        <td><?php echo $row['total_leave']; ?></td>
                                                        <td><?php echo $total_leave; ?></td>
                                                        <td><?php echo $remaining_leave; ?></td>
                                                    </tr>
                                                <?php
                                            //exit;
                                        }

                                        ?>
                                        
                                       
                                     </table>
                                </div>

                                <div class="col-md-6">
                                    <p style="font-size: 1.2rem;font-weight: 600;" >Name : <span><?php echo $_SESSION["name"] ?></span> </p>
                                    <p style="font-size: 1.2rem;font-weight: 600;">Phone No : <span><?php echo $_SESSION["username"] ?></span> </p>
                                    <input type="button" class="btn btn-success" id="addLeave" value="Apply Leave" style="float: right;">
                                    
                                </div>
                              </div>
                              
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row" id="apply_leave_wrap" style="margin-top:20px;display:none">
                    <div class="col-md-12">
                         
                        <div class="card">
                        <div class="card-header" style="background-color: #316ba5;padding:10px"> <span style="color:#fff">Apply For Leave </span> </div>
                            <div class="card-body">
                                <div class="notice" style="background: #ece9de;padding: 10px">
                                    <p style="color: #720b0b;font-size: 1rem;font-family: cursive;" ><i class="fas fa-hand-point-right"></i> &nbsp;&nbsp;If leave due to medical reason then attach medical certificate mandatory.</p>
                                    <p style="color: #720b0b;font-size: 1rem;font-family: cursive;"><i class="fas fa-hand-point-right"></i> &nbsp;&nbsp;On applying quarantine leave medical certificate or  medical report mandatory. </p>
                                </div>
                            <div id="leave_frm">
                                  <form method="post" id="leaveFrm" enctype="multipart/form-data">
                                             <div class="row">
                                                <div class="col-md-1">
                                                    <label for=""><i class="fas fa-arrow-right"></i></label>
                                                </div>
                                                <div class="col-md-7">
                                                <label for="">Applying leave to</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="leave_apply_to" id="leave_apply_to" value="Director, MDRAFM (through Course Director)">
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-1">
                                                    <label for=""><i class="fas fa-arrow-right"></i></label>
                                                </div>
                                                <div class="col-md-7">
                                                <label for="">Type of Leave</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control" name="leave_type_id" id="leave_type_id">
                                                        <option value="0">Select Leave Type</option>
                                                        <option value="1">EL</option>
                                                        <option value="2">CL</option>
                                                        <option value="7">Women Special CL</option>
                                                        <option value="3">Head Quarter Leave</option>
                                                        <option value="4">Maternity Leave</option>
                                                        <option value="5">Paternity Leave</option>
                                                        <option value="6">Quarantine Leave</option>

                                                    </select>
                                                </div>
                                             </div>
                                             <div class="row" >
                                                <div class="col-md-1">
                                                    <label for=""><i class="fas fa-arrow-right"></i></label>
                                                </div>
                                                <div class="col-md-7">
                                                <label for="">Duration of Leave you want to avail</label>
                                                </div>
                                                <div class="col-md-2">
                                                   <label for="">From Date</label>
                                                    <input type="date" class="form-control" name="from_dt" id="from_dt" >
                                                </div>
                                                <div class="col-md-2">
                                                  <label for="">To Date</label>
                                                    <input type="date" class="form-control" name="to_dt" id="to_dt" > <br>
                                                    <p id="noOfDays" class="text-danger" ></p>
                                                </div>
                                                
                                             </div>
                                             <div id="chk_wrap">
                                             <div class="row" id="halfDay" style="display:none">
                                                <div class="col-md-1">
                                                    <label for=""><i class="fas fa-arrow-right"></i></label>
                                                </div>
                                                <div class="col-md-7">
                                                <label for="">If half day leave</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control" name="half_day_leave" id="half_day_leave">
                                                        <option value="0">Select half_day_leave</option>
                                                        <option value="1">Forenoon</option>
                                                        <option value="2">Afternoon</option>
                                                    </select>
                                                </div>
                                             </div>
                                             <div class="row" id="maternity" style="display:none">
                                                <div class="col-md-1">
                                                    <label for=""><i class="fas fa-arrow-right"></i></label>
                                                </div>
                                                <div class="col-md-7">
                                                <label for="">Surviving children if(Maternity/Paternity) Leave <br> 
                                                 <span style= "font-size: 14px;color: #6a4949;">(more than 2 children can't apply)</span></label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="no_of_child" id="no_of_child" >
                                                </div>
                                             </div>
                                             
                                             <div class="row">
                                                <div class="col-md-1">
                                                    <label for=""><i class="fas fa-arrow-right"></i></label>
                                                </div>
                                                <div class="col-md-7">
                                                <label for="">Public Holidays prior to leave period to be applied as Prefix</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" class="form-check-input" name="holidays_prefix" id="holidays_prefix" value="1" >
                                                </div>
                                             </div>
                                             <div class="row hp_div" style="display:none">
                                                <div class="col-md-1">
                                                    <label for=""></label>
                                                </div>
                                                <div class="col-md-7">
                                                
                                                </div>
                                                <div class="col-md-2">
                                                   <label for="">From Date</label>
                                                    <input type="date" class="form-control" name="hp_from_dt" id="hp_from_dt" >
                                                </div>
                                                <div class="col-md-2">
                                                  <label for="">To Date</label>
                                                    <input type="date" class="form-control" name="hp_to_dt" id="hp_to_dt" >
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-1">
                                                    <label for=""><i class="fas fa-arrow-right"></i></label>
                                                </div>
                                                <div class="col-md-7">
                                                <label for="">Public Holidays after leave period to be applied as Suffix</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" class="form-check-input" name="holidays_suffix" id="holidays_suffix" value="1" >
                                                </div>
                                             </div>
                                             <div class="row hs_div" style="display:none">
                                                <div class="col-md-1">
                                                    <label for=""></label>
                                                </div>
                                                <div class="col-md-7">
                                                
                                                </div>
                                                <div class="col-md-2">
                                                   <label for="">From Date</label>
                                                    <input type="date" class="form-control" name="hs_from_dt" id="hs_from_dt" >
                                                </div>
                                                <div class="col-md-2">
                                                  <label for="">To Date</label>
                                                    <input type="date" class="form-control" name="hs_to_dt" id="hs_to_dt" >
                                                </div>
                                                
                                             </div>
                                             <div class="row">
                                                <div class="col-md-1">
                                                    <label for=""><i class="fas fa-arrow-right"></i></label>
                                                </div>
                                                <div class="col-md-7">
                                                <label for="">Do you Submit Medical Report along with this leave application?</label>
                                                </div>
                                                <div class="col-md-1">
                                                      <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="report" id="medical_report1" value="1">
                                                        <label class="form-check-label" for="exampleRadios1">
                                                            Yes
                                                        </label>
                                                        </div>
                                                </div>
                                                <div class="col-md-1">
                                                        <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="report" id="medical_report2" value="2" checked>
                                                        <label class="form-check-label" for="exampleRadios2">
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                             </div>
                                             <div class="row medical_div" style="display:none">
                                                <div class="col-md-1">
                                                    <label for=""></label>
                                                </div>
                                                <div class="col-md-7">
                                                
                                                </div>
                                                <div class="col-md-3">
                                                   <label for="">Medical Report</label>
                                                    <input type="file" class="form-control file" name="medical_report" id="medical_report" >
                                                </div>
                                                
                                             </div>
                                             <div class="row">
                                                <div class="col-md-1">
                                                    <label for=""><i class="fas fa-arrow-right"></i></label>
                                                </div>
                                                <div class="col-md-7">
                                                <label for="">Do you request for Head Quarter Leave Permission with this leave application?</label>
                                                </div>
                                                <div class="col-md-1">
                                                      <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="hq_leave" id="hq_leave1" value="1">
                                                        <label class="form-check-label" for="hq_leave1">
                                                            Yes
                                                        </label>
                                                        </div>
                                                </div>
                                                <div class="col-md-1">
                                                        <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="hq_leave" id="hq_leave2" value="2" checked>
                                                        <label class="form-check-label" for="hq_leave2">
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                             </div>
                                             </div>
                                             <div class="row contact_div" style="display:none">
                                                <div class="col-md-1">
                                                    <label for=""></label>
                                                </div>
                                                <div class="col-md-7">
                                                <label for="">Contact Address While On Leave?</label>
                                                </div>
                                                <div class="col-md-3">
                                                  <textarea name="contact" id="contact" cols="40" rows="5"></textarea>
                                                    
                                                </div>
                                                
                                             </div>
                                             
                                             <div class="row">
                                                <div class="col-md-1">
                                                    <label for=""><i class="fas fa-arrow-right"></i></label>
                                                </div>
                                                <div class="col-md-7">
                                                <label for="">Reason for Leave</label>
                                                </div>
                                                <div class="col-md-3">
                                                  <textarea name="leave_reason" id="leave_reason" cols="40" rows="5"></textarea>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-1">
                                                    <label for=""><i class="fas fa-arrow-right"></i></label>
                                                </div>
                                                <div class="col-md-7">
                                                <label for="">Attach Document</label>
                                                </div>
                                                <div class="col-md-3 application_div" >
                                                    <input type="file" class="form-control file" name="application" id="application" >
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-1">
                                                    <label for=""></label>
                                                </div>
                                                <div class="col-md-7">
                                                 <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" >
                                                 <input type="hidden" name="program_id" value="<?php echo $prog_id; ?>" >
                                                 <input type="hidden" name="trng_type" value="<?php echo $trng_type; ?>" >
                                                 <input type="hidden" name="update_id" id="update_id" value="" >
                                                 <input type="hidden" name="action" value="add_leave" >
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="submit" name="submit" class="btn btn-success submitBtn" value="Apply" >
                                                    
                                                </div>
                                             </div>
                                  </form>
                              </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-12">
                         
                        <div class="card">
                        <div class="card-header" style="background-color: #316ba5;padding:10px"> <span style="color:#fff">Leave Summery Status </span> </div>
                            <div class="card-body">
                            <div id="leave_frm">
                                  <div class="table table-responsive table-striped table-hover">
                                      <table class="table  ">
                                        <thead style="background: #315682;color:#fff;font-size: 11px;">
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Leave type</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php
                                            $sql = "SELECT * FROM `tbl_leave` WHERE user_id ='" . $_SESSION['user_id'] . "'";
                                            $db->select_sql($sql);
                                            $res = $db->getResult();
                                            $cnt = 0;
                                            foreach ($res as $row2) {
                                                $cnt++;
                                                ?>
                                                            <tr>
                                                              <td><?php echo $cnt++ ?></td>
                                                              <td>
                                                                <?php
                                                                switch ($row2['leave_type_id']) {
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
                                                              <td><?php echo $row2['from_dt']; ?></td>
                                                              <td><?php echo $row2['to_dt']; ?></td>
                                                              <td>
                                                                <?php
                                                                //echo ($row2['status'] == 1)?'Pending':'Approved'; 
                                                                switch ($row2['status']) {
                                                                    case '1':
                                                                        echo 'Pending';
                                                                        break;
                                                                    case '2':
                                                                        echo 'Approve';
                                                                        break;
                                                                    case '3':
                                                                        echo 'Reject';
                                                                        break;
                                                                    default:
                                                                        # code...
                                                                        break;
                                                                }
                                                                ?>
                                                            </td>
                                                              <td><?php
                                                                if ($row2['status'] == 1) {
                                                                    ?>
                                                                      <a href="#leave_frm" class="text-info editLeave" data-leaveId="<?php echo $row2['id'] ?>"><i class="fas fa-edit"></i></a>
                                                                      <a href="#" class="text-info deleteLeave" 
                                                                      data-leaveId="<?php echo $row2['id'] ?>" data-medicalReport="<?php echo $row2['report'] ?>" data-application="<?php echo $row2['application'] ?>"><i class="fas fa-trash"></i></a>
                                                                    <?php
                                                                }
                                                              if ($row2['status'] == 3) {
                                                                  ?>
                                                                    <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal_<?php echo $row2['id'] ?>">view reason</a>

                                                                    <div class="modal" id="myModal_<?php echo $row2['id'] ?>">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 180%; margin-left:-20%" >

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Reject Reason</h4>
                <button type="button" class="close"
                    data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div id="application">
                    <textarea rows="5" cols="40" r ><?php echo $row2['reject_reason'] ?></textarea>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger"
                    data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
                                                        
                                                                  <?php
                                                              }
                                                              ?></td>
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

    </div>
<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 180%; margin-left:-20%" >

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close"
                    data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div id="application">
                    
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger"
                    data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
 
    <?php include('common_script.php') ?>

</body>

</html>
<script>
  $(document).ready(function(){
    
     $('.deleteLeave').on('click', function(){
        let leaveId = $(this).data("leaveid");
        let medicalreport = $(this).data("medicalreport");
        let application = $(this).data("application");
        console.log(medicalreport);
        console.log(application);

        if (confirm("Are you sure you want to delete this?")) {
            $.ajax({
                type: "POST",
                url: "ajax_leave.php",
                dataType: 'json',
                data: {

                    action: "delete_leave",
                    leaveId: leaveId,
                    medicalreport,medicalreport,
                    application,application

                },
                success: function (response) {
                    console.log(response);
                    $('.statusMsg').html('');
                    if (response.status == 1) {
                        $('.statusMsg').html('<p class="alert alert-success">' + response.message + '</p>');
                        location.reload();
                    } else {
                        $('.statusMsg').html('<p class="alert alert-danger">' + response.message + '</p>');
                    }


                }
            })
        }
        else {
            return false;
        }
     })
    $('.editLeave').on('click', function(){
       
        $('#apply_leave_wrap').show();
        let leaveId = $(this).data("leaveid");

                    $.ajax({
                        type: "POST",
                        url: "ajax_leave.php",
                        dataType: 'json',
                        data: {
                            action: "edit_leave",
                            leaveId: leaveId,
                        },
                        success: function (res) {
                            console.log(res);
                            $('#leave_apply_to').val(res.leave_apply_to);
                            $('#leave_type_id').val(res.leave_type_id);
                            $('#from_dt').val(res.from_dt);
                            $('#to_dt').val(res.to_dt);
                            $('#half_day_leave').val(res.half_day_leave);
                            $('#leave_reason').val(res.leave_reason);
                            if(res.holidays_prefix == 1){
                                $('#holidays_prefix').prop("checked", true);
                                $('#hp_from_dt').val(res.hp_from_dt);
                                $('#hp_to_dt').val(res.hp_to_dt);
                            }
                            if(res.holidays_suffix == 1){
                                $('#holidays_suffix').prop("checked", true);
                                $('#hs_from_dt').val(res.hs_from_dt);
                                $('#hs_to_dt').val(res.hs_to_dt);
                            }
                            if(res.report != ''){
                                $(`input[name = report][value =${res.medical_report}]`).prop("checked", true);
                                $('.medical_div').html('');
                                $('.medical_div').html(`<div class="col-md-8"></div><div class="col-md-4" > <a href="leave_doc/medical_report/${res.report}" target = "_blank" >view report</a> <button type="button" class="ml-4 deleteReportBtn" data-report-id="${res.id}" data-report="${res.report}" ><i class="fas fa-trash text-danger"></i></button> </div> `);
                                $('.medical_div').show();
                            }
                            if(res.contact != ''){
                                $(`input[name = hq_leave][value =${res.hq_leave}]`).prop("checked", true);
                                //$('.medical_div').html('');
                                $('#contact').val(res.contact);
                                $('.contact_div').show();
                            }

                            if(res.application != ''){
                               
                                $('.application_div').html('');
                                $('.application_div').html(`<div class="" > <a href="leave_doc/application/${res.application}" target = "_blank" >view application</a> <button type="button" class="ml-4 deleteApplicationBtn" data-application-id="${res.id}" data-application="${res.application}" ><i class="fas fa-trash text-danger"></i></button> </div> `);
                                //$('.medical_div').show();
                            }
                            
                            $('#update_id').val(res.id);
                            $('.submitBtn').val('update');
                            
                        }
                    })
       
     })

    // "
    // $('.deleteReport').on('click', function(){
    //       alert(123);
    //  })

    // Use event delegation to handle the click event on the button
    $('.medical_div').on('click', '.deleteReportBtn', function() {
        // Retrieve the report ID from the data attribute
        console.log(123);
        var reportId = $(this).data('report-id');
        var report = $(this).data('report');

        // Call the deleteReport function with the report ID
        deleteReport(reportId,report);
    });
    
    function deleteReport(id,report){
        //console.log(id);
      
        if (confirm("Are you sure you want to delete this?")) {
            $.ajax({
                type: "POST",
                url: "ajax_leave.php",
                dataType: 'json',
                data: {

                    action: "delete_medical_report",
                    leaveId: id,
                    report,report

                },
                success: function (response) {
                    console.log(response);
                    $('.statusMsg').html('');
                    if (response.status == 1) {
                        $('.statusMsg').html('<p class="alert alert-success">' + response.message + '</p>');
                        location.reload();
                    } else {
                        $('.statusMsg').html('<p class="alert alert-danger">' + response.message + '</p>');
                    }


                }
            })
        }
        else {
            return false;
        }
    }

    $('.application_div').on('click', '.deleteApplicationBtn', function() {
        // Retrieve the report ID from the data attribute
        console.log(123);
        var applicationId = $(this).data('application-id');
        var application = $(this).data('application');

        // Call the deleteReport function with the report ID
        deleteApplication(applicationId,application);
    });

    function deleteApplication(id,application){
        console.log(application);
      
        if (confirm("Are you sure you want to delete this?")) {
            $.ajax({
                type: "POST",
                url: "ajax_leave.php",
                dataType: 'json',
                data: {

                    action: "delete_application",
                    leaveId: id,
                    application:application

                },
                success: function (response) {
                    console.log(response);
                    $('.statusMsg').html('');
                    if (response.status == 1) {
                        $('.statusMsg').html('<p class="alert alert-success">' + response.message + '</p>');
                        location.reload();
                    } else {
                        $('.statusMsg').html('<p class="alert alert-danger">' + response.message + '</p>');
                    }


                }
            })
        }
        else {
            return false;
        }
    }

     $('#addLeave').on('click', function(){
        $('#apply_leave_wrap').toggle();
     })
     $('#holidays_prefix').change(function() {
       
        if(this.checked) {
           
            $('.hp_div').show();
        }else{
            $('.hp_div').hide();
        }
            
    });
    $('#holidays_suffix').change(function() {
       
       if(this.checked) {
          
           $('.hs_div').show();
       }else{
           $('.hs_div').hide();
       }
           
   });
   $('input[type=radio][name=report]').click(function(){
    if(this.value == 1) {
        $('.medical_div').show(); 
    }else{
        $('.medical_div').hide(); 
    }
   });
   
   $('input[type=radio][name=hq_leave]').click(function(){
    if(this.value == 1) {
        $('.contact_div').show(); 
    }else{
        $('.contact_div').hide(); 
    }
   });

   //upload form data
  
    //check file type

    $(".file").change(function() {
    var file = this.files[0];
    var fileType = file.type;
    var match = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
    if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))){
        alert('Sorry, only PDF, JPG, JPEG, & PNG files are allowed to upload.');
        $("#file").val('');
        return false;
    }
});

  })

  $("#leaveFrm").on('submit', function(e){
        e.preventDefault();
       // console.log(123);
       let leave_type_id = $('#leave_type_id').val();
       if (leave_type_id == 0) {
        alert('Please Select leave type ');
       }
        $.ajax({
            type: 'POST',
            url: 'ajax_leave.php',
            data: new FormData(this),
           dataType: 'json',
           contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                $('#leaveFrm').css("opacity",".5");
            },
            success: function(response){
                console.log(response);
                $('.statusMsg').html('');
                if(response.status == 1){
                    $('#leaveFrm')[0].reset();
                    $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                    location.reload();
                }else{
                    $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                }
                $('#leaveFrm').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
            }
        });
    });
    
    $('#to_dt').on('change',function(){ 
       let fromDt = $('#from_dt').val();
       let toDt = $('#to_dt').val();
       date1 = new Date(fromDt);  
         date2 = new Date(toDt);  
       var time_difference = date2.getTime() - date1.getTime();  
  
         //calculate days difference by dividing total milliseconds in a day  
         var days_difference = time_difference / (1000 * 60 * 60 * 24);  
         var totalDays = days_difference+1;

         $('#noOfDays').html(` Applying for ${totalDays} Days Leave`);
//console.log(totalDays);
    })
  $('#leave_type_id').on('change',function(){

      let leave_type_id = $('#leave_type_id').val();
    
      console.log(leave_type_id);
      if(leave_type_id == 3){
        $('#chk_wrap').css('display', 'none');
        $('#date-wrap').show();
        
      }else{
        $('#chk_wrap').show();
        $('#date-wrap').hide();
      }

      if(leave_type_id == 2){
        
        $('#halfDay').show();
        
      }else{
        $('#halfDay').hide();
       
      }
      if(leave_type_id == 4 || leave_type_id == 5){
        
        $('#maternity').show();
        
      }else{
        $('#maternity').hide();
       
      }

  })
</script>