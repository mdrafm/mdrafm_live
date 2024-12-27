<!DOCTYPE html>
<html lang="en">


<head>
    <?php 
    
    include('header_link.php');
    include('../config.php');
    include 'database.php';
   
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
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Full Time Table</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action='view_full_time_table.php'>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><strong>Program</strong></label>
                                            <select class="custom-select mr-sm-2" name="program_id" id="program">
                                                <option selected>Select Program</option>
                                                <?php 
                                                $db = new Database();
                                                $count = 0;
                                                $db->select('tbl_short_program_master',"*",null,"(trng_type = 4 OR trng_type = 5) AND status = 'approve' ",null,null);
                                                // print_r( $db->getResult());
                                                foreach($db->getResult() as $row){
                                                    //print_r($row);
                                                    $count++
                                            ?>
                                                <option value="<?php echo $row['id'] ?>">
                                                    <?php echo $row['prg_name'] ?>
                                                </option>

                                                <?php 
                                                            }
                                                       ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <input type="hidden" name="trng_type" value = "4" >
                                        <input type="submit" class="btn btn-info" name="Add" style="margin-top:25px"
                                            value="view">

                                    </div>
                                </div>
                            </form>
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
                                <textarea class="form-control cancel_comment" style="border: 1px solid black;"
                                    id="reject_comment" rows="3"></textarea>
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
function review_timeTable(id, type, prog_id, prog_name, from_dt, to_dt) {

    $.ajax({
        type: "POST",
        url: "ajax_search.php",
        data: {

            id: id,
            type: type,
            prog_id: prog_id,
            prog_name: prog_name,
            from_dt: from_dt,
            to_dt: to_dt,
            action: 'view_timetable'
        },
        success: function(res) {
            console.log(res);
            $('#timeTable_title').html(`Time Table For ${prog_name}`);
            $('#time_Table').html(res);

            $('#timetableModal').modal('show');
        }
    })
}

function approve(id, title) {
    $('#m_body').hide();
    $('#m_footer').html('');
    $('#timetableModal').modal('hide');
    $('#m_title').html(`${title} Time Table`);
    $('.wrn_msg').html(`Hello Sir, Are you sure you want to ${title} this Time Table?`);
    var html =
        `<input type="button" class="btn btn-success btn-dlt" value="Approve" onclick="approve_record(${id},'tbl_time_table_range')" />`;
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

function approve_record(id, tbl) {
    //console.log(id);
    $.ajax({
        type: "POST",
        url: "ajax_master.php",
        data: {

            action: "dir_approve_timeTable",
            id: id,
            table: tbl
        },
        success: function(res) {
            console.log(res);
            if (res == "success") {
                sessionStorage.message = "Record Approve successfully";
                sessionStorage.type = "success";
                location.reload();
            }
        }
    })
}

function reject_record(id, tbl) {
    let msg = $('#reject_comment').val();
    $.ajax({
        type: "POST",
        url: "ajax_master.php",
        data: {

            action: "dir_reject_timeTable",
            id: id,
            msg: msg,
            table: tbl
        },
        success: function(res) {
            console.log(res);
            if (res == "success") {
                sessionStorage.message = "Record Approve successfully";
                sessionStorage.type = "success";
                // location.reload();
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