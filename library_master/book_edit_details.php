g<?php 
session_start();
$location_id=$_POST['location_id'];
$book_ref_no=$_POST['ref_no'];
if(isset($location_id) && empty($book_ref_no))
{
    include '../admin/database.php'; 

    $db = new Database(); 
    $db->select('tbl_book_reference_no',"tbl_bk_ref.*,tbl_bk.book_type as bk_type_id,tbl_book_type.book_type,tbl_subject_name.book_type as subject_name,tbl_bk.subject_id",' tbl_bk_ref JOIN tbl_book_details 
    tbl_bk ON tbl_bk.id =tbl_bk_ref.tbl_book_id left join tbl_book_type on tbl_book_type.id=tbl_bk.book_type left join tbl_subject_name on tbl_subject_name.id=tbl_bk.subject_id','tbl_bk_ref.location like "%'.$location_id.'%" and tbl_bk.status=0',null,null); 
}else if(isset($book_ref_no) && empty($location_id))
{
    include '../admin/database.php'; 
    $db = new Database(); 
    $db->select('tbl_book_reference_no',"tbl_bk_ref.*,tbl_bk.book_type as bk_type_id,tbl_book_type.book_type,tbl_subject_name.book_type as subject_name,tbl_bk.subject_id",' tbl_bk_ref left JOIN tbl_book_details 
    tbl_bk ON tbl_bk.id =tbl_bk_ref.tbl_book_id left join tbl_book_type on tbl_book_type.id=tbl_bk.book_type left join tbl_subject_name on tbl_subject_name.id=tbl_bk.subject_id','tbl_bk_ref.reference_no like "%'.$book_ref_no.'%" and tbl_bk.status=0',null,null); 
}
else if(isset($book_ref_no) && isset($location_id))
{
    include '../admin/database.php'; 
    $db = new Database(); 
    $db->select('tbl_book_reference_no',"tbl_bk_ref.*,tbl_bk.book_type as bk_type_id,tbl_book_type.book_type,tbl_subject_name.book_type as subject_name,tbl_bk.subject_id",' tbl_bk_ref left JOIN tbl_book_details 
    tbl_bk ON tbl_bk.id =tbl_bk_ref.tbl_book_id left join tbl_book_type on tbl_book_type.id=tbl_bk.book_type left join tbl_subject_name on tbl_subject_name.id=tbl_bk.subject_id','tbl_bk_ref.location like "%'.$location_id.'%" and tbl_bk_ref.reference_no like "%'.$book_ref_no.'%" and tbl_bk.status=0',null,null);
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
        <th>Year</th>
        <th>Place & Publisher</th>
        <th>Page</th>
        <th>Price</th>
        <th>quantity</th>
        <th>Location</th>
        <th>Row</th>
        <th>Book Type</th>
        <th>Action</th>
    </thead>
    <tbody>
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
                            $volume=$res['volume'];
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
            <td> 
                <?php
                    if(!empty($status))
                    { ?>
                         <button type="button" class="btn btn-primary" data-toggle="modal" style="padding: 10px 10px;"
                        data-target="#detailsModal_<?php echo $res['id']; ?>">
                        Edit
                        </button>
                   <?php }
                    else
                    { ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" style="padding: 10px 10px;"
                        data-target="#detailsModal_<?php echo $res['id']; ?>">
                        Edit
                        </button>
                        <button type="button" class="btn btn-danger" style="padding: 10px 10px;"
                        id="delete" value="<?php echo $res['id']; ?>" onclick="delete_book(this);">
                        Delete
                        </button>
                  <?php  } 
                ?>
                
                <input type="hidden" id="delete_id_<?=$id?>" value="<?=isset($id)?$id:'';?>" />
                <!--Tranee Detail Modal -->
                <div id="detailsModal_<?php echo $res['id']; ?>" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content" style="width:200%;margin-left: -33%;">
                            <div class="modal-header"
                                style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, #00acc1 0%, #1abc9c 100%);;color: #fff;">
                                <h5 class="modal-title" id="m_title" style="color:#fff" style="text-align:center;"> Book
                                    Details
                                </h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="frm_add_<?=$id?>">
                                    <input type="hidden" id="update_id_<?=$id?>" value="<?=isset($id)?$id:'';?>" />
                                    <input type="hidden" id="update_bk_id_<?=$id?>" value="<?=isset($book_id)?$book_id:'';?>" />
                                    <input type="hidden" name="csrf_token" id="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>" />
                                    <div class="row" style="margin-left:2%;margin-right:2%;padding:1%">
                                        <div class="col-3">
                                            <label>Acc. No :</label>
                                            <input class="form-control me-3" name="book_ref_no" id="book_ref_no_<?=$id?>"
                                                value="<?=isset($book_ref_no)?$book_ref_no:'';?>"
                                                placeholder="Enter Acc. No." required>
                                                <small></small>
                                        </div>
                                        <div class="col-5" >
                                            <label>Book Name :</label>
                                            <input class="form-control me-3" name="book_name" id="book_name_<?=$id?>"
                                                value="<?=isset($book_name)?$book_name:'';?>"
                                                placeholder="Enter Book Name" style="background-color:#d2f7fb" required>
                                                <small></small>
                                        </div>
                                        <div class="col-4" >
                                            <label>Author's Name :</label>
                                            <input class="form-control me-3" name="author_name" id="author_name_<?=$id?>"
                                                value="<?=isset($author_name)?$author_name:'';?>"
                                                placeholder="Enter Author Name" style="background-color:#d2f7fb" required>
                                                <small></small>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-left:2%;margin-right:2%;padding: 1%;">
                                        <div class="col-4">
                                            <label>Edition :</label>
                                            <input class="form-control me-2" name="edition_<?=$id?>" id="edition_<?=$id?>"
                                                value="<?=isset($edition)?$edition:'';?>" placeholder="Enter Edition"
                                                required>
                                        </div>
                                        <div class="col-4">
                                            <label>Year of Publication :</label>
                                            <input class="form-control me-2" name="year_of_publication_<?=$id?>"
                                                id="year_of_publication_<?=$id?>"
                                                value="<?=isset($year_of_publication)?$year_of_publication:'';?>"
                                                placeholder="Enter publication year" required>
                                        </div>
                                        <div class="col-4">
                                            <label>Place and Publisher :</label>
                                            <input class="form-control me-2" name="place_publisher_<?=$id?>" id="place_publisher_<?=$id?>"
                                                value="<?=isset($place_publisher)?$place_publisher:'';?>"
                                                placeholder="Enter Place and Publisher" required>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-left:2%;margin-right:2%;padding: 1%;">
                                    <div class="col-4">
                                            <label>Volume :</label>
                                            <input class="form-control me-2" name="volume_<?=$id?>" id="volume_<?=$id?>"
                                                value="<?=isset($volume)?$volume:'';?>" placeholder="Enter Volume"
                                                required>
                                                <small></small>
                                        </div>
                                        <div class="col-4">
                                            <label>Page :</label>
                                            <input class="form-control me-2" name="page" id="page_<?=$id?>"
                                                value="<?=isset($page)?$page:'';?>" placeholder="Enter No.of Page"
                                                required>
                                                <small></small>
                                        </div>
                                        <div class="col-4">
                                            <label>Price :</label>
                                            <input class="form-control me-2" name="price_<?=$id?>" id="price_<?=$id?>"
                                                value="<?=isset($price)?$price:'';?>" placeholder="Enter Price"
                                                required>
                                        </div>
                                        <!--<div class="col-4">
                                            <label>Quantity :</label>
                                            <input class="form-control me-2" name="quantity_<?=$id?>" id="quantity_<?=$id?>"
                                                value="<?=isset($quantity)?$quantity:'1';?>" placeholder="Enter Quantity"
                                                required>
                                        </div>-->
                                       
                                    </div>
                                    <div class="row" style="margin-left:2%;margin-right:2%;padding: 1%;">
                                    <div class="col-4">
                                            <label>Location :</label>
                                            <input class="form-control me-2" name="location" id="location_<?=$id?>"
                                                value="<?=isset($location)?$location:'';?>" placeholder="Enter Location"
                                                required>
                                                <small></small>
                                        </div>
                                        <div class="col-4">
                                            <label>Row :</label>
                                            <input class="form-control me-2" name="row" id="row_<?=$id?>"
                                                value="<?=isset($row)?$row:'';?>" placeholder="Enter Row" required>
                                                <small></small>
                                        </div>
                                       
                                        <div class="col-4">
                                            <label>Book Type :</label>
                                            <select class="form-control me-2" aria-label="Default select example" name ="book_type" id="book_type_<?=$id?>">
                                            <option value="">Select Book Category</option>
                                            <?php 
                                            if($res_book_cat){
                                            foreach($res_book_cat as $res_cat)
                                            { 
                                            $cat_id=$res_cat['id']; 
                                            if($book_type_id==$cat_id)
                                            {
                                                $selected="selected";
                                            }
                                            else
                                            {
                                                $selected="";
                                            }
                                            ?>
                                            <option value="<?php echo $cat_id?>" <?=$selected?>><?php echo $res_cat['book_type']?></option>
                                            <?php 
                                             }
                                            } ?>              
                                            </select>
                                            <small></small>
                                        </div>
                                        
                                        </div>
                                        <div class="row" style="margin-left:2%;margin-right:2%;padding: 1%;">
                                        <div class="col-4">
                                            <label>Subject :</label>
                                            <select class="form-control me-2" aria-label="Default select example" name ="book_sub" id="book_sub_<?=$id?>">
                                            <option value="">Select Book Category</option>
                                            <?php 
                                            if($res_book_sub){
                                            foreach($res_book_sub as $res_sub)
                                            { 
                                            $sub_id=$res_sub['id']; 
                                            if($subject_id==$sub_id)
                                            {
                                                $selected="selected";
                                            }
                                            else
                                            {
                                                $selected="";
                                            }
                                            ?>
                                            <option value="<?php echo $sub_id?>" <?=$selected?>><?php echo $res_sub['book_type']?></option>
                                            <?php 
                                             }
                                            } ?>              
                                            </select>
                                            <small></small>
                                        </div>
                                        </div>
                                </form>
                            </div>
                            <?php
                            $rules = array(
                                'book_ref_no' => 'required,accession no',
                                'book_name' => 'required',
                                'author_name' => 'required',
                                'page'  => 'required',
                                'location'  => 'required',
                                'row'  => 'required',
                                'book_type' => 'select,book type',
                                'book_sub' => 'select,subject name'
                            );
                            ?>
                            <div class="modal-footer" id="m_footer">
                                <input type="submit" class="btn btn-primary" value="Update" id="<?=$id?>" onclick='update(this,<?php echo json_encode($rules)  ?>,displayMessage)'>
                                <input type="button" class="btn btn-danger" data-dismiss="modal" value="Close">
                            </div>
                        </div>
                    </div>
                </div>

            </td>
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
<script>
    function update(data,rules,callback) {
	var updt_id=data.id;
    const book_ref_no_val = document.querySelector('#book_ref_no_'+updt_id);
    const book_name_val = document.querySelector('#book_name_'+updt_id);
    const author_name_val = document.querySelector('#author_name_'+updt_id);
    const page_val = document.querySelector('#page_'+updt_id);
    const location_val = document.querySelector('#location_'+updt_id);
    const row_val = document.querySelector('#row_'+updt_id);
    const book_type_val= document.querySelector('#book_type_'+updt_id);
    const subject_name_val = document.querySelector('#book_sub_'+updt_id);
    let isbook_ref_no_Valid = checkTextField(book_ref_no_val);
        isbook_name_valid = checkTextField(book_name_val);
        isauthor_name_valid = checkTextField(author_name_val);
        ispage_valid= checkTextField(page_val);
        islocation_valid= checkTextField(location_val);
        isrow_valid = checkTextField(row_val);
        isbook_type_valid = checkDropdown(book_type_val);
        issubject_name_valid =  checkDropdown(subject_name_val);
    let isFormValid = isbook_ref_no_Valid &&
                            isbook_name_valid &&
                            isauthor_name_valid &&
                            ispage_valid &&
                            islocation_valid &&
                            isrow_valid &&
                            isbook_type_valid &&
                            issubject_name_valid 
                            ;
           //console.log(isFormValid);                 
    if(isFormValid)
    {
        var csrf_token = $('#csrf_token').val();
        let update_id = $("#update_id_"+updt_id).val();
        let bk_update_id = $("#update_bk_id_"+updt_id).val();
        var reff_no = $('#book_ref_no_'+updt_id).val();
        var book_name = $('#book_name_'+updt_id).val();
        var author_name = $('#author_name_'+updt_id).val();
        var edition = $('#edition_'+updt_id).val();
        var year_of_publication = $('#year_of_publication_'+updt_id).val();
        var place_publisher = $('#place_publisher_'+updt_id).val();
        var volume = $('#volume_'+updt_id).val();
        var page = $('#page_'+updt_id).val();
        var price = $('#price_'+updt_id).val();
        var location = $('#location_'+updt_id).val();
        var row = $('#row_'+updt_id).val();
        var book_type = $('#book_type_'+updt_id).val();
        var subject_name = $('#book_sub_'+updt_id).val();
    $.ajax({
        method: "POST",
        url: "ajax_case_master.php",
        data: { 'action':'update_book_details','update_id':update_id,'bk_update_id':bk_update_id,'book_ref_no':reff_no,'book_name':book_name,'author_name':author_name,
        'edition':edition,'year_of_publication':year_of_publication,'place_publisher':place_publisher,'volume':volume,'page':page,'price':price,'price':price,
        'location':location,'row':row,'book_sub':subject_name,'book_type':book_type,'table1':'tbl_book_details','table2':'tbl_book_reference_no','csrf_token': csrf_token,'rules': JSON.stringify(rules)},
        success: function(res) {
            console.log(res);
            callback(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                var location_id = $('#location_id').val();
                var book_ref_no = $('#book_ref_no').val();
                $('#detailsModal_'+updt_id).modal('hide');
                getBooksList(location_id,book_ref_no);
                $('.modal-backdrop').remove();
                sessionStorage.message = "Book Details are updated successfully";
                sessionStorage.type = "success";
                showMessage();
                //location.reload();
         
            }

        }
    })
    }
}
function delete_book(data) {
    var del_id=data.value;
    let delete_id = $("#delete_id_"+del_id).val();
    var location_id= '<?php echo $location_id ;?>';

    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: {
            action: "delete_data",
            delete_id: delete_id,
            table: "tbl_book_reference_no",
        },

        success: function(res) {
           // alert(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                getBooksList(location_id);
                sessionStorage.message = "Book Details are Deleted successfully";
                sessionStorage.type = "error";
                showMessage();
                //location.reload();
            }


        }
    })
   
}
</script>