<?php
session_start();

require "includes/db_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

$table = "cart_".$user_id;

$sql1 = "SELECT * FROM $table";
$result1 = mysqli_query($conn,$sql1);
if (!$result1) {
    echo "Something went wrong";
    return;
}
$is_cart_avalaible = false;
if (mysqli_num_rows($result1) > 0){
    $is_cart_avalaible = true;
}
$cart_products = mysqli_fetch_all($result1,MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electrical Tools | Buy Electrical Tools Online At Low Prices In India</title>
    <!-- <link rel="stylesheet" href="css/item_list.css"> -->
    <!-- <link rel="stylesheet" href="css/cart_list.css"> -->
    <?php
    include "includes/head_links.php";
    ?>
    <link rel="stylesheet" href="css/cart_list.css">
</head>
<body>
    <?php
    include "includes/header.php";
    ?>
    <div class="cart-content-container row">
        <div class="page-container col-lg-8">
            <div class="cart-container">
                <div class="cart-heading">
                    <h2>My Cart</h2>
                </div>
                <div class="cart-box-container">
                    <?php
                    if ($is_cart_avalaible==false){
                        echo "No Item is Available In The Cart.";
                        return ;
                    }
                    $total_item = 0;
                    $total_raw_price = 0;
                    $total_discounted_price = 0;
                    foreach ($cart_products as $cart_product){
                        $table = $cart_product['item'];
                        $product_id = $cart_product['product_id'];
                        $sql2 = "select * from $table where id='$product_id'";
                        $result2 = mysqli_query($conn,$sql2);
                        if (!$result2){
                            echo "Something went wrong.";
                            return ;
                        }
                        $product = mysqli_fetch_assoc($result2);
                        $product_quantity = $cart_product['quantity'];
                        $product_image = glob("img/Products/".$table."/".$product['image1']);
                        $total_item++;
                        $total_raw_price += $product_quantity*$product['raw_price'];
                        $total_discounted_price += $product_quantity*$product['current_price'];
                        
                        ?>
                        <div class="cart-item-container product-id-<?= $product_id ?>-item-<?= $table ?> row">
                            <div class="image-container">
                                <div class="product-image mb-2">
                                    <img src="<?= $product_image[0] ?>" alt="logo/images.png">
                                </div>
                                <!-- use ' ' instead of " " for passing parameter in javascript -->
                                <div class="cart-image row justify-content-center">
                                    <div class="minus-container col-auto" onclick="decrement(<?=$product_id ?>,'<?= $table ?>',<?= $product['current_price'] ?>,<?= $product['raw_price'] ?>)">-</div>
                                    <div class="count-container col-auto" id="count-cart-<?=$product_id ?>-<?= $table ?>"><?= $product_quantity ?></div>
                                    <div class="plus-container col-auto" onclick="increment(<?=$product_id ?>,'<?= $table ?>',<?= $product['current_price'] ?>,<?= $product['raw_price'] ?>)">+</div>
                                </div>
                            </div>
                            <div class="cart-detail-container">
                                <div class="product-type-container row justify-content-between">
                                    <div class="product-name col-auto">
                                        <a href="order_list.php?product_id=<?= $product_id ?>&item=<?= $table ?>"><?= $product['name'] ?></a>
                                    </div>
                                    <div class="product-delivery col-auto">
                                        Delivery by MON JUN 3 | Rs. 0
                                    </div>
                                </div>
                                <div class="product-detail-container">
                                    <div class="seller-container">
                                        Seller : LA WELLNESS
                                    </div>
                                    <div class="price-applied-container">
                                        <span class="discounted-price">Rs. <span id="discounted-price-<?=$product_id ?>-<?= $table ?>"><?= $product_quantity*$product['current_price'] ?></span></span>
                                        <?php
                                        $dis = $product['discount'];
                                        if ($dis > 0){
                                            ?>
                                            <span class="actual-price">Rs. <span id="actual-price-<?=$product_id ?>-<?= $table ?>"><?= $product_quantity*$product['raw_price'] ?></span></span>
                                            <span class="discount-percentage"><?= $product['discount'] ?>% Off</span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="choice-container row">
                                        <form id="cart-update-form-<?= $product_id ?>-<?= $table ?>" action="api/toggle_update.php" method="post">
                                        <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                        <input type="hidden" name="item" value="<?= $table ?>">
                                        <input type="hidden" name="quantity" id="cart-quantity-<?= $product_id ?>-<?= $table ?>" value='<?= $product_quantity ?>'>
                                        <button class="update col-auto btn btn-success mb-2" type="submit" name="update">
                                            Update
                                        </button>
                                        </form>
                                        <form id="cart-remove-form-<?= $product_id ?>-<?= $table ?>" action="api/toggle_remove.php" method="post">
                                        <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                        <input type="hidden" name="item" value="<?= $table ?>">
                                        <!-- <input type="number" value='min='1' max='5'' placeholder="Quantity"> -->
                                        <button class="remove col-auto btn btn-danger" type="submit" name="remove">
                                            Remove
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="place-order justify-content-end">
                    <button type="submit" class="place-order-button btn btn-warning">Place Order</button>
                </div>
            </div>
        </div>
        <div class="price-detail-container col-lg-4">
            <div class="price-detail">
                <h2>Price Details</h2>
                <hr>
                <div class="total-price row justify-content-between pb-2">
                    <div class="total-item col-auto" id="total-item">
                        Price (<?= $total_item ?> items)
                    </div>
                    <div class="total-item-price col-auto">
                        Rs. <span id="total-raw-price"><?= $total_raw_price ?></span>
                    </div>
                </div>
                <div class="discount row justify-content-between pb-2">
                    <div class="discount-item col-auto">
                        Discount
                    </div>
                    <div class="discount-item-price col-auto">
                        Rs. <span id="total-discount-price"><?= $total_raw_price-$total_discounted_price?></span>
                    </div>
                </div>
                <div class="delivery row justify-content-between pb-2">
                    <div class="delivery-item col-auto">
                        Delivery Charges
                    </div>
                    <div class="delivery-item-price col-auto">
                        Rs. 0
                    </div>
                </div>
                <hr>
                <div class="total-amount row justify-content-between pb-2">
                    <div class="total-amount-item col-auto">
                        Total Amount
                    </div>
                    <div class="total-item-price col-auto">
                        Rs. <span id="total-item-price"><?= $total_discounted_price ?></span>
                    </div>
                </div>
                <hr>
                <div class="saving-price">
                    <h6>You will save upto Rs. <span id="saving-price"><?= $total_raw_price-$total_discounted_price?></span> on this order.</h6>
                </div>
            </div>
        </div>
    </div>
    <?php
    include "includes/footer.php";
    ?>
    <script type="text/javascript" src="js/remove_cart_list.js"></script>
    <script src="js/incredecre.js"></script>
    
</body>
</html>