<?php

  include 'database.php';
  require '../vendor/autoload.php';

  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
 
  
  $db = new Database();

  if(isset($_POST['action']) && $_POST['action'] == 'upload_excel'){
    // print_r($_POST);
    // print_r($_FILES);
  
      //$file = $_FILES['file']['tmp_name'];
  
          $inputFileNamePath = $_FILES['file']['tmp_name'];
          $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
          $data = $spreadsheet->getActiveSheet()->toArray();
          unset($data[0]);
          // print_r($data);
          // exit;
          
          ?>
                <table id="import_excel_data" class="table">
                    <thead class="" style="background: #315682;color:#fff;">
  
                        <th>Sl No</th>
                        <!-- <th>Roll no</th> -->
                        <th>Name </th>
                        <th>Hrms id</th>
                        <th>Desig</th>
                        <th>office</th>
                        <th>Email</th>
                        <th>Phone</th>
                       
                    </thead>
                    <tbody>
                        <?php 
                                              
                                              
                        $count = 0;
  
                          foreach($data as $row){
                             
                              $count++;
                              $cat = 0;
                             // print_r($row);
                            if( trim($row[1]) !=''){
                             
                            
                            
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row[1]; ?></td>
                            
                            <td><?php echo trim($row[2]); ?> </td>
                            <td><?php echo trim($row[3]); ?> </td>
                            <td><?php echo trim($row[4]); ?> </td>
                            <td><?php echo trim($row[5]); ?> </td>
                            <td><?php echo trim($row[6]); ?> </td>
                            <td><?php echo trim($row[7]); ?> </td>
                            
  
                        </tr>
                        <?php
                            }
                                                    }
                                             
                                              
                                      
                                              
                                              ?>
  
                    </tbody>
                </table>
  <?php
           
    
  }

  if(isset($_POST['action']) && $_POST['action'] == 'import_excel_db'){
      // print_r($_POST);
      //  exit;
   //$tableData = stripcslashes($_POST['tableData']);
    $tableData = $_POST['tableData'];
  
   // Decode the JSON array
    $tableData = json_decode($tableData,TRUE);

      // print_r($tableData);
      // echo 123;
     $cnt =0;
     foreach($tableData as $data){
        //$data['batch_id'] = 3;
        $cnt++;
       
       // print_r($data);
       // exit;
      
        $insert_sql = "INSERT INTO `tbl_dept_trainee_registration` (`id`,`roll_no`, `user_id`, `program_id`, `trng_type`, `name`, `hrms_id`, `designation`, `office_name`, `email`, `phone`, `mdrafm_status`, `status`, `mail_status`) 
        VALUES (NULL,'".$data['roll_no']."', '0', '13', '3', '".$data['name']."', '".$data['hrms_id']."', '".$data['desig']."', '".$data['office']."','".$data['email']."', '".$data['phone']."', '1', '0', '0')";

   
  $db->insert_sql($insert_sql);
  $res = $db->getResult();
  print_r($res);
 echo $cnt;
     }
 }


  ?>