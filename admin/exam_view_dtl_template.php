<div class="modal fade" id="exam_detailt_<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="termModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content" style="width:160%; margin:20px -100px">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="termModalLabel">
                                                                            Exam
                                                                            Detail</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="detail_frm">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <p> Exam Name :
                                                                                        <?php echo $row['exam_title']; ?>
                                                                                    </p></br>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <p> Exam Date And Time:
                                                                                        <?php echo date("d-m-Y h:i", strtotime($row['exam_date_time'])); ?>
                                                                                    </p></br>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <p>First Examiner :
                                                                                        <?php echo $db->getFacultyName($row['examiner_id']); ?>
                                                                                    </p></br>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <p>Second Examiner :
                                                                                        <?php echo $db->getFacultyName($row['asst_examiner_id']); ?>
                                                                                    </p></br>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <p>Program Name :
                                                                                        <?php echo $row['program_name']; ?>
                                                                                    </p></br>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <p>Term :
                                                                                        <?php echo $row['term']; ?>
                                                                                    </p></br>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <p>Paper :
                                                                                        <?php echo $row['paper_code']; ?>
                                                                                    </p></br>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <p>Duration :
                                                                                        <?php echo $row['exam_duration'] . ' Minuets'; ?>
                                                                                    </p></br>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <p>Status :
                                                                                        <?php echo $staus_btn ?>
                                                                                    </p></br>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <p>Reasion For Exam Delay :
                                                                                        <?php echo $row['reasion_modify_exam_time']; ?>
                                                                                    </p></br>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                        </viv>
                                                                        <div class="modal-footer">
                                                                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>