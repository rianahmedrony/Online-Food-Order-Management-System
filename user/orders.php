<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

$title = 'My Orders';

if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}

$referrer_page = basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
if (isset($_GET['order_placed']) && $referrer_page == 'checkout.php') {
    $msg = 'Order placed successfully!';
}

require $root . '/inc/header.php'; ?>
</head>

<body>
    <?php include $root . '/inc/navbar.php'; ?>
    <div class="container-md my-4">
        <h1 class="text-center my-3">My Orders</h1>

        <?php if (isset($msg)) : ?>
            <div class="alert alert-success" role="alert">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <?php
        $sql = "SELECT * FROM customers WHERE username = " . $db->quote($_SESSION['user']);
        $custResult = $db->query($sql);
        $cust = $custResult->fetch();

        $sql = "SELECT * FROM orders WHERE cust_id = " . $cust['id'];
        $result = $db->query($sql);

        if ($result->rowCount() == 0) {
            echo '<div class="alert alert-info" role="alert">You have no orders yet.</div>';
        } else {
        ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Date</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch()) {
                            echo '<tr>';
                            echo '<th scope="row">' . $row['id'] . '</th>';
                            echo '<td>' . $row['date'] . '</td>';
                            echo '<td>' . $row['total_amount'] . '</td>';
                            echo '<td>' . $row['payment_method'] . '</td>';
                            echo '<td>' . $row['status'] . '</td>';
                            echo '<td><a href="./order-details.php?id=' . $row['id'] . '" class="btn btn-primary">View</a></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
    <?php include $root . '/inc/footer.php'; ?>
</body>

</html>