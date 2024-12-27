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
  //print_r($_POST);
  if(!empty($_POST['exam_id']))
  {
    $_SESSION['exam_id']='';
    $get_exam_id=$_POST['exam_id'];
  }else{
    $get_exam_id=$_SESSION['exam_id'];
  }
  $_SESSION['exam_id'] = $get_exam_id;
  $post_exam_id=$_SESSION["exam_id"];
  $exam_category = $_POST['exam_category'];
 //$exam_category = 3;
  $exam_name = '';
  $paper_name = '';
  $prog_table = '';
  $program_id=$_POST['program_id'];
if($exam_category == 1){
     $result_url = 'long_result_pdf.php';
 $object->query = "
   SELECT m.exam_title,p.prg_name,CONCAT(a.paper_code, ' ',a.title) as paper FROM `tbl_exam_master` m 
    JOIN `tbl_program_master` p ON m.program_id = p.id
    JOIN `tbl_paper_master` a ON m.paper_id = a.id
    WHERE m.id = ".$post_exam_id;
}elseif($exam_category == 2){
     $result_url = 'mid_result_pdf.php';
    $object->query = "
    SELECT m.exam_title,p.prg_name,a.paper_code as paper FROM `tbl_exam_master` m 
     JOIN `tbl_mid_program_master` p ON m.program_id = p.id
     JOIN `tbl_mid_paper_master` a ON m.paper_id = a.id
     WHERE m.id = ".$post_exam_id;
}else{

    $result_url = 'long_result_pdf.php';
    if(isset($_POST['trng_type'])){

        if($_POST['trng_type'] == 1){

            $prog_table = 'tbl_program_master';
             }elseif($_POST['trng_type'] == 3){

                   $prog_table = 'tbl_mid_program_master';
             }else{

                     $prog_table = 'tbl_short_program_master';
             }

             $object->query = "
                SELECT m.exam_title,p.prg_name FROM `tbl_exam_master` m 
                 JOIN $prog_table p ON m.program_id = p.id
                
                 WHERE m.id = ".$post_exam_id;
    }
    
}
  

    $exam_result = $object->get_result();
   // print_r($exam_result);
    if(!empty($exam_result))
    {
     foreach($exam_result as $exam_row){
        $exam_name = $exam_row['exam_title']; 
        $paper_name =$exam_row['paper'];
    }
    }
?>
<div>
    <button type="button" class="btn btn-primary" style="float: right;"
        onclick="datapost('<?php echo $result_url; ?>',{exam_id: <?php echo $post_exam_id ?>,program_id: 68})">Print</button>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold" style="color:#0c49fb"> Exam Name : <?php echo $exam_name; ?></h6>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <h6 class="m-0 font-weight-bold" style="color:#0c49fb"> Paper Name : <?php echo $paper_name; ?></h6>
            </div>

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
                        <th> Name</th>
                         <th> Office Address</th>
                        <th>Phone No.</th>
                        <th>Total Mark</th>
                        <th>Remark</th>
                        <th>Indivitual Result</th>
                    </tr>
                </thead>
                <tbody style="background-color:#eaf3f3">
                    <?php
                  if($exam_category == 1){
                    $object->query = "
                    SELECT tbl_trainee_info.user_id, CONCAT( tbl_trainee_info.f_name ,' ',tbl_trainee_info.l_name) as name,tbl_trainee_info.phone,sum(tbl_qs_ans.marks) as tot_mark 
                    FROM `tbl_new_recruite` tbl_trainee_info
                    join tbl_trainee_exam_info tbl_exm_inf on tbl_exm_inf.trainee_id = tbl_trainee_info.user_id 
                    join tbl_exam_question_answer as tbl_qs_ans on  tbl_qs_ans.trainee_exam_info_id=tbl_exm_inf.id
 
                    WHERE tbl_exm_inf.exam_status = 1 AND tbl_exm_inf.exam_id = '".$post_exam_id."'
                    group by tbl_qs_ans.trainee_exam_info_id
                            ";
                  }else if($exam_category == 2){
                    $object->query = "
                    SELECT tbl_trainee_info.user_id,tbl_trainee_info.name,tbl_trainee_info.phone,sum(tbl_qs_ans.marks) as tot_mark 
                    FROM `tbl_dept_trainee_registration` tbl_trainee_info
                    join tbl_trainee_exam_info tbl_exm_inf on tbl_exm_inf.trainee_id = tbl_trainee_info.user_id 
                    join tbl_exam_question_answer as tbl_qs_ans on  tbl_qs_ans.trainee_exam_info_id=tbl_exm_inf.id
 
                    WHERE tbl_exm_inf.exam_status = 1 AND tbl_exm_inf.exam_id = '".$post_exam_id."'  AND tbl_trainee_info.trng_type =3
                    group by tbl_qs_ans.trainee_exam_info_id";
                  }else{
                   
                     if($_POST['trng_type'] == 1){
                     $object->query = "
                            SELECT tbl_trainee_info.user_id, CONCAT( tbl_trainee_info.f_name ,' ',tbl_trainee_info.l_name) as name,tbl_trainee_info.phone,sum(tbl_qs_ans.marks) as tot_mark 
                            FROM tbl_new_recruite tbl_trainee_info
                            join tbl_trainee_exam_info tbl_exm_inf on tbl_exm_inf.trainee_id = tbl_trainee_info.user_id 
                            join tbl_exam_question_answer as tbl_qs_ans on  tbl_qs_ans.trainee_exam_info_id=tbl_exm_inf.id
         
                            WHERE tbl_exm_inf.exam_status = 1 AND tbl_exm_inf.exam_id = '".$post_exam_id."'
                            group by tbl_qs_ans.trainee_exam_info_id ";
                     }else{

                           $object->query = "
                            SELECT tbl_exm_inf.id,tbl_trainee_info.id as dept_id,tbl_trainee_info.user_id,tbl_trainee_info.office_name,tbl_trainee_info.name,tbl_trainee_info.exam_cnt,tbl_trainee_info.phone,sum(tbl_qs_ans.marks) as tot_mark 
                            FROM `tbl_dept_trainee_registration` tbl_trainee_info
                            join tbl_trainee_exam_info tbl_exm_inf on tbl_exm_inf.trainee_id = tbl_trainee_info.user_id 
                            join tbl_exam_question_answer as tbl_qs_ans on  tbl_qs_ans.trainee_exam_info_id=tbl_exm_inf.id
         
                            WHERE tbl_exm_inf.exam_status = 1 AND tbl_exm_inf.exam_id = '".$post_exam_id."' 
                            group by tbl_qs_ans.trainee_exam_info_id";
                     }
                   
                  }

                    $mark_result = $object->get_result();
                   // print_r($mark_result);
                    if(!empty($mark_result))
                    {

                        $count = 0;
                        $final_mark = 0;
                        $failCnt = 0;
                        $passCnt = 0;
                        $exam_cnt = 1;
                        foreach($mark_result as $mark_row){
                            $count++;
                            //echo ($mark_row['dept_id']) ;
                        $exam_cnt = $exam_cnt +$mark_row['exam_cnt'];

                        //$final_mark= $final_mark + $n;
                        $name=$mark_row['name'];
                        $phone=$mark_row['phone'];
                        $tot_mark=$mark_row['tot_mark'];
                        $traniee_user_id=$mark_row['user_id'];
                        $final_mark = $final_mark + $tot_mark;
                        $exam_id=$post_exam_id;

                         // $object->query="UPDATE `mdrafm`.`tbl_dept_trainee_registration` SET `exam_cnt` = $exam_cnt WHERE `tbl_dept_trainee_registration`.`id` =".$mark_row['dept_id'];
                         // $object->execute();
                        if($tot_mark <25){
                          $failCnt++;
                        }else{
                          $passCnt ++;
                        }
                   
                       
                        ?>
                    <tr>


                        <td><?php echo $count ?></td>
                        <td><?php echo $name ?></td>
                        <td><?php echo  $mark_row['office_name']; ?></td>
                        <td><?php echo $phone ?></td>
                        <td><?php echo $tot_mark ?></td>
                        <td><?php echo ($tot_mark <25)?'Fail':'Pass'; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning"
                                onclick="get_indivitual_result(<?=$exam_id?>,<?=$traniee_user_id?>,'<?=$name?>',<?= $exam_category ?>)">View</button>
                        </td>
                    </tr>
                    <?php
                
                        }
                        echo ('Total -'.$count);
                        echo '<br>';
                        echo ('Faill -'.$failCnt);
                        echo '<br>';
                        echo ('Pass  -'.$passCnt);

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