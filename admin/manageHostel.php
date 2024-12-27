<!DOCTYPE html>
<html lang="en">


<head>
    <?php

    include('header_link.php');
    include('../config.php');
    include 'database.php';
    $db = new Database();
    ?>

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

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> Hostel</h4>

                            </div>
                            <div class="card-body">
                               
                                    <div class="row room_div">
                                        <div class="col-md-4">
                                            <div class="image-wrap">
                                                <img src="../images/hostel.jpeg" style="width: 57%;" alt="">
                                            </div>

                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="room-desc" style="margin-top: 1rem ">
                                                    <div class="row">
                                                        <!-- <div class="col-md-2">
                                                            <label for="">Name</label>
                                                        </div> -->
                                                        <div class="col-md-12 class-name" ><?php echo "Mahanadi Hostel" ?></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    
                                                    <div class="col-md-12">
                                                        <p class="seat">Hostel has the capacity to accommodate <?php echo 120; ?> persons</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-1 rent">
                                                            <label for="">Rent:</label>
                                                        </div>
                                                        <div class="col-md-8" > <p class="price"><span>₹</span> <?php echo "300 per bed" ?></p> </div>
                                                        
                                                    </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="hosterl_facilities">
                                                    <p>Info</p>
                                                  
                                                    <ul>
                                                        <li>No of Block - 5 (One Ladies Block and Four numbers of Gents Blocks.)</li>
                                                        <li>Each Block comprises of 12 numbers of Twin-sharing Rooms</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                                <input type="button" class="btn " style="background:#3292a2" name="send" onclick="datapost('show_hostel_room_booking_details.php',{id: 1 })" value="Booking Details">
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

    </div>

    <?php include('common_script.php') ?>

</body>

</html>

<script type="text/javascript">
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