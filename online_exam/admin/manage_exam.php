<?php

include('database.php');

$object = new database();

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}

include('header.php');
             print_r($_POST);   
?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Exam Management</h1>

<!-- DataTales Example -->
<span id="message"></span>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Trainee List</h6>
            </div>
           
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="exam_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Photo</th>
                        <th>Exam Date & Time</th>
                        <th>Exam Duration</th>
                        <th>Status</th>
                        <th>Set Qustion</th>
                        
                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $object->query = "
                        SELECT u.id as user_id,r.f_name,r.l_name, r.email,r.phone,d.photo,m.exam_date_time,m.exam_duration,m.status FROM `tbl_new_recruite` r 
                        JOIN `tbl_user` u ON r.phone = u.username 
                        JOIN `tbl_traniee_documents` d ON u.id = d.user_id
                        JOIN `tbl_exam_master` m ON r.program_id = m.program_id
                        WHERE m.id = '".$_POST['exam_id']."' AND r.program_id = '".$_POST['program_id']."' ORDER BY r.f_name " ;
                        
                        $res_data = $object->get_result();
                        //print_r($res_data);
                        foreach ($res_data as $row) {
                            //print_r($row);
                            $status = '';
			                $action_button = '';

                            if($row['status'] == 4 )
                            {
                                $action_button = '
                                <div  align="center">
                                 <button type="button" name="send_button" class="btn btn-success  btn-sm" onclick="setQuestion('.$row["user_id"].','.$_POST['exam_id'].')">Set Qustion</button>
                                </div>
                                ';
                            }
            
                            if($row['status'] == 4)
                            {
                                $status = '<span class="badge badge-warning">Upcoming</span>';
                               
                            }
            
                            if($row['status'] == '5')
                            {
                                $status = '<span class="badge badge-dark">Completed</span>';
                                
                            }

                           ?>
                             <tr>
                                <td><?php echo $row['f_name'].' '.$row['l_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td>
                                  <img src="<?php echo $object->base_url.'../admin/uploads/'.$row['photo']; ?>" alt="image" class="img-fluid img-thumbnail" width="75" height="75" />
                                </td>
                                <td><?php echo $row['exam_date_time']; ?></td>
                                <td><?php echo $row['exam_duration'].'Minutes'; ?></td>
                                <td><?php echo $status ?></td>
                                <td><?php echo $action_button ?></td>
                                

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
function setQuestion(user_id,exam_id){
    alert(user_id);
    
 }

$(document).ready(function() {

    

});



</script>