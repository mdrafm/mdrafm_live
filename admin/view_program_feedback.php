<!DOCTYPE html>
<html lang="en">


<head>
    <?php 
    
    include('header_link.php');
    include('../config.php');
    include 'helper.php';
    include 'database.php';
    include 'dynamic_tbl.php';

    $db = new Database();
    $hp = new Helper($db);

     $program_id = $_POST['program_id'];
     $traning_type = $_POST['traning_type'];

     $sql_user = "SELECT f.user_id,u.name,u.username FROM `tbl_mid_cls_feedback` f 
                  JOIN `tbl_user` u ON f.user_id = u.id
                  WHERE f.time_tbl_id IN (SELECT id  FROM `tbl_sponsored_time_table` WHERE `program_id` = $program_id) GROUP BY f.user_id";


     $db->select_sql($sql_user);
     $res_user = $db->getResult(); 
     $feedback_user_cnt = count($res_user);

     $sql_user_not = "SELECT d.name,d.phone,d.designation,d.office_name from `tbl_dept_trainee_registration` d  WHERE d.program_id = $program_id AND d.phone NOT IN (SELECT u.username FROM `tbl_mid_cls_feedback` f 
                  JOIN `tbl_user` u ON f.user_id = u.id
                  
                  WHERE f.time_tbl_id IN (SELECT id  FROM `tbl_sponsored_time_table` WHERE `program_id` = $program_id) GROUP BY f.user_id)";

     $db->select_sql($sql_user_not);
     $res_user_not = $db->getResult(); 
     $feedback_user_cnt_not = count($res_user_not);
//print_r($res_user_not);
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
                                <button onclick="history.go(-1);" >Back</button>
                                <h4 class="card-title"> Program Feedback Details</h4>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <p style="font-size: 1.2rem;font-weight: 700;padding: 15px;" > Program Name : <span style="font-size:1rem;" ><?php 

                                    $res = $hp->get_program_name($_POST['program_id'],$_POST['traning_type']) ;
                                   
                                     echo $res[0]['prg_name'];
                                     ?></span></p>
                                </div>
                                <div class="row">
                                    <p style="font-size: 1.2rem;font-weight: 700;padding: 15px;"> Number Of Trainee Given Feedback :  <span>  <a href="#" data-toggle="modal"  data-target="#detailsModal"><?php echo $feedback_user_cnt ?> </a> </span> </p>
                                   
                                   <div id="detailsModal" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="width:150%">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="m_title"
                                                        style="text-align:center;">Trainee List Given Feedback
                                                    </h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                     <div>
                                                      <button class="btn btn-danger float-right" onclick="ExportToExcel('xlsx')">Export to excel</button>
                                                    </div>
                                                    <?php

                                                        $headers = array('Sl No', 'Name', 'Phone Number');
                                                        $traineeList = 'traineeList';
                                                        $skipArray=['user_id'];
                                                        $table = new DynamicTable($headers, $res_user,null,$skipArray,$traineeList);
                                                        echo $table->generateTable(); 
                                                     ?>
                                                      
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <p style="font-size: 1.2rem;font-weight: 700;padding: 15px;"> Number Of Trainee Not Given Feedback :  <span>  <a href="#" data-toggle="modal"  data-target="#detailsModal2"><?php echo $feedback_user_cnt_not ?> </a> </span> </p>
                                   
                                   <div id="detailsModal2" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="width:150%">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="m_title"
                                                        style="text-align:center;">Trainee List Not Given Feedback
                                                    </h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                     <div>
                                                      <button class="btn btn-danger float-right" onclick="ExportToExcel2('xlsx')">Export to excel</button>
                                                    </div>
                                                    <?php
 
                                                        $headers2 = array('Sl No', 'Name', 'Phone Number','Designation','Office Name');
                                                        $traineeList = 'traineeList2';
                                                        $skipArray=[];
                                                        $table = new DynamicTable($headers2, $res_user_not,null,$skipArray,$traineeList);
                                                        echo $table->generateTable(); 
                                                     ?>
                                                      
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
               
                
                <?php

                   // if($_POST['flag']==1){

                   // }
                   switch ($_POST['flag']) {
                       case '1':
                           include('template/feedback/claawise_feedback_template.php');
                           break;
                       case '2':
                           include('template/feedback/trainee_wise_feedback_template.php');
                           break;
                       case '3':
                           include('template/feedback/trainee_suggesstion_template.php');
                           break;
                       default:
                           // code...
                           break;
                   }
                 ?>

            </div>


        </div>

    </div>

    </div>

    </div>

    <?php include('common_script.php') ?>

</body>

</html>

<script type="text/javascript">

$('.edit').on('click',function(){
   var program_id = <?php echo $program_id ;?>;
   var traning_type = <?php echo $traning_type; ?>;
   var data = $(this).data('options');
   var trainee_id = data.user_id;
   datapost('get_trainee_ind_feedback_pdf.php',{program_id: program_id ,traning_type:traning_type,trainee_id:trainee_id});
   console.log(data);
})

function generate_pdf() {

    var program_id = <?php echo $program_id ;?>;
    var traning_type = <?php echo $traning_type; ?>;
    // var traning_type = $('#traning_type').val();
    //var prog_name = $('#program_id option:selected ').text();
   // var trainee_name = $('#trainee_id option:selected ').text();
    //var flag = $('input[name="feedback"]:checked').val();
   // var trainee_id = $('#trainee_id').val();
    //var url = (flag == 1)?'get_mid_feedback_pdf.php':'get_trainee_ind_feedback_pdf.php';
   
    datapost('get_mid_feedback_pdf.php',{program_id: program_id ,traning_type:traning_type});
}
function suggetion_pdf(prog_name,program_id,traning_type) {
    
    datapost('get_mid_feedback_suggetion_pdf.php',{program_id: program_id ,traning_type:traning_type,prog_name:prog_name})
}

function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('traineeList');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('TraineeList.' + (type || 'xlsx')));
    }
    function ExportToExcel2(type, fn, dl) {
       var elt = document.getElementById('traineeList2');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('TraineeList.' + (type || 'xlsx')));
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