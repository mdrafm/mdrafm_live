<?php
include('database.php');
$object = new database();
 
//$name=$_POST['name'];  

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}

include('header.php');
//print_r($_SESSION);
$exam_id=$_POST['exam_id']; 
$user_id=$_POST['user_id'];  
$name = $object->get_userNameById($user_id)   
?>
<span id="error"></span>
<!-- Page Heading -->
<!-- DataTales Example -->
<span id="message"></span>

<?php
  //print_r($_POST);
  $exam_name = '';
  $paper_name = '';
  $final_mark = $object->get_final_mark($user_id,$exam_id);
  
  $exam_category = 3;
   $object->query = "
   SELECT m.exam_title,m.exam_duration,m.total_question,m.marks_per_right_answer,m.exam_date_time,p.prg_name FROM `tbl_exam_master` m 
    JOIN `tbl_short_program_master` p ON m.program_id = p.id
    
    WHERE m.id = ".$exam_id;

    $exam_result = $object->get_result();
    //print_r($exam_result);
    foreach($exam_result as $exam_row){
       // print_r($exam_row);
        $exam_name = $exam_row['exam_title'];
       // $exam_duration = $exam_row['exam_duration'];
        $total_question = $exam_row['total_question'];
        //$paper_name =$exam_row['paper'];
         $exam_time = date(' d/m/Y h:i A', strtotime($exam_row['exam_date_time']));
         $hours = floor($exam_row['exam_duration'] / 60);
         $min =$exam_row['exam_duration'] - floor($exam_row['exam_duration'] / 60) * 60;
         $hour =  ($hours!= 0)?$hours.' Hour':'';
         $minuts = ($min != 0)?$min.' Minuts':'';

         $duration =$hour .' '.$minuts  ;
         $total_mark = $exam_row['total_question'] * $exam_row['marks_per_right_answer'];
    }


?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
       

        <div class="row">
            <label >Name :</label> 
            <p style="color:#1a1818">
               &nbsp;&nbsp; <b><?php echo $name; ?></b>
            </p>
        </div>
        <div class="row">
            <label > Exam Name :</label> 
            <p style="color:#1a1818">
               &nbsp;&nbsp; <b><?php echo $exam_name; ?></b>
            </p>
        </div>
         <div class="row">
            <label > Exam Time :</label> 
            <p style="color:#1a1818">
               &nbsp;&nbsp; <b><?php echo $exam_time; ?></b>
            </p>
        </div>
        <div class="row">
            <label > Exam Duration :</label> 
            <p style="color:#1a1818">
               &nbsp;&nbsp; <b><?php echo $duration; ?></b>
            </p>
        </div>
         <div class="row">
            <label > Total Questions :</label> 
            <p style="color:#1a1818">
               &nbsp;&nbsp; <b><?php echo $total_question; ?></b>
            </p>
        </div>
        <div class="row">
            <label > Total Mark :</label> 
            <p style="color:#1a1818">
               &nbsp;&nbsp; <b><?php echo $total_mark; ?></b>
            </p>
        </div>
        <div class="row">
            <label > Mark Sucured :</label> 
            <p style="color:#1a1818">
               &nbsp;&nbsp; <b><?php echo $final_mark; ?> </b>
            </p>
        </div>
         
    </div>
</div>
    
        <div class="table-responsive" >
        
                  <?php
                   
                  if($exam_category == 3){
                    $qstn_tbl = 'surprise_test_question';
                  }else{
                     $qstn_tbl = 'exam_subject_question';
                  }
                  
                    $object->query = "
                    SELECT i.id,q.exam_subject_question_id,q.exam_subject_question_title,q.exam_subject_question_answer,a.trainee_ans_option,a.marks,a.status as ans_status FROM `tbl_trainee_exam_info` i 
                    JOIN `tbl_exam_question_answer` a ON i.id = a.trainee_exam_info_id
                    JOIN `$qstn_tbl` q ON a.exam_question_id =  q.exam_subject_question_id 
                    WHERE i.exam_id = '".$exam_id."' AND i.trainee_id = '".$user_id."'
                    ";

                    

                    $mark_result = $object->get_result();
                    //print_r($mark_result);
                    $count = 0;
                   
                    ?>
                      <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5>Answer Paper</h5>
                        </div>
                        <div class="card-body">
                            
                        
                    <?php
                    $r_ans='';
                    $g_ans='';
                    $i_ans='';
                    foreach($mark_result as $mark_row){
                       // print_r($mark_row);
                        $option1= $object->Get_surprise_question_option_data($mark_row['exam_subject_question_id'], 1);
                        $option2 = $object->Get_surprise_question_option_data($mark_row['exam_subject_question_id'], 2);
                        $option3 = $object->Get_surprise_question_option_data($mark_row['exam_subject_question_id'], 3);
                        $option4 = $object->Get_surprise_question_option_data($mark_row['exam_subject_question_id'], 4);
                        $count++;
                         $n = (int)($mark_row['marks']) ;
                       $final_mark= $final_mark + $n;

                        switch ($mark_row['exam_subject_question_answer']) {
                            case '1':
                                $r_ans = 'A';
                                break;
                            case '2':
                                $r_ans = 'B';
                                break;
                            case '3':
                                $r_ans = 'C';
                                break;
                            case '4':
                                $r_ans = 'D';
                                break;
                            default:
                                // code...
                                break;
                        }
                        switch ($mark_row['trainee_ans_option']) {
                            case '1':
                                $g_ans = 'A';
                                break;
                            case '2':
                                $g_ans = 'B';
                                break;
                            case '3':
                                $g_ans = 'C';
                                break;
                            case '4':
                                $g_ans = 'D';
                                break;
                            default:
                                // code...
                                break;
                        }
                        switch ($mark_row['marks']) {
                                
                                case '+1':
                                   $i_ans = 'Correct';
                                   $color= '#0cb347';
                                    break;
                                case '0':
                                  $i_ans = 'Wrong';
                                   $color= 'red';
                                    break;
                                default:
                                   $i_ans ='Not attended';
                                    $color= '#a3660b';
                                    break;
                            }

                       ?>
                       <div class="ans_div" 
                       style="border: 1px solid #958c8c;border-radius: 7px;padding: 10px;margin-top: 5px;"
                       >
                         <p>Question <?php echo $count ?>. <span><?php echo $mark_row['exam_subject_question_title'] ?></span></p>
                         <p>Options</p>
                             <div class="row m-2">
                                 <p class="col-md-6">A. <span><?php echo $option1 ?></span></p>
                                 <p class="col-md-6">B. <span><?php echo $option2 ?></span></p>
                             </div> 
                             <div class="row m-2">
                                 <p class="col-md-6">C. <span><?php echo $option3 ?></span></p>
                                 <p class="col-md-6">D. <span><?php echo $option4 ?></span></p>
                             </div> 
                            <div class="row">
                               <p style="padding: 4px;border-radius: 5px;margin-left: 10px;background: #0c47b3 ;color: #fff;" >Answer- <?php echo $r_ans ?> </p> 
                               <p style="padding: 4px;border-radius: 5px;margin-left: 10px;background: #cb6f11;color: #fff;" >Given Option - <?php echo $g_ans ?> </p> 
                               <p style="padding: 4px;border-radius: 5px;margin-left: 10px;background:<?php echo $color ?>;color: #fff;" ><?php echo $i_ans ?> </p> 

                            </div>
                        </div>
                       <?php
                   }
                     ?>
                     </div>
                    </div>
                     
        </div>
  





<script>

// $(document).ready(function() {
//        $('#exam_table').DataTable();
// });


</script>