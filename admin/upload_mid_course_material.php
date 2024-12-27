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


            <div class="content">

            <?php 
           
                                        $program_name = '';
                                        $trng_type = 0;
                                        $db->select("tbl_mid_program_master","*",null,"id = '".$_POST['program_id']."' ",null,null );
                                        foreach ($db->getResult() as $row) {
                                            $program_name = $row['prg_name'];
                                        }

                                    ?>
                <div class="row" style="margin-top:50px"> 
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Upload Study Material</h5>
                                <p style="font-weight: 700;" >Program Name : <?php echo $program_name; ?></p>
                            </div>
                            <div class="card-body">
                              
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-body">

                                <div class="row p-2">
                                    <div class="col-md-5" style="box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;">
                                        <div class="row align-items-center" style="background: #3a6285;color: #fff;" >
    
                                            <div class="col-md-9">Available Course Materials</div>
                                            <div class="col-md-3">
                                                <button class="btn btn-primary btn-sm" onclick="addMaterial()" >Add</button>
                                            </div>
                                        </div>

                                        <div id="left" style="height: 70vh;">

                                      
                                            <?php
                                               $db->select_sql("SELECT * FROM `tbl_mid_course_material_master` WHERE flag = 3 AND id NOT IN(SELECT cousrse_material_id FROM `tbl_mid_course_material` WHERE program_id = '".$_POST['program_id']."')");
                                               foreach ($db->getResult() as $row) {
                                                  ?>
                                                    <div class="row material"  draggable="true" style="
                                                                            margin: 5px;
                                                                            cursor: pointer;
                                                                            background-color: #f1f3f7;">
                                                        <div class="col-md-5"><?php echo $row['subject'] ?></div>
                                                        <div class="col-md-5"><?php echo $row['faculty_name'] ?></div>
                                                        <div class="col-md-2">
                                                            <a  href=<?php echo '/admin/course_material/misc/'. $row['file_name'] ?> target="_blank" >  view</a>&nbsp;&nbsp;&nbsp;
                                                            
                                                            <a href="#" onclick="remove(<?php echo $row['id'] ?>,'<?php echo $row['file_name'] ?>')" > <img src="../images/cross.png" alt="cross"> </a>
                                                        </div>
                                                        <input type="hidden" class="doc_id" value="<?php echo $row['id'] ?>" />
                                                    </div>
                                                  <?php
                                               }
                                            ?>
                                        
                                        </div>
                                    </div>
                                    <div class="col-md-5" style="box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;;margin-left: 55px;">
                                    <div class="row align-items-center" style="background: #3a6285;color: #fff;" >
    
                                        <div class="col-md-9" style="padding: 12px;" >Drag & Drop Course Materials Here to Add </div>
                                       
                                    </div>
                                        <div id="right" style="height: 70vh; ">
                                        <?php
                                               $db->select_sql("SELECT m.cousrse_material_id,c.subject,c.faculty_name,c.file_name,c.status  FROM `tbl_mid_course_material` m 
                                                                JOIN `tbl_mid_course_material_master` c ON m.cousrse_material_id = c.id
                                                                WHERE m.program_id = '".$_POST['program_id']."' ");
                                               foreach ($db->getResult() as $row2) {

                                                  ?>
                                                    <div class="row material"  draggable="true" style="
                                                                            margin: 5px;
                                                                            cursor: pointer;
                                                                            background-color: #f1f3f7;">
                                                        <div class="col-md-5"><?php echo $row2['subject'] ?></div>
                                                        <div class="col-md-5"><?php echo $row2['faculty_name'] ?></div>
                                                        <div class="col-md-2">
                                                            <a href=<?php echo '/admin/course_material/misc/'. $row2['file_name'] ?> >view</a>
                                                           
                                                        </div>
                                                        <input type="hidden" class="doc_id" value="<?php echo $row2['cousrse_material_id'] ?>" />
                                                        
                                                    </div>
                                                  <?php
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

    </div>

    </div>

    </div>

    <!-- msgBox Modal Modal HTML -->
    <div id="addMaterialModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content" style="width:160%; margin:120px -60px">
                <form id="attandance">
                    <div class="modal-header">
                        <h5 class="modal-title" id="m_title" style="text-align:center;">Upload Course Material </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                           <div class="col-md-6">
                               <label>Subajec Name</label>
                               <input type="text" name="subject" class="form-control" id="subject">
                            </div>
                            <div class="col-md-6" >
                            <label>Faculty Name</label>
                            <input type="text" name="facultyName" class="form-control" id="facultyName">
                            </div>
                            <div class="col-md-6">
                                <input type="file" name="doc_id" id="doc_id" class="form-control"
                                    style="opacity: 1;position: unset;height: 85%;border-radius: 5px;">
                            </div>
                            
                        </div>
                    

                    </div>
                    <div class="modal-footer" id="mailbtn">
                        <input type="button" class="btn btn-success" value="Upload" id="upload_misc" onclick="upload_doc()" />
                        <span id="upload_msg" style="display:none" class="text-danger" >Uploading...</span>
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />

                    </div>
                </form>
            </div>
        </div>
    </div>
   
    

    <?php include('common_script.php') ?>

</body>

</html>

<script type="text/javascript">

    let materials = document.getElementsByClassName("material");
    let leftBox = document.getElementById('left');
    let rightBox = document.getElementById('right');
   
    for(material of materials){
        //console.log(material);
        material.addEventListener("dragstart",function(e){
            let selected = e.target;
           // from right to left
            rightBox.addEventListener("dragover",function(e){
                e.preventDefault();
            })

            rightBox.addEventListener("drop",function(e){
               rightBox.appendChild(selected);
               
               addCourseMaterial(selected.getElementsByTagName('input')[0].value);
               selected=null;
            })
           // from left to right
            leftBox.addEventListener("dragover",function(e){
                e.preventDefault();
            })

            leftBox.addEventListener("drop",function(e){
                leftBox.appendChild(selected);
                removeCourseMaterial(selected.getElementsByTagName('input')[0].value);
               selected=null;
            })

        })
    }
function addCourseMaterial(material_id){
    let program_id = <?php  echo $_POST['program_id']?>;
    $.ajax({
        type:'POST',
        url:'ajax_doc_upload.php',
        data:{action:"add_mid_study_material",material_id:material_id,program_id:program_id},
        success: function(res){
            console.log(res);
            let elm = res.split('#');
            //console.log(elm[0]);
            if (elm[0] == "success") {
                //print_r$("#email_div").load(" #email_div");
                //location.reload();
            }
        }
    })
}
function removeCourseMaterial(material_id){
    var program_id = <?php  echo $_POST['program_id']?>;
    $.ajax({
        type:'POST',
        url:'ajax_doc_upload.php',
        data:{action:"remove_mid_study_material",material_id:material_id,program_id:program_id},
        success: function(res){
            console.log(res);
            let elm = res.split('#');
            //console.log(elm[0]);
            if (elm[0] == "success") {
                //print_r$("#email_div").load(" #email_div");
                //location.reload();
            }
        }
    })
}
function addMaterial(){
    $('#addMaterialModal').modal('show');
}

function upload_doc() {
var subject = document.getElementById('subject').value;
var facultyName = document.getElementById('facultyName').value;
var traning_type = <?php  echo $_POST['traning_type']?>;

var name = document.getElementById('doc_id').files[0].name;
console.log(subject);
var form_data = new FormData();
var ext = name.split('.').pop().toLowerCase();
if (jQuery.inArray(ext, [ 'pdf','doc','docx','ppt','pptx','ppsx']) == -1) {
    alert("Invalid upload File");
}
var oFReader = new FileReader();
oFReader.readAsDataURL(document.getElementById('doc_id').files[0]);
var f = document.getElementById('doc_id').files[0];
var fsize = f.size || f.fileSize;
if (fsize > 15000000) {
    alert(" File size not be grater than 5MB");
} else {
    form_data.append("file", document.getElementById('doc_id').files[0]);
    form_data.append("action", "upload_master_doc");
    form_data.append("subject", subject);
    form_data.append("facultyName", facultyName);
    form_data.append("trng_type", traning_type);
    
    $.ajax({
        url: "ajax_doc_upload.php",
        method: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            $('#upload_misc').hide();
            $('#upload_msg').show();
        },
        success: function(res) {
            let elm = res.split('#');
            console.log(res);
            if (elm[0] == "success") {
                $('#upload_misc').show();
                $('#upload_msg').hide();
                sessionStorage.message =  "Document" +' '+ elm[1]; 
                sessionStorage.type = "success";
                location.reload();
            }
            return false;
        }
    });
}
}


function remove(id,file_name){
    //alert(doc_name);
    if(confirm("Are you sure you want to delete this?")){
        $.ajax({
        type:'POST',
        url:'ajax_doc_upload.php',
        data:{action:"remove_misc_study_material",id:id,file_name:file_name},
        success: function(res){
            console.log(res);
            let elm = res.split('#');
            //console.log(elm[0]);
            if (elm[0] == "success") {
                //print_r$("#email_div").load(" #email_div");
                location.reload();
            }
        }
    })
    }
    
}


function traneeList(id, program_id, session) {
    console.log(id);
    $.ajax({
        type: 'POST',
        url: "ajax_search.php",
        data: {
            action: "sponsored_tranee_atn",
            timeTable_id: id,
            program_id: program_id,
            session_no: session
        },
        success: function(res) {
            console.log(res);
            $('#view_tranee').html(res);

            $('#viewTraneeModal').modal('show');

            $("#checkAll").click(function(){
                // alert(123);
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $('input[type="checkbox"]').on('change', function() {
                var checkedValue = $(this).prop('checked');
                // uncheck sibling checkboxes (checkboxes on the same row)
                $(this).closest('tr').find('input[type="checkbox"]').each(function() {
                    $(this).prop('checked', false);
                });
                $(this).prop("checked", checkedValue);

            });


        }

    });
}

function tranieList_edit(id,program_id, session) {
    console.log(id);
    $.ajax({
        type: 'POST',
        url: "ajax_search.php",
        data: {
            action: "sponsored_tranee_atn_edit",
            timeTable_id: id,
            program_id: program_id,
            session_no: session
            
        },
        success: function(res) {
            console.log(res);
            $('#mailbtn').html('');

            $('#view_tranee').html(res);
            $('#mailbtn').html(` <input type="button" class="btn btn-success" value="Update" onclick="update_attendance(${id})" />
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />`);
            $('#viewTraneeModal').modal('show');

            $('input[type="checkbox"]').on('change', function() {
                var checkedValue = $(this).prop('checked');
                // uncheck sibling checkboxes (checkboxes on the same row)
                $(this).closest('tr').find('input[type="checkbox"]').each(function() {
                    $(this).prop('checked', false);
                });
                $(this).prop("checked", checkedValue);

            });


        }

    });
}
function save_attendance() {


    var attendance = [];
    $.each($("input:checkbox[name='atten']:checked"), function() {
        attendance.push($(this).val());
    });
    //alert("We remain open on: " +attendance);

    let timeTable_id = $('#timeTable_id').val();
    let program_id = $('#program_id').val();
    let session_no = $('#session_no').val();
   

    //alert(timeTable_id);

    // table = $("#tableid").serializeArray();
    TableData = storeTblValues();
    TableData = JSON.stringify(TableData);
    console.log(storeTblValues());

    $.ajax({
        url: 'ajax_attendance_sponsored.php',
        type: "POST",
        data: {
            'tableData': TableData,
            
            session_no: session_no,
            program_id: program_id,
            session_no: session_no,
            timeTable_id: timeTable_id
        },

        success: function(data) {
            console.log(data)
        }
    });
}

function update_attendance(id){
    

    var attendance = [];
    $.each($("input:checkbox[name='atten']:checked"), function() {
        attendance.push($(this).val());
    });
    //alert("We remain open on: " +attendance);

    let update_id = $('#update_id').val();
    let program_id = $('#program_id').val();
    let session_no = $('#session_no').val();
   

    //alert(timeTable_id);

    // table = $("#tableid").serializeArray();
    TableData = storeTblValues();
    TableData = JSON.stringify(TableData);
    console.log(storeTblValues());

    $.ajax({
        url: 'ajax_attendance_sponsored.php',
        type: "POST",
        data: {
            'tableData': TableData,
            session_no: session_no,
            program_id: program_id,
            session_no: session_no,
            update_id:update_id
        },

        success: function(data) {
            console.log(data)
        }
    });
}

function storeTblValues() {
    var TableData = new Array();
    $('#tbl_attandance tr').each(function(row, tr) {
        TableData[row] = {
            "name": $(tr).find('td:eq(1)').text(),
            "email": $(tr).find('td:eq(2)').text(),
            "phone": $(tr).find('td:eq(3)').text(),
            "attandance": $(tr).find('input[type="checkbox"]:checked').val()

        }
    });
    TableData.shift(); // first row will be empty - so remove
    return TableData;
}
</script>