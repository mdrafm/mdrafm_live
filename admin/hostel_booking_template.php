<?php
$db->select('tbl_floor_master', "*", null, null, "id desc", null);
foreach ($db->getResult() as $row) {
    ?>
    <div class="floor-wrap">
        <p>
            <?php echo $row['name'] ?>
        </p>
        <div class="room-outer-wrap d-flex justify-content-around">
            <?php
            $db->select('tbl_hostel_room_master', "*", null, 'status = 1 AND block_id = '.$block_id.' AND floor_id =' . $row['id'], "id desc", null);
            foreach ($db->getResult() as $row1) {
                ?>
                <div
                    class="room-wrap d-flex flex-column align-items-center">
                    <span data-toggle="tooltip" data-placement="top"
                        title="Room No">
                        <?php echo $row1['room_no'] ?>
                    </span>
                    <div class="hostel-room">
                        <?php
                        // $select_bed_sql = "SELECT b.*,h.id as booking_id,IFNULL(h.status, 0) AS booking_status,h.program_id,h.trainee_id  FROM `tbl_hostel_bed_master` as b 
                        // LEFT JOIN `tbl_hostel_room_booking` h ON b.id = h.bed_id
                        // WHERE  b.room_id =". $row1['id'];

                        $select_bed_sql = "SELECT *  FROM `tbl_hostel_bed_master` WHERE  room_id =". $row1['id'];

                        $db->select_sql($select_bed_sql);

                        foreach ($db->getResult() as $row2) {

                             $status = $row2['status'];
                            // $select_booking_dtl = "SELECT *  FROM `tbl_hostel_room_booking` WHERE  id =". $row2['booking_id'];

                            // $db->select_sql($select_booking_dtl);
                            // $booking = $db->getResult();

                            // print_r($booking[0]['program_id']);
                            ?>
                            <div class="bed-wrap">
                                <button type="button" class="showBookingDtlBtn btn btn-sm btn-<?php echo ($status == 1)?'danger':'success' ?>"
                                    data-bedId=<?php echo $row2['id'] ?>
                                    data-roomId=<?php echo $row1['id'] ?>
                                    data-roomNo=<?php echo $row1['room_no'] ?>
                                    data-bedNo=<?php echo $row2['bed_name'] ?>
                                    data-status=<?php echo $status ?>
                                    data-bookingId=<?php echo $row2['booking_id'] ?>
                                    data-toggle="tooltip" data-placement="top"
                                    title="Bed No">
                                    <?php echo $row2['bed_name'] ?>
                                </button>

                            </div>
                            <?php

                        }
                        ?>

                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}
?>