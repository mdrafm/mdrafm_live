<!DOCTYPE html>
<html lang="en">


<head>
    <?php 
    
    include_once('../tcpdf/tcpdf.php');

    include('header_link.php');
    include('../config.php');
    include 'database.php';
     $object = new Database();
     $db = new Database();
    ?>
    <style>
    .card label {
        font-size: 1rem;
    }
    </style>
</head>

<body class="user-profile">

   

    <div class="wrapper ">

        <?php include('sidebar.php'); ?>
        <?php
         $co_role = 0;
         $asst_co_role = 0;
          $db->select('tbl_role_master','*',null,"status=1 AND name = 'short_course_co' OR name = 'short_asst_course_co' ",null,null);
          
          foreach($db->getResult() as $role){
            if($role['name'] == 'short_course_co') {
               $co_role = $role['id'];
            }
            if($role['name'] == 'short_asst_course_co') {
                $asst_co_role = $role['id'];
             }
            }
        ?>
        <div class="main-panel" id="main-panel">
            <?php include('navbar.php'); ?>

            <div class="panel-header panel-header-sm">


            </div>


            <div class="content" style="margin-top: 50px;">

               <div class="row">
                    <div class="card">
                            <div class="card-header">
                                <h2>Approve certificate</h2>
                            </div>

                             <div class="card-body">

                                 <?php
                                   
$prog_id=$_POST['id']; 
$trng_type = $_POST['trng_type'];


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
  // print_r( $row);exit;
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


    $crt = $obj_pdf->Output('', 'S');
  
echo '<iframe src="data:application/pdf;base64,' . base64_encode($crt) .'" width="900" height="600" ></iframe> ';
 
?>

                               
                             </div>
                    </div>
               </div>

            </div>


        </div>

    </div>

    </div>

    </div>


    <!-- msgBox Modal Modal HTML -->
    

    <?php include('common_script.php') ?>

</body>

</html>

<script type="text/javascript">
    
</script>
