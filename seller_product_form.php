<?php
session_start();
require "includes/db_connect.php";
$seller_id = $_SESSION['seller_id'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <!-- <link rel="stylesheet" href="css/seller_home.css"> -->
    <?php
    include "includes/head_links.php";
    ?>    
    <link rel="stylesheet" href="css/seller_product_form.css">
</head>
<body>
    <?php
    include "includes/seller_header.php";
    ?>
    <div class="content-container row">
        
        <div class="main-content-container">
            
            <div class="product-content-container">
                <div class="product-container">
                    <div class="product-title"><h3>Add Product</h3></div>
                    <div class="product-card-container">
                        <form action="api/add_product_submit.php" method="post" enctype="multipart/form-data">
                            <label for="product-name">Product Name : </label>
                            <input type="text" name="product-name" placeholder="Enter the product name">
                            <br>
                            <label for="product-category">Category : </label>
                            <input type="text" name="product-category" placeholder="Category">
                            <br>
                            <label for="product-category">Sub-category : </label>
                            <input type="text" name="product-sub-category" placeholder="Sub-category">
                            <br>
                            <label for="product-type">Type :</label>
                            <input type="text" name="product-type" placeholder="Type">
                            <br>
                            <label for="product-brand">Brand :</label>
                            <input type="text" name="product-brand" placeholder="Brand">
                            <br>
                            <label for="product-description">Description : </label>
                            <br>
                            <!-- <input type="text" name="product-description" placeholder="Enter the product description"> -->
                            <textarea name="description_area" cols="35" rows="4" placeholder="Add the product description"></textarea>
                            <h3>Stocks and Pricing</h3>
                            <label for="product-stock">Stocks : </label>
                            <input type="number" name="product-stocks" min="10" placeholder="10">
                            <br>
                            <label for="raw-price">Actual Price : </label>
                            <input type="number" name="product-raw-prices" min="1.00" value="1.00">
                            <label for="current-price">Discounted Price : </label>
                            <input type="number" name="product-current-prices" min="1.00" value="1.00">
                            <br>
                            <label for="product-image">Product Images 1: </label>
                            <input type="file" name="my_image1">
                            <br>
                            <label for="product-image">Product Images 2: </label>
                            <input type="file" name="my_image2">
                            <br>
                            <button type="submit" class="btn btn-warning">Submit</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include "includes/footer.php";
    ?>
</body>
</html>