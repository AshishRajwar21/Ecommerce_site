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
$review_date = "25-07-2023";
$rating = $_POST['rating'];
$review_comment = $_POST["comment_area"];
$table2 = $table."_testimonials";

    $sql = "INSERT INTO $table2 (user_id,product_id,review_date,rating,review_comment) VALUES ('$user_id','$product_id', '$review_date','$rating','$review_comment')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo json_encode(array("success" => false, "message" => "Something went wrong"));
        return;
    } else {
        echo json_encode(array("success" => true, "is_comment" => true,"user_id" => $user_id, "product_id" => $product_id, "item" => $table));
        return;
    }

//header('location: order_list.php?product_id='.$product_id.'&item='.$table);
mysqli_close($conn);


