<?php 
session_start(); 
$user_name=isset($_POST['user_name'])?$_POST['user_name']:'';
$phone_no=isset($_POST['phone_no'])?$_POST['phone_no']:'';
$user_id=$_SESSION['user_id'];
include '../admin/database.php'; 
$db = new Database(); 
 if(isset($user_name) && empty($phone_no))
{
    $db->select('tbl_book_request_issue',"tbl_traniee.id,tbl_traniee.f_name,tbl_traniee.l_name,tbl_traniee.email,tbl_traniee.phone,tbl_bk_req.id as bk_rq_id,tbl_bk_req.user_id,tbl_user.name,
    tbl_faculty_master.email as f_email,tbl_faculty_master.phone as f_phone,tbl_faculty_master.desig as f_desig,tbl_staff.phone as s_phone,tbl_staff.email as s_email,tbl_staff.desig as s_desig,
    tbl_dpt_trne.designation as d_desig,tbl_dpt_trne.phone as d_phone,tbl_dpt_trne.email as d_email"
    ,' tbl_bk_req LEFT JOIN tbl_new_recruite tbl_traniee ON tbl_bk_req.user_id =tbl_traniee.user_id LEFT JOIN tbl_user on tbl_user.id=tbl_bk_req.user_id left join 
    tbl_faculty_master ON tbl_bk_req.user_id =tbl_faculty_master.user_id left outer join tbl_staf_master as tbl_staff
    on tbl_staff.user_id= tbl_bk_req.user_id left outer join tbl_dept_trainee_registration as tbl_dpt_trne on tbl_dpt_trne.user_id= tbl_bk_req.user_id',
    'tbl_user.name LIKE "%'.$user_name.'%" GROUP BY tbl_bk_req.user_id',null,null);
}
else if(isset($phone_no) && empty($user_name))
{

    $db->select('tbl_book_request_issue',"tbl_traniee.id,tbl_traniee.f_name,tbl_traniee.l_name,tbl_traniee.email,tbl_traniee.phone,tbl_bk_req.id as bk_rq_id,
    tbl_bk_req.user_id,tbl_faculty_master.name,tbl_faculty_master.email as f_email,tbl_faculty_master.phone as f_phone,tbl_faculty_master.desig as f_desig,
    tbl_staff.phone as s_phone,tbl_staff.email as s_email,tbl_staff.desig as s_desig,tbl_dpt_trne.designation as d_desig,tbl_dpt_trne.phone as d_phone,tbl_dpt_trne.email as d_email"
    ,' tbl_bk_req LEFT JOIN tbl_new_recruite tbl_traniee ON tbl_bk_req.user_id =tbl_traniee.user_id LEFT JOIN tbl_user on tbl_user.id=tbl_bk_req.user_id left join 
    tbl_faculty_master ON tbl_bk_req.user_id =tbl_faculty_master.user_id left outer join tbl_staf_master as tbl_staff
    on tbl_staff.user_id= tbl_bk_req.user_id left outer join tbl_dept_trainee_registration as tbl_dpt_trne on tbl_dpt_trne.user_id= tbl_bk_req.user_id',
    'tbl_user.username= "'.$phone_no.'" GROUP BY tbl_bk_req.user_id',null,null);
}
else if(isset($phone_no) && isset($user_name))
{
     $db->select('tbl_book_request_issue',"tbl_traniee.id,tbl_traniee.f_name,tbl_traniee.l_name,tbl_traniee.email,tbl_traniee.phone,tbl_bk_req.id as bk_rq_id,
     tbl_bk_req.user_id,tbl_faculty_master.name,tbl_faculty_master.email as f_email,tbl_faculty_master.phone as f_phone,tbl_faculty_master.desig as f_desig,
     tbl_staff.phone as s_phone,tbl_staff.email as s_email,tbl_staff.desig as s_desig,tbl_dpt_trne.designation as d_desig,tbl_dpt_trne.phone as d_phone,tbl_dpt_trne.email as d_email"
    ,' tbl_bk_req LEFT JOIN tbl_new_recruite tbl_traniee ON tbl_bk_req.user_id =tbl_traniee.user_id LEFT JOIN tbl_user on tbl_user.id=tbl_bk_req.user_id left join 
    tbl_faculty_master ON tbl_bk_req.user_id =tbl_faculty_master.user_id left outer join tbl_staf_master as tbl_staff
    on tbl_staff.user_id= tbl_bk_req.user_id left outer join tbl_dept_trainee_registration as tbl_dpt_trne on tbl_dpt_trne.user_id= tbl_bk_req.user_id',
    'tbl_user.name LIKE "%'.$user_name.'%" and tbl_user.username= "'.$phone_no.'" GROUP BY tbl_bk_req.user_id',null,null);
}
$res_book = $db->getResult();
//print_r($res_book);
if(isset($_POST['action']) && $_POST['action']=='user_list')
{
     $data=$_POST['data'];
     $bk_user_id=$_POST['bk_user_id'];
     $email=$_POST['email'];
    $db->select('tbl_book_request_issue',"tbl_bk_reqst.*,tbl_book_details.book_name,tbl_book_details.author_name,tbl_bk_ref.reference_no",' tbl_bk_reqst join 
    tbl_book_details on tbl_bk_reqst.book_id=tbl_book_details.id left join 
    tbl_book_reference_no tbl_bk_ref on tbl_bk_ref.id=tbl_bk_reqst.bk_ref_id','user_id= "'.$bk_user_id.'" and tbl_bk_reqst.status= "'.$data.'"',null,null);

                          $res_req= $db->getResult();
                          //print_r($res_req);exit;
                          $sl_n=1;
                          foreach($res_req as $reslt)
                          {
                           $bk_req_id=$reslt['id'];
                           $request_date=$reslt['request_date'];
                           $issue_date=$reslt['issue_date'];
                           $return_date=$reslt['return_date']; 
                           $book_name=$reslt['book_name'];
                           $author_name=$reslt['author_name'];
                           $reference_no=$reslt['reference_no'];
                           $fine=$reslt['fine'];
                           if($data=='2')
                           {
                            $status="Issued";
                           }elseif($data=='4'){
                            $status="Returned";
                           }
                           ?>
                    <div id="detailsModal1_<?php echo $bk_req_id; ?>" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content" style="width:100%;margin-top: 50%;float:right">
                            <div class="modal-header"
                                style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, #3498db 0%, #4addf5 100%);color: #fff;padding: 6px 10px;">
                                <h5 class="modal-title" id="m_title" style="color:#fff" style="text-align:center;"> Return Details
                                </h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="frm_ret_<?=$bk_req_id?>">
                                <input type="hidden" name="csrf_token" id="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>" />
                                    <input type="hidden" id="reference_no_<?=$bk_req_id?>" value="<?=isset($reference_no)?$reference_no:'';?>" />
                                    <input type="hidden" id="bk_user_id_<?=$bk_req_id?>" value="<?=isset($bk_user_id)?$bk_user_id:'';?>" />
                                    <input type="hidden" id="email_<?=$bk_req_id?>" value="<?=isset($email)?$email:'';?>" />
                                    <input type="hidden" id="request_date_<?=$bk_req_id?>" value="<?=isset($request_date)?$request_date:'';?>" />
                                    <input type="hidden" id="issue_date_<?=$bk_req_id?>" value="<?=isset($issue_date)?$issue_date:'';?>" />
                                    <input type="hidden" id="return_date_<?=$bk_req_id?>" value="<?=isset($return_date)?$return_date:'';?>" />
                                    <input type="hidden" id="book_name_<?=$bk_req_id?>" value="<?=isset($book_name)?$book_name:'';?>" />
                                    <input type="hidden" id="author_name_<?=$bk_req_id?>" value="<?=isset($author_name)?$author_name:'';?>"/>
                                    <input type="hidden" id="update_id_<?=$bk_req_id?>" value="<?=isset($bk_req_id)?$bk_req_id:'';?>" />
                                    <div class="row" style="margin-left:2%;margin-right:2%;padding:1%">
                                        <div class="col-6" >
                                            <label>Return Date :</label>
                                            <input class="form-control" type="date" name="return_date" id="retrun_date_<?php echo $bk_req_id; ?>" placeholder="Return date"  value="<?php echo date('Y-m-d');?>" required>
                                            <small></small>
                                        </div>
                                        
                                        <div class="col-6" >
                                            <label>Fine :</label>
                                            <input class="form-control me-3" name="fine" id="fine_<?php echo $bk_req_id; ?>" value="0" placeholder="Enter Fine" required>
                                        </div>
                                    </div>
                                
                            </div>
                            <?php
                            $rules = array(
                                'return_date' => 'required'
                            );
                            ?>
                            <div class="modal-footer" id="m_footer">
                                <input type="submit" class="btn btn-primary" value="Save" id="<?=$bk_req_id?>" onclick='retrun_issued_book(this,<?php echo json_encode($rules)  ?>,displayMessage)'>
                                <input type="button" class="btn btn-danger" data-dismiss="modal" value="Close">
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                       <tr>
                         <td><?php echo $sl_n++;?></td>
                         <td><?php echo $reference_no;?></td>
                         <td><?php echo $book_name;?></td>
                         <td><?php echo $author_name;?></td>
                         <td><?php echo $request_date;?></td>
                         <td><?php echo $issue_date;?></td>
                         <td><?php echo $return_date;?></td>
                         <td><?php echo $fine;?></td>
                         <td><?php echo $status;?></td>
                         <td><?php if($data=='2'){ ?>
                            <button type="button" class="btn btn-warning" data-toggle="modal" style="padding: 10px 10px;"
                                data-target="#detailsModal1_<?php echo $bk_req_id; ?>">Return</button>
                       <?php  }else
                       {
                        echo "N/A";
                       }
                         ?>
                         </td>
                     </tr>

                       <?php }  exit;
}
?>
<style>
#customers th {
  padding-top: 1px;
  padding-bottom: 1px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
<table id="case_law" class="table">
    <thead class="" style="background: #315682;color:#fff;">
        <th style="width:50px;">Sl No</th>
        <th>Name </th>
        <th>Email</th>
        <th>Phone</th>
        <th>Designation</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php 
                           // print_r($res_book);
                            $sl_no=1;
							$book_list = array();
                           foreach($res_book as $res)
                           {
                            $id=$res['id'];
                            //$f_name=$res['f_name'];
                          //  $l_name=$res['l_name'];
                            $bk_rq_id=$res['bk_rq_id']; 
                            if(isset($res['name']))
                            {
                                $name=$res['name']; 
                            }
                            if(!empty($res['f_desig']))
                            {
                                $desig=$res['f_desig'];
                            }
                            else if(!empty($res['s_desig']))
                            {
                                $desig=$res['s_desig'];
                            }
                            else if(!empty($res['d_desig']))
                            {
                                $desig=$res['d_desig'];
                            }
                            else{
                                $desig="Trainee";
                            }
                            if(!empty($res['phone']))
                            {
                                $phone=$res['phone'];
                            }
                            else if(!empty($res['t_phone'])){
                                $phone=$res['t_phone'];
                            }
                            else if(!empty($res['s_phone'])){
                                $phone=$res['s_phone'];
                            }else if(!empty($res['d_phone'])){
                                $phone=$res['d_phone'];
                            }
							
                            $f_email=$res['f_email'];
                            $t_email=$res['email'];
                            $s_email=$res['s_email'];
                            $d_email=$res['d_email'];
                            if(!empty($f_email))
                            {
                                $email=$f_email;
                            }
                            else if(!empty($t_email)){
                                $email=$t_email;
                            }
                            else if(!empty($s_email)){
                                $email=$s_email;
                            } 
                            else if(!empty($d_email)){
                                $email=$d_email;
                            }   						
                            $bk_user_id=$res['user_id']; 

                            ?>
      <tr>
        <td><?php echo $sl_no;?></td>
        <td><?php echo $name;?></td>
        <td><?php echo $email;?></td>
        <td><?php echo $phone;?></td>
        <td><?php echo $desig;?></td>
        <td><button type="button" class="btn btn-warning clickable" onclick="get_user_issue_return_data(2,<?=$bk_user_id?>,'<?=$email?>');" data-toggle="collapse" style="padding: 6px 7px;color:black;font-weight:600"
        data-target="#accordion_<?=$bk_rq_id?>" >Issued Book
                                </button>
        <button type="button" class="btn btn-success clickable" data-toggle="collapse"  onclick="get_user_issue_return_data(4,<?=$bk_user_id?>,'<?=$email?>');" style="padding: 6px 7px;font-weight:600"
        data-target="#accordion_<?=$bk_rq_id?>" >Returned Book
                                </button> </td>
    </tr>
    <tr>
        <td colspan="6">
          <?php
         //$db->select('tbl_book_request_issue',"tbl_bk_reqst.*,tbl_book_details.book_name,tbl_book_details.author_name",' tbl_bk_reqst join 
        // tbl_book_details on tbl_bk_reqst.book_id=tbl_book_details.id','user_id= "'.$user_id.'"',null,null);
                              // $res_req= $db->getResult();
          ?>
            <div id="accordion_<?=$bk_rq_id?>" class="collapse">
            <table id="customers" class="table" style="border-top: 3px solid #00acc1;">
            <thead class="" style="background-color: #04AA6D;color:#fff;">
            <th>Sl No</th>
            <th>Accession No.</th>
            <th>Book Name</th>
            <th>Author Name</th>
            <th>Request Date</th>
            <th>Issue Date</th>
            <th>Return Date</th>
            <th>Fine</th>
            <th>Status</th>
            <th>Action</th>
    </thead>
            <tbody id="data_bind">
            </tbody>
            </table>
            </div>
        </td>
    </tr>
        <?php   }
                            ?>
    </tbody>
</table>

<script>
function get_user_issue_return_data(data,bk_user_id,email)
{
    $.ajax({
        type: "POST",
        url: "get_user_list.php",
        data: { 'action':'user_list','data':data,'bk_user_id':bk_user_id,'email':email},
        success: function(res) {
           console.log(res);
           //alert(res);
           $('#data_bind').html(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                sessionStorage.type = "success"
                showMessage();
                //location.reload();
                $('.modal-backdrop').remove();
            }
        }
    })
}
function retrun_issued_book(data,rules,callback)
{
    var csrf_token = $('#csrf_token').val();
    var req_bk_id=data.id;
    var bk_user_id = $('#bk_user_id_'+req_bk_id).val();
    var email = $('#email_'+req_bk_id).val();
    var request_date = $('#request_date_'+req_bk_id).val();
    var issue_date = $('#issue_date_'+req_bk_id).val();
    var book_ref_id = $('#reference_no_'+req_bk_id).val();
    var return_date = $('#retrun_date_'+req_bk_id).val();
    var fine = $('#fine_'+req_bk_id).val();
    var user_name='<?php echo $user_name;?>';
    var phone_num='<?php echo $phone_no;?>';
    //alert(book_ref_id); return false;
    var book_name = $('#book_name_'+req_bk_id).val();
    var author_name = $('#author_name_'+req_bk_id).val();
    let subject = "Return of Book";
    let email_body = "<p>Dear "+ name + "</p> <br>"
			                    +"<p>The following book has been returned :</p><br>"
								+"Title: "+ book_name+ "<br>"
								+"Author Name: " + author_name + "<br>"
								+"Accession No: " + book_ref_id +" <br><br><br>"
								+"Thank You <br>"
								+"Library, MDRAFM <br>"
    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: { 'action':'update_return_tbl','return_date':return_date,'fine':fine,'bk_req_id':req_bk_id,'bk_user_id':bk_user_id,'book_ref_id':book_ref_id,'issue_date':issue_date,
            'table1':'tbl_book_request_issue','table2':'tbl_book_reference_no','csrf_token': csrf_token,'rules': JSON.stringify(rules)},
        success: function(res) {
            console.log(res);
            callback(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                sendEmail(email,subject,email_body);
                 //$('.modal-backdrop').remove();
                sessionStorage.message = "Book is returned successfully";
                sessionStorage.type = "success";
                showMessage();
                $('.modal-backdrop').remove();
                $('#detailsModal1_'+req_bk_id).hide();
               // location.reload();
               $('#clickable').removeAttr('collapsed');
                $("#clickable").setAttribute('aria-expanded', 'true');
               get_user_list(user_name,phone_num);  
            }else{
                sessionStorage.message = elm[1];
                sessionStorage.type = "error";
                showMessage();
                $('.modal-backdrop').remove();
            }
        }
    })
   // }
}
function sendEmail(email,subject,email_body){

//alert(email_body);
//console.log(email);
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
</script>