<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

$title = 'Register';

if (isset($_SESSION['user'])) {
    header('Location: ./profile.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $conf_pass = $_POST['conf_pass'];

    $usernameSql = "SELECT * FROM customers WHERE username = ?";
    $usernameStmt = $db->prepare($usernameSql);
    $usernameStmt->execute([$username]);

    $emailSql = "SELECT * FROM customers WHERE email = ?";
    $emailStmt = $db->prepare($emailSql);
    $emailStmt->execute([$email]);

    if ($usernameStmt->fetch()) {
        $errMsg = 'Username already exists!';
    } else if ($emailStmt->fetch()) {
        $errMsg = 'Email already exists!';
    } else if (strlen($full_name) < 4) {
        $errMsg = 'Full name must be at least 4 characters!';
    } else if (strlen($username) < 4) {
        $errMsg = 'Username must be at least 4 characters!';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errMsg = 'Invalid email!';
    } else if ($pass != $conf_pass) {
        $errMsg = 'Password does not match!';
    } else if (strlen($pass) < 8) {
        $errMsg = 'Password must be at least 8 characters!';
    } else {
        $sql = "INSERT INTO customers (full_name, username, email, pass) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([$full_name, $username, $email, password_hash($pass, PASSWORD_BCRYPT)]);
        if ($result) {
            header('Location: ./login.php?registered');
            exit;
        } else {
            $errMsg = 'Something went wrong!';
        }
    }
}

require $root . '/inc/header.php'; ?>
</head>

<body>
    <?php include $root . '/inc/navbar.php'; ?>
    <div class="container-md my-4">
        <h1 class="text-center my-3">Register</h1>
        <div class="card content-card">
            <div class="card-body">
                <?php
                if (isset($errMsg) && $errMsg != '')
                    echo "<div class='alert alert-danger'>$errMsg</div>";
                ?>
                <form method="POST" action="" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="full-name" class="form-label">Full name</label>
                        <input type="text" class="form-control" name="full_name" id="full-name" value="<?= $full_name ?>" pattern="[a-zA-Z. ]{3,}" required>
                        <div class="invalid-feedback">
                            Please enter your full name.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?= $username ?>" pattern="[a-zA-Z0-9-_]{3,}" required>
                        <div class="invalid-feedback">
                            Username must be at least 3 characters and can only contain letters, numbers, dashes and underscores.
                        </div>
                    </div>
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
                            Please enter a password.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="conf-pass" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="conf_pass" id="conf-pass" value="<?= $conf_pass ?>" required>
                        <div class="invalid-feedback">
                            Please confirm your password.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                <div class="mt-3">Already have an account? <a href="./login.php">Login</a></div>
            </div>
        </div>
    </div>
    <?php include $root . '/inc/footer.php'; ?>
</body>

</html>