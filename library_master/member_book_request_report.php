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
        margin-left: 50%;
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
  $db->select('tbl_book_details',"*",null,null,null,null);
  $res_book = $db->getResult();
  $book_list = array();
    foreach($res_book as $res)
    {
    $book_name=$res['book_name'];
    array_push($book_list,$book_name);
    }
  $db->select('tbl_book_type',"*",null,null,null,null);
  $res_subject = $db->getResult();
    //print_r($res_location);
    $user_id=$_SESSION['user_id'];
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
                    <h5>Book Request / Issued List</h5>
                    <div class="card table-card">
                        <div class="card-header">
                           
                            <div id="tbl_case_law" class="table table-responsive table-striped table-hover">
                            <?php $db->select('tbl_book_details',"tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk_req.id as bk_req_id,tbl_bk_req.request_date,tbl_bk_req.status,tbl_bk_req.issue_date,tbl_bk_req.no_of_days",' tbl_bk JOIN tbl_book_reference_no tbl_bk_ref ON tbl_bk.id =tbl_bk_ref.tbl_book_id 
                            LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id','tbl_bk_req.user_id= "'.$user_id.'" 
                            GROUP BY tbl_bk_req.id order by tbl_bk_req.id desc',null,null);
                            $res_book = $db->getResult();
                                ?>
                     <table id="case_law" class="table">
                            <thead class="" style="background: #315682;color:#fff;">
                            <th style="width:50px;">Sl No</th>
                            <th >Book Name </th>
                            <th >Author Name</th>
                            <th>Request Date</th>
                            <th>Issue Date</th>
                            <th>Due Date</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            <?php 
                        
                            $sl_no=1;
							$book_list = array();
                           foreach($res_book as $res)
                           {
                            $id=$res['id'];
                            $bk_req_id=$res['bk_req_id'];
                            $book_name=$res['book_name'];
                            $author_name=$res['author_name']; 
						    array_push($book_list,$book_name);
                            $issue_date=$res['issue_date'];
                            $no_of_days=$res['no_of_days'];
                            $request_date=$res['request_date'];
                            $quantity=$res['quantity'];
                            ?>
                            <tr>
                                <td><?php echo $sl_no++;?></td>
                                <td><?php echo $book_name?></td>
                                <td><?php echo $author_name?></td>
                                <?php 
                               // $db->select('tbl_book_request_issue',"*",null,'book_id= "'.$id.'" and user_id ="'.$user_id.'"',null,null);
                                //$res_book = $db->fetch_row(); 
                                $sql = 'SELECT * FROM tbl_book_request_issue WHERE id= "'.$bk_req_id.'" and user_id ="'.$user_id.'"';
                               $res_book= $db->select_sql_row($sql);
                               if(!empty($res_book))
                               {
                                $issue_date=$res_book->issue_date;
                                $no_of_days=$res_book->no_of_days;
                                $status=$res_book->status;
                                $request_date=$res_book->request_date;
                                $due_date=date('d-m-Y', strtotime($issue_date. "+".$no_of_days."days"));
                               }
                               else{
                                $issue_date='';
                                $no_of_days='';
                                $status='';
                                $request_date='';
                                $due_date='';
                               }
                                //$row = $db->fetch_row();
                                //echo $status=$row['status']; 
                               //echo $issue_date=$row['issue_date']; 
                               //echo $no_of_days=$row['no_of_days']; 
                                ?>
                                  <td><?php if(isset($request_date) && $request_date !="0000-00-00")
                                {
                                    echo date('d-m-Y',strtotime($request_date));
                                }
                               else
                               {
                                    echo "";
                               } ?> </td>
                                <td><?php if(isset($issue_date) && $issue_date !="0000-00-00")
                                {
                                    echo date('d-m-Y',strtotime($issue_date));
                                }
                               else
                               {
                                    echo "";
                               } ?> </td>
                                <td>
                                <?php if(isset($no_of_days) && $no_of_days !="0")
                                {
                                    echo $due_date;
                                }
                               else
                               {
                                    echo "";
                               } ?> 
                              </td> 
                                <td>
                                <form id="frm_insert">
                                <?php //echo $_SESSION['user_id']; ?>
                                <input type="hidden" name="book_id" value="<?=$id?>" id="book_id_<?=$id?>"/>
                                <?php
                                if(!empty($res_book) && $status==1)
                                { ?>
                               <span style="color:#ed7d0a;font-size: 15px;font-weight: 700">Book Request sent</span>
                               <?php }
                              else if(!empty($res_book) && $status==2)
                              { ?>
                              <span style="font-size: 15px;font-weight: 700;color:#1aaf08">Book Issued</span>     
                             <?php }
                             else if(!empty($res_book) && $status==3)
                             { ?>
                             <span style="font-size: 15px;font-weight: 700;color:#e96b00;">Book Not Available</span>     
                            <?php }
                              else if(!empty($res_book) && $status==4)
                              { ?>
                                <span style="color:#0b3beb;padding-right:5px;font-size: 15px;font-weight: 700">Book Returned</span>
                             <?php }
                              ?>
                              
                                </form>
                                </td>
                                
                            </tr>
                        <?php   }
                            ?>
                            </tbody>
                            </table>
                             </div>
                        </div>
                    </div>
                <?php //print_r($book_list) ?>
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
