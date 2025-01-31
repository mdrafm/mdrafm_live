<!DOCTYPE html>
<html lang="en">


<head>
    <?php

    include('header_link.php');
    include('../config.php');
    include 'database.php';
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


            <div class="content" style="margin-top: 50px;">

                <div class="row">
                    <div class="col-md-4">
                        <div id="alert_msg" class="alert alert-success">added successfully</div>
                    </div>
                    <div class="col-md-6">
                        <!-- Modal -->
                        <div class="modal fade" id="termModal" tabindex="-1" aria-labelledby="termModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="width:200%; margin:20px -150px">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="termModalLabel">Mid Term Syllabus</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form method="post" id="frm_dtl_syllabus">


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><strong>Syllabus</strong></label>
                                                        <select class="custom-select mr-sm-2" id="syllabus" name="syllabus_id">
                                                            <option value="0" selected>Select Syllabus</option>
                                                            <?php
                                                            $db = new Database();
                                                            $count = 0;
                                                            $db->select('tbl_sylabus_master', "*", null, "trng_type = 3", null, null);
                                                            // print_r( $db->getResult());
                                                            foreach ($db->getResult() as $row) {
                                                                //print_r($row);
                                                                $count++
                                                            ?>
                                                                <option value="<?php echo $row['id'] ?>">
                                                                    <?php echo $row['descr'] ?>
                                                                </option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><strong>Paper</strong></label>
                                                        <select class="custom-select mr-sm-2" id="paper_id" name="paper">
                                                            <option selected>Select Paper</option>
                                                            <?php
                                                            $db = new Database();
                                                            $count = 0;
                                                            $db->select('tbl_mid_paper_master', "*", null, 'status=1', null, null);
                                                            // print_r( $db->getResult());
                                                            foreach ($db->getResult() as $row) {
                                                                //print_r($row);
                                                                $count++
                                                            ?>
                                                                <option value="<?php echo $row['id'] ?>">
                                                                    <?php echo $row['paper_code'] ?>
                                                                </option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><strong>Subject</strong></label>
                                                        <textarea class="form-control" name="subject" id="subject" placeholder="Enter Subject" rows="3" style="border: 1px solid #e3e3e3;border-radius:5px;"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><strong>No of Session</strong></label>
                                                        <input type="text" class="form-control" name="session" id="session" placeholder="Enter No session" />
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" id="update_id">
                                        </form>
                                    </div>
                                    <div class="modal-footer">

                                        <button type="submit" class="btn btn-primary" name="submit" value="Save" id="save" onclick="add('Mid Syllabus','frm_dtl_syllabus','tbl_mid_syllabus')">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row" style="margin-top:50px">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">

                                <h4 class="card-title">Syllabus Wise </h4>

                            </div>
                            <div class="card-body">
                                <form id="frm_range">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><strong>Syllabus</strong></label>
                                                <select class="custom-select mr-sm-2" id="syllabus_id" name="syllabus_id">
                                                    <option value="0" selected>Select Syllabus</option>
                                                    <?php
                                                    $db = new Database();
                                                    $count = 0;
                                                    $db->select('tbl_sylabus_master', "*", null, "trng_type = 3", null, null);
                                                    // print_r( $db->getResult());
                                                    foreach ($db->getResult() as $row) {
                                                        //print_r($row);
                                                        $count++
                                                    ?>
                                                        <option value="<?php echo $row['id'] ?>">
                                                            <?php echo $row['descr'] ?>
                                                        </option>

                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <input type="button" class="btn btn-primary" value="View" onclick="viewSubjectMaster()" style="margin-top: 20px;">
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
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="card-title">Mid Term Syllabus Master</h4>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-2">
                                        <input type="button" class="btn btn-primary" data-toggle="modal" data-target="#termModal" value="Add New">
                                    </div>
                                </div>


                            </div>
                            <div class="card-body">
                                <div id="mid_subject" class=" table table-responsive table-striped table-hover" style="width:65%;margin:0px auto">

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

    <div class="fixed-plugin">
        <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
                <li class="header-title"> Sidebar Background</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger background-color">
                        <div class="badge-colors text-center">
                            <span class="badge filter badge-yellow" data-color="yellow"></span>
                            <span class="badge filter badge-blue" data-color="blue"></span>
                            <span class="badge filter badge-green" data-color="green"></span>
                            <span class="badge filter badge-orange active" data-color="orange"></span>
                            <span class="badge filter badge-red" data-color="red"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>


            </ul>
        </div>
    </div>

    <!-- msgBox Modal Modal HTML -->
    <div id="cnfModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="m_title" style="text-align:center;">Delete Term</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="warning">
                            <p>Are you sure you want to delete this Record?</p>
                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                        </div>
                        <p id="m_body"></p>
                    </div>
                    <div class="modal-footer" id="m_footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- msgBox Modal Modal HTML -->
    <div id="cnfModaSend" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="m_title" style="text-align:center;">Send TO MDRAFM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="warning">
                            <p>Are you sure you want to Send this Record?</p>
                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                        </div>
                        <p id="m_body"></p>
                    </div>
                    <div class="modal-footer" id="ms_footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">

                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include('common_script.php') ?>

</body>

</html>

<script type="text/javascript">
    // $('#term_id').on('change', function() {
    //     var term_id = $(this).val();
    //     // alert(term_id);

    //     $.ajax({
    //         type: "POST",
    //         url: "ajax_master.php",

    //         data: {
    //             term_id: term_id,
    //             table: "tbl_paper_master",
    //             action: "select"
    //         },
    //         success: function(res) {
    //             //console.log(res);
    //             $('#paper_id').html(res);
    //         }
    //     })

    // })

    function viewSubjectMaster() {
        let syllabus_id = $('#syllabus_id').val();

        $.ajax({
            type: "POST",
            url: "ajax_fetch_master_data.php",

            data: {
                action: "view_mid_sub_master",
                syllabus_id: syllabus_id,

            },
            success: function(res) {
                console.log(res);
                $('#mid_subject').html(res);
                $('#mid_subject_tbl').DataTable();
                paperE1 = document.querySelector('#paper_id');
            }
        })

    }

    function add(str, frm, tbl) {


        var update_id = $('#update_id').val();

        $.ajax({
            type: "POST",
            url: "ajax_master.php",

            data: $('#' + frm).serialize() + '&' + $.param({
                'action': 'add',
                'table': tbl,
                'update_id': update_id
            }),
            success: function(res) {
                console.log(res);
                let elm = res.split('#');
                if (elm[0] == "success") {
                    sessionStorage.message = str + ' ' + elm[1];
                    sessionStorage.type = "success";
                    location.reload();
                }
            }
        })

    }

    function edit(id) {

        $.ajax({
            type: "POST",
            url: "ajax_master.php",
            dataType: "json",
            data: {
                action: "edit",
                table: "tbl_mid_syllabus",
                edit_id: id

            },
            success: function(res) {
                console.log(res);
                res.map((data) => {

                        $('#update_id').val(data.id);
                        $('#paper').val(data.paper);
                        $('#subject').val(data.subject);

                        $('#save').html('Update');
                        $('#save').attr('id', 'update');
                        $('#termModal').modal('show');
                    }

                )

            }
        })
    }

    function cnfBox(id) {
        //alert(id);
        $('#m_footer').empty();
        var html =
            `<input type="button" class="btn btn-danger btn-dlt" value="Delete" onclick="delete_record(${id},'tbl_mid_syllabus')" />`;
        $('#m_footer').append(html);
        $('#cnfModal').modal('show');
    }

    function delete_record(id, tbl) {

        $.ajax({
            type: "POST",
            url: "ajax_master.php",
            data: {

                action: "delete",
                id: id,
                table: tbl
            },
            success: function(res) {
                console.log(res);
                if (res == "success") {
                    sessionStorage.message = "record deleted successfully";
                    sessionStorage.type = "success";
                    location.reload();
                }
            }
        })
    }

    function send_record(id, tbl) {

        $.ajax({
            type: "POST",
            url: "ajax_master.php",
            data: {

                action: "send",
                id: id,
                table: tbl
            },
            success: function(res) {
                console.log(res);
                if (res == "success") {
                    sessionStorage.message = "Send to MDRAFM Successfully";
                    sessionStorage.type = "success";
                    location.reload();
                }
            }
        })
    }
</script>