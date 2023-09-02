<?php
session_start();
require "includes/db_connect.php";
$seller_id = $_SESSION['seller_id'];



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce site</title>
    <!-- <link rel="stylesheet" href="css/seller_home.css"> -->
    <?php
    include "includes/head_links.php";
    ?>    
    <link rel="stylesheet" href="css/seller_home.css">
</head>
<body>
    <?php
    include "includes/seller_header.php";
    ?>
    <div class="content-container">
        
        <div class="main-content-container">
            
            <div class="product-content-container">
                <div class="product-container">
                    <div class="product-title"><h3>Products</h3></div>
                    <div class="product-card-container">
                        <div class="add-product-container">
                            <div class="add-product-box">
                                <a href="seller_product_form.php"><button class="btn btn-primary">+ Add Product</button></a>
                            </div>
                        </div>
                        <div class="product-list-container">
                            <div class="product-box-container">
                                <div class="image-container">
                                    <b>Image</b>
                                    <!-- use ' ' instead of " " for passing parameter in javascript -->
                                    
                                </div>
                                <div class="product-name-container">
                                    <b>Product Name</b>
                                </div>
                                <div class="product-category-container">
                                    <b>Category</b>
                                </div>
                                <div class="product-stock-container ms-2 d-none d-sm-inline">
                                    <b>Stock</b>
                                </div>
                                <div class="product-price-container">
                                    <b>Price</b>
                                </div>
                                <div class="product-action-container ms-2 d-none d-sm-inline">
                                    <b>Action</b>
                                </div>                            
                            </div>
                            <?php
                            $categories = array("clothings","musics","sports","kitchens","travels","gardens","electricals","toys","groceries","pet_cares");
                            foreach ($categories as $category){
                                $sql1 = "SELECT * from $category where seller_id='$seller_id' and id<=20";
                                $result1 = mysqli_query($conn,$sql1);
                                if (!$result1){
                                    echo "Something went wrong.";
                                    return;
                                }
                                $products = mysqli_fetch_all($result1,MYSQLI_ASSOC);
                                foreach ($products as $product){
                                    $product_image = glob("img/Products/".$category."/".$product['image1']);
                                    ?>
                                    <div class="product-box-container">
                                        <div class="image-container">
                                            <div class="product-image mb-2">
                                                <img src="<?= $product_image[0] ?>" alt="logo/images.png">
                                            </div>
                                            <!-- use ' ' instead of " " for passing parameter in javascript -->
                                    
                                        </div>
                                        <div class="product-name-container">
                                            <?= $product['name'] ?>
                                        </div>
                                        <div class="product-category-container">
                                            <?= $category ?>
                                        </div>
                                        <div class="product-stock-container ms-2 d-none d-sm-inline">
                                            <?= $product['stock'] ?>
                                        </div>
                                        <div class="product-price-container">
                                            <?= $product['current_price'] ?>
                                        </div>
                                        <div class="product-action-container ms-2 d-none d-sm-inline">
                                            Action
                                        </div>                            
                                    </div>
                                    <?php
                                }
                                ?>

                                

                                <?php
                            }
                            ?>
                            
                            
                        </div>
                        
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