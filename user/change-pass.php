<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

$title = 'Change Password';

if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $new_pass_conf = $_POST['new_pass_conf'];

    if ($new_pass != $new_pass_conf) {
        $errMsg = 'New Passwords do not match!';
    } else {
        $query = "SELECT * FROM customers WHERE username = " . $db->quote($_SESSION['user']);
        $result = $db->query($query);
        $row = $result->fetch();

        if ($row) {
            $hash = $row['pass'];

            if (!password_verify($old_pass, $hash)) {
                $errMsg = 'Wrong old password.';
            } else {
                $sql = "UPDATE customers SET pass = ? WHERE username = ?";
                $stmt = $db->prepare($sql);
                $result = $stmt->execute([password_hash($new_pass, PASSWORD_BCRYPT), $_SESSION['user']]);
                if ($result) {
                    header('Location: ./profile.php?pass_changed');
                    exit;
                } else {
                    $errMsg = 'Something went wrong!';
                }
            }
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
        <h1 class="text-center my-3">Change Password</h1>
        <div class="card content-card">
            <div class="card-body">
                <?php
                if (isset($errMsg) && $errMsg != '')
                    echo "<div class='alert alert-danger'>$errMsg</div>";
                ?>
                <form class="needs-validation" action="" method="POST" novalidate>
                    <div class="mb-3">
                        <label for="old_pass" class="form-label">Old password</label>
                        <input type="password" class="form-control" name="old_pass" id="old_pass" required>
                        <div class="invalid-feedback">
                            Please enter your old password.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="new_pass" class="form-label">New password</label>
                        <input type="password" class="form-control" name="new_pass" id="new_pass" required>
                        <div class="invalid-feedback">
                            Please enter your new password.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="new_pass" class="form-label">Confirm new password</label>
                        <input type="password" class="form-control" name="new_pass_conf" id="new_pass" required>
                        <div class="invalid-feedback">
                            Please confirm your new password.
                        </div>
                    </div>
                    <a href="./profile.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
    <?php include $root . '/inc/footer.php'; ?>
</body>

</html>