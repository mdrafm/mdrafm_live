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
                        <th>User Id</th>
                        <th>Exam cnt </th>
                        <th>Exam 1</th>
                        <th>Exam 2</th>
                        <th>Exam 3</th>
                        <th>Exam 4</th>
                        <th>Exam 5</th>
                        
                    </tr>
                </thead>
                <tbody style="background-color:#eaf3f3">
                    <?php
              
                    $object->query = "SELECT trainee_id,exam_id,count(*)as cnt FROM
                          (SELECT trainee_id,exam_id FROM `tbl_trainee_exam_info` WHERE `exam_id` = 119 AND `exam_status` = 1
                          UNION ALL
                          SELECT trainee_id,exam_id FROM `tbl_trainee_exam_info` WHERE `exam_id` = 120 AND `exam_status` = 1
                          UNION ALL
                          SELECT trainee_id,exam_id FROM `tbl_trainee_exam_info` WHERE `exam_id` = 121 AND `exam_status` = 1
                          UNION ALL
                          SELECT trainee_id,exam_id FROM `tbl_trainee_exam_info` WHERE `exam_id` = 122 AND `exam_status` = 1
                          UNION ALL
                          SELECT trainee_id,exam_id FROM `tbl_trainee_exam_info` WHERE `exam_id` = 123 AND `exam_status` = 1)AS combined
                          group by trainee_id HAVING count(*)>1
                          ";

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
                     

                        //$final_mark= $final_mark + $n;
                        $trainee_id=$mark_row['trainee_id'];
                        $cnt=$mark_row['cnt'];
                       
                       // $traniee_user_id=$mark_row['user_id'];
//                          foreach($exam_array as $exam){
//                            //echo $exam;
//                             if($mark_row['exam_group'] != $exam){
//                                 echo $exam;
//                                  $object->query = "SELECT *  FROM `tbl_trainee_exam_info` WHERE `exam_id` = $exam AND `trainee_id` = $traniee_user_id";
//                                 $dup_result = $object->get_result();
// //print_r($dup_result);
//                                 foreach($dup_result as $dup){
//                                     if($dup['exam_status']==1){
//                                          $object->query="UPDATE `mdrafm`.`tbl_trainee_exam_info` SET `exam_status` = '0' WHERE `tbl_trainee_exam_info`.`id` = ".$dup['id'];
//                                         $object->execute();
//                                     }
//                                 }
//                             }
//                          }
                         //  $object->query="UPDATE `mdrafm`.`tbl_dept_trainee_registration` SET `exam_cnt` = 1 WHERE `tbl_dept_trainee_registration`.`id` =".$mark_row['id'];
                         // $object->execute();
                         //exit;
                       
                        ?>
                    <tr>


                        <td><?php echo $count ?></td>
                        <td><?php echo $trainee_id ?></td>
                        <td><?php echo $cnt ?></td>
                        <td> <?php

                               $object->query = "SELECT *  FROM `tbl_trainee_exam_info` WHERE `exam_id` = 119 AND `trainee_id` = $trainee_id";
                                $exam1_res = $object->get_result();
                                foreach($exam1_res as $exam1){
                                    echo $exam1['exam_status'].'<br>';

                                     $object->query = "SELECT sum(marks)as total_mark FROM `tbl_exam_question_answer` WHERE `trainee_exam_info_id` =".$exam1['id'];

                                   $mark_result = $object->get_result();
                                   $totalMark=0;
                                   foreach($mark_result as $res){
                                    echo 'totalMark- '.$totalMark= $res['total_mark'];
                                   }
                                    
                                   
                                }
                           
                         ?> <br><button class="btn btn-success btn-sm" onclick="save(<?php echo $trainee_id ?>,<?php echo $exam1['id'] ?>,<?php echo $res['total_mark']; ?>,119)">Save</button> 
                            <button class="btn btn-danger btn-sm" onclick="remove(<?php echo $trainee_id ?>,<?php echo $exam1['id'] ?>)">Remove</button> </td>
                        <td>
                            <?php
                       
                               $object->query = "SELECT *  FROM `tbl_trainee_exam_info` WHERE `exam_id` = 120 AND `trainee_id` = $trainee_id";
                                $exam2_res = $object->get_result();
                                foreach($exam2_res as $exam2){
                                    echo $exam2['exam_status'].'<br>';

                                    $object->query = "SELECT sum(marks)as total_mark FROM `tbl_exam_question_answer` WHERE `trainee_exam_info_id` =".$exam2['id'];

                                   $mark_result2 = $object->get_result();
                                   $totalMark=0;
                                   foreach($mark_result2 as $res2){
                                    echo 'totalMark- '.$totalMark= $res2['total_mark'];
                                   }
                                }
                           
                         ?> 
                         <br><button class="btn btn-success btn-sm" onclick="save(<?php echo $trainee_id ?>,<?php echo $exam2['id'] ?>,<?php echo $res2['total_mark']; ?>,120)">Save</button> 
                            <button class="btn btn-danger btn-sm" onclick="remove(<?php echo $trainee_id ?>,<?php echo $exam2['id'] ?>)">Remove</button>
                        </td>
                        
                         <td>
                             <?php
                       
                               $object->query = "SELECT *  FROM `tbl_trainee_exam_info` WHERE `exam_id` = 121 AND `trainee_id` = $trainee_id";
                                $exam3_res = $object->get_result();
                                foreach($exam3_res as $exam3){
                                    echo $exam3['exam_status'].'<br>';

                                    $object->query = "SELECT sum(marks)as total_mark FROM `tbl_exam_question_answer` WHERE `trainee_exam_info_id` =".$exam3['id'];

                                   $mark_result3 = $object->get_result();
                                   $totalMark=0;
                                   foreach($mark_result3 as $res3){
                                    echo 'totalMark- '.$totalMark= $res3['total_mark'];
                                   }
                                }
                           
                         ?> 
                         <br><button class="btn btn-success btn-sm" onclick="save(<?php echo $trainee_id ?>,<?php echo $exam3['id'] ?>,<?php echo $res3['total_mark']; ?>,121)">Save</button> 
                            <button class="btn btn-danger btn-sm" onclick="remove(<?php echo $trainee_id ?>,<?php echo $exam3['id'] ?>)">Remove</button>
                         </td>
                        <td>
                          <?php
                       
                               $object->query = "SELECT *  FROM `tbl_trainee_exam_info` WHERE `exam_id` = 122 AND `trainee_id` = $trainee_id";
                                $exam4_res = $object->get_result();
                                foreach($exam4_res as $exam4){
                                    echo $exam4['exam_status'].'<br>';

                                    $object->query = "SELECT sum(marks)as total_mark FROM `tbl_exam_question_answer` WHERE `trainee_exam_info_id` =".$exam4['id'];

                                   $mark_result4 = $object->get_result();
                                   $totalMark=0;
                                   foreach($mark_result4 as $res4){
                                    echo 'totalMark- '.$totalMark= $res4['total_mark'];
                                   }
                                }
                           
                         ?> 
                         <br><button class="btn btn-success btn-sm" onclick="save(<?php echo $trainee_id ?>,<?php echo $exam4['id'] ?>,<?php echo $res4['total_mark']; ?>,122)">Save</button> 
                            <button class="btn btn-danger btn-sm" onclick="remove(<?php echo $trainee_id ?>,<?php echo $exam4['id'] ?>)">Remove</button>
                        </td>
                        <td>
                          <?php
                       
                               $object->query = "SELECT *  FROM `tbl_trainee_exam_info` WHERE `exam_id` = 123 AND `trainee_id` = $trainee_id";
                                $exam5_res = $object->get_result();
                                foreach($exam5_res as $exam5){
                                    echo $exam5['exam_status'].'<br>';

                                    $object->query = "SELECT sum(marks)as total_mark FROM `tbl_exam_question_answer` WHERE `trainee_exam_info_id` =".$exam5['id'];

                                   $mark_result5 = $object->get_result();
                                   $totalMark=0;
                                   foreach($mark_result5 as $res5){
                                    echo 'totalMark- '.$totalMark= $res5['total_mark'];
                                   }
                                }
                           
                         ?> 
                         <br><button class="btn btn-success btn-sm" onclick="save(<?php echo $trainee_id ?>,<?php echo $exam5['id'] ?>,<?php echo $res5['total_mark']; ?>,123)">Save</button> 
                            <button class="btn btn-danger btn-sm" onclick="remove(<?php echo $trainee_id ?>,<?php echo $exam5['id'] ?>)">Remove</button>
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

<?php
  function totalMark($traine_info_id){
           $object->query = "SELECT sum(marks)as total_mark FROM `tbl_exam_question_answer` WHERE `trainee_exam_info_id` =".$traine_info_id;

           $mark_result = $object->get_result();
           $totalMark=0;
           foreach($mark_result as $res){
            $totalMark= $res['total_mark'];
           }
           
return $totalMark;
  }

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


<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>
    function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('exam_result');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('TraineeList.' + (type || 'xlsx')));
    }
function save(user_id, trainee_info_id,mark,exam_group) { 
    $.ajax({
        method: "POST",
        url: "ajax_multi.php",
        data: {
            'user_id': user_id,
            'trainee_info_id': trainee_info_id,
            'mark':mark,
            'exam_group':exam_group,
            'action':'save'
        },
        success: function(res) {
            console.log(res);

          

        }
    })

}
function remove(user_id, trainee_info_id) { 
    $.ajax({
        method: "POST",
        url: "ajax_multi.php",
        data: {
            'user_id': user_id,
            'trainee_info_id': trainee_info_id,
            
            'action':'remove'
        },
        success: function(res) {
            console.log(res);

          

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