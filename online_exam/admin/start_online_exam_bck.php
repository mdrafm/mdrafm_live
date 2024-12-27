<?php

include('database.php');

$object = new database();

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}

include('header_exam.php');


$exam_id = '';
$exam_title = '';
$paper = '';
$exam_duration = '';

$total_question = '';
$marks_per_right_answer = '';
$marks_per_wrong_answer = '';
$subject_exam_start_time = '';
$subject_exam_end_time = '';
$remaining_minutes = '';
$subject_exam_status = '';

$student_name = '';
$student_roll_no = '';
$student_image = '';
$prg_name = '';
$trainee_exam_info_id = '';

if(isset($_SESSION['exam_id'])){

    $object->query = "
    UPDATE tbl_trainee_exam_info 
       SET exam_status = 1
       WHERE exam_id='".$_SESSION['exam_id']."' AND trainee_id = '".$_SESSION['user_id']."' 
    ";


     $object->execute();

    // $object->query = "
    // SELECT m.id,m.exam_title,CONCAT(p.paper_code,' - ',p.title) as paper,pm.prg_name,m.total_question,
    // m.marks_per_right_answer,m.marks_per_wrong_answer,m.status,i.id as trainee_info_id,i.exam_date_time,i.exam_duration,d.photo 
    // FROM `tbl_exam_master` m 
    // JOIN `tbl_paper_master` p ON m.paper_id = p.id
    // JOIN `tbl_program_master` pm ON m.program_id = pm.id
    // JOIN `tbl_trainee_exam_info` i ON m.id = i.exam_id
    // JOIN `tbl_traniee_documents` d ON i.trainee_id = d.user_id

    // WHERE m.id =  '".$_SESSION['exam_id']."' AND i.trainee_id =  '".$_SESSION['user_id']."'
    // ";

    $object->query = "
    SELECT m.id,m.exam_title,p.paper_code as paper,pm.prg_name,m.total_question,
    m.marks_per_right_answer,m.marks_per_wrong_answer,m.status,i.id as trainee_info_id,i.exam_date_time,i.exam_duration,d.name
    FROM `tbl_exam_master` m 
    JOIN `tbl_mid_paper_master` p ON m.paper_id = p.id
    JOIN `tbl_mid_program_master` pm ON m.program_id = pm.id
    JOIN `tbl_trainee_exam_info` i ON m.id = i.exam_id
    JOIN `tbl_dept_trainee_registration` d ON d.user_id= i.trainee_id
   

    WHERE m.id =  '".$_SESSION['exam_id']."' AND i.trainee_id =  '".$_SESSION['user_id']."'
    ";

    $result = $object->get_result();

    foreach($result as $row)
    {
        $exam_id = $row["id"];
        $exam_title = $row["exam_title"];
        $total_question = $row["total_question"];
        $paper = $row["paper"];
        $prg_name = $row["prg_name"];
        $student_image = $row["photo"];
        $exam_duration = $row["exam_duration"];
        $marks_per_right_answer =  $row["exam_duration"];
        $trainee_exam_info_id = $row["trainee_info_id"];

        $marks_per_wrong_answer =  $row["marks_per_wrong_answer"];
        $subject_exam_start_time =  $row["exam_date_time"];
        $subject_exam_end_time = strtotime($subject_exam_start_time . '+' . $exam_duration . ' minute');
        $subject_exam_end_time = date('Y-m-d H:i:s', $subject_exam_end_time);

        $total_second = strtotime($subject_exam_end_time) - strtotime($subject_exam_start_time);
        $remaining_minutes = strtotime($subject_exam_end_time) - time();
        $subject_exam_status = $row["status"];


    }
}
                
?>

<!-- Page Heading -->
<h1 class="h3 mt-4 mb-4 text-gray-800"></h1>

<div class="card shadow mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <b>Exam : </b><?php echo $exam_title; ?>
            </div>
            <div class="col-md-6">
                <b>Paper : </b><?php echo $paper; //$object->Get_Subject_name($subject_id); ?>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-8">
                <div id="single_question_area" class="mb-2"></div>
            </div>
            <div class="col-md-4">
                <!-- timer div -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow " style="padding: unset">
                            <div class="card-header"><b>Student Details</b></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="text-center"><img src="<?php echo $object->base_url."../admin/uploads/".$student_image; ?>"
                                                class="img-fluid img-thumbnail" width="100" /></p>
                                    </div>
                                    <div class="col-md-7">

                                        <b>Name : </b><?php echo $row['name'] ?><br />
                                        <b>Class : </b><?php echo $prg_name ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="exam_timer" data-timer="<?php echo $remaining_minutes; ?>"
                            style="max-width:375px; width: 100%; height: 190px; margin:0 auto"></div>
                    </div>



                </div>
                <!-- question navigation div -->
                <div id="question_navigation_area" class="mb-2"></div>
                <!-- user detail div -->

            </div>
        </div>


    </div>
</div>

<?php
                include('footer.php');
                ?>
<script>
$(document).ready(function() {
    var exam_id = "<?php echo $exam_id; ?>";
    var trainee_exam_info_id = "<?php echo $trainee_exam_info_id; ?>";

    function load_question(question_id = '', exam_id, trainee_exam_info_id) {
        $.ajax({
            url: "../ajax_action.php",
            method: "POST",
            data: {
                exam_id: exam_id,
                trainee_exam_info_id: trainee_exam_info_id,
                question_id: question_id,
                page: 'view_subject_exam',
                action: 'load_question'
            },
            success: function(data) {
                //console.log(data);
                $('#single_question_area').html(data);
            }
        })
    }

    load_question('', exam_id, trainee_exam_info_id);

    question_navigation();



    $(document).on('click', '.next', function() {
        var next_question_id = $(this).attr('id');
        load_question(next_question_id, exam_id, trainee_exam_info_id);
       // console.log(next_question_id);

        var question_id = '';
        var answer_option = '';
        $.each($("input:radio[name='option_1']:checked"), function() {
                question_id = $(this).data('question_id');
                answer_option = $(this).data('id');
          });

          
         if(answer_option !== ''){
            saveAns(question_id,answer_option,1);
         }
          console.log(question_id,answer_option)
    });

    $(document).on('click', '.previous', function() {
        var question_id = $(this).attr('id');
        load_question(question_id, exam_id, trainee_exam_info_id);
    });

    $(document).on('click', '.question_navigation', function() {
        var question_id = $(this).data('question_id');
        load_question(question_id, exam_id, trainee_exam_info_id);
    });
    
     function saveAns(question_id,answer_option,status){
        $.ajax({
            url: "../ajax_action.php",
            method: "POST",
            data: {
                question_id: question_id,
                answer_option: answer_option,
                exam_id: exam_id,
                trainee_exam_info_id: trainee_exam_info_id,
                status:status,
                page: 'view_subject_exam',
                action: 'answer'
            },
            success: function(data) {
                //console.log(data);
                question_navigation();
            }
        });
     }
    // $(document).on('click', '.answer_option', function() {
    //     var question_id = $(this).data('question_id');
    //     var answer_option = $(this).data('id');
    //     $.ajax({
    //         url: "../ajax_action.php",
    //         method: "POST",
    //         data: {
    //             question_id: question_id,
    //             answer_option: answer_option,
    //             exam_id: exam_id,
    //             trainee_exam_info_id: trainee_exam_info_id,
    //             page: 'view_subject_exam',
    //             action: 'answer'
    //         },
    //         success: function(data) {
    //             //console.log(data);
    //             question_navigation();
    //         }
    //     });
    // });
    $(document).on('click', '.review_ans', function() {
       //var ans =  $('input[name="option_1"]').val();
       var next_question_id = $(this).attr('id');
       load_question(next_question_id, exam_id, trainee_exam_info_id);

       var question_id = '';
       var answer_option = '';
       $.each($("input:radio[name='option_1']:checked"), function() {
                question_id = $(this).data('question_id');
                answer_option = $(this).data('id');
          });

          saveAns(question_id,answer_option,2);
          console.log(question_id,answer_option)
    });

    $(document).on('click', '.finish_exam', function() {
        if (confirm("Are you sure to finish exam!!!") == true) {
            $("#exam_timer").TimeCircles().destroy();
            location.href="dashboard.php";
            // atapost('view_exam_result.php', {
            //     exam_id: <?php echo $exam_id ?>
            // });
        }

    });

    function question_navigation() {
        $.ajax({
            url: "../ajax_action.php",
            method: "POST",
            data: {
                exam_id: exam_id,
                trainee_exam_info_id: trainee_exam_info_id,
                page: 'view_subject_exam',
                action: 'question_navigation'
            },
            success: function(data) {
                console.log(data);
                $('#question_navigation_area').html(data);
            }
        })
    }
    $("#exam_timer").TimeCircles({
        "animation": "smooth",
        "bg_width": 0.8,
        "fg_width": 0.05,
        "circle_bg_color": "#eee",
        "time": {
            "Days": {
                "show": false
            },
            "Hours": {
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

    var total_second = "<?php echo $total_second; ?>";
    var remaining_minutes = "<?php echo $remaining_minutes; ?>";
    console.log(total_second);
    console.log(new Date);

    $("#exam_timer").TimeCircles().addListener(function(unit, value, total) {
        if (total < 1) {
            $("#exam_timer").TimeCircles().destroy();
            alert('Exam Time Completed');
             location.href="index.php";
             //datapost('view_exam_result.php',{exam_id: <?php echo $exam_id ?> });
        }
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

});
</script>