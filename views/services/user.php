<?php
    $user_id = $_SESSION['user_login'];
    $all_food = $dataHandler->get("SELECT food.*, food.type_id, food.shop_id, shop.name AS shopname, food_type.name AS foodtype FROM food JOIN shop ON food.shop_id = shop.id JOIN food_type ON food.type_id = food_type.id");
    $all_cart = $dataHandler->get("SELECT * FROM cart WHERE uses_id = $user_id");
    $all = 0;

    include 'widgets/modal.php';
    $userhead = ['ID', 'name', 'price', 'qty', 'discount', 'shop_ID'];
    $userbody = ['id', 'name', 'price', 'qty', 'discount','shop_id'];
?>

<?php include 'widgets/content.php' ?>

<div class="container">
    <!-- <?php var_dump($all_food); ?> -->

    <?php $interface->table($userhead, $userbody, $all_cart); ?>

    <a href="class/handle.php?checkout=<?= $useAuth['user']['id'] ?>">checkout</a>
</div>

