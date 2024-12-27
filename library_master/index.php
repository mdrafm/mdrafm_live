<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('header_link.php') ?>

    <style type="text/css">
        .table_wrapper {
            margin: 20px;
        }

        #year_case th {
            background: #2c3e50ed;
            color: #fff;
        }

        #court th {
            background: #2c3e50ed;
            color: #fff;
        }

        .card-header {
            background: #0d9c5beb;

        }
        .stl_css
        {
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
            font-size: 14px;
            font-weight: 400;
            line-height: 1.3;
            
        }
        .size_fnt
        {
            font-size:17px;
        }
    </style>

</head>

<body style="padding-right: 0px !important">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ navigation menu ] start -->
    <?php include('sidebar_nav.php') ?>
    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
    <?php include('header_nav.php') ?>
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header" style="margin-bottom: 0px;">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Dashboard</h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <!--<div class="row">
                <div class="col-md-4 mb-4 stretch-card transparent widget-primary-card">
                    <div class="card card-tale">
                        <div class="card-body">
                            <div class="row">
                            <div class="col-md-3 flat-card card-body " ><i class="feather icon-star-on"></i></div>
                            <div class="col-md-9" ><?php
                                                    $db->select('tbl_book_reference_no', "COUNT(*) as total_num", null, "status =0", null, null);
                                                    foreach ($db->getResult() as $book_count) {
                                                    ?>
                                    <h4>Total BooK</h4>
                                    <h6><?php echo $book_count['total_num'] ?></h6>
                                <?php
                                                    }
                                ?></div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Total Bookings</p>
                            <p class="fs-30 mb-2">61344</p>
                            <p>22.00% (30 days)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Total Bookings</p>
                            <p class="fs-30 mb-2">61344</p>
                            <p>22.00% (30 days)</p>
                        </div>
                    </div>
                </div>
            </div>-->
            <?php if($_SESSION['roll_id'] == 15) {
            ?>
            <div class="row" style="box-sizing: border-box;padding: 0px">
                <div class="col-md-3 card flat-card widget-primary-card" style="background-color:#03a9f4;padding: 15px">
                <div class="row-table"> 
                <div class="col-md-3 card-body" style="background-color:#0981b7">
                     <i class="feather icon-star-on"></i>
                    </div>
                    <div class="col-sm-8">
                                <?php 
                             $db->select('tbl_book_reference_no',"COUNT(*) as total_num",null,'status!=2',null,null);
                             foreach($db->getResult() as $book_count){
                                ?>
                                <h4>Total BooK</h4>
                                <h6><?php echo $book_count['total_num'] ?></h6>
                                <?php
                             }
                            ?>
                    </div>
                    </div>
                    </div>
                    <div class="col-md-1"></div>
                 <div class="col-md-3 card flat-card widget-primary-card" style="background-color:#ff9800">
                <div class="row-table">
                <div class="col-md-3 card-body" style="background-color:#d18414">
                     <i class="feather icon-star-on"></i>
                    </div>
                    <div class="col-sm-8">
                        
                                <?php 
                             $db->select('tbl_book_request_issue',"COUNT(*) as total_num",null,"status =".$req_status ,null,null);
                             foreach($db->getResult() as $book_count){
                                ?>
                                <h4 style="color:white">Book Request</h4>
                                <h6><?php echo $book_count['total_num'] ?></h6>
                                <?php
                             }
                            ?>
                    </div>
                    </div>
                    </div>
                    <div class="col-md-1"></div>
                <div class="col-md-3 card flat-card widget-primary-card" style="background-color:#4caf50" >
                <div class="row-table">
                <div class="col-md-3 card-body" style="background-color:#429746">
                     <i class="feather icon-star-on" ></i>
                    </div>
                    <div class="col-sm-8">
                                <?php 
                             $db->select('tbl_book_request_issue',"COUNT(*) as total_num",null,"status =2",null,null);
                             foreach($db->getResult() as $book_count){
                                ?>
                                <h4>Book Issued</h4>
                                <h6><?php echo $book_count['total_num'] ?></h6>
                                <?php
                             }
                            ?>
                    </div>
                    </div>
                    </div>
            </div>
           <?php } else if($_SESSION['roll_id'] == 9 || $_SESSION['roll_id'] == 4) {
            ?>
            <div class="row" style="box-sizing: border-box;padding: 0px">
                <div class="col-md-3 card flat-card widget-primary-card" style="padding: 30px">
                <div class="row-table">
                <div class="col-md-3 card-body">
                     <i class="feather icon-star-on"></i>
                    </div>
                    <div class="col-sm-8">
                                <?php 
                             $db->select('tbl_book_reference_no',"COUNT(*) as total_num",null,"status !=2",null,null);
                             foreach($db->getResult() as $book_count){
                                ?>
                                <h4>Total BooK</h4>
                                <h6><?php echo $book_count['total_num'] ?></h6>
                                <?php
                             }
                            ?>
                    </div>
                    </div>
                    </div>
                    <div class="col-md-1"></div>
                 <div class="col-md-3 card flat-card widget-primary-card" style="background-color:#ff9800">
                <div class="row-table">
                <div class="col-md-3 card-body" style="background-color:#d18414">
                     <i class="feather icon-star-on"></i>
                    </div>
                    <div class="col-sm-8">
                        
                                <?php 
                             $db->select('tbl_book_request_issue',"COUNT(*) as total_num",null,"status =".$req_status ,null,null);
                             foreach($db->getResult() as $book_count){
                                ?>
                                <h4><a href="member_book_issue.php" style="color:white">Book Request</a></h4>
                                <h6><?php echo $book_count['total_num'] ?></h6>
                                <?php
                             }
                            ?>
                    </div>
                    </div>
                    </div>
                    <div class="col-md-1"></div>
                <div class="col-md-3 card flat-card widget-primary-card" style="background-color:#4caf50" >
                <div class="row-table">
                <div class="col-md-3 card-body" style="background-color:#429746">
                     <i class="feather icon-star-on" ></i>
                    </div>
                    <div class="col-sm-8">
                                <?php 
                                //print_r($_SESSION);
                                 $user_id=$_SESSION['user_id'];
                             $db->select('tbl_book_request_issue',"COUNT(*) as total_num",null,"status =2 and user_id=$user_id",null,null);
                                //print_r($db);
                             foreach($db->getResult() as $book_count){
                                ?>
                                <h4>Book Issued</h4>
                                <h6><?php echo $book_count['total_num'] ?></h6>
                                <?php
                             }
                            ?>
                    </div>
                    </div>
                    </div>
            </div>
           <?php } ?>
           <div style="background-color:#fbfbfba1;border-top:3px solid #6c757db8;" class="row" >
            <div class="col-md-12" style="padding-left:2%;padding-right:2%">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
    <div style="font-size:20px" >
    <h4 style="text-align:center;padding-top:1%">GUIDELINES FOR USE OF LIBRARY BOOKS</h4>
            <p style="font-size:15px;font-family: sans-serif;">The following Guidelines regarding requisition, issue and use of library books are made for smooth functioning of the library :</p>
            <p class="stl_css">1.	Library Books may be issued on the basis of online requisition.</p>
            <p  class="stl_css">2.	The requisition may be submitted by the users through <b>“E-Library Management Software”</b>.
            <p  class="stl_css">3. 	The requisition submitted by the users should be on the basis of availability of books in the library which may be accessed through the Academy website / database.</p>
            <p  class="stl_css">4.	The books for which requisition are submitted by the users shall ordinarily be issued after 24 hours from the time at which such requisition is made except for Govt. Holidays.</p>
            <p  class="stl_css">5.	Text books may be return to the library within 3 months from the date of issue. The same can be further re-issued. In case a book is not return in time, penalty of Rs.2/- per day may be imposed.</p>
            <p  class="stl_css">6.	In case of emergency, maximum 03 (three) Nos. of text books can be issued within 2 hours of the submission of requisition.</p>
            <p  class="stl_css"><span>7. In case of fiction & non-fiction books, maximum 5 (five) Nos. of books may be issued for 15 days / 2 weeks consecutively. The same can be re-issued further for 7 days. In case the same is not returned in time, penalty of Rs.2/- per day may be imposed.</span></p>
            <p  class="stl_css">8. <span>In case the online procedure is disrupted due to any technical reasons, in that case books may be manually requisitioned on recommendation of the Course Director and issued for a period of seven days (1 Week). After lapse of 7 days the book may be requisitioned through online procedure for the updation of the E-Library process. In case if the technical fault persists for more than 7 days or 1 week requisition through online procedure may not be possible and the above books may be requisitioned through <b>Officer-in-Charge of Library</b>.</span></p>
            <div class="container stl_css">
            <div class="row justify-content-md-left">
            <div class="col col-lg-2">
           Example :
            </div>
            <div class="col col-lg-2">
            Price of book 
            </div>
            <div class="col col-lg-2" style="text-align:left">
            Rs.500/
            </div>
            </div>
            <div class="row justify-content-md-left">
            <div class="col col-lg-2">
            </div>
            <div class="col col-lg-2">
            Penalty 2 times
            </div>
            <div class="col col-lg-2" style="text-align:left">
            Rs.1000/-
            </div>
            </div>
            <div class="row justify-content-md-left">
            <div class="col col-lg-2">
            </div>
            <div class="col col-lg-2">
            Fine
            </div>
            <div class="col col-lg-2" style="text-align:left">
            Rs.100/-
            </div>
            </div>
            <div class="row justify-content-md-left">
            <div class="col col-lg-2">
            </div>
            <div class="col col-lg-2">
            </div>
            <div class="col col-lg-2" style="text-align:left">
            Rs.1100/-
            </div>
            </div>
            <p style="font-size:17px;padding-left:16%"><b style="color:red">*</b>2 times penalty for normal loss of books</p>
            <div class="row justify-content-md-left">
            <div class="col col-lg-2">
            </div>
            <div class="col col-lg-2">
            Penalty 3 times
            </div>
            <div class="col col-lg-2" style="text-align:left">
            Rs.1500/-
            </div>
            </div>
            <div class="row justify-content-md-left">
            <div class="col col-lg-2">
            </div>
            <div class="col col-lg-2">
            Fine
            </div>
            <div class="col col-lg-2" style="text-align:left">
            Rs.100/-
            </div>
            </div>
            <div class="row justify-content-md-left">
            <div class="col col-lg-2">
            </div>
            <div class="col col-lg-2">
            </div>
            <div class="col col-lg-2" style="text-align:left">
            Rs.1600/-
            </div>
            </div>
            <p style="font-size:17px;padding-left:16%"> <b style="color:red">*</b>3 times penalty for rarely availability of books in the market.</p>
            </div>
            <p  class="stl_css">9.  Library Time		 -	 10.00 AM to 05.30 PM (Except Govt. Holidays)</p>
            <p class="stl_css" style="padding-left:1%">   Lunch break 		-	2.00 PM to 2.30 PM</p>
            </div>
    </div>
    <div class="carousel-item">
    <div class="container">
  <div class="row" style="padding:4%">
    <div class="col-sm">
    <img src="../images/cover_photo/Abdul kalam a life.jpeg" width="230" height="230">
    </div>
    <div class="col-sm">
    <img src="../images/cover_photo/godhulira bagha.jpg" width="230" height="230">
    </div>
    <div class="col-sm">
    <img src="../images/cover_photo/target 3 billion.jpg" width="230" height="230">
    </div>
    <div class="col-sm">
    <img src="../images/cover_photo/beyond 2020.jpeg" width="230" height="230">
    </div>
  </div>
  <div class="row" style="padding:4%">
    <div class="col-sm">
    <img src="../images/cover_photo/Adina barsha.jpg" width="230" height="230">
    </div>
    <div class="col-sm">
    <img src="../images/cover_photo/President.jpg" width="230" height="230">
    </div>
    <div class="col-sm">
    <img src="../images/cover_photo/Girl in room no 105.jpeg" width="230" height="230">
    </div>
    <div class="col-sm">
    <img src="../images/cover_photo/vission india.jpeg" width="230" height="230">
    </div>
  </div>
</div>
    </div>
    <div class="carousel-item">
    <div class="container">
  <div class="row" style="padding:4%">
    <div class="col-sm">
    <img src="../images/cover_photo/janyaseni.jpg" width="230" height="230">
    </div>
    <div class="col-sm">
    <img src="../images/cover_photo/Love knows no loc.jpeg" width="230" height="230">
    </div>
    <div class="col-sm">
    <img src="../images/cover_photo/mamu.jpg" width="230" height="230">
    </div>
    <div class="col-sm">
    <img src="../images/cover_photo/Vikram sarabhai.jpg" width="230" height="230">
    </div>
  </div>
  <div class="row" style="padding:4%">
    <div class="col-sm">
    <img src="../images/cover_photo/the monk who sold his ferrari.jpg" width="230" height="230">
    </div>
    <div class="col-sm">
    <img src="../images/cover_photo/Rich dad poor dad.jpeg" width="230" height="230">
    </div>
    <div class="col-sm">
    <img src="../images/cover_photo/Kashi secret of the black tremple.jpeg" width="230" height="230">
    </div>
    <div class="col-sm">
    <img src="../images/cover_photo/gajapati.jpg" width="230" height="230">
    </div>
  </div>
</div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
            </div> 
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>


    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
    <!-- custom-chart js -->
    <script src="assets/js/pages/dashboard-main.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

</body>

</html>

<script>
    $('#year_case').DataTable();
    $('#court').DataTable();



    function datapost(path, params, method) {
        //alert(path);
        method = method || "post"; // Set method to post by default if not specified.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);
        for (var key in params) {
            if (params.hasOwnProperty(key)) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);
                form.appendChild(hiddenField);
            }
        }
        document.body.appendChild(form);
        form.submit();
    }
</script>