<?php
include_once('../tcpdf/tcpdf.php');
include('database.php');
//include('database.php');
$object = new Database();

$prog_id=68; 
$trng_type = 58;



$prg_tbl ='';
switch ($trng_type) {
    case '3':
    case '7':
        $prg_tbl = 'tbl_mid_program_master';
        break;
    case '4':
    case '5':
        $prg_tbl = 'tbl_short_program_master';
        break;
    default:
        $prg_tbl = 'tbl_program_master';
        break;
}

$cd_sql = "SELECT f.name,f.sign FROM `tbl_program_directors` d 
JOIN `tbl_faculty_master` f ON d.course_director = f.id
WHERE d.program_id = '".$prog_id."' AND d.trng_type = $trng_type";

$object->select_sql($cd_sql);

$cd = $object->getResult();
// echo $cd[0]['name']
// print_r($cd);exit;

 $result_sql = " SELECT d.name,d.designation,d.office_name,d.sex,d.crt_no,d.phone,p.start_date,p.end_date,p.prg_name  FROM `tbl_dept_trainee_registration` d 
 JOIN $prg_tbl p ON d.program_id=p.id
 WHERE d.`program_id` = '".$prog_id."' AND d.trng_type = $trng_type ";
 
$object->select_sql($result_sql);

$result = $object->getResult();


foreach($result as $row){
  // print_r( $row);
 //print_r($row);
  $crt_no = $row['crt_no'];
  $name = $row['name'];
  $designation = $row['designation'];
  $office_name = $row['office_name']; 
  $prg_name = $row['prg_name'];
  $start_date = date("d-m-Y", strtotime($row['start_date']));
  $end_date = date("d-m-Y", strtotime($row['end_date'])) ;

  switch ($row['sex']) {
    case '1':
        $prefix = 'Mr.';
        break;
    case '2':
        $prefix = 'Ms.';
        break;   
    default:
        $prefix = '';
        break;
  }
}
   
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
        $img_file2 ='../images/crt/border2.png';
        $this->Image($img_file2, 10, 10, 280, 190, '', '', '', false, 100, '', false, false, 0);
        $this->SetAlpha(0.1);
        // Render the image
       
        $this->Image($img_file, 50, -10, 200, 210, '', '', '', false, 100, '', false, false, 0);

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
    $obj_pdf->setPageOrientation('L');
    //$obj_pdf->SetMargins('10', '40', '10');
    $obj_pdf->SetAutoPageBreak(TRUE, 10);
    $obj_pdf->SetFont('helvetica', '', 10);

    
    
    $obj_pdf->AddPage();

    // // Set page margins (left, top, right, bottom)
     $obj_pdf->SetMargins(10, 10, 10, 10);

  
    //logo
     $img_file ='../images/logo-Copy.png';
     $img_file2 ='../images/odisha.png';
     $director_sign ='../images/crt/dir.jpg';
     $course_director_sign ='../images/crt/'.$cd[0]['sign'];
    // $crt_no = '<p style="font-size:18px;">Crt No :'.$row['crt_no'].' </p>';snip
    //$crt_no = '<p style="font-size:18px;">Crt No :'.$crt_no.' </p>';
      
   // set color for background
   
   $leftMargin = 10;
   // Vertical alignment
   $obj_pdf->SetFont('Courier', 'B', 20);
   $obj_pdf->Ln(4);
   
   $obj_pdf->Image($img_file,25, 20, 30, 35, '', '', '', false, 100, '', false, false, 0);
   $obj_pdf->Image($img_file2,245, 30, 30, 30, '', '', '', false, 100, '', false, false, 0);
   //$obj_pdf->Cell(0, 10, 'GOVERNMENT OF ODISHA  FINANCE DEPARTMENT', 0, 0, 'L', 0, '', $leftMargin);
   $obj_pdf->SetX(15);
   $obj_pdf->Cell(0, 10, 'MADHUSUDAN DAS REGIONAL ACADEMY OF FINANCIAL MANAGEMENT,', 0, 1, 'C');
 //  $obj_pdf->Ln(1);
    $obj_pdf->SetY(23);
   $obj_pdf->Cell(0, 10, 'CHANDRASEKHARPUR, BHUBANESWAR,', 0, 1, 'C');
   $obj_pdf->SetY(32);
   $obj_pdf->Cell(0, 10, 'ODISHA -751023', 0, 1, 'C');

    $obj_pdf->SetFont('Times', 'B', 18);
    $obj_pdf->Ln(2);
   
   $obj_pdf->Cell(0, 10, 'GOVERNMENT OF ODISHA', 0, 1, 'C');
   $obj_pdf->Cell(0, 10, 'FINANCE DEPARTMENT', 0, 1, 'C');
  // $obj_pdf->SetTextColor(0, 0, 0);
    // write the second column
    //$obj_pdf->Ln(15);
    $obj_pdf->SetFont('Courier', '', 15);
     $obj_pdf->Ln(2);
     $header_titel = '<p style="font-size:25px;" align="center"><u>CERTIFICATE OF COMPLETION</u> </i> </p>';
     //$obj_pdf->Ln(5);

     $obj_pdf->writeHTML($header_titel,true, false, true, false, '');

     $obj_pdf->SetFont('times', '', 13);
    // $obj_pdf->Ln(5);
     $para1 = '
                <style>
                p {
                    line-height: 0.1; 
                }
            </style>
               <p style="font-size:19px;padding:100px" align="center">This is to certify that</p>
               <p style="font-size:19px;" align="center"><b>'.$prefix.' '.$name.' </b> </p>
               <p style="font-size:19px;" align="center">'.trim($designation).', '.$office_name.'</p>
               <p style="font-size:19px;" align="center"> has participated in the training program of   </p>
               <p style="font-size:19px;line-height: 1; " align="center">“'.$prg_name.'”  </p>
               <p style="font-size:19px;" align="center">from '.$start_date.' to '.$end_date.'</p>
     ';
     //$obj_pdf->Ln(5);

     $obj_pdf->writeHTML($para1,true, false, true, false, '');

     // set style for barcode
$style = array(
    'border' => true,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 0.5, // width of a single module in points
    'module_height' => 0.5 // height of a single module in points
);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
    
     $obj_pdf->Ln(5);

     $left_column = ' COURSE DIRECTOR'."\n";
    
    $right_column = ' DIRECTOR';
   
    // write the first column
    $obj_pdf->SetFont('helvetica', 'B', 15);
    $obj_pdf->Ln(40);
    $obj_pdf->SetY(180);
    // Set the starting position for the image
$signature_x = 225;  // Adjust as needed for horizontal positioning
$signature_y = 170;   // Adjust as needed for vertical positioning

// Add the signature image
$obj_pdf->Image($director_sign, $signature_x, $signature_y, 50, 15, '', '', '', false, 300, '', false, false, 0, false, false, false);

// Move cursor below the image 

$signature_x = 40;  // Adjust as needed for horizontal positioning
$signature_y = 162;   // Adjust as needed for vertical positioning

// Add the signature image
$obj_pdf->Image($course_director_sign, $signature_x, $signature_y, 18, 20, '', '', '', false, 500, '', false, false, 0, false, false, false);

//$obj_pdf->SetY($signature_y + 30); // Adjust as needed to leave space below the image

        $left_margin = 25;
        $obj_pdf->SetX($left_margin);
        $obj_pdf->MultiCell(100, 0, $left_column, 0, '', 0, 0, '', '', true, 0, false, true, 0);

        // Move cursor to the right position for the right column with a right margin
        $right_margin = 30; // Adjust as needed
        $right_position = $obj_pdf->getPageWidth() - $right_margin - 100; // Page width - right margin - cell width
        $obj_pdf->SetX($right_position);
        $obj_pdf->MultiCell(100, 0, $right_column, 0, 'R', 0, 0, '', '', true, 0, false, true, 0);

    
//QRCODE,L : QR-CODE Low error correction

 $txt = "Name : ".$name."\n"."Designation : ".$designation."\n"."Program Name : ".$prg_name."\n"."From : ".$start_date." To ".$end_date;
$obj_pdf->write2DBarcode($txt , 'QRCODE,R', 20, 130, 30, 30, $style, 'N');


$crt = $obj_pdf->Output('', 'S');
   

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>
<iframe src="data:application/pdf;base64,<?= base64_encode($crt) ?>" width="900" height="600" ></iframe> ;
</body>
</html>






