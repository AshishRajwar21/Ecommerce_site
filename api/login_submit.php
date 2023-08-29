<?php
session_start();
require("../includes/db_connect.php");

$email = $_POST['email'];
$password = $_POST['password'];
$password = sha1($password);

$sql = "select * from users where email='$email' and password='$password'";

$result = mysqli_query($conn,$sql);
if (!$result){
    $response = array("success" => false, "message" => "Something went wrong.");
    echo json_encode($response);
    exit ;
}
$row_count = mysqli_num_rows($result);
if ($row_count==0){
    $response = array("success" => false, "message" => "Please enter the correct email or password");
    echo json_encode($response);
    exit;
}
$row = mysqli_fetch_assoc($result);

$_SESSION['user_id'] = $row['id'];
$_SESSION['name'] = $row['name'];
$_SESSION['email'] = $row['email'];

$response = array("success" => true);
echo json_encode($response);
//header ('location: index.php');
mysqli_close($conn);





