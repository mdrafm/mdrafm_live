<!DOCTYPE html>
<html lang="en">


<head>
    <?php

    include('header_link.php');
    include('../config.php');
    include 'database.php';
    $db = new Database();

    ?>
    <!-- CSS for full calender -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
</head>

<body class="user-profile">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="wrapper ">

        <?php include('sidebar.php'); ?>

        <div class="main-panel" id="main-panel">
            <?php include('navbar.php'); ?>

            <div class="panel-header panel-header-sm">


            </div>


            <div class="content">


                <div class="row" style="margin-top:50px">
                    <div class="col-md-12">
                        <div class="statusMsg"></div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Guest House Booking Details</h4>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="booking_div">
                                        <?php
                                            $db->select('tbl_floor_master', "*", null, null, "id desc", null);
                                            foreach ($db->getResult() as $row) {
                                                ?>
                                                <div class="floor-wrap">
                                                    <p>
                                                        <?php echo $row['name'] ?>
                                                    </p>
                                                    <div class="room-outer-wrap d-flex justify-content-around"
                                                        style="flex-wrap: wrap-reverse;
                                                                column-gap: 10px;
                                                                row-gap: 10px;"
                                                    >
                                                        <?php
                                                        $db->select('tbl_hostel_room_master', "*", null, 'block_id = 6 AND floor_id =' . $row['id'], "id desc", null);
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
                                                                    $select_bed_sql = "SELECT b.*,h.id as booking_id,IFNULL(h.status, 0) AS booking_status,h.program_id,h.trainee_id ,h.trng_type FROM `tbl_hostel_bed_master` as b 
                                                                    LEFT JOIN `tbl_guest_room_booking` h ON b.id = h.bed_id
                                                                    WHERE b.room_id =". $row1['id'];

                                                                    $db->select_sql($select_bed_sql);

                                                                    foreach ($db->getResult() as $row2) {

                                                                        $status = $row2['booking_status'];
                                                                        //print_r($row2);
                                                                        ?>
                                                                        <div class="bed-wrap">
                                                                            <button type="button" class="showBookingDtlBtn btn btn-sm btn-<?php echo ($status == 1)?'danger':'success' ?>"
                                                                                data-bedId=<?php echo $row2['id'] ?>
                                                                                data-roomId=<?php echo $row1['id'] ?>
                                                                                data-roomNo=<?php echo $row1['room_no'] ?>
                                                                                data-bedNo=<?php echo $row2['bed_name'] ?>
                                                                                data-status=<?php echo $status ?>
                                                                                data-bookingId=<?php echo $row2['booking_id'] ?>
                                                                                data-programId=<?php echo $row2['program_id'] ?>
                                                                                data-traineeId=<?php echo $row2['trainee_id'] ?>
                                                                                data-trngType=<?php echo $row2['trng_type'] ?>

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
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="room_booking"></div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>


            </div>



        </div>




    </div>

    </div>

    </div>

    </div>

    <?php include('common_script.php') ?>
    <!-- JS for full calender -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

</body>

</html>

<script type="text/javascript">
    $(document).ready(function () {
        display_events();
    }); //end document.ready block

    // function showBookingDtl(){
    //     const roomId = $(this).attr('data-roomId');
    //    // $(this).attr("data-id") 
    //     console.log(roomId)
    // }

    function bookRoom(traineeRoomBookFrm) {
        console.log(123);
        $.ajax({
            type: "POST",
            url: "ajax_guest_room_book.php",
            data: $(`#${traineeRoomBookFrm}`).serialize(),
            dataType: 'json',
            beforeSend: function () {
                $('#saveBtn').prop('disabled', true);
                $('#saveBtn').val('Please Wait...');

            },
            success: function (response) {
console.log(response);
                $('#saveBtn').prop('disabled', false);
                $('#saveBtn').val('Book');

                $('.statusMsg').html('');
                if (response.status == 1) {
                    $('.statusMsg').html('<p class="alert alert-success">' + response.message + '</p>');
                     location.reload();
                } else {
                    $('.statusMsg').html('<p class="alert alert-danger">' + response.message + '</p>');
                }

            }
        })
    }

    $('.showBookingDtlBtn').on('click', function () {
        const roomId = $(this).attr('data-roomId');
        const bedId = $(this).attr('data-bedId');
        const status = $(this).attr('data-status');
        const roomNo = $(this).attr('data-roomNo');
        const bedNo = $(this).attr('data-bedNo');
        const bookingId = $(this).attr('data-bookingId');
        const programId = $(this).attr('data-programId');
        const traineeId = $(this).attr('data-traineeId');
        const trngType = $(this).attr('data-trngType');


        $.ajax({
            type: "POST",
            url: "ajax_guest_room_book.php",
            data: {
                action: "book_guestRoom",
                roomId: roomId,
                bedId: bedId,
                roomNo: roomNo,
                bedNo: bedNo,
                bookingId:bookingId,
                traineeId:traineeId,
                programId:programId,
                trngType:trngType,
                status: status
            },
            success: function (res) {
                console.log(res);

                $('#room_booking').html(res);

                $('#traning_type').on('change', function () {
                    var type = $('#traning_type').val();
                    console.log(123);
                    $.ajax({
                        type: "POST",
                        url: "ajax_master.php",
                        data: {

                            action: "timeTable_prgram",
                            type: type,

                        },
                        success: function (res) {
                            console.log(res);
                            $('#program_id').html(res);

                        }
                    })
                })
                $('#program_id').on('change', function () {
                    var type = $('#traning_type').val();
                    var program_id = $('#program_id').val();

                    $.ajax({
                        type: "POST",
                        url: "ajax_master.php",
                        data: {

                            action: "trainee_name_list",
                            type: type,
                            program_id: program_id

                        },
                        success: function (res) {
                            console.log(res);
                            $('#trainee_id').html(res);

                        }
                    })
                })

            }
        })
    })


    function checkOutRoom(bookingId) {
        const chk_date = $('#chk_date').val();
      
        if (confirm("Are you sure you want to check out?")) {
            $.ajax({
                type: "POST",
                url: "ajax_guest_room_book.php",
                dataType: 'json',
                data: {

                    action: "checkOut_booking",
                    bookingId: bookingId,
                    chk_date:chk_date

                },
                success: function (response) {
                    console.log(response);
                    $('.statusMsg').html('');
                    if (response.status == 1) {
                        $('.statusMsg').html('<p class="alert alert-success">' + response.message + '</p>');
                        location.reload();
                    } else {
                        $('.statusMsg').html('<p class="alert alert-danger">' + response.message + '</p>');
                    }


                }
            })
        }
        else {
            return false;
        }



    }
    function editBooking(el) {
        console.log(el);
        let bookingId = el.getAttribute("data-bookid");
        //checking for in house program or other
        console.log(bookingId);
        $.ajax({
            type: "POST",
            url: "ajax_class_room_booking_details.php",
            data: {
                action: "edit_booking_details",
                bookingId: bookingId
            },
            dataType: 'json',
            success: function (res) {
                console.log(res);
                //fetch program details
                if (res[0].trng_type != 0) {

                    $.ajax({
                        type: "POST",
                        url: "ajax_master.php",
                        data: {

                            action: "timeTable_prgram",
                            type: res[0].trng_type,
                            program_id: res[0].program_id

                        },
                        success: function (result) {
                            console.log(result);
                            $('#traning_type_edit').val(res[0].trng_type);
                            $('#program_id_edit').html(result);
                            $('#start_date_edit').val(res[0].from_dt);
                            $('#end_date_edit').val(res[0].to_dt);

                            $('#edit_booking_btn').data('editBookingId', res[0].id);

                            $('#edit_modal').modal('show');


                        }
                    })
                } else {

                    $('#event_name_edit').val(res[0].title);
                    $('#start_date_edit_other').val(res[0].from_dt);
                    $('#end_date_edit_other').val(res[0].to_dt);
                    $('#edit_other_booking_btn').data('editBookingId', res[0].id);
                    $('#edit_other_modal').modal('show');
                }


            }
        })




    }
    function update_booking() {
        let bookingId = $('#edit_booking_btn').data('editBookingId');

        let traning_type = $('#traning_type_edit').val();
        let program_id = $('#program_id_edit').val();
        let event_start_date = $('#start_date_edit').val();
        let event_end_date = $('#end_date_edit').val();
        let title = $('#program_id :selected').text();

        $.ajax({
            url: 'ajax_class_room_booking_details.php',
            data: {
                'action': 'edit_booking',
                'title': title,
                'trng_type': traning_type,
                'program_id': program_id,
                'event_start_date': event_start_date,
                'event_end_date': event_end_date,
                'bookingId': bookingId
            },
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                console.log(response);

                $('.statusMsg').html('');
                if (response.status == 1) {
                    $('.statusMsg').html('<p class="alert alert-success">' + response.message + '</p>');
                    location.reload();
                } else {
                    $('.statusMsg').html('<p class="alert alert-danger">' + response.message + '</p>');
                }

            }
        })

    }
    function update_other_booking() {
        let bookingId = $('#edit_other_booking_btn').data('editBookingId');
        let event_start_date = $('#start_date_edit_other').val();
        let event_end_date = $('#end_date_edit_other').val();
        let title = $('#event_name_edit').val();

        $.ajax({
            url: 'ajax_class_room_booking_details.php',
            data: {
                'action': 'edit_other_booking',
                'title': title,
                'event_start_date': event_start_date,
                'event_end_date': event_end_date,
                'bookingId': bookingId
            },
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                console.log(response);

                $('.statusMsg').html('');
                if (response.status == 1) {
                    $('.statusMsg').html('<p class="alert alert-success">' + response.message + '</p>');
                    location.reload();
                } else {
                    $('.statusMsg').html('<p class="alert alert-danger">' + response.message + '</p>');
                }

            }
        })
    }
    
    function saveBookingInhouse() {
        let trng_type = $('#traning_type').val();
        let program_id = $('#program_id').val()
        let title = $('#program_id :selected').text();
        let event_start_date = $('#event_start_date').val();
        let event_end_date = $('#event_end_date').val();
        let room_id = <?php echo $_POST['id']; ?>;

        $.ajax({
            url: 'ajax_class_room_booking_details.php',
            data: {
                'action': 'add_inhouse_booking',
                'title': title,
                'trng_type': trng_type,
                'program_id': program_id,
                'event_start_date': event_start_date,
                'event_end_date': event_end_date,
                'room_id': room_id
            },
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                console.log(response);

                $('.statusMsg').html('');
                if (response.status == 1) {
                    $('.statusMsg').html('<p class="alert alert-success">' + response.message + '</p>');
                    location.reload();
                } else {
                    $('.statusMsg').html('<p class="alert alert-danger">' + response.message + '</p>');
                }

            }
        })

    }
    function save_event() {
        let event_name = $('#event_name').val();
        let event_start_date = $('#event_start_date_other').val();
        let event_end_date = $('#event_end_date_other').val();
        let room_id = <?php echo $_POST['id']; ?>;

        $.ajax({
            url: 'ajax_class_room_booking_details.php',
            data: {
                'action': 'add_booking',
                'event_name': event_name,
                'event_start_date': event_start_date,
                'event_end_date': event_end_date,
                'room_id': room_id
            },
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                // console.log(response);  

                $('.statusMsg').html('');
                if (response.status == 1) {

                    $('.statusMsg').html('<p class="alert alert-success">' + response.message + '</p>');
                    location.reload();
                } else {
                    $('.statusMsg').html('<p class="alert alert-danger">' + response.message + '</p>');
                }

            }
        })


    }


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