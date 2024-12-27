<?php 
// Include the main TCPDF library (search for installation path).
include_once('../tcpdf/tcpdf.php');
include 'database.php';
$db = new Database();
$program_id = $_POST['program_id'];
$traning_type = $_POST['traning_type'];
$prog_name = 'Misc july';
$trainee_name = 'Leepu';
//$prg_name = '';
$suggestion = '';
$sugst = '';

$count = 0;
     
     // $sql = "SELECT f.id,f.user_id,f.feedback,t.paper_covered,t.faculty_type,t.faculty_id  FROM `tbl_mid_cls_feedback` f 
     //                JOIN `tbl_inhouse_time_table` t ON f.time_tbl_id = t.id
     //                WHERE f.`user_id` =".$_POST['trainee_id'];
if ($traning_type == 4 || $traning_type == 5) {
    $tbl = 'tbl_sponsored_time_table';
       $sql = "SELECT f.id,f.user_id,f.feedback,t.paper_covered,t.faculty_name FROM `tbl_mid_cls_feedback` f 
                    JOIN $tbl t ON f.time_tbl_id = t.id
                    WHERE f.`user_id` =".$_POST['trainee_id'];
    }else if($traning_type == 3 || $traning_type == 7){

      $tbl = 'tbl_inhouse_time_table';
      $sql = "SELECT f.id,f.user_id,f.feedback,t.paper_covered,t.faculty_type,t.faculty_id  FROM `tbl_mid_cls_feedback` f 
                    JOIN $tbl t ON f.time_tbl_id = t.id
                    WHERE f.`user_id` =".$_POST['trainee_id'];
    }
     
    
    
    $db->select_sql($sql);
    $res = $db->getResult(); 
   // print_r($res);
    $count = 1;
              foreach ($res as $row) {
               // print_r($row);exit;

               

                 switch($row['feedback']){
                       case '5':
                        $feedback = "Excellent";
                        break;
                       case '4':
                        $feedback =  "Very Good";
                        break;
                       case '3':
                        $feedback =  "Good";
                        break;
                       case '2':
                        $feedback =  "Average";
                        break;
                       case '1':
                        $feedback =  "Needs Improvement";
                        break;
                       default:
                       $feedback =  'feedback not given';
                       break;
                       
                }
                $faculty_name = '';
                $paper_covered=htmlspecialchars( strip_tags($row["paper_covered"]));
                // if($row['faculty_type'] !==0){
                //         $db->select('tbl_faculty_master','name',null,'id='.$row['faculty_id'],null,null);
                //         $res2 = $db->getResult(); 
                //        // print_r($res2);\''.$url_class_feedback.'\'

                //     }

                $sugst .=  '<tr style="border: 1px solid black;font-size: 15px;">
                           <td style="border: 1px solid black; width:10%">'.$count.'</td>
                           <td style="border: 1px solid black; width:30%">\''.$paper_covered.'\'</td>
                           <td style="border: 1px solid black;width:30%">'.$feedback.'</td>
                              
                           
                      </tr>';
                    
                    
                  
                $count++;

             }
     $suggestion =  '<table align="left" width="100%">
                <thead style="font-size: 30px;background-color: red;color: #fff;">

                <tr style="border: 1px solid black;font-size: 15px;" >
                    <th  style="border: 1px solid black; width:10%">Sl No</th>
                    <th  style="border: 1px solid black; width:30%">Subject & Faculty Name </th>
                    <th  style="border: 1px solid black;width:30%">Feedback</th>
                    
                </tr>
                </thead>
                <tbody>'
                .$sugst.
                '</tbody>

                </table>';

//echo $suggestion;exit;
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