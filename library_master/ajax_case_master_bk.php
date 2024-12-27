<?php
include('../admin/database.php');
$db = new Database();
session_start(); 
$user_id=$_SESSION['user_id'];
//print_r($_POST);
$pos = array_search("action",array_keys($_POST));
$frm_data = array_splice($_POST,0,$pos);

if(isset($_POST['action']) && $_POST['action'] == 'add_master'){
  
    $update_id =$_POST['update_id'];
    $table = $_POST['table']; 
     //update
    if ($update_id != '' ){
       $db->update($table, $frm_data,'id='.$update_id);
       $res = $db->getResult();
      
        if($res){
            echo "success#".$res[1];
        }
        else{
         
          echo "error#".$res[0];
        } 
    }
    //add
    else{
        $db->insert($table, $frm_data);
       $res = $db->getResult();
       //print_r($res);
      if($res){
          echo "success#".$res[1];
      }
      else{
        //print_r($db->getResult());
        echo "error#".$res[0];
      }
    }
    
  }
  //remove case(update status only)
  if(isset($_POST['action']) && $_POST['action'] == 'remove_case'){
    $case_id = $_POST['case_id'];
    $table = $_POST['table'];

    $db->update($table, ["status" => 0 ],'id='.$case_id);
    $res = $db->getResult();
   // print_r($res);
    if($res){
        echo "success#".$res[1];
    }
    else{
        //print_r($db->getResult());
        echo "error#".$res[0];
    }
  }
  //Delete book(update status only)
  if(isset($_POST['action']) && $_POST['action'] == 'delete_case'){
    $book_id = $_POST['book_id'];
    $table = $_POST['table'];

    $db->update($table, ["status" => 2 ],'id='.$book_id);
    $res = $db->getResult();
   // print_r($res);
    if($res){
        echo "success#".$res[1];
    }
    else{
        //print_r($db->getResult());
        echo "error#".$res[0];
    }
  }
  //Delete from table 
  if(isset($_POST['action']) && $_POST['action'] == 'delete_data'){
    $delete_id = $_POST['delete_id']; 
    $table = $_POST['table'];

    $db->delete($table,'id='.$delete_id);    
    $res = $db->getResult();
   //print_r($res);
    if($res){
        echo "success#".$res[0];
    }
    else{
        //print_r($db->getResult());
        echo "error#".$res[1];
    }
  }
  //update status of book request table 
  if(isset($_POST['action']) && $_POST['action'] == 'update_manual'){
    $update_id = $_POST['update_id'];
    $status = $_POST['status'];
    $table = $_POST['table'];

    $db->update($table, ["status" => $status ],'id='.$update_id);
    $res = $db->getResult();
   // print_r($res);
    if($res){
        echo "success#".$res[1];
    }
    else{
        //print_r($db->getResult());
        echo "error#".$res[0];
    }
  }
   //update status of book issue table 
   if(isset($_POST['action']) && $_POST['action'] == 'update_issue_tbl'){
    $ref_update_id = $_POST['ref_update_id'];
    $issue_update_id = $_POST['issue_update_id'];
    $issue_date = $_POST['issue_date'];
    $request_date = $_POST['request_date'];
    $no_of_days = $_POST['no_of_days'];
    $table1 = $_POST['table1'];
    $table2 = $_POST['table2'];
    if($issue_date < $request_date)
    {
      echo "error#Issue date should be greater than request date";
    }else
    {
      $db->update($table1, ["bk_ref_id" => $ref_update_id,"issue_date" => $issue_date,"no_of_days" => $no_of_days,"status" => 2],'id='.$issue_update_id);
      $res1 = $db->getResult();
      if($res1)
      {
        $db->update($table2, ["status" => 1 ],'id='.$ref_update_id);
        $res2 = $db->getResult();
      }
      if($res2){
          echo "success#".$res2[1];
      }
      else{
          //print_r($db->getResult());
          echo "error#".$res2[0];
      }
    }
  }
  //add book details
  if(isset($_POST['action']) && $_POST['action'] == 'inesrt_book_details'){
    $quantity=$_POST['quantity'];
    $book_ref_no=$_POST['book_ref_no'];
    $book_name=$_POST['book_name'];
    $author_name=$_POST['author_name'];
    $edition=$_POST['edition'];
    $year_of_publication=$_POST['year_of_publication'];
    $place_publisher=$_POST['place_publisher'];
    $volume=$_POST['volume'];
    $page=$_POST['page'];
    $price=$_POST['price'];
    $location=$_POST['location'];
    $row=$_POST['row'];
    $book_type=$_POST['book_type'];
    $subject_id=$_POST['subject_name'];
    $table1 = $_POST['table1'];
    $table2 = $_POST['table2'];
	$cnt_ext_ref = array();
	
    foreach($book_ref_no as $ref)
      {
        $db->select($table2,"*",null,'reference_no= "'.$ref.'"',null,null);
        $res_book_ref= $db->getResult(); 
		
        if(!empty($res_book_ref))
         {
		  $cnt_ext_ref[] =  $ref;
         } 
      } 
	  if(!empty($cnt_ext_ref)){
		  echo 'accesno#'.implode(',',$cnt_ext_ref);
	  }else{
		   $frm_data1=array(
                    'book_name'=>$book_name,
                    'author_name'=>$author_name,
                    'quantity'=>$quantity,
                    'subject_id'=>$subject_id,
                    'book_type'=>$book_type,
                    'status'=>0
                  );
                  $db->insert($table1, $frm_data1);
                  $res1 = $db->getResult();
                  $last_insert_id=$res1['0'];
				  if($last_insert_id!='')
				  {
					  foreach($book_ref_no as $ref)
						{
						  $frm_data2=array(
							'tbl_book_id'=>$last_insert_id,
							'reference_no'=>$ref,
							'book_name'=>$book_name,
							'author_name'=>$author_name,
							'edition'=>$edition,
							'year_of_publication'=>$year_of_publication,
							'place_publisher'=>$place_publisher,
							'volume'=>$volume,
							'page'=>$page,
							'price'=>$price,
							'location'=>$location,
							'row'=>$row,
							'status'=>0
						  );
						  $db->insert($table2, $frm_data2);
						  $res2 = $db->getResult();
						 }
						 if($res2){
							echo "success#".$res2[1];
							}
							else{
							echo "error#";
							}
					}				
			
	  }
	  // print_r($cnt_ext_ref);
 }
 if(isset($_POST['action']) && $_POST['action'] == 'update_book_details'){
   //print_r($_POST); exit;
   $update_id=$_POST['update_id'];
   $bk_update_id=$_POST['bk_update_id'];
   $book_ref_no = $_POST['book_ref_no'];
  //$quantity=$_POST['quantity'];
  $book_name=$_POST['book_name'];
  $author_name=$_POST['author_name'];
  $edition=$_POST['edition'];
  $year_of_publication=$_POST['year_of_publication'];
  $place_publisher=$_POST['place_publisher'];
  $page=$_POST['page'];
  $volume=$_POST['volume'];
  $price=$_POST['price'];
  $location=$_POST['location'];
  $row=$_POST['row'];
  $book_type=$_POST['book_type'];
  $subject_id=$_POST['subject_name'];
  $table1 = $_POST['table1'];
  $table2 = $_POST['table2'];
  //print_r($book_ref_no);
  $frm_data1=array(
    'book_name'=>$book_name,
    'author_name'=>$author_name,
    'subject_id'=>$subject_id,
    'book_type'=>$book_type,
    'status'=>0
  );  
  $db->update($table1, $frm_data1,'id='.$bk_update_id);
  $res = $db->getResult();
  
  if($res){
      $frm_data2=array(
        'reference_no'=>$book_ref_no,
        'edition'=>$edition,
        'year_of_publication'=>$year_of_publication,
        'place_publisher'=>$place_publisher,
        'volume'=>$volume,
        'page'=>$page,
        'price'=>$price,
        'location'=>$location,
        'row'=>$row
      );
      $db->update($table2, $frm_data2,'id='.$update_id);
     echo "success#";
   }
 else{
   //print_r($db->getResult());
   echo "error#";
  }
}
 //update status of book issue table 
 if(isset($_POST['action']) && $_POST['action'] == 'update_return_tbl'){
  $bk_req_id = $_POST['bk_req_id'];
  $book_ref_number = $_POST['book_ref_id'];
  $return_date = $_POST['return_date'];
  $fine = $_POST['fine'];
  $table1 = $_POST['table1'];
  $table2 = $_POST['table2'];
  $issue_date = $_POST['issue_date'];
  if($return_date < $issue_date)
  {
    echo "error#Return date should be greater than issue date";
  }else
  {
    $db->update($table1, ["return_date" => $return_date,"fine" => $fine,"status" => 4],'id='.$bk_req_id);
    $res = $db->getResult();
    $db->update($table2, ["status" => 0],'reference_no='.$book_ref_number);
    $res2 = $db->getResult();
    if($res){
        echo "success#".$res[1];
    }
    else{
        echo "error#".$res[0];
    }
  }
}
if(isset($_POST['action']) && $_POST['action'] == 'get_ref_number'){
  $qnt_val = $_POST['val_qnt']; 
  $ref_no = $_POST['ref_no'];
  if(!empty($qnt_val))
  {
    //$ref_no = $_POST['ref_no'];
  ?>
  <div class="col-9" style="margin-left:4%;margin-right:2%;padding:1%">
    <label>Acc. No :</label>
    <?php 
    for($i=1;$i<=$qnt_val;$i++)
    { 
      
        ?>
        <input class="form-control me-3" name="book_reff_no[]" id="book_reff_no"
        value="<?=isset($ref_no)?$ref_no:''?>"
        placeholder="Enter Acc. No." required></br>
    <?php if(is_numeric($_POST['ref_no']))
          {
             $ref_no=$ref_no + 1;
          }
             
} ?></div>
<?php }
    ?>
    

<?php
}
//update/Insert Book Quantity in book details table 
if(isset($_POST['action']) && $_POST['action'] == 'update_book_qt_details'){
    $bk_update_id = $_POST['update_id'];
    $quantity=$_POST['quantity'];
    if(!empty($_POST['book_ref_no']))
    {
      $book_ref_no=$_POST['book_ref_no'];
    }
    $book_name=$_POST['book_name'];
    $author_name=$_POST['author_name'];
    $edition=$_POST['edition'];
    $year_of_publication=$_POST['year_of_publication'];
    $place_publisher=$_POST['place_publisher'];
    $page=$_POST['page'];
    $price=$_POST['price'];
    $location=$_POST['location'];
    $row=$_POST['row'];
    $book_type=$_POST['book_type'];
    $subject_id=$_POST['subject_name'];
    $table1 = $_POST['table1'];
    $table2 = $_POST['table2'];
    //print_r($book_ref_no);
    $frm_data1=array(
      'book_name'=>$book_name,
      'author_name'=>$author_name,
      'quantity'=>$quantity,
      'subject_id'=>$subject_id,
      'book_type'=>$book_type,
      'status'=>0
    );
    $db->update($table1, $frm_data1,'id='.$bk_update_id);
    $res = $db->getResult();
    $frm_data3=array(
      'book_name'=>$book_name,
      'author_name'=>$author_name,
    );
    $db->update($table2, $frm_data3,'tbl_book_id='.$bk_update_id);
    $res1 = $db->getResult();

    if($res){
      if(!empty($book_ref_no))
      { 
        foreach($book_ref_no as $ref)
        {
          $frm_data2=array(
            'tbl_book_id'=>$bk_update_id,
            'reference_no'=>$ref,
            'book_name'=>$book_name,
            'author_name'=>$author_name,
            'edition'=>$edition,
            'year_of_publication'=>$year_of_publication,
            'place_publisher'=>$place_publisher,
            'page'=>$page,
            'price'=>$price,
            'location'=>$location,
            'row'=>$row,
            'status'=>0
          );
          $db->insert($table2, $frm_data2);
        }
      }
       echo "success#";
     }
   else{
     //print_r($db->getResult());
     echo "error#";
    }
}
//Merge Book data
if(isset($_POST['action']) && $_POST['action'] == 'merge_book'){
  $old_bk_id = $_POST['old_bk_id'];
  $new_bk_id=$_POST['new_bk_id'];
  $table1 = $_POST['table1'];
  $table2 = $_POST['table2'];
  $old_quantity = $_POST['old_quantity'];
  
  $db->update($table2,["tbl_book_id" => $new_bk_id],'tbl_book_id='.$old_bk_id);
  $res = $db->getResult();
  if($res){
	
      $sql1 = "UPDATE tbl_book_details SET quantity = quantity+".$old_quantity." WHERE id= '".$new_bk_id."'";
	  $db->update_dir($sql1);
	  
	  $db->update($table1,["status" =>1],'id='.$old_bk_id);
     
     echo "success#";
   }
 else{
   //print_r($db->getResult());
   echo "error#";
  }
}
 //Delete from table 
 if(isset($_POST['action']) && $_POST['action'] == 'delete_book_type'){
  $delete_id = $_POST['delete_id']; 
  $table = $_POST['table'];
  $db->select('tbl_subject_name',"*",null,'book_category= "'.$delete_id.'"',null,null);
  $res_book_cat = $db->getResult(); 
  if(!empty($res_book_cat))
   {
       echo "error#First delete subject of this Book Type";
    }else
    {
      $db->delete($table,'id='.$delete_id);    
      $res = $db->getResult();
     //print_r($res);
      if($res){
          echo "success#".$res[0];
      }
      else{
          //print_r($db->getResult());
          echo "error#".$res[1];
      }
    }
}
//Book Renew Details
if(isset($_POST['action']) && $_POST['action'] == 'insert_renew_tbl'){
  $bk_req_id=$_POST['bk_req_id'];
  $renew_date=$_POST['renew_date'];
  $no_of_days=$_POST['no_of_days'];
  $table1 = $_POST['table1'];
  $table2 = $_POST['table2'];
  //print_r($book_ref_no);
  $frm_data1=array(
    'bk_issue_id'=>$bk_req_id,
    'renew_date'=>$renew_date,
    'no_of_days'=>$no_of_days,
    'status'=>'0',
    'user_id'=>$user_id,
    'created_date'=>date("Y-m-d H:i:s")
  );
  $db->insert($table1, $frm_data1);
  $res = $db->getResult();
  if($res){
    $sql1 = "UPDATE $table2 SET no_of_days = no_of_days + ".$no_of_days." WHERE id= '".$bk_req_id."'";
	  $db->update_dir($sql1);
     echo "success#";
   }
 else{
   //print_r($db->getResult());
   echo "error#";
  }
}
if(isset($_POST['action']) && $_POST['action'] == 'update_missing_book'){
  $reference_id = $_POST['reference_id'];
  $lost_type = $_POST['lost_type'];
  $table = $_POST['table'];

  $db->update($table, ["lost_status" => $lost_type ],'id='.$reference_id);
  $res = $db->getResult();
 // print_r($res);
  if($res){
      echo "success#".$res[1];
  }
  else{
      //print_r($db->getResult());
      echo "error#".$res[0];
  }
}
if(isset($_POST['action']) && $_POST['action'] == 'check_exist_book'){
	
	$book_name=$_POST['book_name'];
    $author_name=$_POST['author_name'];
	
	$sql = 'SELECT * FROM tbl_book_details WHERE book_name ="'.$book_name.'" and author_name ="'.$author_name.'"';
    $res_book_det=$db->select_sql_row($sql);

	if(!empty($res_book_det)){
		echo 'error#Book - '.$book_name.', Author -'.$author_name.' Already Present. ';
	}else{
		 echo "success#";
	}
	
}
?>