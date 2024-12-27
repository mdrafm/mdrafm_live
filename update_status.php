<?php
$host = 'localhost';
$user = 'root';
$pass = 'MdR@6%&!#$1';
$db = 'mdrafm';


$connection = new mysqli($host, $user, $pass, $db);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$id = $_POST['id'];

$query = "UPDATE tbl_dept_trainee_registration SET verify=1 WHERE id=$id";

if ($connection->query($query) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $connection->error;
}

$connection->close();
?>
