<?php

include 'database.php';
$db = new Database();

if( isset($_POST['action']) && $_POST['action'] == 'show_booking'){
   
    $db->select('tbl_bus_booking_details',"*",null,null,null,null);
     $res = $db->getResult();
     $data_arr=array();
     $i=1;
     if($res){
        foreach($res as $data_row){
            $data_arr[$i]['event_id'] = $data_row['id'];
            $data_arr[$i]['title'] = $data_row['title'];
            $data_arr[$i]['start'] = date("Y-m-d", strtotime($data_row['from_dt']));
            $data_arr[$i]['end'] = date("Y-m-d", strtotime($data_row['to_dt']));
            $data_arr[$i]['color'] = 'red'; 
            $i++;
        }
        $data = array(
            'status' => true,
            'msg' => 'successfully!',
            'data' => $data_arr
        );
     }else{
        $data = array(
            'status' => false,
            'msg' => 'Error!',
            'data' => ''				
        );
     }
     echo json_encode($data);
}

if (isset($_POST['action']) && $_POST['action'] == 'clt_prog_dt') {
    $type = $_POST['type'];
    $program_id = $_POST['program_id'];
   
  
    if ($type == 1 || $type == 2) {
      $prog_table = 'tbl_program_master';
      $db->select($prog_table,"provisonal_Sdate as start_date,provisonal_Edate as end_date",null,"trng_type = '".$type."' AND id = '".$program_id."' ",null,null);
    } elseif ($type == 3 || $type == 7) {
      $prog_table = 'tbl_mid_program_master';
      $db->select($prog_table,"start_date, end_date",null,"trng_type = '".$type."' AND id = '".$program_id."' ",null,null);
    } elseif ($type == 4 || $type == 5) {
      $prog_table = 'tbl_short_program_master';
      $db->select($prog_table,"start_date, end_date",null,"trng_type = '".$type."' AND id = '".$program_id."' ",null,null);
    }
   // print_r($db->getResult());
    foreach ($db->getResult() as $row) {
        $data = array(
            'start_dt' => $row['start_date'],
            'end_dt' => $row['end_date'],
            			
        );
    }

    echo json_encode($data);
}
if( isset($_POST['action']) && $_POST['action'] == 'add_inhouse_booking'){
    $program_id = $_POST['program_id'];
    $trng_type = $_POST['trng_type'];
    $title = $_POST['title'];
    $event_start_date = $_POST['event_start_date'];
    $event_end_date = $_POST['event_end_date'];
    $boarding = $_POST['boarding'];
    $destination = $_POST['destination'];
    $distance = $_POST['distance'];

    // $date = new DateTime($event_end_date);
    // $date->modify('+1 day');
    // $end_date = $date->format('Y-m-d');
//exit;
   
    $chkRooms =chkRoomAvalibility($event_start_date,$event_end_date);

    if($chkRooms == 1){
    $insert_sql = "INSERT INTO `tbl_bus_booking_details` (`id`, `program_id`, `trng_type`, `user_id`, `title`, `from_dt`, `to_dt`,`boarding_frm`,`destination_to`,`distance`, `status`) VALUES 
    (NULL, '$program_id', '$trng_type', '0','".$title."',  '".$event_start_date."',  '".$event_end_date."','".$boarding."','".$destination."','".$distance."', '1') ";
    $db->insert_sql($insert_sql);
    $res = $db->getResult();
    //print_r($res);
    if ($res) {
        // echo 123;
        $response['status'] = 1;
        $response['message'] = 'Bus Booked successfully!';
    }else {
        $response['status'] = 0;
        $response['message'] = 'Something Wrong!';
    }
    }else{
        $response['status'] = 0;
        $response['message'] = 'Bus not available on this date';
    }
    echo json_encode($response);


}
if( isset($_POST['action']) && $_POST['action'] == 'add_booking'){

    $event_name = $_POST['event_name'];
    $event_start_date = $_POST['event_start_date'];
    $event_end_date = $_POST['event_end_date'];
    $room_id = $_POST['room_id'];
    $chkRooms =chkRoomAvalibility($room_id,$event_start_date,$event_end_date);

    if($chkRooms == 1){
        $insert_sql = "INSERT INTO `tbl_class_room_booking_details` (`id`, `program_id`, `trng_type`, `user_id`, `class_room_id`, `title`, `from_dt`, `to_dt`, `status`) VALUES 
        (NULL, '0', '0', '0', '$room_id', '".$event_name."',  '".$event_start_date."',  '".$event_end_date."', '1')";
        $db->insert_sql($insert_sql);
        $res = $db->getResult();
       // print_r($res);
        if ($res) {
            // echo 123;
            $response['status'] = 1;
            $response['message'] = 'Event Added successfully!';
        }else {
            $response['status'] = 0;
            $response['message'] = 'Something Wrong!';
        }
    }else{
        $response['status'] = 0;
        $response['message'] = 'Class room not available on this date';
    }
    
    echo json_encode($response);


}

if( isset($_POST['action']) && $_POST['action'] == 'edit_booking'){

    $program_id = $_POST['program_id'];
    $trng_type = $_POST['trng_type'];
    $title = $_POST['title'];
    $event_start_date = $_POST['event_start_date'];
    $event_end_date = $_POST['event_end_date'];

    // $date = new DateTime($event_end_date);
    // $date->modify('+1 day');
    // $end_date = $date->format('Y-m-d');
//exit;
    $bookingId = $_POST['bookingId'];
    $chkRooms =chkRoomAvalibility($bookingId,$event_start_date,$event_end_date);

    if($chkRooms == 1){
    $db->update('tbl_class_room_booking_details',['trng_type'=>$trng_type,'program_id'=>$program_id,'title'=>$title,'from_dt'=>$event_start_date,'to_dt'=>$event_end_date,], 'id=' . $bookingId);
    
    $res = $db->getResult();
    //print_r($res);
    if ($res) {
        // echo 123;
        $response['status'] = 1;
        $response['message'] = 'Event Updated successfully!';
    }else {
        $response['status'] = 0;
        $response['message'] = 'Something Wrong!';
    }
    }else{
        $response['status'] = 0;
        $response['message'] = 'Class room not available on this date';
    }
    echo json_encode($response);


}
if( isset($_POST['action']) && $_POST['action'] == 'edit_other_booking'){

    
    $title = $_POST['title'];
    $event_start_date = $_POST['event_start_date'];
    $event_end_date = $_POST['event_end_date'];

    // $date = new DateTime($event_end_date);
    // $date->modify('+1 day');
    // $end_date = $date->format('Y-m-d');
//exit;
    $bookingId = $_POST['bookingId'];
    $chkRooms =chkRoomAvalibility($bookingId,$event_start_date,$event_end_date);

    if($chkRooms == 1){
    $db->update('tbl_class_room_booking_details',['title'=>$title,'from_dt'=>$event_start_date,'to_dt'=>$event_end_date,], 'id=' . $bookingId);
    
    $res = $db->getResult();
    //print_r($res);
    if ($res) {
        // echo 123;
        $response['status'] = 1;
        $response['message'] = 'Booking Updated successfully!';
    }else {
        $response['status'] = 0;
        $response['message'] = 'Something Wrong!';
    }
    }else{
        $response['status'] = 0;
        $response['message'] = 'Class room not available on this date';
    }
    echo json_encode($response);


}
if( isset($_POST['action']) && $_POST['action'] == 'booking_details'){
    $room_id = $_POST['room_id'];
    $month_id = $_POST['month_id'];

    ?>
      <table class="table  ">
            <thead style="background: #315682;color:#fff;font-size: 11px;">
                <tr>
                    <th>Sl No</th>
                    <th>Title</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
               <?php
                 $sql = "SELECT * FROM `tbl_class_room_booking_details` WHERE class_room_id = $room_id AND MONTH(from_dt) = $month_id ";

                 $db->select_sql($sql);
                 $res = $db->getResult();
                 $cnt = 0;
                 foreach ($res as $row) {
                     $cnt++;
                     ?>
                        <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['from_dt']; ?></td>
                            <td><?php echo $row['to_dt']; ?></td>
                            <td>
                              <a href="#" class="text-info" data-bookId="<?php echo $row['id'] ?>" class="editBooking" onclick="editBooking(this)" ><i class="fas fa-edit"></i></a>
                              <a href="#" class="text-info" data-bookId="<?php echo $row['id'] ?>" class="" onclick="deleteBooking(this)"><i class="fas fa-trash text-danger"></i></a>
                            </td>
                        </tr>
                     <?php 
                 }
               ?>
            </tbody>
      </table>
    <?php
}

if( isset($_POST['action']) && $_POST['action'] == 'edit_booking_details'){
    $bookingId = $_POST['bookingId'];
    $sql = "SELECT * FROM `tbl_class_room_booking_details` WHERE id = $bookingId ";

    $db->select_sql($sql);
    $res = $db->getResult();
    echo json_encode($res);
}

if( isset($_POST['action']) && $_POST['action'] == 'delete_booking'){
    $bookingId = $_POST['bookingId'];

    $db->delete('tbl_class_room_booking_details', 'id=' . $bookingId);
  $res = $db->getResult();
  if ($res) {
    // echo 123;
    $response['status'] = 1;
    $response['message'] = 'Deleted successfully!';
    }else {
        $response['status'] = 0;
        $response['message'] = 'Something Wrong!';
    }
    echo json_encode($response);
}

function chkRoomAvalibility($startDt,$endDt){
    $db = new Database();
     $chksql = "SELECT id
     FROM `tbl_bus_booking_details`
     WHERE ('".$startDt."' BETWEEN `from_dt` AND `to_dt`
              OR '".$endDt."' BETWEEN `from_dt` AND `to_dt`)";
    $db->select_sql($chksql);
    $res = $db->getResult();
     //print_r($res);exit;
    if($res){
        return 0;
    }else{
        return 1;
    }
   
}

?>