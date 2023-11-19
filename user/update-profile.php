<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

$title = 'Update Profile';

if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];

    $emailSql = "SELECT * FROM customers WHERE email = ? AND username != ?";
    $emailStmt = $db->prepare($emailSql);
    $emailStmt->execute([$email, $_SESSION['user']]);

    if (strlen($full_name) < 3) {
        $errMsg = 'Full name must be at least 3 characters!';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errMsg = 'Invalid email!';
    } else if ($emailStmt->fetch()) {
        $errMsg = 'Email already exists!';
    } else {
        $sql = "UPDATE customers SET full_name = ?, email = ?, mobile = ?, address = ? WHERE username = ?";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([$full_name, $email, $mobile, $address, $_SESSION['user']]);
        if ($result) {
            header('Location: ./profile.php?profile_updated');
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
        <h1 class="text-center my-3">Update Profile</h1>
        <div class="card content-card">
            <div class="card-body">
                <?php
                if (isset($errMsg) && $errMsg != '')
                    echo "<div class='alert alert-danger'>$errMsg</div>";
                ?>
                <?php
                $sql = "SELECT * FROM customers WHERE username = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$_SESSION['user']]);
                $user = $stmt->fetch();
                ?>
                <form class="needs-validation" action="" method="POST" novalidate>
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full name *</label>
                        <input type="text" class="form-control" name="full_name" id="full_name" value="<?= $user['full_name'] ?>" pattern="[a-zA-Z. ]{3,}" required>
                        <div class="invalid-feedback">
                            Please enter your full name.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= $user['email'] ?>" required>
                        <div class="invalid-feedback">
                            Please enter a valid email address.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" class="form-control" name="mobile" id="mobile" value="<?= $user['mobile'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" rows="3"><?= $user['address'] ?></textarea>
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