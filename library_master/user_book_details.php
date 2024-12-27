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
  $db->select('tbl_user',"name,username",null,'status=1 group by name',null,null);
  $res_user = $db->getResult();
  //print_r($res_user);
  $name_list = array();
  $phn_list = array();
    foreach($res_user as $res)
    {
    $name=trim($res['name']);
    $phone=trim($res['username']);
    array_push($name_list,$name);
    array_push($phn_list,$phone);
    }
 //print_r($name_list);
?>
<div class="pcoded-main-container">
<div class="pcoded-content">
<div class="row" > 
		<div class="col-lg-7">
			<div class="alert-success shadow my-3" role="alert" style="border-radius: 0px;float:right !important" id="alert_msg">
			</div>
		</div>  
        </div>
<form id="frm_add">
<div class="row">
<div class="col-5">
<label for="" class="">User Name</label>
<input class="form-control" type="search" name="user_name" id="user_name"
placeholder="User Name (A-Z)" required>
</div>
OR
<div class="form-group col-md-6 ">
<label>Phone No. :</label>
<input class="form-control" type="search" name="Phone_num" id="Phone_num"
placeholder="Phone Number (0-9)" required>
<small class="text-danger"></small>
</div>
<div class="col-auto" style="padding-top:2%">
<button type="button" class="btn btn-primary mb-3" onclick="get_user_details()">Show</button>

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
                            <h5>User Details List</h5>
                            <!-- <div class="loader" style="display: none;margin-left: 35%;">
                                <img src="../admin/assets/img/loader.gif" class="loader_img" alt="Loading" style="width: 300px;height: 90px;" />
                            </div> -->
                            <div id="tbl_case_law" class="table table-responsive table-striped table-hover">
                           
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

//For getting book details 
function get_user_details() {
var user_name = $('#user_name').val();
var Phone_num = $('#Phone_num').val();
  // console.log(subject_id);
  // console.log(book_name);
  get_user_list(user_name,Phone_num);  
}

//Autocomplete
  let name_list =  <?php echo json_encode($name_list) ?>;
  let phn_list =  <?php echo json_encode($phn_list) ?>;
  //console.log(name_list);
  //console.log(phn_list);

  function autocomplete(searchEle, arr) {
    console.log(arr[0]);
      var currentFocus;
      searchEle.addEventListener("input", function(e) {
         var divCreate,
         b,
         i,
         fieldVal = this.value;
         closeAllLists();
         if (!fieldVal) {
            return false;
         }
         currentFocus = -1;
         divCreate = document.createElement("DIV");
         divCreate.setAttribute("id", this.id + "autocomplete-list");
         divCreate.setAttribute("class", "autocomplete-items");
         this.parentNode.appendChild(divCreate);
         for (i = 0; i <arr.length; i++) {
            if ( arr[i].substr(0, fieldVal.length).toUpperCase() == fieldVal.toUpperCase() ) {
               b = document.createElement("DIV");
               b.innerHTML = "<strong>" + arr[i].substr(0, fieldVal.length) + "</strong>";
               b.innerHTML += arr[i].substr(fieldVal.length);
               b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
               b.addEventListener("click", function(e) {
                  searchEle.value = this.getElementsByTagName("input")[0].value;
                  closeAllLists();
               });
               divCreate.appendChild(b);
            }
         }
      });
      searchEle.addEventListener("keydown", function(e) {
         var autocompleteList = document.getElementById(
            this.id + "autocomplete-list"
         );
         if (autocompleteList)
            autocompleteList = autocompleteList.getElementsByTagName("div");
         if (e.keyCode == 40) {
            currentFocus++;
            addActive(autocompleteList);
         }
         else if (e.keyCode == 38) {
            //up
            currentFocus--;
            addActive(autocompleteList);
         }
         else if (e.keyCode == 13) {
            e.preventDefault();
            if (currentFocus > -1) {
               if (autocompleteList) autocompleteList[currentFocus].click();
            }
         }
      });
      function addActive(autocompleteList) {
         if (!autocompleteList) return false;
            removeActive(autocompleteList);
         if (currentFocus >= autocompleteList.length) currentFocus = 0;
         if (currentFocus < 0) currentFocus = autocompleteList.length - 1;
         autocompleteList[currentFocus].classList.add("autocomplete-active");
      }
      function removeActive(autocompleteList) {
         for (var i = 0; i < autocompleteList.length; i++) {
            autocompleteList[i].classList.remove("autocomplete-active");
         }
      }
      function closeAllLists(elmnt) {
         var autocompleteList = document.getElementsByClassName(
            "autocomplete-items"
         );
         for (var i = 0; i < autocompleteList.length; i++) {
            if (elmnt != autocompleteList[i] && elmnt != searchEle) {
               autocompleteList[i].parentNode.removeChild(autocompleteList[i]);
            }
         }
      }
      document.addEventListener("click", function(e) {
         closeAllLists(e.target);
      });
   }
   //console.log(name_list);
  autocomplete(document.getElementById("user_name"), name_list);
  autocomplete(document.getElementById("Phone_num"), phn_list);
  
</script>
