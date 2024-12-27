
<?php 
 session_start();

 
if (isset($_SESSION))
{
      session_destroy();
      unset($_SESSION);
}

include('header.php'); 
include('nav_bar.php') ;

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
<section class="info">

    <div  class="build_img">
        <img src="images/building1.jpg" style="width: 400px;height: 275px;" />
    </div>
    <div class="info-dtls" style="height: 275px;;overflow: hidden; padding:5px;background-color:aliceblue;box-shadow:rgba(149,157,165,0.2) 0px 8px 24px;">

       
        <div class="program">
            <div class="program-wrap">
                <h3>Ongoing Training Programmes</h3>
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


                        </ul>
                   

                </div>
                <!-- <div style="float: right;margin-top: -8px">
                    <a href="onGoingProgram.php"> View More </a>
                </div> -->
            </div>
        </div>
       
        <br>
    </div>
    <div class="woners" style="width: 400px;background-image: url('images/istock.jpg')">
            <!-- <img src="images/bg-2.jpg" style="width: 400px;float: right;" /> -->

            <div class="header-buttom ">
                    <div class="pt-1" style="margin-bottom: 10px;">
                        <div class="Profile prof2" style="width:300px;">
                            <img class="photo" src="images/bk.jpg" width="70" height="83"
                                style="display:block; float:left; margin-right:8px; border:solid 1px #CCC;">
                            <div class="desig pt-4" ><strong>Shri Bikram Keshari Arukha</strong><br><p style="color:#010101;font-size: 12px;"> Hon'ble Cabinet Minister, Finance</p></div>
                        </div>
                    </div>
                    <div class="pb-2" >
                        <div class="Profile prof3" style="width:300px;">
                            <img class="photo" src="images/pri_sec.png" width="70" height="83"
                                style="display:block; float:left; margin-right:8px; border:solid 1px #CCC;">
                            <div class="desig pt-4"><strong>Shri Vishal Kumar Dev, IAS</strong><br> <p style="color:#010101;font-size: 12px;">Principal Secretary, Finance</p></div>
                        </div>
                    </div>
                    <div class="img3" style="margin-bottom: 15px;">
                        <div class="Profile prof" style="width:300px;">
                            <img class="photo" src="images/director.png" width="70" height="83"
                                style="display:block; float:left; margin-right:8px; border:solid 1px #CCC;">
                            <div class="desig pt-4"><strong>Shri Ashok kumar Mohanty</strong><br><p style="color:#010101;font-size: 12px;">Director,MDRAFM</p></div>
                        </div>
                    </div>
                </div>
    </div>
</section>
<!-- info section end -->
<!-- news section start -->
<!-- <div class=" " style="margin-top:-10px ;background-image:url(images/bg-1-1.jpg);height: 365px;" > -->
<section class="" style="display: block;">
    <div class="notice ">
        <div class=" information">
            <div class="new info-box holder" style="background-color:aliceblue;">
                <h3 class="content-header">MDRAFM News</h3>
                <div class="content ">
                    <div class="view-content" style="">
                       
                            <ul style="list-style-type: circle;padding: 20px;" id="news2">
                            <?php 
                                  
                                  $conn->select('tbl_news',"*",null,null,null,null);
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
                                                <a style="color: #0d3746;text-decoration: none;font-weight: 300;font-size: 15px;" href="news.php">
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
                        <a href="news.php"> View More </a>
                    </div> -->
                </div>
            </div>

            
            
            <div class="events info-box holder" style="background-color:aliceblue;">
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

            <div class="events info-box holder" style="background-color:#dcdcdc;">
                <h3 class="content-header">Modules</h3>
                <div class="content">
                    <div class="view-content" style="">
                   
                       <div class="modules" style="background: #1f5c91;margin: 5px;border-radius: 5px;">
                        <a href="login.php" class="d-flex justify-content-start ml-2" style="text-decoration: none;">
                            <div style="font-size: 2rem; margin-left:1rem;" >
                                <img src="images/modules/web.png" width="75" height="" alt="">
                            </div>
                            <div style="border-left: 2px solid red;height:45px;margin: 1rem;" ></div>
                            <div style="font-size: 1.3rem;margin-top: 1rem;"> <span style="font-family: serif;color: #fff;">ITMS</span> </div>
                            
                            </a> 
                       
                       </div> 
                       <div class="modules" style="background: #b038b8;margin: 5px;border-radius: 5px;">
                         <a href="library_login.php" class="d-flex justify-content-start ml-2" style="text-decoration: none;">
                            <div style="font-size: 2rem; margin-left:1rem;" >
                                <img src="images/modules/school.png" width="75" height="" alt="">
                            </div>
                            <div style="border-left: 2px solid red;height:45px;margin: 1rem;" ></div>
                            <div style="font-size: 1.3rem;margin-top: 1rem;"> <span style="font-family: serif;color: #fff;">LIBRARY</span> </div>
                            
                            </a> 
                       
                       </div> 

                       <div class="modules" style="background: #1f9186;margin: 5px;border-radius: 5px;">
                        <a href="online_exam/" class="d-flex justify-content-start ml-2" style="text-decoration: none;">
                            <div style="font-size: 2rem; margin-left:1rem;" >
                                <img src="images/modules/online_exam4.png" width="75" height="" alt="">
                            </div>
                            <div style="border-left: 2px solid red;height:45px;margin: 1rem;" ></div>
                            <div style="font-size: 1.3rem;margin-top: 1rem;"> <span style="font-family: serif;color: #fff;">ONLINE EXAM</span> </div>
                            
                            </a> 
                       
                       </div> 
                       

                       <div class="modules" style="background: #a36612;margin: 5px;border-radius: 5px;">
                         <a href="gst_law/login.php" class="d-flex justify-content-start ml-2" style="text-decoration: none;">
                            <div style="font-size: 2rem; margin-left:1rem;" >
                                <img src="images/modules/judgment.png" width="75" height="" alt="">
                            </div>
                            <div style="border-left: 2px solid red;height:45px;margin: 1rem;" ></div>
                            <div style="font-size: 1.2rem;margin-top: 1rem;"> <span style="font-family: serif;color: #fff;">JUDGMENT UNDER GST ACT</span> </div>
                            
                            </a> 
                       
                       </div> 
                      
                       
                       
                    </div>

                    <!-- <div class="footer-content">
                        <a href="events.php"> View More </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    
    
    <section style="display:block;" >
        <div class="notice ">
             <div class=" information">
        <div class="new info-box holder" style="background-color:aliceblue;">
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

            <div class="notification info-box holder" style="background-color:aliceblue;">
                <h3 class="content-header">Upcoming Programmes</h3>
                <div class="content ">
                    <div class="view-content" style="">
                       
                            <ul style="list-style-type: circle;padding: 20px;" id="news2">
                            <?php 
                                  
                                  $conn->select('tbl_upcoming_program',"*",null,null,null,null);
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
                                                <a style="color: #0d3746;text-decoration: none;font-weight: 300;font-size: 15px;" href="news.php">
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
                        <a href="news.php"> View More </a>
                    </div> -->
                </div>
            </div>

            <div class="notification info-box holder" style="background-color:aliceblue;">
                <h3 class="content-header">Image Gallery</h3>
                <div class="content">
                    <div class="view-content" style="height: 235px;overflow-y:hidden;">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                 <img src="images/galary/mdrafm-3A80-B867-101449.jpeg"  width="400" alt="...">
                            </div>
                       
                        <?php
                        //$conn->select('tbl_image_gallery',"*",null,'status=1',null,null);
                        $conn->select_sql('SELECT * FROM `tbl_image_gallery` WHERE status = 1 ORDER BY id DESC');
                        
                             // print_r($db->getResult());
                               foreach($conn->getResult() as $row){

                                   ?>
                                   <div class="carousel-item  ">
                                       <a href="photogallery.php"><img src="images/galary/<?=isset($row['image'])?$row['image']:'';?>" width="400" alt="..."></a> 
                                    </div>
                                     <!-- <div class="carousel-caption "><?php echo ($row['img_title'])?></div> -->
                        <?php
                               }
                            ?>
                           
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

                    <!-- <div class="footer-content">
                        <a href="notification.php"> View More </a>
                    </div> -->
                </div>
            </div>
        </div>
        </div>
    </section>
</section>
<section style="display: none;">
    <div class="container-fluid text-center my-3">
        <div class="row mx-auto my-auto justify-content-center">
            <div id="recipeCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-img">
                                    <img src="images/galary/image1.jpg"  class="d-block w-100">
                                </div>
                                <div class="card-img-overlay">Slide 1</div>
                            </div>
                        </div>
                    </div>
                    <?php
                     $conn->select('tbl_image_gallery',"*",null,'status=1',null,null);
                             // print_r($db->getResult());
                               foreach($conn->getResult() as $row){
                                

                                ?>
                                  
                                    <div class="carousel-item">
                                        <div class="col-md-3 ">
                                            <div class="card m-1 rounded">
                                                <div class="card-img">
                                        <img src="images/galary/<?=isset($row['image'])?$row['image']:'';?>"  class="d-block w-100">
                                                </div>
                                                <div class="card-img-overlay"><?=isset($row['img_title'])?$row['img_title']:'';?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                   
                </div>
                <a class="carousel-control-prev bg-transparent w-aut" href="#recipeCarousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </a>
                <a class="carousel-control-next bg-transparent w-aut" href="#recipeCarousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
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
    <div class="col-md-4">
        <img src="images/lg1.png" style="width: 55%;">
    </div>
    <div class="col-md-4">
       <div class="other-link">
        <h3>Other Institution Link</h3>
             <div class="list">
                <ul>
                    <li> <a href="https://orissajudicialacademy.nic.in/" target="_blank">Orissa Judicial Academy</a> </li>
                    <li> <a href="https://sirdodisha.nic.in/" target="_blank">SIRD & PR</a> </li>
                    <li> <a href="https://gopabandhuacademy.gov.in/sites/all/themes/gaoa/" target="_blank">Gopabandhu Academy of Administration</a> </li>
                    <li> <a href="https://rotiodisha.nic.in/Index.aspx" target="_blank">Revenue Officers' Training Institutes(ROTI)</a> </li>
                    <li> <a href="http://bpspaorissa.gov.in//" target="_blank">Biju Patnaik State Police Academy</a> </li>
                    
                   
                </ul>
             </div>
       </div>
    </div>
    <div class="col-md-4">
     <div class="other-link">
        <h3> Important Link</h3>
        <div class="list">
                <ul>
                    <li> <a href="https://finance.odisha.gov.in/" target="_blank" >Finance Department Odisha</a> </li>
                    <li> <a href="https://odisha.gov.in/" target="_blank">Odisha Government Portal</a> </li>
                    <li> <a href="https://hrmsorissa.gov.in/" target="_blank">HRMS</a> </li>
                    <li> <a href="https://edodisha.gov.in/" target="_blank">e Despatch</a> </li>
                    <li> <a href="https://gem.gov.in/" target="_blank">Government e Marketplace</a> </li>
                    
                   
                </ul>
             </div>

    </div>
    
    </div>
    </div>
</div> 

<!-- link section end -->


<?php include('footer.php') ?>


<script type="text/javascript">

    // let items = document.querySelectorAll('.carousel .carousel-item')

    // items.forEach((el) => {
    //     const minPerSlide = 4
    //     let next = el.nextElementSibling
    //     for (var i = 1; i < minPerSlide; i++) {
    //         if (!next) {
    //             // wrap carousel by using first child
    //             next = items[0]
    //         }
    //         let cloneChild = next.cloneNode(true)
    //         el.appendChild(cloneChild.children[0])
    //         next = next.nextElementSibling
    //     }
    // })

    
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
