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
                                <h4 class="card-title">Hostel Booking Details</h4>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="booking_div">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#block1">Block
                                                        1</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#block2">Block 2</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#block3">Block 3</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#block4">Block 4</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#block5">Block 5</a>
                                                </li>

                                            </ul>
                                            <div class="tab-content mt-3">
                                                <!-- block 1 start -->
                                                <div class="tab-pane fade show active" id="block1">
                                                   <?php 
                                                   $block_id = 1;
                                                   require 'hostel_booking_template.php' 
                                                   
                                                   ?>
                                                </div>

                                                <!-- block 1 end -->
                                                <div class="tab-pane fade" id="block2">
                                                <?php 
                                                   $block_id = 2;
                                                   require 'hostel_booking_template.php' 
                                                   
                                                   ?>
                                                </div>
                                                <div class="tab-pane fade" id="block3">
                                                <?php 
                                                   $block_id = 3;
                                                   require 'hostel_booking_template.php' 
                                                   
                                                   ?>
                                                </div>
                                                <div class="tab-pane fade" id="block4">
                                                <?php 
                                                   $block_id = 4;
                                                   require 'hostel_booking_template.php' 
                                                   
                                                   ?>
                                                </div>
                                                <div class="tab-pane fade" id="block4">
                                                <?php 
                                                   $block_id = 5;
                                                   require 'hostel_booking_template.php' 
                                                   
                                                   ?>
                                                </div>
                                            </div>
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

    function bookRoom() {
        console.log(123);
        $.ajax({
            type: "POST",
            url: "ajax_hostel_room_book.php",
            data: $('#roomBookFrm').serialize(),
            dataType: 'json',
            beforeSend: function () {
                $('#saveBtn').prop('disabled', true);
                $('#saveBtn').val('Please Wait...');

            },
            success: function (response) {

                $('#saveBtn').prop('disabled', false);
                $('#saveBtn').val('Book');

                $('.statusMsg').html('');
                if (response.status == 1) {
                    $('.statusMsg').html('<p class="alert alert-success">' + response.message + '</p>');
                    // location.reload();
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


        $.ajax({
            type: "POST",
            url: "ajax_hostel_room_book.php",
            data: {
                action: "book_room",
                roomId: roomId,
                bedId: bedId,
                roomNo: roomNo,
                bedNo: bedNo,
                bookingId:bookingId,
                traineeId:traineeId,
                programId:programId,
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


    function checkOutRoom(bookingId,bedId) {
        const chk_date = $('#chk_date').val();
      
        if (confirm("Are you sure you want to check out?")) {
            $.ajax({
                type: "POST",
                url: "ajax_hostel_room_book.php",
                dataType: 'json',
                data: {

                    action: "checkOut_booking",
                    bookingId: bookingId,
                    chk_date:chk_date,
                    bedId:bedId

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