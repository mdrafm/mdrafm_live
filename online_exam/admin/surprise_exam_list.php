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
                        <th>Exam Date & Time</th>
                        <th>Exam Duration</th>
                        <th>Total Question</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Secreat Code</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                        $object->query = "
                        SELECT  m.id,m.program_id,m.exam_title,m.total_question,m.set_question_paper,m.exam_category,m.trng_type, 
                         m.exam_date_time,m.exam_duration,m.status,m.exam_code,m.trainee_attandance FROM `tbl_exam_master` m 
                         WHERE m.exam_category = 3 ";
                     
                       // echo $object->query;
                        $res_data = $object->get_result();
                       
                        foreach ($res_data as $row) {
                          // print_r($exam_row);
                            $status = '';
			                $action_button = '';
                            
                            $exam_title = html_entity_decode($row["exam_title"]);
          
                            $exam_date_time = $row['exam_date_time'];
                            $exam_duration = $row['exam_duration'] . ' Minutes';
                            $total_question = $row['total_question'] . ' Qustions';

                            $exam_code = '';
                            if ($row['trainee_attandance'] == 1) {
                                $exam_code = $row['exam_code'];
                            }

                        
                            $exam_category = $row["exam_category"];
                            $exam_id = $row["id"];
                            $program_id = $row["program_id"];
                            $trng_type = $row["trng_type"];
                           
                            if ($row['status'] == 4) {
                                if ($row['set_question_paper'] == 0) {
                                    $action_button = '
                                <div  align="center">
                                 <button type="button" id="set_qstn" class="btn btn-success  btn-sm" 
                                   data-id="' . $row["id"] . '"
                                    onclick = "setQuestion(' . $exam_id . ',' . $program_id . ',' . $trng_type . ')" >Set Qustion</button>
                                <button type="button" id="set_qstn" class="btn btn-warning  btn-sm mt-1" 
                                   data-id="' . $row["id"] . '"
                                    onclick = "modifyTime(' . $exam_id . ',' . $program_id . ')" >Modify Time</button>
                                </div>
                               
                                </div>
                                <input type="hidden" name="exam_id" value = "' . $row["id"] . '" >
                                ';
                                } else {
                                    $action_button = '
                                <div  align="center">
                                 <button type="button" id="set_qstn" class="btn btn-success  btn-sm" 
                                   data-id="' . $row["id"] . '"
                                    onclick = "takeAttendance(' . $exam_id . ',' . $program_id . ',' . $trng_type . ')" >Take Attendance</button>
                
                                <button type="button" id="set_qstn" class="btn btn-warning  btn-sm mt-1" 
                                    data-id="' . $row["id"] . '"
                                     onclick = "modifyTime(' . $exam_id . ',' . $program_id . ')" >Modify Time</button>
                                </div>
                                <button type="button" class="btn btn-success  btn-sm" data-id="' . $row["id"] . '"
                                 onclick = "setQuestionInd(' . $exam_id . ',' . $program_id . ',' . $trng_type . ')" >Set Question Ind</button>
                                  <button type="button" id="set_qstn" class="btn btn-primary  btn-sm mt-1" 
                                   data-id="' . $row["id"] . '"
                                    onclick = "updateExamStatus(' . $exam_id . ',5)" >Start </button>
                
                                <input type="hidden" name="exam_id" value = "' . $row["id"] . '" >
                                ';
                                }
                            }
                            if ($row['status'] == 5) {
                                $action_button = '
                                <div  align="center">
                                 <button type="button" id="set_qstn" class="btn btn-success  btn-sm" 
                                   data-id="' . $row["id"] . '"
                                    onclick = "takeAttendance(' . $exam_id . ',' . $program_id . ')" >Take Attendance</button>
                
                                <button type="button" id="set_qstn" class="btn btn-warning  btn-sm mt-1" 
                                    data-id="' . $row["id"] . '"
                                     onclick = "modifyTime(' . $exam_id . ',' . $program_id . ')" >Modify Time</button>
                                </div>
                                <button type="button" id="set_qstn" class="btn btn-danger  btn-sm mt-1" 
                                   data-id="' . $row["id"] . '"
                                    onclick = "updateExamStatus(' . $exam_id . ',6)" >Stop </button>
                                <input type="hidden" name="exam_id" value = "' . $row["id"] . '" >
                                ';
                            }
                            if ($row['status'] == 6) {
                                $action_button = '
                                <div  align="center">
                                <button type="button" id="set_qstn" class="btn btn-success  btn-sm" 
                                onclick = "view_result(' . $exam_id . ','.$exam_category.','.$trng_type.')" >View Result</button>
                
                                ';
                            }
                
                            // if($exam_row['status'] == 1)
                            // {
                            //     $status = '<span class="badge badge-success">Created</span>';
                            // }   
                            if ($row['status'] == 4) {
                                $status = '<span class="badge badge-warning">Upcoming</span>';
                            }
                            if ($row['status'] == 5) {
                                $status = '<span class="badge badge-success">Started</span>';
                            }
                            if ($row['status'] == 6) {
                                $status = '<span class="badge badge-danger">Completed</span>';
                            }
                           ?>
                             <tr>
                                <td><?php echo $exam_title; ?></td>
                                <td><?php echo $exam_date_time; ?></td>
                                <td><?php echo  $exam_duration;?> </td>
                                <td><?php echo  $total_question;?> </td>
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
<div id="traineeAttendanceModal" class="modal fade">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="traineeAttendance_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Take Trainee Attendance</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>

                    <div id="view_trainee_list"></div>
        		</div>
        		<div class="modal-footer">
          			 

          			<!-- <input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" /> -->
                      <input type="button" class="btn btn-success" value="Save" onclick="save_attendance()" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<div id="modifyTimeModal" class="modal fade">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="modifyTimeModal">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Modify Exam Time</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
                    <div class="form-group">
                        <label>Exam Date & Time</label>
                        <input type="text" name="exam_datetime" id="exam_datetime" class="form-control datepicker" readonly required data-parsley-trigger="keyup" />
                    </div>
                    <div class="form-group">
                        <label>Reasion to modify Exam time</label>
                        <textarea name="time_modify_reseasion" id="time_modify_reseasion" rows="3" class="form-control" required></textarea>
                   </div>
        		</div>
        		<div class="modal-footer" id="change_time_footer">
          			 

          			<!-- <input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" /> -->
                    
        		</div>
      		</div>
    	</form>
  	</div>
</div>
<?php
include('footer.php');
?>



<script>
    $(document).ready(function() {
       
        var date = new Date();
        date.setDate(date.getDate());
        $("#exam_datetime").datetimepicker({
            startDate: date,
            format: 'dd-mm-yyyy hh:ii',
            autoclose: true
        });

        $('#exam_table').DataTable();
    });
    function setQuestion(exam_id,program_id,trng_type){
//alert(exam_id); 

    $.ajax({
       url:"examiner_surprise_exam_list_action.php",
       method:"POST",
       data:{"action":'set_question',exam_id:exam_id,program_id:program_id,trng_type:trng_type},
       beforeSend:function()
            {
                $('#set_qstn').attr('disabled', 'disabled');
                $('#set_qstn').val('wait...');
            },
        success:function(data)
        {
            console.log(data);
            if(data.trim() == 'success'){
                $('#set_qstn').attr('disabled', false);
                //location.reload();
            }else{
               // alert(data.trim());
            }
           

        }
    })
}

function modifyTime(exam_id,program_id){
    $('#change_time_footer').html('');

    $('#change_time_footer').html(` <input type="button" class="btn btn-success" id="modify_time" value="Save" onclick="save_modify_exam_time(${exam_id},${program_id})" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>`);
           
    $('#modifyTimeModal').modal('show');
}

function save_modify_exam_time(exam_id,program_id){
    let time_modify_reseasion = $('#time_modify_reseasion').val();
    let exam_datetime = $("#exam_datetime").val();

    $.ajax({
       url:"examiner_long_exam_list_action.php",
       method:"POST",
       data:{"action":'modify_exam_time',exam_id:exam_id,program_id:program_id,time_modify_reseasion:time_modify_reseasion,exam_datetime:exam_datetime},
       beforeSend:function()
            {
                $('#modify_time').attr('disabled', 'disabled');
                $('#modify_time').val('wait...');
            },
        success:function(data)
        {
            console.log(data);

            $('#modify_time').attr('disabled', false);
            if(data.trim() == 'success'){
                location.reload();
            }

        }
   })
}

function takeAttendance(exam_id,program_id,trng_type){
    $('.modal-footer').html('');

    $.ajax({
        type: 'POST',
        url: "examiner_surprise_exam_list_action.php",
        data: {
            action: "trainee_atn",
            exam_id: exam_id,
            program_id: program_id,
            trng_type:trng_type
            
        },
        success: function(res) {
            console.log(res);
            $('#view_trainee_list').html(res);
            $('.modal-footer').html(` <input type="button" class="btn btn-success" value="Save" onclick="save_attendance(${exam_id})" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>`);
            $('#traineeAttendanceModal').modal('show');

            $("#checkAll").click(function(){
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


        }

    });
}
function save_attendance(exam_id) {


var attendance = [];
$.each($("input:checkbox[name='atten']:checked"), function() {
    attendance.push($(this).val());
});
//alert("We remain open on: " +attendance);

TableData = storeTblValues();
TableData = JSON.stringify(TableData);
//console.log(storeTblValues());

$.ajax({
    url: 'examiner_surprise_exam_list_action.php',
    type: "POST",
    data: {
        'action':'save_attandance',
        'tableData': TableData,
        'exam_id':exam_id
       
    },

    success: function(data) {
        console.log(data)
        if(data.trim() == 'success'){
            $('#traineeAttendanceModal').modal('hide');
            location.reload();
        }
    }
});
}
//exam_date();

function updateExamStatus(exam_id,status){
     $.ajax({
        url: 'examiner_surprise_exam_list_action.php',
        type: "POST",
        data: {
            'action':'update_exam_status',
            status:status,
            exam_id:exam_id
        
        },

        success: function(data) {
            console.log(data)
           
        }
    });
}

function exam_date(){
    var examDateData = [];
    var data = "";
     $('#exam_table tr').each(function(row,tr){
        examDateData[row] = {
            "exam_date": $(tr).find('td:eq(4)').text(),
            "exam_duration": $(tr).find('td:eq(5)').text(),
            "exam_status": $(tr).find('td:eq(7)').text(),
            "exam_id": $(tr).find('input[type="hidden"]').val()
        }
     });
     examDateData.shift();
     //data = JSON.stringify(examDateData);

    //console.log(data);
     return examDateData;

}

function storeTblValues() {
    var TableData = new Array();
    $('#trainne_attn_table tr').each(function(row, tr) {
        TableData[row] = {
            "trainee_id": $(tr).find('input[type="hidden"]').val(),
            "phone": $(tr).find('td:eq(3)').text(),
            "attandance": $(tr).find('input[type="checkbox"]:checked').val()

        }
    });
    TableData.shift(); // first row will be empty - so remove
    return TableData;
}

function view_result(exam_id,exam_category,trng_type)
{
    datapost('get_traniee_result_list.php', {
                exam_id: exam_id,
                exam_category:exam_category,
                trng_type:trng_type
            });
}

function setQuestionInd(exam_id,program_id,trng_type)
{
    datapost('set_individual_question.php', {
                exam_id: exam_id,
                program_id:program_id,
                trng_type:trng_type
            });
}

function datapost(path, params, method) {
       
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