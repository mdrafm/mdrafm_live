
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    
    include('header_link.php');
    include('../config.php');
    include 'database.php';
    $db = new Database();

   
    ?>

</head>
<body class="user-profile">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="wrapper ">

        <?php include('sidebar.php'); 
             
           
        ?>
           
        <div class="main-panel" id="main-panel">
            <?php include('navbar.php'); 
            switch ($trng_type) {
                case '3':
                   $prog_tbl = 'tbl_mid_program_master';
                    break;
                case '1':
                $prog_tbl = 'tbl_short_program_master';
                    $sql2 = "SELECT *  FROM `tbl_dept_trainee_registration` WHERE  phone =".$_SESSION['username'];

                        $db->select_sql($sql2);
                       $trainee = $db->getResult();
                      //  print_r($trainee[0] );
                         $prog_id =  $trainee[0]['program_id'];
                break;
                case '4':
                case '5':
                   $prog_tbl = 'tbl_short_program_master';
                    break;
                
                default:
                    // code...
                    break;
            }
            
            $db->select($prog_tbl ,'*',null,'id='.$prog_id,null,null);
            foreach($db->getResult() as $row ){
                //print_r($row);
                $prg_name = $row['prg_name'];
                $start_date = $row['start_date'];
                $end_date = $row['end_date'];
            }
            ?>

            <div class="panel-header panel-header-sm">
            <div class="col-md-6" style="text-align:center">
                <div id="alert_msg" class="alert alert-success"></div>
            </div>

            </div>


            <div class="content" style="margin-top: 50px;">
            
                <div class="row" style="margin-top:20px">
                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-body">

                                <div id="feedbakfrm" style='line-height: 3rem;'>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <b> Name</b>:
                                        </div>
                                        <div class="col-md-8">
                                            <?php 
                                            echo $_SESSION['name'];
                                        ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <b> Name of The Program</b>:
                                        </div>
                                        <div class="col-md-8">
                                            <?php 
                                           
                                            echo $prg_name;
                                        ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <b> Period of program</b>:
                                        </div>
                                        <div class="col-md-8">
                                            <?php 
                                           
                                            echo '<b>From - </b>  '.  date("d-m-Y", strtotime($start_date)) .'  '.'  <b>  To  -</b>  '. date("d-m-Y", strtotime($end_date));
                                        ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <b>How do you rate the program?</b>:
                                        </div>

                                    </div>

                                    <?php
                                      $suggestion ='';
                                      $edit_id ='';
                                    $feedback_sql = "SELECT d.id,m.feedback as name,p.id as edit_id,p.program_id,p.trng_type,p.username,p.suggestion,d.feedback FROM `tbl_post_trng_feedback` p 
                                                        LEFT JOIN `tbl_post_trng_feedback_data` d ON p.id = d.post_feedback_id
                                                        JOIN `tbl_feedback_master` m ON d.feedback_name_id = m.id WHERE p.program_id = '".$prog_id."' AND p.trng_type = '".$trng_type."' AND p.username = '". $_SESSION['username']."' ";
                                       $db->select_sql($feedback_sql);
                                       $result = $db->getResult();
                                     
                                       if($result){
                                          ?>
                                                 <div class="row">
                                        <table style="width:95%;margin:0px auto">
                                            <tr>
                                                <td style="width: 20%;"></td>
                                                <td></td>
                                                <td style="width: 20%;"></td>
                                                <td style="width: 20%;"></td>
                                                <td style="width: 10%;"></td>
                                             
                                                 <td colspan="2" style="margin-left:15%;float:right"><b style="color:red">Low</b>---><b style="color:green">High</b></td>  

                                            </tr>
                                        </table>
                                        <div id="class_tbl"
                                            class=" table table-responsive table-striped table-hover table-bordered"
                                            style="width:95%;margin:0px auto">

                                            <table class=" term table" id="feedback_tbl" >

                                                <thead class="" style="background: #315682;color:#fff;font-size: 11px;">
                                                    <th style="width:200px;"></th>
                                                  <th style="width:200px;">Needs Improvement</th>
                                                    <th style="width:200px;">Average</th>
                                                    <th style="width:200px;">Good</th>
                                                    <th style="width:200px;">Very Good</th>
                                                    <th style="width:200px;">Excellent</th>
                                                    
                                                </thead>
                                                <tbody>
                                                    <?php
                                             
                                               foreach($result as $feedback ){
                                                // print_r($row);
                                                   $suggestion = $feedback['suggestion'];
                                                   $edit_id = $feedback['edit_id'];
                                                   ?>
                                                    <tr>
                                        <input type="hidden" name="fdbk_name" id="feedback_id" value="<?php echo $feedback['id']; ?>">
                                                        
                                                        <td style="width:200px;text-align: center"><?php echo $feedback['name']; ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <div class="form-check ">
                                                                <input class="form-check-input" type="radio"
                                                                    name="feedback_<?php echo $feedback['id'] ?>" value="1" 
                                                                    <?php echo ($feedback['feedback'] == 1)?'checked':'' ?>>
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <div class="form-check ">
                                                                <input class="form-check-input" type="radio"
                                                                    name="feedback_<?php echo $feedback['id'] ?>" value="2"  
                                                                    <?php echo ($feedback['feedback'] == 2)?'checked':'' ?>>
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <div class="form-check ">
                                                                <input class="form-check-input" type="radio"
                                                                    name="feedback_<?php echo $feedback['id'] ?>" value="3" 
                                                                    <?php echo ($feedback['feedback'] == 3)?'checked':'' ?>>
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <div class="form-check ">
                                                                <input class="form-check-input" type="radio"
                                                                    name="feedback_<?php echo $feedback['id'] ?>" value="4" 
                                                                    <?php echo ($feedback['feedback'] == 4)?'checked':'' ?>>
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <div class="form-check ">
                                                                <input class="form-check-input" type="radio"
                                                                    name="feedback_<?php echo $feedback['id'] ?>" value="5" 
                                                                    <?php echo ($feedback['feedback'] == 5)?'checked':'' ?>>
                                                            </div>
                                                        </td>
                                                        
                                                    </tr>
                                                    <?php
                                               }
                                              ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                          <?php
                                       }else{
                                        ?>

                                    <div class="row">
                                        <table style="width:95%;margin:0px auto">
                                            <tr>
                                               <td style="width: 20%;"></td>
                                                <td></td>
                                                <td style="width: 20%;"></td>
                                                <td style="width: 20%;"></td>
                                                <td style="width: 10%;"></td>
                                                <td></td>
                                                <td colspan="13" style="margin-left:15%;float:right"><b style="color:red">Low</b>---><b style="color:green">High</b></td>

                                            </tr>
                                        </table>
                                        <div id="class_tbl"
                                            class=" table table-responsive table-striped table-hover table-bordered"
                                            style="width:95%;margin:0px auto">

                                            <table class=" term table" id="feedback_tbl">

                                                <thead class="" style="background: #315682;color:#fff;font-size: 11px;">
                                                    <th style="width:200px;"></th>
                                                  <th style="width:200px;">Needs Improvement</th>
                                                    <th style="width:200px;">Average</th>
                                                    <th style="width:200px;">Good</th>
                                                    <th style="width:200px;">Very Good</th>
                                                    <th style="width:200px;">Excellent</th>
                                                    
                                                </thead>
                                                <tbody>
                                                    <?php
                                              $count = 0;
                                              $db->select('tbl_feedback_master','*',null,null,null,null);
                                               foreach($db->getResult() as $row ){
                                                   //print_r($row);

                                                   $count++;
                                                   ?>
                                                    <tr>
                                                        <input type="hidden" name="fdbk_name" id="feedback_id" value="<?php echo $row['id']?>">
                                                        <td style="width:200px;"><?php echo $row['feedback']; ?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <div class="form-check ">
                                                                <input class="form-check-input" type="radio"
                                                                    name="feedback_<?php echo $row['id'] ?>" value="1">
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <div class="form-check ">
                                                                <input class="form-check-input" type="radio"
                                                                    name="feedback_<?php echo $row['id'] ?>" value="2">
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center"> 
                                                            <div class="form-check ">
                                                                <input class="form-check-input" type="radio"
                                                                    name="feedback_<?php echo $row['id'] ?>" value="3">
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <div class="form-check ">
                                                                <input class="form-check-input" type="radio"
                                                                    name="feedback_<?php echo $row['id'] ?>" value="4">
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <div class="form-check ">
                                                                <input class="form-check-input" type="radio"
                                                                    name="feedback_<?php echo $row['id'] ?>" value="5">
                                                            </div>
                                                        </td>
                                                       
                                                        
                                                    </tr>
                                                    <?php
                                               }
                                              ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php
                                       }
                                    
                                    ?>
                                   

                                    <div class="row">
                                        <div class="col-md-10">
                                            <b> What is your suggestion for improving the training program ? </b> <br>
                                            <b>(Max 250 Words)</b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <textarea style="width: 80%;" id="suggestion" > <?php echo ($suggestion != '')?$suggestion:'' ?> </textarea>
                                        </div>
                                    </div>
                                    <div class="row" style="display: <?php echo ($suggestion == '')?'':'none' ?>">
                                        <input type="button" style="margin: 0 auto;" class="btn btn-primary"
                                            value='Submit'
                                            onclick="save_feedback(<?php echo $prog_id ?>,<?php echo $trng_type ?>,'<?php echo $_SESSION['username'] ?>')">
                                    </div>
                                    <!-- <div class="row" style="display: <?php //echo ($suggestion != '')?'':'none' ?>">
                                        <input type="button" style="margin: 0 auto;" class="btn btn-primary"
                                            value='Update Suggestion'
                                            onclick="update_feedback(<?php// echo $prog_id ?>,<?php //echo $edit_id ?>)">
                                    </div> -->
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

<script>
function save_feedback(prog_id, trng_type, username) {
    TableData = storeTblValues();
    TableData = JSON.stringify(TableData);

    let suggestion = $('#suggestion').val();
    
console.log(TableData );
    $.ajax({
        url: 'ajax_trainee.php',
        type: "POST",
        data: {
            'tableData': TableData,
            suggestion: suggestion,
            username: username,
            program_id: prog_id,
            trng_type: trng_type,
            action: 'post_feedback'
        },

        success: function(data) {
            console.log(data);
            elm = data.split('#');
            if (elm[0] == 'success') {
                 showMessage();
                sessionStorage.message = "Feedback saved Successfully";
                sessionStorage.type = "success";
                location.reload();
            }
        }
    });
}

function update_feedback(prog_id, edit_id) {
  

    let suggestion = $('#suggestion').val();

    $.ajax({
        url: 'ajax_trainee.php',
        type: "POST",
        data: {
            suggestion: suggestion,
            program_id: prog_id,
            edit_id: edit_id,
            action: 'update_post_feedback'
        },

        success: function(data) {
            console.log(data);
            elm = data.split('#');
            if (elm[0] == 'success') {
                sessionStorage.message = "Feedback upadted Successfully";
                sessionStorage.type = "success";
                location.reload();
            }
        }
    });
}

function storeTblValues() {
    var TableData = new Array();
    $('#feedback_tbl tr').each(function(row, tr) {
        TableData[row] = {

            "feedback_name_id": $(tr).find('#feedback_id').val(),
            "feedback": $(tr).find('input[type="radio"]:checked').val(),

        }
    });
    TableData.shift(); // first row will be empty - so remove
    return TableData;
}
</script>
