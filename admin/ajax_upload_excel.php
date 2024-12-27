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
                        <th>Name </th>
                        <th>Phone</th>
                        <th>group</th>
                        <!-- <th>Designation</th>
                        <th>Office </th> -->
                       
                    </thead>
                    <tbody>
                        <?php 
                                              
                                              
                        $count = 0;
  //print_r($data);
                          foreach($data as $row){
                             
                              $count++;
                              $cat = 0;
                              //print_r($row);
                            if( trim($row[0]) !='' && trim($row[1]) != '' && trim($row[2]) != '' && trim($row[3]) != ''){
                              //$name = explode(' ', trim($row[0]));
                           
                            
                              //exit;
                            
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                           
                            <td><?php echo $row[1]; ?></td>
                            <td><?php echo trim($row[2]); ?> </td>
                            
                            <td><?php echo trim($row[3]); ?> </td>
                            <!-- <td><?php //echo trim($row[5]); ?> </td>
                            <td><?php //echo trim($row[6]); ?> </td> -->
                           
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
    //  print_r($_POST);
    //    exit;
   //$tableData = stripcslashes($_POST['tableData']);
  
   // Decode the JSON array
     $tableData = json_decode($_POST['tableData'],TRUE);
     //print_r($tableData);
     foreach($tableData as $data){
      //print_r($data);
        //$data['batch_id'] = 3;
       
    //    print_r($data);
    //    exit;
      
    
  //  echo $insert_sql = "INSERT INTO `tbl_new_recruite` (`id`, `batch_id`, `program_id`, `trng_type`, `f_name`, `l_name`, `dob`, `category`, `hrms_id`, `place_of_posting`, `sex`, `email`, `phone`, `roll_no`, `district`, `fin_status`, `mdrafm_status`, `email_status`, `add_on`) 
  //                  VALUES (NULL, '11', '', '1', '".$data['f_name']."', '".$data['l_name']."', '".$dob."', '".$data['category']."', '', '', '".$data['sex']."', '".$data['email']."','".$data['phone']."', '".$data['roll_no']."', '".$data['district']."', '0', '0', '0', '2023-01-05 18:43:33.000000')";

   $insert_sql =   "INSERT INTO `tbl_trainee_registration` (`id`, `program_id`, `trng_type`, `name`, `hrms_id`, `designation`, `office_name`, `email`, `phone`, `status`, `mail_status`) 
    VALUES (NULL, '3', '3', '".$data['name']."', '0', '".$data['designation']."', '".$data['office']."', '".$data['email']."','".$data['mobile']."', '1', '1')";
//exit;
  $db->insert_sql($insert_sql);
  $res = $db->getResult();
  print_r($res);
 
     }
 }

 if(isset($_POST['action']) && $_POST['action'] == 'import_excel_groupe'){
  //  print_r($_POST);
  //    exit;
 //$tableData = stripcslashes($_POST['tableData']);

 // Decode the JSON array
   //$tableData = json_decode($_POST['tableData'][0],TRUE);
   //print_r();
   foreach($_POST['tableData'] as $data){
   // print_r($data);
    if($data['group'] == 12){
        $name = explode(' ',$data['name']);
        if(count($name)==3){
          $fname = $name[0].' '.$name[1];
          $lame = $name[2];
        }else{
          $fname = $name[0];
          $lame = $name[1];
        }
       
        $update_sql = "UPDATE `tbl_new_recruite` SET `program_id` = '12' WHERE f_name = '".$fname."' AND l_name = '".$lame."' AND program_id = 9";
        $db->update_dir( $update_sql);
        $res = $db->getResult();
        print_r($res);
    }
   
      //$data['batch_id'] = 3;
     
  //    print_r($data);
  //    exit;
    
  
   }
}

  function split_name($name) {
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
    return array($first_name, $last_name);
}

  ?>