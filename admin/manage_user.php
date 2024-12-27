<?php
    /*Just for your server-side code*/
    header('Content-Type: text/html; charset=ISO-8859-1');
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <?php 
    
    include('header_link.php');
    include('../config.php');
    include 'database.php';
    $db = new Database();
    ?>


 <style type="text/css" media="print">
   
    footer, .sidebar {   
     display: none !important;
    }
    .printbtn{
     display: none !important;
    }
    .finpos_table{
          width: 100% !important;
        }

  @media print {
    .pagebreak { page-break-before: always; } /* page-break-after works, as well */
}

    </style>

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


            <div class="" style="font-size: 14px !important;font-color: black !important;" >
            <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <form id="syllabus">
                               
                            <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>Training Type</strong></label>
                                                <select class="custom-select mr-sm-2" name="traning_type"
                                                    id="traning_type">
                                                    <option selected>Select Type</option>
                                                    <?php 
                                                                    $db = new Database();
                                                                    $count = 0;
                                                                    $db->select('tbl_training_type',"*",null,null,null,null);
                                                                    // print_r( $db->getResult());
                                                                    foreach($db->getResult() as $row){
                                                                        //print_r($row);
                                                                        $count++
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>Program</strong></label>
                                                <select class="custom-select mr-sm-2" name="program_id" id="program_id">
                                                    <option selected>Select Program</option>

                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3 class_room">
                                        <div class="form-group">

                                          <input type="button" class="btn btn-primary" value="view"
                                            style="float: right" onclick="view_trainee()">
                                        </div>
                                           
                                        </div>
                                      

                                    </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                           
                            <div class="card-body" id="">
                            <div id="trainee_list">

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

<script>
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

function view_trainee(){
  var program_id = $('#program_id').val(); 
  var trng_type = $('#traning_type').val();

  $.ajax({
        type: "POST",
        url: "ajax_master.php",
        data: {

            action: "view_trainee",
            trng_type: trng_type,
            program_id:program_id

        },
        success: function(res) {
            console.log(res);
            $('#trainee_list').html(res);

        }
    })
}

 function resetPsw(id){
  const userName = $(`#user_name_${id}`).val();
  const pass = $(`#pass_${id}`).val();

  $.ajax({
        type: "POST",
        url: "ajax_master.php",
        data: {

            action: "reset_password",
            username: userName,
            new_psw:pass

        },
        success: function(res) {
            console.log(res);
            let elm = res.split('#');
            if(elm[0]== "success"){
                // sessionStorage.message = elm[1];
                // sessionStorage.type = "success";
                alert(elm[1]);
                location.reload();
              
            }

        }
    })
 }    
</script>

</html>

