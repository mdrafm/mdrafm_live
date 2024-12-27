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

<div class="pcoded-main-container">
<div class="pcoded-content">
<div class="row" > 
<div class="col-lg-5" >
<div class="alert-success shadow my-3" role="alert" style="margin-left:30%;border-radius: 0px;float:left;position:fixed;top:0" id="alert_msg">
</div>
</div>  
</div>
<form id="frm_add">
<div class="row">
<div class="col-5">
<label for="" class="">Request Upto Date :</label>
<input class="form-control" type="date" name="upto_date" id="upto_date"
placeholder="Upto Date" required>
</div>
<div class="col-auto" style="margin-left:1%;padding-top:2%">
<button type="button" class="btn btn-primary mb-3" onclick="get_book_name()">Find Book Request</button>
</div>
</div>

</form>
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-md-12">
                    <!-- <div class=" table-striped table-hover" id="result_tbl">
                    </div> -->
                    
                    <div class="card table-card">
                        <div class="card-header">
                            <h5>Book List</h5>
                            <div id="tbl_book_list" class="table table-responsive table-striped table-hover">
                           
                             </div>
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
//For getting book details 
function get_book_name() {
var req_upto_date = $('#upto_date').val();
//alert(req_upto_date);
verify_member_request_book_list(req_upto_date);  
}
</script>