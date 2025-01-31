<form method="post" id="frm_timeTable_<?php echo $i ?>" class="session_frm">
<input type="hidden" name="program_id" value="<?php echo $_POST['prog_id'] ?>" />
<input type="hidden" name="table_range_id" value="<?php echo $_POST['tt_range_id'] ?>" />
<div class="row">
    <h4>Add Session No - <?php echo $i; ?></h4>
</div>


<hr>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label><strong>Training Date</strong></label>

            <input type="date" class="form-control input-control" name="training_dt" id="training_dt"
                placeholder="Select Training Date" value=<?php echo $session_date ?>>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label><strong> Period Type</strong></label>
            <select class="custom-select mr-sm-2 period_type input-control" name="period_type"
                id="<?php echo $i ?>">
                <option value="0">Select Period Type</option>
                <option value="1" selected> Session</option>
                <option value="2"> Break</option>
            </select>


        </div>
    </div>
    <div class="col-md-3" id="break_fld_<?php echo $i ?>" style="display:none">
        <div class="form-group">
            <label><strong> Break</strong></label>
            <select class="custom-select mr-sm-2 input-control" name="break" id="break_<?php echo $i ?>">

                <option value="0">Select Break</option>
                <option value="1"> Tea Break</option>
                <option value="2"> Lunch Break</option>

            </select>


        </div>
    </div>


</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label><strong> Class Start Time</strong></label>
            <input type="text" class="form-control input-control class_start_time_<?php echo $i ?>" id="class_start_time"
                name="class_start_time" value='<?php echo $session_start_time; ?>' />
            <p id='start_time' style="display:none"></p>
            <span> <button type="button" id="verify_start" onclick="verify_class_time('start_time' )"
                    class="btn btn-sm" style="background-color:#141664">Verify Class Time</button></span>

        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label><strong>Class End Time</strong></label>
            <input type="text" class="form-control input-control class_end_time_<?php echo $i ?>" name="class_end_time"
                value="<?php echo $session_end_time; ?>" />
            <p id='end_time' style="display:none"></p>
            <span> <button type="button" id="verify_end" onclick="verify_class_time('end_time')" class="btn btn-sm"
                    style="background-color:#141664">Verify Class Time</button></span>
        </div>

    </div>

</div>
<div id="class_time_<?php echo $i ?>">
    <div class="row">

        <div class="col-md-6">
            <div class="form-group">
                <label><strong>Session Type</strong></label>
                <div class="form-check form-check-inline" style="margin-left: 20px;">
                    <input class="form-check-input " type="radio" name="session_type" id="ClassRoom" value="1"
                        checked>
                    <label class="form-check-label" for="Inhouse" style="padding-left: 5px;">ClassRoom Study</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="session_type" id="other" value="2">
                    <label class="form-check-label" for="Visiting" style="padding-left: 5px;">Other</label>
                </div>

            </div>
        </div>
        <div class="col-md-6 class_room">
            <div class="form-group">
                <label><strong>Faculty Type</strong></label>
                <div class="form-check form-check-inline" style="margin-left: 20px;">
                    <input class="form-check-input" type="radio" name="faculty" id="<?php echo $i ?>" value="1">
                    <label class="form-check-label" for="Inhouse" style="padding-left: 5px;">Inhouse Faculty</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="faculty" id="<?php echo $i ?>" value="2">
                    <label class="form-check-label" for="Visiting" style="padding-left: 5px;">Visiting
                        Faculty</label>
                </div>

            </div>
            <select class="custom-select input-control mr-sm-6 faculty_id_div inhouse" name="faculty_id[]"
                multiple="multiple" id="faculty_id_<?php echo $i ?>" style="width:400px">
                <option selected value="0">Select Faculty</option>

            </select>
            <p class="faculty_msg text-danger"></p>
        </div>

        <div class="col-md-6 ">
            <div class="others" style="display:none">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Select Other
                                    Class</strong></label>
                            <select class="custom-select mr-sm-2 input-control" name="other_class" id="other_class">
                                <option selected value="0">Select Other
                                    Class</option>
                                <?php 
                                                                    
                                                                    $count = 0;
                                                                    $db->select('other_topic',"*",null,null,null,null);
                                                                    // print_r( $db->getResult());
                                                                    foreach($db->getResult() as $row){
                                                                        //print_r($row);
                                                                        $count++
                                                                ?>
                                <option value="<?php echo $row['id'] ?>">
                                    <?php echo $row['name'] ?>
                                </option>

                                <?php 
                                                                }
                                                                ?>
                            </select>


                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Remark</strong></label>
                            <textarea class="form-control input-control" name="class_remark" id="class_remark"
                                placeholder="Remark for Other Class" rows="3"
                                style="border: 1px solid #e3e3e3;border-radius:5px;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>No of Session</strong></label>
                            <input type="text" class="form-control input-control" placeholder="Enter No of Session"
                                name="no_of_session" id="no_of_session">
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- class room -->
    <div class="class_room">

        <div class="row">
            
            <div class="col-md-6">
                <div class="form-group">
                    <label><strong> Subject</strong></label>
                    <textarea class="form-control input-control" name="paper_covered"
                        id="paperCovered_<?php echo $i ?>" placeholder="Enter Other Subject" rows="3"
                        style="border: 1px solid #e3e3e3;border-radius:5px;"></textarea>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="btn btn-primary float-right" onclick="addSession(<?php echo $i ?>,<?php echo $trng_type ?>)">Save</div>
    </div>
</div>
<!-- end class room -->
<input type="hidden" name="trng_type" value="<?php echo $trng_type ?>">
<input type="hidden" name="session_no" value="<?php echo $i ?>">
<input type="hidden" id="update_id_<?php echo $i ?>">
</form>