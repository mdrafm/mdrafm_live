<?php

//exam.php

include('database.php');

$object = new database();

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}

// if(!$object->is_master_user())
// {
//     header("location:".$object->base_url."admin/result.php");
// }

// $object->query = "
// SELECT * FROM exam_soes 
// WHERE exam_status = 'Pending' OR exam_status = 'Created' 
// ORDER BY exam_title ASC
// ";

// $result = $object->get_result();

include('header.php');
                
?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Remove Exam</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <!-- <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	
                            	
                                    <div class="col-md-4">
                                         <label>Exam</label>
                                            <select name="exam_id" id="exam_id" class="form-control" required>
                                                <option value="0">Select Exam</option>
                                                <?php
                                                $object->query = "
                                                SELECT * FROM tbl_exam_master 
                                                ";
                                                
                                                $res = $object->get_result();

                                                foreach ($res as $row1) {
                                                    echo '
                                                    <option value="' . $row1["id"] . '">' . $row1["exam_title"] . '</option>
                                                    ';
                                                }
                                                ?>
                                            </select>
                                    </div>
                                   
                                   
                                    <div class="col-md-2">
                                       <input type="button" name="view" id="view_button" onclick="exam_id()" class="btn btn-success mt-5" value="View" />
                                    </div>
                               
                            </div>
                        </div>
                        <div class="card-body">
                            
                        </div>
                    </div> -->

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold text-primary">Exam List</h6>
                            	</div>
                            	
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="exam_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Exam Name</th>
                                            <th>Examiner</th>
                                            <th>Date & Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                                $object->query = "
                                                SELECT * FROM tbl_exam_master 
                                                ";
                                              //  $res_data = $object->get_result();
                                                $result = $object->get_result();
                                                $count=0;
                                                foreach ($result as $res) {
                                                    $count++;
                                                  ?>
                                                  <tr>
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo $res['exam_title'] ?></td>
                                                    <td><?php echo $res['exam_date_time'] ?></td>
                                                    <td><?php echo $res['status'] ?></td>
                                                    <td>
                                                    <button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id='<?php echo $res["id"] ?>'><i class="fas fa-times"></i></button>
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
                  

                <?php
                include('footer.php');
                ?>


<script>
   
    
$(document).ready(function(){
   
	$(document).on('click', '.delete_button', function(){

    	var id = $(this).data('id');
console.log(id)
    	if(confirm("Are you sure you want to remove it?"))
    	{

      		$.ajax({

        		url:"exam_action.php",

        		method:"POST",

        		data:{id:id, action:'remove_exam'},

        		success:function(data)
        		{
                  console.log(data);
          			//$('#message').html(data);


        		}

      		})

    	}

  	});

    


});
</script>