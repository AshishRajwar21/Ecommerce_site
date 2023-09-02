<?php
session_start();

require "includes/db_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$table = $_GET['item'];
$product_id = $_GET['product_id'];

$sql1 = "SELECT * from $table where id='$product_id'";

$result1 = mysqli_query($conn,$sql1);

if (!$result1){
    echo "Something went wrong.";
    return ;
}
$product = mysqli_fetch_assoc($result1);

$table2 = $table."_testimonials";
$sql2 = "SELECT * from $table2 where product_id='$product_id'";

$result2 = mysqli_query($conn,$sql2);
if (!$result2){
    echo "Something went wrong.";
    return;
}
$testimonials = mysqli_fetch_all($result2,MYSQLI_ASSOC);

$review_count = mysqli_num_rows($result2);

$is_cart=false;
if ($user_id==NULL){
    $is_cart=false;
}
else{

$sql3 = "SELECT * FROM cart WHERE user_id='$user_id' and product_id = '$product_id' and item = '$table'";
$result3 = mysqli_query($conn,$sql3);
if (!$result3) {
    echo "Something went wrong";
    return;
}
//$is_cart = false;
if (mysqli_num_rows($result3) > 0){
    $is_cart = true;
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $table ?> | Buy <?= $table ?> Online At Low Prices In India</title>
    <?php
    include "includes/head_links.php";
    ?>
    <link rel="stylesheet" href="css/order_list.css">
    
</head>
<body>
    <?php
    include "includes/header.php";
    ?>
    <div class="current-product-detail-container row">
        <div class="col-lg-5">
            <?php
            //$pd_image = "$product_id".".jpeg";
            $product_image1 = glob("img/Products/".$table."/".$product['image1']);
            $product_image2 = glob("img/Products/".$table."/".$product['image2']);
            ?>
            <div class="product-preview-container">
                <div class="product-image-container row">
                    <div class="preview-image col-2">
                        <div class="row">
                            <div class="front-view"><img src="<?= $product_image1[0] ?>" alt="logo/images.png"></div>
                            <div class="back-view"><img src="<?= $product_image2[0] ?>" alt="logo/images.png"></div>
                        </div>
                    </div>
                    <div class="full-image col-10">
                        <img src="<?= $product_image1[0] ?>" alt="logo/images.png">
                    </div>
                </div>
                <div class="form-box">
                    <form id="cart-form" action="api/toggle_cart.php" method="post">
                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                <input type="hidden" name="item" value="<?= $table ?>">
                <?php
                if ($is_cart==false){
                    ?>
                    <input type="number" class="quantity" value="1" min="1" max="5" name="quantity" placeholder="Quantity" required>
                    <?php
                }
                ?>
                <div class="button-container btn-group justify-content-center" role="group">
                    <button type="submit" class="cart-button btn btn-success" name="cart">
                        <?php
                        if ($is_cart==true){
                            echo "Remove from cart";
                        }
                        else{
                            echo "Add To Cart";
                        }
                        ?>
                    </button>
                    <button class="buy-button btn btn-warning" name="buy">Buy Now</button>
                </div>
                    </form>
                </div>
                
            </div>
        </div>
        <div class="col-lg-7 product-id-<?= $product_id ?>">
            <div class="product-description">
                <div class="product-name-interested row justify-content-between">
                    <div class="product-name col-auto">
                        <a href="order_list.php?product_id=<?= $product['id']?>&item=<?= $table ?>">
                            <?php 
                            $sz = strlen($product['name']);
                            if ($sz > 44){
                                echo substr($product['name'],0,41)."...";
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
                    <div class="property col-auto">Type : <?= $product['property'] ?></div>
                    <div class="property col-auto">Brand : <?= $product['brand'] ?></div>
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
                <div class="description">
                    Description : <?= $product['description'] ?>
                </div>
            </div>

            <hr>
            <div class="review-container">
                <h4>Product Reviews</h4>
                <div class="people-review-container">
                    
                    <?php
                    
                    $sql5 = "SELECT * from $table2 where user_id='$user_id' and product_id='$product_id'";
                    $result5 = mysqli_query($conn,$sql5);
                    if (!$result5){
                        echo "Something went wrong.";
                        return;
                    }
                    $user_comment = mysqli_num_rows($result5);
                    
                    $sql6 = "SELECT * from users where id='$user_id'";
                    $result6 = mysqli_query($conn,$sql6);
                    if (!$result6){
                        echo "Something went wrong.";
                        return;
                    }
                    $user_data = mysqli_fetch_assoc($result6);
                    if ($user_comment==0){
                    ?>
                    <form action="api/add_comment.php" method="post">
                        <textarea name="comment_area" cols="40" rows="3" placeholder="Add your comments"></textarea>
                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                        <input type="hidden" name="product_id" value="<?= $product_id ?>">
                        <input type="hidden" name="item" value="<?= $table ?>">
                        <input type="hidden" name="rating" id="star-value" value="<?= 5?>">
                        <div class="star-container">
                        <i class="star-rating far fa-star" onmouseover="star_function(1)"></i>
                        <i class="star-rating far fa-star" onmouseover="star_function(2)"></i>
                        <i class="star-rating far fa-star" onmouseover="star_function(3)"></i>
                        <i class="star-rating far fa-star" onmouseover="star_function(4)"></i>
                        <i class="star-rating far fa-star" onmouseover="star_function(5)"></i>
                        </div>
                        
                        <button type="submit" class="send-button btn btn-success">Send</button>

                    </form>
                    <?php
                    }
                    else{
                        
                        ?>
                        <hr>
                        <div class="review-box row">
                            <div class="profile-image-container col-1">
                                <div class="profile-image">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            </div>
                            <div class="comment-detail col-11">
                                <div class="user-detail row justify-content-between">
                                    <div class="col-auto">
                                        <span class="user-name"><?= $user_data['email'] ?> </span>
                                        <?php
                                        $user_testimonial = mysqli_fetch_assoc($result5);
                                        $total_rating = $user_testimonial['rating'];
                                        ?>
                                        <span class="star-container" title="<?= $total_rating ?>">
                                        <?php
                                        //$total_rating = $testimonial['rating'];
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
                                        </span>
                                    </div>
                                    <div class="col-auto"><span class="review-date">Date : <?= $user_testimonial['review_date'] ?></span></div>
                                </div>
                                <div class="user-comment">
                                <p>
                                <?php 
                                    $sz = strlen($user_testimonial['review_comment']);
                                    if ($sz == 255){
                                        echo substr($user_testimonial['review_comment'],0,252)."...";
                                    }
                                    else {
                                        echo $user_testimonial['review_comment'];
                                    }
                                ?>
                                </p>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    foreach ($testimonials as $testimonial){
                        $user = $testimonial['user_id'];
                        if ($user==$user_id){
                            continue;
                        }
                        $sql7 = "SELECT * from users where id='$user'";
                        $result7 = mysqli_query($conn,$sql7);
                        if (!$result7){
                            echo "Something went wrong.";
                            return;
                        }
                        $user_data2 = mysqli_fetch_assoc($result7);
                        ?>
                        <hr>
                        <div class="review-box row">
                            <div class="profile-image-container col-1">
                                <div class="profile-image">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            </div>
                            <div class="comment-detail col-11">
                                <div class="user-detail row justify-content-between">
                                    <div class="col-auto">
                                        <span class="user-name"><?= $user_data2['email'] ?> </span>
                                        <?php
                                        $total_rating = $testimonial['rating'];
                                        ?>
                                        <span class="star-container" title="<?= $total_rating ?>">
                                            <?php
                                            //$total_rating = $testimonial['rating'];
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
                                        </span>
                                    </div>
                                    <div class="col-auto"><span class="review-date">Date : <?= $testimonial['review_date'] ?></span></div>
                                </div>
                                <div class="user-comment">
                                    <p>
                                    <?php 
                                        $sz = strlen($testimonial['review_comment']);
                                        if ($sz == 255){
                                            echo substr($testimonial['review_comment'],0,252)."...";
                                        }
                                        else {
                                            echo $testimonial['review_comment'];
                                        }
                                    ?>
                                    </p>
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
    <div class="similar-product-container mx-lg-5">
        <div class="product-container">
            <h1>Similar Products</h1>
            <div class="product-card-container row">
            <?php
            $product_brand = $product['brand'];
            $product_category = $product['category'];
            $sql4 = "SELECT * from $table where id<=15 and (brand='$product_brand' or category='$product_category')";
            $result4 = mysqli_query($conn,$sql4);
            if (!$result4){
                echo "Something went wrong.";
                return ;
            }
            $similar_products = mysqli_fetch_all($result4,MYSQLI_ASSOC);

            $table2 = $table."_testimonials";
            foreach ($similar_products as $similar_product){
                $similar_product_id = $similar_product['id'];
                if ($similar_product_id == $product_id){
                    continue;
                }
                $similar_product_images = glob("img/Products/".$table."/".$similar_product['image1']);
                ?>
                <div class="product-item product-id-<?= $similar_product_id ?> col-lg-2">
                    <div class="product-box">
                        <div class="product-image">
                            <a href="order_list.php?product_id=<?= $similar_product_id ?>&item=<?= $table?>">
                            <img src="<?= $similar_product_images[0] ?>" alt="logo/images.png"></a>
                        </div>
                        <hr>
                        <div class="product-detail">
                            <div class="product-name-interested row justify-content-between">
                                <div class="product-name col-auto">
                                    <a href="order_list.php?product_id=<?= $similar_product_id ?>&item=<?= $table?>">
                                    <?php 
                                                $sz = strlen($product['name']);
                                                if ($sz > 21){
                                                    echo substr($product['name'],0,18)."...";
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
                                    $sql3 = "SELECT * from $table3 where product_id='$similar_product_id'";
                                    $result3 = mysqli_query($conn,$sql3);
                                    if (!$result3){
                                        echo "Something went wrong.";
                                        return;
                                    }
                                    $liked_users = mysqli_num_rows($result3);
                                    $sql4 = "SELECT * from $table3 where product_id='$similar_product_id' and user_id='$user_id'";
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
                                        <i class="is-interested-image fas fa-heart" product_id="<?= $similar_product_id ?>" item="<?= $table ?>"></i>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <i class="is-interested-image far fa-heart" product_id="<?= $similar_product_id ?>" item="<?= $table ?>"></i>
                                        <?php
                                    }
                                    ?>
                                    <div class="interested-text">
                                        <span class="interested-user-count"><?= $liked_users ?></span>
                                    </div>
                                </div>    
                            </div>
                            <div class="property-container row justify-content-between">
                                <div class="property col-auto"><?= $similar_product['property'] ?></div>
                                <div class="property col-auto"><?= $similar_product['brand'] ?></div>
                            </div>
                            <div class="price-applied-container">
                                <span class="discounted-price">Rs. <?= $similar_product['current_price'] ?></span>
                                <?php
                                $dis = $similar_product['discount'];
                                if ($dis > 0){
                                    ?>
                                    <span class="actual-price">Rs. <?= $similar_product['raw_price'] ?></span>
                                    <span class="discount-percentage"><?= $similar_product['discount'] ?>% Off</span>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="product-mode">Free Delivery</div>
                            <?php
                                $sql5 = "SELECT * from $table2 where product_id='$similar_product_id'";

                                $result5 = mysqli_query($conn,$sql5);
                                if (!$result5){
                                    echo "Something went wrong.";
                                    return;
                                }
                                $testimonials = mysqli_fetch_all($result5,MYSQLI_ASSOC);
    
                                $review_count = mysqli_num_rows($result5);
            
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
    <div class="recommended-product-container mx-lg-5">
        <div class="product-container">
            <h1>Recommended Products</h1>
            <div class="product-card-container row">
            <?php
            $product_brand = $product['brand'];
            $product_category = $product['category'];
            $sql4 = "SELECT * from $table where id<=15 and (brand='$product_brand' or category='$product_category')";
            $result4 = mysqli_query($conn,$sql4);
            if (!$result4){
                echo "Something went wrong.";
                return ;
            }
            $similar_products = mysqli_fetch_all($result4,MYSQLI_ASSOC);

            $table2 = $table."_testimonials";
            foreach ($similar_products as $similar_product){
                $similar_product_id = $similar_product['id'];
                if ($similar_product_id == $product_id){
                    continue;
                }
                $similar_product_images = glob("img/Products/".$table."/".$similar_product['image1']);
                ?>
                <div class="product-item product-id-<?= $similar_product_id ?> col-lg-2">
                    <div class="product-box">
                        <div class="product-image">
                            <a href="order_list.php?product_id=<?= $similar_product_id ?>&item=<?= $table?>">
                            <img src="<?= $similar_product_images[0] ?>" alt="logo/images.png"></a>
                        </div>
                        <hr>
                        <div class="product-detail">
                            <div class="product-name-interested row justify-content-between">
                                <div class="product-name col-auto">
                                    <a href="order_list.php">
                                    <?php 
                                                $sz = strlen($product['name']);
                                                if ($sz > 27){
                                                    echo substr($product['name'],0,18)."...";
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
                                    $sql3 = "SELECT * from $table3 where product_id='$similar_product_id'";
                                    $result3 = mysqli_query($conn,$sql3);
                                    if (!$result3){
                                        echo "Something went wrong.";
                                        return;
                                    }
                                    $liked_users = mysqli_num_rows($result3);
                                    $sql4 = "SELECT * from $table3 where product_id='$similar_product_id' and user_id='$user_id'";
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
                                        <i class="is-interested-image fas fa-heart" product_id="<?= $similar_product_id ?>" item="<?= $table ?>"></i>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <i class="is-interested-image far fa-heart" product_id="<?= $similar_product_id ?>" item="<?= $table ?>"></i>
                                        <?php
                                    }
                                    ?>
                                    <div class="interested-text">
                                        <span class="interested-user-count"><?= $liked_users ?></span>
                                    </div>
                                </div>    
                            </div>
                            <div class="property-container row justify-content-between">
                                <div class="property col-auto"><?= $similar_product['property'] ?></div>
                                <div class="property col-auto"><?= $similar_product['brand'] ?></div>
                            </div>
                            <div class="price-applied-container">
                                <span class="discounted-price">Rs. <?= $similar_product['current_price'] ?></span>
                                <?php
                                $dis = $similar_product['discount'];
                                if ($dis > 0){
                                    ?>
                                    <span class="actual-price">Rs. <?= $similar_product['raw_price'] ?></span>
                                    <span class="discount-percentage"><?= $similar_product['discount'] ?>% Off</span>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="product-mode">Free Delivery</div>
                            <?php
                                $sql5 = "SELECT * from $table2 where product_id='$similar_product_id'";

                                $result5 = mysqli_query($conn,$sql5);
                                if (!$result5){
                                    echo "Something went wrong.";
                                    return;
                                }
                                $testimonials = mysqli_fetch_all($result5,MYSQLI_ASSOC);
    
                                $review_count = mysqli_num_rows($result5);
            
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

    <?php
    include "includes/login_modal.php";
    include "includes/signup_modal.php";
    include "includes/seller_login_modal.php";
    include "includes/seller_signup_modal.php";
    include "includes/footer.php";
    ?>
    <script type="text/javascript" src="js/toggle_cart.js"></script>    
    <script type="text/javascript" src="js/order_list.js"></script>
    <script type="text/javascript" src="js/star.js"></script>
    <!-- <script type="text/javascript" src="js/cart_list.js"></script> -->
</body>
</html>