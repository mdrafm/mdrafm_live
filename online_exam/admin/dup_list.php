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


<div>
    
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
           

        </div>
    </div>
    <div class="card-body">
        <div>
            <button class="btn btn-danger float-right" onclick="ExportToExcel('xlsx')">Export to excel</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="exam_result" width="100%" cellspacing="0">
                <thead>
                    <tr class="" style="background-color:#167F92;color:white">
                        <th>Sl No</th>
                        <th>Name</th>
                        
                        <th>Phone No.</th>
                         <th>exam id</th>
                        <th>Total Mark</th>
                        <th>Remark</th>
                        <th>Indivitual Result</th>
                    </tr>
                </thead>
                <tbody style="background-color:#eaf3f3">
                    <?php
              
                    $object->query = "SELECT *  FROM `tbl_dept_trainee_registration` WHERE `program_id` = 68 AND `exam_cnt` > 1";

                    $mark_result = $object->get_result();
                   // print_r($mark_result);
                    if(!empty($mark_result))
                    {

                        $count = 0;
                        $final_mark = 0;
                        $failCnt = 0;
                        $passCnt = 0;
                        $exam_cnt = 1;
                        $exam_array = [119,120,121,122,123];

                        foreach($mark_result as $mark_row){
                            $count++;
                     

                        //$final_mark= $final_mark + $n;
                        $name=$mark_row['name'];
                        $phone=$mark_row['phone'];
                       
                        $traniee_user_id=$mark_row['user_id'];
                         foreach($exam_array as $exam){
                           //echo $exam;
                            if($mark_row['exam_group'] != $exam){
                                echo $exam;
                                 $object->query = "SELECT *  FROM `tbl_trainee_exam_info` WHERE `exam_id` = $exam AND `trainee_id` = $traniee_user_id";
                                $dup_result = $object->get_result();
//print_r($dup_result);
                                foreach($dup_result as $dup){
                                    if($dup['exam_status']==1){
                                         $object->query="UPDATE `mdrafm`.`tbl_trainee_exam_info` SET `exam_status` = '0' WHERE `tbl_trainee_exam_info`.`id` = ".$dup['id'];
                                        $object->execute();
                                    }
                                }
                            }
                         }
                          $object->query="UPDATE `mdrafm`.`tbl_dept_trainee_registration` SET `exam_cnt` = 1 WHERE `tbl_dept_trainee_registration`.`id` =".$mark_row['id'];
                         $object->execute();
                         //exit;
                       
                        ?>
                    <tr>


                        <td><?php echo $count ?></td>
                        <td><?php echo $name ?></td>
                        <td><?php echo $phone ?></td>
                        <td><?php echo $mark_row['exam_group']?></td>
                        <td><?php echo $mark_row['mark'] ?></td>
                        <td>
                          
                        </td>
                    </tr>
                    <?php
                
                        }
                      

                    }
                  ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

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


<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>
    function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('exam_result');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('TraineeList.' + (type || 'xlsx')));
    }
function get_indivitual_result(exam_id, user_id, name, exam_category) { 
    $.ajax({
        method: "POST",
        url: "view_exam_result.php",
        data: {
            'exam_id': exam_id,
            'user_id': user_id,
            'name': name,
            'exam_category':exam_category
        },
        success: function(res) {
            console.log(res);

            $('#tbl_result_div').html(res);
            $('#modal_exam_result').modal('show');
            //$('#book_table').DataTable();
            //update();
            //$('#detailsModal_27').modal('hide');

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