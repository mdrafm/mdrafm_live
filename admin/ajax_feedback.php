<?php


include 'database.php';
include 'helper.php';
 session_start();

$db = new Database();
$hp = new Helper($db);

 if (isset($_POST['action']) && $_POST['action'] == 'program_list') {
  $type = $_POST['type'];
  $prog_table = '';
  $_SESSION['trng_type']=$type;

  $program_id = 0;
  if(isset($_POST['program_id'])){
    $program_id = $_POST['program_id'];
  }

  if ($type == 1 || $type == 2) {
    $prog_table = 'tbl_program_master';
  } elseif ($type == 3 || $type ==7) {
    $prog_table = 'tbl_mid_program_master';
  } elseif ($type == 4 || $type == 5) {
    $prog_table = 'tbl_short_program_master';
  }

  

if ($type == 1 || $type == 2) {
     $db->select($prog_table,"id,prg_name,provisonal_Sdate as start_date,provisonal_Edate as end_date",null,"trng_type =".$type,'provisonal_Sdate DESC',null);
}else{
     $db->select($prog_table,"id,prg_name,start_date,end_date",null,"trng_type =".$type,'start_date DESC',null);
}
  

  $res = $db->getResult();
  $cnt = 0;

  $tbl = '
         <table class="table table-sesponsive table-striped table-sm" id="prog_list">

         <tr>
           <th>Sl No</th>
           <th>Program Name</th>
           <th>Start Date</th>
           <th>End Date</th>
           <th>Action</th>
         </tr>
  ';

  foreach ($res as $row) {
  	$cnt++;
	$program_id = $row['id'];
	$prog_name = $row['prg_name'];
	$url_class_feedback = 'view_program_feedback.php';
	$url_trainee_feedback = 'view_program_feedback.php';
  	 $tbl .= ' <tr>
         <td>'.$cnt.'</td>
         <td>'.$row["prg_name"].'</dt>
         <td>'.$row["start_date"].'</dt>
         <td>'.$row["end_date"].'</dt>
          <td> 
          <button class="btn btn-success btn-sm " onclick="redirectPage(\''.$url_class_feedback.'\','.$program_id.','.$type.',1)" > Time Table wise </button>
          <button class="btn btn-primary btn-sm"  onclick="redirectPage(\''.$url_class_feedback.'\','.$program_id.','.$type.',2)" > Trainee Wise </button>
          <button class="btn btn-info btn-sm" onclick="redirectPage(\''.$url_class_feedback.'\','.$program_id.','.$type.',3)" > Suggeestion </button> 
          </td>
          </tr>
  	 '; 

  }

  $tbl .= '</table>';

  echo $tbl;

}

if (isset($_POST['action']) && $_POST['action'] == 'view_trainee_feedBack') {
    //print_r($_POST);
            $sql = "SELECT f.id,f.user_id,f.feedback,t.paper_covered,t.faculty_type,t.faculty_id  FROM `tbl_mid_cls_feedback` f 
                    JOIN `tbl_inhouse_time_table` t ON f.time_tbl_id = t.id
                    WHERE f.`user_id` =".$_POST['trainee_id'];
    $db->select_sql($sql);
    $res = $db->getResult(); 

    ?>
     <table class="table table-striped table-sm" style="width:70%;margin:0px auto;">
        <thead style="font-size: 10px;background-color: rgb(59 67 84);color: #fff;">

            <tr>
                <th scope="col">Sl.No</th>
                <th scope="col"> Subject & Faculty Name</th>
                <!-- <th scope="col"> </th> -->
                <th scope="col">Feedback</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //echo 123;
              $count = 1;
              foreach ($res as $row) {
               // print_r($row);exit;
                $faculty_name = '';
                if(isset($row['faculty_type']) && $row['faculty_type'] !==0){
                        $db->select('tbl_faculty_master','name',null,'id='.$row['faculty_id'],null,null);
                        $res2 = $db->getResult(); 
                       // print_r($res2);

                    }

                
                    ?>
                      <tr>
                           <td><?php echo $count ?></td>
                           <td><?php echo $row['paper_covered'].'<br>'.$res2[0]['name']; ?></td>
                           <td>
                               <?php
                             //  echo $row['feedback'];
                                     switch($row['feedback']){
                                           case '5':
                                            echo "Excellent";
                                            break;
                                           case '4':
                                            echo "Very Good";
                                            break;
                                           case '3':
                                            echo "Good";
                                            break;
                                           case '2':
                                            echo "Average";
                                            break;
                                           case '1':
                                            echo "Needs Improvement";
                                            break;
                                           default:
                                           echo 'feedback not given';
                                           break;
                                           
                                    }
                                ?>
                           </td>
                      </tr>
                    <?php
                
                $count++;

             }
             ?>
        </tbody>
    </table>
    <?php

}
if (isset($_POST['action']) && $_POST['action'] == 'view_mid_feedBack') {
    $program_id = $_POST['program_id'];
    $traning_type = $_POST['traning_type'];
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
    ?>
    <table class="table table-striped table-sm" style="width:70%;margin:0px auto;">
        <thead style="font-size: 10px;background-color: rgb(59 67 84);color: #fff;">

            <tr>
                <th scope="col">Sl.No</th>
                <th scope="col"> Subject & Faculty Name</th>
                <!-- <th scope="col"> </th> -->
                <th scope="col">Feedback</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;
            foreach ($res as $res_feedback) {
                 //print_r( $feedback);exit;
                $count++;
                $faculty_id = $res_feedback['faculty_id'];
                $subject_id = $res_feedback['subject_id'];
            ?>
                <tr>
                    <td><?php echo $count ?></td>
                   <!--  <td><?php echo $res_feedback['name'] ?></td> -->
                    <td><?php echo $res_feedback['subject'] ?></td>
                    <td style="width: 30%;">
                        <?php
                        
                        $cnt1 = 0;
                        $cnt2 = 0;
                        $cnt3 = 0;
                        $cnt4 = 0;
                        $cnt5 = 0;
                       
                            $ins_cls_id = $row_cls['id'];
                            $sql_fdbk = "SELECT feedback FROM tbl_mid_cls_feedback where time_tbl_id =". $res_feedback['id'];
                            $db->select_sql($sql_fdbk);
                            $res_fdbk = $db->getResult();
                            foreach ($res_fdbk as $fdk) {
                                if ($fdk['feedback'] == 1) {
                                    $cnt1 =  $cnt1 + 1;
                                } else if ($fdk['feedback'] == 2) {
                                    $cnt2 =  $cnt2 + 1;
                                } else if ($fdk['feedback'] == 3) {
                                    $cnt3 =  $cnt3 + 1;
                                } else if ($fdk['feedback'] == 4) {
                                    $cnt4 =  $cnt4 + 1;
                                } else if ($fdk['feedback'] == 5) {
                                    $cnt5 =  $cnt5 + 1;
                                }
                            }
                        
                        $tot_cnt = $cnt1 + $cnt2 + $cnt3 + $cnt4 + $cnt5;
                        $febck1 = ($cnt1 / $tot_cnt) * 100;
                        $febck2 = ($cnt2 / $tot_cnt) * 100;
                        $febck3 = ($cnt3 / $tot_cnt) * 100;
                        $febck4 = ($cnt4 / $tot_cnt) * 100;
                        $febck5 = ($cnt5 / $tot_cnt) * 100;
                        ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    Excellent
                                </div>
                                <div class="col-md-4">
                                    <?php echo number_format($febck5, 2, '.', ''); ?>%
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class=" col-lg-8">
                                    Very Good
                                </div>
                                <div class="col-md-4">
                                    <?php echo number_format($febck4, 2, '.', ''); ?>%
                                </div>
                            </div>
                             <hr>
                            <div class="row">
                                <div class="col-lg-8">
                                    Good
                                </div>
                                <div class="col-md-4">
                                    <?php echo number_format($febck3, 2, '.', ''); ?>%
                                </div>
                            </div>
                             <hr>
                            <div class="row">
                                <div class="col-lg-8">
                                    Average
                                </div>
                                <div class="col-md-4">
                                    <?php echo number_format($febck2, 2, '.', ''); ?>%
                                </div>
                            </div>
                             <hr>
                            <div class="row">
                                <div class="col-lg-8">
                                    Needs Improvement
                                </div>
                                <div class="col-md-4">
                                    <?php echo number_format($febck1, 2, '.', ''); ?>%
                                </div>
                            </div>


                        </div>
                    </td>
                </tr>


            <?php
            }
            ?>
        </tbody>
    </table>

    <div class="sugg_wrap">
        <div class="feedback-heading" style="margin-top: 50px">
            <p style="padding: 5px;"> Trainee Suggestion</p>
        </div>
        <button class=" btn btn-primary" onclick="suggetion_pdf()">Generate Report</button>
        <table class="table table-striped table-sm" style="width:60%;">
            <thead style="font-size: 10px;background-color: rgb(59 67 84);color: #fff;">

                <tr>
                    <th scope="col">Sl No</th>
                    <th scope="col">Name </th>
                    <th scope="col">Suggestions
                    <th>
                </tr>
            </thead>
            <tbody>
                <?php
                // $db->select('tbl_post_trng_feedback',$select_query,' f JOIN '.$prog_table.' t ON f.username=t.phone',"f.program_id = '".$prog_id."' AND 
                //     f.trng_type = '".$traning_type."'",null,null);
                $sql = "SELECT u.name,s.suggestion,s.id FROM tbl_mid_cls_suggestation s
                            JOIN `tbl_user` u ON s.user_id=u.id
                            WHERE s.program_id = $program_id AND s.trng_type = $traning_type
                            GROUP BY s.id";

                $db->select_sql($sql);
                $res = $db->getResult();

                $count = 0;
                foreach ($res as $row2) {
                    // print_r( $feedback);
                    $count++;
                ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row2['name'] ?></td>
                        <td><?php echo $row2['suggestion'] ?> </td>
                    </tr>


                <?php
                }


                ?>
            </tbody>
        </table>
    </div>
    <?php
}


?>