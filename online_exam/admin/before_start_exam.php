
<?php

include('database.php');

$object = new database();

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}

include('header_exam.php');



$exam_duration = '';
$subject_exam_start_time = '';
$subject_exam_end_time = '';
$remaining_minutes = '';
$subject_exam_status = '';
$trainee_exam_info_id = '';

if(isset($_SESSION['exam_id'])){
    $object->query = "
    SELECT exam_date_time FROM tbl_trainee_exam_info
    WHERE exam_id =  '".$_SESSION['exam_id']."' AND trainee_id =  '".$_SESSION['user_id']."'
    ";

    $result = $object->get_result();

    foreach($result as $row)
    {
       
        $subject_exam_start_time =  $row["exam_date_time"];
        // $subject_exam_start_time = strtotime($subject_exam_start_time.'minute');
        // $subject_exam_start_time = date('Y-m-d H:i:s', $subject_exam_start_time);
    
         $date_now = date('Y-m-d H:i:s');
       // $difference = date_diff($date_now, $subject_exam_start_time); 
       
        $remaining_minutes =   strtotime($subject_exam_start_time) - strtotime($date_now);
    
       // $remaining_minutes = time() - strtotime($subject_exam_start_time) ;
        
        //exit;

    }
}
                
?>

   <!-- Page Heading -->
   <h1 class="h3 mt-4 mb-4 text-gray-800"></h1>
                    
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <!-- <div class="row">
                                <div class="col-md-6">
                                <b>Exam : </b><?php echo $exam_title; ?>
                                </div>
                                <div class="col-md-6">
                                    <b>Paper : </b><?php echo $paper; //$object->Get_Subject_name($subject_id); ?>
                                </div>
                            </div> -->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div id="single_question_area" class="mb-2 text-center">
                                        <h2>Question paper will be available in scheduled time</h2>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center mt-2 mb-2">
                                        <div id="exam_timer" data-timer="<?php echo $remaining_minutes; ?>" style="max-width:375px; width: 100%; height: 190px; margin:0 auto"></div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                include('footer.php');
                ?>
<script>
$(document).ready(function(){
    
    
    $("#exam_timer").TimeCircles({
        "animation": "smooth",
        "bg_width": 1.2,
        "fg_width": 0.1,
        "circle_bg_color": "#eee",
        "time": {
            "Days":
            {
                "show": false
            },
            "Hours":
            {
                "show": false
            },
            "Minutes": {
                "text": "Minutes",
                "color": "#ffc107",
                "show": true
            },
            "Seconds": {
                "text": "Seconds",
                "color": "#007bff",
                "show": true
            }
        }
    });

    

    $("#exam_timer").TimeCircles().addListener(function(unit, value, total) {
        if(total < 1)
        {
            $("#exam_timer").TimeCircles().destroy();
            location.href="start_online_exam.php";
        }
    });

});
</script>
