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
                    <h5>Show issued book list</h5> 
                    <div class="card table-card">
                        <div class="card-header">
                             
                        <form id="frm_add">
                                    
                                    <div class="row" style="margin-left:2%;margin-right:2%;padding:1%">
                                    <div class="col-4">
                                            <label>From date :</label>
                                            <input type="date" class="form-control" id="from_date" name="from_date">
                                            <small></small>
                                        </div>
                                    <div class="col-4">
                                            <label>To Date :</label>
                                            <input type="date" class="form-control" id="to_date" name="to_date">
                                                <small></small>
                                        </div>
                                        <?php
                                   $rules = array(
                                    'from_date'=>'required,From date',
                                    'to_date'=>'required,To date',
                                   );
                                 ?>
                                        <div class="col-4" style="padding-top:1.6%;">
                                        <input type="button" class="btn btn-primary" value="Show" id="show_btn" onclick='show_issued_list(<?php echo json_encode($rules)  ?>,displayMessage)'>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
            <input type="hidden" name="update_id" id="update_id" value="" >
                <div class="row">
                <div class="col-md-12">
                <h5  style='text-align:left'>Book Issued List</h5>
                
                    <!-- <div class=" table-striped table-hover" id="result_tbl">
                    </div> -->
                    
                        <div class="card table-card">
                            <div class="card-header" style="padding:0.25rem 1.25rem">
                                <div class="loader" style="display: none;margin-left: 35%;">
                                    <img src="../admin/assets/img/loader.gif" class="loader_img" alt="Loading" style="width: 300px;height: 90px;" />
                                </div>
                                <div id="tbl_book_list" class="table table-responsive table-striped table-hover">
                                
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
function ExportToExcel(type, fn, dl) {
    var elt = document.getElementById('book_table');
    var wb = XLSX.utils.table_to_book(elt, {
        sheet: "sheet1"
    });
    return dl ?
        XLSX.write(wb, {
            bookType: type,
            bookSST: true,
            type: 'base64'
        }) :
        XLSX.writeFile(wb, fn || ('BOOKLIST.' + (type || 'xlsx')));
}
function show_issued_list(rules,callback) {
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();
    $.ajax({
            type: 'POST',
            url: 'ajax_case_master.php',
            data: {
                action: "get_issued_list",
                from_date: from_date,
                to_date: to_date,
            },
            beforeSend: function(){
                    $('.loader').show();
                     },
            success: function(res) {
                console.log(res);
                $('.loader').hide();
                    $('#tbl_book_list').html(res);
                     $('#book_table').DataTable({
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, 'All'],
                        ],
                    });
                // if (res.trim() == 'success') {
                //     location.reload();
                // }

            }
        })
}

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