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
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="wrapper ">

        <?php include('sidebar.php'); ?>

        <div class="main-panel" id="main-panel">
            <?php include('navbar.php'); ?>

            <div class="panel-header panel-header-sm">


            </div>


            <div class="content" style="margin-top: 50px;">


                <div class="row">
                    <div class="col-md-12">
                   
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="card-title">Image Gallery  </h4>
                                    </div>

                                </div>


                            </div>
                            <div class="card-body">
                            <form id="program" method="post" enctype="multipart/form-data">
                                <div class="row" style="margin-top:20px;">
                                   <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-md-3" style="text-align: center;">
                                                <label style="text-align:center"><strong>Image Title</strong></label>
                                            </div>
                                            <div class="col-md-4">
                                               <!-- <input type="text" class="form-control" name='title' placeholder="Enter Title" /> -->
                                               <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" rows="2" 
                                               style="border: 1px solid rgb(79 67 67);border-radius:5px;"/>
                                            </div>
                                        </div>
                                    </div>
                                 <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-md-3" style="text-align: center;">
                                                <label style="padding: 25px;"><strong>Upload Photo</strong></label>
                                            </div>
                                            <div class="col-md-7">
                                                  <div class="col-md-6" style="">
                                                        <div class="row">
                                                            <input type="file" name="img_glry" id="img_glry" class="form-control"
                                                            style="opacity: 1;position: unset;height: 85%;border-radius: 5px;">
                                                        </div>
                                                    
                                                    </div>
                                                
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        <input type="button" class="btn btn-primary" id="save" value="Add" 
                                        onclick="upload_image()"
                                        style="margin-top: 0px" />
                                    </div>
                                </div>
                               
                                </form>
                                <input type="hidden" name="update_id" id="update_id" />
                            </div>
                        </div>
                       
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                           
                            <div class="card-body">
                            <div id="term2" class=" table table-responsive table-striped table-hover" style="width:85%;margin:0px auto" >
                                    <table class=" term table">
                                        <thead class="" style="background: #315682;color:#fff;font-size: 11px;">

                                            <th style="text-align:center;">Sl No</th>
                                            <th style="text-align:center;">Title</th>
                                            <th style="text-align:center;">Image</th>
                                            <th style="text-align:center;">Action</th>
                                        </thead>
                                        <tbody>
                                            <?php 
                               
                              
                               $count = 0;
                               $db->select('tbl_image_gallery',"*",null,null,null,null);
                              // print_r( $db->getResult());
                               foreach($db->getResult() as $row){
                                if($row['status'] =='1')
                                {
                                    $status='Active';
                                    $cls= 'btn-success';
                                }else
                                {
                                    $status='Inactive';
                                    $cls= 'btn-danger';
                                }
                                   //print_r($row);
                                   $count++
                                   ?>
                                            <tr>
                                                <td style="text-align:center;"><?php echo $count; ?></td>
                                                <td style="text-align:center;"><?php echo $row['img_title'] ?></td>
                                                <td style="text-align:center"><img src="../images/galary/<?=isset($row['image'])?$row['image']:''?>"
                                                width="120" height="100"></td>
                                                <td style="text-align:center;">
                                                <input type="button" id="active_<?=$row['id']?>" class="btn  <?=$cls?>" value="<?=$status?>" onclick="active_inactive_status(<?=$row['id']?>)"/>
                                   

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
    <?php include('common_script.php') ?>

</body>

</html>

<script type="text/javascript">
    function upload_image() {
    var update_id = $('#update_id').val();
    var desc_file = $('#img_glry')[0].files;
    var title = $('#title').val();
     //console.log(title);
     console.log(desc_file[0]);

    var fd = new FormData();
    fd.append('file',desc_file[0]);
    fd.append('action','upload_gallery_image');
    fd.append('title',title);
    fd.append('update_id',update_id);
    fd.append('tbl','tbl_image_gallery');
    //form_data.append("file", document.getElementById('descr_doc').files[0]);
    //form_data.append("action", "upload_ppt_doc");
    //console.log(fd);
    $.ajax({
        type: "POST",
        url: "ajax_otherProgram.php",
        data: fd,
        contentType: false,
              processData: false,
        success: function(res) {
            console.log(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                sessionStorage.message = "Image uploaded successfully";
                sessionStorage.type = "success";
                location.reload();
            }
        }
    })

    }

    function active_inactive_status(data) {
    var update_id=data;
    var status_chk = $('#active_'+update_id).val();
    if(status_chk == 'Active')
    {
       var status='2';
    }
    else 
    {
        var status='1';
    }
    $.ajax({
        type: "POST",
        url: "ajax_otherProgram.php",
        data: {
            action: "active_inactive_status",
            update_id: update_id,
            status: status,
            table: "tbl_image_gallery",
        },

        success: function(res) {
          // alert(res);
            let elm = res.split('#');
            if (elm[0] == "success") {
                sessionStorage.message = "Image inactivated successfully";
                sessionStorage.type = "error";
                setTimeout(function(){
                    window.location.reload(1);
                    }, 1000);
					showMessage();
            }


        }
    })
   
}
//$('#active_'+update_id).val() == "Active" ? active_int(update_id) : inactive_int(update_id);
// function active_int(update_id) {
//    // alert(update_id);
//         $('#active_'+update_id).val("Inactive");
//         $('#active_'+update_id).removeClass("btn-success");
//         $('#active_'+update_id).addClass("btn-danger");

//         // do play
//         }
//  function inactive_int(update_id) {
//    // alert(update_id);
//         $('#active_'+update_id).val("Active");
//         $('#active_'+update_id).removeClass("btn-danger");
//         $('#active_'+update_id).addClass("btn-success");
//         // do pause
//         }

</script>