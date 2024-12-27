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
<h4 class="text-gray-800">Exam Result</h4>


<!-- DataTales Example -->
<span id="message"></span>

<?php
   $program_id=$_POST['program_id'];
   $exam_id=$_POST['exam_id'];
   $trng_type=$_POST['trng_type'];

   $object->query = "SELECT i.id,i.user_id,i.trainee_detail_id,i.name,i.phone FROM `tbl_dept_trainee_registration`i
  
   WHERE i.program_id = 68 AND i.trng_type = 5 AND i.user_id NOT IN (SELECT trainee_id FROM `tbl_trainee_exam_info` WHERE `exam_id` = 123)";
   echo "<div class='table-responsive'>";
   echo "<table class='table table-bordered'  width='100%' cellspacing='0' border='1'>";
   echo "<tr>
           <th>ID</th>
           <th>User ID</th>
           <th>Trainee Detail ID</th>
           <th>Name</th>
           <th>Phone</th>
           <th>Action</th>
         </tr>";
   $res_data = $object->get_result();
   foreach ($res_data as $row) {
    $user_id = htmlspecialchars($row['user_id']);
    $dept_trainee_id = $row['id'];
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['trainee_detail_id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
    echo '<td><button type="button" class="btn btn-success" id="set_qstn'.$row['id'] . '"
     onclick = "setIndQuestion(' . $exam_id . ',' . $program_id . ',' . $trng_type . ',' . $user_id . ',' . $dept_trainee_id . ')" >Set Qustion</button> </td>';
    echo "</tr>";

   }

   echo "</table>";
   echo "</div>";

?>



<div id="modal_exam_result" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form method="post" id="modal_exam_result">
            <div class="modal-content">

                <div class="modal-body" id="tbl_result_div">

                </div>
                <div class="modal-footer" id="change_time_footer">
                    <input type="button" class="btn btn-danger" data-dismiss="modal" value="Close">
                </div>
            </div>
        </form>
    </div>
</div>
<?php
  include('footer.php');
?>

<script>

function setIndQuestion(exam_id, program_id, trng_type,user_id,id){
//alert(exam_id); 

    $.ajax({
       url:"examiner_surprise_exam_list_action.php",
       method:"POST",
       data:{"action":'set_ind_question',exam_id:exam_id,program_id:program_id,trng_type:trng_type,dept_trainee_id:id},
       beforeSend:function()
            {
                $('#set_qstn'+id).attr('disabled', 'disabled');
                $('#set_qstn'+id).val('wait...');
            },
        success:function(data)
        {
            console.log(data);
            if(data.trim() == 'success'){
                $('#set_qstn'+id).attr('disabled', false);
                //dataTable.ajax.reload();
                location.reload();
            }else{
               // alert(data.trim());
            }
           

        }
    })
}

$(document).ready(function() {
    $('#exam_table').DataTable();
});

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