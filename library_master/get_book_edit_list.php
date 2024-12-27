<?php
session_start();
$book_name = $_POST['book_name'];
$author_name = $_POST['author_name'];
$user_id = $_SESSION['user_id'];
if (isset($book_name) && empty($author_name)) {
    include '../admin/database.php';
    $db = new Database();
    $db->select('tbl_book_details', "tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk.book_type,tbl_bk.subject_id,tbl_bk.cover_photo,tbl_bk_req.id as bk_req_id,tbl_bk_req.status,
    tbl_bk_req.issue_date,tbl_bk_req.no_of_days,tbl_bk_req.request_date,tbl_book_type.book_type as book_type_name,tbl_subject_name.book_type as subject_name,
    tbl_bk_ref.id as bk_ref_id,tbl_bk_ref.edition,tbl_bk_ref.year_of_publication,tbl_bk_ref.place_publisher,tbl_bk_ref.page,tbl_bk_ref.price,tbl_bk_ref.location,tbl_bk_ref.row", ' tbl_bk JOIN tbl_book_reference_no tbl_bk_ref ON tbl_bk.id =tbl_bk_ref.tbl_book_id
     LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id left join tbl_book_type ON tbl_book_type.id =tbl_bk.book_type 
     left join tbl_subject_name ON tbl_subject_name.id =tbl_bk.subject_id', 'tbl_bk.book_name= "' . $book_name . '" 
    GROUP BY tbl_bk.id', null, null);
} else if (isset($author_name) && empty($book_name)) {
    include '../admin/database.php';
    $db = new Database();
    $db->select('tbl_book_details', "tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk.book_type,tbl_bk.subject_id,tbl_bk.cover_photo,tbl_bk_req.id as bk_req_id,tbl_bk_req.status,
    tbl_bk_req.issue_date,tbl_bk_req.no_of_days,tbl_bk_req.request_date,tbl_book_type.book_type as book_type_name,tbl_subject_name.book_type as subject_name,
    tbl_bk_ref.edition,tbl_bk_ref.year_of_publication,tbl_bk_ref.place_publisher,tbl_bk_ref.page,tbl_bk_ref.price,tbl_bk_ref.location,tbl_bk_ref.row", ' tbl_bk JOIN tbl_book_reference_no tbl_bk_ref ON tbl_bk.id =tbl_bk_ref.tbl_book_id
     LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id left join tbl_book_type ON tbl_book_type.id =tbl_bk.book_type 
     left join tbl_subject_name ON tbl_subject_name.id =tbl_bk.subject_id', 'tbl_bk.author_name= "' . $author_name . '" 
    GROUP BY tbl_bk.id', null, null);
} else if (isset($author_name) && isset($book_name)) {
    include '../admin/database.php';
    $db = new Database();
    $db->select('tbl_book_details', "tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk.book_type,tbl_bk.subject_id,tbl_bk.cover_photo,tbl_bk_req.id as bk_req_id,tbl_bk_req.status,
    tbl_bk_req.issue_date,tbl_bk_req.no_of_days,tbl_bk_req.request_date,tbl_book_type.book_type as book_type_name,tbl_subject_name.book_type as subject_name,
    tbl_bk_ref.edition,tbl_bk_ref.year_of_publication,tbl_bk_ref.place_publisher,tbl_bk_ref.page,tbl_bk_ref.price,tbl_bk_ref.location,tbl_bk_ref.row", ' tbl_bk JOIN tbl_book_reference_no tbl_bk_ref ON tbl_bk.id =tbl_bk_ref.tbl_book_id
     LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id left join tbl_book_type ON tbl_book_type.id =tbl_bk.book_type 
     left join tbl_subject_name ON tbl_subject_name.id =tbl_bk.subject_id', 'tbl_bk.author_name= "' . $author_name . '" and tbl_bk.book_name= "' . $book_name . '"  
    GROUP BY tbl_bk.id', null, null);
}
$res_book = $db->getResult();
//print_r($res_book);
$db->select('tbl_book_type', "*", null, null, null, null);
$res_book_cat = $db->getResult();
$db->select('tbl_subject_name', "*", null, null, null, null);
$res_book_sub = $db->getResult();
?>
<table id="case_law" class="table">
    <thead class="" style="background: #315682;color:#fff;">
        <th style="width:50px;">Sl No</th>
        <th>Book Name </th>
        <th>Author Name</th>
        <th>quantity</th>
        <th>Book Type</th>
        <th>Subject</th>
        <th>Photo</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php
        // print_r($res_book);
        $sl_no = 1;
        $book_list = array();
        foreach ($res_book as $res) {
            $id = $res['id'];
            $bk_req_id = $res['bk_req_id'];
            //$bk_ref_id=$res['bk_ref_id'];
            $book_name = $res['book_name'];
            $author_name = $res['author_name'];
            $edition = $res['edition'];
            $year_of_publication = $res['year_of_publication'];
            $place_publisher = $res['place_publisher'];
            $page = $res['page'];
            $price = $res['price'];
            $location = $res['location'];
            $row = $res['row'];
            array_push($book_list, $book_name);
            $issue_date = $res['issue_date'];
            $book_type = $res['book_type_name'];
            $quantity = $res['quantity'];
            $subject_name = $res['subject_name'];
            $book_type_id = $res['book_type'];
            $subject_id = $res['subject_id'];
            $cover_photo = $res['cover_photo'];
        ?>
            <tr>
                <td><?php echo $sl_no++; ?></td>
                <td><?php echo $book_name ?></td>
                <td><?php echo $author_name ?></td>
                <td><?php echo $quantity ?></td>
                <td><?php echo $book_type ?></td>
                <td><?php echo $subject_name ?></td>
                <td><?php if(!empty($cover_photo))
                {
                    ?>
                    <img src="../images/cover_photo/<?=isset($cover_photo)?$cover_photo:''?>"
                                                width="120" height="100">
                <?php }else{
                    echo "N/A";
                } ?>
                    </td>
                <td>
                    <form id="frm_insert">
                        <?php //echo $_SESSION['user_id']; 
                        ?>
                        <input type="hidden" name="book_id" value="<?= $id ?>" id="book_id_<?= $id ?>" />
                        <button type="button" class="btn btn-primary" data-toggle="modal" style="padding: 10px 10px;" data-target="#detailsModal_<?php echo $res['id']; ?>">
                            Edit
                        </button>
                    </form>
                </td>
                <td>
                <div id="detailsModal_<?php echo $res['id']; ?>" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content" style="width:200%;margin-left: -33%;">
                            <div class="modal-header" style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, #00c1af 0%, #009ae0 100%);padding: 5px;color: #fff;">
                                <h5 class="modal-title" id="m_title" style="color:#fff" style="text-align:center;"> Edit Book
                                    Details
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <form id="frm_add<?= $id ?>">
                            <div class="modal-body">
                                    <input type="hidden" name="csrf_token" id="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>" />
                                    <input type="hidden" name="update_id" id="update_id_<?= $id ?>" value="<?= isset($id) ? $id : ''; ?>" />
                                    <input type="hidden" name="bk_ref_update_id" id="bk_ref_update_id_<?= $id ?>" value="" />
                                    <input type="hidden" name="oldquantity" id="oldquantity_<?= $id ?>" value="<?= isset($quantity) ? $quantity : ''; ?>" />
                                    <input type="hidden" name="edition" id="edition_<?= $id ?>" value="<?= isset($edition) ? $edition : ''; ?>" />
                                    <input type="hidden" name="year_of_publication" id="year_of_publication_<?= $id ?>" value="<?= isset($year_of_publication) ? $year_of_publication : ''; ?>" />
                                    <input type="hidden" name="place_publisher" id="place_publisher_<?= $id ?>" value="<?= isset($place_publisher) ? $place_publisher : ''; ?>" />
                                    <input type="hidden" name="page" id="page_<?= $id ?>" value="<?= isset($page) ? $page : ''; ?>" />
                                    <input type="hidden" name="price" id="price_<?= $id ?>" value="<?= isset($price) ? $price : ''; ?>" />
                                    <input type="hidden" name="location" id="location_<?= $id ?>" value="<?= isset($location) ? $location : ''; ?>" />
                                    <input type="hidden" name="row" id="row_<?= $id ?>" value="<?= isset($row) ? $row : ''; ?>" />
                                    <input type="hidden" name="hdn_photo" id="hdn_photo_<?= $id ?>" value="<?= isset($cover_photo) ? $cover_photo : ''; ?>" />
                                    <div class="row" style="margin-left:2%;margin-right:2%;padding:1%">
                                        <div class="col-4">
                                            <label>Book Name :</label>
                                            <input class="form-control me-3" name="book_name_cpy" id="book_name_<?= $id ?>" value="<?= isset($book_name) ? $book_name : ''; ?>" placeholder="Enter Book Name" required>
                                            <small></small>
                                        </div>
                                        <div class="col-4">
                                            <label>Author's Name :</label>
                                            <input class="form-control me-3" name="author_name_cpy" id="author_name_<?= $id ?>" value="<?= isset($author_name) ? $author_name : ''; ?>" placeholder="Enter Author Name" required>
                                            <small></small>
                                        </div>
                                        <div class="col-4">
                                            <label>Quantity :</label>
                                            <input class="form-control me-2 quantity" name="quantity" id="quantity_<?= $id ?>" value="<?= isset($quantity) ? $quantity : ''; ?>" placeholder="Enter Quantity" required>
                                            <small></small>
                                        </div>

                                    </div>

                                    <div class="row" style="margin-left:2%;margin-right:2%;padding: 1%;">
                                        <div class="col-4">
                                            <label>Book Type :</label>
                                            <select class="form-control me-2" aria-label="Default select example" name="book_type" id="book_type_<?= $id ?>">
                                                <option value="0">Select Book Type</option>
                                                <?php
                                                if ($res_book_cat) {
                                                    foreach ($res_book_cat as $res_cat) {
                                                        $cat_id = $res_cat['id'];
                                                        if ($book_type_id == $cat_id) {
                                                            $selected = "selected";
                                                        } else {
                                                            $selected = "";
                                                        }
                                                ?>
                                                        <option value="<?php echo $cat_id ?>" <?= $selected ?>><?php echo $res_cat['book_type'] ?></option>
                                                <?php
                                                    }
                                                } ?>
                                            </select>
                                            <small></small>
                                        </div>
                                        <div class="col-4">
                                            <label>Subject :</label>
                                            <select class="form-control me-2" aria-label="Default select example" name="book_sub" id="book_sub_<?= $id ?>">
                                                <option value="0">Select Subject</option>
                                                <?php
                                                if ($res_book_sub) {
                                                    foreach ($res_book_sub as $res_sub) {
                                                        $sub_id = $res_sub['id'];
                                                        if ($subject_id == $sub_id) {
                                                            $selected = "selected";
                                                        } else {
                                                            $selected = "";
                                                        }
                                                ?>
                                                        <option value="<?php echo $sub_id ?>" <?= $selected ?>><?php echo $res_sub['book_type'] ?></option>
                                                <?php
                                                    }
                                                } ?>
                                            </select>
                                            <small></small>
                                        </div>
                                        <div class="col-4" style="display:" id="">
                                            <label>Book Cover Photo :</label>
                                            <input type="file" class="form-control me-2" name="cover_photo" id="cover_photo_<?= $id ?>"  value="<?= isset($cover_photo) ? $cover_photo : ''; ?>" >
                                            <span id="img_id"><?php echo $cover_photo?></span>
                                            <small></small>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-left:2%;margin-right:2%;padding: 1%;">
                                    <div class="col-4" style="display:none" id="ref_div">
                                            <label>Starting Acc. No :</label>
                                            <input class="form-control me-2 quantity" name="bookrefno_<?= $id ?>" id="bookrefno_<?= $id ?>" value="" placeholder="Enter Acc. No" required>
                                            <small></small>
                                        </div>
                                        </div> 
                                    <div class="row" style="margin-left:2%;margin-right:2%;padding: 1%;" id="add_ref_num">
                                    </div>
                               
                            </div>
                            <?php
                            $rules = array(
                                'book_name_cpy' => 'required',
                                'author_name_cpy' => 'required',
                                'quantity'  => 'required|integer,quantity',
                                'book_type' => 'select,book type',
                                'book_sub' => 'select,subject name'
                            );
                            ?>
                            <div class="modal-footer" id="m_footer">
                                <input type="submit" class="btn btn-primary" value="Update" id="<?= $id ?>" onclick='update(this,<?php echo json_encode($rules)  ?>,displayMessage)'>
                                <input type="button" class="btn btn-danger" data-dismiss="modal" value="Close">
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                </td>
            </tr>
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
    $(document).ready(function() {
        $(".quantity").keyup(function() {
            var id = $(this).attr('id');
            let bk_id = id.split('_');
            var val_qnt = $('#' + id).val();
            var qnt_val = $('#quantity_' + bk_id[1]).val();
            var old_qnt_val = $('#oldquantity_' + bk_id[1]).val();
            var new_qnty = qnt_val - old_qnt_val;
            if (old_qnt_val < qnt_val) {
                $('#ref_div').css("display", "block");
                var ref_no = $('#bookrefno_' + bk_id[1]).val();

                $.ajax({
                    method: "POST",
                    url: "ajax_case_master.php",
                    data: {
                        'action': 'get_ref_number',
                        'val_qnt': new_qnty,
                        'ref_no': ref_no
                    },
                    beforeSend: function() {},
                    success: function(res) {
                        //alert(res);
                        $('#add_ref_num').html(res);
                    }
                })

            } else {
                $('#ref_div').css("display", "none");
                $('#add_ref_num').hide();
            }

        });
    });
</script>
<script>
    function update(data,rules,callback) {
        var updt_id = data.id;

           const book_name_val = document.querySelector('#book_name_'+updt_id);
           const author_name_val = document.querySelector('#author_name_'+updt_id);
           const quantity_val = document.querySelector('#quantity_'+updt_id);
           const book_type_val= document.querySelector('#book_type_'+updt_id);
           const subject_name_val = document.querySelector('#book_sub_'+updt_id);

           let isbook_name_valid = checkTextField(book_name_val);
               isauthor_name_valid = checkTextField(author_name_val);
               isquantity_valid =  checkTextField(quantity_val);
               isbook_type_valid = checkDropdown(book_type_val);
               issubject_name_valid =  checkDropdown(subject_name_val);

           let isFormValid =       isbook_name_valid &&
                                   isauthor_name_valid &&
                                   isquantity_valid &&
                                   isbook_type_valid &&
                                   issubject_name_valid 

               var old_qnt_val=$('#oldquantity_'+updt_id).val();  
               var new_qnt = $('#quantity_'+updt_id).val();                   ;
                  //console.log(isFormValid);   
            if(old_qnt_val > new_qnt)
            {
                    alert("Quantity value should not be decreased.");
                    return false;
            }else{
                if(isFormValid)
                    {
        let update_id = $("#update_id_" + updt_id).val();
        let bk_update_id = $("#update_bk_id_" + updt_id).val();
        var reff_no = [];
        $('input[name^="book_reff_no[]"]').each(function() {
            reff_nos = $(this).val();
            reff_no.push(reff_nos);
        });
        // var reff_no = $('#book_ref_no_'+updt_id).val();
        var csrf_token = $('#csrf_token').val();
        var book_name = $('#book_name_' + updt_id).val();
        var author_name = $('#author_name_' + updt_id).val();
        var quantity = $('#quantity_' + updt_id).val();
        var edition = $('#edition_' + updt_id).val();
        var year_of_publication = $('#year_of_publication_' + updt_id).val();
        var place_publisher = $('#place_publisher_' + updt_id).val();
        var page = $('#page_' + updt_id).val();
        var price = $('#price_' + updt_id).val();
        var location = $('#location_' + updt_id).val();
        var row = $('#row_' + updt_id).val();
        var book_type = $('#book_type_' + updt_id).val();
        var subject_name = $('#book_sub_' + updt_id).val();
        var cover_photo = $('#cover_photo_' + updt_id).val();
        var form = $('#frm_add'+ updt_id)[0];
        var form_data = new FormData(form);
        form_data.append("action", "update_book_qt_details");
        form_data.append("table1", "tbl_book_details");
        form_data.append("table2", "tbl_book_reference_no");
        form_data.append("update_id", update_id);
        form_data.append("book_ref_no", reff_no);
        form_data.append("rules", JSON.stringify(rules));
        $.ajax({
            method: "POST",
            url: "ajax_case_master.php",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(res) {
                console.log(res);

                callback(res);
                let elm = res.split('#');
                if (elm[0] == "success") {
                    $('#detailsModal_' + updt_id).modal('hide');
                    get_book_edit_list(book_name, author_name);
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
    }
</script>