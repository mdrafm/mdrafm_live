                <?php

                include('database.php');

				$object = new database();

				if(!$object->is_login())
				{
				    header("location:".$object->base_url."");
				}

                // if(!$object->is_master_user())
                // {
                //     header("location:".$object->base_url."admin/result.php");
                // }

                include('header.php');

                ?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

                    <!-- Content Row -->
                    <div class="row row-cols-5" style="display: <?php echo ($_SESSION['user_type'] == 'Examinee')?'none':'' ?>;">
                        <!-- Earnings (Monthly) Card Example -->
                        <!-- <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Today Result Publish</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php //echo $object->Get_total_result(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Exam</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->Get_total_exam(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                       <!--  <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Student
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    <?php
                                                            $students =   json_decode($object->Get_total_student()); 
                                                            $total_student = 0;
                                                            foreach($students as $student){
                                                                $total_student += $student->no_trainee;
                                                            }
                                                           echo $total_student; 
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                           <a href="#" data-toggle="modal" data-target="#totalResultModal" >
                                           <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                           </a> 
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
 -->
                        <!-- Pending Requests Card Example -->
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Question</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php 
                                               
                                               
                                                $questions =   json_decode($object->Get_total_Question()); 
                                                $total_question = 0;
                                                foreach($questions as $question){
                                                    $total_question += $question->question;
                                                }
                                               echo $total_question; 
                                       
                                                
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <a href="#" data-toggle="modal" data-target="#totalQuestionModal" >
                                           <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Classes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php //echo $object->Get_total_classes();?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  -->
                    </div>
                     <div class="col-md-2">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                <a href="examiner_exam_shedule_list.php">Start Exam</a>
                                                </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div id="totalQuestionModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="publish_result_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Total Question</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                        <table>
                            <thead style="color: green;background: #ebe3e3;">
                                <tr style="font-size: 15px;border-bottom: 2px solid #b8aeae;">
                                    <td>Syllabus Name</td>
                                    <td>No Of Questions</td>
                                </tr>
                            </thead>
                                <?php
                                    $questions =   json_decode($object->Get_total_Question()); 
                                    foreach($questions as $question){
                                    
                                        ?>
                                    
                                        <tr style="font-size: 15px;border-bottom: 2px solid #b8aeae;">
                                            <td><?php echo $question->descr ?></td>
                                        
                                            <td style="text-align: center;"><?php echo $question->question ?></td>
                                        </tr>
                                        
                                        
                                        <?php
                                    }
                                ?>
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="totalResultModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="publish_result_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Total Student</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                        <table>
                            <thead style="color: green;background: #ebe3e3;">
                                <tr style="font-size: 15px;border-bottom: 2px solid #b8aeae;">
                                    <td>Programme Name</td>
                                    <td>No Of Trainee</td>
                                </tr>
                            </thead>
                                <?php
                                    $students =   json_decode($object->Get_total_student()); 
                                    foreach($students as $student){
                                    
                                        ?>
                                    
                                        <tr style="font-size: 15px;border-bottom: 2px solid #b8aeae;">
                                            <td><?php echo $student->prg_name ?></td>
                                        
                                            <td style="text-align: center;"><?php echo $student->no_trainee ?></td>
                                        </tr>
                                        
                                        
                                        <?php
                                    }
                                ?>
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
                <?php
                include('footer.php');
                ?>