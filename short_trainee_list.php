<?php include('header.php') ?>
<?php include('nav_bar.php') ?>
<?php

// include 'admin/database.php';
// $conn = new Database();

 //$year = 2021;

               if( isset($_POST['id'])){
                  $id = $_POST['id'];
               }

               //echo $id;
?>

<div class="news-head">
    <h2>Trainee List  </h2>
</div>
 <div class="news" >
  <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead style="background-color:#c8d0ff">
            <tr>
                <th style="width:75px;">Sl No</th>
                <th style="text-align:center;" >Name</th>
                <th>Designation</th>
                <th>Office Name</th>
                <th>Email</th>
               <!--  <th>Category</th> -->
                

                
            </tr>
        </thead>
        <tbody>
            <?php
              

               $count = 0;
               $sql_visit = "SELECT name,designation,office_name,email  FROM `tbl_dept_trainee_registration` WHERE `program_id` = $id";

              $conn->select_sql($sql_visit);

               
              foreach ($conn->getResult() as $row) {
                   //print_r($row);
                
                   $count++;
                   ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['designation']; ?></td>
                        <td><?php echo $row['office_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                       
                       
                        
                    </tr>
                   <?php
               }
            ?>
           
            </tbody>
        
    </table>
    </div>
<?php include('footer.php') ?>

<script>
     $('#example').DataTable();
</script>