<?php 
session_start(); 
$req_upto_date= $_POST['req_upto_date'];
$status_type= $_POST['status_type'];
if(isset($req_upto_date) && empty($status_type))
{
    include '../admin/database.php'; 
    $db = new Database(); 
    $db->select('tbl_book_details',"tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk_req.id as bk_req_id,tbl_bk_req.request_date,
    tbl_bk_req.status,tbl_user.name,tbl_fclty.desig as f_desig,tbl_fclty.phone,tbl_fclty.email,tbl_trainee.phone as t_phone,tbl_trainee.email as t_email,tbl_trainee.designation,tbl_trainee.trng_type as new_trng_type,tbl_trainee.program_id as new_program_id,tbl_bk_req.issue_date,
    tbl_bk_req.no_of_days,tbl_bk_req.return_date,tbl_bk_req.fine,tbl_bk_ref.reference_no,tbl_staff.phone as s_phone,tbl_staff.email as s_email,tbl_staff.desig as s_desig,tbl_dpt_trne.designation as d_desig,tbl_dpt_trne.phone as d_phone,tbl_dpt_trne.email as d_email,tbl_dpt_trne.trng_type as d_trng_type,tbl_dpt_trne.program_id as d_program_id",' 
    tbl_bk LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id left outer join tbl_book_reference_no tbl_bk_ref ON 
    tbl_bk_ref.id =tbl_bk_req.bk_ref_id JOIN tbl_user ON tbl_user.id =tbl_bk_req.user_id left outer join tbl_new_recruite as tbl_trainee 
    on tbl_trainee.user_id= tbl_bk_req.user_id left outer join tbl_faculty_master as tbl_fclty 
    on tbl_fclty.user_id= tbl_bk_req.user_id left outer join tbl_staf_master as tbl_staff
    on tbl_staff.user_id= tbl_bk_req.user_id left outer join tbl_dept_trainee_registration as tbl_dpt_trne on tbl_dpt_trne.user_id= tbl_bk_req.user_id and tbl_dpt_trne.trng_type != 5','tbl_bk_req.request_date <= "'.$req_upto_date.'" and tbl_bk_req.status >= "1" and tbl_dpt_trne.trng_type != 5
    GROUP BY tbl_bk_req.id','tbl_bk_req.request_date desc',null); 
    $res_book = $db->getResult();
}else if(isset($status_type) && empty($req_upto_date))
{
    include '../admin/database.php'; 
    $db = new Database(); 
    if($status_type=='1' || $status_type=='3')
    {
        $type='tbl_bk_req.request_date';
    }else if($status_type=='2')
    {
        $type='tbl_bk_req.issue_date';
    }
    else if($status_type=='4')
    {
        $type='tbl_bk_req.return_date';
    }
    $db->select('tbl_book_details',"tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk_req.id as bk_req_id,tbl_bk_req.request_date,
    tbl_bk_req.status,tbl_user.name,tbl_fclty.desig as f_desig,tbl_fclty.phone,tbl_fclty.email,tbl_trainee.phone as t_phone,tbl_trainee.email as t_email,tbl_trainee.designation,tbl_trainee.trng_type as new_trng_type,tbl_trainee.program_id as new_program_id,tbl_bk_req.issue_date,
    tbl_bk_req.no_of_days,tbl_bk_req.return_date,tbl_bk_req.fine,tbl_bk_ref.reference_no,tbl_staff.phone as s_phone,tbl_staff.email as s_email,tbl_staff.desig as s_desig,tbl_dpt_trne.designation as d_desig,tbl_dpt_trne.phone as d_phone,tbl_dpt_trne.email as d_email,tbl_dpt_trne.trng_type as d_trng_type,tbl_dpt_trne.program_id as d_program_id",' 
    tbl_bk LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id left outer join tbl_book_reference_no tbl_bk_ref ON
     tbl_bk_ref.id =tbl_bk_req.bk_ref_id JOIN tbl_user ON tbl_user.id =tbl_bk_req.user_id left outer join tbl_new_recruite as tbl_trainee 
    on tbl_trainee.user_id= tbl_bk_req.user_id left outer join tbl_faculty_master as tbl_fclty 
    on tbl_fclty.user_id= tbl_bk_req.user_id left outer join tbl_staf_master as tbl_staff
    on tbl_staff.user_id= tbl_bk_req.user_id left outer join tbl_dept_trainee_registration as tbl_dpt_trne on tbl_dpt_trne.user_id= tbl_bk_req.user_id and tbl_dpt_trne.trng_type != 5','tbl_bk_req.status = "'.$status_type.'"
    GROUP BY tbl_bk_req.id',' '.$type.' desc',null); 
    $res_book = $db->getResult();
}
else{
  $res_book=array();
}
?>
<style>
small {
        font-size: 1rem;
        color:red
    }
    </style>
    <span style="padding:1%"><button class="btn btn-danger float-right" onclick="ExportToExcel('xlsx')">Export to
                                        excel</button></span>
 <table id="book_table" class="table">
                            <thead class="" style="background: #315682;color:#fff;">
                            <th style="width:25px;">Sl</th>
                            <th  style="width:55px;">Date</th>
                            <th>Name </th>
                            <th>Designation</th>
                            <th>Phone</th>
                            <th>Book Name</th>
                            <th  style="width:100px;">Author Name</th>
                            <th>Acc. No.</th>
                            <th>Issue Date</th>
                            <th>No of Days</th>
                            <th>Return Date</th>
                            <th>Fine</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            <?php 
                           // print_r($res_book);
                            $sl_no=1;
							
                           foreach($res_book as $res)
                           {
                            $id=$res['id'];
                            $bk_req_id=$res['bk_req_id'];
                            $request_date=$res['request_date'];
                            $name=$res['name'];
                            $book_name=$res['book_name'];
                            $author_name=$res['author_name'];
                            $reference_no=$res['reference_no'];
                            $issue_date=$res['issue_date'];
                            $no_of_days=$res['no_of_days'];
                            $return_date=$res['return_date'];
                            $fine=$res['fine'];
                            if(!empty($res['new_trng_type']))
                            {
                                $tranie_type=$res['new_trng_type'];
                            }else if(!empty($res['d_trng_type']))
                            {
                                $tranie_type=$res['d_trng_type'];
                            }
                            else
                            {
                                $tranie_type='';
                            }
                            if(!empty($res['new_program_id']))
                            {
                                $program_id=$res['new_program_id'];
                            }else if(!empty($res['d_program_id']))
                            {
                                $program_id=$res['d_program_id'];
                            }
                            else
                            {
                                $program_id='';
                            }
                            
                           // $designation=$res['s_desig'];
                            
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
                            else if(!empty($res['designation']))
                            {
                                $desig=$res['designation'];
                            }
                            else{
                                $desig="Trainee";
                            }
                            $phone_num=$res['phone'];
                            $t_phone=$res['t_phone'];
                            $s_phone=$res['s_phone'];
                            $d_phone=$res['d_phone'];
                            if(!empty($phone_num))
                            {
                                $phone=$phone_num;
                            }
                            else if(!empty($t_phone)){
                                $phone=$t_phone;
                            }
                            else if(!empty($s_phone)){
                                $phone=$s_phone;
                            }
                            else if(!empty($d_phone)){
                                $phone=$d_phone;
                            }
							
                            $f_email=$res['email'];
                            $t_email=$res['t_email'];
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
                            ?>
                            <tr>
                                <td style="text-align:center"><?php echo $sl_no++;?></td>
                                <td><?php echo date('d-m-Y',strtotime($request_date))?></td>
                                <td><?php echo $name?></td>
                                <td><?php echo $desig?></td>
                                <td><?=isset($phone)?$phone:''?></td>
                                <td><?php echo $book_name?></td>
                                <td><?php echo $author_name?></td>
                                <?php  
                                //echo $tranie_type;
                                if($tranie_type==1 || $tranie_type==2) 
                                        {
                                            $sql = 'SELECT provisonal_Sdate as start_date,provisonal_Edate as end_date FROM tbl_program_master WHERE id= "'.$program_id.'" and trng_type="'.$tranie_type.'"';
                                            $res_date= $db->select_sql_row($sql);
                                        }else if($tranie_type==3 or $tranie_type==7) 
                                        {
                                            $sql = 'SELECT start_date,end_date FROM tbl_mid_program_master WHERE id= "'.$program_id.'" and trng_type="'.$tranie_type.'"';
                                            $res_date= $db->select_sql_row($sql);
                                        }
                                        else
                                        {
                                            $res_date= '';
                                        }
                                        if(!empty($res_date))
                                        {
                                            $upto_st_date=$res_date->start_date;
                                            $upto_end_date=date('d-m-Y',strtotime($res_date->end_date));
                                        }else
                                        {
                                            $upto_end_date='';
                                        }

                                $sql = 'SELECT * FROM tbl_book_request_issue WHERE id= "'.$bk_req_id.'"';
                               $res_book= $db->select_sql_row($sql);
                               if(!empty($res_book))
                               {
                                $issue_date=$res_book->issue_date;
                                $no_of_days=$res_book->no_of_days;
                                $status=$res_book->status;
                               }
                               else{
                                $issue_date='';
                                $no_of_days='';
                                $status='';
                               }
                                //$row = $db->fetch_row();
                                //echo $status=$row['status']; 
                               //echo $issue_date=$row['issue_date']; 
                               //echo $no_of_days=$row['no_of_days']; 
                                ?>
                                 <td><?=isset($reference_no)?$reference_no:'';?></td>
                                
                                <td><?php if(isset($issue_date) && $issue_date !="0000-00-00")
                                {
                                    echo date('d-m-Y',strtotime($issue_date));
                                }
                               else
                               {
                                    echo "";
                               } ?> </td>
                                <td>
                                <?php if(isset($no_of_days) && $no_of_days !="0")
                                {
                                    echo $no_of_days;
                                }
                               else
                               {
                                    echo "";
                               } ?> 
                              </td> 
                              <td><?php if(isset($return_date) && $return_date !="0000-00-00")
                                {
                                    echo date('d-m-Y',strtotime($return_date));
                                }
                               else
                               {
                                    echo "";
                               } ?></td>
                              <td><?php if(isset($fine))
                                {
                                    echo $fine;
                                }
                               else
                               {
                                    echo "";
                               } ?></td>
                                <td>
                                <form id="frm_insert">
                                <?php //echo $_SESSION['user_id']; ?>
                                <input type="hidden" name="book_id" value="<?=$id?>" id="book_id_<?=$id?>"/>
                                <?php 
                                $db->select('tbl_book_request_issue',"*",null,'id= "'.$bk_req_id.'"',null,null);
                                $res_book = $db->getResult();
                                if(!empty($res_book) && $status==1)
                                { ?>
                                <button type="button" class="btn btn-primary" data-toggle="modal" style="padding: 10px 10px;"
                                data-target="#detailsModal_<?php echo $bk_req_id; ?>">
                                Issue Book
                                </button>
                                <?php }
                               else if(!empty($res_book) && $status==2)
                               { ?>
                               <span style="color:#2ecc71;padding-right:5px;font-size: 15px;font-weight: 700">Book Issued</span>   
                                <button type="button" class="btn btn-warning" data-toggle="modal" style="padding: 10px 10px;background:#0a95ff;border-color: #0a95ff;"
                                data-target="#detailsModal2_<?php echo $bk_req_id; ?>">Renew</button>
                              <?php }
                              else if(!empty($res_book) && $status==3)
                              { ?>
                                <span style="color:#e96b00;padding-right:5px;font-size: 15px;font-weight: 700">Book Not Available</span>
                             <?php }
                              else if(!empty($res_book) && $status==4)
                              { ?>
                                <span style="color:#0b3beb;padding-right:5px;font-size: 15px;font-weight: 700">Book Returned</span>
                             <?php }
                              ?>
                                </form>
                                </td>
                            </tr>
                      
                    <div id="detailsModal_<?php echo $bk_req_id; ?>" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content" style="width:200%;margin-left: -33%;">
                            <div class="modal-header"
                                style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, #00acc1 0%, #1abc9c 100%);;color: #fff;">
                                <h5 class="modal-title" id="m_title" style="color:#fff" style="text-align:center;"> Issue
                                    Details
                                </h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="frm_add_<?=$id?>">
                                <input type="hidden" name="csrf_token" id="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>" />
                                    <input type="hidden" id="reference_no_<?=$bk_req_id?>" value="<?=isset($reference_no)?$reference_no:'';?>" />
                                    <input type="hidden" id="update_id_<?=$id?>" value="<?=isset($id)?$id:'';?>" />

                                    <input type="hidden" id="email_id_<?=$bk_req_id?>" value="<?=isset($email)?$email:'';?>" />

                                     <input type="hidden" id="name_<?=$bk_req_id?>" value="<?=isset($name)?$name:'';?>" />

                                    <input type="hidden" id="update_id_<?=$bk_req_id?>" value="<?=isset($bk_req_id)?$bk_req_id:'';?>" />

                                    <input type="hidden" id="book_name_<?=$bk_req_id?>" value="<?=isset($book_name)?$book_name:'';?>" />

                                    <input type="hidden" id="author_name_<?=$bk_req_id?>" value="<?=isset($author_name)?$author_name:'';?>" />
                                    <input type="hidden" id="prog_end_date_<?=$bk_req_id?>" value="<?=isset($upto_end_date)?$upto_end_date:'';?>" />

                                    <div class="row" style="margin-left:2%;margin-right:2%;padding:1%">
                                        <div class="col-3">
                                            <label>Reference No :</label>
                                            <?php 
                                $db->select('tbl_book_reference_no',"*",null,'tbl_book_id= "'.$id.'" and status=0',null,null);
                                $res_book_ref = $db->getResult();
                                
                               // print_r($res_book_ref);
                                ?>   
                                        
                                        <select class="form-control me-2" aria-label="Default select example" id="book_ref_no_<?php echo $bk_req_id; ?>" name="book_ref_no">
                                        <option value="">Select Reference No.</option>
                                        <?php 
                                        if(!empty($res_book_ref)){
                                        foreach($res_book_ref as $res_ref)
                                        { 
                                        $reference_no=$res_ref['reference_no']; 
                                        $reference_id=$res_ref['id']; 
                                         ?>
                                        <option value="<?php echo $reference_id?>"><?php echo $reference_no?></option>
                                        <?php }
                                        }  ?>
                                        </select>
                                        <small></small>
                                        </div>
                                        <div class="col-5" >
                                            <label>Date :</label>
                                            <input class="form-control" type="date" name="issue_date" id="issue_date_<?php echo $bk_req_id; ?>" placeholder="Issue date"  value="<?php echo date('Y-m-d');?>" required>
                                            <small></small>
                                        </div>
                                        
                                        <div class="col-4" >
                                            <label>No.of days:</label>
                                            <input class="form-control me-3" name="no_of_days" id="no_of_days_<?php echo $bk_req_id; ?>" value="" placeholder="Enter No. of days" required>
                                            <small></small>
                                        </div>
                                    </div>
                                
                            </div>
                            <?php
                            $rules = array(
                                'book_ref_no' => 'select,accession no',
                                'issue_date' => 'required',
                                'no_of_days' => 'required',
                            );
                            ?>
                            <div class="modal-footer" id="m_footer">
                                <input type="submit" class="btn btn-primary" value="Issue" id="<?=$bk_req_id?>" onclick='issue_book_request(this,<?php echo json_encode($rules)  ?>,displayMessage)'>
                                <input type="submit" class="btn btn-warning" value="Reject Request" id="<?=$bk_req_id?>" onclick="reject_book_request(this)">
                                <input type="button" class="btn btn-danger" data-dismiss="modal" value="Close">
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
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
                                <form id="frm_ret_<?=$id?>">
                                    <input type="hidden" id="reference_no_<?=$bk_req_id?>" value="<?=isset($reference_no)?$reference_no:'';?>" />
                                    <input type="hidden" id="email_id_<?=$bk_req_id?>" value="<?=isset($email)?$email:'';?>" />
                                    <input type="hidden" id="name_<?=$bk_req_id?>" value="<?=isset($name)?$name:'';?>" />
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
                <div id="detailsModal2_<?php echo $bk_req_id; ?>" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content" style="width:100%;margin-top: 50%;float:right">
                            <div class="modal-header"
                                style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, #054b80 0%, #2c9ff5 100%);color: #fff;padding: 6px 10px;">
                                <h5 class="modal-title" id="m_title" style="color:#fff" style="text-align:center;"> Renew Details
                                </h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="frm_ret_<?=$id?>">
                                <input type="hidden" id="reference_no_<?=$bk_req_id?>" value="<?=isset($reference_no)?$reference_no:'';?>" />
                                    <input type="hidden" id="email_id_<?=$bk_req_id?>" value="<?=isset($email)?$email:'';?>" />
                                    <input type="hidden" id="name_<?=$bk_req_id?>" value="<?=isset($name)?$name:'';?>" />
                                    <input type="hidden" id="book_name_<?=$bk_req_id?>" value="<?=isset($book_name)?$book_name:'';?>" />
                                    <input type="hidden" id="author_name_<?=$bk_req_id?>" value="<?=isset($author_name)?$author_name:'';?>"/>
                                    <input type="hidden" id="update_id_<?=$id?>" value="<?=isset($id)?$id:'';?>" />
                                    <input type="hidden" id="update_id_<?=$bk_req_id?>" value="<?=isset($bk_req_id)?$bk_req_id:'';?>" />
                                    <div class="row" style="margin-left:2%;margin-right:2%;padding:1%">
                                        <div class="col-6" >
                                            <label>Renew Date :</label>
                                            <input class="form-control" type="date" name="renew_date" id="renew_date_<?php echo $bk_req_id; ?>" placeholder="Renew Date"  value="<?php echo date('Y-m-d');?>" required>
                                            <small></small>
                                        </div>
                                        <div class="col-6" >
                                            <label>No. of days :</label>
                                            <input class="form-control me-3" name="renew_no_of_days" id="renew_no_of_days_<?php echo $bk_req_id; ?>" value="0" placeholder="Enter Days" required>
                                            <small></small>
                                        </div>
                                    </div>
                                    <?php
                            $rules = array(
                                'renew_date' => 'required',
                                'renew_no_of_days' => 'required'
                            );
                            ?>
                            </div>
                            <div class="modal-footer" id="m_footer">
                                <input type="submit" class="btn btn-primary" value="Save" id="<?=$bk_req_id?>" onclick='renew_issued_book(this,<?php echo json_encode($rules)  ?>,displayMessage)'>
                                <input type="button" class="btn btn-danger" data-dismiss="modal" value="Close">
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <?php   }
                            ?>
                            </tbody>
                            </table>
 <script src="assets/js/common.js"> </script>
<script src="assets/js/form_validation.js"> </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
function issue_book_request(data,rules,callback)
{
    var csrf_token = $('#csrf_token').val();
    var req_bk_id=data.id;
    const book_ref_no_val = document.querySelector('#book_ref_no_'+req_bk_id);
    const issue_date_val = document.querySelector('#issue_date_'+req_bk_id);
    const no_of_days_val= document.querySelector('#no_of_days_'+req_bk_id);
    let isbook_ref_no_Valid = checkDropdown(book_ref_no_val);
        isissue_date_valid = checkTextField(issue_date_val);
        isno_of_days_valid = checkTextField(no_of_days_val);
        let isFormValid = isbook_ref_no_Valid &&
                           isissue_date_valid &&
                            isno_of_days_valid ;
    if(isFormValid){
    var request_date= '<?php echo $request_date ;?>';
    var req_upto_date= '<?php echo $req_upto_date ;?>';
    var book_ref_id = $('#book_ref_no_'+req_bk_id).val();
    var issue_date = $('#issue_date_'+req_bk_id).val();
    var no_of_days = $('#no_of_days_'+req_bk_id).val();
    var email = $('#email_id_'+req_bk_id).val();
    var name = $('#name_'+req_bk_id).val();
    var book_name = $('#book_name_'+req_bk_id).val();
    var author_name = $('#author_name_'+req_bk_id).val();
    var prog_end_date = $('#prog_end_date_'+req_bk_id).val();
    var new_dt = new Date(issue_date);
    var gt_date=new_dt.getDate();
    var nos_day = parseInt(no_of_days);
    var due_date=new_dt.setDate(gt_date + nos_day);
	var status_type= '<?php echo $status_type ;?>';
	var book_ref_no = $(`#book_ref_no_${req_bk_id} option:selected`).text();
	//alert(email);
    var nw_due_date=formatDate(new Date(due_date));
    console.log(prog_end_date);
    //console.log(nw_due_date);
    let subject = "Issue of Book";
    let email_body = "<p>Dear "+ name + "</p> <br>"
			                    +"<p>The following book has been issued :</p><br>"
								+"Title: "+ book_name+ "<br>"
								+"Author Name: " + author_name + "<br>"
								+"Accession No: " + book_ref_no +" <br>"
                                +"Due Date: " + nw_due_date +" <br><br><br><br>"
								+"Thank You <br>"
								+"Library, MDRAFM <br>"
    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: { 'action':'update_issue_tbl','book_ref_no':book_ref_id,'request_date':request_date,'issue_date':issue_date,'prog_end_date':prog_end_date,
            'nw_due_date':nw_due_date,'no_of_days':no_of_days,'issue_update_id':req_bk_id,'table1':'tbl_book_request_issue','table2':'tbl_book_reference_no','csrf_token': csrf_token,'rules': JSON.stringify(rules)},
        success: function(res) {
        // alert(res);
        console.log(res);
        
            let elm = res.split('#');
            console.log(elm[0]);
            if (elm[0] == "success") {
                callback(res);
                // get_member_request_book_list(req_upto_date);
				 get_member_request_book_list(req_upto_date,status_type);  
				  sendEmail(email,subject,email_body);
                 //$('.modal-backdrop').remove();
                sessionStorage.message = "Book is issued successfully";
                sessionStorage.type = "success";
                showMessage();
                $('.modal-backdrop').remove();
            }else{
                
                sessionStorage.message = elm[1];
                sessionStorage.type = "error";
                showMessage();
                $('.modal-backdrop').remove();
            }
        }
    })
   }
   
}
function formatDate(date) {
   if(date.getMonth()< 9){
    var set_zero='0';
   }
   else
   {
    var set_zero='';
   }
    return set_zero + date.getDate() + '-' + set_zero + (date.getMonth()+ 1)  + '-' + date.getFullYear();
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
function retrun_issued_book(data,rules,callback)
{
    var csrf_token = $('#csrf_token').val();
    var req_bk_id=data.id;
    // const return_date_val = document.querySelector('#retrun_date_'+req_bk_id);
    // let isissue_date_valid = checkTextField(return_date_val);
    // let isFormValid =  isissue_date_valid ;
    // if(isFormValid){
    var request_date= '<?php echo $request_date ;?>';
    var req_upto_date= '<?php echo $req_upto_date ;?>';
    var issue_date= '<?php echo $issue_date ;?>';
   // alert(issue_date);
    var book_ref_id = $('#reference_no_'+req_bk_id).val();
    var return_date = $('#retrun_date_'+req_bk_id).val();
    var fine = $('#fine_'+req_bk_id).val();
    var status_type= '<?php echo $status_type ;?>';
    //alert(book_ref_id); return false;
    var email = $('#email_id_'+req_bk_id).val();
    var name = $('#name_'+req_bk_id).val();
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
        data: { 'action':'update_return_tbl','return_date':return_date,'fine':fine,'bk_req_id':req_bk_id,'book_ref_id':book_ref_id,'issue_date':issue_date,
            'table1':'tbl_book_request_issue','table2':'tbl_book_reference_no','csrf_token': csrf_token,'rules': JSON.stringify(rules)},
        success: function(res) {
            console.log(res);
            callback(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                 get_member_request_book_list(req_upto_date,status_type);
                 sendEmail(email,subject,email_body);
                 //$('.modal-backdrop').remove();
                sessionStorage.message = "Book is returned successfully";
                sessionStorage.type = "success";
                showMessage();
                $('.modal-backdrop').remove();
            }else{
                sessionStorage.message = elm[1];
                sessionStorage.type = "error";
                showMessage();
                $('.modal-backdrop').remove();
            }
        }
    })
    //}
}
function reject_book_request(data)
{
    var req_bk_id=data.id;
    var req_upto_date= '<?php echo $req_upto_date ;?>';
    var status_type= '<?php echo $status_type ;?>';
    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: { 'action':'update_manual','update_id':req_bk_id,'status':3,'table':'tbl_book_request_issue'},
        success: function(res) {
           console.log(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                get_member_request_book_list(req_upto_date,status_type);
                sessionStorage.message = "Sent notification successfully";
                sessionStorage.type = "success";
                showMessage();
                //location.reload();
                $('.modal-backdrop').remove();
            }
        }
    })
}
function renew_issued_book(data,rules,callback)
{
    var csrf_token = $('#csrf_token').val();
    var req_bk_id=data.id;
    // const renew_date_val = document.querySelector('#renew_date_'+req_bk_id);
    // const renew_no_of_days_val= document.querySelector('#renew_no_of_days_'+req_bk_id);
    // let isrenew_date_valid = checkTextField(renew_date_val);
    // let isrenew_days_valid = checkTextField(renew_no_of_days_val);
    // let isFormValid =  isrenew_date_valid && isrenew_days_valid;
    // //alert(isFormValid); return false;
    // if(isFormValid){
    var request_date= '<?php echo $request_date ;?>';
    var req_upto_date= '<?php echo $req_upto_date ;?>';
    var issue_date= '<?php echo $issue_date ;?>';
    var status_type= '<?php echo $status_type ;?>';
    var book_ref_id = $('#reference_no_'+req_bk_id).val();
    var renew_date = $('#renew_date_'+req_bk_id).val();
    var no_days = $('#renew_no_of_days_'+req_bk_id).val();
    var email = $('#email_id_'+req_bk_id).val();
    var name = $('#name_'+req_bk_id).val();
    var book_name = $('#book_name_'+req_bk_id).val();
    var author_name = $('#author_name_'+req_bk_id).val();
    var new_dt = new Date(renew_date);
    var gt_date=new_dt.getDate();
    var nos_day = parseInt(no_days);
    var due_date=new_dt.setDate(gt_date + nos_day);
    var nw_due_date=formatDate(new Date(due_date));
                let subject = "Renew of Book";
                let email_body = "<p>Dear "+ name + "</p> <br>"
			                    +"<p>The following book has been renewed :</p><br>"
								+"Title: "+ book_name+ "<br>"
								+"Author Name: " + author_name + "<br>"
								+"Accession No: " + book_ref_id +" <br>"
                                +"Due Date: " + nw_due_date +" <br><br><br><br>"
								+"Thank You <br>"
								+"Library, MDRAFM <br>"
    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: { 'action':'insert_renew_tbl','renew_date':renew_date,'renew_no_of_days':no_days,'bk_req_id':req_bk_id,'table1':'tbl_book_renew',
            'table2':'tbl_book_request_issue','csrf_token': csrf_token,'rules': JSON.stringify(rules)},
        success: function(res) {
            console.log(res);
            callback(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                 get_member_request_book_list(req_upto_date,status_type);
                 sendEmail(email,subject,email_body);
                 //$('.modal-backdrop').remove();
                sessionStorage.message = "Book is renewed successfully";
                sessionStorage.type = "success";
                showMessage();
                $('.modal-backdrop').remove();
            }else{
                sessionStorage.message = elm[1];
                sessionStorage.type = "error";
                showMessage();
                $('.modal-backdrop').remove();
            }
        }
    })
    //}
}
function ExportToExcel(type, fn, dl) {
    var elt = document.getElementById('book_table');
    var wb = XLSX.utils.table_to_book(elt, {
        sheet: "sheet1"
    });
    return dl ?
        XLSX.write(wb, {
            bookType: type,
            bookSST: true,
            type: 'base64'
        }) :
        XLSX.writeFile(wb, fn || ('BOOKLIST.' + (type || 'xlsx')));
}
</script>
