<?php
session_start();


require "includes/db_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

$sql1 = "SELECT * from clothings where id<=6";

$result1 = mysqli_query($conn,$sql1);

if (!$result1){
    echo "Something went wrong.";
    return;
}

$products1 = mysqli_fetch_all($result1,MYSQLI_ASSOC);

$sql2 = "SELECT * from groceries where id<=4";

$result2 = mysqli_query($conn,$sql2);

if (!$result1){
    echo "Something went wrong.";
    return;
}

$products2 = mysqli_fetch_all($result2,MYSQLI_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce site</title>
    <link rel="stylesheet" href="css/index.css">
    <?php
    include "includes/head_links.php";
    ?>    
</head>
<body>
    <?php
    include "includes/header.php";
    ?>
    <div class="content-container">
        <div class="content-table">
            <?php
            include "includes/content.php";
            ?>
        </div>
        <div class="main-content-container">
            <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-indicators">
                    <?php
                    $ads_images = glob("img/Advertisement/*");
                    foreach ($ads_images as $index => $ads_image){
                    ?>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $index ?>" class="<?= $index==0 ? "active" : ""; ?>" aria-current="<?= $index==0 ? "true" : ""; ?>"></button> 
                        <?php
                    }
                    ?>
                </div>
                <div class="carousel-inner">
                    <?php
            
                    foreach ($ads_images as $index => $ads_image){
                    ?>
                        <div class="carousel-item <?= $index==0 ? "active" : "" ;?>">
                            <img class="d-block w-100" src="<?= $ads_image ?>" alt="slide">
                        </div>
                    <?php
                    }
                    ?>
    
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="product-content-container">
                <div class="product-container">
                    <div class="product-title"><h3>Product for you</h3></div>
                    <div class="product-card-container">
                        <?php
                        $table2 = "clothings_testimonials";
                        foreach ($products1 as $product){
                            // $table2 = $table."_testimonials";
                            $product_id = $product['id'];
                            $sql2 = "SELECT * from $table2 where product_id='$product_id'";

                            $result2 = mysqli_query($conn,$sql2);
                            if (!$result2){
                                echo "Something went wrong.";
                                return;
                            }
                            $testimonials = mysqli_fetch_all($result2,MYSQLI_ASSOC);

                            $review_count = mysqli_num_rows($result2);

                            $product_images = glob("img/Products/clothings/".$product['image1']);
                            ?>
                            <div class="product-item product-id-<?= $product['id'] ?>">
                                <div class="product-box">
                                    <div class="product-image">
                                        <a href="order_list.php?product_id=<?= $product['id']?>&item=<?= $table ?>">
                                            <img src="<?= $product_images[0] ?>"  alt="logo/images.png">
                                        </a>
                                    </div>
                                    <hr>
                                    <div class="product-detail">
                                        <div class="product-name-interested row justify-content-between">
                                            <div class="product-name col-auto">
                                                <a href="order_list.php?product_id=<?= $product['id']?>&item=<?= $table ?>">
                                                <?php 
                                                $sz = strlen($product['name']);
                                                if ($sz > 27){
                                                    echo substr($product['name'],0,24)."...";
                                                }
                                                else {
                                                    echo $product['name'];
                                                }
                                                ?>
                                                </a>
                                            </div>
                                            <div class="interested-container col-auto">
                                                <?php
                                                $table3 = "clothings_likes";
                                                $is_interested = false;
                                                $sql3 = "SELECT * from $table3 where product_id='$product_id'";
                                                $result3 = mysqli_query($conn,$sql3);
                                                if (!$result3){
                                                    echo "Something went wrong.";
                                                    return;
                                                }
                                                $liked_users = mysqli_num_rows($result3);
                                                $sql4 = "SELECT * from $table3 where product_id='$product_id' and user_id='$user_id'";
                                                $result4 = mysqli_query($conn,$sql4);
                                                if (!$result4){
                                                    echo "Something went wrong.";
                                                    return;
                                                }
                                                $rows = mysqli_num_rows($result4);
                                                if ($rows==1){
                                                    $is_interested = true;
                                                }
                                                if ($is_interested){
                                                    ?>
                                                    <i class="is-interested-image fas fa-heart" product_id="<?= $product_id ?>" item="<?= $table ?>"></i>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <i class="is-interested-image far fa-heart" product_id="<?= $product_id ?>" item="<?= $table ?>"></i>
                                                    <?php
                                                }
                                                ?>
                                                <div class="interested-text">
                                                    <span class="interested-user-count"><?= $liked_users ?></span>
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="property-container row justify-content-between">
                                            <div class="property col-auto"><?= $product['property'] ?></div>
                                            <div class="property col-auto"><?= $product['brand'] ?></div>
                                        </div>
                                        <div class="price-applied-container">
                                            <span class="discounted-price">Rs. <?= $product['current_price'] ?></span>
                                            <?php
                                            $dis = $product['discount'];
                                            if ($dis > 0){
                                                ?>
                                                <span class="actual-price">Rs. <?= $product['raw_price'] ?></span>
                                                <span class="discount-percentage"><?= $product['discount'] ?>% Off</span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="product-mode">Free Delivery</div>
                                        <?php
                                        
                                        $sum = 0;
                                        foreach ($testimonials as $testimonial){
                                            $sum += $testimonial['rating'];
                                        }
                                        $total_rating=0;
                                        if ($review_count!=0){
                                            $total_rating = $sum/$review_count;
                                        }
                                        
                                        ?>
                                        <div class="product-review row justify-content-between">
                                            <div class="star-container col-auto" title="<?= $total_rating ?>">
                                            <?php
                                            for ($i=0;$i<5;$i++){
                                                if ($total_rating >= $i + 0.8){
                                                    ?>
                                                    <i class="fas fa-star"></i>
                                                    <?php
                                                }
                                                else if ($total_rating >= $i + 0.3){
                                                    ?>
                                                    <i class="fa-solid fa-star-half-stroke"></i>
                                                    <?php
                                                }
                                                else {
                                                    ?>
                                                    <i class="far fa-star"></i> 
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                            </div>
                                            <div class="interested-user-container col-auto"><?= $review_count ?> Review</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="product-container">
                    <div class="product-title"><h3>Deal of the day</h3></div>
                    <div class="product-card-container">
                        <?php
                        $table2 = "groceries_testimonials";
                        foreach ($products2 as $product){
                            // $table2 = $table."_testimonials";
                            $product_id = $product['id'];
                            $sql2 = "SELECT * from $table2 where product_id='$product_id'";

                            $result2 = mysqli_query($conn,$sql2);
                            if (!$result2){
                                echo "Something went wrong.";
                                return;
                            }
                            $testimonials = mysqli_fetch_all($result2,MYSQLI_ASSOC);

                            $review_count = mysqli_num_rows($result2);

                            $product_images = glob("img/Products/groceries/".$product['image1']);
                            ?>
                            <div class="product-item product-id-<?= $product['id'] ?>">
                                <div class="product-box">
                                    <div class="product-image">
                                        <a href="order_list.php?product_id=<?= $product['id']?>&item=<?= $table ?>">
                                            <img src="<?= $product_images[0] ?>" alt="logo/images.png">
                                        </a>
                                    </div>
                                    <hr>
                                    <div class="product-detail">
                                        <div class="product-name-interested row justify-content-between">
                                            <div class="product-name col-auto">
                                                <a href="order_list.php?product_id=<?= $product['id']?>&item=<?= $table ?>">
                                                <?php 
                                                $sz = strlen($product['name']);
                                                if ($sz > 27){
                                                    echo substr($product['name'],0,24)."...";
                                                }
                                                else {
                                                    echo $product['name'];
                                                }
                                                ?>
                                                </a>
                                            </div>
                                            <div class="interested-container col-auto">
                                                <?php
                                                $table3 = "groceries_likes";
                                                $is_interested = false;
                                                $sql3 = "SELECT * from $table3 where product_id='$product_id'";
                                                $result3 = mysqli_query($conn,$sql3);
                                                if (!$result3){
                                                    echo "Something went wrong.";
                                                    return;
                                                }
                                                $liked_users = mysqli_num_rows($result3);
                                                $sql4 = "SELECT * from $table3 where product_id='$product_id' and user_id='$user_id'";
                                                $result4 = mysqli_query($conn,$sql4);
                                                if (!$result4){
                                                    echo "Something went wrong.";
                                                    return;
                                                }
                                                $rows = mysqli_num_rows($result4);
                                                if ($rows==1){
                                                    $is_interested = true;
                                                }
                                                if ($is_interested){
                                                    ?>
                                                    <i class="is-interested-image fas fa-heart" product_id="<?= $product_id ?>" item="<?= $table ?>"></i>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <i class="is-interested-image far fa-heart" product_id="<?= $product_id ?>" item="<?= $table ?>"></i>
                                                    <?php
                                                }
                                                ?>
                                                <div class="interested-text">
                                                    <span class="interested-user-count"><?= $liked_users ?></span>
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="property-container row justify-content-between">
                                            <div class="property col-auto"><?= $product['property'] ?></div>
                                            <div class="property col-auto"><?= $product['brand'] ?></div>
                                        </div>
                                        <div class="price-applied-container">
                                            <span class="discounted-price">Rs. <?= $product['current_price'] ?></span>
                                            <?php
                                            $dis = $product['discount'];
                                            if ($dis > 0){
                                                ?>
                                                <span class="actual-price">Rs. <?= $product['raw_price'] ?></span>
                                                <span class="discount-percentage"><?= $product['discount'] ?>% Off</span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="product-mode">Free Delivery</div>
                                        <?php
                                        
                                        $sum = 0;
                                        foreach ($testimonials as $testimonial){
                                            $sum += $testimonial['rating'];
                                        }
                                        $total_rating=0;
                                        if ($review_count!=0){
                                            $total_rating = $sum/$review_count;
                                        }
                                        
                                        ?>
                                        <div class="product-review row justify-content-between">
                                            <div class="star-container col-auto" title="<?= $total_rating ?>">
                                            <?php
                                            for ($i=0;$i<5;$i++){
                                                if ($total_rating >= $i + 0.8){
                                                    ?>
                                                    <i class="fas fa-star"></i>
                                                    <?php
                                                }
                                                else if ($total_rating >= $i + 0.3){
                                                    ?>
                                                    <i class="fa-solid fa-star-half-stroke"></i>
                                                    <?php
                                                }
                                                else {
                                                    ?>
                                                    <i class="far fa-star"></i> 
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                            </div>
                                            <div class="interested-user-container col-auto"><?= $review_count ?> Review</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="product-container-id-3">
                    
                </div>
            </div>
        </div>
    </div>
    <?php
    include "includes/login_modal.php";
    include "includes/signup_modal.php";
    include "includes/seller_login_modal.php";
    include "includes/seller_signup_modal.php";
    include "includes/footer.php";
    ?>
</body>
</html>