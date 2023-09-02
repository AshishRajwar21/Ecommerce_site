<?php
session_start();

require "../includes/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "is_logged_in" => false));
    return;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST["product_id"];
$table = $_POST["item"];
$quantity = $_POST["quantity"];


$sql_1 = "UPDATE cart set quantity=$quantity WHERE item='$table' AND product_id = '$product_id'";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
    echo json_encode(array("success" => false, "message" => "Something went wrong"));
    return;
}
echo json_encode(array("success" => true, "product_id" => $product_id, "item" => $table, "message" => "Updated successfully"));
//header('Location: cart_list.php');
mysqli_close($conn);


