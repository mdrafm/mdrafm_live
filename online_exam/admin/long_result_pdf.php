<?php
include_once('../../tcpdf/tcpdf.php');
include('../../admin/database.php');
//include('database.php');
$object = new Database();

$post_exam_id=$_POST['exam_id']; 
//$exam_category=$_POST['exam_category']; 

$exam_name = '';
$paper_name = '';

$object_sql = "
SELECT m.exam_title,m.exam_date_time,m.exam_duration,m.total_question,m.marks_per_right_answer,p.prg_name,a.id as paper_id,CONCAT(a.paper_code, ' ',a.title) as paper FROM `tbl_exam_master` m 
JOIN `tbl_program_master` p ON m.program_id = p.id
JOIN `tbl_paper_master` a ON m.paper_id = a.id
WHERE m.id = ".$post_exam_id;


$object->select_sql($object_sql);
$exam_result = $object->getResult();
 $total_mark = 0;
 
  foreach($exam_result as $exam_row){
   
     $exam_name = $exam_row['exam_title'];

     if($exam_row['paper_id'] ==12 ){
        $paper_name =$exam_row['paper'] .' & '.' 205B Common Office Procedures';
     }elseif ($exam_row['paper_id'] ==37 ) {
         $paper_name =$exam_row['paper'] .' & '.' 504B Common Office Procedures';
     }elseif ($exam_row['paper_id'] ==31 ) {
        $paper_name =$exam_row['paper'] .' & '.' 405B Information Technology';
    }

     else{
        $paper_name =$exam_row['paper'];
     }
     
     $total_mark = $exam_row['total_question'] * $exam_row['marks_per_right_answer'];
     
     $exam_time = date(' d/m/Y h:i A', strtotime($exam_row['exam_date_time']));
     $exam_duration_minuts =  intdiv($exam_row['exam_duration'], 60).':'. ($exam_row['exam_duration'] % 60); 

     $hours = floor($exam_row['exam_duration'] / 60);
     $min =$exam_row['exam_duration'] - floor($exam_row['exam_duration'] / 60) * 60;
     $hour =  ($hours!= 0)?$hours.' Hour':'';
     $minuts = ($min != 0)?$min.' Minuts':'';

     $duration =$hour .' '.$minuts  ;

     $pass_mark = 0;
     switch ($total_mark) {
        case '60':
            $pass_mark = 30;
            break;
        
        default:
            # code...
            break;
    }
    
 }
//exit;
$result_sql = "
SELECT tbl_trainee_info.user_id, CONCAT( tbl_trainee_info.f_name ,' ',tbl_trainee_info.l_name) as name,tbl_trainee_info.phone,sum(tbl_qs_ans.marks) as tot_mark 
FROM `tbl_new_recruite` tbl_trainee_info
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
$remark = '';
$res = '';

foreach($mark_result as $mark_row){
    $count++;
   // print_r($mark_row);

    $name=$mark_row['name'];
    $phone=$mark_row['phone'];
    $tot_mark=$mark_row['tot_mark'];
   
    $final_mark = $final_mark + $tot_mark;
    $exam_id=$post_exam_id;
    $remark = ($tot_mark >= $pass_mark)?'<p style="color:green" >PASS</p>':'<p style="color:red" >FAIL</p>';
   // if($mark_row['user_id'] == 1815 || $mark_row['user_id'] == 1816){
   //      $tot_mark = $tot_mark/2;
   //  }
   
   $res .= '<tr>

        <td style="border: 1px solid black; width:10%;font-size:12px">'.$count.'</td>
        <td style="border: 1px solid black; width:35%;font-size:12px;" >'.$mark_row['name'].'</td>
        <td style="border: 1px solid black; width:17%;font-size:12px;" >'.$mark_row['phone'].'</td>
        <td style="border: 1px solid black; width:20%;font-size:13px;text-align: center;" >'.$tot_mark.'</td>
        
       
       

        </tr>';
   
}

$suggestion =  '<table align="left" width="100%" style="text-align:left;border: 1px solid black;">


                <tr style="border: 1px solid black;" >
                    <th  style="border: 1px solid black; width:10%;font-size:15px;font-weight:bold">Sl No</th>
                    <th  style="border: 1px solid black; width:35%;font-size:15px;font-weight:bold">Name </th>
                    <th  style="border: 1px solid black; width:17%;font-size:15px;font-weight:bold">Phone No </th>
                    <th  style="border: 1px solid black; width:20%;font-size:15px;font-weight:bold">Total Mark('.$total_mark.')</th>
                   
                    
                </tr>

                '
                .$res.
                '

                </table>';


//print_r($suggestion);

class MYPDF extends TCPDF {
    public function Header() {
        // Get the current page break margin
        $bMargin = $this->getBreakMargin();

        // Get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;

        // Disable auto-page-break
        $this->SetAutoPageBreak(false, 0);

        // Define the path to the image that you want to use as watermark.
        $img_file ='../../images/logo-Copy.png';
        $this->SetAlpha(0.1);
        // Render the image
        $this->Image($img_file, 0, 0, 223, 280, '', '', '', false, 300, '', false, false, 0);

        // Restore the auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        // Set the starting point for the page content
        $this->setPageMark();
    }
}

$obj_pdf = new MYPDF (PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

$obj_pdf->SetCreator(PDF_CREATOR);
$obj_pdf->SetAuthor('Nicola Asuni');
// set default header data
$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
// set margins
$obj_pdf->SetTitle('Exam Result');
$obj_pdf->SetSubject('Exam Result');
$obj_pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$obj_pdf->SetTitle("Result");
$obj_pdf->SetDefaultMonospacedFont('helvetica');

$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//$obj_pdf->setPrintHeader(false);
$obj_pdf->setPrintFooter(false);
//$obj_pdf->SetMargins('10', '40', '10');
$obj_pdf->SetAutoPageBreak(TRUE, 10);
$obj_pdf->SetFont('helvetica', '', 10);

$obj_pdf->AddPage();

$obj_pdf->SetDrawColor(255,0,0);
$obj_pdf->SetTextColor(0,63,127);


// $obj_pdf->MultiCell(80, 0, $exam_time, 0, 'J', 0, 0, '', '', true, 0, false, true, 0);
// $obj_pdf->MultiCell(80, 0, $duration, 0, 'J', 0, 0, '', '', true, 0, false, true, 0);

//logo
$img_file ='../../images/logo-Copy.png';
$obj_pdf->Image($img_file, 0, 0, 15, 20, '', '', '', false, 100, 'C', false, false, 0);
 
$obj_pdf->SetFont('helvetica', '', 12);
$obj_pdf->Ln(5);
$obj_pdf->MultiCell(80, 20,'Date & Time: '.$exam_time, 0, 'L', 0, 0, '', '', true, 0, false, true, 40);
$obj_pdf->MultiCell(110, 0,'Total Question: '.$exam_row['total_question'], 0, 'R', 0, 0, '', '', true, 0, false, true, 0);

$obj_pdf->Ln(5);
$obj_pdf->MultiCell(80, 0,'Exam Duration: '.$duration, 0, 'L', 0, 0, '', '', true, 0, false, true, 40);
$obj_pdf->MultiCell(110, 0,'Total Mark: '.$total_mark, 0, 'R', 0, 0, '', '', true, 0, false, true, 0);

$title = '<h2  align="center" style="font-size:18px;">Exam Result</h2> <hr>';
$obj_pdf->Ln(5);
$obj_pdf->writeHTML($title,true, false, true, false, '');


$obj_pdf->Ln(5);
$obj_pdf->Write(0, 'Exam Name : '.$exam_name, '', 0, 'L', true, 0, false, false, 0);
$obj_pdf->Write(0, 'Paper Name : '.$paper_name, '', 0, 'L', true, 0, false, false, 0);


 $obj_pdf->SetFont('times', '', 10);
 $obj_pdf->SetDrawColor(255,0,0);
 $obj_pdf->SetTextColor(0,63,127);

 $obj_pdf->Ln(10);
 $obj_pdf->writeHTML($suggestion,true, false, true, false, '');

 $obj_pdf->SetX(15);


 $left_column = ' Invigilator'."\n";

$right_column = ' Member, Examination Committee'."\n";

// write the first column
$obj_pdf->SetFont('helvetica', '', 15);
$obj_pdf->Ln(15);
$obj_pdf->MultiCell(80, 0, $left_column, 0, 'J', 0, 0, '', '', true, 0, false, true, 0);


// write the second column
//$obj_pdf->Ln(15);
$obj_pdf->MultiCell(100, 0, $right_column, 0, 'R', 0, 0, '', '', true, 0, false, true, 0);


 $obj_pdf->Output('result.pdf', 'I');
