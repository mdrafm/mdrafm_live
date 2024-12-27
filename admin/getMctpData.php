<?php

include 'database.php';

$db = new Database();
if (isset($_POST["action"]) && $_POST["action"] == 'fetch') {


    $where = "";
    if (!empty($_REQUEST['search']['value'])) {
        $where .= "AND ( email LIKE '" . $_REQUEST['search']['value'] . "%' ";
        $where .= " OR mobile_number LIKE '" . $_REQUEST['search']['value'] . "%' )";
    }

    $totalRecordsSql = "SELECT count(*) as total FROM tbl_ofs_master $where";
    $db->select_sql($totalRecordsSql);
    $res = $db->getResult();

    $totalRecords = $res[0]['total'];
    // print_r($totalRecords );

    $limit_query = '';

    if ($_POST["length"] != -1) {
        $limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $db->select_sql("SELECT m.id,m.name,m.email,m.mobile,m.emp_id,m.gpf_no,m.acct_type as acct_type_id,a.name as acct_type,e.type as emp_type,
                m.deploy_type,m.religion_id,r.religion,m.gender,m.dob,m.doj,m.dor,m.cader,m.grade,m.home_town,m.category_id,c.category,m.office_name,
                m.office_address,m.designation,m.last_year_passing,m.qualification,m.degree,t.trng_name 
                FROM `tbl_ofs_master` m 
                LEFT JOIN `tbl_acct_type_master` a  ON m.acct_type = a.id
                LEFT JOIN `tbl_emp_type_master` e  ON m.emp_type = e.id
                LEFT JOIN `tbl_category_master` c ON m.category_id = c.id
                LEFT JOIN `tbl_religion_master` r ON m.religion_id = r.id
                LEFT JOIN `tbl_training_master` t ON m.trainning_id = t.id
                WHERE m.status = 1 $where $limit_query");
    $results = $db->getResult();


    $data = array();

    foreach ($results as $row) {
        $sub_array = array();
        $sub_array[] = $row['id'];
        $sub_array[] = $row['name'];
        $sub_array[] = $row['mobile'];
        $sub_array[] = $row['email'];

        $sub_array[] = $row['dob'];
        $sub_array[] = $row['doj'];
        $sub_array[] = $row['dor'];
        $sub_array[] = 'active';


        $action_button = '
    <div  align="center">
    <span class="text-success" onclick="viewOfsList(' . $row["id"] . ')" style="cursor:pointer" ><i class="far fa-eye " style="font-size:1.5rem;"></i></sapan>
    
    <span class="text-danger" onclick="editOfsList(' . $row["id"] . ')" style="cursor:pointer"><i class="far fa-edit " style="font-size:1.5rem;"></i></sapan>
         
      

    </div>
   
    ';
        $sub_array[] = $action_button;
        $data[] = $sub_array;
    }


    $output = array(
        "draw"                =>     intval($_POST["draw"]),
        "recordsTotal"      =>  $totalRecords,
        "recordsFiltered"     =>     $totalRecords,
        "data"                =>     $data
    );

    echo json_encode($output);
}
if (isset($_POST["action"]) && $_POST["action"] == 'fetchOfsList') {

    $id = $_POST['id'];

    $db->select_sql("SELECT m.id,m.emp_id,m.gpf_no,m.acct_type as acct_type_id,a.name as acct_type,e.type as emp_type,m.name,m.deploy_type,m.religion_id,r.religion,m.gender,m.mobile,m.email,m.dob,
                                            m.doj,m.dor,m.cader,m.grade,m.home_town,m.category_id,c.category,m.office_name,m.office_address,m.designation,m.last_year_passing,
                                            m.qualification,m.degree,t.trng_name 
                                            FROM `tbl_ofs_master` m 
                                            LEFT JOIN `tbl_acct_type_master` a  ON m.acct_type = a.id
                                            LEFT JOIN `tbl_emp_type_master` e  ON m.emp_type = e.id
                                           LEFT JOIN `tbl_category_master` c ON m.category_id = c.id
                                           LEFT JOIN `tbl_religion_master` r ON m.religion_id = r.id
                                           LEFT JOIN `tbl_training_master` t ON m.trainning_id = t.id
                                            WHERE m.status = 1 AND m.id = $id");
                                            //print_r($db->getResult());exit;

    foreach ($db->getResult() as $row) {
        $retired_date = date('Y-m-d', strtotime($row['dob'] . ' + 60 years'));
?>
        <div class="employee_dtl" style="line-height: 1.7rem;">
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between ">

                    <label for="">Name</label>

                    <span><?php echo $row['name'] ?></span>
                </div>
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Employee id </label>

                    <span><?php echo $row['emp_id'] ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Gpf No</label>

                    <span><?php echo $row['gpf_no'] ?></span>
                </div>
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Acct Type </label>

                    <span><?php echo $row['acct_type'] ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Deploy Type </label>

                    <span><?php echo $row['deploy_type'] ?></span>
                </div>
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Religion</label>

                    <span><?php echo $row['religion'] ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Gender</label>

                    <span><?php echo ($row['gender'] == 1) ? 'Male' : 'Femail'; ?></span>
                </div>
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Cader</label>

                    <span><?php echo $row['cader'] ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Phone no</label>

                    <span><?php echo $row['mobile'] ?></span>
                </div>
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Email</label>

                    <span><?php echo $row['email'] ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Date of Birth</label>

                    <span><?php echo date('d-m-Y', strtotime($row['dob'])) ?></span>
                </div>
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Date of Joining</label>

                    <span><?php echo date('d-m-Y', strtotime($row['doj'])) ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Date of Retirement</label>

                    <span><?php echo date('d-m-Y', strtotime($row['dor'])) ?></span>
                </div>
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Grade</label>

                    <span><?php echo $row['grade'] ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Home Town</label>

                    <span><?php echo $row['home_town'] ?></span>
                </div>
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Category</label>

                    <span><?php echo $row['category'] ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Office Name</label>

                    <span><?php echo $row['office_name'] ?></span>
                </div>
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Office Address</label>

                    <span><?php echo $row['office_address'] ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Designation</label>

                    <span><?php echo $row['designation'] ?></span>
                </div>
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Last year Passing</label>

                    <span><?php echo $row['last_year_passing'] ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Qualification</label>

                    <span><?php echo $row['qualification'] ?></span>
                </div>
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Degree</label>

                    <span><?php echo $row['degree'] ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Training Type</label>

                    <span><?php echo $row['trng_name'] ?></span>
                </div>
                <div class="col-md-6 d-flex justify-content-between">
                    <label for="">Status</label>

                    <span><?php echo 'active' ?></span>
                </div>
            </div>
        </div>
<?php
    }
}

if (isset($_POST["action"]) && $_POST["action"] == 'edtOfsList') {
    $id = $_POST['id'];

    $db->select_sql("SELECT m.id,m.emp_id,m.gpf_no,m.acct_type as acct_type_id,a.name as acct_type,e.type as emp_type,m.name,m.deploy_type,m.religion_id,r.religion,m.gender,m.mobile,m.email,m.dob,
                                            m.doj,m.dor,m.cader,m.grade,m.home_town,m.category_id,c.category,m.office_name,m.office_address,m.designation,m.last_year_passing,
                                            m.qualification,m.degree,t.trng_name 
                                            FROM `tbl_ofs_master` m 
                                            LEFT JOIN `tbl_acct_type_master` a  ON m.acct_type = a.id
                                            LEFT JOIN `tbl_emp_type_master` e  ON m.emp_type = e.id
                                           LEFT JOIN `tbl_category_master` c ON m.category_id = c.id
                                           LEFT JOIN `tbl_religion_master` r ON m.religion_id = r.id
                                           LEFT JOIN `tbl_training_master` t ON m.trainning_id = t.id
                                            WHERE m.status = 1 AND m.id = $id");
                                            //print_r($db->getResult());exit;

    foreach ($db->getResult() as $row) {
        ?>
           <form id="ofs_frm_<?php echo $row['id']; ?>">
                                                            <div class="employee_dtl" style="line-height: 1.7rem;">
                                                                <div class="row">
                                                                    <div class="col-md-6 d-flex justify-content-between ">

                                                                        <label for="">Name</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="name" class="form-control" value="<?php echo $row['name'] ?>">

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Employee id </label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="emp_id" class="form-control" value="<?php echo $row['emp_id'] ?>">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Gpf No</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="gpf_no" class="form-control" value="<?php echo $row['gpf_no'] ?>">

                                                                        </div>


                                                                    </div>
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Acct Type </label>
                                                                        <div class="col-md-8">
                                                                            <select class="custom-select mr-sm-2" name="acct_type" style="height: calc(1em + 0.75rem + 2px);padding:0px">

                                                                                <option>Select acct_type </option>
                                                                                <?php


                                                                                $db->select('tbl_acct_type_master', "id,name", null, 'status =1', null, null);
                                                                                // print_r( $db->getResult());
                                                                                foreach ($db->getResult() as $row6) {
                                                                                    //print_r($row);

                                                                                ?>
                                                                                    <option value="<?php echo $row6['id'] ?>" <?php echo ($row['acct_type_id'] == $row6['id']) ? 'selected' : '' ?>>
                                                                                        <?php echo $row6['name'] ?>
                                                                                    </option>

                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>


                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Deploy Type </label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="deploy_type" class="form-control" value="<?php echo $row['deploy_type'] ?>">

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Religion</label>
                                                                        <div class="col-md-8">
                                                                            <select class="custom-select mr-sm-2" name="religion_id" style="height: calc(1em + 0.75rem + 2px);padding:0px">

                                                                                <option>Select acct_type </option>
                                                                                <?php


                                                                                $db->select('tbl_religion_master', "id,religion", null, 'status =1', null, null);
                                                                                // print_r( $db->getResult());
                                                                                foreach ($db->getResult() as $row7) {
                                                                                    //print_r($row);

                                                                                ?>
                                                                                    <option value="<?php echo $row7['id'] ?>" <?php echo ($row['religion_id'] == $row7['id']) ? 'selected' : '' ?>>
                                                                                        <?php echo $row7['religion'] ?>
                                                                                    </option>

                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>


                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Gender</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="gender" class="form-control" value="<?php echo ($row['gender'] == 1) ? 'Male' : 'Femail'; ?>">

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Cader</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="cader" class="form-control" value="<?php echo $row['cader'] ?>">

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Phone no</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="mobile" class="form-control" value="<?php echo $row['mobile'] ?>">

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Email</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="email" class="form-control" value="<?php echo $row['email'] ?>">

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Date of Birth</label>
                                                                        <div class="col-md-8">
                                                                            <input type="date" name="dob" class="form-control" value="<?php echo $row['dob'] ?>">

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Date of Joining</label>
                                                                        <div class="col-md-8">
                                                                            <input type="date" name="doj" class="form-control" value="<?php echo $row['doj'] ?>">

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Date of Retirement</label>
                                                                        <div class="col-md-8">
                                                                            <input type="date" name="dor" class="form-control" value="<?php echo $row['dor'] ?>">

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Grade</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="grade" class="form-control" value="<?php echo $row['grade'] ?>">

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Home Town</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="home_town" class="form-control" value="<?php echo $row['home_town'] ?>">

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Category</label>
                                                                        <div class="col-md-8">
                                                                            <select class="custom-select mr-sm-2" name="category_id" style="height: calc(1em + 0.75rem + 2px);padding:0px">

                                                                                <option>Select Category </option>
                                                                                <?php


                                                                                $db->select('tbl_category_master', "id,category", null, 'status =1', null, null);
                                                                                // print_r( $db->getResult());
                                                                                foreach ($db->getResult() as $row8) {
                                                                                    //print_r($row);

                                                                                ?>
                                                                                    <option value="<?php echo $row8['id'] ?>" <?php echo ($row['category_id'] == $row8['id']) ? 'selected' : '' ?>>
                                                                                        <?php echo $row8['category'] ?>
                                                                                    </option>

                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>


                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Office Name</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="office_name" class="form-control" value="<?php echo $row['office_name'] ?>">

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Office Address</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="office_address" class="form-control" value="<?php echo $row['office_address'] ?>">

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Designation</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="designation" class="form-control" value="<?php echo $row['designation'] ?>">

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Last year Passing</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="last_year_passing" class="form-control" value="<?php echo $row['last_year_passing'] ?>">

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Qualification</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="qualification" class="form-control" value="<?php echo $row['qualification'] ?>">

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Degree</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="degree" class="form-control" value="<?php echo $row['degree'] ?>">

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <!-- <div class="col-md-6 d-flex justify-content-between">
                                                                        <label for="">Training Type</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="trng_name" class="form-control" value="<?php echo $row['trng_name'] ?>">

                                                                        </div>

                                                                    </div> -->

                                                                </div>
                                                            </div>
                                                        </form>
        <?php
    }
}
?>