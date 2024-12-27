
<?php 

 include ('admin/database.php');
 $conn = new Database();

?>

<section class="header-nav mt-1" style="display: block;">

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1e4f87;">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav" style="justify-content: center;">

            <ul class="navbar-nav" style="align-items: center;" >
                <!-- <li class="nav-item "> <a class="nav-link" href="index.php">Home </a> </li> -->
                <li class="nav-item"> <a class="nav-link" href="index.php" style="color:#fff"><i class="fa fa-home" aria-hidden="true"></i> Home </a> </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" data-toggle="dropdown" style="color:#fff">The
                        Academy </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="about.php"> About Us </a></li>
                        <li><a class="dropdown-item" href="vision.php"> Vision </a></li>
                        <li><a class="dropdown-item" href="mission.php"> Mission </a></li>
                        <li><a class="dropdown-item" href="organogram.php"> Organogram </a></li>
                        <li><a class="dropdown-item" href="#"> Infrastructure &raquo </a>
                            <ul class="submenu dropdown-menu">
                                <li><a class="dropdown-item" href="adminBuilding.php">Administrative Office</a></li>
                                <li><a class="dropdown-item" href="conferenceHall.php">Training Halls/Conference Halls</a></li>
                                <li><a class="dropdown-item" href="computerLab.php">Computer Laboratory </a></li>
                                <li><a class="dropdown-item" href="library.php">Library</a></li>
                                <li><a class="dropdown-item" href="hostel.php">Hostel</a></li>
                                <li><a class="dropdown-item" href="guesthouse.php">Guest House</a></li>
                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="directors.php">Director's Desk</a></li>
                        <li><a class="dropdown-item" href="directorslist.php">About The Director</a></li>
                       
                        
                        
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" style="color:#fff"> Programmes
                    </a>
                    <ul class="dropdown-menu">

                        <li><a class="dropdown-item " href="#"> Long Term Program (Newly Recruited) &raquo </a>
                            <ul class="submenu dropdown-menu">

                                <li><a class="dropdown-item" href="newly_recruited_ofs.php">Newly Recruited Odisha Finance Service Officers &raquo</a>
                                    <ul class="submenu dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" onclick="datapost('trainee_list.php',{id: 1})">OFS 2019 Batch</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" onclick="datapost('trainee_list.php',{id: 10})">OFS 2020 Batch</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" onclick="datapost('trainee_list.php',{id: 13})">OFS 2021 Batch</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item" href="newly_recruited_ot&as.php">Newly Recruited Odisha Taxation & Account Service  Officers &raquo </a>
                                       
                                    <ul class="submenu dropdown-menu">
                                        
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="datapost('trainee_list.php',{id: 11})">OT&AS 2020 Batch</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="datapost('trainee_list.php',{id: 14})">OT&AS 2021 Batch</a>
                                        </li>
                                    </ul>
                                    </li>
                                <!-- <li><a class="dropdown-item" href="">Newly Recruited India Administrative Services
                                        Probationers</a></li>
                                <li><a class="dropdown-item" href="">Newly Recruited Odisha Administrative Services</a>
                                </li>
                                <li><a class="dropdown-item" href="">Newly Recruited Judicial Officers.</a></li>
                                <li><a class="dropdown-item" href="">Newly Recruited Medical officers Of Health & Family
                                        Welfare Department</a></li>
                                <li><a class="dropdown-item" href="">Training on Finance Management for Assistant
                                        Fisheries Officer</a></li> -->

                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="#"> Long Term Program (In Service) &raquo </a>
                           <ul class="submenu dropdown-menu">

                                <li><a class="dropdown-item" href="promoted_ofs.php">Promoted Odisha Finance Service Officers &raquo </a>
                                    <ul class="submenu dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="datapost('trainee_list.php',{id: 2})">2018 Batch</a>
                                        </li>
                                        
                                    </ul>
                                </li>
                                <li><a class="dropdown-item" href="promoted_ot&as.php">Promoted Odisha Taxation & Account Service
                                        Officers</a></li>
                               

                           </ul>
                        </li>
                        <li><a class="dropdown-item" href="#">Medium Term Program &raquo </a>
                            <ul class="submenu dropdown-menu">
                                <li><a class="dropdown-item" href="ministerial_program.php">Career Promotion Training programme for Ministerial Employees &raquo</a>
                                        
                                    <ul class="submenu dropdown-menu">
                                        <?php
                                                $conn->select('tbl_mid_program_master',"id,prg_name",null,'syllabus_id=5',null,null);
                                               $res = $conn->getResult();
                                                foreach($res as $row2){
                                                    $id=$row2['id'];
                                        ?>
                                         <li>
                                            <a class="dropdown-item" href="#" onclick="datapost('mid_trainee_list.php',{id: <?php echo $id;?>})"><?php echo $row2['prg_name'] ?></a>
                                        </li>
                                        <?php
                                                }

                                         ?> 
                                        
                                       
                                       
                                    </ul>
                                    </li>
                                <li><a class="dropdown-item" href="">Accounts Training Programme for Audit Personnel under Common Cadre Auditors (CCA) &raquo</a>
                                        <ul class="submenu dropdown-menu">
                                            <?php
                                                    $conn->select('tbl_mid_program_master',"id,prg_name",null,'syllabus_id=4',null,null);
                                                   $res = $conn->getResult();
                                                    foreach($res as $row2){
                                                        $id=$row2['id'];
                                            ?>
                                             <li>
                                                <a class="dropdown-item" href="#" onclick="datapost('mid_trainee_list.php',{id: <?php echo $id;?>})"><?php echo $row2['prg_name'] ?></a>
                                            </li>
                                            <?php
                                                    }

                                             ?> 
                                            
                                           
                                           
                                        </ul>
                                </li>
                                <li><a class="dropdown-item" href="">Induction Training Programme of Local Fund Auditors &raquo</a>
                                        <ul class="submenu dropdown-menu">
                                            <?php
                                                    $conn->select('tbl_mid_program_master',"id,prg_name",null,'syllabus_id=6',null,null);
                                                   $res = $conn->getResult();
                                                    foreach($res as $row2){
                                                        $id=$row2['id'];
                                            ?>
                                             <li>
                                                <a class="dropdown-item" href="#" onclick="datapost('mid_trainee_list.php',{id: <?php echo $id;?>})"><?php echo $row2['prg_name'] ?></a>
                                            </li>
                                            <?php
                                                    }

                                             ?> 
                                        </ul>
                                </li>

                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="#"> Short Term Program &raquo</a>
                            <ul class="submenu dropdown-menu" style="height: 40vh;overflow-y: scroll;">
                                <?php
                                                    $conn->select('tbl_short_program_master',"id,prg_name",null,'trng_type=4 OR trng_type =5',null,null);
                                                   $res = $conn->getResult();
                                                    foreach($res as $row2){
                                                        $id=$row2['id'];
                                            ?>
                                             <li>
                                                <a class="dropdown-item" href="#" onclick="datapost('short_trainee_list.php',{id: <?php echo $id;?>})"><?php echo $row2['prg_name'] ?></a>
                                            </li>
                                            <?php
                                                    }

                                             ?> 
                            </ul>
                        </li>

                        <li><a class="dropdown-item" href="#">Others Programs &raquo</a>
                            <ul class="submenu dropdown-menu">
                                <li><a class="dropdown-item" href="">Income Tax Act & Rules</a></li>
                                <li><a class="dropdown-item" href="">Functions of RBI and Functional Interface with
                                        State Governments</a></li>
                                <li><a class="dropdown-item" href="">Digital Transaction at Government Setup : Concept &
                                        Process</a></li>
                                <li><a class="dropdown-item" href="">Gender Inequality in Employment in India</a></li>
                                <li><a class="dropdown-item" href="">Financial Inclusion in India: Issues &
                                        Challenges</a></li>
                                <li><a class="dropdown-item" href="">Government e Marketplace</a></li>
                                <li><a class="dropdown-item" href="">Goods and Services Tax</a></li>
                                <li><a class="dropdown-item" href="">Gender Responsive Budgeting -Issues &
                                        Challenges</a></li>
                                <li><a class="dropdown-item" href="">Importance of Yoga in Modern Life</a></li>
                            </ul>
                        </li>

                        <!-- <li><a class="dropdown-item" href="#"> Odisha Darshan &raquo</a>
                            <ul class="submenu dropdown-menu">
                                <li><a class="dropdown-item" href="">Visit to His Excellency Governor's House</a></li>
                                <li><a class="dropdown-item" href="">Visit to the Odisha Legislative Assembly</a></li>
                                <li><a class="dropdown-item" href="">Visit to Accountant General (Odisha) Office</a>
                                </li>
                                <li><a class="dropdown-item" href="">Visit to Industrial Houses</a></li>
                                <li><a class="dropdown-item" href="">Site Visits</a></li>
                            </ul>
                        </li> -->
                        <!-- <li><a class="dropdown-item" href="#"> Outside State Exposure Training &raquo</a>
                            <ul class="submenu dropdown-menu">
                                <li><a class="dropdown-item" href="">MDP Training at NIFM,Faridabad</a></li>
                            </ul>
                        </li> -->
                        <!-- <li><a class="dropdown-item" href="#"> International Training Programmes attended on Virtual
                                Mode &raquo</a>
                            <ul class="submenu dropdown-menu">
                                <li><a class="dropdown-item" href="">OFS Probationers & Officers</a></li>
                                <li><a class="dropdown-item" href="">OT&AS Probationers & Officers</a></li>
                            </ul>
                        </li>

                        <li><a class="dropdown-item" href="#"> Our Journey So Far </a></li> -->

                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" style="color:#fff"> Faculty &
                        Staff </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="inhouse.php"> Inhouse Faculty </a></li>
                        <li><a class="dropdown-item" href="visiting_faculty.php"> Visiting Faculty </a></li>

                        <li><a class="dropdown-item" href="#"> Staff &raquo </a>
                            <ul class="submenu dropdown-menu">
                                <li><a class="dropdown-item" href="regular_staff.php">Regular Employees</a></li>
                                <li><a class="dropdown-item" href="outsourced-staff.php">Outsourced Employees</a></li>

                            </ul>
                        </li>

                    </ul>
                </li>
                <li class="nav-item"> <a class="nav-link" href="tranningCalendar.php" style="color:#fff">Training
                        Calender </a> </li>
                <!-- <li class="nav-item"> <a class="nav-link" href="#" style="color:#fff">Syllabus </a> </li> -->


                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" style="color:#fff"> Publications
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"> Annual Reports </a></li>
                        <li><a class="dropdown-item" href="#"> Journal </a></li>
                    </ul>
                </li> -->
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" style="color:#fff"> Academic
                        Council </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"> Examination Committee </a></li>
                        <li><a class="dropdown-item" href="#"> Pay Fixation Officers </a></li>
                        <li><a class="dropdown-item" href="#"> Committee On MACP </a></li>
                        <li><a class="dropdown-item" href="#"> Committee On Appointment under RA Scheme </a></li>
                        <li><a class="dropdown-item" href="#"> Local Purchase Committee </a></li>
                        <li><a class="dropdown-item" href="#"> Gem Procurement Team </a></li>
                        <li><a class="dropdown-item" href="#"> Disposal Committee </a></li>
                        <li><a class="dropdown-item" href="#"> RTI Officers </a></li>


                    </ul>
                </li> -->
                <!-- <li class="nav-item"> <a class="nav-link" href="#" style="color:#fff">Library </a> </li> -->
                 <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" style="color:#fff"> Library
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="library_login.php">Online Process</a></li>
                        <li><a class="dropdown-item" href="library.php"> About Library </a></li>
                    </ul>
                </li>
                <li class="nav-item"> <a class="nav-link" href="tender.php" style="color:#fff">Tender </a> </li>
                <li class="nav-item"> <a class="nav-link" href="partnership.php" style="color:#fff">Partnership</a></li>
              <!--   <li class="nav-item"> <a class="nav-link" href="circular_management.php" style="color:#fff">Circular Archive </a> </li>
                <li class="nav-item"> <a class="nav-link" href="gst_law/login.php" style="color:#fff">Judgement Under GST Act </a> </li> -->
               
                 <li class="nav-item" style="display: flex;align-items: center; "> <i class="fa fa-desktop" aria-hidden="true" style="color: sandybrown;"></i><a class="nav-link" href="online_exam/" style="color:#fff">Online Exam</a></li>

                <li class="nav-item" style="display: flex;align-items: center;"> <i class="fa fa-unlock-alt" aria-hidden="true" style="color: sandybrown;"></i><a class="nav-link" href="login.php" style="color:#fff">ITMS</a></li>
                 <li class="nav-item" style="" > <a class="nav-link" href="contact_us.php" style="color:#fff">Contact Us</a> </li>


            </ul>

        </div> <!-- navbar-collapse.// -->

    </nav>
</section>