<?php
session_start();
$book_name = $_POST['book_name'];
$author_name = $_POST['author_name'];
//$user_id = $_SESSION['user_id']; exit;
if (isset($book_name) && empty($author_name)) {
    include 'admin/database.php';
    $db = new Database();
    $db->select('tbl_book_details', "tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk.book_type,tbl_bk.subject_id,tbl_bk_req.id as bk_req_id,tbl_bk_req.status,
    tbl_bk_req.issue_date,tbl_bk_req.no_of_days,tbl_bk_req.request_date,tbl_book_type.book_type as book_type_name,tbl_subject_name.book_type as subject_name,
    tbl_bk_ref.id as bk_ref_id,tbl_bk_ref.edition,tbl_bk_ref.year_of_publication,tbl_bk_ref.place_publisher,tbl_bk_ref.page,tbl_bk_ref.price,tbl_bk_ref.location,tbl_bk_ref.row,tbl_bk_ref.status as ref_status", ' tbl_bk JOIN tbl_book_reference_no tbl_bk_ref ON tbl_bk.id =tbl_bk_ref.tbl_book_id
     LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id left join tbl_book_type ON tbl_book_type.id =tbl_bk.book_type 
     left join tbl_subject_name ON tbl_subject_name.id =tbl_bk.subject_id', 'tbl_bk.book_name= "' . $book_name . '" 
    GROUP BY tbl_bk.id', null, null);
} else if (isset($author_name) && empty($book_name)) {
    include 'admin/database.php';
    $db = new Database();
    $db->select('tbl_book_details', "tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk.book_type,tbl_bk.subject_id,tbl_bk_req.id as bk_req_id,tbl_bk_req.status,
    tbl_bk_req.issue_date,tbl_bk_req.no_of_days,tbl_bk_req.request_date,tbl_book_type.book_type as book_type_name,tbl_subject_name.book_type as subject_name,
    tbl_bk_ref.edition,tbl_bk_ref.year_of_publication,tbl_bk_ref.place_publisher,tbl_bk_ref.page,tbl_bk_ref.price,tbl_bk_ref.location,tbl_bk_ref.row,tbl_bk_ref.status as ref_status", ' tbl_bk JOIN tbl_book_reference_no tbl_bk_ref ON tbl_bk.id =tbl_bk_ref.tbl_book_id
     LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id left join tbl_book_type ON tbl_book_type.id =tbl_bk.book_type 
     left join tbl_subject_name ON tbl_subject_name.id =tbl_bk.subject_id', 'tbl_bk.author_name= "' . $author_name . '" 
    GROUP BY tbl_bk.id', null, null);
} else if (isset($author_name) && isset($book_name)) {
    include 'admin/database.php';
    $db = new Database();
    $db->select('tbl_book_details', "tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk.book_type,tbl_bk.subject_id,tbl_bk_req.id as bk_req_id,tbl_bk_req.status,
    tbl_bk_req.issue_date,tbl_bk_req.no_of_days,tbl_bk_req.request_date,tbl_book_type.book_type as book_type_name,tbl_subject_name.book_type as subject_name,
    tbl_bk_ref.edition,tbl_bk_ref.year_of_publication,tbl_bk_ref.place_publisher,tbl_bk_ref.page,tbl_bk_ref.price,tbl_bk_ref.location,tbl_bk_ref.row,tbl_bk_ref.status as ref_status", ' tbl_bk JOIN tbl_book_reference_no tbl_bk_ref ON tbl_bk.id =tbl_bk_ref.tbl_book_id
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
<table id="case_law" class="table table-striped">
    <thead class="" style="background: #126976b5;color:#fff;">
        <th style="width:50px;"></th>
        <th>Book Name </th>
        <th>Author Name</th>
        <th>Location</th>
        <th>Row</th>
		<th>Status</th>
    </thead>
    <tbody>
        <?php
       //print_r($res_book);
        if(!empty($res_book))
        {
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
            $bk_ref_status = $res['ref_status'];
        ?>
            <tr class="table-info">
                <td><?php //echo $sl_no++; ?></td>
                <td><?php echo $book_name ?></td>
                <td><?php echo $author_name ?></td>
                <td><?php echo $location ?></td>
                <td><?php echo $row ?></td>
              
                    <?php if($bk_ref_status==1)
                            {
                                $sts="Issued";
                                $stl='style="color:red;font-weight:600"';
                                $span_stl='style="background-color:#ffe26c;width:10px;padding:4px"';
                            }else
                            {
                                $sts="Available";
                                $stl='style="color:black;font-weight:600"';
                                $span_stl='style="background-color:#05ef18f5;width:10px;padding:4px"';
                            }?>
             <td <?= $stl?>><span <?=$span_stl?>><?=isset($sts)?$sts:''?></span></td>
            </tr>
        <?php   } 
        }else
        {
           echo "Book is not found"; 
        }
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
        var form = $('#frm_add')[0];
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