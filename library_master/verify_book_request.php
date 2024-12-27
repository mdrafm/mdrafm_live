<?php 
session_start(); 
$req_upto_date=$_POST['req_upto_date'];
if(isset($req_upto_date))
{
    include '../admin/database.php'; 
    $db = new Database(); 
    $db->select('tbl_book_details',"tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk_req.id as bk_req_id,tbl_bk_req.request_date,
    tbl_bk_req.status,tbl_user.name,tbl_fclty.desig as f_desig,tbl_fclty.phone,tbl_trainee.phone as t_phone,tbl_bk_req.issue_date,tbl_bk_req.no_of_days,tbl_staff.phone as s_phone,tbl_staff.email as s_email,tbl_staff.desig as s_desig,tbl_dpt_trne.designation as d_desig,tbl_dpt_trne.phone as d_phone,tbl_dpt_trne.email as d_email",' 
    tbl_bk JOIN tbl_book_reference_no tbl_bk_ref ON tbl_bk.id =tbl_bk_ref.tbl_book_id 
    LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id JOIN tbl_user ON tbl_user.id =tbl_bk_req.user_id left outer join tbl_new_recruite as tbl_trainee 
    on tbl_trainee.user_id= tbl_bk_req.user_id left outer join tbl_faculty_master as tbl_fclty 
    on tbl_fclty.user_id= tbl_bk_req.user_id left outer join tbl_staf_master as tbl_staff
    on tbl_staff.user_id= tbl_bk_req.user_id left outer join tbl_dept_trainee_registration as tbl_dpt_trne on tbl_dpt_trne.user_id= tbl_bk_req.user_id','tbl_bk_req.request_date <= "'.$req_upto_date.'" and tbl_bk_req.status <= "1"
    GROUP BY tbl_bk_req.id',null,null); 
    $res_book = $db->getResult();
}
else{
  $res_book=array();
}
//print_r($res_book);
?>
 <table id="book_table" class="table">
                            <thead class="" style="background: #315682;color:#fff;">
                            <th style="width:50px;">Sl No</th>
                            <th>Date</th>
                            <th>Name </th>
                            <th>Designation</th>
                            <th>Book Name</th>
                            <th>Author Name</th>
                            <th>Phone</th>
                            <th>Issue Date</th>
                            <th>No of Days</th>
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
                            $issue_date=$res['issue_date'];
                            $no_of_days=$res['no_of_days'];
                            //$designation=$res['desig'];
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
                            ?>
                            <tr>
                                <td><?php echo $sl_no++;?></td>
                                <td><?php echo date('d-m-Y',strtotime($request_date))?></td>
                                <td><?php echo $name?></td>
                                <td><?php echo $desig?></td>
                                <td><?php echo $book_name?></td>
                                <td><?php echo $author_name?></td>
                                <td><?php echo $phone?></td>
                                <?php   $sql = 'SELECT * FROM tbl_book_request_issue WHERE id= "'.$bk_req_id.'" ';
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
                                <td><?php if(isset($issue_date) && $issue_date !="0000-00-00")
                                {
                                    echo $issue_date;
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
                                <td>
                                <form id="frm_insert">
                                <?php //echo $_SESSION['user_id']; ?>
                                <input type="hidden" name="book_id" value="<?=$id?>" id="book_id_<?=$id?>"/>
                                <?php 
                                if(!empty($res_book) && $status==0)
                                { 
                               ?>
                                <button type="button" class="btn btn-primary" data-toggle="modal" style="padding: 10px 10px;" id="<?=$bk_req_id?>" onclick="verify_book_request(this)">
                                Verify Request
                                </button>
                                <span id="vry_msg_<?=$bk_req_id?>" style="color:#2ecc71;padding-right:5px;font-size: 15px;font-weight: 700;display:none">Book Verified</span>   
                                <?php }
                               else if(!empty($res_book) && $status==1)
                               { ?>
                               <span style="color:#2ecc71;padding-right:5px;font-size: 15px;font-weight: 700">Book Verified</span>     
                              <?php }?>
                                </form>
                                </td>
                            </tr>
                        <?php   }
                            ?>
                            </tbody>
                            </table>
                    
<script>
function verify_book_request(data)
{
    var req_bk_id=data.id;
    var req_upto_date= '<?php echo $req_upto_date ;?>';
    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: { 'action':'update_manual','status': '1','update_id':req_bk_id,'table':'tbl_book_request_issue'},
        success: function(res) {
           console.log(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                //verify_member_request_book_list(req_upto_date);
                sessionStorage.message = "Book request is verified successfully";
                sessionStorage.type = "success";
                showMessage();
                $("#"+req_bk_id).hide();
                $("#vry_msg_"+req_bk_id).show();
                //$("html, body").animate({ scrollTop: 0 }, "slow");
                //$("#vry_msg_").html("display","blcok");
                //location.reload();
            }
        }
    })
}
</script>

