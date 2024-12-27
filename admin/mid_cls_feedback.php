 <!DOCTYPE html>
<html lang="en">


<head>
    <?php 
    
    include('header_link.php');
    include('../config.php');
    include 'database.php';
    $db = new Database();
    ?>
<style type="text/css">
    .rd{
        width: 0.8rem;
    }
    .fdName{
       
        font-size: 0.9rem;
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

              <div class="alert_msg" id="alert_msg" style="margin-left:10%"></div>
            <div class="content" style="margin-top: 50px;">


                <div class="row" style="margin-top:20px">
                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-body">
                                <h3>All Time Table</h3>
                                <div class="row">

                                    <div id="class_tbl" class=" table table-responsive table-striped table-hover"
                                        style="width:95%;margin:0px auto">
                                        <table class=" term table" id="tableid">
                                            <thead class="" style="background: #315682;color:#fff;font-size: 11px;">
                                               
                                                <th >Sl No</th>
                                                <th >Time Table </th>
                                                <th >From Date</th>
                                                <th >To Date</th>
                                                <th >Action</th>


                                            </thead>
                                            <tbody>
                                                <?php
                                              $count = 0;
                                             
                                                $sql = "SELECT *  FROM `tbl_time_table_range` WHERE `program_id` = $prog_id AND type = $trng_type ORDER BY from_dt DESC";

                                              
                                            
                                              //echo $sql ; 

                                               $db->select_sql($sql);
                                               foreach($db->getResult() as $row ){
                                                   
                                                  
                                                   $count++;
                                                   $tbl_range_id = $row['id'];
                                                   ?>
                                                <tr>
                                               
                                                   
                                                     <td><?php echo $count; ?></td>
                                                    <td><?php echo $row['name'] ?> </td>
                                                    <td><?php echo date("d-m-Y", strtotime($row['from_dt']) ) ?></td>
                                                    <td><?php echo date("d-m-Y", strtotime($row['to_dt']) ) ?></td>
                                                   
                                                    
                                                    <td> <button class="btn btn-success btn-sm"
                                                           onclick="datapost('traine_cls_feedback.php',{tbl_range_id: <?php echo $tbl_range_id ?> })"
                                                           >Feedback</button>
                                                    </td>
                                                    
                                                </tr>
                                                <?php
                                               }
                                              ?>
                                            </tbody>
                                        </table>
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

<script>
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