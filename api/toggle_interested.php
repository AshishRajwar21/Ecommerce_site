<?php
session_start();

require "../includes/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "is_logged_in" => false));
    return;
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET["product_id"];
$table = $_GET["item"];
$table2 = $table."_likes";

$sql_1 = "SELECT * FROM $table2 WHERE user_id = $user_id AND product_id = $product_id";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
    echo json_encode(array("success" => false, "message" => "Something went wrong"));
    return;
}

if (mysqli_num_rows($result_1) > 0) {
    $sql_2 = "DELETE FROM $table2 WHERE user_id = $user_id AND product_id = $product_id";
    $result_2 = mysqli_query($conn, $sql_2);
    if (!$result_2) {
        echo json_encode(array("success" => false, "message" => "Something went wrong"));
        return;
    } else {
        echo json_encode(array("success" => true, "is_interested" => false, "product_id" => $product_id));
        return;
    }
} else {
    $sql_3 = "INSERT INTO $table2 (user_id, product_id) VALUES ('$user_id', '$product_id')";
    $result_3 = mysqli_query($conn, $sql_3);
    if (!$result_3) {
        echo json_encode(array("success" => false, "message" => "Something went wrong"));
        return;
    } else {
        echo json_encode(array("success" => true, "is_interested" => true, "product_id" => $product_id));
        return;
    }
}