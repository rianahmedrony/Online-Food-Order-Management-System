<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

$title = 'Order Details';

if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}

if ($_GET['id']) {
    $order_id = $_GET['id'];
    $sql = "SELECT * FROM order_items WHERE order_id = $order_id";
    $order_items = $db->query($sql)->fetchAll();

    if (count($order_items) == 0) {
        header('Location: /index.php');
        exit;
    }
}

require $root . '/inc/header.php'; ?>
</head>

<body>
    <?php include $root . '/inc/navbar.php'; ?>
    <div class="container-md my-4">
        <h1 class="text-center my-3">Order Details</h1>
        <div class="table-respondive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col">Food</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($order_items as $item) {
                        $sql = "SELECT * FROM foods WHERE id = " . $item['food_id'];
                        $product = $db->query($sql)->fetch();
                        $total += $item['quantity'] * $product['price'];
                    ?>
                        <tr>
                            <td>
                                <img src="/assets/images/foods/<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>" class="table-img">
                                <span><?php echo $product['name']; ?></span>
                            </td>
                            <td><?php echo $product['price']; ?> Taka</td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $item['quantity'] * $product['price']; ?> Taka</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                <h4>Total: <?php echo $total; ?> Taka</h4>
            </div>

            <div class="mt-3">
                <a href="./orders.php" class="btn btn-primary">&laquo; Back</a>
            </div>


        </div>
    </div>
    <?php include $root . '/inc/footer.php'; ?>
</body>

</html>