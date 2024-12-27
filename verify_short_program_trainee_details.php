<?php include('header.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Data Table</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <!-- Include Bootstrap CSS and JS for Modal -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <h5 class="text-center text-danger m-3" >Please check and update your details, and click verify</h5>
    <table id="tableid" class="term table">
        <thead style="background: #315682;color:#fff;font-size: 11px;">
            <tr>
                <th>Sl No</th>
                <th>Name</th>
                <th>HRMS Id</th>
                <th>Designation</th>
                <th>Place of Posting</th>
                <th>Gender</th>
                <th>District</th>
                <th>Email</th>
                <th style="text-align:center;">Phone</th>
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;width: 8rem;">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Trainee Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" name="name">
                        </div>
                        <div class="form-group">
                            <label for="editHrmsId">HRMS Id</label>
                            <input type="text" class="form-control" id="editHrmsId" name="hrms_id">
                        </div>
                        <div class="form-group">
                            <label for="editDesignation">Designation</label>
                            <input type="text" class="form-control" id="editDesignation" name="designation">
                        </div>
                        <div class="form-group">
                            <label for="editOfficeName">Place of Posting</label>
                            <input type="text" class="form-control" id="editOfficeName" name="office_name">
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email">
                        </div>
                        <div class="form-group">
                            <label for="editPhone">Phone</label>
                            <input type="text" class="form-control" id="editPhone" name="phone" >
                        </div>
                         <div class="form-group">
                            <label for="district">Select Gender</label>
                            <select class="form-control" id="editSex" name="sex">
                             <option value="0">Select Gender</option>
                             <option value="1">Male</option>
                             <option value="2">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="district">Select District</label>
                            <select class="form-control" id="editDistrict" name="district_id">
                             <option value="0">Select District</option>
                             <?php
                                $count = 0;
                                $sql_dist = "SELECT * FROM tbl_district_master order by dist_name asc";
                                $sql_dist_res = mysqli_query($db,$sql_dist);
                                
                                while ($row = mysqli_fetch_array($sql_dist_res)){
                                    $count++;

                            ?>
                              <option value="<?php echo $row['id'] ?>"><?php echo $row['dist_name'] ?></option>
                            <?php
                                }
                            ?>

                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#tableid').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "fetch_data2.php",
                    "type": "POST"
                },
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "hrms_id" },
                    { "data": "designation" },
                    { "data": "office_name" },
                    
                    { "data": 'gender'},
                    { "data": "district" },
                    { "data": "email" },
                    { "data": "phone" },
                    { "data": "status" },
                    {
                        "data": null,
                        "defaultContent": '<button type="button" class="btn btn-info mr-2 btn-sm editBtn">Edit</button><button type="button" class="btn btn-success btn-sm verifyBtn">Verify</button>'
                    }
                ]
            });

            $('#tableid tbody').on('click', '.verifyBtn', function () {
                var data = table.row($(this).parents('tr')).data();
                //$('#editId').val(data.id);
                $.ajax({
                    type: 'POST',
                    url: 'update_status.php',
                    data: {'id':data.id},
                    success: function(response) {
                        table.ajax.reload();
                    },
                    error: function() {
                        alert('Failed to update data.');
                    }
                });
            });

            $('#tableid tbody').on('click', '.editBtn', function () {
                var data = table.row($(this).parents('tr')).data();
                console.log(data);
                $('#editId').val(data.id);
                $('#editName').val(data.name);
                $('#editHrmsId').val(data.hrms_id);
                $('#editDesignation').val(data.designation);
                $('#editOfficeName').val(data.office_name);
                $('#editEmail').val(data.email);
                $('#editDistrict').val(data.district_id);
                $('#editSex').val(data.sex);
                $('#editPhone').val(data.phone);
                $('#editModal').modal('show');
            });

            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                var dist =  $('#editDistrict').val();
               var text= $('#editDistrict option:selected').text();
                console.log(text)
                if(dist >0){
                    $.ajax({
                    type: 'POST',
                    url: 'update_data.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editModal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function() {
                        alert('Failed to update data.');
                    }
                });
                }else{
                    alert('Please Select District.');
                }
               
            });
        });
    </script>
</body>
</html>
