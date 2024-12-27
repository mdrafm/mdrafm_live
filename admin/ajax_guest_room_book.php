<?php

include 'database.php';
$db = new Database();

if (isset($_POST['action']) && $_POST['action'] == 'trainee_store_room') {

    $insert_sql = "INSERT INTO `tbl_guest_room_booking` (`id`, `room_id`, `bed_id`, `trng_type`, `program_id`, `trainee_id`, `cadre`, `check_in`, `check_out`, `remark`, `status`) 
                   VALUES (NULL, '" . $_POST['room_id'] . "', '" . $_POST['bedId'] . "', '" . $_POST['traning_type'] . "', '" . $_POST['program_id'] . "','" . $_POST['trainee_id'] . "', '" . $_POST['cadre'] . "', '" . $_POST['check_in'] . "', '" . $_POST['check_out'] . "', '" . $_POST['remark'] . "', 1)";
    $db->insert_sql($insert_sql);
    $res = $db->getResult();
    // print_r($res);
    if ($res) {
        // echo 123;
        $response['status'] = 1;
        $response['message'] = 'Room Booked successfully!';
    } else {
        $response['status'] = 0;
        $response['message'] = 'Something Wrong!';
    }

    echo json_encode($response);

}
if (isset($_POST['action']) && $_POST['action'] == 'gh_store_room_other') {

    $insert_sql = "INSERT INTO `tbl_guest_room_booking` (`id`, `room_id`, `bed_id`,`program_name`,`name`, `cadre`, `check_in`, `check_out`, `remark`, `status`) 
                   VALUES (NULL, '" . $_POST['room_id'] . "', '" . $_POST['bedId'] . "','" . $_POST['program_name'] . "','" . $_POST['name'] . "', '" . $_POST['cadre'] . "', '" . $_POST['check_in'] . "', '" . $_POST['check_out'] . "', '" . $_POST['remark'] . "', 1)";
    $db->insert_sql($insert_sql);
    $res = $db->getResult();
    // print_r($res);
    if ($res) {
        // echo 123;
        $response['status'] = 1;
        $response['message'] = 'Room Booked successfully!';
    } else {
        $response['status'] = 0;
        $response['message'] = 'Something Wrong!';
    }

    echo json_encode($response);

}


if (isset($_POST['action']) && $_POST['action'] == 'book_guestRoom') {
    ?>


    <p> Room Booking Details</p>
    <div class="row">
        <span>Room No :
            <?php echo $_POST['roomNo'] ?>
        </span>
    </div>
    <div class="row">
        <span>Bed No :
            <?php echo $_POST['bedNo'] ?>
        </span>
    </div>
    <?php if ($_POST['status'] != 1) {
        ?>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#block1">Booking For Trainee</a>

            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#block2">Booking For Others</a>
            </li>

        </ul>
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="block1">
                <form action="" id="traineeRoomBookFrm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Training Type</strong></label>
                                <select class="custom-select mr-sm-2" name="traning_type" id="traning_type">
                                    <option selected>Select Type</option>
                                    <?php
                                    $db->select('tbl_training_type', "*", null, null, null, null);

                                    foreach ($db->getResult() as $row) {
                                        ?>
                                        <option value="<?php echo $row['id'] ?>">
                                            <?php echo $row['type'] ?>
                                        </option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Program</strong></label>
                                <select class="custom-select mr-sm-2" name="program_id" id="program_id">
                                    <option selected>Select Program</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Trainee Name</strong></label>
                                <select class="custom-select mr-sm-2" name="trainee_id" id="trainee_id">
                                    <option selected>Select Trainee</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>CADRE</strong></label>
                                <input type="text" class="form-control" name="cadre" id="cadre" value="" />

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Check In</strong></label>
                                <input type="date" class="form-control" name="check_in" id="check_in" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Check Out</strong></label>
                                <input type="date" class="form-control" name="check_out" id="check_out" value="" />

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Remark</strong></label>
                                <input type="text" class="form-control" name="remark" id="remark" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Status</strong></label>
                                <select class="custom-select mr-sm-2" name="status" id="status">
                                    <option value="0" selected>Select Status</option>
                                    <option value="1">Occupied</option>
                                    <option value="2">Vacant</option>

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <input type="hidden" name="room_id" value="<?php echo $_POST['roomId'] ?>">
                        <input type="hidden" name="bedId" value="<?php echo $_POST['bedId'] ?>">
                        <input type="hidden" name="status" value="<?php echo $_POST['status'] ?>">
                        <input type="hidden" name="action" value="trainee_store_room">
                        <input type="button" class="btn" style="background:#3292a2;margin-left: 12vw;" id="saveBtn" name="send"
                            onclick="bookRoom('traineeRoomBookFrm')" value="Book">
                    </div>
                </form>
            </div>
            <div class="tab-pane fade show " id="block2">
            <form action="" id="OtherRoomBookFrm">
                    <div class="row">
                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Program Name</strong></label>
                                <input type="text" class="form-control" name="program_name" id="program_name" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Occupant Name</strong></label>
                                <input type="text" class="form-control" name="name" id="name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>CADRE</strong></label>
                                <input type="text" class="form-control" name="cadre" id="cadre" value="" />

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Check In</strong></label>
                                <input type="date" class="form-control" name="check_in" id="check_in" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Check Out</strong></label>
                                <input type="date" class="form-control" name="check_out" id="check_out" value="" />

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Remark</strong></label>
                                <input type="text" class="form-control" name="remark" id="remark" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Status</strong></label>
                                <select class="custom-select mr-sm-2" name="status" id="status">
                                    <option value="0" selected>Select Status</option>
                                    <option value="1">Occupied</option>
                                    <option value="2">Vacant</option>

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <input type="hidden" name="room_id" value="<?php echo $_POST['roomId'] ?>">
                        <input type="hidden" name="bedId" value="<?php echo $_POST['bedId'] ?>">
                        <input type="hidden" name="status" value="<?php echo $_POST['status'] ?>">
                        <input type="hidden" name="action" value="gh_store_room_other">
                        <input type="button" class="btn" style="background:#3292a2;margin-left: 12vw;" 
                        id="saveBtn" name="send" onclick="bookRoom('OtherRoomBookFrm')" value="Book">
                            
                    </div>
                </form>
            </div>
        </div>
        <?php
    } else {
        $sex =0;
       // print_r($_POST);

        if($_POST['trngType'] == 1 || $_POST['trngType'] == 2){
            $sex =1;
            $booking_sql = "SELECT b.id,b.check_in,CONCAT(n.f_name,' ',n.l_name)as name,p.prg_name,n.sex,n.phone,n.email FROM `tbl_guest_room_booking` b 
            JOIN `tbl_new_recruite` n ON b.program_id = n.program_id 
            JOIN `tbl_program_master` p ON b.program_id = p.id
            WHERE n.program_id = '" . $_POST['programId'] . "' AND n.user_id = '" . $_POST['traineeId'] . "' AND b.id = '" . $_POST['bookingId'] . "'";

        }else if($_POST['trngType'] == 3 || $_POST['trngType'] == 7){
            $booking_sql = "SELECT b.id,b.check_in,name,p.prg_name,n.phone,n.email FROM `tbl_guest_room_booking` b 
            JOIN `tbl_dept_trainee_registration` n ON b.program_id = n.program_id 
            JOIN `tbl_mid_program_master` p ON b.program_id = p.id
            WHERE n.program_id = '" . $_POST['programId'] . "' AND n.user_id = '" . $_POST['traineeId'] . "' AND b.id = '" . $_POST['bookingId'] . "'";
        }else if($_POST['trngType'] == 4 || $_POST['trngType'] == 5){
            $booking_sql = "SELECT b.id,b.check_in,name,p.prg_name,n.phone,n.email FROM `tbl_guest_room_booking` b 
            JOIN `tbl_short_trainee_registration` n ON b.program_id = n.program_id 
            JOIN `tbl_mid_program_master` p ON b.program_id = p.id
            WHERE n.program_id = '" . $_POST['programId'] . "' AND n.user_id = '" . $_POST['traineeId'] . "' AND b.id = '" . $_POST['bookingId'] . "'";
        }else{
            $booking_sql = "SELECT program_name as prg_name,name,cadre,check_in,check_out  FROM `tbl_guest_room_booking` WHERE id = '" . $_POST['bookingId'] . "'";
        }
        //echo $booking_sql;
        $db->select_sql($booking_sql);

        foreach ($db->getResult() as $row) {
          //  print_r($row);
            ?>
            <div class="book_trainee_dtl">
                <div class="row">
                    <div class="col-md-4 label-name">Program Name :</div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $row['prg_name'] ?>" ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 label-name">Name :</div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $row['name'] ?>" ?>
                    </div>
                </div>
                <div class="row" style="display: <?php echo ($sex == 0)?'none':'' ?>" >
                    <div class="col-md-4 label-name">Gender :</div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" value="<?php echo ($row['sex'] == 1) ? 'Male' : 'Female' ?>" ?>
                    </div>
                </div>

                <div class="row" style="display: <?php echo ($sex == 0)?'none':'' ?>">
                    <div class="col-md-4 label-name">Phone No :</div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $row['phone'] ?>" ?>
                    </div>
                </div>
                <div class="row" style="display: <?php echo ($sex == 0)?'none':'' ?>">
                    <div class="col-md-4 label-name">Email :</div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $row['email'] ?>" ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 label-name">Check In :</div>
                    <div class="col-md-8">
                        <input type="date" class="form-control" value="<?php echo $row['check_in'] ?>" ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 label-name">Check Out :</div>
                    <div class="col-md-8">
                        <input type="date" class="form-control" name="check_out" id="chk_date" value="" ?>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="room_id" value="<?php echo $_POST['roomId'] ?>">

                    <input type="hidden" name="action" value="store_room">
                    <input type="button" class="btn" style="background:#df2507;margin-left: 12vw;" id="checkOutBtn" name="send"
                        onclick="checkOutRoom(<?php echo $_POST['bookingId'] ?>)" value="Check Out">
                </div>

            </div>
            <?php
        }



        ?>

        <?php
    }



}

if (isset($_POST['action']) && $_POST['action'] == 'checkOut_booking') {
    $bookingId = $_POST['bookingId'];
    $chk_date = $_POST['chk_date'];

    $db->update('tbl_guest_room_booking', ["check_out" => $chk_date, 'status' => 0], 'id=' . $bookingId);
    $res = $db->getResult();
    if ($res) {
        // echo 123;
        $response['status'] = 1;
        $response['message'] = 'Checkout successfully!';
    } else {
        $response['status'] = 0;
        $response['message'] = 'Something Wrong!';
    }
    echo json_encode($response);
}

?>