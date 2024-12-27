<?php

include 'database.php';
$db = new Database();

if( isset($_POST['action']) && $_POST['action'] == 'upload_doc'){
    //print_r($_POST);
  
    $type = $_POST['type'];
    $timeTable_id = $_POST['tbl_id'];
    $program_id = $_POST['program_id'];
    $session = $_POST['session'];
    $user_id = $_POST['user_id'];
    $trng_type = $_POST['trng_type'];
  
    $filename = strtolower(basename($_FILES['file']['name']));
    $ext = substr($filename, strrpos($filename, '.') + 1);
   
    $md_referenceno = gen_uuid();
    $ext=".".$ext;
    $new_filename = 'course_material/'. $md_referenceno . $ext;
    $doc_name = $md_referenceno . $ext;

    
     $db->select('tbl_tranning_document',"id,time_tbl_id,doc_name",null," trng_type = '$trng_type' AND time_tbl_id =".$timeTable_id,null,null);
     $res = $db->getResult();

     if($res){

        foreach($res as $row){
           
            if(move_uploaded_file($_FILES['file']['tmp_name'],$new_filename)){
                    
                    if($row['doc_name']==''){
                      $new_doc_name = $doc_name;
                    }else{
                      $new_doc_name = $row['doc_name'].','.$doc_name;
                    }
                    
                   // echo $doc_name;exit;
     
                     $db->update('tbl_tranning_document',['doc_name'=>$new_doc_name],'id='.$row['id']);
                         if($db->getResult()){
                             echo "success#Document uploaded Successfully";
                         }
                         else{
                          
                           echo "error#".$res[0];
                         }
     
            }
                 
     
          }
      
        
     }else{
       
        if(move_uploaded_file($_FILES['file']['tmp_name'],$new_filename)){
            
            $db->insert_sql("INSERT INTO `tbl_tranning_document` (`trng_type`,`time_tbl_id`, `session_no`, `doc_type`, `doc_name`, `add_by`) 
                    VALUES ('$trng_type','$timeTable_id', '$session', '$type', '$doc_name', '$user_id');");
            if($db->getResult()){
                echo "success#Document uploaded Successfully";
            }
            else{
                
                echo "error#".$res[0];
            }
        }
     }
     

   exit;
    
}

if( isset($_POST['action']) && $_POST['action'] == 'upload_master_doc'){
   
    
    $subject = $_POST['subject'];
    $facultyName = $_POST['facultyName'];
    $trng_type = $_POST['trng_type'];
  
    $filename = strtolower(basename($_FILES['file']['name']));
    $ext = substr($filename, strrpos($filename, '.') + 1);
   
    $md_referenceno = gen_uuid();
    $ext=".".$ext;
    $new_filename = 'course_material/misc/'. $md_referenceno . $ext;
    $doc_name = $md_referenceno . $ext;

    if(move_uploaded_file($_FILES['file']['tmp_name'],$new_filename)){
       
            
        $db->insert_sql("INSERT INTO `tbl_mid_course_material_master` (`subject`, `faculty_name`, `file_name`, `flag`, `status`) 
                VALUES ('$subject','$facultyName', '$doc_name', '$trng_type',1)");
        if($db->getResult()){
            echo "success#Document uploaded Successfully";
        }
        else{
            
            echo "error#".$res[0];
        }
    }
     

   exit;
}

if( isset($_POST['action']) && $_POST['action'] == 'add_mid_study_material'){

    $material_id = $_POST['material_id'];
    $program_id = $_POST['program_id'];

    $db->insert_sql("INSERT INTO `tbl_mid_course_material` (`id`, `cousrse_material_id`, `program_id`, `status`) VALUES (NULL, '$material_id', '$program_id', 1)");
    if($db->getResult()){
        echo "success#Document uploaded Successfully";
    }
    else{
        
        echo "error#";
    }

}
if( isset($_POST['action']) && $_POST['action'] == 'remove_mid_study_material'){

    $material_id = $_POST['material_id'];
    $program_id = $_POST['program_id'];

    $db->delete('tbl_mid_course_material', 'program_id=' . $program_id);
    if($db->getResult()){
        echo "success#Document deleted Successfully";
    }
    else{
        
        echo "error#";
    }

}
   

if( isset($_POST['action']) && $_POST['action'] == 'update_doc'){
$field = $_POST['field'];
$update_id = $_POST['update_id'];
$user_id= $_SESSION['user_id'];

$test = explode('.', $_FILES["file"]["name"]);
$text = end($test);
$rand_name = gen_uuid();
$ext=".".$text;
$name = $user_id.'-'.$rand_name . $ext;
$location = 'uploads/' . $name;

  

if( move_uploaded_file($_FILES["file"]["tmp_name"], $location)){
  
  $db->update('tbl_traniee_documents',["$field"=>$name],'id='.$update_id);
  $res2 = $db->getResult();
      if($res2){
          echo "success#".$res2[1];
      }
      else{
      
      echo "error#".$res2[0];
      }
}

}

if (isset($_POST['action']) && $_POST['action'] == 'remove_study_material'){
  $delete_id = $_POST['id'];
  $doc_name = $_POST['doc_name'];
  
  $db->select('tbl_tranning_document',"doc_name",null,"id =".$delete_id,null,null);
   $res =  $db->getResult();
   foreach($res as $row1){
       $doc_list = explode(",",$row1['doc_name']);
       //$new_dic_list = unset($doc_list[''])

       if (($key = array_search($doc_name, $doc_list)) !== false) {
            unset($doc_list[$key]);
        }

       //print_r($doc_list);
       $new_doc_list = implode(', ', $doc_list);
       $file_path = "/mdrafm/admin/course_material/".$doc_name;
       $path = $_SERVER['DOCUMENT_ROOT'].$file_path;
      
       if($path)
         {
             unlink($path);
           
             $db->update('tbl_tranning_document',['doc_name'=>$new_doc_list],'id='.$delete_id);
             $res = $db->getResult();

             if($res){
                 echo "success#".$res[1];
             }
             else{
                 echo "error#".$res[0];
             }
         }
         else
         {
             echo "File Not Found";
             exit;
         }
   }
}
if (isset($_POST['action']) && $_POST['action'] == 'remove_misc_study_material'){
    $delete_id = $_POST['id'];
    $file_name = $_POST['file_name'];
    
        
         $file_path = "/admin/course_material/misc/".$file_name;
         $path = $_SERVER['DOCUMENT_ROOT'].$file_path;
        
         if($path)
           {
               unlink($path);
             
               $db->delete('tbl_mid_course_material_master','id='.$delete_id);
               $res = $db->getResult();
              // print_r($res);
               if($res){
                   echo "success#";
               }
               else{
                   echo "error#";
               }
           }
           else
           {
               echo "File Not Found";
               exit;
           }
 
}


if (isset($_POST['action']) && $_POST['action'] == 'remove_trainee_doc'){
  $delete_id = $_POST['id'];
  $doc_name = $_POST['doc'];
  $field_name = $_POST['field_name'];
  
      
       $file_path = "/mdrafm/admin/uploads/".$doc_name;
       $path = $_SERVER['DOCUMENT_ROOT'].$file_path;
      
       if($path)
         {
             unlink($path);
           
             $db->update('tbl_traniee_documents',["$field_name"=>''],'id='.$delete_id);
             $res = $db->getResult();
             //print_r($res);
             if($res){
                 echo "success#".$res[1];
             }
             else{
                 echo "error#".$res[0];
             }
         }
         else
         {
             echo "File Not Found";
             exit;
         }
   }
   //print_r($_POST);exit;
   if (isset($_POST['action']) && $_POST['action'] == 'update_id_proof'){
    $id_type = $_POST['id_type'];
    $update_id = $_POST['update_id'];
    
    
        $db->update('tbl_traniee_documents',["idproof_type"=>$id_type],'id='.$update_id);
        $res = $db->getResult();
       // print_r($res);
        if($res){
            echo "success";
        }
        else{
            echo "error";
        }
     }


function gen_uuid() 
{ 
      $s = strtoupper(md5(uniqid(date("YmdHis"),true))); 
       $guidText =substr($s,0,4)."-".substr($s,4,4)."-" ;
       
       $date=date("his");
     return $guidText.$date;
}

?>