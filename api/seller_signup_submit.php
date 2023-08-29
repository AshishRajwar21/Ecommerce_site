<?php
//session_start();
require("../includes/db_connect.php");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password = sha1($password);
$phone = $_POST['phone'];
$home_city = $_POST['home_city'];
$shop_name = $_POST['shop_name'];

$sql1 = "select * from sellers where email='$email'";

$result1 = mysqli_query($conn,$sql1);

if (!$result1){
    $response = array("success" => false, "message" => "Something went wrong.");
    echo json_encode($response);
    exit;
}

$row_count = mysqli_num_rows($result1);

if ($row_count!=0){
    $response = array("success" => false, "message" => "This email id is already registered with us.");
    echo json_encode($response);
    exit;
}

$sql2 = "insert into sellers (email,name,phone,home_city,password,shop_name) values ('$email','$name','$phone','$home_city','$password','$shop_name')";

$result2 = mysqli_query($conn,$sql2);

if (!$result2){
    $response = array("success" => false, "message" => "Something went wrong.");
    echo json_encode($response);
    exit;
}

$response = array("success" => true, "message" => "Your account have been successfully created.");
echo json_encode($response);
mysqli_close($conn);







