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
                                <h5>Import Data From Excel</h5>

                                <div class="col-md-8">
                                    <div id="search">
                                        <div class="search_div mt-2" style="margin-left: 33%;padding: 0 10px;background: rgb(37 78 87);border-radius: 10px;
                                             box-shadow: rgb(0 0 0 / 16%) 0px 3px 6px, rgb(0 0 0 / 23%) 0px 3px 6px;">
                                            <div class="search">
                                                <form id="upload_from">
                                                    <div >
                                                        <div class="row">
                                                            <div class="col-md-2 mt-3">
                                                                <label>Upload</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input class="form-control m-2" type="file" name="file"
                                                                    id="excel_file" placeholder="upload file">
                                                            </div>
                                                            <div class="col-md-2 mt-2">
                                                                <input type="hidden" name="action"
                                                                    value="upload_excel" />
                                                                <input type="button" name="submit"
                                                                    class="btn btn-primary" value="Upload"
                                                                    id="upload" />
                                                            </div>


                                                        </div>



                                                    </div>

                                                    </from>
                                            </div>


                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="row">
                   
                    <div class="col-md-12">
                        <div class="card " id="excel_data" style="display:none">

                            <div class="card-header">
                                <h5>Excel Data</h5>

                            </div>
                            <div class="card-body">
                                <div id="result_div">

                                </div>


                            </div>
                            <div class="card-footer">
                                <div class="card-footer-right float-right">
                                    <div class="loader" style="display:none">
                                        <img src="assets/images/loader.gif" alt="Loading"
                                            style="width: 300px;height: 90px;float: right; " />
                                    </div>
                                    <button type="button" class="btn btn-primary" id="save_data"
                                        onclick="import_excel()">
                                        Save
                                    </button>
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
<script>


$("#upload").on('click', function(e) {

     
var name = document.getElementById("excel_file").files[0];
 var form_data = new FormData();
form_data.append("file", name);
form_data.append("action", "upload_excel");
// console.log(form_data); 

$.ajax({
    url: "ajax_upload_excel.php",

    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    type: 'post',
    success: function(res) {
        console.log(res);
        // $('#uploadExcel_frm').hide();
        $('#excel_file').val('');
         $('#excel_data').show();
        
        $('#result_div').html(res);
       
    }
});
})

function import_excel(){
   
   TableData = storeTblValues();
   //TableData = JSON.stringify(TableData);
    //console.log(TableData);
    //TableData = JSON.stringify(TableData);

   $.ajax({
       url: 'ajax_upload_excel.php',
       type: "POST",
       data: {
          
           'action':'import_excel_groupe',
           'tableData': TableData, 
                  
       },
       beforeSend: function() {
            $('.loader').show();
            $('#save_data').hide();
            //  $('#send_email').prop('disabled', true);
        },
       success: function(data) {
        console.log(data);
          
       }
   });
}

function storeTblValues() {
    var TableData = new Array();
    $('#import_excel_data tr').each(function(row, tr) {
        TableData[row] = {
          
           
            // "syllabus_id": $(tr).find('td:eq(1)').text(),
            // "term_id": $(tr).find('td:eq(2)').text(),
            // "paper_id": $(tr).find('td:eq(3)').text(),
            // "exam_subject_question_title": $(tr).find('td:eq(4)').text(),
            // "option_title_1": $(tr).find('td:eq(5)').text(),
            // "option_title_2": $(tr).find('td:eq(6)').text(),
            // "option_title_3": $(tr).find('td:eq(7)').text(),
            // "option_title_4": $(tr).find('td:eq(8)').text(),
            // "exam_subject_question_answer": $(tr).find('td:eq(9)').text(),

            "name": $(tr).find('td:eq(1)').text(),
            "phone": $(tr).find('td:eq(2)').text(),
            "group": $(tr).find('td:eq(3)').text(),

        }
    });
    TableData.shift(); // first row will be empty - so remove
    return TableData;
}
</script>