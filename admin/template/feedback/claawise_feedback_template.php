<div class="row" style="margin-top:50px">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>

                            </div>
                            <div class="card-body">
                                <div id="program_list">
                                 <input type="button" class="btn btn-success" value="Print" style="float: right" onclick="generate_pdf()">
                                                    
                                  <?php
                                   if($feedback_user_cnt != 0){

                                    if ($traning_type == 4) {
                                        $sql = "SELECT tbl_in_tm.id,tbl_in_tm.faculty_id,tbl_in_tm.subject_id,tbl_in_tm.paper_covered as subject,    tbl_fclt.name FROM tbl_inhouse_time_table tbl_in_tm 
                                                join tbl_faculty_master tbl_fclt on tbl_fclt.id=tbl_in_tm.faculty_id 
                                                WHERE tbl_in_tm.program_id =$program_id  AND tbl_in_tm.trng_type=$traning_type
                                                GROUP BY tbl_in_tm.faculty_id, tbl_in_tm.subject_id";
                                    }else if($traning_type == 5){

                                       $sql= "SELECT id, paper_covered as subject FROM `tbl_sponsored_time_table` WHERE `period_type` = 1 AND `program_id` =".$program_id;
                                    }
                                     else {
                                        $sql = "SELECT tbl_in_tm.id,tbl_in_tm.faculty_id,tbl_in_tm.subject_id,tbl_fclt.name,tbl_mid_syllabus.subject FROM tbl_inhouse_time_table tbl_in_tm join 
                                            tbl_faculty_master tbl_fclt on tbl_fclt.id=tbl_in_tm.faculty_id join tbl_mid_syllabus on tbl_mid_syllabus.id=tbl_in_tm.subject_id
                                            WHERE tbl_in_tm.program_id = $program_id AND tbl_in_tm.trng_type = $traning_type
                                            GROUP BY tbl_in_tm.faculty_id, tbl_in_tm.subject_id";
                                    }

                                   $db->select_sql($sql);
                                    $res = $db->getResult(); 

                                    ?>
                                 <table class="table table-striped table-sm" style="width:90%;margin:0px auto;">
                                        <thead style="font-size: 10px;background-color: rgb(10 101 111);color: #fff;">

                                            <tr>
                                                <th scope="col">Sl.No</th>
                                                <th scope="col"> Subject & Faculty Name</th>
                                                <!-- <th scope="col"> </th> -->
                                                <th scope="col">Feedback</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            foreach ($res as $res_feedback) {
                                                 //print_r( $feedback);exit;
                                                $count++;
                                                $faculty_id = $res_feedback['faculty_id'];
                                                $subject_id = $res_feedback['subject_id'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $count ?></td>
                                                   <!--  <td><?php echo $res_feedback['name'] ?></td> -->
                                                    <td><?php echo $res_feedback['subject'] ?></td>
                                                    <td style="width: 30%;">
                                                        <?php
                                                        
                                                        $cnt1 = 0;
                                                        $cnt2 = 0;
                                                        $cnt3 = 0;
                                                        $cnt4 = 0;
                                                        $cnt5 = 0;
                                                       
                                                            $ins_cls_id = $row_cls['id'];
                                                            $sql_fdbk = "SELECT feedback FROM tbl_mid_cls_feedback where time_tbl_id =". $res_feedback['id'];
                                                            $db->select_sql($sql_fdbk);
                                                            $res_fdbk = $db->getResult();
                                                            foreach ($res_fdbk as $fdk) {
                                                                if ($fdk['feedback'] == 1) {
                                                                    $cnt1 =  $cnt1 + 1;
                                                                } else if ($fdk['feedback'] == 2) {
                                                                    $cnt2 =  $cnt2 + 1;
                                                                } else if ($fdk['feedback'] == 3) {
                                                                    $cnt3 =  $cnt3 + 1;
                                                                } else if ($fdk['feedback'] == 4) {
                                                                    $cnt4 =  $cnt4 + 1;
                                                                } else if ($fdk['feedback'] == 5) {
                                                                    $cnt5 =  $cnt5 + 1;
                                                                }
                                                            }
                                                        
                                                        $tot_cnt = $cnt1 + $cnt2 + $cnt3 + $cnt4 + $cnt5;
                                                        $febck1 = ($cnt1 / $tot_cnt) * 100;
                                                        $febck2 = ($cnt2 / $tot_cnt) * 100;
                                                        $febck3 = ($cnt3 / $tot_cnt) * 100;
                                                        $febck4 = ($cnt4 / $tot_cnt) * 100;
                                                        $febck5 = ($cnt5 / $tot_cnt) * 100;
                                                        ?>
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    Excellent
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <?php echo number_format($febck5, 2, '.', ''); ?>%
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class=" col-lg-8">
                                                                    Very Good
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <?php echo number_format($febck4, 2, '.', ''); ?>%
                                                                </div>
                                                            </div>
                                                             <hr>
                                                            <div class="row">
                                                                <div class="col-lg-8">
                                                                    Good
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <?php echo number_format($febck3, 2, '.', ''); ?>%
                                                                </div>
                                                            </div>
                                                             <hr>
                                                            <div class="row">
                                                                <div class="col-lg-8">
                                                                    Average
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <?php echo number_format($febck2, 2, '.', ''); ?>%
                                                                </div>
                                                            </div>
                                                             <hr>
                                                            <div class="row">
                                                                <div class="col-lg-8">
                                                                    Needs Improvement
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <?php echo number_format($febck1, 2, '.', ''); ?>%
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </td>
                                                </tr>


                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                  <?php 
                                      }else{
                                        echo "Feedback Not Found";
                                      }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>