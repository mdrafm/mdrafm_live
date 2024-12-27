<?php 
session_start(); 
$book_name=$_POST['book_name'];
$author_name=$_POST['author_name'];
$acc_no=$_POST['acc_no'];

$user_id=$_SESSION['user_id'];
 if(isset($book_name) && empty($author_name) && empty($acc_no))
{
    include '../admin/database.php'; 
    $db = new Database(); 
    $db->select('tbl_book_details',"tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk_req.id as bk_req_id,tbl_bk_req.status,
    tbl_bk_req.issue_date,tbl_bk_req.no_of_days,tbl_bk_req.request_date",' tbl_bk JOIN tbl_book_reference_no tbl_bk_ref ON tbl_bk.id =tbl_bk_ref.tbl_book_id
     LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id and tbl_bk_req.status!=4','tbl_bk.book_name= "'.$book_name.'" and tbl_bk_ref.lost_status = 0
    GROUP BY tbl_bk.id',null,null);
}
else if(isset($author_name) && empty($book_name) && empty($acc_no))
{
    include '../admin/database.php'; 
    $db = new Database(); 
    $db->select('tbl_book_details',"tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk_req.id as bk_req_id,
    tbl_bk_req.status,tbl_bk_req.issue_date,tbl_bk_req.no_of_days,tbl_bk_req.request_date",' tbl_bk JOIN tbl_book_reference_no tbl_bk_ref ON tbl_bk.id =tbl_bk_ref.tbl_book_id 
    LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id and tbl_bk_req.status!=4','tbl_bk.author_name= "'.$author_name.'" and tbl_bk_ref.lost_status = 0  
    GROUP BY tbl_bk.id',null,null); 
}
else if(isset($acc_no) && empty($author_name) && empty($book_name))
{
    include '../admin/database.php'; 
    $db = new Database(); 
    $db->select('tbl_book_details',"tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk_req.id as bk_req_id,
    tbl_bk_req.status,tbl_bk_req.issue_date,tbl_bk_req.no_of_days,tbl_bk_req.request_date",' tbl_bk JOIN tbl_book_reference_no tbl_bk_ref ON tbl_bk.id =tbl_bk_ref.tbl_book_id 
    LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id and tbl_bk_req.status!=4','tbl_bk_ref.reference_no= "'.$acc_no.'" and tbl_bk_ref.lost_status = 0  
    GROUP BY tbl_bk.id',null,null); 
}
else if(isset($author_name) && isset($book_name) && isset($acc_no))
{
    include '../admin/database.php'; 
    $db = new Database(); 
    $db->select('tbl_book_details',"tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk_req.id as bk_req_id,tbl_bk_req.status,
    tbl_bk_req.issue_date,tbl_bk_req.no_of_days,tbl_bk_req.request_date",' tbl_bk JOIN tbl_book_reference_no tbl_bk_ref ON tbl_bk.id =tbl_bk_ref.tbl_book_id 
    LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id and tbl_bk_req.status!=4','tbl_bk.author_name= "'.$author_name.'" and tbl_bk_ref.lost_status = 0
    and tbl_bk.book_name= "'.$book_name.'" and tbl_bk_ref.reference_no= "'.$acc_no.'"  GROUP BY tbl_bk.id',null,null);
}
$res_book = $db->getResult();
//print_r($res_book);

?>
<table id="case_law" class="table">
    <thead class="" style="background: #315682;color:#fff;">
        <th style="width:50px;">Sl No</th>
        <th>Book Name </th>
        <th>Author Name</th>
        <th>quantity</th>
        <th>Request Date</th>
        <th>Issue Date</th>
        <th>Due Date</th>
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
                            $bk_req_id=$res['bk_req_id'];
                            $book_name2=$res['book_name'];
                            $author_name=$res['author_name']; 
						    array_push($book_list,$book_name);
                            $issue_date=$res['issue_date'];
                            $no_of_days=$res['no_of_days'];
                            $quantity=$res['quantity'];
                            //$request_date=$res['request_date'];
                            $sql_quant = 'SELECT count(*) as qnt_avail FROM tbl_book_request_issue WHERE book_id= "'.$id.'" and status = 2';
                            $res_book_quantity = $db->select_sql_row($sql_quant); 
                            if($quantity > $res_book_quantity->qnt_avail)
                            {
                                $tot_qunt= $quantity - $res_book_quantity->qnt_avail;
                            }
                            else{
                                $tot_qunt=$quantity;
                            }
                            ?>
        <tr>
            <td><?php echo $sl_no++;?></td>
            <td><?php echo $book_name2?></td>
            <td><?php echo $author_name?></td>
            <td><?php echo $tot_qunt?></td>
            <?php 
                               
                                //$sql = 'SELECT * FROM tbl_book_request_issue WHERE id= "'.$bk_req_id.'" and user_id ="'.$user_id.'"';
                               // $res_book= $db->select_sql($sql);
                               $sql = 'SELECT * FROM tbl_book_request_issue WHERE book_id= "'.$id.'" and user_id ="'.$user_id.'" and status!=4';
                               $res_book=$db->select_sql_row($sql);
                                //$res_book = $db->getResult();
                                $db->select('tbl_book_reference_no',"*",null,'tbl_book_id= "'.$id.'" and status=0',null,null);
                                $res_book_ref = $db->getResult();
                                // print_r( $res_book);
                               if(!empty($res_book))
                               {
                                $issue_date=$res_book->issue_date;
                                $no_of_days=$res_book->no_of_days;
                                $status=$res_book->status;
                                $request_date=$res_book->request_date;
                                $due_date=date('d-m-Y', strtotime($issue_date. "+".$no_of_days."days"));
                               }                            
                                //$row = $db->fetch_row();
                                //echo $status=$row['status']; 
                               //echo $issue_date=$row['issue_date']; 
                               //echo $no_of_days=$row['no_of_days']; 
                                ?>
            <td><?php if(!empty($request_date))
                                {
                                    echo date('d-m-Y',strtotime($request_date));
                                }
                               else
                               {
                                    echo "N/A";
                               } ?> </td>
            <td><?php if(isset($issue_date) && $issue_date !="0000-00-00")
                                {
                                    echo date('d-m-Y',strtotime($issue_date));
                                }
                               else
                               {
                                    echo "N/A";
                               } ?> </td>
            <td>
                <?php if(isset($no_of_days) && $no_of_days !="0")
                                {
                                    echo $due_date;
                                }
                               else
                               {
                                    echo "N/A";
                               } ?>
            </td>
            <td>
                <form id="frm_insert">
                    <?php //echo $_SESSION['user_id']; ?>
                    <input type="hidden" name="book_id" value="<?=$id?>" id="book_id_<?=$id?>" />
                    <?php
                                if(!empty($res_book) && $status==1)
                                { 
                                    if(!empty($res_book_ref)){?>
                                <span style="color:#ed7d0a;padding-right:5px;font-size: 15px;font-weight: 700">Book Request
                                    sent</span>
                                <?php } else {?>
                                <span style="color:red;padding-right:5px;font-size: 15px;font-weight: 700;">Check Out</span>
                                <?php } ?>
                                <input type="button" class="btn btn-danger" value="Cancel" id="<?=$bk_req_id?>"
                                    onclick="cancel_book_request(this)" />
                                <div id="loader2_<?=$bk_req_id?>" style="display: none" ;>
                                    <img src="../admin/assets/img/loader.gif" alt="Loading" style="width: 150px;height: 50px;" />
                                </div>
                                <?php }
                              else if(!empty($res_book) && $status==2)
                              { ?>
                    <span style="color:#2ecc71;padding-right:5px;font-size: 15px;font-weight: 700;color:#1aaf08">Book
                        Issued</span>
                    <?php }
                               else{ 
                                if(!empty($res_book_ref))
                                { ?>
                    <input type="button" class="btn btn-primary" value="Book Request" id="<?=$id?>"
                        onclick="book_request(this)" />
                    <div id="loader1_<?=$id?>" style="display: none" ;>
                        <img src="../admin/assets/img/loader.gif" alt="Loading" style="width: 150px;height: 50px;" />
                        <?php }else{?>
                        <span style="color:red;padding-right:5px;font-size: 15px;font-weight: 700;">Check Out</span>
                        <?php }
                                        ?>

                    </div>
                    <?php } ?>


                </form>
            </td>

        </tr>
        <?php   }
                            ?>
    </tbody>
</table>

<script>
function book_request(data) {

    if (confirm('Are you sure to send request ?')) {
        var bk_id = data.id;
        var user_id = '<?php echo $_SESSION['user_id']; ?>';
        var request_date = '<?php echo date("Y-m-d");?>';
        var book_id = $('#book_id_' + bk_id).val();
        var author_name = '<?php echo $author_name ;?>';
        var book_name = '<?php echo $book_name ;?>';
        var acc_no = '<?php echo $acc_no ;?>';
        $.ajax({
            method: "POST",
            url: "ajax_case_master.php",
            data: {
                'user_id': user_id,
                'book_id': book_id,
                'request_date': request_date,
                'action': 'book_request',
                'update_id': '',
                'table': 'tbl_book_request_issue'
            },
            beforeSend: function() {
                $(`#loader1_${bk_id}`).show();
                $(`#${bk_id}`).hide();
                $('.loader_img').hide();
                //  $('#send_email').prop('disabled', true);
            },
            success: function(res) {
                console.log(res);
                let elm = res.split('#');
                if (elm[0] == "success") {

                    get_member_book_list(book_name, author_name,acc_no);
                    sessionStorage.message = "Book issue request are successfully sent.";
                    sessionStorage.type = "success";
                    showMessage();
                    // location.reload();    
                }

            }
        })
    } else {
        return false;
    }
}

function cancel_book_request(data) {
    var auto_bk_id = data.id;
    var author_name = '<?php echo $author_name ;?>';
    var book_name = '';
    var acc_no = '<?php echo $acc_no ;?>';
    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: {
            action: "delete_data",
            delete_id: auto_bk_id,
            table: "tbl_book_request_issue",
        },
        beforeSend: function() {
            $(`#loader2_${auto_bk_id}`).show();
            $(`#${auto_bk_id}`).hide();
            $('.loader_img').hide();
            //  $('#send_email').prop('disabled', true);
        },
        success: function(res) {
            console.log(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                get_member_book_list(book_name, author_name,acc_no);
                sessionStorage.message = "Book request is cancelled successfully";
                sessionStorage.type = "error";
                showMessage();
                //location.reload();
            }
        }
    })
}
</script>