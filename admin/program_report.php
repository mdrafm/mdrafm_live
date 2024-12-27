<!DOCTYPE html>
<html lang="en">


<head>
    <?php
    //header("Cache-Control: no cache");
    // session_cache_limiter("private_no_expire");
    include('header_link.php');
    include('../config.php');
    include 'database.php';
 
    //echo 123;
    $db = new Database();
    $prog_name = '';
    $program_table = '';
    
    $trng_type = $_POST['trng_type'];

    if( $trng_type == 1 || $trng_type == 2){
      
       $program_table = 'tbl_program_master';
    }
    elseif($trng_type == 3 || $trng_type == 8){
             
       $program_table = 'tbl_mid_program_master';
    }
    elseif($trng_type == 4 || $trng_type == 5){
      
        $program_table = 'tbl_short_program_master';
    }
    ?>

    <style type="text/css">
        #frm_newTranee {

            width: 60%;
            margin: 0 auto;
            border: 1px solid #cdcdcd;
            padding: 20px;
            border-radius: 10px;
            background-color: #f1fbfd;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }
    </style>

</head>

<body class="user-profile">

    <!-- Google Tag Manager (noscript) -->
    <!-- End Google Tag Manager (noscript) -->

    <div class="wrapper ">

        <?php include('sidebar.php'); ?>

        <div class="main-panel" id="main-panel">
            <?php include('navbar.php'); ?>

            <div class="panel-header panel-header-sm">


            </div>


            <div class="content">

                <div class="row">
                    <div class="col-md-4">
                        <div id="alert_msg" class="alert alert-success">added successfully</div>
                    </div>
                    <div class="col-md-8">
                        <!-- Modal -->
                     
                    </div>
                </div>  
            </div>

        </div>


    </div>

    <?php include('common_script.php') ?>
    

</body>

</html>




    
</script>