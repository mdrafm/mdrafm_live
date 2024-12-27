<!DOCTYPE html>
<html lang="en">


<head>
    <?php 
    
    include('header_link.php');
    include('../config.php');
    include 'database.php';
  
    ?>
    <!-- select2 -->
    <link href="assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    /* .content_row .contentBox{
            position:relative; 
            background:#fff;
            height:0;
            overflow:hidden;
            transition:0.5s;
            overflow-y:auto;
        } */
    /* .content_row .active .contentBox{
            height:150px;
            padding:10px;
        } */
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


            <div class="content">


                <div class="row" style="margin-top:50px">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Feedback</h4>
                            </div>
                            <div class="card-body">
                                <form id="frm_feedback">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>Training Type</strong></label>
                                                <select class="custom-select mr-sm-2" name="traning_type"
                                                    id="traning_type">
                                                    <option selected>Select Type</option>
                                                    <?php 
                                                                    $db = new Database();
                                                                    $count = 0;
                                                                    $db->select('tbl_training_type',"*",null,null,null,null);
                                                                    // print_r( $db->getResult());
                                                                    foreach($db->getResult() as $row){
                                                                        //print_r($row);
                                                                        $count++
                                                                 ?>
                                                    <option value="<?php echo $row['id'] ?>">
                                                        <?php echo $row['type'] ?>
                                                    </option>

                                                    <?php 
                                                            }
                                                       ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>Program</strong></label>
                                                <select class="custom-select mr-sm-2" name="program_id" id="program_id">
                                                    <option selected>Select Program</option>

                                                </select>
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-md-6 class_room">
                                            <div class="form-group">
                                             
                                                <div class="form-check form-check-inline" style="margin-left: 20px;">
                                                    <input class="form-check-input" type="radio" name="feedback"   value="1">
                                                      
                                                    <label class="form-check-label" for="Faculty"
                                                        style="padding-left: 5px;">Time Table Wise1</label>
                                                </div>
                                               
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="feedback"  value="3">
                                                       
                                                    <label class="form-check-label" for="Topic"
                                                        style="padding-left: 5px;">Trainee Wise</label>
                                                </div>

                                            </div>
                                           
                                        </div>
                                        

                                    </div> -->
                                   
                                   <!--  <div class="row">
                                        <div class="col-md-3"  id="traineeWise"  style="display:none">
                                           <div class="form-group">
                                                <label><strong>Select Trainee</strong></label>
                                                <select class="custom-select mr-sm-2" name="trainee_id" id="trainee_id">
                                                  <option value="0" >Select Trainee</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div> -->
                                   <!--  <div class="row">
                                        <div class="col-md-11">
                                            <div class="form-group">
                                               
                                                    <input type="button" class="btn btn-success" value="Generate Report"
                                                    style="float: right" onclick="generate_pdf()">
                                                    <input type="button" class="btn btn-primary" value="view"
                                                    style="float: right" onclick="view_feedback()">
                                            </div>
                                        </div>
                                    </div> -->
                                </form>
                                <input type="hidden" name="update_id" id="update_id" />
                            </div>
                        </div>

                    </div>

                </div>
               
                
                <div class="row" style="margin-top:50px">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>

                            </div>
                            <div class="card-body">
                                <div id="program_list">
                                 
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

<script type="text/javascript">

   let type = <?php echo isset($_SESSION['trng_type'])? $_SESSION['trng_type']:0 ?>;
   console.log(type);

   if(type !==0){
    $('#traning_type').val(type);
    programList(type);
   }

$('#traning_type').on('change', function() {
    var type = $('#traning_type').val();
    programList(type);
    
})

function programList(type){
    $.ajax({
        type: "POST",
        url: "ajax_feedback.php",
        data: {
            action: "program_list",
            type: type,

        },
        success: function(res) {
            console.log(res);
            $('#program_list').html(res);
            $('#prog_list').DataTable();

        }
    })
}
function redirectPage(url,program_id,traning_type,flag){
  //console.log(prog_name);
     datapost('view_program_feedback.php',{program_id: program_id ,traning_type:traning_type,flag:flag})
  
}



function view_feedback() {
    var program_id = $('#program_id').val();
    var type = $('#traning_type').val();
    var flag = $('input[name="feedback"]:checked').val();
    var action = (flag == 1)?'view_mid_feedBack':'view_trainee_feedBack';

     console.log(action);
    // return false;
    $.ajax({
        type: "POST",
        url: "ajax_trainee.php",
        data: $('#frm_feedback').serialize() + '&' + $.param({
            'action': action

        }),
        success: function(res) {
            console.log(res);
           // alert(res);
            $('#feedback_data').html(res);
            // const accordion = $('.content_row');
            // //console.log(acordian);
            // for (i = 0; i < accordion.length; i++) {
            //     accordion[i].addEventListener('click', function() {
            //         this.classList.toggle('active')
            //     })
            // }

        }
    })

}
function show_content(id) {
    // $(`.contentBox_${id}`).css({transition : 'opacity 1s ease-in-out'});
    // $(this).parent().find('button').html('<i class="fa fa-minus"></i>');
    $(`.contentBox_${id}`).toggle();
}

function suggetion_pdf() {
    var program_id = $('#program_id').val();
    var traning_type = $('#traning_type').val();
    var prog_name = $('#program_id option:selected ').text();
    datapost('get_mid_feedback_suggetion_pdf.php',{program_id: program_id ,traning_type:traning_type,prog_name:prog_name})
}
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