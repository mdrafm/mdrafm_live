<?php 
// Include the main TCPDF library (search for installation path).
include_once('../tcpdf/tcpdf.php');
include 'database.php';
include 'helper.php';

$db = new Database(); 
$hp = new Helper($db);

$program_id = $_POST['program_id'];
$traning_type = $_POST['traning_type'];

   $res5 = $hp->get_program_name($_POST['program_id'],$_POST['traning_type']) ;
                                   
//print_r($res5);
$prog_name = $res5[0]['prg_name'];
//$prg_name = '';
$suggestion = '';
$sugst = '';

$count = 0;
     
    //$db->select('tbl_post_trng_feedback','t.name,f.suggestion',' f JOIN `tbl_mid_trainee_registration` t ON f.username=t.phone',null,null,null);
    // $sql = "SELECT tbl_in_tm.id,tbl_in_tm.faculty_id,tbl_in_tm.subject_id,tbl_fclt.name,tbl_mid_syllabus.subject FROM tbl_sponsored_time_table tbl_in_tm join 
    // tbl_faculty_master tbl_fclt on tbl_fclt.id=tbl_in_tm.faculty_id join tbl_mid_syllabus on tbl_mid_syllabus.id=tbl_in_tm.subject_id
    //                         WHERE tbl_in_tm.program_id = $program_id AND tbl_in_tm.trng_type = $traning_type
    //                         GROUP BY tbl_in_tm.faculty_id, tbl_in_tm.subject_id";
if ($traning_type == 4) {
        $sql = "SELECT tbl_in_tm.id,tbl_in_tm.faculty_id,tbl_in_tm.subject_id,tbl_in_tm.paper_covered as subject,tbl_fclt.name FROM tbl_inhouse_time_table tbl_in_tm 
 join tbl_faculty_master tbl_fclt on tbl_fclt.id=tbl_in_tm.faculty_id 
    
                            WHERE tbl_in_tm.program_id =$program_id  AND tbl_in_tm.trng_type=$traning_type
                            GROUP BY tbl_in_tm.faculty_id, tbl_in_tm.subject_id";
    }else if($traning_type == 5){

       $sql= "SELECT id, paper_covered as subject FROM `tbl_sponsored_time_table` WHERE `period_type` = 1 AND `program_id` =".$program_id;
    }
     else {
        $sql = "SELECT tbl_in_tm.id,tbl_in_tm.faculty_id,tbl_in_tm.subject_id,tbl_fclt.name,tbl_mid_syllabus.subject FROM tbl_inhouse_time_table tbl_in_tm join 
    tbl_faculty_master tbl_fclt on tbl_fclt.id=tbl_in_tm.faculty_id join tbl_mid_syllabus on tbl_mid_syllabus.id=tbl_in_tm.subject_id
                            WHERE tbl_in_tm.program_id = $program_id AND tbl_in_tm.trng_type = $traning_type
                            GROUP BY tbl_in_tm.faculty_id, tbl_in_tm.subject_id";
    }
     $db->select_sql($sql);
     $res = $db->getResult();

     foreach($res as $res_feedback){
         //print_r( $res_feedback);

         //$faculty_id=$res_feedback['faculty_id'];
        // $subject_id=$res_feedback['subject_id'];
        $cnt1=0;
     $cnt2=0;
     $cnt3=0;
     $cnt4=0;
     $cnt5=0;

     
          $sql_fdbk = "SELECT feedback FROM tbl_mid_cls_feedback where time_tbl_id =".$res_feedback['id'];
         $db->select_sql($sql_fdbk);
         $res_fdbk= $db->getResult();
         foreach($res_fdbk as $fdk)
         {
             if($fdk['feedback']==1)
             {
                $cnt1=  $cnt1 + 1;
             }else if($fdk['feedback']==2)
             {
                $cnt2=  $cnt2 + 1;
             }
             else if($fdk['feedback']==3)
             {
               $cnt3=  $cnt3 + 1;
             }
             else if($fdk['feedback']==4)
             {
                 $cnt4=  $cnt4 + 1;
             }
             else if($fdk['feedback']==5)
             {
                 $cnt5=  $cnt5 + 1;
             }
         }
        
     
     $tot_cnt=$cnt1+$cnt2+$cnt3+$cnt4+$cnt5;
     if($tot_cnt >0){
        $febck1=($cnt1 / $tot_cnt)*100;
        $febck2=($cnt2 / $tot_cnt)*100;
        $febck3=($cnt3 / $tot_cnt)*100;
        $febck4=($cnt4 / $tot_cnt)*100;
        $febck5=($cnt5 / $tot_cnt)*100;
     }

        $count++;
        $subject =strip_tags($res_feedback["subject"]);

    $sugst .= '<tr>
      <td style="border: 1px solid black;width:10%">'.$count.'</td>
      <td style="border: 1px solid black;width:50%">'.htmlspecialchars($subject).'</td>';
     
     $sugst .= '<td style="border: 1px solid black;width:40%">';
     $sugst .= '<p>Excellent ===> '.number_format($febck5, 2, '.', '').'%</p>';
     $sugst .= '<p>Very Good  ===> '.number_format($febck4, 2, '.', '').'%</p>';
     $sugst .= '<p>Good  ===> '.number_format($febck3, 2, '.', '').'%</p>';
     $sugst .= '<p>Average  ===> '.number_format($febck2, 2, '.', '').'%</p>';
     $sugst .= '<p>Needs Improvement  ===> '.number_format($febck1, 2, '.', '').'%</p>';
     $sugst .= '</td>';
     $sugst .= '</tr>';
     }
     $suggestion =  '<table align="left" width="100%" style="text-align:left;border: 1px solid black;">
                <thead style="font-size: 30px;background-color: red;color: #fff;">

                <tr style="border: 1px solid black;font-size: 15px;" >
                    <th  style="border: 1px solid black; width:10%">Sl No</th>
                    
                    <th  style="border: 1px solid black;width:50%">Subject</th>
                    <th  style="border: 1px solid black;width:40%">Feedback</th>
                    
                </tr>
                </thead>
                <tbody>'
                .$sugst.
                '</tbody>

                </table>';


//echo $suggestion;
class MYPDF extends TCPDF {
    
   public function Header() {
        // Get the current page break margin
        $bMargin = $this->getBreakMargin();

        // Get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;

        // Disable auto-page-break
        $this->SetAutoPageBreak(false, 0);

        // Define the path to the image that you want to use as watermark.
        $img_file ='../images/logo-Copy.png';
        $this->SetAlpha(0.1);
        // Render the image
        $this->Image($img_file, 0, 0, 223, 280, '', '', '', false, 300, '', false, false, 0);

        // Restore the auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        // Set the starting point for the page content
        $this->setPageMark();
    }
}


$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
$img_file ='../images/logo-Copy.png';
$obj_pdf->Image($img_file, 0, 0, 15, 20, '', '', '', false, 100, 'C', false, false, 0);
 
$obj_pdf->SetFont('helvetica', '', 12);

$title = '<h2  align="center" style="font-size:18px;">Class Wise Feedback</h2> <hr>';
$obj_pdf->Ln(15);
$obj_pdf->writeHTML($title,true, false, true, false, '');


$obj_pdf->Ln(5);
$obj_pdf->Write(0, 'Programme Name : '.$prog_name, '', 0, 'L', true, 0, false, false, 0);
//$obj_pdf->Write(0, 'Paper Name : '.$paper_name, '', 0, 'L', true, 0, false, false, 0);


 $obj_pdf->SetFont('times', '', 10);
 $obj_pdf->SetDrawColor(255,0,0);
 $obj_pdf->SetTextColor(0,63,127);

 $obj_pdf->Ln(10);
 $obj_pdf->writeHTML($suggestion,true, false, true, false, '');

 $obj_pdf->SetX(15);


//  $left_column = ' Invigilator'."\n";

// $right_column = ' Member, Examination Committee'."\n";

// // write the first column
// $obj_pdf->SetFont('helvetica', '', 15);
// $obj_pdf->Ln(15);
// $obj_pdf->MultiCell(80, 0, $left_column, 0, 'J', 0, 0, '', '', true, 0, false, true, 0);


// // write the second column
// //$obj_pdf->Ln(15);
// $obj_pdf->MultiCell(100, 0, $right_column, 0, 'R', 0, 0, '', '', true, 0, false, true, 0);


 $obj_pdf->Output('feedback.pdf', 'I');
?>