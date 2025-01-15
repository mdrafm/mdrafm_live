<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('header_link.php') ?>
    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/fontawesome.min.css" integrity="sha512-RvQxwf+3zJuNwl4e0sZjQeX7kUa3o82bDETpgVCH2RiwYSZVDdFJ7N/woNigN/ldyOOoKw8584jM4plQdt8bhA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #alert_msg {
            position: absolute;
            z-index: 1400;
            top: 2%;
            /* right:4%; */
            margin: 40px;
            text-align: center;
            background: #2c8a2c;
            color: #fff;
            display: none;
        }

        #circular_frm {
            width: 95%;
            margin: 0 auto;
            padding: 20px;
            box-shadow: rgb(50 50 93 / 25%) 0px 2px 5px -1px, rgb(0 0 0 / 30%) 0px 1px 3px -1px;
            background-color: #f7f7f7;
            border-radius: 5px;
        }

        #circular_frm input {
            border-radius: 5px;
            /* border: none; */
        }

        #circular_frm select {
            border-radius: 5px;
            /* border: none; */
        }

        small {
            font-size: 1rem;
            color: red
        }

        label {
            color: black;
            font-size: ;
            font-weight: 600;

        }

        .select2-search__field {
            height: 2rem;
        }
    </style>
</head>

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <?php include('sidebar_nav.php') ?>
    <!-- [ Header ] start -->
    <?php include('header_nav.php') ?>
    <!-- [ Header ] end -->
    <!-- [ Main Content ] start -->

    <!-- [ Main Content ] end -->
    <?php
    // $db->select('tbl_temp_book_detail',"DISTINCT(location)",null,null,null,null);
    //$res_location = $db->getResult();
    $db->select('tbl_book_type', "*", null, null, null, null);
    $res_book_type = $db->getResult();
    $db->select('tbl_subject_name', "*", null, null, null, null);
    $res_subject_type = $db->getResult();
    //print_r($res_location);
    ?>

    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ Main Content ] start -->
            <!--  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- <div class=" table-striped table-hover" id="result_tbl">
                    </div> -->
                    <div class="col-md-6" style="margin-left:45%;padding-top:%">
                        <div id="alert_msg" class="alert alert-success"></div>
                        <div id="alert_msg" class="alert alert-danger"></div>
                    </div>
                    <h5>Add Book Details</h5>
                    <div class="card table-card">
                        <div class="card-header">

                            <form id="frm_add" enctype="multipart/form-data">
                      
                                <div class="row" style="margin-left:2%;margin-right:2%;padding:1%">
                                    <div class="col-4">
                                        <label>Acc. No :</label>
                                        <input class="form-control me-3" name="book_ref_no" id="book_ref_no" value="" placeholder="Enter Reference No." required>
                                        <small></small>
                                    </div>
                                    <div class="col-4">
                                        <label>Book Name :</label>
                                        <input class="form-control me-3" name="book_name" id="book_name" value="" placeholder="Enter Book Name" required>
                                        <small></small>
                                    </div>
                                    <div class="col-4">
                                        <label>Author's Name :</label>
                                        <input class="form-control me-3" name="author_name" id="author_name" value="" placeholder="Enter Author Name" required>
                                        <small></small>
                                    </div>
                                </div>
                                <div class="row" style="margin-left:2%;margin-right:2%;padding: 1%;">
                                    <div class="col-4">
                                        <label>Edition :</label>
                                        <input class="form-control me-2" name="edition" id="edition" value="" placeholder="Enter Edition" required>
                                    </div>
                                    <div class="col-4">
                                        <label>Year of Publication :</label>
                                        <input class="form-control me-2" name="year_of_publication" id="year_of_publication" value="" placeholder="Enter publication year" required>
                                    </div>
                                    <div class="col-4">
                                        <label>Place and Publisher :</label>
                                        <input class="form-control me-2" name="place_publisher" id="place_publisher" value="" placeholder="Enter Place and Publisher" required>
                                    </div>
                                </div>
                                <div class="row" style="margin-left:2%;margin-right:2%;padding: 1%;">
                                    <div class="col-4">
                                        <label>Volume :</label>
                                        <input class="form-control me-2" name="volume" id="volume" value="" placeholder="Enter Volume" required>
                                    </div>
                                    <div class="col-4">
                                        <label>Page :</label>
                                        <input class="form-control me-2" name="page" id="page" value="" placeholder="Enter No.of Page" required>
                                    </div>
                                    <div class="col-4">
                                        <label>Price :</label>
                                        <input class="form-control me-2" name="price" id="price" value="" placeholder="Enter Price" required>
                                    </div>

                                </div>
                                <div class="row" style="margin-left:2%;margin-right:2%;padding: 1%;">
                                    <div class="col-4">
                                        <label>Quantity :</label>
                                        <input class="form-control me-2" name="quantity" id="quantity" value="" placeholder="Enter Quantity" required>
                                        <span><a href="#" onclick='verify_reference_num();'>Verify Accession Number</a></span>
                                        <small></small><span id="ref_num" style="color:red"></span>
                                    </div>
                                    <div class="col-4">
                                        <label>Location :</label>
                                        <input class="form-control me-2" name="location" id="location" value="" placeholder="Enter Location" required>
                                        <small></small>
                                    </div>
                                    <div class="col-4">
                                        <label>Row :</label>
                                        <input class="form-control me-2" name="row" id="row" value="" placeholder="Enter Row" required>
                                        <small></small>
                                    </div>


                                </div>
                                <div class="row" style="margin-left:2%;margin-right:2%;padding: 1%;">
                                    <div class="col-4">
                                        <label>Book Type :</label>
                                        <select class="form-control me-2" aria-label="Default select example" name="book_type" id="book_type">
                                            <option value="">Select Book Category</option>
                                            <?php
                                            if ($res_book_type) {
                                                foreach ($res_book_type as $res_typ) {
                                                    $bk_typ_id = $res_typ['id'];
                                                    // if($book_category==$cat_id)
                                                    // {
                                                    //     $selected="selected";
                                                    // }
                                                    // else
                                                    // {
                                                    //     $selected="";
                                                    // }
                                            ?>
                                                    <option value="<?php echo $bk_typ_id ?>"><?php echo $res_typ['book_type'] ?></option>
                                            <?php
                                                }
                                            } ?>
                                        </select>
                                        <small></small>
                                    </div>
                                    <div class="col-4">
                                        <label>Subject :</label>
                                        <select class="form-control me-2" aria-label="Default select example" name="subject_name" id="subject_name">
                                            <option value="">Select subject</option>
                                            <?php
                                            if ($res_subject_type) {
                                                foreach ($res_subject_type as $res_sub) {
                                                    $subject_id = $res_sub['id']; ?>
                                                    <option value="<?php echo $subject_id ?>"><?php echo $res_sub['book_type'] ?></option>
                                            <?php
                                                }
                                            } ?>
                                        </select>
                                        <small></small>
                                    </div>
                                    <div class="col-4">
                                        <label>Cover Photo :</label>
                                        <input type="file" class="form-control me-2" name="cover_photo" id="cover_photo" value="" required>
                                        <small></small>
                                    </div>
                                    <?php
                                    $rules = array(
                                        'book_ref_no' => 'required',
                                        'book_name' => 'required',
                                        'author_name' => 'required',
                                        'quantity' => 'required|integer',
                                        'location' => 'required',
                                        'row' => 'required',
                                        'book_type' => 'select',
                                        'subject_name' => 'select',
                                    );
                                    ?>
                                    <div class="col-4" style="padding: 26px;">
                                        <button type="button" class="btn btn-primary" style="padding: 10px 10px;" onclick='add_book(<?php echo json_encode($rules)  ?>,displayMessage);'>ADD BOOK</button>
                                    </div>
                                </div>
                            </form>

                            <div id="tbl_case_law" class="table table-responsive table-striped table-hover">
                                <?php //include('book_edit_details.php') ;
                                ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div id="detailsModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content" style="width:200%;margin-left: -33%;">
                        <div class="modal-header" style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, #00acc1 0%, #1abc9c 100%);;color: #fff;">
                            <h5 class="modal-title" id="m_title" style="color:#fff" style="text-align:center;"> Verify Reference ID
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <form id="frm_ref" method="post">
                            <div class="modal-body" style="overflow-y: auto;height:500px">
                                <div class="row" style="margin-left:2%;margin-right:2%;padding:1%" id="reference_div_id">

                                </div>

                            </div>
                            <div class="modal-footer" id="m_footer">
                                <!--<input type="button" class="btn btn-primary" value="Add Book" id="" onclick="add_book(this)">-->
                                <input type="button" class="btn btn-danger" data-dismiss="modal" value="Close">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="alert_box" class="modal fade" role="dialog" aria-labelledby="alert_boxLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="alert_boxLabel2"></h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0 alrt_msg">
                            </p>
                        </div>
                        <div class="modal-footer " id="footer_alert">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>



</body>

</html>
<script src="assets/js/common.js"> </script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="assets/js/form_validation.js"> </script>

<script type="text/javascript">
    $('#btn_search').click(function() {
        $('#circular_frm').toggle("down");
    });
    //For Update Book Table 
    function verify_reference_num() {
        let msg_flg = '';

        var quantity = $('#quantity').val();
        if (quantity > 0) {
            var form = $('#frm_add')[0];
            var form_data = new FormData(form);
            //form_data.append("action", "check_exist_book");
            $('#detailsModal').modal('show');
            $.ajax({
                type: "POST",
                url: "verify_accession_number.php",
                data: form_data,
                processData: false,
                contentType: false,

                success: function(res) {
                    console.log(res);
                    $('#reference_div_id').html(res);
                }
            });
        }

        // // console.log(rules);
        // const book_ref_no_vali = document.querySelector('#book_ref_no');
        // const book_name_vali = document.querySelector('#book_name');
        // const author_name_vali = document.querySelector('#author_name');
        // const quantity_vali = document.querySelector('#quantity');
        // const location_vali = document.querySelector('#location');
        // const row_vali = document.querySelector('#row');
        // const book_type_vali = document.querySelector('#book_type');
        // const subject_name_vali = document.querySelector('#subject_name');
        // let isbook_ref_no_Valid = checkTextField(book_ref_no_vali);
        //     isbook_name_valid = checkTextField(book_name_vali);
        //     isauthor_name_valid = checkTextField(author_name_vali);
        //     isquantity_valid = checkTextField(quantity_vali);
        //     islocation_valid= checkTextField(location_vali);
        //     isrow_valid = checkTextField(row_vali);
        //     isbook_type_valid = checkDropdown(book_type_vali);
        //     issubject_name_valid =  checkDropdown(subject_name_vali);


        // let isFormValid = isbook_ref_no_Valid &&
        //                         isbook_name_valid &&
        //                         isauthor_name_valid &&
        //                         isquantity_valid &&
        //                         islocation_valid &&
        //                         isrow_valid &&
        //                         isbook_type_valid &&
        //                         issubject_name_valid 
        //                         ;
        // if(isFormValid){
        //console.log(form_data);
        // var quantity = $('#quantity').val();
        // var book_ref_no = $('#book_ref_no').val();
        // var book_name = $('#book_name').val();
        // var author_name = $('#author_name').val();
        // var edition = $('#edition').val();
        // var year_of_publication = $('#year_of_publication').val();
        // var place_publisher = $('#place_publisher').val();
        // var volume = $('#volume').val();
        // var page = $('#page').val();
        // var price = $('#price').val();
        // var location = $('#location').val();
        // var row = $('#row').val();
        // var book_type = $('#book_type').val();
        // var subject_name = $('#subject_name').val();
        // var isbookValid = false;
        // var form = $('#frm_add')[0];
        // var form_data = new FormData(form);
        // form_data.append("action", "check_exist_book");
        // form_data.append("rules", JSON.stringify(rules));
        // $.ajax({
        //     type: "POST",
        //     url: "ajax_case_master.php",
        //     data: form_data,
        //     processData: false,
        //     contentType: false,

        //     success: function(res) {
        //         console.log(res);
        //         //return false;
        //         callback(res);

        //         isbookValid = false;
        //         let elm = res.split('#');
        //         if (elm[0] == "success") {
        //             isbookValid = true;
        //         } else if (elm[0] == "err") {
        //             //isbookValid = false;
        //             if (confirm(`${elm[1]} \n Are you want to continue ?`)) {
        //                 isbookValid = true;
        //             } else {
        //                 isbookValid = false;
        //             }
        //         }
        //         console.log(isbookValid);
        //         if (isbookValid) {
        //             $('#detailsModal').modal('show');
        //             $.ajax({
        //             type: "POST",
        //             url: "get_reference_num.php",
        //             data: form_data,
        //             processData: false,
        //             contentType: false,

        //             success: function(res) {
        //                         console.log(res);
        //                 $('#reference_div_id').html(res);
        //             }
        //             });
        //         }

        //     }
        // })
        //}
    }

    function add_book(rules, callback) {
        var quantity = $('#quantity').val();

        var reff_no = [];
        $('input[name^="book_reff_no[]"]').each(function() {
            reff_nos = $(this).val();
            //alert(reff_nos);
            reff_no.push(reff_nos);
        });
        const validationRules = ['book_ref_no|checkTextField', 'book_name|checkTextField', 'author_name|checkTextField', 'quantity|checkTextField',
            'location|checkTextField', 'row|checkTextField', 'book_type|checkDropdown',
            'subject_name|checkDropdown'
        ];
        let formValid = chkValidation(validationRules);

        if (formValid.includes(false)) {
            isFormValid = false;
        } else {
            isFormValid = true;
        }

        var book_name = $('#book_name').val();
        var author_name = $('#author_name').val();
        var edition = $('#edition').val();
        var year_of_publication = $('#year_of_publication').val();
        var place_publisher = $('#place_publisher').val();
        var volume = $('#volume').val();
        var page = $('#page').val();
        var price = $('#price').val();
        var location = $('#location').val();
        var row = $('#row').val();
        var book_type = $('#book_type').val();
        var subject_name = $('#subject_name').val();
        var form = $('#frm_add')[0];
        var form_data = new FormData(form);
        form_data.append("action", "inesrt_book_details");
        form_data.append("table1", "tbl_book_details");
        form_data.append("table2", "tbl_book_reference_no");
        form_data.append("update_id", '');
        form_data.append("book_acc_no", JSON.stringify(reff_no));
        form_data.append('rules', JSON.stringify(rules));

        if (isFormValid) {
            if (reff_no.length == 0) {
                alert('Please verify accession number');
                return false;
            }
            var isbookValid = false;
            $.ajax({
                type: "POST",
                url: "ajax_case_master.php",
                data: {
                    action: "check_exist_book",
                    'book_name': book_name,
                    'author_name': author_name
                },
                success: function(res) {
                    console.log(res);
                    isbookValid = false;
                    let elm = res.split('#');
                    if (elm[0] == "success") {
                        isbookValid = true;
                    } else if (elm[0] == "err") {
                        //isbookValid = false;
                        if (confirm(`${elm[1]} \n Are you want to continue ?`)) {
                            isbookValid = true;
                            console.log(12345);
                        } else {
                            isbookValid = false;
                        }
                    }
                    console.log(isbookValid);
                    if (isbookValid) {
                                $.ajax({
                                    method: "POST",
                                    url: "ajax_case_master.php",
                                    data: form_data,
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function(res) {
                                        console.log(res);
                                        callback(res);
                                        console.log(1234);
                                        let elm = res.split('#');
                                        if (elm[0] == "success") {
                                            $('.modal-backdrop').remove();
                                            $('#detailsModal').modal('hide');
                                            sessionStorage.message = "Book is added successfully";
                                            sessionStorage.type = "success";
                                            showMessage();
                                        } else if (elm[0] == "error") {
                                            sessionStorage.message = elm[1];
                                            sessionStorage.type = "error";
                                            showMessage();
                                            $('.modal-backdrop').remove();
                                        } else if (elm[0] == "accesno") {
                                            console.log(elm[1]);
                                            $('#ref_num').html(elm[1] + '  is already exist');
                                        }
                                    }
                                })
                            }
                }
            })
            

        }
    }
</script>