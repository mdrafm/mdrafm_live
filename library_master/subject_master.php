<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('header_link.php') ?>
    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
        rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/fontawesome.min.css"
        integrity="sha512-RvQxwf+3zJuNwl4e0sZjQeX7kUa3o82bDETpgVCH2RiwYSZVDdFJ7N/woNigN/ldyOOoKw8584jM4plQdt8bhA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    #alert_msg {
        position: absolute;
        z-index: 1400;
        top: 2%;
        /* right:4%; */
        margin: 40px;
        text-align: center;
        color: #fff;
        display: none;
    }

    #circular_frm {
        width: 95%;
        margin: 0 auto;
        padding: 20px;
        box-shadow: rgb(50 50 93 / 25%) 0px 2px 5px -1px, rgb(0 0 0 / 30%) 0px 1px 3px -1px;
        background-color: #f7f7f7;
        border-radius: 5px;
    }

    #circular_frm input {
        border-radius: 5px;
        /* border: none; */
    }

    #circular_frm select {
        border-radius: 5px;
        /* border: none; */
    }

    small {
        font-size: 1rem;
        color:red
    }

    label {
        color: black;
        font-size: ;
        font-weight: 600;

    }
    .select2-search__field {
        height: 2rem;
    }
    .table td, .table th {
        padding: 0.05rem 0.75rem;
        vertical-align: middle;
    }
    </style>
</head>

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <?php include('sidebar_nav.php') ?>
    <!-- [ Header ] start -->
    <?php include('header_nav.php') ?>
    <!-- [ Header ] end -->
    <!-- [ Main Content ] start -->

    <!-- [ Main Content ] end -->
    <?php
    // $db->select('tbl_temp_book_detail',"DISTINCT(location)",null,null,null,null);
     //$res_location = $db->getResult();
    $db->select('tbl_book_type',"*",null,null,null,null);
    $res_book_type = $db->getResult(); 
    $db->select('tbl_subject_name',"tbl_subject_name.id,tbl_subject_name.book_type,tbl_subject_name.book_category,tbl_book_type.book_type as book_cat",
    ' join tbl_book_type on tbl_subject_name.book_category=tbl_book_type.id',null,'tbl_subject_name.id',null);
    $res_subject_type = $db->getResult();
 //print_r($res_location);
?>

    <div class="pcoded-main-container">
        <div class="pcoded-content" id="test">
            <!-- [ Main Content ] start -->
           <!--  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- <div class=" table-striped table-hover" id="result_tbl">
                    </div> -->
                    <div class="col-md-6" style="margin-left:30%;padding-top:%">
                    <div id="alert_msg" style="position:absolute"></div>
                    </div> 
                    <h5>Add Subject</h5> 
                    <div class="card table-card">
                        <div class="card-header">
                             
                        <form id="frm_add">
                                    
                                    <div class="row" style="margin-left:2%;margin-right:2%;padding:1%">
                                    <div class="col-4">
                                            <label>Book Type :</label>
                                            <select class="form-control me-2" aria-label="Default select example" name ="book_category" id="book_category">
                                            <option value="">Select Book Type</option>
                                            <?php 
                                            if($res_book_type){
                                            foreach($res_book_type as $res_typ)
                                            { 
                                            $bk_typ_id=$res_typ['id']; 
                                            ?>
                                            <option value="<?php echo $bk_typ_id?>"><?php echo $res_typ['book_type']?></option>
                                            <?php
                                             }
                                            } ?>              
                                            </select>
                                            <small></small>
                                        </div>
                                    <div class="col-4">
                                            <label>Subject Name :</label>
                                      
                                            <input class="form-control me-3" name="book_type" id="book_type"
                                                value=""
                                                placeholder="Enter Type." required>
                                                <small></small>
                                        </div>
                                        <?php
                                   $rules = array(
                                    'book_category'=>'select,book type',
                                    'book_type'=>'required,subject name'
                                   );
                                 ?>
                                        <div class="col-4" style="padding-top:1.6%;">
                                        <input type="button" class="btn btn-primary" value="Add Subject" id="save_btn" onclick='add_subject(<?php echo json_encode($rules)  ?>,displayMessage)'>
                                        </div>
                                    </div>
                            </form>
                            <input type="hidden" name="update_id" id="update_id" value="" >
                            <div id="tbl_case_law" class="table table-responsive table-striped table-hover">
                            <table id="case_law" class="table table-bordered" style="width:50%;margin-left:5%">
                            <thead class="" style="background: #315682;color:#fff;">
                            <th>Sl No</th>
                            <th>Book Type </th>
                            <th>Subject</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 
                            $sl_no=1;
                           foreach($res_subject_type as $res)
                           {
                            $id=$res['id'];
                            $book_cat=$res['book_cat'];
                            $book_category=$res['book_category'];
                            $subject_name=$res['book_type'];
                            ?>
                            <input type="hidden" name="hdn_book_cat" id="hdn_book_cat_<?=$id?>" value="<?=isset($book_category)?$book_category:''?>" >
                            <input type="hidden" name="hdn_book_type" id="hdn_book_type_<?=$id?>" value="<?=isset($subject_name)?$subject_name:''?>" >
                            <tr>
                            <td><?php echo $sl_no++;?></td>
                            <td ><?php echo $book_cat?></td>
                            <td ><?php echo $subject_name?></td>
                            <td style="text-align:center"><input type="button" class="btn btn-success" value="Edit"   id="<?=$id;?>"  onclick="edit_subject(this)">
                            <input type="button" class="btn btn-danger" value="Delete"  id="<?=$id;?>" onclick="delete_subject(this)">
                        </td>
                            <?php } ?>
                           </tr>
                           </tbody>
                           </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
</body>
</html>
<script src="assets/js/common.js"> </script>
<script src="assets/js/form_validation.js"> </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$('#btn_search').click(function() {
    $('#circular_frm').toggle("down");
});
//For Update Book Table 
function add_subject(rules,callback) {
    let update_id = $('#update_id').val();
	let msg_flg = (update_id === '')?'added':'updated';
    var form_data = new FormData(document.querySelector('form'));
        form_data.append("action", "add_master");
        form_data.append("table", "tbl_subject_name");
		form_data.append("update_id", update_id);
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
				//console.log(elm[0]);
                if (elm[0] == "success") {
                    sessionStorage.message = `Subject is ${msg_flg} Successfully`;
                    sessionStorage.type = "success";
					 showMessage();
                     setTimeout(function(){
                    window.location.reload(1);
                    }, 1500);
                }
            }
        })
}
function edit_subject(data) {
    //alert(data.id);
	$('#update_id').val(data);
	$('#save_btn').val('Update');
    var tbl_id=data.id;
    var book_cat=$('#hdn_book_cat_'+tbl_id).val();
    var book_typ=$('#hdn_book_type_'+tbl_id).val();
    $('#book_category').val(book_cat);
    $('#book_type').val(book_typ);
    $('#update_id').val(tbl_id);
    $("html, body").animate({ scrollTop: 0 }, "fast");
}
function delete_subject(data) {
    var delete_id=data.id;
    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: {
            action: "delete_data",
            delete_id: delete_id,
            table: "tbl_subject_name",
        },
        success: function(res) {
            //alert(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                sessionStorage.message = 'Subject is deleted Successfully';
                sessionStorage.type = "error";
                showMessage();
                setTimeout(function(){
                    window.location.reload(1);
                    },1000);
                    $("html, body").animate({ scrollTop: 0 }, "fast");
                
            }


        }
    })
   
}

</script>