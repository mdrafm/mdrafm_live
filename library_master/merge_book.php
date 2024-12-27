<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header_link.php') ?>
<link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/fontawesome.min.css"
integrity="sha512-RvQxwf+3zJuNwl4e0sZjQeX7kUa3o82bDETpgVCH2RiwYSZVDdFJ7N/woNigN/ldyOOoKw8584jM4plQdt8bhA=="
crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="assets/css/manual_css.css">
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
  $db->select('tbl_book_details',"*",null,'status=0',null,null);
  $res_book = $db->getResult();
  $book_list = array();
  $author_list = array();
    foreach($res_book as $res)
    {
    $book_name=$res['book_name'];
    $old_quantity=$res['quantity'];
    $author_name=$res['author_name'];
    array_push($book_list,$book_name);
    array_push($author_list,$author_name);
    }
  $db->select('tbl_book_type',"*",null,null,null,null);
  $res_subject = $db->getResult();
    //print_r($res_location);
?>
<div class="pcoded-main-container">
<div class="pcoded-content">
<div class="row" > 
		<div class="col-lg-7">
			<div class="alert-success shadow my-3" role="alert" style="border-radius: 0px;float:right !important" id="alert_msg">
			</div>
		</div>  
        </div>
           
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-md-12">
                    <!-- <div class=" table-striped table-hover" id="result_tbl">
                    </div> -->
                    <div class="card table-card">
                        <div class="card-header">
                            <h5 style="padding:5px"><u>Merge Book with Same Name</u></h5>
                            
                            
                            <form id="frm_add">
                            <input type="hidden" name="csrf_token" id="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>" />
                            <input type="hidden" id="old_quantity" value="" />
                            <div class="row">
                            <div class="col-5">
                            <label>Book Name :</label>
                             
                           <select class="form-control me-2" aria-label="Default select example" name ="old_bk_name" id="old_bk_name" onchange="get_ref_num(this)">
                                            <option value="">Select Book name</option>
                                            <?php 
                                            if($res_book){
                                            foreach($res_book as $res)
                                            { 
                                             $book_name=$res['book_name'];
                                             $bk_id=$res['id'];
                                            ?>
                                            <option value="<?php echo $bk_id?>" ><?php echo $book_name?></option>
                                            <?php 
                                             }
                                            } ?>              
                                            </select>
                            <small class="text-danger"></small>
                            </div>
                            <div class="col-5">
                              <lebel>Reference No. :</lebel>
                            <span id="span_id" style="color:red"></span>
                                          </div>
                            </div>
                            <div class="row" style="padding-left:7%;padding-top:1%"> <label for="" class="">Merge Into <i class="feather icon-arrow-down"></i></label></div>
                            <div class="row">
                            <div class="col-5">
                            <select class="form-control me-2" aria-label="Default select example" name ="new_book" id="new_book" onchange="get_ref_new_num(this)">
                                            <option value="">Select Book Name</option>
                                            <?php 
                                            if($res_book){
                                            foreach($res_book as $res)
                                            { 
                                             $book_name=$res['book_name'];
                                             $bk_id=$res['id'];
                                            ?>
                                            <option value="<?php echo $bk_id?>" ><?php echo $book_name?></option>
                                            <?php 
                                             }
                                            } ?>              
                                            </select>
                                <small></small>
                            </div>
                            <div class="col-5">
                              <lebel>Reference No. :</lebel>
                            <span id="nw_span_id" style="color:red"></span>
                                          </div>
                            </div>
                            <?php
                            $rules = array(
                                'old_bk_name' => 'select',
                                'new_book' => 'select'
                            );
                            ?>
                            <div class="row">
                            <div class="col-5" style="padding-top:2%">
                            <button type="button" class="btn btn-primary mb-3" onclick='merge_book(this,<?php echo json_encode($rules)  ?>,displayMessage)'>Merge</button>
                            </div></div>
                            </form>
                            
                        </div>
                    </div>
                <?php //print_r($author_list) ?>
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
</body>
</html>
<script src="assets/js/common.js"> </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="../js/case.js"> </script>
<script type="text/javascript">
$( document ).ready(function() {
    var book_type = $('#book_type option:selected').text();
	//alert(book_type);
});

//For getting book details 
function get_ref_num(data) {
let book_id = data.value;
 get_ref_number(book_id,'span_id',1);  
} 
function get_ref_new_num(data) {
let book_id = data.value;
get_ref_number(book_id,'nw_span_id',2);  
} 
function get_ref_number(book_id,s_id,flag){
   var reff =[];
    $.ajax({
            method: "POST",
            url: "get_book_wise_ref_number.php",
            data: {'book_id': book_id},
            dataType: 'json',
            beforeSend: function(){
               $('.loader').show();
                  //  $('#send_email').prop('disabled', true);
                },
            success: function(res) {
              console.log(res.quantity);
			  let qunt = '';
                res.map((elm)=>{
                reff.push(elm.reference_no);
				     qunt = elm.quantity;
                 
                })
                console.log(qunt);
				(flag ===1)?$("#old_quantity").val(qunt):'';
				
                $('#'+s_id).html(reff.join(','));
                $('.loader').hide();
            }
        })
}
function merge_book(data,rules,callback) {

    let old_bk_id = $("#old_bk_name").val();
    let new_bk_id = $("#new_book").val();
    let old_quantity = $("#old_quantity").val();
    var csrf_token = $('#csrf_token').val();
    //alert(old_quantity);
    //return false;
    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: { 'action':'merge_book','old_bk_name':old_bk_id,'new_book':new_bk_id,'old_quantity':old_quantity,'table1':'tbl_book_details',
            'table2':'tbl_book_reference_no','csrf_token': csrf_token,'rules': JSON.stringify(rules)},

        success: function(res) {
            console.log(res);
            callback(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                sessionStorage.message = "Book Details are merged successfully";
                sessionStorage.type = "success";
                showMessage();
                
            }


        }
    })
   
}
</script>
