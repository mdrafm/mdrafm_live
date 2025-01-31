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
                                <h4 class="card-title">Time Table</h4>

                            </div>
                            <div class="card-body">
                                <form id="frm_range">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>Select Training Type</strong></label>
                                                <select class="custom-select mr-sm-2" name="traning_type" id="traning_type">
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
                                                <label><strong>Select Program</strong></label>
                                                <select class="custom-select mr-sm-2" name="program_id" id="program_id">
                                                    <option selected>Select Program</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                         

                                    </div>
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="form-group">

                                                <input type="button" class="btn btn-primary" value="view" id="view_time_table"  style="float: right"
                                                    onclick="time_table()">
                                            </div>

                                        </div>
                                    </div>
                                </form>
                                <input type="hidden" name="update_id"  id="update_id" />
                            </div>
                        </div>

                    </div>

                </div>
             
                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="card-title">Time Table For Approval</h4>
                                     <?php //print_r($_SESSION) ?>
                                    </div>

                                </div>


                            </div>
                            <div class="card-body">
                                <div id="viewTimeTable" class=" table table-responsive table-striped table-hover"
                                    style="width:100%;margin:0px auto">
                                   
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

function time_table(){
   
    const program_id = $('#program_id').val();
    const trng_type =  $('#traning_type').val();
    
    $.ajax({
        type: "POST",
        url: "ajax_search.php",
        data: {

            action: "viewTimeTable",
            program_id:program_id,
            trng_type:trng_type,
        },
        success: function(res) {
            console.log(res);
            $('#viewTimeTable').html(res);
            $('#viewTimeTable').show();
            
        }
    })
}

function review_timeTable(program_table,time_table,subject_tbl,id,type,prog_id,prog_name,from_dt,to_dt) {

    $.ajax({
        type: "POST",
        url: "ajax_courseDir.php",
        data: {
            program_table,
            time_table,
            subject_tbl,
            id: id,
            type: type,
            prog_id: prog_id,
            prog_name: prog_name,
            from_dt: from_dt,
            to_dt: to_dt,
            action:'view_timetable_courseDir'
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
    $('.wrn_msg').html(`you want to ${title} this Time Table?`);
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

            action: "approve_timeTable",
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

            action: "reject_timeTable",
            id: id,
            msg: msg,
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

$('#term_id').on('change', function() {
    var term_id = $(this).val();
    // alert(term_id);

    $.ajax({
        type: "POST",
        url: "ajax_master.php",

        data: {
            term_id: term_id,
            table: "tbl_paper_master",
            action: "select"
        },
        success: function(res) {
            //console.log(res);
            $('#paper_id').html(res);
        }
    })

})

$('#trng_type').on('change', function() {
    var trng_type = $(this).val();
    // alert(term_id);
    var tbl;
    if (trng_type == 1) {
        tbl = "tbl_sylabus_master";
        $('#syllabus').show();
    } else if (trng_type == 2) {
        tbl = "tbl_mid_syllabus";
        $('#syllabus').show();
    } else {
        $('#syllabus').hide();
    }


    $.ajax({
        type: "POST",
        url: "ajax_master.php",

        data: {
            trng_type: trng_type,
            table: tbl,
            action: "select_syllabus"
        },
        success: function(res) {
            console.log(res);
            $('#syllabus_id').html(res);
        }
    })

})
$('#traning_type').on('change', function(){
   const type = $('#traning_type').val();
   const username = '<?php echo $_SESSION['username']; ?>'
   $.ajax({
        type: "POST",
        url: "ajax_master.php",
        data: {

            action: "timeTable_prgram",
            type: type,
            username:username
            
        },
        success: function(res) {
            console.log(res);
                $('#program_id').html(res);
            
            
            
        }
    })
})

function add(str, frm, tbl) {


    var update_id = $('#update_id').val();

    $.ajax({
        type: "POST",
        url: "ajax_master.php",

        data: $('#' + frm).serialize() + '&' + $.param({
            'action': 'add',
            'table': tbl,
            'update_id': update_id
        }),
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

function edit(id) {

    $.ajax({
        type: "POST",
        url: "ajax_master.php",
        dataType: "json",
        data: {
            action: "edit",
            table: "tbl_program_master",
            edit_id: id

        },
        success: function(res) {
            console.log(res);
            res.map((data) => {

                    $('#update_id').val(data.id);
                    $('#trng_type').val(data.trng_type);
                    $('#syllabus_id').val(data.syllabus_id);
                    $('#course_director').val(data.course_director);
                    $('#prg_name').val(data.prg_name);
                    $('#provisonal_Sdate').val(data.provisonal_Sdate);
                    $('#provisonal_Edate').val(data.provisonal_Edate);
                    $('#dt_publication').val(data.dt_publication);
                    $('#dt_completion').val(data.dt_completion);


                    $('#save').html('Update');
                    $('#save').attr('id', 'update');
                    $('#termModal').modal('show');
                }

            )

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