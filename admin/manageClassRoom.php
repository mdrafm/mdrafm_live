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
                                <h4 class="card-title"> Class Rooms & Auditorioum</h4>

                            </div>
                            <div class="card-body">
                                <?php
                                $db->select('tbl_class_room_master', "*", null, "status = 1 ", 'id', null); 
                                foreach ($db->getResult() as $row) {
                                ?>
                                    <div class="row room_div">
                                        <div class="col-md-4">
                                            <div class="image-wrap">
                                                <img src="../images/trainning_hall/<?php echo $row['image'] ?>" alt="">
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
                                                        <div class="col-md-12 class-name" ><?php echo $row['name'] ?></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    
                                                    <div class="col-md-12">
                                                        <p class="seat">Seating arrangements for <?php echo $row['capacity'] ?> participants</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-1 rent">
                                                            <label for="">Rent:</label>
                                                        </div>
                                                        <?php
                                                           $rents = explode(',',$row['rent']);
                                                           foreach($rents as $rent){
                                                            $db->select('tb_rent_master', "*", null, "id =".$rent, null, null);
                                                            foreach ($db->getResult() as $row2) {
                                                              ?>
                                                                <div class="col-md-8" > <p class="price"><span>₹</span> <?php echo $row2['price'] ?></p> </div>
                                                              <?php
                                                            }
                                                           }

                                                          
                                                        ?>
                                                        
                                                </div>
                                                <div class="row">
                                                <input type="button" class="btn " style="background:#3292a2"
                                                            name="send"
                                                            onclick="datapost('show_class_room_booking_details.php',{id: <?php echo $row['id'] ?> })"
                                                            value="Booking Details" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="facilities">
                                                    <p>Facilities</p>
                                                    <!-- <hr> -->
                                                        <?php
                                                          $features = explode(',',$row['facility']);
                                                          foreach($features as $feature) {
                                                            $db->select('tbl_ficility_master', "name", null, "id =".$feature, null, null);
                                                           foreach ($db->getResult() as $row3) {
                                                              
                                                               ?>
                                                                 <ul>
                                                                    <li><?php echo $row3['name']; ?></li>
                                                                 </ul>
                                                               <?php
                                                           }

                                                          }  
                                                        ?>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                            
                        <?php
                                    //exit;
                                }
                        ?>

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