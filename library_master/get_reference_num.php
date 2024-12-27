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
print_r($cover_photo);
?>

 <div class="row" style="margin-left:2%;margin-right:2%;padding:1%">
                                    <div class="col-4">
                                            <label>Book Name:</label>
                                            <input type="text"  class="form-control me-3" name="book_name" id="book_name" value="<?=isset($book_name)?$book_name:''?>" placeholder="Enter Book Name"/>
                                                <small></small>
                                        </div>
                                        <div class="col-4" >
                                            <label>Author's Name :</label>
                                            <input type="text"  class="form-control me-3" name="author_name"  id="author_name" value="<?=isset($author_name)?$author_name:''?>"  placeholder="Enter Author Name"/>
                                                <small></small>
                                        </div>
                                        <div class="col-4" >
                                            <label>Edition :</label>
                                            <input class="form-control me-3" name="edition" id="edition" value="<?=isset($edition)?$edition:''?>" 
                                                placeholder="Enter Edition" required>
                                                <small></small>
</div>
</div>
<div class="row" style="margin-left:2%;margin-right:2%;padding:1%">
                                    <div class="col-4">
                                    <label>Year of Publication:</label>
                                     <input type="text" id="year_of_publication" name="year_of_publication" class="form-control me-3" value="<?=isset($year_of_publication)?$year_of_publication:''?>" />
                                                <small></small>
                                        </div>
                                        <div class="col-4" >
                                        <label>PLace and Publisher :</label>
                                    <input type="text" id="place_publisher"  name="place_publisher" class="form-control me-3" value="<?=isset($place_publisher)?$place_publisher:''?>" />
                                                <small></small>
                                        </div>
                                        <div class="col-4" >
                                        <label>Volume :</label>
                                    <input type="text" id="volume" class="form-control me-3" name="volume" value="<?=isset($volume)?$volume:''?>" />
                                                <small></small>
</div>
</div>
<div class="row" style="margin-left:2%;margin-right:2%;padding:1%">
                <div class="col-4" >
                <label>Page :</label>
                <input type="text" id="page" class="form-control me-3" name="page" value="<?=isset($page)?$page:''?>" />
                            <small></small>
                </div>
                <div class="col-4">
                <label>Price :</label>
                <input type="text" id="price"  class="form-control me-3" name="price" value="<?=isset($price)?$price:''?>" />
                    <small></small>
                </div>
                <div class="col-4" >
                <label>Location:</label>
                <input type="text" id="location"  class="form-control me-3" name="location" value="<?=isset($location)?$location:''?>" />
                    <small></small>
                </div>
                </div>
 <div class="row" style="margin-left:2%;margin-right:2%;padding:1%">
                <div class="col-12" >
                <label>Row :</label>
                <input type="text" id="row"  class="form-control me-3" name="row" value="<?=isset($row)?$row:''?>" />
                    <small></small>
                </div>
</div>
<input type="hidden" value="<?=$quantity?>" name="quantity">
<input type="file" value="" name="cover_photo" id="image-cropper2">
<input type="hidden" id="book_type" name="book_type" value="<?=isset($book_type)?$book_type:''?>" />
<input type="hidden" id="subject_name" name="subject_name" value="<?=isset($subject_name)?$subject_name:''?>" />
<div class="col-9" style="margin-left:4%;margin-right:2%;padding:1%">
    <label>Acc. No :</label> <span id="ref_num" style="color:red"></span>
    <?php 
    for($i=1;$i<=$quantity;$i++)
    { 
        // $book_ref_num=$book_ref_num + 1;
        ?>
        <input class="form-control me-3" name="book_reff_no[]" id="book_reff_no"
        value="<?=isset($book_ref_no)?$book_ref_no:'';?>"
        placeholder="Enter Reference No." required></br>
    <?php 
    $book_ref_no=$book_ref_no + 1;
    
}
    ?>
    
</div>