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
                        <th>Fist Name </th>
                        <th>Last Name </th>
                       <!--  <th>DOB</th> -->
                        <th>Category </th>
                        <th>Sex</th>
                        <th>Phone</th>
                        <th>Email</th>
                        
                        <th>Roll No</th>
                        <th>District</th>
                       
  
                    </thead>
                    <tbody>
                        <?php 
                                              
                                              
                        $count = 0;
  
                          foreach($data as $row){
                             
                              $count++;
                              $cat = 0;
                              //print_r($row);
                            if( trim($row[0]) !='' && trim($row[1]) != '' && trim($row[2]) != '' && trim($row[3]) != ''){
                              //$name = explode(' ', trim($row[0]));
                              //$name = split_name(trim($row[0]));
                             // print_r($name);
                             switch ($row[2]) {
                              case 'UR':
                                $cat = 1;
                                break;
                              case 'SEBC':
                                $cat = 3;
                                break;
                              case 'ST':
                                $cat = 4;
                                break;
                              case 'SC':
                                $cat = 5;
                                break;
                              
                             
                             }
                              //exit;
                            
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row[0]; ?></td>
                            <td><?php echo $row[1]; ?></td>
                          
                            <td><?php echo $cat; ?></td>
                            <td><?php echo ($row[3] == 'MALE')?1:0; ?></td>
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
    //  print_r($_POST);
    //    exit;
   $tableData = stripcslashes($_POST['tableData']);
  
   // Decode the JSON array
     $tableData = json_decode($tableData,TRUE);
     foreach($tableData as $data){
        //$data['batch_id'] = 3;
       // $dob  = Date("Y-m-d",strtotime($data['dob']));
       // print_r($data);
       // exit;
      
    
   echo $insert_sql = "INSERT INTO `tbl_new_recruite` (`id`, `batch_id`, `program_id`, `trng_type`, `f_name`, `l_name`, `dob`, `category`, `hrms_id`, `place_of_posting`, `sex`, `email`, `phone`, `roll_no`, `district`, `fin_status`, `mdrafm_status`, `email_status`, `add_on`) 
                   VALUES (NULL, '14', '14', '1', '".$data['f_name']."', '".$data['l_name']."', '', '".$data['category']."', '', '', '".$data['sex']."','".$data['phone']."', '".$data['email']."', '".$data['roll_no']."', '".$data['district']."', '0', '1', '0', '')";

  $db->insert_sql($insert_sql);
  $res = $db->getResult();
  print_r($res);
 
     }
 }


  function split_name($name) {
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
    return array($first_name, $last_name);
}

  ?>