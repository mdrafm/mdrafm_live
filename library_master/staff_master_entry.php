<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header_link.php') ?>
<link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/fontawesome.min.css"
integrity="sha512-RvQxwf+3zJuNwl4e0sZjQeX7kUa3o82bDETpgVCH2RiwYSZVDdFJ7N/woNigN/ldyOOoKw8584jM4plQdt8bhA=="
crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="assets/css/manual_css.css">
</head>
<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <?php include('sidebar_nav.php') ?>
    <!-- [ Header ] start -->
    <?php include('header_nav.php') ?>
    <!-- [ Pre-loader ] End -->
    
    <!-- [ Header ] end -->
    <!-- [ Main Content ] start -->
   
            <!-- [ Main Content ] end -->
<?php
  $db->select('tbl_book_details',"*",null,'status=0',null,null);
  $res_book = $db->getResult();
  $book_list = array();
  $author_list = array();
    foreach($res_book as $res)
    {
    $book_name=$res['book_name'];
    $author_name=$res['author_name'];
    array_push($book_list,$book_name);
    array_push($author_list,$author_name);
    }
  $db->select('tbl_book_type',"*",null,null,null,null);
  $res_subject = $db->getResult();
  $db->select('tbl_staf_master',"*",null,null,'id desc',null);
  $res_staff_list= $db->getResult();
    //print_r($res_lost_book);
?>
<div class="pcoded-main-container">
<div class="pcoded-content">
<div class="row" > 
		<div class="col-lg-7">
			<div class="alert-success shadow my-3" role="alert" style="border-radius: 0px;float:right !important" id="alert_msg">
			</div>
		</div>  
        </div>
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-md-12">
                    <!-- <div class=" table-striped table-hover" id="result_tbl">
                    </div> -->
                    <div class="card table-card">
                        <div class="card-header">
                        <div class="" style="width:60%;margin-left:15%" >
                        <div class="card" style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;border-top: 3px solid #ebebeb;">
                        <div class="card-header" style="background-color: #76b2b5;color:white;height: 50px;">Staff Registration</div>
                         <div class="card-body" style="margin-top:1%;margin-left:2%"> 
                            <form>
                            <div class="form-group row">
                            <label for="bookname" class="col-sm-3 col-form-label">Staff Type : </label>
                            <div class="col-sm-5">
                            <select class="custom-select mr-sm-2" id="staff_type" name="staff_type">
                            <option value="">Select</option>
                            <option value="4">Outsource staff</option>
                            <option value="3">Regular staff</option>
                            <option value="2">Guest Staff</option>
                            <option value="1">Inhouse Staff</option>
                            </select>
                            <small></small>          
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">Name : </label>
                            <div class="col-sm-5">
                            <input type="text" class="form-control" name="name" id="name" >
                            <small></small>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">Designation : </label>
                            <div class="col-sm-5">
                            <input type="text" class="form-control" name="desig" id="desig" >
                            <small></small>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">Address : </label>
                            <div class="col-sm-5">
                            <input type="text" class="form-control" name="address" id="address">
                            <small></small>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">Phone : </label>
                            <div class="col-sm-5">
                            <input type="text" class="form-control" name="phone" id="phone" >
                            <small></small>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">Email : </label>
                            <div class="col-sm-5">
                            <input type="text" class="form-control" name="email" id="email" >
                            <small></small>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">Photo : </label>
                            <div class="col-sm-5">
                            <input type="file" class="form-control" name="photo" id="photo" >
                            <span id="img_id"></span>
                            <input type="hidden" class="form-control" name="hdn_photo" id="hdn_photo" >
                            </div>
                            </div>
                            <input type="hidden" name="update_id" id="update_id" value="" >
                            <input type="hidden" name="update_user_id" id="update_user_id" value="" >
                            <?php
                                $rules = array(
                                'staff_type' => 'select',
                                'name' => 'required',
                                'desig' => 'required,designation',
                                'address' => 'required',
                                'phone' => 'required|integer',
                                'email' => 'required'
                            );
                            ?>
                            <div class="col-sm-7" style="float:right">
                            <button type="button" class="btn btn-primary mb-2" id="save_btn" onclick='add_staff(<?php echo json_encode($rules)  ?>,displayMessage)'>Save</button>
                            <button type="button" class="btn btn-primary mb-2" id="update_btn" onclick='update_staff(<?php echo json_encode($rules)  ?>,displayMessage)' style="display:none">Update</button>
                            </div>
                            </form> 
                        </div>
                    </div>
                    </div>
                            <h5>Staff List</h5>
                            <div class="loader" style="display: none;margin-left: 35%;">
                                <img src="../admin/assets/img/loader.gif" class="loader_img" alt="Loading" style="width: 300px;height: 90px;" />
                            </div>
                            <div id="tbl_case_law" class="table table-responsive table-striped table-hover">
                            <table id="case_law" class="table">
                            <thead class="" style="background: #315682;color:#fff;">
                            <th>Sl No</th>
                            <th>Staff Type</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Photo</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Photo</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                           <?php $sl_no=1;
                           foreach($res_staff_list as $res)
                           {
                            $id=$res['id'];
                            $user_id=$res['user_id'];
                            $type=$res['type'];
                            $name=$res['name'];
                            $desig=$res['desig'];
                            $address=$res['address'];
                            $phone=$res['phone'];
                            $email=$res['email'];
                            $image=$res['image'];
                            $status=$res['status'];
                            if($type==1)
                            {
                                $type_name='Inhouse Staff';
                            }
                            else if($type==2)
                            {
                                $type_name='Regular staff';
                            }
                            else if($type==3)
                            {
                                $type_name='Guest Staff';
                            }
                            else if($type==4)
                            {
                                $type_name='Inhouse Staff';
                            }
                            ?>
                             
                             <input type="hidden" name="update_user_id" id="update_user_id_<?=$id?>" value="<?=isset($user_id)?$user_id:''?>">
                            <input type="hidden" name="hdn_type" id="hdn_type_<?=$id?>" value="<?=isset($type)?$type:''?>" >
                            <input type="hidden" name="hdn_name" id="hdn_name_<?=$id?>" value="<?=isset($name)?$name:''?>" >
                            <input type="hidden" name="hdn_desig" id="hdn_desig_<?=$id?>" value="<?=isset($desig)?$desig:''?>" >
                            <input type="hidden" name="hdn_address" id="hdn_address_<?=$id?>" value="<?=isset($address)?$address:''?>" >
                            <input type="hidden" name="hdn_phone" id="hdn_phone_<?=$id?>" value="<?=isset($phone)?$phone:''?>" >
                            <input type="hidden" name="hdn_email" id="hdn_email_<?=$id?>" value="<?=isset($email)?$email:''?>" >
                            <input type="hidden" name="hdn_image" id="hdn_image_<?=$id?>" value="<?=isset($image)?$image:''?>" >
                            <tr>
                            <td><?php echo $sl_no++;?></td>
                            <td><?=isset($type_name)?$type_name:''?></td>
                            <td><?=isset($name)?$name:''?></td>
                            <td><?=isset($desig)?$desig:''?></td>
                            <td><?=isset($phone)?$phone:''?></td>
                            <td><?=isset($email)?$email:''?></td>
                            <td style="width:15%"><?=isset($address)?$address:''?></td>
                            <td><img src="../images/staff/<?=isset($image)?$image:''?>"
                                                width="120" height="100"></td>
                            <td style="width:12%;text-align:center" >
                            <?php if($status=='0')
                            { ?>
                               <span style="padding: 6px 7px;font-weight:600;color:;background-color:;border-radius:8px" class="btn-secondary">Inactivated<span>
                           <?php }else{ ?>
                        <button type="button" class="btn-info" style="padding: 2px 14px"
                        value="<?php echo $res['id']; ?>" onclick="edit_staff_details(this);">
                        Edit
                        </button>
                        <button type="button" class="btn-danger" style="padding: 2px 10px"
                        value="delete" id="<?php echo $res['id']; ?>" onclick="delete_staff_details(this);">
                        Delete
                        </button>
                        <button type="button" class="btn-warning" style="margin-top: 3%;margin-left: 10%;padding: 2px 10px"
                        value="status" id="<?php echo $res['id']; ?>" onclick="active_inactive_status(this);">
                        Inactive
                        </button>
                          <?php }
                            ?>
                       
                    </td>
                           </tr>
                           <?php } ?>
                            </tbody>
                             </table>
                             </div>
                        </div>
                    </div>
                <?php //print_r($author_list) ?>
                </div>
            </div>
            <div id="alert_box" class="modal fade" role="dialog" aria-labelledby="alert_boxLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="alert_boxLabel2"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0 alrt_msg">
                            </p>
                        </div>
                        <div class="modal-footer " id="footer_alert">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
</body>
</html>
<script src="assets/js/common.js"> </script>
<script src="assets/js/form_validation.js"> </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="../js/case.js"> </script>
<script type="text/javascript">
function add_staff(rules,callback) {

    const name = document.querySelector('#name');
    const staff_type = document.querySelector('#staff_type');
    const desig = document.querySelector('#desig');
    const address = document.querySelector('#address');
    const phone = document.querySelector('#phone');
    const email = document.querySelector('#email');
    const photo = document.querySelector('#photo');
    let valid_staff_type =  checkDropdown(staff_type);
        valid_name = checkTextField(name);
        valid_desig = checkTextField(desig);
        valid_address = checkTextField(address);
        valid_phone = checkTextField(phone);
        valid_email= checkTextField(email);

    let isFormValid = valid_staff_type && valid_name && valid_desig && valid_address && valid_address && valid_phone && valid_email;
      if(isFormValid){
        var form_data = new FormData(document.querySelector('form'));
        form_data.append("action", "add_staff_master");
        form_data.append("table", "tbl_staf_master");
        form_data.append("rules", JSON.stringify(rules));
        $.ajax({
            method: "POST",
            url: "ajax_case_master.php",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
        //  beforeSend: function() {
        //  $(`#save_btn`).html("Wait...");
        //  $(`#save_btn`).prop('disabled', true);
        // },
            success: function(res) {
                console.log(res);
                callback(res);
                let elm = res.split('#');
				console.log(elm[0]);
                let username=elm[1] ;
                let pass=elm[2] ;
                let email=elm[3] ;
                let attachment = [];
                let subject='MDRAFM Login Credentials';
                let email_body =  "<br><h3>MDRAFM Login</h3> </br><p>User name: <strong>"+ username +"</strong><p></br><p>Password: <strong>"+ pass +"</strong><p>";
                sendEmail(email,subject,email_body);
                if (elm[0] == "success") {
                  sessionStorage.message = `Staff is added successfully`;
                    sessionStorage.type = "success";
                    setTimeout(function(){
                    window.location.reload(1);
                    }, 1000);
					showMessage();
                }
                else{
                    sessionStorage.message =elm[1];
                    sessionStorage.type = "error";
                    showMessage();
                }
            }
        })
      }   
}

function delete_staff_details(data) {
    var delete_id=data.id;
    //alert(delete_id);
    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: {
            action: "delete_staff_details",
            delete_id: delete_id,
            table: "tbl_staf_master",
        },
        success: function(res) {
            alert(res);
            let elm = res.split('#');
            //alert(elm);
            if (elm[0] == "success") {
                sessionStorage.message = "Staff Details are Deleted Successfully";
                sessionStorage.type = "success";
                showMessage();
                setTimeout(function(){
                    window.location.reload(1);
                    }, 1000);
            }
            else if(elm[0] == "error") {
                sessionStorage.message = elm[1];
                sessionStorage.type = "error";
                showMessage();
            }
        }
    })
   
}
function sendEmail(email,subject,email_body){
 $.ajax({
     url: '../admin/mail_send.php',
     type: "POST",
     data: {
         subject:subject,
         email_body:email_body, 
         email:email,
        
     },

    
     success: function(data) {
         console.log(data);
     }
 });
}
function edit_staff_details(data) {
    window.scrollTo(0, 0);
    //$('#update_id').val(data);
	$('#save_btn').css('display', 'none');
    $('#update_btn').css('display', 'block');
    var tbl_id=data.value;
    //alert(tbl_id);
    var stf_type=$('#hdn_type_'+tbl_id).val();
    var name=$('#hdn_name_'+tbl_id).val();
    var desig=$('#hdn_desig_'+tbl_id).val();
    var address=$('#hdn_address_'+tbl_id).val();
    var phone=$('#hdn_phone_'+tbl_id).val();
    var email=$('#hdn_email_'+tbl_id).val();
    var image=$('#hdn_image_'+tbl_id).val();
    var update_user_id=$('#update_user_id_'+tbl_id).val();
    $('#staff_type').val(stf_type);
    $('#name').val(name);
    $('#desig').val(desig);
    $('#address').val(address);
    $('#phone').val(phone);
    $('#email').val(email);
    $('#img_id').html(image);
    $('#hdn_photo').val(image);
    $('#update_id').val(tbl_id);
    $('#update_user_id').val(update_user_id);
}
function update_staff(rules,callback) {
	let msg_flg = (update_id === '')?'added':'updated';
    const staff_type = document.querySelector('#staff_type');
    const name = document.querySelector('#name');
    const desig = document.querySelector('#desig');
    const address = document.querySelector('#address');
    const phone = document.querySelector('#phone');
    const email = document.querySelector('#email');
    const photo = document.querySelector('#photo');
    let valid_staff_type =  checkDropdown(staff_type);
        valid_name = checkTextField(name);
        valid_desig = checkTextField(desig);
        valid_address = checkTextField(address);
        valid_phone = checkTextField(phone);
        valid_email= checkTextField(email);

    let isFormValid = valid_staff_type && valid_name && valid_desig && valid_address && valid_address && valid_phone && valid_email;
      if(isFormValid){
        let update_id = $('#update_id').val();
        let update_user_id = $('#update_user_id').val();
        var form_data = new FormData(document.querySelector('form'));
        form_data.append("action", "update_staff_master");
        form_data.append("table", "tbl_staf_master");
        form_data.append("update_id", update_id);
        form_data.append("update_user_id", update_user_id);
        form_data.append("rules", JSON.stringify(rules));
        $.ajax({
            method: "POST",
            url: "ajax_case_master.php",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(res) {
               //alert(res);
                console.log(res);
                let elm = res.split('#');
				console.log(elm[0]);
                if (elm[0] == "success") {
                  //  sessionStorage.message = `Staff is ${msg_flg} successfully`;
                  sessionStorage.message = 'Staff is updated successfully';
                    sessionStorage.type = "success";
                    setTimeout(function(){
                    window.location.reload(1);
                    }, 1000);
					showMessage();
                }
                else{
                    sessionStorage.message =elm[1];
                    sessionStorage.type = "error";
                    showMessage();
                }
            }
        })
      }
}
function active_inactive_status(data) {
    var update_id=data.id;
    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: {
            action: "active_inactive_status",
            update_id: update_id,
            table: "tbl_staf_master",
        },

        success: function(res) {
          // alert(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                sessionStorage.message = "Staff inactivated successfully";
                sessionStorage.type = "error";
                setTimeout(function(){
                    window.location.reload(1);
                    }, 1000);
					showMessage();
            }


        }
    })
   
}
</script>
