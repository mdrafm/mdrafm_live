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
        font-size: 18px;
        margin: 40px;
        text-align: center;
        color: #fff;
        display: none;
		margin-top: 6%;
        margin-left: 50%;
        padding:2%;
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
        font-size: 1.2rem;
        font-weight: 600;

    }
    .select2-search__field {
        height: 2rem;
    }
    table.dataTable tbody th, table.dataTable tbody td {
    padding: 3px 3px;
    line-height: 2.5;
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
$db->select('tbl_book_request_issue',"DISTINCT(status)",null,null,null,null);
$res_status = $db->getResult();
//print_r($res_location);
?>
<div class="pcoded-main-container">
<div class="pcoded-content">
<div class="row" > 
		<div class="col-lg-7" >
			<div class="alert-success shadow my-3" role="alert" style="border-radius: 0px;float:right !important" id="alert_msg">
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
OR 
<div class="col-5">
<label for="" class="">Book Request/Issue/return</label>
<select class="form-control me-2" aria-label="Default select example" name="status_type" id="status_type">
<option value="">Select Location</option>
<option value="1">Book Requested</option>     
<option value="2">Book Issued</option> 
<option value="4">Book Returned</option>      
<option value="3">Request Rejected</option>             
</select>
</div>
<div class="col-auto" style="margin-left:1%;padding-top:2%">
<button type="button" class="btn btn-primary mb-3" onclick="get_book_name()">Show</button>
</div>
</div>

</form>
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-md-12">
                <h5  style='text-align:left'>Book Request/Issue List</h5>
                
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
var status_type = $('#status_type').val();
get_member_request_book_list(req_upto_date,status_type);  
}
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
        XLSX.writeFile(wb, fn || ('ISSUEDLIST.' + (type || 'xlsx')));
}
</script>