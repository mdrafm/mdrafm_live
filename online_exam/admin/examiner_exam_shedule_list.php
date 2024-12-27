<?php

include('database.php');

$object = new database();

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}

include('header.php');
                
?>
<span id="error"></span>
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Exam Management</h1>

<?php print_r($_SESSION); ?>
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
                        <th>Paper</th>
                        <th>Exam Date & Time</th>
                        <th>Exam Duration</th>
                        <th>Total Questions</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  <?php

                    $trng_type = 0;
                       $object->query  = "SELECT m.trng_type
                        FROM `tbl_exam_master` m 
                        JOIN `tbl_trainee_exam_info` i ON m.id = i.exam_id
                        WHERE i.trainee_id = '".$_SESSION['user_id']."'";
                        $object->execute();
                        $trng_type_res = $object->get_result();
                       //echo ($trng_type_res[0]['trng_type']);
                        foreach($trng_type_res as $row_type)
                        {
                            //echo $row_type['trng_type'];
                            $trng_type = $row_type['trng_type'];
                        }

                       
                        if($trng_type == 4){
                            $main_query = "
                                     SELECT m.id,m.exam_title,i.exam_date_time,i.exam_duration,m.total_question,m.status,i.exam_status
                                    FROM `tbl_exam_master` m 
                                    JOIN `tbl_trainee_exam_info` i ON m.id = i.exam_id
                                    WHERE i.trainee_id = '".$_SESSION['user_id']."'" ;
                        }else{
                            $main_query = "
                         SELECT m.id,m.exam_title,i.exam_date_time,i.exam_duration,m.total_question,m.status,p.paper_code,p.title as paper_title ,i.exam_status
                        FROM `tbl_exam_master` m 
                        JOIN `tbl_paper_master` p ON m.paper_id = p.id
                        JOIN `tbl_trainee_exam_info` i ON m.id = i.exam_id
                        WHERE i.trainee_id = '".$_SESSION['user_id']."'" ;
                        }

                         $object->query = $main_query;

                         $object->execute();

                         $result = $object->get_result();

                         foreach($result as $row)
                            {
                                $exam_title = html_entity_decode($row["exam_title"]);
          
                                $exam_date_time = $row['exam_date_time'];
                                $exam_duration = $row['exam_duration'] . ' Minutes';
                                $total_question = $row['total_question'] . ' Qustions';

                                
                                $status = '';
                                $action_button = '';
                                if($row['status'] == 4)
                                {
                                    $status = '<span class="badge badge-warning">Upcoming</span>';
                                   
                                }

                                if($row['status'] == 4 )
                                {
                                   if($row['exam_status'] == 1){
                                    // $action_button = '
                                    // <div  align="center">
                                    //  <button type="button" id="set_qstn" class="btn btn-danger  btn-sm" 
                                    //    data-id="'.$row["id"].'"
                                    //     onclick = "view_result('.$row["id"].')" >View Result</button>
                                    // </div>
                                    // ';
                                     $status = '<span class="badge badge-success">Complete</span>';
                                   }else{
                                    $action_button = '
                                    <div  align="center">
                                     <button type="button" id="set_qstn" class="btn btn-success  btn-sm" 
                                       data-id="'.$row["id"].'"
                                        onclick = "start_exam('.$row["id"].')" >Start exam</button>
                                    </div>
                                    ';
                                   }
                                   
                                    
                                }

                                // if($exam_row['status'] == 1)
                                // {
                                //     $status = '<span class="badge badge-success">Created</span>';
                                // }   
                                

                                if($row['status'] == '5')
                                {
                                    $status = '<span class="badge badge-dark">Started</span>';
                                    $action_button = '
                                    <div  align="center">
                                     <button type="button" id="set_qstn" class="btn btn-success  btn-sm" 
                                       data-id="'.$row["id"].'"
                                        onclick = "start_exam('.$row["id"].')" >Start exam</button>
                                    </div>
                                    ';
                                    
                                }
                                if($row['status'] == '6')
                                {
                                    $status = '<span class="badge badge-dark">Complete</span>';
                                    //  $action_button = '
                                    // <div  align="center">
                                    //  <button type="button" id="set_qstn" class="btn btn-danger  btn-sm" 
                                    //    data-id="'.$row["id"].'"
                                    //     onclick = "view_result('.$row["id"].')" >View Result</button>
                                    // </div>
                                    // ';
                                    
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
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Exam Secret Code</label>
                        <div class="col-sm-9">
                            <input type="text" name="secret_code" id="secret_code" autocomplete="off" class="form-control" required />
                        </div>
                    </div>
                   
        		</div>
        		<div class="modal-footer">
          			
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
    $('#exam_table').DataTable({});

    // var dataTable = $('#exam_table').DataTable({
    //         "processing" : true,
    //         "serverSide" : true,
           
    //         "ajax" : {
    //             url:"examiner_exam_shedule_list_action.php",
    //             type:"POST",
    //             data:{action:'fetch'}
    //         },
    //         "column":[
    //             {"data":0},
    //             {"data":1},
    //             {"data":2},
    //             {"data":3},
    //             {"data":4},
    //             {"data":5},
    //             {"data":6},
               
    //         ],
    //     });

});

function start_exam(exam_id){

   
   $('.modal-footer').html('');

   $('.modal-footer').html(` <input type="button" class="btn btn-success" value="Submit" onclick="verify_exam_code(${exam_id})" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>`);
   $('#traineeAttendanceModal').modal('show');

  
}

function view_result(exam_id){
    let user_id = <?php echo $_SESSION['user_id'] ?>;
    datapost('view_exam_result.php',{exam_id:exam_id,user_id:user_id});
}


function verify_exam_code(exam_id){
    let user_id = <?php echo $_SESSION['user_id'] ?>;
    let secret_code = $('#secret_code').val();
    $.ajax({
       url:"examiner_exam_shedule_list_action.php",
       method:"POST",
       data:{"action":'start_exam',exam_id:exam_id,user_id:user_id,secret_code:secret_code},
       dataType:"JSON",
        success:function(data)
        {
            console.log(data);
            $('#traineeAttendanceModal').modal('hide');
            if(data.error != '')
                    {
                        $('#error').html(data.error);
                       
                    }
                    else
                    {
                        window.location.href = data.url;
                       // window.location.href = "start_online_exam.php";
                    }
           // $('#set_qstn').attr('disabled', false);

        }
   })
}


function datapost(path, params, method) {
			//alert(path);
			method = method || "post"; // Set method to post by default if not specified.
			var form = document.createElement("form");
			form.setAttribute("method", method);
			form.setAttribute("action", path);
			for(var key in params) {
				if(params.hasOwnProperty(key)) {
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