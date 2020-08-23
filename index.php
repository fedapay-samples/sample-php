<?php include 'inc/header.php'; ?>

<div class="row">
    <?php
    $data = file_get_contents("data.json", true);
    $array = json_decode($data, true);
    foreach ($array as $key => $product) {
    ?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">

            <?php include 'inc/card.php'; ?>

            <!--Description Modal-->
            <?php include 'inc/product-modal.php'; ?>

            <!--Checkout Modal-->
            <?php include 'inc/checkout-modal.php'; ?>
        </div>
    <?php
    }
    ?>
</div>

<?php include 'inc/footer.php'; ?>
