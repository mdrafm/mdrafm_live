<?php 
session_start(); 
include '../admin/database.php'; 

$db = new Database(); 
$quantity=$_POST['quantity'];
$book_ref_no=$_POST['book_ref_no'];
$book_name=$_POST['book_name'];
$author_name=$_POST['author_name'];
$edition=$_POST['edition'];
$year_of_publication=$_POST['year_of_publication'];
$place_publisher=$_POST['place_publisher'];
$volume=$_POST['volume'];
$page=$_POST['page'];
$price=$_POST['price'];
$location=$_POST['location'];
$row=$_POST['row'];
$book_type=$_POST['book_type'];
$subject_name=$_POST['subject_name'];
$cover_photo=$_FILES['cover_photo'];
$cover_photo_string=implode(',',$cover_photo);
?>
<input type="hidden" value="<?=$quantity?>" name="quantity">
<div class="col-9" style="margin-left:4%;margin-right:2%;padding:1%">
    <label>Acc. No :</label> 
    <?php 
    for($i=1;$i<=$quantity;$i++)
    { 
        // $book_ref_num=$book_ref_num + 1;
        ?>
        <input class="form-control me-3" name="book_reff_no[]" id="book_reff_no"
        value="<?=isset($book_ref_no)?$book_ref_no:'';?>"
        placeholder="Enter Reference No." required></br>
    <?php 
    if(is_numeric($book_ref_no))
    {
        $book_ref_no=$book_ref_no + 1;
    }else{
        $book_ref_no=$book_ref_no;
    }
    
    
}
    ?>
    
</div>