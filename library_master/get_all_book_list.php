<?php 
 include '../admin/database.php'; 
 $db = new Database(); 
$db->select('tbl_book_reference_no',"tbl_bk_ref.*,tbl_bk.book_type as bk_type_id,tbl_book_type.book_type,tbl_subject_name.book_type as subject_name,
tbl_bk.subject_id",' tbl_bk_ref JOIN tbl_book_details 
tbl_bk ON tbl_bk.id =tbl_bk_ref.tbl_book_id left outer join tbl_book_type on tbl_book_type.id=tbl_bk.book_type 
left outer join tbl_subject_name on tbl_subject_name.id=tbl_bk.subject_id',null,'tbl_bk_ref.reference_no',null);
$res_book = $db->getResult(); 
?>
            <span style="padding:1%"><button class="btn btn-danger float-right" onclick="ExportToExcel('xlsx')">Export to
                                        excel</button></span>
                            <?php 
if(!empty($res_book))
{ ?>

<table id="case_law" class="table">
<h4 align="center">Book Details</h4>
    <thead class="" style="background: #315682;color:#fff;" >
        <th style="width:50px;">Sl No</th>
        <th>Acc. No.</th>
        <th>Book Name </th>
        <th>Author Name</th>
        <th>Edition</th>
        <th>Year</th>
        <th>Place & Publisher</th>
        <th>Page</th>
        <th>Price</th>
        <th>quantity</th>
        <th>Location</th>
        <th>Row</th>
        <th>Book Type</th>
    </thead>
    <tbody id="mytable">
        <?php 
                            //print_r($res_book);
                            $sl_no=1;
                           foreach($res_book as $res)
                           {
                            $id=$res['id'];
                            $book_id=$res['tbl_book_id'];
                            $book_ref_no=$res['reference_no'];
                            $book_name=$res['book_name'];
                            $author_name=$res['author_name'];
                            $edition=$res['edition'];
                            $year_of_publication=$res['year_of_publication'];
                            $place_publisher=$res['place_publisher'];
                            //$volume=$res['volume'];
                            $page=$res['page'];
                            $price=$res['price'];
                          //  $quantity=$res['quantity'];
                            $location=$res['location'];
                            $row=$res['row'];
                            $book_type=$res['book_type'];
                            $book_type_id=$res['bk_type_id'];
                            $subject_id=$res['subject_id'];
                            $status=$res['status'];
                            ?>
        <tr>
            <td><?php echo $sl_no++;?></td>
            <td><?php echo $book_ref_no?></td>
            <td><?php echo $book_name?></td>
            <td><?php echo $author_name?></td>
            <td><?php echo $edition?></td>
            <td><?php echo $year_of_publication?></td>
            <td><?php echo $place_publisher?></td>
            <td><?php echo $page?></td>
            <td><?php echo $price?></td>
            <td><?php echo "1";?></td>
            <td><?php echo $location?></td>
            <td><?php echo $row?></td>
            <td><?php echo $book_type?></td>
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