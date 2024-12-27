<?php

include('database.php');

$object = new database();

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}

include('header.php');
                
?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Exam Management <span style="float:right"><?php echo date('d-m-Y H:i:s') ?></span></h1>

<!-- DataTales Example -->
<span id="message"></span>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Exam List</h6>
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
});
var dataTable = $('#exam_table').DataTable({
            "processing" : true,
            "serverSide" : true,
            "bDestroy": true,
            "serverMethod":'post',
            "order" : [],
            "ajax" : {
                url:"examiner_quiz_exam_list_action.php",
                type:"POST",
                data:{action:'fetch'}
            },
            "column":[
                {
                    "targets":[3, 4, 5, 6, 7, 8],
                    "orderable":false,
                },
            ],
        });
function setQuestion(exam_id,program_id,paper_id){
//alert(exam_id); 

    $.ajax({
       url:"examiner_quiz_exam_list_action.php",
       method:"POST",
       data:{"action":'set_question',exam_id:exam_id,program_id:program_id,paper_id:paper_id},
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
                dataTable.ajax.reload();
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

setInterval(function () {
        //console.log('it works' + new Date());
        compare_date();
    },1000*6);

function compare_date(){
    var examdate =  exam_date();
    //var currentdate = new Date();
    let current = new Date();
    
    let minuts = current.getMinutes();
    let m = (minuts>9)?minuts:`0${minuts}`;

    let cDate = current.getFullYear() + '-' + (current.getMonth() + 1) + '-' + current.getDate();
    let cTime = current.getHours() + ":" + m + ":" + current.getSeconds();
    let currentTime = cDate + ' ' + cTime;
    //console.log(dateTime); 
    //console.log(examdate)
    // examdate.forEach((data)=>{
    //     console.log(data.exam_date);
    // })
    examdate.map((data)=>{
        let duration = data.exam_duration.split(' ');
        
        let current = new Date(data.exam_date);
        let eDate = current.getFullYear() + '-' + (current.getMonth() + 1) + '-' + current.getDate();
        let eTime = current.getHours() + ":" + (current.getMinutes() + Number(duration[0])) + ":" + current.getSeconds();
        let examEndTime = eDate + ' ' + eTime;

        let estartTime = new Date(data.exam_date);
        let sDate = current.getFullYear() + '-' + (current.getMonth() + 1) + '-' + current.getDate();
        let sTime = current.getHours() + ":" + current.getMinutes()  + ":" + current.getSeconds();
        let examStartTime = sDate + ' ' + sTime;

         console.log('currentTime -'+currentTime);
         console.log('start-time -'+ examStartTime);
         console.log('end-time -'+examEndTime);

            if(data.exam_status === 'Upcoming' || data.exam_status === 'Started'){
                if(currentTime < examStartTime ){
                console.log('pending');
                 }
                else if((currentTime >= examStartTime) && (currentTime <= examEndTime)){
                    console.log('started');
                    updateExamStatus(data.exam_id,5);
                    dataTable.ajax.reload();

                }
                else if(currentTime >= examEndTime ){
                    console.log('complite');
                    updateExamStatus(data.exam_id,6);
                    dataTable.ajax.reload();
                }
        }
        
        
    })
}

function updateExamStatus(exam_id,status){
     $.ajax({
        url: 'examiner_exam_list_action.php',
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