<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Online Exam Management System</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../vendor/parsley/parsley.css"/>

    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap-select/bootstrap-select.min.css"/>

    <link rel="stylesheet" type="text/css" href="../vendor/datepicker/bootstrap-datepicker.css"/>

    <link rel="stylesheet" type="text/css" href="../vendor/datetimepicker/bootstrap-datetimepicker.css"/>
    <link rel="stylesheet" type="text/css" href="../vendor/TimeCircle/TimeCircles.css"/>

     <style>
        @media screen and (max-width: 600px) {
          #webView{
            display: none;
          }
          .mobileView{
            display: block !important;
          }
      }

      @media screen and (min-width: 768px) {
        #webView{
            display: block !important;
          }
          .mobileView{
            display: none;
          }
     }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
              

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <?php
                       // echo($_SESSION['user_type']);
                        $user_name = '';
                        $user_profile_image = '';

                        switch ($_SESSION['user_type']) {
                            case 'Examiner':
                                $object->query = "
                                    SELECT * FROM tbl_faculty_master 
                                    WHERE phone = '".$_SESSION['username']."'
                                    ";
                                $user_result = $object->get_result();
                                //print_r($user_result);
                                foreach($user_result as $row)
                                {
                                    $user_name = $row['name'];
                                    $user_profile_image = $row['image'];
                                }
                                break;
                            case 'Examinee':
                                $object->query = "
                                   SELECT CONCAT(i.first_name,i.last_name)as name,d.photo FROM `tbl_trainee_info` i 
                                   JOIN `tbl_traniee_documents` d ON i.user_id = d.user_id WHERE i.mobile = '".$_SESSION['username']."'
                                    ";
                                $user_result = $object->get_result();
                                //print_r($user_result);
                                foreach($user_result as $row)
                                {
                                    $user_name = $row['name'];
                                    $user_profile_image = "../admin/uploads/".$row['photo'];
                                }
                                break;
                            default:
                                # code...
                                break;
                        }
                        

                       
                        //print_r()
                       
                        // foreach($user_result as $row)
                        // {
                        //     if($row['username'] != '')
                        //     {
                        //         $user_name = $row['name'];
                        //     }
                        //     else
                        //     {
                        //         $user_name = 'Master';
                        //     }

                        //     // if($row['user_profile'] != '') 
                        //     // {
                        //     //     $user_profile_image = $row['user_profile'];
                        //     // }
                        //     // else
                        //     // {
                        //     //     $user_profile_image = '../img/undraw_profile.svg';
                        //     // }
                        //     $user_profile_image = '../img/undraw_profile.svg';
                        // }
                        ?>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="user_profile_name"><?php echo $user_name; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?php echo $object->base_url.$user_profile_image; ?>" id="user_profile_image">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">