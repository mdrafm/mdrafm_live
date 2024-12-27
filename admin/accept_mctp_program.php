<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include('header_link.php');

    include('../config.php');
    include 'database.php';
    ?>
    <!-- <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.4/dist/bootstrap-table.min.css"> -->
    <style>
        .card label {
            font-size: 1rem;
        }
    </style>
</head>

<body class="user-profile">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
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
                                    <div class="col-md-10">
                                        <h4 class="card-title">Send request to trainee for acceptance MCTP trainning</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="term3" class=" table table-responsive table-striped table-hover" style="width:100%;margin:0px auto">
                                    <table class="first_list table">
                                        <thead class="" style="background: #315682;color:#fff;font-size: 11px;">
                                           
                                            <th>Sl No</th>
                                            <th>Program Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $db = new Database();
                                            //print_r($_SESSION);
                                            $sql = "SELECT m.id,m.ofs_id,s.prg_name,s.start_date,s.end_date,m.mctp_accept_ststus FROM `tbl_mctp_approve` m 
                                            JOIN `tbl_ofs_master` o ON m.ofs_id = o.id
                                            JOIN `tbl_short_program_master` s ON m.program_id = s.id AND m.trng_type = s.trng_type
                                            WHERE o.user_id = ".$_SESSION['user_id'];
                                            $db->select_sql($sql);
                                            $res_set = $db->getResult();
                                           
                                         
                                                foreach ($res_set as $row1) {
                                                   //  print_r($row1);
                                                    $cnt=1;
                                            ?>
                                                    <tr>
                                                       
                                                        <td><?php echo $cnt++; ?></td>
                                                        <td><?php echo $row1['prg_name'] ; ?> </td>
                                                        <td><?php echo date('Y-m-d',strtotime($row1['start_date']))  ; ?> </td>
                                                        <td><?php echo date('Y-m-d',strtotime($row1['end_date'])); ?></td>
                                                        
                                                        <td>
                                                            <?php  
                                                             //  isset($row1['mail_id']) ? $row1['mail_id'] : '' 
                                                               switch ($row1['mctp_accept_ststus']) {
                                                                case '1':
                                                                   echo 'Pending';
                                                                    break;
                                                                case '2':
                                                                    echo 'Accept';
                                                                        break;
                                                                case '3':
                                                                    echo 'Rejected';
                                                                        break;
                                                                
                                                                default:
                                                                    # code...
                                                                    break;
                                                               }
                                                            ?>
                                                            
                                                        </td>

                                                        <td> 
                                                            <?php 
                                                              if($row1['mctp_accept_ststus'] == 1){
                                                                ?>
                                                                <button type="button" class="btn btn-success" onclick="accept(<?php echo $row1['id'] ; ?>,<?php echo $row1['ofs_id'] ; ?>)" >Accept</button> 
                                                                <button type="button" class="btn btn-danger" onclick="reject(<?php echo $row1['id'] ; ?>,<?php echo $row1['ofs_id'] ; ?>)" >Reject</button> 
                                                                <?php
                                                              }
                                                            ?>
                                                            
                                                        </td>

                                                    </tr>

                                            <?php
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
    <div id="rejectModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content" style="width:130%; margin:120px -60px">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="m_title" style="text-align:center;">Write Reject Reasone </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                <label style="margin-top: 2rem;"> Reject Reasone : </label>
                                </div>
                                <div class="col-md-8">
                                <textarea class="w-100" rows="5"  name="reason" id="reason" ></textarea>
                                </div>
                            </div>
                          
                            
                        </div>
                       
                    </div>
                    <div class="modal-footer" id="rejectbtn">
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
   
        <?php include('common_script.php') ?>

</body>

</html>
<script src="../ckeditor/ckeditor.js"> </script>
<!-- <script src="https://unpkg.com/bootstrap-table@1.22.4/dist/bootstrap-table.min.js"></script> -->
<script type="text/javascript">
   
   function accept(id,ofs_id){
    $.ajax({
            type: "POST",
            url: "action_controller.php",
            data: {
                'action': 'accept_mctp ',
                'id':id,
                'ofs_id': ofs_id
            },
            success: function(res) {
                console.log(res);
                if(res == 'success'){
                    location.reload();
                }else{
                    console.log($res);
                }
              
            }
        })
}
    

function reject(id,ofs_id){
    $('#rejectModal').modal('show');
    $('#rejectbtn').html(`<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="button" class="btn btn-primary" value="Reject" onclick="reject_control('${id}',${ofs_id})">`);

    
}


function  reject_control(id,ofs_id) {
        let reason = $('#reason').val();
        $.ajax({
            type: "POST",
            url: "action_controller.php",
            data: {
                'action': 'reject_mctp',
                'id':id,
                'ofs_id': ofs_id,
                'reason':reason
            },
            success: function(res) {
                console.log(res);
                if(res == 'success'){
                    location.reload();
                }else{
                    console.log($res);
                }
              
            }
        })
    }
    

</script>