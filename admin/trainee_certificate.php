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

        <?php include('sidebar.php'); ?>

        <div class="main-panel" id="main-panel">
            <?php include('navbar.php'); ?>

            <div class="panel-header panel-header-sm">


            </div>


            <div class="content" style="margin-top: 50px;">

               
                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                               <div class="row">
                                    <div class="col-md-4">  
                                      <h4 class="card-title">Result</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="term2" class=" table table-responsive table-striped table-hover" style="width:85%;margin:0px auto" >
                                    <table class=" term table">
                                        <thead class="" style="background: #315682;color:#fff;font-size: 11px;">

                                        <th style="width:75px;">Sl No</th>
                                        <th>Program Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>

                                        </thead>
                                        <tbody>
                                            <?php 
                               
                               //$db = new Database();
                              
                               $count = 0;
                               $exam_group = 0;
                               $prog_tbl = '';
                               $allowDnwCrt = 0;
                                switch ($trng_type) {
                                    case '3':
                                    case '7':
                                        $prog_tbl='tbl_mid_program_master';
                                        break;
                                    case '4':
                                    case '5':
                                        $prog_tbl='tbl_short_program_master';
                                        break;
                                    default:
                                       $prog_tbl='tbl_program_master';
                                        break;
                                }
                                
                                

                               

                                  $db->select_sql("SELECT *  FROM `tbl_dept_trainee_registration` WHERE `user_id`=".$_SESSION['user_id']);
//echo "SELECT *  FROM `tbl_dept_trainee_registration` WHERE `user_id`=".$_SESSION['user_id'];
                                  //print_r($db->getResult());
                                  foreach($db->getResult() as $row5){
                                     $exam_group = $row5['exam_group'];
                                 
                                  $crt_temp = '';
                                  if($prog_id == 70){
                                    $crt_temp = 'download_crt_trainee_2.php';
                                  }elseif($prog_id==83){
                                    $crt_temp = 'download_crt_trainee_3.php';
                                  }
                                  else{
                                     $crt_temp = 'download_crt_trainee.php';
                                  }
                                 //print_r($res);

                               $db->select($prog_tbl,"*",null,'status ="approve" AND id ='.$row5['program_id'],null,null);
                              // print_r( $db->getResult());
                               foreach($db->getResult() as $row){
                                   //print_r($row);
                                   $user_id = $_SESSION['user_id'];
                                   $db->select('tbl_mid_cls_suggestation',"*",null,'program_id = "'.$row5['program_id'].'" AND user_id ='.$_SESSION['user_id'],null,null);
                                 $res = $db->getResult();
                                // print_r($res);
                                // echo count($res[0]);
                                  if($res[0]){
                                    $allowDnwCrt = 1;
                                  }
//$allowDnwCrt = 1;
                                   $count++;
                                   ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                
                                                <td><?php echo $row['prg_name']; ?> </td>
                                                <td><?php echo $row['start_date']; ?> </td>
                                                <td><?php echo $row['end_date']; ?> </td>
                                                <td>
                                                    <?php
                                                 if($prog_id == 68){
                                                    ?>
                                                     <button type="button" class="btn btn-success btn-sm" 
                                                onclick="view_result(<?php echo $exam_group ?>,<?php echo $user_id ?>)">View Result</button>

                                                    <?php
                                                 }
                                                     ?>
                                                <?php
                                                 if($allowDnwCrt>0){
                                                    if($prog_id == 68 && $row5['exam_result_status'] == 1 && $row5['mark'] >24){
                                                        ?>
                                                        <button type="button" class="btn btn-primary crtDn" 
                                                           onclick="downloadCrt('<?php echo $crt_temp; ?>',<?php echo $prog_id ?>,<?php echo $trng_type ?>,<?php echo $user_id ?>)">Download</button>
                                                        <?php
                                                    }
                                                    if($row5['program_id'] == 73 || $row5['program_id'] == 70 || $row5['program_id'] == 71 || $row5['program_id'] == 83){
                                                        ?>
                                                       <button type="button" class="btn btn-primary crtDn" 
                                                          onclick="downloadCrt('<?php echo $crt_temp; ?>',<?php echo $prog_id ?>,<?php echo $trng_type ?>,<?php echo $user_id ?>)">Download</button>
                                                        <?php
                                                    }
                                                    ?>

                                                     

                                                    <?php
                                                 }else{
                                                    echo '<p class="text-danger">Please give classwise feedback and suggestion to download certificate</p>';
                                                 }
                                                 ?>
                                               
                                                   
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

                    </div>

                </div>
            </div>


        </div>

    </div>

    </div>

    </div>

    <!-- msgBox Modal Modal HTML -->
    <div id="cnfModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="m_title" style="text-align:center;">Delete Term</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="warning">
                            <p>Are you sure you want to delete this Record?</p>
                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                        </div>
                        <p id="m_body"></p>
                    </div>
                    <div class="modal-footer" id="m_footer">
                        <input type="submit" class="btn btn-default" data-dismiss="modal" value="Cancel">

                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include('common_script.php') ?>

</body>

</html>

<script type="text/javascript">

    function view_result(exam_id){
    let user_id = <?php echo $_SESSION['user_id'] ?>;
    datapost('../online_exam/admin/view_exam_result.php',{exam_id:exam_id,user_id:user_id});
}
function downloadCrt(crt_temp,prog_id,trng_type,user_id){
     $('.crtDn').text('Please Wait..');
    datapost(crt_temp,{prog_id:prog_id ,trng_type:trng_type,user_id:user_id })
}
function datapost(path, params, method) {
    //alert(path);
    $('.crtDn').val('Please Wait..');
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
    //$('.crtDn').text('Download');
}
</script>