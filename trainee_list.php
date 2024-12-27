<?php include('header.php') ?>
<?php include('nav_bar.php') ?>
<?php
//echo $year = 2021;
//include 'admin/database.php';
//echo $year = 2021;
//$conn = new Database();

 

			   if( isset($_POST['id'])){
			   	  $id = $_POST['id'];
			   }
?>
<div class="news-head">
    <h2>OFS Trainee List  </h2>
</div>
 <div class="news" >
  <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead style="background-color:#c8d0ff">
            <tr>
                <th style="width:75px;">Sl No</th>
                <th style="text-align:center;" >Name</th>
                <th>Email</th>
                <th>Gender</th>
               <!--  <th>Category</th> -->
                

                
            </tr>
        </thead>
        <tbody>
            <?php
              

               $count = 0;
               $sql_visit = "SELECT b.batch_name,b.batch_year,n.f_name,n.l_name,n.category,n.email,n.sex FROM `tbl_batch_master` b JOIN `tbl_new_recruite` n ON b.id = n.batch_id 
                   WHERE n.batch_id = $id AND n.mdrafm_status = 1";

              $conn->select_sql($sql_visit);

               
              foreach ($conn->getResult() as $row) {
                // print_r($row);
              	switch ($row['category']) {
                              case '1':
                                $cat = 'UR';
                                break;
                              case '3':
                                $cat = 'SEBC';
                                break;
                              case '4':
                                $cat = 'ST';
                                break;
                              case '5':
                                $cat = 'SC';
                                break;
                              
                             
                             }
                   $count++;
                   ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['f_name'].' '.$row['l_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo ($row['sex']==0)?'FEMALE':'MALE'; ?></td>
                       
                        
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