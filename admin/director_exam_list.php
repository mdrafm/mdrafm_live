<!DOCTYPE html>
<html lang="en">


<head>
    <?php 
    
    include('header_link.php');
    include('../config.php');
    include 'database.php';
   
    ?>
    <style>
    .card label {
        font-size: 1rem;
    }
    </style>
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

                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="card-title">Exam List</h4>
                                    </div>

                                </div>


                            </div>
                            <div class="card-body">
                                <div id="term2" class=" table table-responsive table-striped table-hover"
                                    style="width:100%;margin:0px auto">
                                    <table class=" term table">
                                        <thead class="" style="background: #315682;color:#fff;font-size: 11px;">
                                             <th>Sl No</th>
                                            <th>Exam Name</th>
                                            <th>Examiner Name</th>
                                            <th>Program Name</th>
                                            <th>Term Name</th>
                                            <th>Paper Name</th>
                                            <th>Exam Date & Time</th>
                                            <th>Exam Duration</th>
                                            <th>Action</th>

                                        </thead>
                                        <tbody>
                                            <?php 
                               
                               $db = new Database();
                               $count = 0;
                               //$db->select('tbl_program_master',"*",null,null,null,null);
                               $sql = " SELECT  m.id,m.exam_title, m.examiner_id,m.asst_examiner_id, p.prg_name as program_name, 
                               t.term, pm.paper_code,m.exam_date_time,m.exam_duration,m.status,m.exam_code,m.reasion_modify_exam_time FROM `tbl_exam_master` m 
                               JOIN `tbl_program_master` p ON m.program_id = p.id
                               JOIN `tbl_term_master` t ON m.term_id = t.id
                               JOIN `tbl_paper_master` pm ON m.paper_id = pm.id WHERE m.status != 1 AND m.status !=2 ";
                                $db->select_sql($sql);             
                              // print_r( $db->getResult());
                               foreach($db->getResult() as $row){
                                    //print_r($row); 
                                   $tbl = "";
                                   $staus_btn = '';
                                   switch ($row['status']) {

                                       case '3';
                                           $staus_btn = '<span class="badge badge-warning">Pending at Director</span>';
                                           break;
                                       case '4';
                                           $staus_btn = '<span class="badge badge-warning">Approved</span>';
                                           break;
                                       case '5';
                                           $staus_btn = '<span class="badge badge-warning">Started</span>';
                                           break;
                                       case '6';
                                           $staus_btn = '<span class="badge badge-warning">Complite</span>';
                                           break;
                                       case '0';
                                           $staus_btn = '<span class="badge badge-warning">Rejected</span>';
                                           break;

                                       default:
                                           # code...
                                           break;
                                   }
                                   $count++
                                   ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $row['exam_title']; ?> </td>
                                                <td ><?php echo $db->getFacultyName($row['examiner_id']); ?> </td>
                                                <td><?php echo $row['program_name']; ?> </td>
                                                <td><?php echo $row['term']; ?> </td>
                                                <td><?php echo $row['paper_code']; ?> </td>
                                                <td>
                                                    <?php echo date("d/m/Y h:i", strtotime($row['exam_date_time'])) ?>
                                                </td>
                                                <td><?php echo $row['exam_duration'].' Minuets'; ?></td>
                                                <td>
                                                <input type="button" style="background: #bb1b09;border: 0;
                                                                                padding: 5px;
                                                                                border-radius: 3px;
                                                                                color: #fff;" data-toggle="modal" data-target="#exam_detailt_<?php echo $row['id'] ?>" value="view">
                                                      
                                                    <?php
                                                     include ('exam_view_dtl_template.php');
                                                     switch ($row['status']) {
                                                        case '3':
                                                           ?>
                                                             <button type="button" class="btn btn-info btn-sm"
                                                                        onclick="approve(<?php echo $row['id'] ?>,'Approve')">Approve</button>
                                                                        

                                                             <button type="button" class="btn btn-danger ml-2 btn-sm"
                                                                        onclick="reject(<?php echo $row['id'] ?>,'Reject')">Reject</button>
                                                           <?php
                                                            break;
                                                       
                                                        case '4';
                                                           echo '<span class="badge badge-primary">Approved</span>';
                                                           break;
                                                        case '5';
                                                           echo '<span class="badge badge-success">Complite</span>';
                                                           break;
                                                        case '0';
                                                           echo '<span class="badge badge-danger">Rejected</span>';
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

    <?php include('common_script.php') ?>

</body>

</html>

<script type="text/javascript">
function approve(id, title) {



    $('#m_body').hide();
    $('#m_footer').html('');


    $('#m_title').html(`${title} Exam`);
    $('.wrn_msg').html(`Hello Sir, Are you sure you want to ${title} this Record?`);
    var html =
        `<input type="button" class="btn btn-success btn-dlt" value="Approve" 
         onclick="approve_record(${id},'tbl_exam_master')" />`;
    $('#m_footer').append(html);
    $('#cnfModal').modal('show');
}

function reject(id, title) {
    $('#m_footer').html('');

    $('#m_title').html(`${title} Exam`);
    $('.wrn_msg').html(`Hello Sir,Please Write Remark For  ${title} this Record?`);
    var html =
        `<input type="button" class="btn btn-danger btn-dlt" value="Reject" onclick="reject_record(${id},'tbl_exam_master')" />`;
    $('#m_body').show();
    $('#m_footer').append(html);
    $('#cnfModal').modal('show');
}

function approve_record(id, tbl) {

   
    $.ajax({
        type: "POST",
        url: "ajax_exam.php",
        data: {

            action: "approve_exam_by_director",
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
        url: "ajax_exam.php",
        data: {

            action: "reject_exam_by_incharge",
            id: id,
            msg: msg,
            table: tbl
        },
        success: function(res) {
            console.log(res);
            if (res == "success") {
                sessionStorage.message = "Exam Reject successfully";
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

function add_course_dir(id, old_course_dir, roll) {

    let course_dir = $(`#course_director_${id}`).val();
    var action;
    //console.log(roll);

    if (old_course_dir == 0) {
        action = "add_course_dir";
    } else {
        action = "update_course_dir";
    }
    console.log(action);
    $.ajax({
        type: "POST",
        url: "ajax_master.php",
        data: {

            action: action,
            id: id,
            new_course_dir: course_dir,
            old_course_dir: old_course_dir,
            roll_id: roll,
            table: "tbl_program_master"
        },
        success: function(res) {
            console.log(res);
            // if (res == "success") {
            //     sessionStorage.message = "Email Content Updated successfully";
            //     sessionStorage.type = "success";
            //     location.reload();
            // }
        }
    })
}

function add_asst_course_dir(id, old_course_dir, roll) {

    let course_dir = $(`#asst_course_director_${id}`).val();
    var action;

    console.log(course_dir);

    if (old_course_dir == 0) {
        action = "add_asst_course_dir";
    } else {
        action = "update_asst_course_dir";
    }
    console.log(action);
    $.ajax({
        type: "POST",
        url: "ajax_master.php",
        data: {

            action: action,
            id: id,
            new_course_dir: course_dir,
            old_course_dir: old_course_dir,
            roll_id: roll,
            table: "tbl_program_master"

        },
        success: function(res) {
            console.log(res);
            // if (res == "success") {
            //     sessionStorage.message = "Email Content Updated successfully";
            //     sessionStorage.type = "success";
            //     location.reload();
            // }
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