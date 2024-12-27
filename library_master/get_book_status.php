<?php 
$book_ref_no=$_POST['ref_no']; 
if(isset($book_ref_no))
{
    include '../admin/database.php'; 
    $db = new Database(); 
    $db->select('tbl_book_reference_no',"tbl_bk_ref.*,tbl_bk.book_type as bk_type_id,tbl_book_type.book_type,tbl_subject_name.book_type as subject_name,tbl_bk.subject_id",' tbl_bk_ref left JOIN tbl_book_details 
    tbl_bk ON tbl_bk.id =tbl_bk_ref.tbl_book_id left join tbl_book_type on tbl_book_type.id=tbl_bk.book_type left join tbl_subject_name on tbl_subject_name.id=tbl_bk.subject_id','tbl_bk_ref.reference_no= "'.$book_ref_no.'" and tbl_bk.status=0',null,null); 
}
$res_book = $db->getResult(); 

$db->select('tbl_book_type',"*",null,null,null,null);
$res_book_cat = $db->getResult(); 
$db->select('tbl_subject_name',"*",null,null,null,null);
$res_book_sub = $db->getResult(); 
if(!empty($res_book))
{ ?>
<table id="case_law" class="table">
<h4 align="center">Book Details</h4>
    <thead class="" style="background: #315682;color:#fff;">
        <th style="width:50px;">Sl No</th>
        <th>Acc. No.</th>
        <th>Book Name </th>
        <th>Author Name</th>
        <th>Edition</th>
        <th>Price</th>
        <!-- <th>Year</th>
        <th>Place & Publisher</th>
        <th>Page</th>
        <th>Price</th>
        <th>Location</th>
        <th>Row</th> -->
        <th>No.of Times Issued</th>
        <th>Status</th>
    </thead>
    <tbody>
        <?php 
                            //print_r($res_book);
                            $sl_no=1;
                           foreach($res_book as $res)
                           {
                            $id=$res['id'];
                            $book_id=$res['tbl_book_id'];
                            $bk_ref_id=$res['id'];
                            $book_ref_no=$res['reference_no'];
                            $book_name=$res['book_name'];
                            $author_name=$res['author_name'];
                            $edition=$res['edition'];
                            $year_of_publication=$res['year_of_publication'];
                            $place_publisher=$res['place_publisher'];
                            $volume=$res['volume'];
                            $page=$res['page'];
                            $price=$res['price'];
                            $location=$res['location'];
                            $row=$res['row'];
                            $book_type=$res['book_type'];
                            $book_type_id=$res['bk_type_id'];
                            $subject_id=$res['subject_id'];
                            $bk_ref_status=$res['status'];
                            
                           // $db->select('tbl_book_request_issue',"count(*) as tot_issue",null,'book_id="'.$book_id.'" and bk_ref_id="'.$bk_ref_id.'"',null,null);
                            $sql = 'SELECT count(*) as tot_issue FROM tbl_book_request_issue WHERE bk_ref_id= "'.$bk_ref_id.'" and book_id ="'.$book_id.'" and (status =2 or status=4)';
                            $res_book = $db->select_sql_row($sql);
                            $tot_issue=$res_book->tot_issue;
                           $sql1 = 'SELECT tbl_user.name FROM tbl_book_request_issue join tbl_user on tbl_user.id=tbl_book_request_issue.user_id WHERE tbl_book_request_issue.bk_ref_id= "'.$bk_ref_id.'" and tbl_book_request_issue.book_id ="'.$book_id.'" and tbl_book_request_issue.status =2';
                            $res_user_name = $db->select_sql_row($sql1);

                            if(!empty($res_user_name))
                            {
                                $usr_name=$res_user_name->name;
                            }else{
                                $usr_name='';
                            }
                            if($bk_ref_status==1 and !empty($res_user_name->name))
                            {
                                $sts="Borrowed by ".ucfirst(strtolower($usr_name));
                                $stl='style="color:red;font-weight:600"';
                                $span_stl='style="background-color:#ffe26c;width:10px;padding:4px"';
                            }else
                            {
                                $sts="Available";
                                $stl='style="color:black;font-weight:600"';
                                $span_stl='style="background-color:#05ef18f5;width:10px;padding:4px"';
                            }
                            ?>
        <tr>
            <td><?php echo $sl_no++;?></td>
            <td><?=isset($book_ref_no)?$book_ref_no:''?></td>
            <td><?=isset($book_name)?$book_name:''?></td>
            <td><?=isset($author_name)?$author_name:''?></td>
            <td><?=isset($edition)?$edition:''?></td>
            <td><?=isset($price)?$price:''?></td>
            <!-- <td><?php //echo $year_of_publication?></td>
            <td><?php //echo $place_publisher?></td>
            <td><?php //echo $page?></td>
            <td><?php //echo $location?></td>
            <td><?php //echo $row?></td> -->
            <td><?=isset($tot_issue)?$tot_issue:''?></td>
           
            <td <?= $stl?>><span <?=$span_stl?>><?=isset($sts)?$sts:''?></span></td>
        </tr>
        <?php   }
                           ?>
    </tbody>
</table>
<?php } else 
{
    echo '<b style="color:red">No data found</b>';
}
?>
