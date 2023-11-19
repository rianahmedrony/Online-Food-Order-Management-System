<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

$title = 'Login';

if (isset($_SESSION['user'])) {
    header('Location: ./profile.php');
    exit;
}

$referrer_page = basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
if (isset($_GET['registered']) && $referrer_page == 'register.php') {
    $msg = 'You have successfully registered! You can login now.';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $query = "SELECT * FROM customers WHERE email = " . $db->quote($email);
    $result = $db->query($query);
    $row = $result->fetch();

    if ($row) {
        $hash = $row['pass'];
        if (password_verify($pass, $hash)) {
            $_SESSION['user'] = $row['username'];
            header('Location: /');
            exit;
        } else {
            $errMsg = 'Invalid email or password.';
        }
    } else {
        $errMsg = 'Invalid email or password.';
    }
}

require $root . '/inc/header.php'; ?>
</head>

<body>
    <?php include $root . '/inc/navbar.php'; ?>
    <div class="container-md my-4">
        <h1 class="text-center my-3">Login</h1>
        <div class="card content-card">
            <div class="card-body">
                <?php if (isset($errMsg)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $errMsg ?>
                    </div>
                <?php endif; ?>
                <?php
                if (isset($msg))
                    echo "<div class='alert alert-success'>$msg</div>";
                ?>
                <form method="POST" action="" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= $email ?>" required>
                        <div class="invalid-feedback">
                            Please enter a valid email address.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Password</label>
                        <input type="password" class="form-control" name="pass" id="pass" value="<?= $pass ?>" required>
                        <div class="invalid-feedback">
                            Please enter your password.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <div class="mt-3">Don't have an account? <a href="./register.php">Register</a></div>
            </div>
        </div>
    </div>
    <?php include $root . '/inc/footer.php'; ?>
</body>

</html>