 <!DOCTYPE html>
<html lang="en">


<head>
    <?php 
    
    include('header_link.php');
    include('../config.php');
    include 'database.php';
    $db = new Database();
    ?>
<style type="text/css">
    .rd{
        width: 0.8rem;
    }
    .fdName{
       
        font-size: 0.9rem;
    }
</style>
</head>

<body class="user-profile">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="wrapper ">

        <?php include('sidebar.php'); ?>

        <div class="main-panel" id="main-panel">
            <?php include('navbar.php'); ?>

            <div class="panel-header panel-header-sm">


            </div>

              <div class="alert_msg" id="alert_msg" style="margin-left:10%"></div>
            <div class="content" style="margin-top: 50px;">


                <div class="row" style="margin-top:20px">
                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-body">
                                <h3> Class Feedback</h3>
                                <div class="row">

                                    <div id="class_tbl" class=" table table-responsive table-striped table-hover"
                                        style="width:95%;margin:0px auto">
                                        <table class=" term table" id="tableid">
                                            <thead class="" style="background: #315682;color:#fff;font-size: 11px;">
                                                <th style=""><input type="checkbox" id="checkAll">All Select</th>
                                                <th style="">Sl No</th>
                                                <!-- <th style="text-align:center;">Date</th> -->
                                                <th style="text-align:center;"> Date & Subject</th>
                                               <!--  <th style="text-align:center;">Faculty</th> -->
                                                <th style="text-align:center;">Feadback</th>
                                                <th style="text-align:center;">Action</th>


                                            </thead>
                                            <tbody>
                                                <?php
                                                $table_range_id = $_POST['tbl_range_id'];
                                              $count = 0;
                                              if($trng_type == 5){
                                                $sql = "SELECT t.id,t.training_dt,t.faculty_name,t.paper_covered as subject  FROM `tbl_sponsored_time_table` t
                                                WHERE t.period_type = 1 AND t.other_class = 0 AND t.`table_range_id` = (SELECT id FROM `tbl_time_table_range` WHERE program_id = $prog_id AND type = $trng_type)  ";

                                              }
                                                else if($trng_type == 1){

                                                   $sql2 = "SELECT *  FROM `tbl_dept_trainee_registration` 
                                               
                                                      WHERE  phone =".$_SESSION['username'];

                                                    $db->select_sql($sql2);
                                                  $trainee = $db->getResult();
                                                  //  print_r($trainee[0] );
                                                     $prog_id =  $trainee[0]['program_id'];
                                                     $trng_type = $trainee[0]['trng_type'];

                                                    $sql = "SELECT t.id,t.training_dt,t.paper_covered as subject  FROM `tbl_inhouse_time_table` t
                                               
                                                WHERE t.period_type = 1 AND t.other_class = 0 AND t.`table_range_id` = (SELECT id FROM `tbl_time_table_range` WHERE program_id = $prog_id AND type = $trng_type)  ";
                                                }
                                              else{

                                                // $sql = "SELECT t.id,t.training_dt,f.name,t.paper_covered as subject  FROM `tbl_inhouse_time_table` t
                                                // JOIN `tbl_faculty_master` f ON t.faculty_id = f.id
                                                // WHERE  t.`table_range_id` = (SELECT id FROM `tbl_time_table_range` WHERE program_id = $prog_id AND type = $trng_type)  ";

                                                 $sql = "SELECT t.id,t.training_dt,t.paper_covered as subject  FROM `tbl_inhouse_time_table` t
                                               
                                                WHERE t.period_type = 1 AND t.other_class = 0 AND t.table_range_id = $table_range_id AND t.program_id = $prog_id";

                                              }
                                            
                                             // echo $sql ; 

                                               $db->select_sql($sql);
                                               foreach($db->getResult() as $row ){
                                                   //print_r($row);
                                                   $id = $row['id'];
                                                   $user_id = $_SESSION['user_id'];
                                                   $count++;
                                                   ?>
                                                <tr>
                                                <?php
                                                           
                                                    $db->select('tbl_mid_cls_feedback',"time_tbl_id,feedback",null,"time_tbl_id = $id AND user_id = $user_id ",null,null);
                                                    $feedback = $db->getResult();
                                        
                                                    $disp='style="display:block"';
                                                            if($feedback)
                                                                {
                                                                   $disp='style="display:none"';
                                                                }
                                                                ?>
                                                    <td><input type="checkbox" class="chk_box" value="<?php echo $id;?>" id="chk_<?php echo $id;?>" <?php echo $disp;?>></td>
                                                    <td><?php echo $count; ?></td>
                                                   <!--  <td><?php echo date("d-m-Y", strtotime($row['training_dt']) )  ?>
                                                    </td> -->
                                                    <td><?php echo date("d-m-Y", strtotime($row['training_dt']) ).'<br> <br>'.$row['subject'] ?></td>
                                                   <?php
                                                           //print_r($feedback);
                                                           if($feedback){

                                                            foreach($feedback as $slctFeedback){
                                                                echo '<td style="text-align:center;">';
                                                                switch($slctFeedback['feedback']){
                                                                       case '5':
                                                                        echo "Excellent";
                                                                        break;
                                                                       case '4':
                                                                        echo "Very Good";
                                                                        break;
                                                                       case '3':
                                                                        echo "Good";
                                                                        break;
                                                                       case '2':
                                                                        echo "Average";
                                                                        break;
                                                                       case '1':
                                                                        echo "Needs Improvement";
                                                                        break;
                                                                       
                                                                }
                                                                echo '</td>';
                                                            }
                                                            echo '<td></td>';
                                                           }else{
                                                             ?>
                                                    <td class="d-flex ">
                                                        <div >
                                                            <div class="form-check form-check-inline" >
                                                                <input class="form-check-input rd" type="radio"
                                                                    name="feedback_<?php echo $row['id'] ?>" value="5">
                                                                <label class="form-check-label fdName"
                                                                    for="inlineRadio1" >Excellent</label>
                                                            </div>
                                                            <div class="form-check form-check-inline"  >
                                                                <input class="form-check-input rd" type="radio"
                                                                    name="feedback_<?php echo $row['id'] ?>" value="4">
                                                                <label class="form-check-label fdName" for="inlineRadio2"> Very
                                                                    Good</label>
                                                            </div>
                                                            <div class="form-check form-check-inline"  >
                                                                <input class="form-check-input rd" type="radio"
                                                                    name="feedback_<?php echo $row['id'] ?>" value="3">
                                                                <label class="form-check-label fdName"
                                                                    for="inlineRadio3">Good</label>
                                                            </div>
                                                        
                                                            <div class="form-check form-check-inline" >
                                                                <input class="form-check-input rd" type="radio"
                                                                    name="feedback_<?php echo $row['id'] ?>" value="2">
                                                                <label class="form-check-label fdName"
                                                                    for="inlineRadio3" >Average</label>
                                                            </div>
                                                            <div class="form-check form-check-inline"  >
                                                                <input class="form-check-input rd" type="radio"
                                                                    name="feedback_<?php echo $row['id'] ?>" value="1">
                                                                <label class="form-check-label fdName" for="inlineRadio4" >Needs
                                                                    Improvement</label>
                                                            </div>
                                                        </div>


                                                    </td>
                                                    <td> <button class="btn btn-success"
                                                            id="save_<?php echo $row['id'] ?>"
                                                            onclick="sendFeedback(<?php echo $row['id'] ?>,<?php echo $user_id ?>)">Send</button>
                                                    </td>
                                                    <?php
                                                           }
                                                        //    foreach($db->getResult() as $feedback){

                                                        //    }
                                                        
                                                        ?>




                                                </tr>
                                                <?php
                                               }
                                              ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
    <div style="text-align:right"><input type="submit" class="btn btn-warning" name="send_all" onclick="func_send_all(<?php echo $user_id ?>);" value="Send All"></div>
<?php
$suggestion = '';
 $db->select('tbl_mid_cls_suggestation','id,suggestion',null,'user_id = '.$_SESSION['user_id'],null,null);
 foreach($db->getResult() as $sugest_row ){
      $suggestion = $sugest_row['suggestion'];
      $suggest_id  = $sugest_row['id'];
 }

?>
                                <div class="row">
                                    <div class="col-md-10">
                                        <b> What is your suggestion for improving the training program ? </b> <br>
                                        <b>(Max 100 Words)</b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <textarea style="width: 80%;" <?php echo ($suggestion == '')?'':'disabled' ?>
                                         id="suggestion"> <?php echo ($suggestion != '')?$suggestion:'' ?> </textarea>
                                    </div>
                                </div>
                                <div class="row" style="display: <?php echo ($suggestion == '')?'':'none' ?>">
                                    <input type="button" style="margin: 0 auto;" class="btn btn-primary" value='Submit Suggestion'
                                        onclick="save_feedback(<?php echo $prog_id ?>,<?php echo $trng_type ?>,<?php echo $_SESSION['user_id'] ?>)">
                                </div>
                                <div class="row edit_div" style="display: <?php echo ($suggestion == '')?'none':'' ?>">
                                 <p class="text-success" >Feedback submitted Successfully</p>
                                    <input type="button"  class="btn btn-primary" value='Edit Suggestion'  onclick="edit_feedback()"/>
                                </div>
                                <div class="row update_div" style="display: none">
                                   <input type="button" style="" class="btn btn-primary" value='Update Suggestion' onclick="update_feedback(<?php echo $suggest_id ?>)" />
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    </div>

    </div>

    <?php include('common_script.php') ?>

</body>

</html>

<script src="../ckeditor/ckeditor.js"> </script>

<script>
    $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);

});
CKEDITOR.replace('suggestion');
function func_send_all(user_id)
{
    $planSelectValid = false;
    var time_table = [];
    var feedBack = [];

        $('.chk_box:checked').each(function(i) {
            time_table[i] = $(this).val();
            if($('input[name="feedback_'+time_table[i]+'"]').is(':checked')){
                feedBack[i] = $(`input[name="feedback_${time_table[i]}"]:checked`).val();
            } else {
                alert("You have to choose a feedback");
                
            }
        });
        if(time_table.length == feedBack.length)
        {
            $.ajax({
            type: 'POST',
            url: 'ajax_trainee.php',
            data: {
                action: "mul_mid_feedback",
                time_table_id: time_table,
                feedBack: feedBack,
                user_id:user_id
            },
            success: function(res) {
                console.log(res);
                if (res.trim() == 'success'){
                    sessionStorage.message = "Feedback send Successfully";
                    sessionStorage.type = "success";
                    location.reload();
                }

            }
            })
        }
}
function sendFeedback(id,user_id) {
    //let paper_code = $(this).closest('tr').find('.paper_code').text();

    let feedBack = $(`input[name="feedback_${id}"]:checked`).val();

    if (feedBack > 0) {
        $('#save_' + id).attr('value', '...wait');
        $('#save_' + id).attr("disabled", true);

        $.ajax({
            type: 'POST',
            url: 'ajax_trainee.php',
            data: {
                action: "mid_feedback",
                id: id,
                user_id:user_id,
                feedBack: feedBack
            },
            success: function(res) {
                console.log(res);
                if (res.trim() == 'success') {
                    location.reload();
                }

            }
        })
    } else {
        alert("Please select Feadback");
    }

}

function save_feedback(prog_id, trng_type, user_id){
   
    let suggestion =  CKEDITOR.instances['suggestion'].getData(); 
    //alert(suggestion);
    if(suggestion == ''){
        alert('Suggestion box can not be blanck');
        return false;
    }
    else{
         $.ajax({
        url: 'ajax_trainee.php',
        type: "POST",
        data: {
            suggestion: suggestion,
            user_id: user_id,
            program_id: prog_id,
            trng_type: trng_type,
            action: 'cls_feedback_suggest'
        },

        success: function(data) {
            console.log(data);
           
            if (data.trim() == 'success') {
                sessionStorage.message = "Feedback send Successfully";
                sessionStorage.type = "success";
                location.reload();
            }
        }
       });
    }
   
}

function edit_feedback(){
    console.log(123);
    $('#suggestion').prop('disabled',false);
    CKEDITOR.instances['suggestion'].setReadOnly(false);
    $('.edit_div').hide();
    $('.update_div').show();

}
function update_feedback(suggest_id){
    let suggestion =  CKEDITOR.instances['suggestion'].getData(); 

    $.ajax({
        url: 'ajax_trainee.php',
        type: "POST",
        data: {
            suggestion: suggestion,
            suggest_id: suggest_id,
            action: 'edit_cls_feedback_suggest'
        },

        success: function(data) {
            console.log(data);
           
            if (data.trim() == 'success') {
                sessionStorage.message = "Update send Successfully";
                sessionStorage.type = "success";
                location.reload();
            }
        }
    });
}
</script>