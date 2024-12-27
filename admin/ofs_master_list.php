<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include('header_link.php');

    include('../config.php');
    include 'database.php';
    ?>
    <!-- <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.4/dist/bootstrap-table.min.css"> -->
    <style>
        .card label {
            font-size: 1rem;
        }
    </style>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="card-title">MCTP OFS List</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#menu1">All OFS List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#home">MCTP training taken List</a>

                                    </li>

                                   
                                </ul>

                                <div class="tab-content">
                                    <div id="menu1" class="container tab-pane active">
                                        <div id="term2" class=" table table-responsive table-striped table-hover" style="width:100%;margin:0px auto">
                                            <table id="ofs_table">

                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th>Email</th>
                                                        <th>Date of Birth</th>
                                                        <th>Date of Joining</th>
                                                        <th>Date of Retirement</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    <div id="home" class="container tab-pane">
                                        <div id="term2" class=" table table-responsive table-striped table-hover" style="width:100%;margin:0px auto">
                                            <table class="table" id="mtpc_ofs_table">
                                                <thead class="" style="background: #315682;color:#fff;font-size: 11px;">

                                                    <th>Sl No</th>
                                                    <th>Name</th>
                                                    <th>Phone no</th>
                                                    <th>Email</th>
                                                    <th>Date of Birth</th>
                                                    <th>Date of Joining</th>
                                                    <th>Date of Retirement</th>
                                                    <th>Status</th>
                                                    <th>Action</th>

                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $db = new Database();
                                                    $cnt = 1;
                                                    $db->select_sql("SELECT m.id,m.emp_id,m.gpf_no,a.name as acct_type,e.type as emp_type,m.name,m.deploy_type,r.religion,m.gender,m.mobile,m.email,m.dob,
                                            m.doj,m.dor,m.cader,m.grade,m.home_town,c.category,m.office_name,m.office_address,m.designation,m.last_year_passing,
                                            m.qualification,m.degree,t.trng_name,m.mctp_trainning_status
                                            FROM `tbl_ofs_master` m 
                                            LEFT JOIN `tbl_acct_type_master` a  ON m.acct_type = a.id
                                            LEFT JOIN `tbl_emp_type_master` e  ON m.emp_type = e.id
                                           LEFT JOIN `tbl_category_master` c ON m.category_id = c.id
                                           LEFT JOIN `tbl_religion_master` r ON m.religion_id = r.id
                                           LEFT JOIN `tbl_training_master` t ON m.trainning_id = t.id
                                            WHERE m.status = 1 AND m.mctp_trainning_status != 0");

                                                    foreach ($db->getResult() as $row) {
                                                        $retired_date = date('Y-m-d', strtotime($row['dob'] . ' + 60 years'));
                                                    ?>
                                                        <tr>

                                                            <td><?php echo $cnt++; ?></td>
                                                            <td><?php echo $row['name'] ?></td>

                                                            <td><?php echo $row['mobile'] ?></td>
                                                            <td><?php echo $row['email'] ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($row['dob'])) ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($row['doj'])) ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($row['dor'])) ?></td>
                                                            <td><?php echo ($row['mctp_trainning_status'] == 1) ? 'MCTP-I' : 'MCTP-II' ?></td>

                                                            <td colspan="12" style="text-align:right">

                                                                <!-- <input type="button" class="btn " style="background:#3292a2"
                                                    name="send" onclick="mail_compose();" value="Send Mail" /> -->
                                                                <a href="#empDetailModal_<?php echo $row['id']; ?>" data-toggle="modal" style="color:#4164b3" class="edit"><i class="far fa-edit " style="font-size:1.5rem;"></i></a>
                                                                &nbsp;
                                                                <div id="empDetailModal_<?php echo $row['id']; ?>" class="modal fade">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <form id="employeeDtl">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="m_title" style="text-align:center;">Compose Mail</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="employee_dtl">
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Name :</label>
                                                                                                <span><?php echo $row['name'] ?></span>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Employee id :</label>
                                                                                                <span><?php echo $row['emp_id'] ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Gpf No :</label>
                                                                                                <span><?php echo $row['gpf_no'] ?></span>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Acct Type :</label>
                                                                                                <span><?php echo $row['acct_type'] ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Deploy Type :</label>
                                                                                                <span><?php echo $row['deploy_type'] ?></span>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Religion :</label>
                                                                                                <span><?php echo $row['religion'] ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Gender :</label>
                                                                                                <span><?php echo ($row['gender'] == 1) ? 'Male' : 'Femail'; ?></span>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Cader :</label>
                                                                                                <span><?php echo $row['cader'] ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Phone no :</label>
                                                                                                <span><?php echo $row['mobile'] ?></span>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Email :</label>
                                                                                                <span><?php echo $row['email'] ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Date of Birth :</label>
                                                                                                <span><?php echo date('d-m-Y', strtotime($row['dob'])) ?></span>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Date of Joining :</label>
                                                                                                <span><?php echo date('d-m-Y', strtotime($row['doj'])) ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Date of Retirement :</label>
                                                                                                <span><?php echo date('d-m-Y', strtotime($row['dor'])) ?></span>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Grade :</label>
                                                                                                <span><?php echo $row['grade'] ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Home Town :</label>
                                                                                                <span><?php echo $row['home_town'] ?></span>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Category :</label>
                                                                                                <span><?php echo $row['category'] ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Office Name :</label>
                                                                                                <span><?php echo $row['office_name'] ?></span>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Office Address :</label>
                                                                                                <span><?php echo $row['office_address'] ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Designation :</label>
                                                                                                <span><?php echo $row['designation'] ?></span>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Last year Passing :</label>
                                                                                                <span><?php echo $row['last_year_passing'] ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Qualification :</label>
                                                                                                <span><?php echo $row['qualification'] ?></span>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Degree :</label>
                                                                                                <span><?php echo $row['degree'] ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Training Type :</label>
                                                                                                <span><?php echo $row['trng_name'] ?></span>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label for="">Status :</label>
                                                                                                <span><?php echo 'active' ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
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

    </div>

    <!-- edit Modal HTML -->
    <div id="empDetailModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="m_title" style="text-align:center;">Employee Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="empDetails">


                </div>
                <div class="modal-footer" id="detaisFooter">
                </div>

            </div>
        </div>
        <!-- end edit  Modal HTML -->

        <!-- msgBox Modal Modal HTML -->
        <div id="emailModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content" style="width:130%; margin:120px -60px">
                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title" id="m_title" style="text-align:center;">Email to accept MCTP Program </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label> Subject : </label>
                                <input type="text" class="form-control col-sm-8" name="subject" id="subject" placeholder="Enter subject">

                            </div>
                            <div class="form-group">
                                <label> Email Content : </label>
                                <textarea class="form-control" name="email_body" id="email_body" rows="5" style="border: 1px solid black;max-height: 140px;"></textarea>
                            </div>

                            <div class="loader">
                                <img src="assets/img/loader.gif" alt="Loading" style="width: 300px;height: 90px;" />
                            </div>
                        </div>
                        <div class="modal-footer" id="mailbtn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- msgBox Modal Modal HTML -->
        <?php include('common_script.php') ?>

</body>

</html>
<script src="../ckeditor/ckeditor.js"> </script>
<!-- <script src="https://unpkg.com/bootstrap-table@1.22.4/dist/bootstrap-table.min.js"></script> -->
<script type="text/javascript">
    //$('#ofs_table').DataTable();
    //let table = new DataTable('#ofs_table');
    $(document).ready(function() {
        var mainurl = "getMctpData.php";
        $('#ofs_table').DataTable({
            "processing": true,
            "serverSide": true,
            scrollY: true,
            "ajax": {
                url: mainurl, // json
                type: "post", // type of method
                data: {
                    action: 'fetch'
                },

                "error": function(xhr, errorType, thrownError) {
                    console.log("AJAX error: " + errorType);
                    console.log(thrownError);
                }
            }
        });
    });
    //$('#ofs_table').DataTable();
    $('#mtpc_ofs_table').DataTable();
    $('.first_list').DataTable();

    $("#checkAll").click(function() {
        // alert(123);
        $('.first_list input:checkbox').not(this).prop('checked', this.checked);
    });

    $('input[type="checkbox"]').on('change', function() {
        var checkedValue = $(this).prop('checked');
        // uncheck sibling checkboxes (checkboxes on the same row)
        $(this).closest('tr').find('input[type="checkbox"]').each(function() {
            $(this).prop('checked', false);
        });
        $(this).prop("checked", checkedValue);

    });

    function viewOfsList(ofs_id) {
        $.ajax({
            type: "POST",
            url: "getMctpData.php",
            // dataType:'json',
            data: {
                'action': 'fetchOfsList',
                'table': 'tbl_ofs_master',
                'id': ofs_id
            },
            success: function(res) {
                console.log(res);
                $('#empDetails').html(res);
                $('#empDetailModal').modal('show');
            }
        })
    }

    function editOfsList(ofs_id) {
        $.ajax({
            type: "POST",
            url: "getMctpData.php",
            // dataType:'json',
            data: {
                'action': 'edtOfsList',
                'table': 'tbl_ofs_master',
                'id': ofs_id
            },
            success: function(res) {
                console.log(res);
                $('#empDetails').html(res);
                $('#detaisFooter').html(`<button class="btn btn-success" onclick="updateEmployee(${ofs_id},'ofs_frm')">Update</button>`)
                $('#empDetailModal').modal('show');
            }
        })
    }



    function updateEmployee(id, frm) {


        var update_id = id;
        console.log(frm);
        $.ajax({
            type: "POST",
            url: "ajax_master.php",

            data: $(`#${frm}_${id}`).serialize() + '&' + $.param({
                'action': 'add',
                'table': 'tbl_ofs_master',
                'update_id': update_id
            }),
            success: function(res) {
                console.log(res);
                let elm = res.split('#');
                if (elm[0] == "success") {
                    sessionStorage.message = 'update' + ' ' + elm[1];
                    sessionStorage.type = "success";
                    location.reload();
                }
            }
        })

    }

    function show_email_div(tbl_id) {

        $('#emailModal').modal('show');
        $('#mailbtn').html(`<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="button" class="btn btn-primary" value="Send" onclick="handle_mail('${tbl_id}')">`);

    }

    async function handle_mail(tbl_id) {


        TableData = storeTblValues(tbl_id);
        console.log(TableData);
        // TableData = JSON.stringify(TableData);
        const emailStatus = TableData.map(async data => {
            // console.log(data);
            if (data.send == 1) {
                console.log(data.email);
                const Status = await sendEmail(data.email, data.phone, data.ofs_id, data.name);

                return Status;
            }


        })


        const results = await Promise.all(emailStatus);

        console.log(results);
    }

    async function sendEmail(email, phone, ofs_id, name) {

        let subject = $('#subject').val();
        let email_body = $('#email_body').val();
        let args = {
            'action': 'mctp_approval',
            subject,
            email_body,
            email,
            phone,
            ofs_id,
            name
        }
        let url = 'action_controller.php';

        const stuff = await doAjax(url, args);
        console.log(stuff);
        return stuff;
    }

    async function doAjax(ajaxurl, args) {
        let result;

        try {
            result = await $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: args
            });

            return result;
        } catch (error) {
            console.error(error);
        }
    }



    function storeTblValues(tbl_id) {
        var TableData = new Array();
        $(`.${tbl_id} tr`).each(function(row, tr) {

            TableData[row] = {

                "ofs_id": $(tr).find('.ofs_id').val(),
                "name": $(tr).find('td:eq(2)').text(),
                "email": $(tr).find('td:eq(5)').text(),
                "phone": $(tr).find('td:eq(4)').text(),
                "send": ($(tr).find('input[type="checkbox"]:checked').val() == 1) ? "1" : "0",

            }
        });
        TableData.shift(); // first row will be empty - so remove
        return TableData;
    }

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