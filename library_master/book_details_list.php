<?php
   //include '../admin/database.php';
   //session_start();   
  // $db = new Database(); 
  // $err = '';
	
/* 	SELECT book_ref_no, COUNT(*)
FROM `tbl_temp_book_detail`
GROUP BY book_ref_no
HAVING COUNT(*) > 1; */
	//echo count($res);
	//print_r($res);
	/* foreach($res as $row){
		$db_pass = $row['password'];
		if($row['status']==0){
            $err = "Inactive User";
            
        }
        else{
            
            }
        } 
		
	}*/




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('header_link.php') ?>
    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
        rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/fontawesome.min.css"
        integrity="sha512-RvQxwf+3zJuNwl4e0sZjQeX7kUa3o82bDETpgVCH2RiwYSZVDdFJ7N/woNigN/ldyOOoKw8584jM4plQdt8bhA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
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
		margin-top: 6%;
        margin-left: 60%;
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
    }

    label {
        color: black;
        font-size: ;
        font-weight: 600;

    }

    .select2-search__field {
        height: 2rem;
    }
   
   
    </style>
</head>

<body>
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
<?php 
$db->select('tbl_book_reference_no',"tbl_bk_ref.*,tbl_bk.book_type as bk_type_id,tbl_book_type.book_type,tbl_subject_name.book_type as subject_name,
tbl_bk.subject_id",' tbl_bk_ref JOIN tbl_book_details 
tbl_bk ON tbl_bk.id =tbl_bk_ref.tbl_book_id left outer join tbl_book_type on tbl_book_type.id=tbl_bk.book_type 
left outer join tbl_subject_name on tbl_subject_name.id=tbl_bk.subject_id',null,'tbl_bk_ref.reference_no',null);
$res_book = $db->getResult(); 
?>
    <!-- [ Main Content ] end -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-md-12">
                    <!-- <div class=" table-striped table-hover" id="result_tbl">
                    </div> -->
                  
         <div class="row" > 
		<div class="col-lg-6">
			<div class="alert-success shadow my-3" role="alert" style="border-radius: 0px;float:right !important" id="alert_msg">
			</div>
		</div>  
        </div>
       
                    <div class="card table-card">
                    
                        <div class="card-header">
                        <div class="loader" style="display:none;margin-left: 35%;">
                                <img src="../admin/assets/img/loader.gif" class="loader_img" alt="Loading" style="width: 300px;height: 90px;" />
                            </div>
                            <span id="span_id" style="display:none"><label>Search :</label> <input id='myInput' onkeyup='searchTable()' type='text'></span>
                            <div id="tbl_case_law" class="table table-responsive table-striped table-hover">
                            
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div id="alert_box" class="modal fade" role="dialog" aria-labelledby="alert_boxLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="alert_boxLabel2"></h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0 alrt_msg">
                            </p>
                        </div>
                        <div class="modal-footer " id="footer_alert">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
</html>
<script src="assets/js/common.js"> </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="assets/js/plugins/jquery.dataTables.min.js"></script>


<script src="../js/case.js"> </script>
<script type="text/javascript">
$( document ).ready(function() {
   
  
});

get_all_Book_List();
function get_all_Book_List(){
    $.ajax({
            method: "POST",
            url: "get_all_book_list.php",
            beforeSend: function() {
                $(`.loader`).show();
                //$('.loader_img').hide();
                //  $('#send_email').prop('disabled', true);
            },
            success: function(res) {
                console.log(res);
                $('#tbl_case_law').html(res);
                $("#span_id").css("display", "block");
//                 $('#case_law').DataTable( {
//     paging: false
// } );
    //             $('#case_law').DataTable({
    //     lengthMenu: [
    //         [10, 25, 50, -1],
    //         [10, 25, 50, 'All'],
    //     ],
    // });
                $(`.loader`).hide();
                //update();
                //$('#detailsModal_27').modal('hide');

            }
        })
}
function update(data) {
	var updt_id=data.id;
    //var form_data = new FormData(document.getElementById('frm_add_'+updt_id));
    let update_id = $("#update_id_"+updt_id).val();
    let bk_update_id = $("#update_bk_id_"+updt_id).val();
    //form_data.append("action", "add_master");
   // form_data.append("update_id", update_id);
    //form_data.append("table", "tbl_book_reference_no");
    //alert('#detailsModal_'+updt_id);
    var reff_no = $('#book_ref_no_'+updt_id).val();
    var book_name = $('#book_name_'+updt_id).val();
    var author_name = $('#author_name_'+updt_id).val();
    var edition = $('#edition_'+updt_id).val();
    var year_of_publication = $('#year_of_publication_'+updt_id).val();
    var place_publisher = $('#place_publisher_'+updt_id).val();
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
        'edition':edition,'year_of_publication':year_of_publication,'place_publisher':place_publisher,'page':page,'price':price,'price':price,
        'location':location,'row':row,'subject_name':subject_name,'book_type':book_type,'table1':'tbl_book_details','table2':'tbl_book_reference_no'},
        success: function(res) {
           // alert(res);
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
function ExportToExcel(type, fn, dl) {
    var elt = document.getElementById('case_law');
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
// $("#search").keyup(function(){
//         var searchText = $(this).val().toLowerCase();
//         // Show only matching TR, hide rest of them
//         $.each($("#case_law tbody tr"), function() {
//             if($(this).text().toLowerCase().indexOf(searchText) === -1)
//                $(this).hide();
//             else
//                $(this).show();                
//         });
//     }); 
    
</script>
<script>
function searchTable() {
    var input, filter, found, table, tr, td, i, j;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("case_law");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                found = true;
            }
        }
        if (found) {
            tr[i].style.display = "";
            found = false;
        } else {
            tr[i].style.display = "none";
        }
    }
}
</script>
</script>