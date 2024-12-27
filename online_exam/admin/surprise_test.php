<?php

//exam.php

include('database.php');

$object = new database();

if (!$object->is_login()) {
    header("location:" . $object->base_url . "admin");
}

if (!$object->is_master_user()) {
    header("location:" . $object->base_url . "admin/result.php");
}

$object->query = "
SELECT * FROM tbl_program_master 
WHERE active = 1 ";

$result = $object->get_result();

include('header.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Exam Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Exam List</h6>
            </div>
            <div class="col" align="right">
                <button type="button" name="add_exam" id="add_exam" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="exam_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Exam Name</th>
                        <th>Examiner Name</th>
                        <th>Program Name</th>
                        <th>Term Name</th>
                        <th>Paper Name</th>
                        <th>Exam Date & Time</th>
                        <th>Exam Duration</th>
                        <th>Total Question</th>
                        <th>Right Answer</th>
                        <th>Wrong Answer</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $object->query = "
                        SELECT  m.id,m.exam_title, f.name as faculty_name, m.trng_type,m.program_id,m.term_id,m.paper_id, 
		                m.exam_date_time,m.exam_duration,m.total_question,
                        m.marks_per_right_answer,m.marks_per_wrong_answer,m.status,m.exam_code FROM `tbl_exam_master` m 
                        JOIN `tbl_faculty_master` f ON m.examiner_id = f.id
                        WHERE m.exam_category =3
                        ";
                       // echo $object->query;
                        $res_data = $object->get_result();
                       
                        foreach ($res_data as $exam_row) {
                          // print_r($exam_row);
                            $status = '';
			                $action_button = '';

                            if($exam_row['trng_type'] == 1){
                                $prog_table = "tbl_program_master";
                                $paper_table = "tbl_paper_master";
                              
                            }elseif($exam_row['trng_type'] == 3){
                                $prog_table = "tbl_mid_program_master";
                                $paper_table = "tbl_mid_paper_master";
                            }else{
                                $prog_table = "tbl_short_program_master";
                                $paper_table = "tbl_mid_paper_master";
                            }

                            if($exam_row['status'] == 1 )
                            {
                               
                                $action_button = '
                                <div  align="center">
                                <button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$exam_row["id"].'"><i class="fas fa-edit"></i></button>
                                <button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$exam_row["id"].'"><i class="fas fa-times"></i></button>
                                <button type="button" name="send_button" class="btn btn-success  btn-sm approval_button" data-id="'.$exam_row["id"].'">Send to Approve</button>
                                </div>
                                ';
                            }
            
                            if($exam_row['status'] == 1)
                            {
                                $status = '<span class="badge badge-success">Created</span>';
                            }   
                            if($exam_row['status'] == 2)
                            {
                                $status = '<span class="badge badge-warning">Pending</span>';
                               
                            }
                            if($exam_row['status'] == 4)
                            {
                                $action_button = '
                                <div  align="center">
                                <button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$exam_row["id"].'"><i class="fas fa-edit"></i></button>
                                <button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$exam_row["id"].'"><i class="fas fa-times"></i></button>
                                
                                </div>
                                ';
                                $status = '<span class="badge badge-warning">Approved</span>';
                               
                            }
            
                            if($exam_row['status'] == '5')
                            {
                                $status = '<span class="badge badge-dark">Completed</span>';
                                
                            }
                           ?>
                             <tr>
                                <td><?php echo $exam_row['exam_title']; ?></td>
                                <td><?php echo $exam_row['faculty_name']; ?></td>
                                <td>
                                    <?php 
                                        echo  $object-> Get_program_name($prog_table,$exam_row['program_id']);
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                     if($exam_row['trng_type'] == 1){
                                       
                                        echo  $object->Get_term_name('tbl_term_master',$exam_row['term_id']);
                                     }else{
                                        echo "not available";
                                     }
                                       
                                     ?>
                                </td>
                                <td>
                                    <?php 
                                    
                                    echo  $object->Get_paper_name($paper_table,$exam_row['paper_id']);
                                    ?>
                                </td>
                                <td><?php echo $exam_row['exam_date_time']; ?></td>
                                <td><?php echo $exam_row['exam_duration'].' Minutes'; ?></td>
                                <td><?php echo $exam_row['total_question'].' Qustions'; ?></td>
                                <td><?php echo '+'.$exam_row['marks_per_right_answer']; ?></td>
                                <td><?php echo ($exam_row['marks_per_wrong_answer'] == 0)?0: '-'.$exam_row['marks_per_wrong_answer']; ?></td>
                                <td><?php echo $status ?></td>
                                <td><?php echo $action_button ?></td>
                                

                             </tr>
                           <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>

<div id="examModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="surprise_exam_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Exam Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <label>Exam Name</label>
                        <input type="text" name="exam_title" id="exam_title" class="form-control" required data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-trigger="keyup" />
                    </div>
                    <div class="form-group">
                        <label>Programme Type</label>
                        <select name="trng_type" id="program_type" class="form-control" required>
                            <option value="">Select Programme Type</option>
                            <option value="1">Long Term</option>
                            <option value="3">Mid Term</option>
                            <option value="4">Short Term</option>
                           
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Programme</label>
                        <select name="program_id" id="program_id" class="form-control" required>
                            <option value="">Select Programme</option>
                            
                        </select>
                    </div>
                    <div class="form-group" id="term_div">
                        <label>Term</label>
                        <select name="term_id" id="term_id" class="form-control">
                            <option value="0">Select Term</option>
                            <?php
                            $object->query = "
                            SELECT * FROM tbl_term_master 
                            ";
                            
                            $res2 = $object->get_result();

                            foreach ($res2 as $row2) {
                                echo '<option value="' . $row2["id"] . '">' . $row2["term"] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Paper</label>
                        <select name="paper_id" id="paper_id" class="form-control" required>
                            <option value="0">Select Paper</option>
                            <?php
                            // $object->query = "
                            // SELECT * FROM tbl_paper_master 
                            // ";
                            
                            // $res3 = $object->get_result();

                            // foreach ($res3 as $row3) {
                            //     echo '
                            //     <option value="' . $row3["id"] . '">' . $row3["paper_code"] . '</option>
                            //     ';
                            // }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Examiner 1</label>
                        <select name="examiner_id" id="examiner_id" class="form-control" required>
                            <option value="">Select Examiner </option>
                            <?php
                            $object->query = "
                            SELECT * FROM tbl_faculty_master 
                            WHERE role = 1 AND desig != 'Director' ";
                            
                            $res = $object->get_result();

                            foreach ($res as $row1) {
                                echo '
                                <option value="' . $row1["id"] . '">' . $row1["name"] . '</option>
                                ';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Examiner 2</label>
                        <select name="asst_examiner_id" id="asst_examiner_id" class="form-control" required>
                            <option value="">Select Examiner</option>
                            <?php
                            $object->query = "
                            SELECT * FROM tbl_faculty_master 
                            WHERE role = 1 AND desig != 'Director' ";
                            
                            $res = $object->get_result();

                            foreach ($res as $row1) {
                                echo '
                                <option value="' . $row1["id"] . '">' . $row1["name"] . '</option>
                                ';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <!-- <div class="form-group">
                        <label>Exam Date</label>
                        <input type="Date" name="exam_date" id="exam_date" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Exam Time</label>
                        <input type="Time" name="exam_time" id="exam_time" class="form-control" required />
                    </div> -->
                    <div class="form-group">
                        <label>Exam Date & Time</label>
                        <input type="text" name="exam_datetime" id="exam_datetime" class="form-control datepicker" readonly required data-parsley-trigger="keyup" />
                    </div>
                    <div class="form-group">
                        <label>Exam Duration for Each Subject <span class="text-danger">*</span></label>
                        <select name="exam_duration" id="exam_duration" class="form-control" required>
                            <option value="">Select</option>
                            <option value="5">5 Minute</option>
                            <option value="10">10 Minute</option>
                            <option value="20">20 Minute</option>
                            <option value="30">30 Minute</option>
                            <option value="45">45 Minute</option>
                            <option value="60">1 Hour</option>
                            <option value="120">2 Hour</option>
                            <option value="180">3 Hour</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Total Question</label>
                        <select name="total_question" id="total_question" class="form-control" required>
                            <option value="">Select</option>
                            <option value="5">5 Question</option>
                            <option value="10">10 Question</option>
                            <option value="25">25 Question</option>
                            <option value="50">50 Question</option>
                            <option value="100">100 Question</option>
                            <option value="200">200 Question</option>
                            <option value="300">300 Question</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Marks for Correct Answer</label>
                        <select name="marks_per_right_answer" id="marks_per_right_answer" class="form-control">
                            <option value="">Select</option>
                            <option value="1">+1 Mark</option>
                            <option value="2">+2 Mark</option>
                            <option value="3">+3 Mark</option>
                            <option value="4">+4 Mark</option>
                            <option value="5">+5 Mark</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Marks for Wrong Answer</label>
                        <select name="marks_per_wrong_answer" id="marks_per_wrong_answer" class="form-control">
                            <option value="">Select</option>
                            <option value="0">NO Negative Mark</option>
                            <option value="1">-1 Mark</option>
                            <option value="1.25">-1.25 Mark</option>
                            <option value="1.50">-1.50 Mark</option>
                            <option value="2">-2 Mark</option>
                        </select>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="hidden" name="exam_category" value="3" />
                    <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="publishresultModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="publish_result_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Publish Exam Result</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Exam Result Publish Date & Time</label>
                        <input type="text" name="exam_result_publish_datetime" id="exam_result_publish_datetime" class="form-control datepicker" readonly required data-parsley-trigger="keyup" />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_exam_id" id="hidden_exam_id" />
                    <input type="hidden" name="action" id="action" value="Result Publish" />
                    <input type="submit" name="submit" id="result_publish_submit_button" class="btn btn-success" value="Publish" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#exam_table').DataTable();
        // var dataTable = $('#exam_table').DataTable({
        //     "processing": true,
        //     "serverSide": true,
        //     "order": [],
        //     "ajax": {
        //         url: "exam_action.php",
        //         type: "POST",
        //         data: {
        //             action: 'fetch'
        //         },success:function(res){
        //             conaole.log(res)
        //         }
        //     },
        //     "columnDefs": [{
        //         "targets": [9],
        //         "orderable": false,
        //     }, ],
        // });

        var date = new Date();
        date.setDate(date.getDate());
        $("#exam_datetime").datetimepicker({
            startDate: date,
            format: 'dd-mm-yyyy hh:ii',
            autoclose: true
        });

        $('#exam_result_publish_datetime').datetimepicker({
            startDate: date,
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true
        });
        $('#program_type').change(function(){
            const program_type = $(this).val();

            $.ajax({
                type: "POST",
                url: "surprise_test_action.php",

                data: {
                    program_type: program_type,
                    action: "select_programme"
                },
                success: function(res) {
                    console.log(res);
                    $('#program_id').html(res);
                }
            })

        })
        $('#program_id').change(function() {
            const program_id = $(this).val();
            const program_type = $('#program_type').val();
            if (program_type == 1){
                $('#term_div').show();

                    $.ajax({
                    type: "POST",
                    url: "surprise_test_action.php",

                    data: {
                        program_id: program_id,
                        action: "select_term"
                    },
                    success: function(res) {
                        console.log(res);
                        $('#term_id').html(res);
                    }
                })
            }else{
               
                $('#term_div').hide();

                $.ajax({
                type: "POST",
                url: "surprise_test_action.php",

                data: {
                    program_id: program_id,
                    action: "select_mid_paper"
                },
                success: function(res) {
                    console.log(res);
                    $('#paper_id').html(res);
                }
            })
            }
            
        })
        $('#term_id').change(function() {
            var term_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "exam_action.php",

                data: {
                    term_id: term_id,
                    action: "select_paper"
                },
                success: function(res) {
                    console.log(res);
                    $('#paper_id').html(res);
                }
            })
        })

        $('#add_exam').click(function() {
          
            $('#surprise_exam_form')[0].reset();

            $('#surprise_exam_form').parsley().reset();

            $('#modal_title').text('Add Exam Data');

            $('#action').val('Add');

            $('#submit_button').val('Add');

            $('#examModal').modal('show');

            $('#form_message').html('');

            $('#ifedit').html('');

            $('#exam_class_id').attr('disabled', false);

        });

        $('#surprise_exam_form').parsley();

        $('#surprise_exam_form').on('submit', function(event) {
            event.preventDefault();
            console.log('Please');
            if ($('#examModal').parsley().isValid()) {
                $.ajax({
                    url: "surprise_test_action.php",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $('#submit_button').attr('disabled', 'disabled');
                        $('#submit_button').val('wait...');
                    },
                    success: function(data) {
                        console.log(data);
                        $('#submit_button').attr('disabled', false);
                        if (data.error != '') {
                            $('#form_message').html(data.error);
                            $('#submit_button').val('Add');
                        } else {
                            $('#examModal').modal('hide');
                            $('#message').html(data.success);
                            dataTable.ajax.reload();
                               
                            setTimeout(function() {

                                $('#message').html('');
                                location.reload()

                            }, 5000);
                        }
                    }
                })
            }
        });

        $(document).on('click', '.edit_button', function() {

            var exam_id = $(this).data('id');

            $('#surprise_exam_form').parsley().reset();

            $('#form_message').html('');

            $.ajax({

                url: "exam_action.php",

                method: "POST",

                data: {
                    exam_id: exam_id,
                    action: 'fetch_single',
                    table : 'tbl_exam_master'
                },

                dataType: 'JSON',

                success: function(data) {

                    $('#exam_class_id').val(data.exam_class_id);

                    $('#exam_class_id').attr('disabled', 'disabled');

                    $('#exam_title').val(data.exam_title);

                    $('#exam_duration').val(data.exam_duration);
                    
                    $('#examiner_id').val(data.examiner_id);
                    $('#program_id').val(data.program_id);
                    $('#term_id').val(data.term_id);
                    $('#paper_id').val(data.paper_id);
                    $('#exam_datetime').val(data.exam_date_time);
                    $('#total_question').val(data.total_question);
                    $('#marks_per_right_answer').val(data.marks_per_right_answer);
                    $('#marks_per_wrong_answer').val(data.marks_per_wrong_answer);

                    $('#modal_title').text('Edit Exam Data');

                    $('#action').val('Edit');

                    $('#submit_button').val('Edit');

                    $('#examModal').modal('show');

                    $('#hidden_id').val(exam_id);

                   

                }

            })

        });

        $(document).on('click', '.delete_button', function() {

            var id = $(this).data('id');

            if (confirm("Are you sure you want to remove it?")) {

                $.ajax({

                    url: "exam_action.php",

                    method: "POST",

                    data: {
                        id: id,
                        action: 'delete'
                    },

                    success: function(data) {

                        $('#message').html(data);

                        dataTable.ajax.reload();

                        setTimeout(function() {

                            $('#message').html('');

                        }, 5000);

                    }

                })

            }

        });
        
         $(document).on('click', '.approval_button', function() {

            var id = $(this).data('id');

            if (confirm("Are you sure you want to send it for approval?")) {

                $.ajax({

                    url: "exam_action.php",

                    method: "POST",

                    data: {
                        id: id,
                        action: 'approval'
                    },

                    success: function(data) {

                        $('#message').html(data);

                        setTimeout(function() {

                            $('#message').html('');
                           location.reload();
                        }, 5000);

                    }

                })

            }

        });

        $(document).on('click', '.publish_result', function() {
            var exam_id = $(this).data('exam_id');
            $.ajax({
                url: "exam_action.php",
                method: "POST",
                data: {
                    exam_id: exam_id,
                    action: "fetch_result_publish_data"
                },
                success: function(data) {
                    if (data != '') {
                        $('#exam_result_publish_datetime').val(data);
                    }
                    $('#publishresultModal').modal('show');
                    $('#hidden_exam_id').val(exam_id);
                }
            });
        });

        $('#publish_result_form').parsley();

        $('#publish_result_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#publish_result_form').parsley().isValid()) {
                $.ajax({
                    url: "exam_action.php",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $('#result_publish_submit_button').attr('disabled', 'disabled');
                        $('#result_publish_submit_button').val('wait...');
                    },
                    success: function(data) {
                        $('#result_publish_submit_button').attr('disabled', false);

                        $('#publishresultModal').modal('hide');
                        $('#message').html(data.success);
                        dataTable.ajax.reload();

                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });

    });
</script>