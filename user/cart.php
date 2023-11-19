<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

$title = 'My Cart';

if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}

require $root . '/inc/header.php'; ?>
</head>

<body>
    <?php include $root . '/inc/navbar.php'; ?>
    <div class="container-md my-4">
        <h1 class="text-center my-3">My Cart</h1>


        <?php
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Action</th>
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
                            <tr data-food-id="<?php echo $food_id; ?>">
                                <td>
                                    <img src="/assets/images/foods/<?php echo $food['img']; ?>" alt="<?php echo $food['name']; ?>" class="table-img">
                                    <span><?php echo $food['name']; ?></span>
                                </td>
                                <td><?php echo $food['price']; ?> Taka</td>
                                <td>
                                    <span class="quantity"><?php echo $quantity; ?></span>
                                    <div class="btn-group ms-2">
                                        <button data-action="dec" class="btn btn-outline-secondary btn-sm update-quantity-btn">-</button>
                                        <button data-action="inc" class="btn btn-outline-primary btn-sm update-quantity-btn">+</button>
                                    </div>
                                </td>
                                <td><?php echo $food['price'] * $quantity; ?> Taka</td>
                                <td>
                                    <div>
                                        <button data-action="remove" class="btn btn-danger btn-sm update-quantity-btn">Remove</button>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="3" class="text-end">Total</td>
                            <td><?php echo $total; ?> Taka</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                <a href="/user/checkout.php" class="btn btn-primary">Checkout</a>
            </div>
        <?php } else { ?>
            <div class="alert alert-info mt-3 text-center">
                Your cart is empty!
            </div>
            <div class="mt-3 d-flex justify-content center">
                <a href="/" class="btn btn-primary mx-auto">Shop Now</a>
            </div>
        <?php } ?>
    </div>
    <?php include $root . '/inc/footer.php'; ?>
    <script>
        // Update cart
        const updateQuantityBtns = document.querySelectorAll('.update-quantity-btn');

        updateQuantityBtns.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();

                const food = e.target.parentElement.parentElement.parentElement;

                const foodId = food.getAttribute('data-food-id');
                const quantity = food.querySelector('.quantity').textContent;
                const action = e.target.getAttribute('data-action');

                fetch('./ajax/update_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        food_id: foodId,
                        action: action
                    })
                }).then(res => res.json()).then(res => {
                    if (res.status == 'success') {
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.message
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>