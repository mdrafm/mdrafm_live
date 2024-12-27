<?php

  include 'database.php';
  $db = new Database();

  
if( isset($_POST['action']) && $_POST['action'] == 'reject_exam_by_incharge'){
    
    $remark = $_POST['msg'];
    $exam_id = $_POST['id'];
    $table = $_POST['table'];
  
    //$db->delete($table,'id='.$delete_id);
    $db->update($table,["status"=> 0,"remark" =>$remark],'id='.$exam_id);
    $res = $db->getResult();
    //print_r($res);
    if($res){
      echo "success";
    }
    else{
      //print_r($db->getResult());
      echo "error#".$res[0];
    }
  }
  if( isset($_POST['action']) && $_POST['action'] == 'approve_exam_by_incharge'){
    
    
    $exam_id = $_POST['id'];
    $table = $_POST['table'];
  
    //$db->delete($table,'id='.$delete_id);
    $db->update($table,["status"=> 3],'id='.$exam_id);
    $res = $db->getResult();
    //print_r($res);
    if($res){
      echo "success";
    }
    else{
      //print_r($db->getResult());
      echo "error#".$res[0];
    }
  }
  if( isset($_POST['action']) && $_POST['action'] == 'approve_exam_by_director'){
    
    
    $exam_id = $_POST['id'];
    $table = $_POST['table'];
  
    //$db->delete($table,'id='.$delete_id);
    $db->update($table,["status"=> 4],'id='.$exam_id);
    $res = $db->getResult();
    //print_r($res);
    if($res){
      echo "success";
    }
    else{
      //print_r($db->getResult());
      echo "error#".$res[0];
    }
  }

?>