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
            <div class="row" style="margin-top:50px">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Leave Report</h4>
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
                                   
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="form-group">

                                                <input type="button" class="btn btn-primary" value="view"
                                                    style="float: right" onclick="view_report()">
                                            </div>

                                        </div>
                                    </div>
                                </form>
                              
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-md-4"> 
                    <div id="alert_msg" class="alert alert-success"></div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">Leave Applications Report</div>
                            <div class="card-body">
                                <div class="table table-responsive table-striped table-hover" id="leave_report">
                                   
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

function view_report(){
    const program_id = $('#program_id').val();
    const trng_type = $('#traning_type').val();
    const user_id = <?php echo  $_SESSION['user_id']; ?>;
    $.ajax({
        type: "POST",
        url: "ajax_leave.php",
        data: {
            action: "leave_report",
            program_id: program_id,
            trng_type:trng_type,
            user_id:user_id,

        },
        success: function(res) {
            console.log(res);
            $('#leave_report').html(res);

        }
    })
}

</script>