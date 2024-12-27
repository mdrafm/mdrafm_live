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
                                <h4 class="card-title"> Bus Service</h4>

                            </div>
                            <div class="card-body">
                               
                                    <div class="row room_div" style="height: 23rem;" >
                                        <div class="col-md-4">
                                            <div class="image-wrap">
                                                <img src="../images/bus.jpeg" alt="" style="width: 90%;">
                                            </div>

                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                            <div class="col-md-8">
                                                <div class="room-desc" style="margin-top: 1rem ">
                                                    <div class="row">
                                                        <!-- <div class="col-md-2">
                                                            <label for="">Name</label>
                                                        </div> -->
                                                        <div class="col-md-12 class-name" >MDRAFM Bus Service</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    
                                                    <div class="col-md-12">
                                                        <p class="seat">Seating arrangements for 30 participants</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <p class="rent" style="font-size: 1.7rem;
                                                                            font-weight: 600;
                                                                            color: #b93a12;
                                                                            font-family: emoji;" >
                                                        Rent</p>
                                                </div>
                                                <div class="row">
                                                        <!-- <div class="col-md-1 rent">
                                                            <label for="">Rent</label>
                                                        </div></br> -->
                                                        <div class="col-md-8" > 
                                                            <!-- <p class="price"><span>₹</span></p>  -->
                                                            <table class="table table-hover table-bordered">

                                                            
                                                            <tr>
                                                                <td>Per day Charge</td>
                                                                <td>₹ 1000</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Detention Charge</td>
                                                                <td> ₹ 100 (Per Day)</td>

                                                            </tr>
                                                            <tr>
                                                                <td>Fuel</td>
                                                                <td>4.5 KM @ 1 Ltr</td>

                                                            </tr>
                                                            </table>
                                                        
                                                        </div>
                                                        
                                                </div>
                                                <div class="row">
                                                <input type="button" class="btn " style="background:#3292a2"
                                                            name="send"
                                                            onclick="datapost('show_bus_booking_details.php',{id: 1 })"
                                                            value="Booking Details" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="facilities">
                                                    <p>Facilities</p>
                                                    <!-- <hr> -->
                                                    <ul>
                                                        <li>Ac Bus</li>
                                                    </ul>
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