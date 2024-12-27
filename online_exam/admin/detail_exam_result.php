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
<h1 class="h3 mb-4 text-gray-800">Exam Result</h1>

<!-- DataTales Example -->
<span id="message"></span>

<?php
  //print_r($_POST);
  $exam_id = 4;
  $exam_name = '';
  $paper_name = '';

   $object->query = "
   SELECT m.exam_title,p.prg_name,CONCAT(a.paper_code, ' ',a.title) as paper FROM `tbl_exam_master` m 
    JOIN `tbl_program_master` p ON m.program_id = p.id
    JOIN `tbl_paper_master` a ON m.paper_id = a.id
    WHERE m.id = ".$exam_id;

    $exam_result = $object->get_result();
    foreach($exam_result as $exam_row){
        $exam_name = $exam_row['exam_title'];
        $paper_name =$exam_row['paper'];
    }
?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary"> Exam Name : <?php echo $exam_name; ?></h6>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <h6 class="m-0 font-weight-bold text-primary"> Paper Name : <?php echo $paper_name; ?></h6>
            </div>
           
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive">
        <table class="table table-bordered" id="exam_result" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Question Name</th>
                        <th>Answer</th>
                        <th>Mark</th>
                       
                    </tr>
                </thead>
                <tbody>
                  <?php
                    $object->query = "
                    SELECT i.id,q.exam_subject_question_title,a.marks,a.status as ans_status FROM `tbl_trainee_exam_info` i 
                    JOIN `tbl_exam_question_answer` a ON i.id = a.trainee_exam_info_id
                    JOIN `exam_subject_question` q ON a.exam_question_id =  q.exam_subject_question_id 
                    WHERE i.exam_id = '".$exam_id."' AND i.trainee_id = '".$_SESSION["user_id"]."'
                    ";

                    $mark_result = $object->get_result();
                    $count = 0;
                    $final_mark = 0;
                    foreach($mark_result as $mark_row){
                        $count++;
                         $n = (int)($mark_row['marks']) ;
                       $final_mark= $final_mark + $n;
                     ?>
                     <tr>

                    
                        <td><?php echo $count ?></td>
                        <td><?php echo $mark_row['exam_subject_question_title'] ?></td>
                        <td>
                            <?php 
                            
                            switch ($mark_row['marks']) {
                                
                                case '+1':
                                    echo '<span class="text-success" > Correct</span>';
                                    break;
                                case '-1':
                                    echo '<span class="text-danger" > Wrong</span>';
                                    break;
                                default:
                                    echo '<span class="text-warning" >Not attened</span>';
                                    break;
                            }
                            ?>
                        </td>

                        <td><?php echo $mark_row['marks'] ?></td>
                        </tr>
                     <?php
                    }
                    
                    echo '<tr>
                         <td></td>
                         <td></td>
                         <td>Total</td>
                         <td>'. $final_mark.'</td>
                    <tr>';
                  ?>
                </tbody>
            </table> 
        </div>
    </div>
</div>


<?php
                include('footer.php');
                ?>



<script>

$(document).ready(function() {
       $('#exam_table').DataTable();

    // var dataTable = $('#exam_table').DataTable({
    //         "processing" : true,
    //         "serverSide" : true,
    //         "bDestroy": true,
    //         "serverMethod":'post',
    //         "order" : [],
    //         "ajax" : {
    //             url:"examiner_exam_shedule_list_action.php",
    //             type:"POST",
    //             data:{action:'fetch'}
    //         },
    //         "column":[
    //             {
    //                 "targets":[3, 4, 5, 6, 7, 8],
    //                 "orderable":false,
    //             },
    //         ],
    //     });

});


</script>