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

$sql_1 = "SELECT * FROM cart WHERE product_id = '$product_id' and item = '$table'";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
    echo json_encode(array("success" => false, "message" => "Something went wrong"));
    return;
}

if (mysqli_num_rows($result_1) > 0) {
    $sql_2 = "DELETE FROM cart WHERE product_id = '$product_id' and item = '$table'";
    $result_2 = mysqli_query($conn, $sql_2);
    if (!$result_2) {
        echo json_encode(array("success" => false, "message" => "Something went wrong"));
        return;
    } else {
        echo json_encode(array("success" => true, "is_cart" => false, "product_id" => $product_id, "item" => $table));
        return;
    }
} else {
    $sql_3 = "INSERT INTO cart (product_id,item,quantity) VALUES ('$product_id', '$table','$quantity')";
    $result_3 = mysqli_query($conn, $sql_3);
    if (!$result_3) {
        echo json_encode(array("success" => false, "message" => "Something went wrong"));
        return;
    } else {
        echo json_encode(array("success" => true, "is_cart" => true, "product_id" => $product_id, "item" => $table));
        return;
    }
}
//header('location: order_list.php?product_id='.$product_id.'&item='.$table);
mysqli_close($conn);


