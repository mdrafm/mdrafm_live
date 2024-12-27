
<?php 
 session_start();

if (isset($_SESSION))
{
      session_destroy();
      unset($_SESSION);
}

include('header.php'); 
include('nav_bar.php') ;

header('Content-Type: text/html; charset=utf-8');

?>

<?php 
// echo 12345;
// include ('admin/database.php');
// $conn = new Database();
// echo 123;

?>
<!--location Modal start -->
<div class="modal fade" id="location" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 650px">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Madhusudan Das Regional Academy of Financial
                    Management (MDRAFM), Bhubaneswar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14967.093460744445!2d85.8138516!3d20.3096459!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x1e98ae9e0901e35c!2sMadhusudan%20Das%20Regional%20Academy%20of%20Financial%20Management%20(MDRAFM)!5e0!3m2!1sen!2sin!4v1643266425146!5m2!1sen!2sin"
                    width="600" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <!-- <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  
                  </div> -->
        </div>
    </div>
</div>
<!-- location Modal end -->
<!-- info section start -->
<section id="" style="display:block;"  >
 <div class="row">

        <!-- Slider main container -->
         <div class="col-md-9" style="float:;margin-left">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" style="margin-left:4%">
        <div class="carousel-inner">
        <div class="carousel-item active">
        <img src="images/slider/ISO.jpg" class="d-block w-100" alt="..." height="500">
        <div style="margin: -20rem 10rem">
            <p style="outline: inset 1px #e89878;width: 18%;border-radius: 3px;padding: 5px;color: #f3c50b;font-weight: 700;" >CERTIFICATIONS</p>
         <h1 style="font-size:4rem;font-weight: 700;" >ISO 9001:2015 Certified</h1>
          <p style="font-size: 1.2rem;color:#b6c0dc">Committed to Capacity Building in the area of Public Finance Management</p>
        </div> 
          
        </div>
        <div class="carousel-item ">
        <img src="images/slider/photo1.jpg" class="d-block w-100" alt="..." height="500">
        </div>
        <div class="carousel-item">
        <img src="images/slider/photo2.jpg" class="d-block w-100" alt="..." height="500">
        </div>
        <div class="carousel-item">
        <img src="images/slider/photo3.jpeg" class="d-block w-100" alt="..." height="500">
        </div>
       <!--  <div class="carousel-item">
        <img src="images/slider/photo4.jpeg" class="d-block w-100" alt="..." height="500">
        </div> -->
        <div class="carousel-item">
        <img src="images/slider/photo5.jpg" class="d-block w-100" alt="..." height="500">
        </div>
        <div class="carousel-item">
        <img src="images/slider/photo4.jpeg" class="d-block w-100" alt="..." height="500">
        </div> 
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
        </button>
        </div>
      </div>
 
    <div class="col-md-3" style="padding-right:2%">
    <div class="woners" style="">
            <!-- <img src="images/bg-2.jpg" style="width: 400px;float: right;" /> -->

            <div class="header-buttom ">
                   <!--  <div class="pt-1" style="">
                        <div class="Profile prof2" style="width:360px;">
                            <img class="photo" src="images/bk.jpg" width="100" height="100"
                                style="margin-left: 8rem; border:solid 1px #CCC;border-radius: 50%;">
                            <div class="desig pt-2" style="margin-left: 5rem;"><strong>Shri Bikram Keshari Arukha</strong><br><span style="color:#010101;font-size: 12px;"> Hon'ble Cabinet Minister, Finance</span></div>
                        </div>
                    </div> -->
                    <div class="pt-2" style="">
                        <div class="Profile prof3" style="width:360px;">
                            <img class="photo" src="images/pri_sec.png" width="100" height="100"
                                style="margin-left: 8rem; border:solid 1px #CCC;border-radius: 50%;margin-top: 12px;">
                            <div class="desig pt-2" style="margin-left: 5rem;"><strong>Shri Saswat Mishra, IAS</strong><br> <span style="color:#010101;font-size: 12px;">Principal Secretary, Finance</span></div>
                        </div>
                    </div>
                    <div class="pt-2 img3" style="margin-bottom: px;">
                        <div class="Profile prof" style="width:360px;">
                            <img class="photo" src="images/director.png" width="100" height="100"
                                style="margin-left: 8rem; border:solid 1px #CCC;border-radius: 50%;margin-top: 12px;">
                            <div class="desig pt-1" style="margin-left: 5rem;"><strong>Shri Ashok kumar Mohanty, OFS</strong><br><span style="color:#010101;font-size: 12px;">Director,MDRAFM</span></div>
                        </div>
                    </div>
                </div>
    </div>
    </div>
 </div>
</section>
<div></div>
<!-- info section end -->
<!-- news section start -->
<!-- <div class=" " style="margin-top:-10px ;background-image:url(images/bg-1-1.jpg);height: 365px;" > -->
    <!-- <div id="scroll-container">
  <div id="" style="" ><marquee  width="" style="color:#9b0707 ;animation: scroll-left 50s linear infinite, blink 1s step-start 2s infinite"><img src="images/new-blinking.gif" width="60">
  <a href= "pdf/Corrigendum.pdf" target="_blank" class="text-decoration-none text-danger">Corrigendum</a> |<img src="images/new-blinking.gif" width="60">
  <a href= "pdf/cfms_notice.pdf" target="_blank" class="text-decoration-none text-danger">Rescheduling of pre-proposal meeting(for CFMS) from 09.09.2024 to 10.09.2024 </a> | <img src="images/new-blinking.gif" width="60">
  <a href= "pdf/CFMS_MDRAFM.pdf" target="_blank" class="text-decoration-none text-danger">REQUEST FOR PROPOSAL (RFP) FOR SELECTION OF AGENCY FOR PROVIDING CFMS, AUGUST, 2024 </a></marquee></div>
</div> -->
<section class="" style="display: block;margin-top:10px">
    <div class="notice ">
        <div class=" information">
            <div class="notification info-box holder" style="background-color:#cbf6ff;">
                <h3 class="content-header">Ongoing Training Programmes</h3>
                <div class="content ">
                   <div class="view-content" style="height: 200px;overflow: auto;margin-top: -4px;">
                        
                        <ul style="list-style-type: circle;padding: 20px;">
                        <?php 
                                  
                                  $conn->select('tbl_other_program',"*",null,'status=1',null,null);
                                  $res = $conn->getResult();
                                    foreach($res as $row){

                                          //print_r($row);exit;
                                      $curr = date("Y-m-d");
                                      $currDate=date('Y-m-d', strtotime($curr));

                                    $active = date('Y-m-d', strtotime($row['active_dt']));
                                    $inActive = date('Y-m-d', strtotime($row['in_active_dt']));
                                    
                                    if (($currDate >= $active) && ($currDate <= $inActive)){
                                          ?>
                                          <li>

                                                <a style="color: #0d3746;text-decoration: none;font-weight: 300;font-size: 15px;" href="#">
                                                <?php echo $row['title']; ?>
                                                </a>
                                                <span><img src="images/newicon.gif" style="height: 20px; width: 40px; user-select: auto;display:<?php echo ($row['new'] == 1)?'':'none'; ?>"></span>
                                          </li>
                                          
                                          <hr style="border:none;background:rgb(230 4 4 / 57%);height:1px;margin:10px 0px; width:390px;">
                                                
                                       <?php
                                    }
                                       
                                  }

                                  // mid programme
                                  $conn->select('tbl_mid_program_master',"*",null,'active=1',null,null);

                                  $res = $conn->getResult();
                                    foreach($res as $row1){

                                          //print_r($row);exit;
                                      $curr = date("Y-m-d");
                                      $currDate=date('Y-m-d', strtotime($curr));

                                    $active = date('Y-m-d', strtotime($row1['start_date']));
                                    $inActive = date('Y-m-d', strtotime($row1['end_date']));

                                    $cDate = date('d-m-Y', strtotime($row1['start_date']));
                                    
                                    if (($currDate >= $active) && ($currDate <= $inActive)){
                                          ?>
                                          <li>

                                                <a style="color: #0d3746;text-decoration: none;font-weight: 300;font-size: 15px;" href="onGoingProgram.php">
                                                <?php echo $row1['prg_name'] .' has commenced from '.$cDate; ?>
                                                </a> <span><img src="images/newicon.gif" style="height: 20px; width: 40px; user-select: auto;display:<?php echo ($row['new'] == 1)?'':'none'; ?>"></span>
                                               
                                          </li>
                                          
                                          <hr style="border:none;background:rgb(230 4 4 / 57%);height:1px;margin:10px 0px; width:390px;">
                                                
                                       <?php
                                    }
                                       
                                  }
                                  //short term programme

                                  $conn->select('tbl_short_program_master',"*",null,'active=1',null,null);
                                  $res = $conn->getResult();
                                    foreach($res as $row2){

                                          //print_r($row);exit;
                                      $curr = date("Y-m-d");
                                      $currDate=date('Y-m-d', strtotime($curr));

                                    $active = date('Y-m-d', strtotime($row2['start_date']));
                                    $inActive = date('Y-m-d', strtotime($row2['end_date']));

                                     $sDate = date('d-m-Y', strtotime($row2['start_date']));
                                    
                                    if (($currDate >= $active) && ($currDate <= $inActive)){
                                          ?>
                                          <li>

                                                <a style="color: #0d3746;text-decoration: none;font-weight: 300;font-size: 15px;" href="onGoingProgram.php">
                                                <?php echo $row2['prg_name'] .' has commenced from '.$sDate; ?>
                                                </a> <span><img src="images/newicon.gif" style="height: 20px; width: 40px; user-select: auto;display:<?php echo ($row['new'] == 1)?'':'none'; ?>"></span>
                                               
                                          </li>
                                          
                                          <hr style="border:none;background:rgb(230 4 4 / 57%);height:1px;margin:10px 0px; width:390px;">
                                                
                                       <?php
                                    }
                                       
                                  }
                              
                              ?>
                              <?php 
                               //short term programme

                                  $conn->select('tbl_oneday_program_master',"*",null,'active=1',null,null);
                                  $res = $conn->getResult();
                                    foreach($res as $row2){

                                          //print_r($row);exit;
                                      $curr = date("Y-m-d");
                                      $currDate=date('Y-m-d', strtotime($curr));

                                    $active = date('Y-m-d', strtotime($row2['start_date']));
                                    //$inActive = date('Y-m-d', strtotime($row2['end_date']));

                                     $sDate = date('d-m-Y', strtotime($row2['start_date']));
                                    
                                    if ($currDate == $active){
                                          ?>
                                          <li>

                                                <a style="color: #0d3746;text-decoration: none;font-weight: 300;font-size: 15px;" href="onGoingProgram.php">
                                                <?php echo $row2['prg_name'] .' has commenced from '.$sDate; ?>
                                                </a> <span><img src="images/newicon.gif" style="height: 20px; width: 40px; user-select: auto;display:<?php echo ($row['new'] == 1)?'':'none'; ?>"></span>
                                               
                                          </li>
                                          
                                          <hr style="border:none;background:rgb(230 4 4 / 57%);height:1px;margin:10px 0px; width:390px;">
                                                
                                       <?php
                                    }
                                       
                                  }
                              
                              ?>


                        </ul>
                   

                </div>

                    <!-- <div class="footer-content">
                        <a href="news.php"> View More </a>
                    </div> -->
                </div>
            </div>
            
            
            
            <div class="events info-box holder" style="background-color:#cbf6ff;">
                <h3 class="content-header">Other Events</h3>
                <div class="content">
                    <div class="view-content" style="">
                   
                        <ul style="list-style-type: circle;padding: 20px;" id="news">
                        <?php 
                                  
                                  $conn->select('tbl_other_event',"*",null,null,null,null);
                                  $res1 = $conn->getResult();
                                    foreach($res1 as $row1){
                                         // print_r($row1);exit;
                                      $curr = date("Y-m-d");
                                      $currDate=date('Y-m-d', strtotime($curr));

                                    $active = date('Y-m-d', strtotime($row1['active_dt']));
                                    $inActive = date('Y-m-d', strtotime($row1['in_active_dt']));
                                    
                                    if (($currDate >= $active) && ($currDate <= $inActive)){
                                          ?>
                                          <li>
                                                <a style="color: #0d3746;text-decoration: none;font-weight: 300;font-size: 15px;" href="#" 
                                                onclick="datapost('events.php',{id: <?php echo $row1['id'] ?> })" >
                                                <?php echo $row1['title']; ?>
                                                </a>
                                                <span><img src="images/newicon.gif" style="height: 20px; width: 40px; user-select: auto;display:<?php echo ($row1['new'] == 1)?'':'none'; ?>"></span>
                                          </li>
                                          
                                          <hr style="border:none;background:rgb(230 4 4 / 57%);height:1px;margin:10px 0px; width:390px;">
                                                
                                       <?php
                                    }
                                       
                                  }
                              
                              ?>
                        </ul>
                       
                    </div>

                    <!-- <div class="footer-content">
                        <a href="events.php"> View More </a>
                    </div> -->
                </div>
            </div>

            <div class="events info-box holder" style="background-color:#cbf6ff;;">
                <h3 class="content-header">କବିତା ସଂକଳନ</h3>
                <div class="content">
                   <div class="view-content" style="">
                       
                            <ul style="list-style-type: circle;padding: 20px;" id="news2">
                            <?php 
                                  //mysqli_set_charset($conn, 'utf8');
                                //  $conn->set_charset('utf8');
                                  $conn->select('tbl_odia_kabita',"*",null,null,null,null);
                                   // $conn->set_charset('utf8');
                                  $res1 = $conn->getResult();
                                    foreach($res1 as $row1){
                                      // print_r($row1)
                                        ?>
                                          <li>
                                            <a style="color: #0d3746;text-decoration: none;font-weight: 300;font-size: 15px;" href="kabita.php?id=<?php echo $row1['id'] ?>">
                                                <?php echo $row1['title']; ?>
                                            </a>
                                                
                                          </li>
                                          
                                          <hr style="border:none;background:rgb(230 4 4 / 57%);height:1px;margin:10px 0px; width:390px;">
                                                
                                        <?php
                                  }
                              
                              ?>

                            </ul>
                       
                    </div>

                    <!-- <div class="footer-content">
                        <a href="events.php"> View More </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    </section>
    <section style="display:block;" >
        <div class="notice ">
             <div class=" information">
        <div class="new info-box holder" style="background-color:#cbf6ff;;">
                <h3 class="content-header">Completed Programmes</h3>
                <div class="content ">
                    <div class="view-content" style="">
                       
                            <ul style="list-style-type: circle;padding: 20px;" id="news2">
                           <?php 
                                  // long term program
                                 // $conn->select('tbl_program_master',"*",null,null,null,null);
                                  $conn->select_sql("SELECT * FROM `all_programs` ORDER BY start_date DESC");
                                  $res = $conn->getResult();
                                    foreach($res as $row){

                                          //print_r($row);exit;
                                      $curr = date("Y-m-d");
                                      $currDate=date('Y-m-d', strtotime($curr));

                                    $active = date('Y-m-d', strtotime($row['start_date']));
                                    $inActive = date('Y-m-d', strtotime($row['end_date']));

                                     $start_date = date('d-m-Y', strtotime($row['start_date']));
                                    $end_date = date('d-m-Y', strtotime($row['end_date']));

                                    
                                    if ($currDate >= $inActive) {
                                          ?>
                                          <li>

                                                <a style="color: #0d3746;text-decoration: none;font-weight: 300;font-size: 15px;" href="onGoingProgram.php">
                                                <?php echo $row['prg_name'].' from '.$start_date.' to '.$end_date;  ?>
                                                </a>
                                               
                                          </li>
                                          
                                          <hr style="border:none;background:rgb(230 4 4 / 57%);height:1px;margin:10px 0px; width:390px;">
                                                
                                       <?php
                                    }
                                       
                                  }

                              
                              ?>

                            </ul>
                       
                    </div>

                    <!-- <div class="footer-content">
                        <a href="news.php"> View More </a>
                    </div> -->
                </div>
            
        </div>

            <div class="notification info-box holder" style="background-color:#cbf6ff;;">
                <h3 class="content-header">Upcoming Programmes</h3>
                <div class="content ">
                    <div class="view-content" style="">
                       
                            <ul style="list-style-type: circle;padding: 20px;" id="news2">
                            <?php 
                                  
                                  $conn->select('tbl_short_program_master',"*",null,null,null,null);
                                  $res1 = $conn->getResult();
                                    foreach($res1 as $row1){
                                         // print_r($row1);exit;
                                      $curr = date("Y-m-d");
                                      $currDate=date('Y-m-d', strtotime($curr));

                                    $active = date('Y-m-d', strtotime($row1['start_date']));
                                    $inActive = date('Y-m-d', strtotime($row1['end_date']));
                                    
                                    if ( ($currDate < $active)){
                                          ?>
                                          <li>
                                                <a style="color: #0d3746;text-decoration: none;font-weight: 300;font-size: 15px;" href="#">
                                                <?php echo $row1['prg_name']; ?>
                                                </a>
                                                <span><img src="images/newicon.gif" style="height: 20px; width: 40px; user-select: auto;display:<?php echo ($row1['new'] == 1)?'':'none'; ?>"></span>
                                          </li>
                                          
                                          <hr style="border:none;background:rgb(230 4 4 / 57%);height:1px;margin:10px 0px; width:390px;">
                                                
                                       <?php
                                    }
                                       
                                  }
                              
                              ?>

                            </ul>
                       
                    </div>

                    <!-- <div class="footer-content">
                        <a href="news.php"> View More </a>
                    </div> -->
                </div>
            </div>

            <div class="notification info-box holder" style="background-color:#cbf6ff;">
                <h3 class="content-header">Image Gallery</h3>
                <div class="content">
                    <div class="view-content" style="height: 243px;overflow-y:hidden;margin-top:-8px">
                    <div id="carouselExampleControls1" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                 <img src="images/galary/mdrafm-1B44-9CCC-053805.jpeg"  width="525" alt="...">
                            </div>
                       
                        <?php
                        //$conn->select('tbl_image_gallery',"*",null,'status=1',null,null);
                        $conn->select_sql('SELECT * FROM `tbl_image_gallery` WHERE status = 1 ORDER BY id DESC');
                        
                             // print_r($db->getResult());
                               foreach($conn->getResult() as $row){

                                   ?>
                                   <div class="carousel-item  ">
                                       <a href="photogallery.php"><img src="images/galary/<?=isset($row['image'])?$row['image']:'';?>" width="525" alt="..."></a> 
                                    </div>
                                     <!-- <div class="carousel-caption "><?php echo ($row['img_title'])?></div> -->
                        <?php
                               }
                            ?>
                           
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls1" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls1" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        </div>
                    </div>

                    <!-- <div class="footer-content">
                        <a href="notification.php"> View More </a>
                    </div> -->
                </div>
            </div>
        </div>
        </div>
    </section>
<!-- </div> -->
<!-- news section end -->
<div id="scroll-container">
  <div id=""><marquee  width="" style="color:#9b0707">
  For any application issues kindly e-mail us at : <b>mdrafm@odisha.gov.in</b></marquee></div>
</div>

<!-- link section start-->
 
 <div class="link-container">
    <div class="row">
   <!--  <div class="col-md-4">
        <img src="images/lg1.png" style="width: 55%;">
    </div> -->
    <div class="col-md-6" style="border-right: 1px solid #cb8736;">
       <div class="other-link">
        <h3 class="text-center text-decoration-underline " style="text-decoration-color: #e37636;" >Other Institution Link</h3>
             <div class="list">
                <ul >
                    <div class="row">
                        
                   
                    <div class="col-md-6">
                        <li> <a href="https://orissajudicialacademy.nic.in/" target="_blank">Orissa Judicial Academy</a> </li>
                    <li> <a href="https://sirdodisha.nic.in/" target="_blank">SIRD & PR</a> </li>
                    <li> <a href="https://gopabandhuacademy.gov.in/sites/all/themes/gaoa/" target="_blank">Gopabandhu Academy of Administration</a> </li>
                    </div>
                    <div class="col-md-6">
                         <li> <a href="https://rotiodisha.nic.in/Index.aspx" target="_blank">Revenue Officers' Training Institutes(ROTI)</a> </li>
                    <li> <a href="http://bpspaorissa.gov.in//" target="_blank">Biju Patnaik State Police Academy</a> </li>
                     <li> <a href="gst_law/login.php" target="_blank">Judgement Under GST Act </a> </li>
                    </div>
                     </div>
                   
                    
                   
                </ul>
             </div>
       </div>
    </div>
    <div class="col-md-6">
     <div class="other-link">
        <h3 class="text-center text-decoration-underline"> Important Link</h3>
        <div class="list">
                <ul>
                     <div class="row">
                        
                   
                    <div class="col-md-6">
                        <li> <a href="https://finance.odisha.gov.in/" target="_blank" >Finance Department Odisha</a> </li>
                    <li> <a href="https://odisha.gov.in/" target="_blank">Odisha Government Portal</a> </li>
                    <li> <a href="https://hrmsorissa.gov.in/" target="_blank">HRMS</a> </li>
                </div>
                     <div class="col-md-6">
                          <li> <a href="https://edodisha.gov.in/" target="_blank">e Despatch</a> </li>
                    <li> <a href="https://gem.gov.in/" target="_blank">Government e Marketplace</a> </li>
                     </div>
                    
                   
                    
                   </div>
                </ul>
             </div>

    </div>
    
    </div>
    </div>
</div> 

<!-- link section end -->

<?php include('footer.php') ?>


<script type="text/javascript">
    const swiper = new Swiper('.swiper', {
    // Optional parameters
    //direction: 'vertical',
   // cssMode: true,
//    slidesPerView: 1,
//       spaceBetween: 30,
//     loop: true,
    speed: 400,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    on:{
        slideChangeTransitionStart: function () {
          // Slide captions
          var swiper = this;
          var slideTitle = $(swiper.slides[swiper.activeIndex]).attr("data-title");
         
          $(".slide-captions").html(function() {
            return "<h4 class='current-title'>" + slideTitle +"</h4>" ;
          });
      }
    },

    // And if we need scrollbar
    // scrollbar: {
    //     el: '.swiper-scrollbar',
    // },
    });

//     var activeSlide = document.querySelector('div.swiper-slide-active');
// var caption = activeSlide.dataset.caption;

// var updateCaptions = function () {
//     if (activeSlide.hasAttribute('data-title')) {
//         captions.innerHTML = caption
//     };
// }

    
    
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
<!-- <script>
function tick() {
    console.log(123);
    $('#news li:first').slideUp(function() {
        $(this).appendTo($('#news')).slideDown();
    });
    $('#news hr:first').slideUp(function() {
        $(this).appendTo($('#news')).slideDown();
    });

    $('#notify li:first').slideUp(function() {
        $(this).appendTo($('#notify')).slideDown();
    });
    $('#notify hr:first').slideUp(function() {
        $(this).appendTo($('#notify')).slideDown();
    });
}

// jquery ready start
$(document).ready(function() {
    // jQuery code
    setInterval(function() {
        tick()
    }, 3000);

    //////////////////////// Prevent closing from click inside dropdown
    $(document).on('click', '.dropdown-menu', function(e) {
        e.stopPropagation();
    });

    // make it as accordion for smaller screens
    if ($(window).width() < 992) {
        $('.dropdown-menu a').click(function(e) {
            e.preventDefault();
            if ($(this).next('.submenu').length) {
                $(this).next('.submenu').toggle();
            }
            $('.dropdown').on('hide.bs.dropdown', function() {
                $(this).find('.submenu').hide();
            })
        });
    }

}); // jquery end
</script> -->
