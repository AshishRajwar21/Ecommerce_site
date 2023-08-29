
<?php
session_start();

require "includes/db_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

$table = $_GET['item'];

$sql1 = "SELECT * from $table where id<=15";

$result1 = mysqli_query($conn,$sql1);

if (!$result1){
    echo "Something went wrong.";
    return;
}

$products = mysqli_fetch_all($result1,MYSQLI_ASSOC);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $table ?> | Buy <?= $table ?> Online At Low Prices In India</title>
    <!-- <link rel="stylesheet" href="css/item_list.css"> -->
    <link rel="stylesheet" href="css/item_list.css">
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
        <div class="sticky-top pt-5">
    <nav>
        <ul class="content-list">
            <li class="list <?= $table=="clothings" ? "active" : ""; ?>"><a class="clothing" href="item_list.php?item=clothings"><i class="fa fa-shirt"></i><span class="ms-2 d-none d-sm-inline">Clothing & shoes</span></a></li>
            <li class="list <?= $table=="musics" ? "active" : ""; ?>"><a class="music" href="item_list.php?item=musics"><i class="fa fa-music"></i><span class="ms-2 d-none d-sm-inline">Music</span></a></li>
            <li class="list <?= $table=="sports" ? "active" : ""; ?>"><a class="sport" href="item_list.php?item=sports"><i class="fa fa-volleyball"></i><span class="ms-2 d-none d-sm-inline">Sports & Lifestyle</span></a></li>
            <li class="list <?= $table=="kitchens" ? "active" : ""; ?>"><a class="kitchen" href="item_list.php?item=kitchens"><i class="fa-solid fa-kitchen-set"></i><span class="ms-2 d-none d-sm-inline">Kitchen Accessories</span></a></li>
            <li class="list <?= $table=="travels" ? "active" : ""; ?>"><a class="travel" href="item_list.php?item=travels"><i class="fa-solid fa-umbrella-beach"></i><span class="ms-2 d-none d-sm-inline">Travel equipment</span></a></li>
            <li class="list <?= $table=="gardens" ? "active" : ""; ?>"><a class="garden" href="item_list.php?item=gardens"><i class="fa-solid fa-spa"></i><span class="ms-2 d-none d-sm-inline">Growing & Garden</span></a></li>
            <li class="list <?= $table=="electricals" ? "active" : ""; ?>"><a class="electrical" href="item_list.php?item=electricals"><i class="fa fa-tv"></i><span class="ms-2 d-none d-sm-inline">Electrical Tools</span></a></li>
            <li class="list <?= $table=="toys" ? "active" : ""; ?>"><a class="toy" href="item_list.php?item=toys"><i class="fa-solid fa-child"></i><span class="ms-2 d-none d-sm-inline">Toys</span></a></li>
            <li class="list <?= $table=="groceries" ? "active" : ""; ?>"><a class="grocery" href="item_list.php?item=groceries"><i class="fa fa-light fa-basket-shopping"></i><span class="ms-2 d-none d-sm-inline">Grocery</span></a></li>
            <li class="list <?= $table=="pet_cares" ? "active" : ""; ?>"><a class="pet" href="item_list.php?item=pet_cares"><i class="fa-solid fa-dog"></i><span class="ms-2 d-none d-sm-inline">Pets care</span></a></li>
        </ul>
    </nav>
</div>
        </div>
        <div class="main-content-container">
            <div class="product-content-container">
                <div class="product-container">
                    <div class="product-title"><h3><?= $table ?></h3></div>
                    
                    <div class="product-card-container">
                        <?php
                        $table2 = $table."_testimonials";
                        foreach ($products as $product){
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

                            $product_images = glob("img/Products/".$table."/".$product['image1']);
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
                                                $table3 = $table."_likes";
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
    <script type="text/javascript" src="js/item_list.js"></script>
</body>
</html>