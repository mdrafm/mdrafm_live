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
  $db->select('tbl_book_details',"*",null,null,null,null);
  $res_book = $db->getResult();
  $book_list = array();
  $author_list = array();
    foreach($res_book as $res)
    {
    $book_name=$res['book_name'];
    $author_name=$res['author_name'];
    array_push($book_list,$book_name);
    array_push($author_list,$author_name);
    }
  $db->select('tbl_book_type',"*",null,null,null,null);
  $res_subject = $db->getResult();
  $db->select('tbl_book_reference_no',"*",null,'lost_status > 0',null,null);
  $res_lost_book = $db->getResult();
    //print_r($res_lost_book);
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
                        <div class="container" >
                        <div class="card" style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;border-top: 3px solid #ebebeb;">
                        <div class="card-header" style="background-color: #f7f7f7">Missing / Destroyed Book Entry</div>
                         <div class="card-body" style="margin-top:1%;margin-left:2%"> 
                            <form>
                            <input type="hidden" name="csrf_token" id="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>" />
                            <div class="form-group row">
                            <label for="bookname" class="col-sm-2 col-form-label">Book Name</label>
                            <div class="col-sm-5">
                            <select class="custom-select mr-sm-2" id="destoyed_book_id" name="destoyed_book_id" onchange="get_ref_num(this)">
                            <option value="0">Choose Book name</option>
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
                            </div>
                            <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Reference Number</label>
                            <div class="col-sm-5">
                            <select class="custom-select mr-sm-2" id="reference_num" name="reference_num">
                            <option value="0">Choose...</option>
                            </select>
                            <small></small>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Type</label>
                            <div class="col-sm-5">
                            <select class="custom-select mr-sm-2" id="lost_type" name="lost_type">
                            <option value="0" selected>Choose...</option>
                            <option value="1">Missing</option>
                            <option value="2">Write off</option>
                            </select>
                            <small></small>
                            </div>
                            </div>
                            <?php
                            $rules = array(
                                'destoyed_book_id' => 'select,Book name',
                                'reference_num' => 'select,accession number',
                                'lost_type' => 'select'
                            );
                            ?>
                            <div class="col-sm-7" style="float:right">
                            <button type="button" class="btn btn-primary mb-2"  onclick='book_destroyed(this,<?php echo json_encode($rules)  ?>,displayMessage)' >Save</button>
                            </div>
                            </form> 
                        </div>
                    </div>
                    </div>
                            <h5>Missing/Destroyed Book List</h5>
                            <div class="loader" style="display: none;margin-left: 35%;">
                                <img src="../admin/assets/img/loader.gif" class="loader_img" alt="Loading" style="width: 300px;height: 90px;" />
                            </div>
                            <div id="tbl_case_law" class="table table-responsive table-striped table-hover">
                            <table id="case_law" class="table">
                            <thead class="" style="background: #315682;color:#fff;">
                            <th>Sl No</th>
                            <th>Ref No.</th>
                            <th>Book Name </th>
                            <th>Author Name</th>
                            <th>Edition</th>
                            <th>Type</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                           <?php $sl_no=1;
                           foreach($res_lost_book as $res)
                           {
                            $id=$res['id'];
                            $book_id=$res['tbl_book_id'];
                            $book_ref_no=$res['reference_no'];
                            $book_name=$res['book_name'];
                            $author_name=$res['author_name'];
                            $edition=$res['edition'];
                            $lost_status=$res['lost_status'];
                            if($lost_status==1)
                            {
                                $type='Missing Book';
                            }else{
                                $type='Destroyed';
                            }
                           
                            ?>
                            <tr>
                            <td><?php echo $sl_no++;?></td>
                            <td><?php echo $book_ref_no?></td>
                            <td><?php echo $book_name?></td>
                            <td><?php echo $author_name?></td>
                            <td><?php echo $edition?></td>
                            <td style="color:red"><?php echo $type?></td>  
                            <td> <button type="button" class="btn btn-danger" style="padding: 10px 10px;"
                        id="delete" value="<?php echo $res['id']; ?>" onclick="delete_book_destroyed_data(this);">
                        Delete
                        </button></td>
                           </tr>
                           <?php } ?>
                            </tbody>
                             </table>
                             </div>
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
function get_ref_num(data) {
let book_id = data.value;
 get_ref_number(book_id);  
} 
function get_ref_number(book_id){
   var reff =[];
   var option='';
    $.ajax({
            method: "POST",
            url: "get_book_wise_ref_number.php",
            data: {'book_id': book_id},
            dataType: 'json',
            success: function(res) {
              console.log(res);
			  let qunt = '';
                res.map((elm)=>{
                reff.push(elm.reference_no);
				     qunt = elm.quantity;
                  option +=  `<option value="${elm.id}">${elm.reference_no}</option>`
                })
                $('#reference_num').html(option);
            }
        })
}
function book_destroyed(data,rules,callback) {
    var book_id=$('#destoyed_book_id').val();
    var reference_num=$('#reference_num').val();
    var lost_type=$('#lost_type').val();
    var auto_bk_id = data.id;
    var author_name = '<?php echo $author_name ;?>';
    var book_name = '';
    var csrf_token = $('#csrf_token').val();
    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: {
            'action': 'update_missing_book',
            'destoyed_book_id': book_id,
            'reference_num': reference_num,
            'lost_type': lost_type,
            'csrf_token': csrf_token,
            'rules': JSON.stringify(rules),
            'table': "tbl_book_reference_no"
        },
        success: function(res) {
            console.log(res);
            callback(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                //get_member_book_list(book_name, author_name);
                sessionStorage.message = "Destroyed Book data is saved successfully";
                sessionStorage.type = "success";
                showMessage();
                setTimeout(function(){
                    window.location.reload(1);
                    }, 1000);
					showMessage();
            }
        }
    })
}
function delete_book_destroyed_data(data) {
    var del_id=data.value;
    $.ajax({
        type: "POST",
        url: "ajax_case_master.php",
        data: {
            'action': 'delete_missing_book',
            'reference_id': del_id,
            'lost_type': '0',
             table: "tbl_book_reference_no",
        },
        success: function(res) {
            console.log(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                //get_member_book_list(book_name, author_name);
                sessionStorage.message = "Destroyed Book data is deleted successfully";
                sessionStorage.type = "error";
                showMessage();
                setTimeout(function(){
                    window.location.reload(1);
                    }, 1500);
            }
        }
    })
}

</script>
