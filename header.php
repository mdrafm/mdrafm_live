<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>Madhusudan Das Regional Academy Of Financial Management</title>
    <link rel="icon" href="images/logo.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,700;1,600&family=Roboto:wght@300&display=swap"
        rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="js/bootstrap/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
   

    <!-- <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    /> -->
    <!-- bootstrap5 dataTables css cdn -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" />
    <script src="admin/assets/js/core/jquery.min.js"></script>
    <!-- <script src="js/bootstrap/js/jquery.min.js"></script> -->
    <!--  <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script type="text/javascript" src="js/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- CDN of mark.js -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/mark.min.js"
        integrity=
"sha512-5CYOlHXGh6QpOFA/TeTylKLWfB3ftPsde7AnmhuitiTX4K5SqCLBeKro6sPS8ilsz1Q4NRx3v8Ko2IBiszzdww=="
        crossorigin="anonymous"> -->


    <style type="text/css">
         #imp-links{
    background: #1d4ea8;
}

.link ul li {
    list-style-type: none;
    
}
.link ul li a{
    text-decoration: none;
    color: #fff;
}
    .topnav {
        display: none;
        color: #fff;
    }

    .topnav a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 13px;
        text-decoration: none;
        font-size: 14px;
    }

    .topnav a:hover {
        background-color: #ddd;
        color: black;
    }

    .topnav a.active {
        /* background-color: #04AA6D; */
        color: white;
    }

    .topnav .icon {
        display: none;
    }


    @media screen and (max-width: 600px) {
        .topnav {
            display: block;
        }

        .topnav a:not(:first-child) {
            display: none;
        }

        .topnav a.icon {
            float: right;
            display: block;
        }

        .header-top a h1 {
            font-size: 1.2rem !important;
            margin-top: -15px;
        }

        /* style for navbar */
        #main_nav {
            background-color: #1e4f87;
            position: relative;
            z-index: 11;
        }
        .woners{
            height: 45vh !important;
        }
        .carousel-item{
            height: 15rem;
        }
        .header-buttom {
            flex-direction: column;
            align-items: flex-start;
        }
        .header-buttom .Profile{
            flex-direction: row;
            font-size: 11px;
            margin: 5px;
        }
        .header-buttom .Profile img{
            margin-left: 2rem !important;
            margin: 5px;
        }
        .header-buttom .Profile .desig{
            margin-left: 3rem !important;
        }
        .header-mobile h4{
            font-size: 1rem !important;
        }
         .header-mobile img{
            margin-top: 1rem;
        }
        .dropdown-menu {
            background-color: #2a7f97 !important;
        }

        .submenu {
            background-color: #076557 !important;
        }

        .dropdown-menu li a {
            color: #fff !important;
        }

        .navbar .dropdown-item:hover {
            background-color: #3b4753 !important;
        }

        .info {
            flex-direction: column;
        }

        .info-dtls {
            order:3;
            flex-direction: column-reverse;
            height: 300px !important;
            width: 100%;
        }

        .program {
            margin-left: 0px !important;
        }

        .program-wrap {
            margin-top: 10px;
        }

        .build_img {
            order:2;
           
        }
        .build_img img {
          width: 365px !important;
        }
        .information {
            flex-direction: column;
            height: auto;
        }

        .info-box {
            width: 90%;
        }

        .kabita-wrap{
            background-image: url(images/paper.jpg) !important;
            background-size: cover !important;
        }
        .kabita{
            position: relative;
            left: 10% !important;
            width: 75% !important;
            padding: 20px !important;
            /* width:50%;
            background-image: url(images/ink-pen.jpg);
            background-size: cover; */
        }

    }

    @media screen and (max-width: 600px) {
        .region {
            display: none;
        }

        .topnav.responsive {
            position: relative;
        }

        .topnav.responsive .icon {
            position: absolute;
            right: 0;
            top: 0;
        }

        .topnav.responsive a {
            float: none;
            display: block;
            text-align: left;
        }

        .modal-content {
            width: 500px !important;

        }

        iframe {
            width: 460px;
            height: 300px !important;
        }
    }

    @media (min-width: 992px) {
        .dropdown-menu .dropdown-toggle:after {
            border-top: .3em solid transparent;
            border-right: 0;
            border-bottom: .3em solid transparent;
            border-left: .3em solid;
        }

        .dropdown-menu .dropdown-menu {
            margin-left: 0;
            margin-right: 0;
        }

        .dropdown-menu li {
            position: relative;
        }

        .nav-item .submenu {
            display: none;
            position: absolute;
            left: 100%;
            top: -7px;
        }

        .nav-item .submenu-left {
            right: 100%;
            left: auto;
        }

        .dropdown-menu>li:hover {
            background-color: #f1f1f1
        }

        .dropdown-menu>li:hover>.submenu {
            display: block;
        }
        #main_nav ul li a {
            font-size: 0.8rem;
        }
    }

    .topnav {
        overflow: hidden;
        background-color: #333;
    }

    @media screen and (max-width: 700px) {
        .header {
            height: 260px !important;
            display: none !important;
        }

        .header-wrap {
            display: none !important;
        }
        .header-mobile{
          display: block !important;
        }


        .header-logo {
            float: left;
        }

        .header-logo>a {}

        img.photo {
            clear: both;
            float: none !important;
            margin-left: 20px;
        }

        /*.img3 {
            margin-left: 10px !important;

        }*/

        .woners{
          order:1;
          width: 400px !important;
        }

        /* .header-buttom{
          flex-direction: row;
        } */

        .modal-content {
            width: 100% !important;
            margin: 20px 0px !important;

        }
    }
    .galary{
        background-color: #dbddf1;
        padding:80px 0;
    }
    .galary-item{
        background-color: #fff;
        padding:15px;
        width: 100%;
        box-shadow: 0 0 15px rgba(0,0,0,0.3);
        cursor:pointer;
    }
    #gallery-modal .modal-img{
        width: 100%;
    }
    #search{
    border: 1px solid gray;
    user-select: auto;
    /* background-image: url(images/search11.jpg); */
    /* background: linear-gradient(90deg, rgb(30 79 135) 0%, rgb(149 78 30 / 54%) 83%);; */
    background-color: #44aa56;
                
    width: 95%;
    margin: 30px;
    padding: 20px;
    border-radius: 5px;
    box-shadow: rgb(0 0 0 / 16%) 0px 3px 6px, rgb(0 0 0 / 23%) 0px 3px 6px;
    }
    #tbl_circular{
    width: 95%;
    margin: 30px;
    padding: 20px;
    border-radius: 5px;
    box-shadow: rgb(0 0 0 / 16%) 0px 3px 6px, rgb(0 0 0 / 23%) 0px 3px 6px;
    }
    .dept{
    border: 1px solid gray;
    border-radius: 5px;
    padding: 3px;
    background: #2a7652;
    }
    .dept a{
    text-decoration: none;
    color: #f6f6f6;
    }
    .link-container{
    background-color: #243673;
    padding: 20px 
    }

    .other-link h3{
        text-align: left;
    background: none;
    font-family: auto;
    }
    .list ul {
        padding-left: 15px;
        margin-bottom: 0;
    }
    .list ul li{
        list-style-type: none;
        margin-bottom: 10px;
    }
    .list ul li a{
        color: #ffffff;
        text-decoration: none;
    -webkit-transition: all ease 0.5s;
    transition: all ease 0.5s;
    font-family: emoji;
    font-size: 1.3rem;

    }
    .list ul li a:hover{
        color: #f9f9f8;
        padding: 5px;
        background: #a67030;
    
    }
    .contact{
    font-weight: 600;
    font-family: monospace;
    font-size: 1.2rem;
    color: #4e4854;
}
.contact span{
    font-size: 1.1rem;
}

/* Slide captions */
    .swiper-slide img {
      display: block;
      width: 100%;
      height: 90%;
      /* object-fit: cover; */
    }
.slide-captions {
    position: absolute;
    top: 90%;
    left: 15%;
    color: #fff;
    z-index: 999;
    transform: translateY(-50%);
}
.slide-captions .current-title {
    font-size: 28px;
}
.kabita{
    position: relative;
    left: 130%;
    width: 40%;
    padding: 20px;
    /* width:50%;
    background-image: url(images/ink-pen.jpg);
    background-size: cover; */
}
.kabita h4{
    text-align: center;
    text-decoration: underline;
}
.kabita .desc{
    font-size: 20px;
    text-align: justify;
}
.kabita-wrap{
    background-image: url(images/kabita_bg.jpg);
    background-size: cover;
}

/*design hero section */
  
  #hero{
    height: 80vh;
  }
.woners{
    background-image: url('images/istock.jpg');
    height:72vh
}
@media screen and (min-width: 768px) {
    #hero{
    height: 84vh;

    }

    .woners{
        height: 55vh;
    }
   }

   @media screen and (min-width: 1900px) {
    #hero{
    height: 60vh;

    }

    .woners{
        height: 55vh;
    }
   }
    </style>

</head>

<body>

    <section class="header" style="display: block;height:140px;background-color: #fff;">
        <div class="header-wrap d-flex justify-content-between">
            <div class="header-logo logo">
              
                <img src="images/madhu_babu.png" style="height:120px;width: 110px; margin-left: 10px; ">
                <!--  <img src="images/odisha_logo.png" style="height:130px;width: 140px; margin-left: 5px;"> -->
            </div>

            <div class="header-top top d-flex">
                <div class="header-logo logo" style="margin-top: -10px;">
                  
                    <img src="images/logo-Copy.png" style="height:120px;">
                </div>
                <div class="container" style="padding-top:5px;padding-bottom:5px;">

                    <div class=""><br>
                        <a href="index-2.html" style="text-decoration: azure;">
                            <h1 style="font-size: 1.5rem;font-family: serif;user-select: auto;font-weight:bold;color:#2551b5">ମଧୁସୂଦନ ଦାସ ଆଞ୍ଚଳିକ ବିତ୍ତୀୟ ପରିଚାଳନା ପ୍ରତିଷ୍ଠାନ, ଭୁବନେଶ୍ବର</h1>
                            <h1
                                style="font-size: 1.5rem;font-family: serif;user-select: auto;font-weight:bold;color:#2551b5">
                                Madhusudan Das
                                Regional Academy of Financial Management, Bhubaneswar</h1> 
                        </a>
                    </div>

                </div>
            </div>
            <div class="header-logo logo d-flex cm">
             
                <!-- <div style="user-select: auto;margin: auto 5px;margin-top: 75px;">
                    <a class="float-left" href="" title="Shri Naveen Patnaik"
                        style=" font-size: 16px; color: #010101;margin-top: 30px;line-height: 21px;text-decoration: none;">
                        Shri Mohan Charan Majhi <br style="user-select: auto;">
                        <span style="font-size: 13px;user-select: auto;">Hon'ble Chief Minister</span></a>
                </div> -->
                <div>
                    <img src="images/cms.png" style="height:140px;margin-right:10px">

                </div>


            </div>

        </div>
        
    </section>

    <section  class="header-mobile" style="display: none;height:30%;background-color: #fff;">
      <div class="header-img d-flex" >
          <!-- <div class="header-logo logo">
              
              <img src="images/madhu_babu.png" style="height:80px;margin-left: 10px;">
          </div> -->
          <div class="header-logo logo d-flex cm" style="margin-left: 23%;">
             
               <!--  <div style="user-select: auto;margin: auto 0px;">
                    <a class="float-left" href="" title="Shri Naveen Patnaik"
                        style=" font-size: 12px; color: #010101;text-decoration: none;">
                        Shri Naveen Patnaik <br style="user-select: auto;">
                        <span style="font-size: 10px;user-select: auto;">Hon'ble Chief Minister</span></a>
                </div>
                <div>
                    <img src="images/cm.png" style="height:80px;margin-right:10px">
                </div>
 -->

          </div>
      </div>
      <div class="header-title">
        <div class="header-top top d-flex">
                  <div class="header-logo logo" >
                    
                      <img src="images/logo-Copy.png" style="height:80px;">
                  </div>
                  <div class="container" >

                      <div class=""><br>
                           <a href="index-2.html" style="text-decoration: azure;">
                            <h4 style="font-size: 1.5rem;font-family: serif;user-select: auto;font-weight:bold;color:#2551b5">ମଧୁସୂଦନ ଦାସ ଆଞ୍ଚଳିକ ବିତ୍ତୀୟ ପରିଚାଳନା ପ୍ରତିଷ୍ଠାନ, ଭୁବନେଶ୍ବର</h4>
                            <h4
                                style="font-size: 1.5rem;font-family: serif;user-select: auto;font-weight:bold;color:#2551b5">
                                Madhusudan Das
                                Regional Academy of Financial Management, Bhubaneswar</h4>
                        </a>
                      </div>

                  </div>
              </div>
        </div>
    </section>
   <!--  <section style="display:block" >
        <div style="margin-left: 16%;" >
            <img src="images/slider/odia_bhasa_samilani.jpg" 
                    style="width:60vw;height:40vh;" alt="">
        </div>
    </section> -->