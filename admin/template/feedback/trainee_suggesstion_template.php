<div class="row" style="margin-top:50px">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>

                            </div>
                            <div class="card-body">
                                <div id="program_list">
                                 <input type="button" class="btn btn-success" value="Print" style="float: right" onclick="suggetion_pdf('<?php echo $res[0]['prg_name'] ?>',<?php echo $program_id ?>,<?php echo $traning_type ?>)">
                                                    
                                  <?php
                                   if($feedback_user_cnt != 0){

                                    $sql = "SELECT u.name,s.suggestion,s.id FROM tbl_mid_cls_suggestation s
                                                JOIN `tbl_user` u ON s.user_id=u.id
                                                WHERE s.program_id = $program_id AND s.trng_type = $traning_type
                                                GROUP BY s.id";

                                   $db->select_sql($sql);
                                    $res = $db->getResult(); 

                                    ?>
                                 <table class="table table-striped table-sm" style="width:90%;margin:0px auto;">
                                        <thead style="font-size: 10px;background-color: rgb(10 101 111);color: #fff;">

                                            <tr>
                                                <th scope="col">Sl.No</th>
                                                <th scope="col"> Name</th>
                                                <!-- <th scope="col"> </th> -->
                                                <th scope="col">Suggestions</th>
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
                                                    <td><?php echo $res_feedback['name'] ?></td> 
                                                    <td><?php echo $res_feedback['suggestion'] ?></td>
                                                   
                                                </tr>


                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                  <?php 
                                      }else{
                                        echo "Suggestion Not Found";
                                      }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>