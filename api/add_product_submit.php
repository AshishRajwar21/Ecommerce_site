
<?php
session_start();
require("../includes/db_connect.php");

$seller_id = $_SESSION['seller_id'];
//$seller_name = $_SESSION['name'];
$product_name = $_POST['product-name'];
$table = $_POST['product-category'];
$category = $_POST['product-sub-category'];
$property = $_POST['product-type'];
$description = addslashes($_POST["description_area"]);//very important line for string having symbol
$stock = $_POST['product-stocks'];
$raw_price = $_POST['product-raw-prices'];
$current_price = $_POST['product-current-prices'];


$brand = $_POST['product-brand'];
//uploading the image1
$product_image1 = $_FILES['my_image1'];

$image_name1 = $product_image1['name'];
$image_size1 = $product_image1['size'];
$temp_name1 = $product_image1['tmp_name'];
$error1 = $product_image1['error'];

//uploading the image2
$product_image2 = $_FILES['my_image2'];

$image_name2 = $product_image2['name'];
$image_size2 = $product_image2['size'];
$temp_name2 = $product_image2['tmp_name'];
$error2 = $product_image2['error'];


$discount = (($raw_price-$current_price)*100)/$raw_price;

if ($error1==0 || $error2==0){
    if ($image_size1 > 150000 || $image_size2 > 150000){
        $error_message = "Sorry, your file size is very large.";
        echo $error_message;
        return;
    }
    else{
        //image1
        $image_ext1 = pathinfo($image_name1,PATHINFO_EXTENSION);
        $image_ext_lc1 = strtolower($image_ext1);
        //image2
        $image_ext2 = pathinfo($image_name2,PATHINFO_EXTENSION);
        $image_ext_lc2 = strtolower($image_ext2);
        $allowed_ext = array("jpg","jpeg","png");
        if (in_array($image_ext_lc1,$allowed_ext) || in_array($image_ext_lc2,$allowed_ext)){
            //image1
            $new_image_name1 = uniqid("IMG-",true).'.'.$image_ext_lc1;
            $image_upload_path1 = '../img/Products/'.$table.'/'.$new_image_name1;
            move_uploaded_file($temp_name1,$image_upload_path1);//this will move the file from xammp server to my project server
            //image2
            $new_image_name2 = uniqid("IMG-",true).'.'.$image_ext_lc2;
            $image_upload_path2 = '../img/Products/'.$table.'/'.$new_image_name2;
            move_uploaded_file($temp_name2,$image_upload_path2);//this will move the file from xammp server to my project server
            //insert into database
            $sql1 = "INSERT into $table 
            (name,category,brand,current_price,raw_price,discount,property,description,seller_id,stock,image1,image2) 
            values 
            ('$product_name','$category','$brand','$current_price','$raw_price','$discount','$property','$description','$seller_id','$stock','$new_image_name1','$new_image_name2')";

            $result1 = mysqli_query($conn,$sql1);

            if (!$result1){
                $response = array("success" => false, "message" => "Something went wrong.");
                echo json_encode($response);
                exit;
            }

            $response = array("success" => true, "message" => "You have successfully added the products.");
            echo json_encode($response);
            mysqli_close($conn);


        }
        else {
            $error_message = "You can't upload this type of file.";
            echo $error_message;
            header("Location: seller_product_form.php");
        }
    }
}







