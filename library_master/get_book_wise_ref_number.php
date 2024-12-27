<?php 
session_start(); 
include '../admin/database.php'; 
$db = new Database(); 
$book_id=$_POST['book_id'];
$db->select('tbl_book_reference_no',"tbl_bk_ref.id,tbl_bk_ref.reference_no,tbl_bk.quantity",' tbl_bk_ref JOIN tbl_book_details tbl_bk ON tbl_bk.id =tbl_bk_ref.tbl_book_id ','tbl_book_id= "'.$book_id.'"',null,null); 
$res_book_ref = $db->getResult();
//print_r($res_book_ref);
echo json_encode($res_book_ref);

?>