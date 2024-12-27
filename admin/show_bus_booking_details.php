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
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
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
                                <h4 class="card-title">Bus Booking Details</h4>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="room_details">

                                            <p>Seating Capacity : 30 participants</span></p>

                                            <!-- <div class="rent d-flex justify-content-between ">
                                                    <p> Rent : <span class="price">₹</span> </p>
                                                            
                                                </div> -->

                                        </div>

                                        <div class="booking_div">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#inhouse">Inhouse</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#others">Other</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#lists">Booking List</a>
                                                </li>

                                            </ul>
                                            <div class="tab-content mt-3">
                                                <div class="tab-pane fade show active" id="inhouse">
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
                                                                <label><strong>Booking From</strong></label>
                                                                <input type="date" name="event_start_date" id="event_start_date" class="form-control onlydatepicker" placeholder="Booking start date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><strong>Booking To</strong></label>
                                                                <input type="date" name="event_end_date" id="event_end_date" class="form-control onlydatepicker" placeholder="Booking start date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><strong>Boarding From</strong></label>
                                                                <input type="text" name="boarding" id="boarding" class="form-control " placeholder="Boarding From">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><strong>Destination To</strong></label>
                                                                <input type="text" name="destination" id="destination" class="form-control " placeholder="Destination To">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><strong>Distance in KM</strong></label>
                                                                <input type="text" name="distance" id="distance" class="form-control " placeholder="Distance">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row d-flex justify-content-center">
                                                        <input type="button" class="btn  " style="background:#3292a2" name="send" onclick="saveBookingInhouse()" value="Save" />
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="others">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><strong>Booking for</strong></label>
                                                                <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Enter Booking Title">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><strong>Booking From</strong></label>
                                                                <input type="date" name="event_start_date" id="event_start_date_other" class="form-control onlydatepicker" placeholder="Booking start date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><strong>Booking To</strong></label>
                                                                <input type="date" name="event_end_date" id="event_end_date_other" class="form-control onlydatepicker" placeholder="Booking start date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><strong>Boarding From</strong></label>
                                                                <input type="text" name="boarding" id="boarding_other" class="form-control " placeholder="Boarding From">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><strong>Destination To</strong></label>
                                                                <input type="text" name="destination" id="destination_other" class="form-control " placeholder="Destination To">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><strong>Distance in KM</strong></label>
                                                                <input type="text" name="distance" id="distance_other" class="form-control " placeholder="Distance">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row d-flex justify-content-center">
                                                        <input type="button" class="btn  " style="background:#3292a2" name="send" onclick="save_event()" value="Save" />
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="lists">
                                                    <div class="search">
                                                        <select class="custom-select mr-sm-2" name="month_id" id="month">
                                                            <option selected>Select Month</option>
                                                            <?php
                                                            $db->select('tbl_month', "*", null, null, null, null);

                                                            foreach ($db->getResult() as $row) {
                                                            ?>
                                                                <option value="<?php echo $row['month_id'] ?>">
                                                                    <?php echo $row['month_name'] ?>
                                                                </option>

                                                            <?php
                                                            }
                                                            ?>

                                                        </select>

                                                    </div>
                                                    <div class="search_result">
                                                        <div class="table table-responsive table-striped table-hover booking_table">

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="calendar"></div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <!-- Start popup dialog box -->
                <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel"> Edit Booking Class Room</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="img-container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Training Type</strong></label>
                                                <select class="custom-select mr-sm-2" name="traning_type" id="traning_type_edit">
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
                                                <select class="custom-select mr-sm-2" name="program_id" id="program_id_edit">
                                                    <option selected>Select Program</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="event_start_date">Start From </label>
                                                <input type="date" name="event_start_date" id="start_date_edit" class="form-control onlydatepicker" placeholder="start date">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="event_end_date">End To</label>
                                                <input type="date" name="event_end_date" id="end_date_edit" class="form-control" placeholder="Event end date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="edit_booking_btn" onclick="update_booking()">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End popup dialog box -->
                <!-- Start edit other program dialog box -->
                <div class="modal fade" id="edit_other_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel"> Edit Booking Class Room</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="img-container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Booking for</strong></label>
                                                <input type="text" class="form-control" name="event_name" id="event_name_edit" placeholder="Enter Booking Title">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="event_start_date">Start From </label>
                                                <input type="date" name="event_start_date" id="start_date_edit_other" class="form-control onlydatepicker" placeholder="start date">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="event_end_date">End To</label>
                                                <input type="date" name="event_end_date" id="end_date_edit_other" class="form-control" placeholder="Event end date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="edit_other_booking_btn" onclick="update_other_booking()">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End popup dialog box -->

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
    $(document).ready(function() {
        display_events();
    }); //end document.ready block
    $('#traning_type').on('change', function() {
        var type = $('#traning_type').val();

        $.ajax({
            type: "POST",
            url: "ajax_master.php",
            data: {

                action: "timeTable_prgram",
                type: type,

            },
            success: function(res) {
                console.log(res);
                $('#program_id').html(res);

            }
        })
    })
    // $('#program_id').on('change', function () {

    //     var type = $('#traning_type').val();
    //     var program_id = $('#program_id').val();

    //     $.ajax({
    //         type: "POST",
    //         url: "ajax_bus_booking_details.php",
    //         dataType: 'json',
    //         data: {

    //             action: "clt_prog_dt",
    //             type: type,
    //             program_id: program_id,

    //         },
    //         success: function (res) {
    //             console.log(res);
    //             event_start_date
    //             $('#event_start_date').val(res.start_dt);
    //             $('#event_end_date').val(res.end_dt);

    //         }
    //     })
    // })

    $('#month').on('change', function() {
        let month_id = $('#month').val();
        let room_id = <?php echo $_POST['id']; ?>;
        $.ajax({
            type: "POST",
            url: "ajax_bus_booking_details.php",
            data: {
                action: "booking_details",
                month_id: month_id,
                room_id: room_id
            },
            success: function(res) {
                console.log(res);
                $('.booking_table').html(res);
                editBooking(this)
                deleteBooking(this)

            }
        })
    })

    function deleteBooking(el) {

        let bookingId = el.getAttribute("data-bookid");
        if (confirm("Are you sure you want to delete this?")) {
            $.ajax({
                type: "POST",
                url: "ajax_bus_booking_details.php",
                dataType: 'json',
                data: {

                    action: "delete_booking",
                    bookingId: bookingId

                },
                success: function(response) {
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
        } else {
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
            url: "ajax_bus_booking_details.php",
            data: {
                action: "edit_booking_details",
                bookingId: bookingId
            },
            dataType: 'json',
            success: function(res) {
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
                        success: function(result) {
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
            url: 'ajax_bus_booking_details.php',
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
            success: function(response) {
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
            url: 'ajax_bus_booking_details.php',
            data: {
                'action': 'edit_other_booking',
                'title': title,
                'event_start_date': event_start_date,
                'event_end_date': event_end_date,
                'bookingId': bookingId
            },
            method: 'POST',
            dataType: 'json',
            success: function(response) {
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

    function display_events() {
        var event = new Array();

        $.ajax({
            url: 'ajax_bus_booking_details.php',
            data: {
                'action': 'show_booking',
            },
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                //console.log(response);
                var result = response.data;
                $.each(result, function(i, item) {
                    let date = new Date(result[i].end);
                    let end_date = date.setDate(date.getDate() + 1);
                    event.push({
                        title: result[i].title,
                        event_id: result[i].event_id,
                        start: result[i].start,
                        end: end_date,
                        color: result[i].color,

                    });
                })
                //console.log(event);
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'prev,next,today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'

                    },
                    initialView: 'dayGridMonth',
                    timeZone: 'UTC',
                    eventSources: [{
                        events: event
                    }],

                    editable: true,
                    selectable: true,
                    selectHelper: true,
                    select: function() {
                        $('#event_entry_modal').modal('show');
                    },
                    eventClick: function(info) {

                        // change the border color just for fun
                        info.el.style.borderColor = 'green';
                    }
                })
                calendar.render();
            }
        }); //end ajax block	
    }

    function saveBookingInhouse() {
        let trng_type = $('#traning_type').val();
        let program_id = $('#program_id').val()
        let title = $('#program_id :selected').text();
        let event_start_date = $('#event_start_date').val();
        let event_end_date = $('#event_end_date').val();
        let boarding = $('#boarding').val();
        let destination = $('#destination').val();
        let distance = $('#distance').val();


        $.ajax({
            url: 'ajax_bus_booking_details.php',
            data: {
                'action': 'add_inhouse_booking',
                'title': title,
                'trng_type': trng_type,
                'program_id': program_id,
                'event_start_date': event_start_date,
                'event_end_date': event_end_date,
                'boarding': boarding,
                'destination': destination,
                'distance': distance
            },
            method: 'POST',
            dataType: 'json',
            success: function(response) {
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
        let boarding = $('#boarding_other').val();
        let destination = $('#destination_other').val();
        let distance = $('#distance_other').val();

        $.ajax({
            url: 'ajax_bus_booking_details.php',
            data: {
                'action': 'add_booking',
                'event_name': event_name,
                'event_start_date': event_start_date,
                'event_end_date': event_end_date,
                'room_id': room_id
            },
            method: 'POST',
            dataType: 'json',
            success: function(response) {
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