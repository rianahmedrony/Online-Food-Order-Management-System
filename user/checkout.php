<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

$title = 'Checkout';

if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}

if (count($_SESSION['cart']) == 0) {
    header('Location: ./index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment-method'];

    $total = 0;
    $cart = $_SESSION['cart'];

    foreach ($cart as $food_id => $quantity) {
        $food = $db->query("SELECT * FROM foods WHERE id = $food_id")->fetch();
        $total += $food['price'] * $quantity;
    }

    $sql = "SELECT id FROM customers WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_SESSION['user']]);
    $cust_id = $stmt->fetch()['id'];

    // Check if food is in stock
    $food = $db->query("SELECT * FROM foods WHERE id = $food_id")->fetch();
    if ($food['in_stock'] < $quantity) {
        $error = 'Sorry, ' . $food['name'] . ' is out of stock';
        exit;
    }

    // Add order
    $sql = "INSERT INTO orders (cust_id, full_name, email, mobile, address, total_amount, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $ordered = $stmt->execute([$cust_id, $full_name, $email, $mobile, $address, $total, $payment_method]);

    if ($ordered) {
        $order_id = $db->lastInsertId();
        foreach ($cart as $food_id => $quantity) {
            // Add order items
            $sql = "INSERT INTO order_items (order_id, food_id, price, quantity) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$order_id, $food_id, $food['price'], $quantity]);

            // Update food stock
            $sql = "UPDATE foods SET in_stock = in_stock - ?, sold = sold + ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$quantity, $quantity, $food_id]);
        }

        unset($_SESSION['cart']);
        header('Location: ./orders.php?order_placed');
    } else {
        $error = 'Something went wrong';
    }
}

$sql = "SELECT * FROM customers WHERE username = " . $db->quote($_SESSION['user']);
$result = $db->query($sql);
$row = $result->fetch();

require $root . '/inc/header.php'; ?>
</head>

<body>
    <?php include $root . '/inc/navbar.php'; ?>
    <div class="container-md my-4">
        <h1 class="text-center mb-md-5 mb-3">Checkout</h1>
        <div class="row g-5">
            <div class="col-md-7">
                <h2 class="mb-3">Shipping Information</h2>
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="full_name" id="full_name" pattern="[a-zA-Z ]{3,}" value="<?= $row['full_name'] ?>" required>
                        <div class="invalid-feedback">
                            Please enter reciever's full name.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= $row['email'] ?>" required>
                        <div class="invalid-feedback">
                            Please enter a valid email address.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" class="form-control" name="mobile" id="mobile" pattern="[0-9+-]{11,15}" value="<?= $row['mobile'] ?>" required>
                        <div class="invalid-feedback">
                            Please enter a valid mobile number.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" rows="3" required><?= $row['address'] ?></textarea>
                        <div class="invalid-feedback">
                            Please enter shipping address.
                        </div>
                    </div>
                    <hr class="my-4">
                    <h2 class="mb-3">Payment</h2>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment-method" id="COD" value="COD" checked>
                        <label class="form-check-label" for="COD">
                            Cash on Delivery
                        </label>
                    </div>
                    <hr class="my-4">
                    <button type="submit" class="btn btn-primary btn-block">Place Order</button>
                </form>
            </div>
            <div class="col-md-5">
                <h2>Order Summary</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            $cart = $_SESSION['cart'];
                            foreach ($cart as $food_id => $quantity) {
                                $food = $db->query("SELECT * FROM foods WHERE id = $food_id")->fetch();
                                $total += $food['price'] * $quantity;
                            ?>
                                <tr>
                                    <td><?= $food['name'] ?></td>
                                    <td><?= $quantity ?></td>
                                    <td><?= $food['price'] ?> Taka</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <h5>Total:</h5>
                    <h5><?= $total ?> Taka</h5>
                </div>

                <div class="text-center mt-3">
                    <a href="./cart.php" class="btn btn-outline-secondary">Modify items</a>
                </div>
            </div>
        </div>
    </div>
    <?php include $root . '/inc/footer.php'; ?>
    <script>
        const decBtns = document.querySelectorAll('.dec-btn');
        const incBtns = document.querySelectorAll('.inc-btn');

        decBtns.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                const foodId = e.target.getAttribute('data-food-id');
                const action = e.target.getAttribute('data-action');
                const quantity = e.target.getAttribute('data-quantity');

                if (quantity == 1) {
                    e.target.setAttribute('disabled', true);
                }

                const req = new XMLHttpRequest();
                req.open('POST', './update-cart.ajax.php', true);
                req.setRequestHeader('Content-Type', 'application/json');
                req.send(JSON.stringify({
                    food_id: foodId,
                    action: action
                }));
            });
        });

        incBtns.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                const foodId = e.target.getAttribute('data-food-id');
                const action = e.target.getAttribute('data-action');
                const quantity = e.target.getAttribute('data-quantity');

                if (quantity == 1) {
                    e.target.setAttribute('disabled', true);
                }

                const req = new XMLHttpRequest();
                req.open('POST', './update-cart.ajax.php', true);
                req.setRequestHeader('Content-Type', 'application/json');
                req.send(JSON.stringify({
                    food_id: foodId,
                    action: action
                }));
            });
        });
    </script>
</body>

</html>