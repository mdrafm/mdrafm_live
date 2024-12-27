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
                        <th>Syllabus </th>
                        <th>Term </th>
                        <th>Paper </th>
                        <th>Question </th>
                        <th>Option 1</th>
                        <th>Option 2 </th>
                        <th>Option 3</th>
                        <th>Option 4</th>
                        <th>write option</th>
                                             
  
                    </thead>
                    <tbody>
                        <?php 
                                              
                                              
                        $count = 0;
  
                          foreach($data as $row){
                             
                              $count++;
                              $cat = 0;
                              // print_r($row);
                              // exit;
                            if( trim($row[0]) !='' && trim($row[1]) != '' && trim($row[2]) != '' && trim($row[3]) != ''){
                              //$name = explode(' ', trim($row[0]));
                            $option = '';
                            switch ($row[6]) {
                              case 'A':
                                $option = 1;
                                break;
                              case 'B':
                                $option = 2;
                                break;
                              case 'C':
                                $option = 3;
                                break;
                              case 'D':
                                $option = 4;
                                break;
                              
                             
                             }
                            
                        ?>
                        <tr>
                            <td><?php echo $count ?> </td>
                            <td><?php echo trim($row[0]); ?> </td>
                            <td><?php echo trim($row[1]); ?> </td>
                            <td><?php echo trim($row[2]); ?> </td>
                            <td><?php echo trim($row[3]); ?> </td>
                            <td><?php echo trim($row[4]); ?> </td>
                            <td><?php echo trim($row[5]); ?> </td>
                            <td><?php echo trim($row[6]); ?> </td>
                            <td><?php echo trim($row[7]); ?> </td>
                            <td><?php echo trim($row[8]);?> </td>
                           
  
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
    $tableData = $_POST['tableData'];
   

     foreach($tableData as $data){
     // print_r($data);
    // exit;
     $insert_sql = "INSERT INTO `exam_subject_question` (syllabus_id, term_id, paper_id, exam_subject_question_title, exam_subject_question_answer) 
                   VALUES ( '".$data['syllabus_id']."', '".$data['term_id']."','".$data['paper_id']."', '".$data['exam_subject_question_title']."', '".$data['exam_subject_question_answer']."')";

      $db->insert_sql($insert_sql);
      $res = $db->getResult();
      $exam_subject_question_id = $res[0];

     for($count = 1; $count <= 4; $count++)
		{
			//echo $count;           option_title_1
		 	$num = $data['option_title_'.$count];
      //exit;
			// $data_option = array(
			// 	':exam_subject_question_id'		=>	$exam_subject_question_id,
			// 	':question_option_number'		=>	$count,
			// 	':question_option_title'		=>	$object->clean_input($_POST['option_title_' . $count])
			// );
       
			$sql = "
			INSERT INTO question_option 
			(exam_subject_question_id, question_option_number, question_option_title) 
			VALUES ('".$exam_subject_question_id."','".$count."','".$data['option_title_'.$count]."')
			";

      $db->insert_sql($sql);
      $res2 = $db->getResult();
      print_r($res2);
			
		}
      // print_r($res);
      // exit;
 
     }
 }


  function split_name($name) {
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
    return array($first_name, $last_name);
}

  ?>