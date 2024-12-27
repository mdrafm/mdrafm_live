<?php

  include 'database.php';
  require '../vendor/autoload.php';

  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
 require 'formValidation.php';
  
  $db = new Database();
 $valid = new Validation();
  if(isset($_POST['action']) && $_POST['action'] == 'upload_excel'){
    // print_r($_POST);
    // print_r($_FILES);
  
      //$file = $_FILES['file']['tmp_name'];
  
          $inputFileNamePath = $_FILES['file']['tmp_name'];
          $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
          $data = $spreadsheet->getActiveSheet()->toArray();
          // unset($data[0]);
          // print_r($data);
          // exit;
          
          ?>
                <table id="import_excel_data" class="table">
                    <thead class="" style="background: #315682;color:#fff;">
  
                        <th>Sl No</th>
                        <th>Name </th>
                        <th> Roll No </th>
                        <th>Hrms id</th>
                        <th>Desig</th>
                        <th>office</th>
                       <!--  <th>age</th>
                        <th>sex</th>
                        <th>category</th>
                        <th>edu qualification</th>
                        <th>joining dt</th> -->
                         <th>Phone</th>
                        <th>Email</th>
                       
                       <!--  <th>prev industry</th> -->
                       
                    </thead>
                    <tbody>
                        <?php 
                                              
                                              
                        $count = 0;
  
                          foreach($data as $row){
                            unset($row[6]);
                             //print_r($row);
                              $count++;
                              $cat = 0;
                              //print_r($row);exit;
                            if( trim($row[0]) !='' && trim($row[1]) != '' ){
                             
                            
                            
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row[1]; ?></td>
                            <td><?php echo $row[0]; ?></td>
                            <td>0</td>
                            <td><?php echo trim($row[2]); ?> </td>
                            <td><?php echo trim($row[3]); ?> </td>
                            <td><?php echo trim($row[4]); ?> </td>
                            
                            <td><?php echo trim($row[5]); ?> </td>
                           
                            
  
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
     //   exit;
   $tableData = $_POST['tableData'];
  
   // Decode the JSON array
     $tableData = json_decode($tableData,TRUE);
     $cnt =0;
     foreach($tableData as $data){
        //$data['batch_id'] = 3;
        $cnt++;
       
       // print_r($data);
       // exit;

       $valid_phn=$valid->phoneNumber(trim($data['phone']),'Phone',''); 
     if($valid_phn=='error')
     {
        echo "err#Invalid Phone Number - ".$data['phone'];
     }else
     {
        $db->select("tbl_dept_trainee_registration", "*", null, "phone='" . $data['phone'] . "'", null, null);
        $res1 = $db->getResult();
          if(empty($res1))
          {
              $insert_sql = "INSERT INTO `tbl_dept_trainee_registration` (`id`,`roll_no`, `user_id`, `program_id`, `trng_type`, `name`, `hrms_id`, `designation`, `office_name`, `email`, `phone`, `mdrafm_status`, `status`, `mail_status`) 
              VALUES (NULL,'".$data['roll_no']."', '0', '92', '5', '".$data['name']."', '".$data['hrms_id']."', '".$data['desig']."', '".$data['office']."','".$data['email']."', '".trim($data['phone'])."','1', '0', '0')";

             $db->insert_sql($insert_sql);
             $res = $db->getResult();
          }  
     }
    
    // $insert_sql = "INSERT INTO `tbl_dept_trainee_registration` (`id`,`roll_no`, `user_id`, `program_id`, `trng_type`, `name`, `hrms_id`, `designation`, `office_name`,`age`,`sex`,`category`,`edu_qualification`, `email`, `phone`,`previous_industry`, `mdrafm_status`, `status`, `mail_status`) 
    // VALUES (NULL,'".$data['roll_no']."', '0', '17', '3', '".$data['name']."', '".$data['hrms_id']."', '".$data['desig']."', '".$data['office']."','".$data['age']."','".$data['sex']."','".$data['category']."','".$data['edu_qualification']."','".$data['email']."', '".$data['phone']."','".$data['previous_industry']."', '1', '0', '0')";


    
  //print_r($res);
    //echo $cnt;
     }
       echo "success#Data Saved Successfuly";
 }


  ?>