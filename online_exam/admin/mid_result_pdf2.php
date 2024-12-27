<?php
include_once('../../tcpdf/tcpdf.php');
include('../../admin/database.php');
//include('database.php');
$object = new Database();

$post_exam_id=$_POST['exam_id']; 

$exam_name = '';
$paper_name = '';

$object_sql = "
 SELECT m.exam_title,p.prg_name,a.paper_code as paper FROM `tbl_exam_master` m 
 JOIN `tbl_mid_program_master` p ON m.program_id = p.id
 JOIN `tbl_mid_paper_master` a ON m.paper_id = a.id
 WHERE m.id = ".$post_exam_id;

// echo "
// SELECT m.exam_title,p.prg_name,a.paper_code as paper FROM `tbl_exam_master` m 
//  JOIN `tbl_mid_program_master` p ON m.program_id = p.id
//  JOIN `tbl_mid_paper_master` a ON m.paper_id = a.id
//  WHERE m.id = ".$post_exam_id;
// $object->select_sql($sql_result);

$object->select_sql($object_sql);
$exam_result = $object->getResult();
 
 
  foreach($exam_result as $exam_row){
   
     $exam_name = $exam_row['exam_title'];
     $paper_name =$exam_row['paper'];
 
 }

 $result_sql = "
    SELECT tbl_trainee_info.user_id,tbl_trainee_info.name,tbl_trainee_info.phone,sum(tbl_qs_ans.marks) as tot_mark 
    FROM `tbl_dept_trainee_registration` tbl_trainee_info
    join tbl_trainee_exam_info tbl_exm_inf on tbl_exm_inf.trainee_id = tbl_trainee_info.user_id 
    join tbl_exam_question_answer as tbl_qs_ans on  tbl_qs_ans.trainee_exam_info_id=tbl_exm_inf.id

    WHERE tbl_exm_inf.exam_status = 1 AND tbl_exm_inf.exam_id = '".$post_exam_id."' 
    group by tbl_qs_ans.trainee_exam_info_id
";

//$object->select_sql($sql_result);
$object->select_sql($result_sql);

$mark_result = $object->getResult();

$count = 0;
$final_mark = 0;
$res = '';

foreach($mark_result as $mark_row){
    $count++;
   // print_r($mark_row);
    $name=$mark_row['name'];
    $phone=$mark_row['phone'];
    $tot_mark=$mark_row['tot_mark'];
   
    $final_mark = $final_mark + $tot_mark;
    $exam_id=$post_exam_id;
   
   $res .= '<tr>

        <td style="border: 1px solid black; width:10%;font-size:15px">'.$count.'</td>
        <td style="border: 1px solid black; width:40%;font-size:15px;" >'.$mark_row['name'].'</td>
        <td style="border: 1px solid black; width:30%;font-size:15px;" >'.$mark_row['phone'].'</td>
        <td style="border: 1px solid black; width:20%;font-size:15px;" >'.$tot_mark.'</td>
       

        </tr>';
   
}

$suggestion =  '<table align="left" width="100%" style="text-align:left;border: 1px solid black;">


                <tr style="border: 1px solid black;" >
                    <th  style="border: 1px solid black; width:10%;font-size:15px;font-weight:bold">Sl No</th>
                    <th  style="border: 1px solid black; width:40%;font-size:15px;font-weight:bold">Name </th>
                    <th  style="border: 1px solid black; width:30%;font-size:15px;font-weight:bold">Phone No </th>
                    <th  style="border: 1px solid black; width:20%;font-size:15px;font-weight:bold">Total Mark </th>
                    
                </tr>

                '
                .$res.
                '

                </table>';


//print_r($suggestion);
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

$obj_pdf->SetCreator(PDF_CREATOR);
$obj_pdf->SetAuthor('Nicola Asuni');
$obj_pdf->SetTitle('TCPDF Example 003');
$obj_pdf->SetSubject('TCPDF Tutorial');
$obj_pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$obj_pdf->SetTitle("Result");
$obj_pdf->SetDefaultMonospacedFont('helvetica');

$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$obj_pdf->setPrintHeader(false);
$obj_pdf->setPrintFooter(false);
$obj_pdf->SetAutoPageBreak(TRUE, 10);
$obj_pdf->SetFont('helvetica', '', 10);

$obj_pdf->AddPage();

// set some text to print
$title = '<h2  align="center" style="font-size:18px;">Final Examination Result CCA</h2> <hr>';
$obj_pdf->Ln(15.5);
$obj_pdf->writeHTML($title,true, false, true, false, '');


 $exam_name = '<p style="font-size:18px;">Exam Name : '.$exam_name.'</p>';
 $obj_pdf->Ln(10);
 $obj_pdf->writeHTML($exam_name,true, false, true, false, '');

 $paper_name = '<p style="font-size:18px;">Paper Name : '.$paper_name.'</p>';
 $obj_pdf->Ln(10);
 $obj_pdf->writeHTML($paper_name,true, false, true, false, '');

 //$obj_pdf->AddPage();
 
 
 $obj_pdf->Ln(15.5);
 $obj_pdf->writeHTML($suggestion,true, false, true, false, '');

 $obj_pdf->SetX(15);


 $obj_pdf->Output('result.pdf', 'I');
