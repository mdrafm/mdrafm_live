<?php
$host = 'localhost';
$user = 'root';
$pass = 'MdR@6%&!#$1';
$db = 'mdrafm';


$connection = new mysqli($host, $user, $pass, $db);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchValue = $_POST['search']['value'];

$program_id = $_POST['program_id'];
$trng_type = $_POST['trng_type'];


$query = "SELECT * FROM tbl_dept_trainee_registration WHERE trng_type = $trng_type AND program_id = $program_id";

if (!empty($searchValue)) {
    $query .= " AND (name LIKE '%" . $searchValue . "%' OR hrms_id LIKE '%" . $searchValue . "%' OR designation LIKE '%" . $searchValue . "%' OR office_name LIKE '%" . $searchValue . "%' OR email LIKE '%" . $searchValue . "%' OR phone LIKE '%" . $searchValue . "%')";
}

$totalQuery = $query;
$query .= " LIMIT $start, $length";

$result = $connection->query($query);
$totalResult = $connection->query($totalQuery);

$data = [];
while ($row = $result->fetch_assoc()) {
    $dist_id = $row['district_id'];
    $sex =$row['sex'];
$gender = '';
    switch ($sex) {
        case '1':
            $gender = 'Male';
            break;
         case '2':
            $gender= 'Female';
            break;
        default:
           $gender = 'NaN';
            break;
    }
    $dist_name = '';
    if($dist_id==0){
        $dist_name = 'NaN';
    }else{
        $query2 = "SELECT dist_name FROM tbl_district_master WHERE id = $dist_id ";
        $result2 = $connection->query($query2);
        $row2 = $result2->fetch_assoc();
        $dist_name =$row2['dist_name'];
      //  print_r($row2);
    }
    
    $data[] = [
        "id" => $row['id'],
        "name" => $row['name'],
        "hrms_id" => $row['hrms_id'],
        "designation" => $row['designation'],
        "office_name" => $row['office_name'],
        "district" =>$dist_name,
        "district_id" =>$dist_id,
        "sex" =>$row['sex'],
        "gender"=>$gender,
        "email" => $row['email'],
        "phone" => $row['phone'],

         "address1" => $row['address1'],
         "address2" => $row['address2'],
         "district_id" => $row['district_id'],
         "pin" => $row['pin'],
         "same_addr" => $row['addrss_flag'], 
         "per_address1" => $row['per_address1'],
         "per_address2" => $row['per_address2'],
         "per_pin" => $row['pre_pin'],
         "perDistrict" => $row['per_district_id'],
        "status" => ($row['verify'] == 0)?'Not Verify':'Verified',
        "action" => '<button type="button" class="btn btn-info btn-sm editBtn">Edit</button>'
    ];
}

$totalRecords = $totalResult->num_rows;

echo json_encode([
    "draw" => intval($draw),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecords,
    "data" => $data
]);

$connection->close();
?>
