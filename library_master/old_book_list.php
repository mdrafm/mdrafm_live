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
$db->select('tbl_old_book_list',"*",null,null,'bk_ref_no',null);
$old_res_book = $db->getResult(); 
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
                            <div id="tbl_case_law" class="table table-responsive table-striped table-hover">
                            <?php 
if(!empty($old_res_book))
{ ?>
<table id="case_law" class="table">
<h4 align="center">Old Book Register</h4>
    <thead class="" style="background: #315682;color:#fff;">
        <th style="width:40px;">Sl</th>
        <th>Acc No.</th>
        <th>Book Name </th>
        <th>Author Name</th>
        <th>Edition</th>
        <th>Year</th>
        <th>Place & Publisher</th>
        <th>Page</th>
        <th>Price</th>
        <th>quantity</th>
        <th>Location</th>
        <th>Row</th>
        <th>Book Type</th>
    </thead>
    <tbody>
        <?php 
                            //print_r($res_book);
                            $sl_no=1;
                           foreach($old_res_book as $res)
                           {
                            $id=$res['id'];
                            //$book_id=$res['tbl_book_id'];
                            $book_ref_no=$res['bk_ref_no'];
                            $book_name=$res['book_name'];
                            $author_name=$res['author_name'];
                            $edition=$res['edition'];
                            $year_of_publication=$res['year_of_publication'];
                            $place_publisher=$res['place_publisher'];
                            //$volume=$res['volume'];
                            $page=$res['page'];
                            $price=$res['price'];
                          //  $quantity=$res['quantity'];
                            $location=$res['location'];
                            $row=$res['row'];
                            $book_type=$res['book_type'];
                            //$status=$res['status'];
                            ?>
        <tr>
            <td style="text-align:center;"><?php echo $sl_no++;?></td>
            <td><?php echo $book_ref_no?></td>
            <td><?php echo $book_name?></td>
            <td><?php echo $author_name?></td>
            <td><?php echo $edition?></td>
            <td><?php echo $year_of_publication?></td>
            <td><?php echo $place_publisher?></td>
            <td><?php echo $page?></td>
            <td><?php echo $price?></td>
            <td><?php echo "1";?></td>
            <td><?php echo $location?></td>
            <td><?php echo $row?></td>
            <td><?php echo $book_type?></td>
        </tr>
        <?php   }
                            ?>
    </tbody>
</table>
<?php } else 
{
    echo '<b style="color:red">No data found</b>';
}
?>
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
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>


<script src="../js/case.js"> </script>
<script type="text/javascript">
$( document ).ready(function() {
    $('#case_law').DataTable();
    var location_id = $('#location_id option:selected').text();
	//alert(location_id);
});

</script>