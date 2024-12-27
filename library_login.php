<?php //include('header.php') 
?>
<?php //include('nav_bar.php') 
?>
<?php

include 'admin/database.php';
session_start();
$db = new Database();
$err = '';
if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    //echo gettype($username);
    $db_pass = '';
    $db->select('tbl_user', "id,username,name,password,roll_id,status", null, 'username =' . "'$username'", null, null);
    $res = $db->getResult();
    foreach ($res as $row) {
        $db_pass = $row['password'];
        if ($row['status'] == 0) {
            $err = "Inactive User";
        } else {
            if ($db_pass !== false) {
                $validPassword = password_verify($password, $db_pass);
                if ($validPassword) {

                    $_SESSION['user_id'] =  $row['id'];
                    $_SESSION['username'] =  $row['username'];
                    $_SESSION['roll_id'] = $row['roll_id'];
                    $name =  $row['name'];
                    $roll_id =  $row['roll_id'];

                    if (($row['roll_id'] == 5) || ($row['roll_id'] == 15)) {

                        $db->select_one('tbl_user', 'name', $row['id']);
                        foreach ($db->getResult() as $librarian) {
                            $_SESSION['name'] =  $librarian['name'];
                        }
                    } else {
                        $_SESSION['name'] =  $name;
                        $_SESSION['roll_id'] =  $roll_id;
                    }
                    //print_r($_SESSION);exit;
                    //echo "hello";exit;
                    header('location:library_master/index.php');
                } else {
                    //echo 'not valid';
                    $err = "Invalid Password!!";
                }
            }
        }
    }
}

?>
<?php
$db->select('tbl_book_details', "*", null, 'status=0', null, null);
$res_book = $db->getResult();
$book_list = array();
$author_list = array();
foreach ($res_book as $res) {
    $book_name = $res['book_name'];
    $author_name = $res['author_name'];
    array_push($book_list, $book_name);
    array_push($author_list, $author_name);
}
$db->select('tbl_book_type', "*", null, null, null, null);
$res_subject = $db->getResult();
//print_r($res_location);
?>
<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/logn.css">
    <link rel="stylesheet" href="library_master/assets/css/manual_css.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        @media screen and (max-width: 600px) {
            .logo {
                padding-left: 1px !important;
                margin-bottom: 1px !important;
            }

            .logo p {
                padding-left: 8px !important;
                font-size: 22px !important;
            }

            .container-fluid {
                width: 95% !important;
                padding: 0px 0px 0px 0px !important;
            }

            .wrap img {
                width: 100% !important;
                margin-left: -15px;
            }

            .login-wrap {
                margin-left: -8px !important;
                width: 88% !important;
            }
        }

        body {
            background-image: url('library/lib_img.jpg');
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
        }

        input[type="book_name"]::-ms-input-placeholder {
            text-align: center;
        }
    </style>
</head>

<body background_ima="">
    <section class="ftco-section">
        <div class="">
            <div class="logo" style="display: flex;margin-bottom:10px ;padding-left: 115px;">
                <div class="">
                    <p class="social-media d-flex justify-content-end">

                        <a href="index.php" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-home"></span></a>
                    </p>
                </div>
                <div class="">
                    <img src="images/lg1.png" style="height:120px;width:120px;">
                </div>
                <div>
                    <span style="font-weight:600;font-size:40px;color:black;padding-top: 5%;;padding-left: 20px;font-family: ui-serif;color:#25d1a8;line-height: 120px;">
                        Library Management System</span>
                </div>

            </div>

            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="row">
                        <div class="input-group mb-4" style="margin-top:1%">
                            <input class="form-control" type="search" name="book_name" id="book_name" placeholder="Book Name (A-Z)" required style="border-bottom: 2px solid #198754;border-top: 2px solid #198754;border-left: 2px solid #198754;">
                            <input class="form-control" type="search" name="auth_name" id="auth_name" placeholder="Author Name (A-Z)" required style="border-bottom: 2px solid #198754;border-top: 2px solid #198754;">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit" onclick="get_book_details()">SEARCH</button>
                            </div>
                            <small></small>
                        </div>

                        <div class="alert alert-info alert-dismissible fade show col-lg-11" id="show_div" style="display:none;position:absolute;z-index:9;margin-top:4%;margin-left:4%">
                            <strong id="tbl_case_law">
                            </strong>
                            <button type="button" class="btn-close case_law"></button>
                        </div>
                        <div class="wrap d-md-flex" style="background: #ffffff9f;padding: 2px;">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <center>
                                            <h4 style="font-size:15px;font-weight: 600;padding-top:10px;">SUBSCRIBED E-RESOURCES</h4><img src="library/line.png" style="height: 2px; width: 60px;margin-top: -35px">
                                        </center>
                                        <div class="row">
                                            <!-- <div class="col-md-6">
                                                <p style="text-align-last: center;">
                                                    <a href="https://www.taxmann.com/auth/login"> <img src="library/taxmann.png" style="height: 50px;margin-top: -15px"> </a>
                                                </p> <br>
                                            </div> -->
                                            <div class="col-md-12">
                                                <p style="text-align-last: center;">
                                                    <a href="https://mcgrawhillindia.vitalsource.com/#/explore"><img src="images/ipc_logo.png" style="height: 50px;margin-top: -15px"> </a>
                                                </p> <br>
                                            </div>
                                            <!-- <div class="col-md-3">
                                                <p style="text-align-last: center;">
                                                    <a href="https://www.epwrfits.in/Main_screen.aspx?userfeedback=true"><img src="library/epwrf.jpg" style="height: 40px;margin-top: -15px;width:155%"> </a>
                                                </p> <br>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 pd0" style="margin-top: -30px">
                                        <center>
                                            <h4 style="font-size:15px;font-weight: 600"> OPEN E-RESOURCES </h4><img src="library/line.png" style="height: 2px; width: 60px;margin-top: -30px">
                                        </center>
                                        <div class="row" style="margin-left: 1%;">
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="https://dbie.rbi.org.in/"> <img class="lom" src="library/RBI%20LOGO%20Final.png" style="height: 46px"></a>
                                            </div>
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"> <a href="https://finance.odisha.gov.in/financial-notification" style="text-decoration: none;"> <img class="lom" src="images/odisha_logo.png" style="height: 30px"><b>FD Notification</b></a>
                                            </div>
                                             <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"> <a href="https://ga.odisha.gov.in/notification/gapg-all-notifications" style="text-decoration :none;"><img class="lom" src="images/odisha_logo.png" style="height: 30px"><b style="color:blue">GA Notification</b></a>
                                            </div>
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"> <a href="https://www.india.gov.in/"> <img class="lom" src="library/logo_1.png" style="height: 48px"></a>
                                            </div>
                                            
                                        </div>
                                        <div class="row" style="margin-left: 1%;line-height: 3rem;">
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="https://www.sebi.gov.in/"> <img class="lom" src="library/sebi11.png" style="height: 30px;width: 80%"></a>
                                            </div>
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="https://www.bseindia.com/"> <img class="lom" src="library/bse.png" style="height: 46px"></a>
                                            </div>
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="https://www.nseindia.com/"> <img class="lom" src="library/NSE.svg" style="height: 46px"></a>
                                            </div>
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="https://www.nism.ac.in/"> <img class="lom" src="library/nism.png" style="height: 25px"></a>
                                            </div>
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="https://pfrda.org.in/"> <img class="lom" src="library/pfrda.png" style="height: 30px"></a>
                                            </div>
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="http://niti.gov.in/"> <img class="lom1" src="library/niti.png" style="height: 50px"></a>
                                            </div>
                                            <!-- <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="https://data.worldbank.org/"> <img class="lom" src="library/worldbank.svg" style="height: 35px"></a>
                                            </div> -->
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="https://www.imf.org/en/data"> <img src="library/imflogo.png" class="lom" style="height: 40px; "></a>
                                            </div>
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="https://core.ac.uk/"> <img class="lom" src="library/core.png" style="height: 46px"></a>
                                            </div>
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="https://doaj.org/"> <img class="lom" src="library/doaj.png" style="height: 40px"></a>
                                            </div>
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"> <a href="https://data.gov.in/"> <img class="lom" src="library/logo.png" style="height: 45px;background-color: #85be00"></a>
                                            </div>
                                             <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="http://iipmpublications.com/"> <img class="lom" src="library/logo-iipm.jpg" style="height: 46px"></a>
                                            </div>
                                           <!--  <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="http://asci.org.in/index.php/publications/asci-journal-of-management#previous-issues"> <img class="lom" src="library/logojune22.png" style="height: 30px;  "></a>
                                            </div> -->
                                            <div class="col-md-3 pd0">
                                                <img src="library/arrow.png" id="er" style="height: 20px"><a href="https://cmie.com/"> <img class="lom" src="library/cmie1.png" style="height: 30px"></a>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>

                               
                                <!--div complete-->
                            </div>
                            <div class="col-md-3" style="background-image: url(library/login_bg.jpg);background-repeat: no-repeat;">
                                <p id="alert_msg" style="width: 70%; margin-left: 10%;color:#fff;background-color: #59ac60;"></p>

                                <div class="login-wrap" style="margin: 0 auto;">
                                    <div class="d-flex">
                                        <div class="w-100">
                                            <h3 class="mb-4" style="padding-top:3px;text-align:center">Sign In</h3>
                                        </div>
                                    </div>
                                    <form action="#" class="signin-form" method="post">
                                        <div class="form-group mb-3">
                                            <label class="label" for="name">User Id</label>
                                            <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="label" for="password">Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
                                            <br>
                                            <p class="text-danger"><?php echo ($err != '') ? $err : ''; ?></p>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" name="submit" class="form-control rounded submit ml-3 px-3" style="background-color:#22ac8b;color:#fff">Sign In</button>
                                        </div>
                                        <div class="form-group">
                                            <div class="w-20 text-left">

                                            </div>
                                            <div class="w-80 text-md-right ">
                                                <a class="text-danger" href="forget_password.php">Forgot Password</a>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- <p class="text-center">Not a member? <a data-toggle="tab" href="register.php">Sign Up</a> -->
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="row" style="margin-top:1%;background-color: #09777cfa;margin-left: 1px;border-bottom-left-radius: 15px;border-bottom-right-radius: 15px;">
                                            <div class="col-md-2 pd0">
                                            <a href="https://sambadepaper.com/"><img src="images/news_paper/sambad-logo.png" width="150" height="" style="margin-top: 3%;"></a>
                                            </div>
                                            <div class="col-md-2 pd0">
                                            <a href="https://dharitriepaper.in/"><img src="images/news_paper/dharitri.png" width="150" height="" style="margin-top: 3%;"></a>
                                            </div>
                                            <div class="col-md-2 pd0">
                                            <a href="https://economictimes.indiatimes.com/"> <img src="images/news_paper/etms.png" width="150" height="70"></a>
                                            </div>
                                            <div class="col-md-2 pd0">
                                                <a href="https://epaper.thehindu.com/login"> <img src="images/news_paper/hind.png" width="150" height=""></a>
                                            </div>
                                            <div class="col-md-2 pd0">
                                                <a href="https://www.afr.com/"> <img src="images/news_paper/abc.png" width="150" height="90" ></a>
                                            </div>
                                            <div class="col-md-2 pd0">
                                                <a href="https://www.washingtonpost.com/"> <img src="images/news_paper/wtp.png" width="150" height="40" style="margin-top: 14%;"></a>
                                            </div>
                                        </div>

                    </div>
                </div>
            </div>

            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container" style="background-color: ;">
                            <div class="row" style="margin-top:1%;padding:5px">
                                <div class="col-sm">
                                    <img src="images/cover_photo/Abdul kalam a life.jpeg" width="150" height="150" style="margin-top: 5%;">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/godhulira bagha.jpg" width="150" height="150" style="margin-top: 5%;">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/target 3 billion.jpg" width="150" height="150" style="margin-top: 5%;">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/beyond 2020.jpeg" width="150" height="160" style="">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/Adina barsha.jpg" width="150" height="160" style="">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/President.jpg" width="150" height="160">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                    <div class="container" style="background-color: ;">
                            <div class="row" style="margin-top:1%;padding:5px">
                                <div class="col-sm">
                                    <img src="images/cover_photo/the monk who sold his ferrari.jpg" width="150" height="150" style="margin-top: 5%;">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/Rich dad poor dad.jpeg" width="150" height="150" style="margin-top: 5%;">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/Kashi secret of the black tremple.jpeg" width="150" height="150" style="margin-top: 5%;">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/gajapati.jpg" width="150" height="160" style="">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/Adina barsha.jpg" width="150" height="160" style="">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/President.jpg" width="150" height="160">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                    <div class="container" style="background-color: ;">
                            <div class="row" style="margin-top:1%;padding:5px">
                                <div class="col-sm">
                                    <img src="images/cover_photo/Girl in room no 105.jpeg" width="150" height="150" style="margin-top: 5%;">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/vission india.jpeg" width="150" height="150" style="margin-top: 5%;">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/janyaseni.jpg" width="150" height="150" style="margin-top: 5%;">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/Love knows no loc.jpeg" width="150" height="160" style="">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/mamu.jpg" width="150" height="160" style="">
                                </div>
                                <div class="col-sm">
                                    <img src="images/cover_photo/Vikram sarabhai.jpg" width="150" height="160">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
            </div>
            
    </section>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        showMessage();

        function showMessage() {
            if (sessionStorage.type == "success") {
                console.log(123);
                $('#alert_msg').show();
                //$('#btn_records_mtnc').show();
                $("#alert_msg").addClass("alert alert-success").html(sessionStorage.message);
                closeAlertBox();

                sessionStorage.removeItem("message");
                sessionStorage.removeItem("type");
            }
            if (sessionStorage.type == "error") {
                $('#alert_msg').show();
                $("#alert_msg").addClass("alert ").html(sessionStorage.message);
                closeAlertBox();
                sessionStorage.removeItem("message");
                sessionStorage.removeItem("type");
            }

        }

        function closeAlertBox() {
            window.setTimeout(function() {
                $("#alert_msg").fadeOut(300)
            }, 3000);
        }
    </script>
</body>

</html>
<script>
    function get_book_details() {

        var book_name = $('#book_name').val();
        var author_name = $('#auth_name').val();
        $.ajax({
            method: "POST",
            url: "library_search.php",
            data: {
                'book_name': book_name,
                'author_name': author_name
            },
            // beforeSend: function(){
            // $('.loader').show();
            //  $('#send_email').prop('disabled', true);
            // },
            success: function(res) {
                console.log(res);
                $('#show_div').css("display", "block");
                $('#tbl_case_law').html(res);
                //$('#case_law').DataTable();
                // $('.loader').hide();
                //update();
                //$('#detailsModal_27').modal('hide');

            }
        })
    }
    $(".case_law").click(function() {
        $('#show_div').css("display", "none");
    });
    //Autocomplete
    let book_list = <?php echo json_encode($book_list) ?>;
    let author_list = <?php echo json_encode($author_list) ?>;
    console.log(book_list);
    console.log(author_list);

    function autocomplete(searchEle, arr) {
        var currentFocus;
        searchEle.addEventListener("input", function(e) {
            var divCreate,
                b,
                i,
                fieldVal = this.value;
            closeAllLists();
            if (!fieldVal) {
                return false;
            }
            currentFocus = -1;
            divCreate = document.createElement("DIV");
            divCreate.setAttribute("id", this.id + "autocomplete-list");
            divCreate.setAttribute("class", "autocomplete-items");
            this.parentNode.appendChild(divCreate);
            for (i = 0; i < arr.length; i++) {
                if (arr[i].substr(0, fieldVal.length).toUpperCase() == fieldVal.toUpperCase()) {
                    b = document.createElement("DIV");
                    b.innerHTML = "<strong>" + arr[i].substr(0, fieldVal.length) + "</strong>";
                    b.innerHTML += arr[i].substr(fieldVal.length);
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    b.addEventListener("click", function(e) {
                        searchEle.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                    divCreate.appendChild(b);
                }
            }
        });
        searchEle.addEventListener("keydown", function(e) {
            var autocompleteList = document.getElementById(
                this.id + "autocomplete-list"
            );
            if (autocompleteList)
                autocompleteList = autocompleteList.getElementsByTagName("div");
            if (e.keyCode == 40) {
                currentFocus++;
                addActive(autocompleteList);
            } else if (e.keyCode == 38) {
                //up
                currentFocus--;
                addActive(autocompleteList);
            } else if (e.keyCode == 13) {
                e.preventDefault();
                if (currentFocus > -1) {
                    if (autocompleteList) autocompleteList[currentFocus].click();
                }
            }
        });

        function addActive(autocompleteList) {
            if (!autocompleteList) return false;
            removeActive(autocompleteList);
            if (currentFocus >= autocompleteList.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = autocompleteList.length - 1;
            autocompleteList[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(autocompleteList) {
            for (var i = 0; i < autocompleteList.length; i++) {
                autocompleteList[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            var autocompleteList = document.getElementsByClassName(
                "autocomplete-items"
            );
            for (var i = 0; i < autocompleteList.length; i++) {
                if (elmnt != autocompleteList[i] && elmnt != searchEle) {
                    autocompleteList[i].parentNode.removeChild(autocompleteList[i]);
                }
            }
        }
        document.addEventListener("click", function(e) {
            closeAllLists(e.target);
        });
    }
    autocomplete(document.getElementById("book_name"), book_list);
    autocomplete(document.getElementById("auth_name"), author_list);
</script>