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
    #menu1 {
        padding: 20px;
        border-radius: 5px;
        background-color: #f2efef;
        box-shadow: rgb(0 0 0 / 2%) 0px 1px 3px 0px, rgb(27 31 35 / 15%) 0px 0px 0px 1p
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
            <div class="row">
                    <div class="col-md-4">
                      
                    </div>
                    <div class="col-md-6">
                    <div id="alert_msg" class="alert alert-success">added successfully</div>
                    </div>
                    <div class="col-md-2">

                    </div>
                </div>

            <div class="content" style="margin-top: 50px;">
                
                <div class="row" style="margin-top:10px">
                    <div class="card">

                        <div class="card-body">

                            <div id="menu1" class="container">
                                <h5 class="text-center">Add New Trainee </h5><br>
                                <?php //print_r($_SESSION ) ?>
                                <?php 
                                    if(!empty($_POST['id']) && !empty($_POST['trng_type']))
                                    {
                                    $porg_id = $_POST['id'];
                                    $trng_type = $_POST['trng_type'];
                                    $_SESSION['prg_id']=$porg_id;
                                    $_SESSION['trn_tpy']=$trng_type;
                                    }else
                                    {
                                        $porg_id = $_SESSION['prg_id'];
                                        $trng_type = $_SESSION['trn_tpy'];
                                    }
                                    switch ($trng_type) {
                                        case '3':
                                        case '7':
                                           $table = 'tbl_mid_program_master';
                                            break;
                                        case '4':
                                        case '5':
                                            $table = 'tbl_short_program_master';
                                                break;
                                        default:
                                            # code...
                                            break;
                                    }
                                    $mdrafm_status = 0;
                                   // echo $_SESSION['username'];
                                    $db->select($table,"id,trng_type,mdrafm_status",null,"id = '".$porg_id."' ",null,null );
                                    foreach ($db->getResult() as $row) {
                                        $program_id = $row['id'];
                                        $trng_type = $row['trng_type'];
                                        $mdrafm_status = $row['mdrafm_status'];
                                    }
                                   //echo $porg_id;
                                ?>
                                <form method="post" id="frm_newTranee">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong> Name</strong></label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="Enter Name">
                                                <small></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong> HRMS Id</strong></label>
                                                <input type="text" class="form-control" name="hrms_id" id="hrms_id"
                                                    placeholder="Enter HRMS Id">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Designation</strong></label>
                                                <input type="text" class="form-control" name="designation"
                                                    id="designation" placeholder="Enter Designation">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Name of the Office</strong></label>
                                                <input type="text" class="form-control" name="office_name"
                                                    id="office_name" placeholder="Name of the Office">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong> Email</strong></label>
                                                <input type="email" class="form-control" name="email" id="email"
                                                    placeholder=" Enter Email">
                                                <small></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong> Phone</strong></label>
                                                <input type="text" class="form-control" name="phone" id="phone"
                                                    placeholder=" Enter Phone Number">
                                                <small></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong> Select Gender</strong></label>
                                                <select class="custom-select mr-sm-2 mt-2" name="sex" id="sex">
                                                                        <option value="0" selected>Select Gender</option>
                                                                       <option value="1"> Male</option>
                                                                       <option value="2"> Female</option>
                                                                    </select>
                                                <small></small>
                                            </div>
                                        </div>
                                        
                                    </div>



                                    <!-- <input type="hidden" id="update_id"> -->
                                    <input type="hidden" name="program_id" value="<?php echo $porg_id; ?>" />
                                    <input type="hidden" name="trng_type" value="<?php echo $trng_type; ?>" />

                                </form>
                                <div class="d-flex justify-content-center ">
                                    <?php 
                                      if($row['mdrafm_status'] == 1){
?>
 <button type="button" class="btn btn-success" >Registration Closed</button>

<?php
                                      }else{
                                        ?>
                                        <button type="submit" class="btn btn-primary" name="submit" value="Save" id="save"
                                        onclick="add('New trainee','frm_newTranee','tbl_dept_trainee_registration')" >Save</button>
                                        <?php
                                      }
                                    ?>
                                   
                                </div>

                            </div>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="card-title">Trainee List </h4>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <!-- <div class="col-md-2">
                                    <input type="button" class="btn btn-primary" data-toggle="modal" data-target="#termModal"
                                     value="Add New">
                                    </div> -->
                                </div>


                            </div>
                            <div class="card-body">
                                <div id="term2" class=" table table-responsive table-striped table-hover"
                                    style="width:100%;margin:0px auto">
                                    <table class=" term table" id="tableid">
                                        <thead class="" style="background: #315682;color:#fff;font-size: 11px;">


                                            <th>Sl No</th>

                                            <th>Name</th>
                                            <th>HRMS Id</th>
                                            <th>Designation</th>
                                            <th>Place of Posting</th>
                                            <th>Email</th>
                                            <th style="text-align:center;">Phone</th>
                                            <th style="text-align:center;">Gender</th>
                                            <th style="text-align:center;width: 8rem;">Action</th>
                                        </thead>
                                        <tbody>
                                            <?php


        $count = 0;


        $db->select('tbl_dept_trainee_registration', "*", null, "trng_type = '".$trng_type."' AND program_id =" . $porg_id, null, null);
        $res_set=$db->getResult();    
        if(!empty($res_set))
        {
        foreach ($res_set as $row) {
            $count++
        ?>  
                                                 <tr>
                                                <td><?php echo $count; ?></td>
                                                <td> <?php echo $row['name']  ?></td>
                                                <td> <?php echo $row['hrms_id']  ?></td>
                                                <td> <?php echo $row['designation']  ?></td>
                                                <td> <?php echo $row['office_name']  ?></td>
                                                <td> <?php echo $row['email']  ?></td>
                                                <td style="text-align:center;"><?php echo $row['phone']; ?> </td>
                                                <td style="text-align:center;"><?php 
                                                     switch ($row['sex']) {
                                                         case '1':
                                                             echo "Male";
                                                             break;
                                                         case '':
                                                             echo "Female";
                                                             break;
                                                         default:
                                                              echo "NA";
                                                             break;
                                                     }
                                                 ?> 

                                               </td>


                                                <td style="text-align:center;">
                                                    <?php
                                                   
                                                     if($mdrafm_status == 0){
                                                         ?>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#detailsModal_<?php echo $row['id']; ?>"
                                                        style="color:#4164b3 ;">
                                                        <i class="far fa-edit " style="font-size:1.5rem;"></i>
                                                    </a>

                                                    &nbsp;
                                                    <a href="#" style="color:#e50c0c" id="<?php echo $row['id']; ?>"
                                                        onclick="cnfBox(<?php echo $row['id']; ?>)"><i
                                                            class="far fa-trash-alt " style="font-size:1.5rem;"></i></i>
                                                    </a><br>
                                                    <?php
                                                     }
                                                  
                                                  ?>


                                                    <!--Tranee Detail Modal -->

                                                    <div id="detailsModal_<?php echo $row['id']; ?>" class="modal fade">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content" style="width:150%">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="m_title"
                                                                        style="text-align:center;">Edit Trainee details
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal"
                                                                        aria-hidden="true">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post"
                                                                        id="frm_newTranee_update_<?php echo $row['id']; ?>"
                                                                        style="width:90%">


                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label><strong>
                                                                                            Name</strong></label>
                                                                                    <input type="text"
                                                                                        class="form-control" name="name"
                                                                                        id="name"
                                                                                        placeholder="Enter Name"
                                                                                        value="<?php echo $row['name']; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label><strong> HRMS
                                                                                            Id</strong></label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="hrms_id" id="hrms_id"
                                                                                        placeholder="Enter HRMS Id"
                                                                                        value="<?php echo $row['hrms_id']; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label><strong>Designation</strong></label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="designation"
                                                                                        id="designation"
                                                                                        placeholder="Enter Designation"
                                                                                        value="<?php echo $row['designation']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label><strong>Name of the
                                                                                            Office</strong></label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="office_name"
                                                                                        id="office_name"
                                                                                        placeholder="Enter Name of the Office"
                                                                                        value="<?php echo $row['office_name']; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label><strong>
                                                                                            Email</strong></label>
                                                                                    <input type="email"
                                                                                        class="form-control"
                                                                                        name="email" id="email"
                                                                                        placeholder=" Enter Email"
                                                                                        value="<?php echo $row['email']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label><strong>
                                                                                            Phone</strong></label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="phone" id="phone"
                                                                                        placeholder=" Enter Phone Number"
                                                                                        value="<?php echo $row['phone']; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" id="update_id" value="" />

                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer" id="m_footer">
                                                                    <input type="button" class="btn btn-default"
                                                                        data-dismiss="modal" value="Cancel">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        name="submit" value="Save" id="save"
                                                                        onclick="edit('New trainee','frm_newTranee_update_<?php echo $row['id']; ?>','tbl_dept_trainee_registration',<?php echo $row['id']; ?>)">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                           
                               
                               <?php
        }
        ?>
                   <tr>   
                    <td colspan="8"><?php 
                                if($mdrafm_status == 0){
                                ?>
                                <input type="button" class="btn btn-success"
                                onclick="send_to_mdrafm(<?php echo $porg_id ?>,'<?php echo $table ?>')"
                                name="submit" value="Send to MDRAFM" />
                                <?php
                                }else{
                                ?>
                                <input type="button" class="btn btn-info" value="Already Send to MDRAFM" disabled />
                                <?php
                                }
                                ?></td>
                 </tr>
            <?php } ?>
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
                        <h5 class="modal-title" id="m_title" style="text-align:center;">Delete Program</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="warning">
                            <p>Are you sure you want to delete this Record?</p>
                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                        </div>
                        <p id="m_body"></p>
                    </div>
                    <div class="modal-footer" id="m_footer2">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- msgBox Modal Modal HTML -->
    <div id="cnfModaSend" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">

                        <h5 class="modal-title" id="m_title" style="text-align:center;">Send TO MDRAFM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="warning">
                            <p>Are you sure you want to Send this Record?</p>
                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                        </div>
                        <p id="m_body"></p>
                    </div>
                    <div class="modal-footer" id="ms_footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">

                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include('common_script.php') ?>

</body>

</html>

<script type="text/javascript">
const nameEl = document.querySelector('#name');
const emailE1 = document.querySelector('#email');
const phoneE1 = document.querySelector('#phone');
const sexE1 = document.querySelector('#sex');


function addProgram() {
    let trng_type = $('#trng_type').val();
    // alert(trng_type); 
    if (trng_type == 5) {
        $('#shortTermModalSponsored').modal('show');
    } else {
        $('#shortTermModalInhouse').modal('show');
    }


}



function add(str, frm, tbl, updt_id) {
    // validate forms
    let isNameValid = checkTextField(nameEl),
        isEmailValid = checkEmail(emailE1),
        isPhoneValid = checkPhone(phoneE1);
        isSexValid = checkDropdown(sexE1);

    let isFormValid = isNameValid &&
        isEmailValid &&
        isPhoneValid &&isSexValid;


    var update_id = $('#update_id').val();
    if (isFormValid) {
        $.ajax({
            type: "POST",
            url: "ajax_master.php",

            data: $('#' + frm).serialize() + '&' + $.param({
                'action': 'add',
                'table': tbl,
                'update_id': updt_id
            }),
            success: function(res) {
                console.log(res);
                let elm = res.split('#');
                if (elm[0] == "success") {
                    sessionStorage.message = str + ' ' + elm[1];
                    sessionStorage.type = "success";
                    location.reload();
                }
            }
        })
    }


}

function edit(str, frm, tbl, updt_id) {
    // validate forms


    var update_id = $('#update_id').val();

    $.ajax({
        type: "POST",
        url: "ajax_master.php",

        data: $('#' + frm).serialize() + '&' + $.param({
            'action': 'add',
            'table': tbl,
            'update_id': updt_id
        }),
        success: function(res) {
            console.log(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                sessionStorage.message = str + ' ' + elm[1];
                sessionStorage.type = "success";
                location.reload();
            }
        }
    })



}



function cnfBox(id) {
    //alert(id);
    $('#m_footer2').empty();
    var html =
        `<input type="button" class="btn btn-danger btn-dlt" value="Delete" onclick="delete_record(${id},'tbl_dept_trainee_registration')" />`;
    $('#m_footer2').append(html);
    $('#cnfModal').modal('show');
}

function delete_record(id, tbl) {

    $.ajax({
        type: "POST",
        url: "ajax_master.php",
        data: {

            action: "remove",
            id: id,
            table: tbl
        },
        success: function(res) {
            console.log(res);
            if (res == "success") {
                sessionStorage.message = "Record deleted successfully";
                sessionStorage.type = "success";
                location.reload();
            }
        }
    })
}

function sendToApprove(id, tbl) {
    if (confirm('Are you sure you want to Send this Program to Tranning Incharge For Approval')) {
        $.ajax({
            type: "POST",
            url: "ajax_master.php",
            data: {

                action: "send_to_approve",
                id: id,
                table: tbl
            },
            success: function(res) {
                console.log(res);
                if (res == "success") {
                    sessionStorage.message = " Successfully Send to Tranning Incharge for Approval";
                    sessionStorage.type = "success";
                    location.reload();
                }
            }
        })
    } else {
        return false;
    }
}

function send_to_mdrafm(prog_id, tbl) {

    $.ajax({
        type: "POST",
        url: "ajax_master.php",
        data: {

            action: "send_sponsored_program_mdrafm",
            prog_id: prog_id,
            table: tbl
        },
        success: function(res) {
            console.log(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                sessionStorage.message = " Successfully Send to MDRAFM";
                sessionStorage.type = "success";
                location.reload();
            }
        }
    })
}
</script>