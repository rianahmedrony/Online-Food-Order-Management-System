<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

$title = 'My Profile';

if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}

$referrer_page = basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
if (isset($_GET['pass_changed']) && $referrer_page == 'change-pass.php') {
    $msg = 'Password changed successfully!';
} else if (isset($_GET['profile_updated']) && $referrer_page == 'update-profile.php') {
    $msg = 'Profile info updated successfully!';
}

require $root . '/inc/header.php'; ?>
</head>

<body>
    <?php include $root . '/inc/navbar.php'; ?>
    <div class="container-md my-4">
        <h1 class="text-center my-3">My Profile</h1>
        <div class="card content-card">
            <div class="card-body">
                <?php if (isset($msg)) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= $msg ?>
                    </div>
                <?php endif; ?>
                <?php
                $sql = "SELECT * FROM customers WHERE username = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$_SESSION['user']]);
                $user = $stmt->fetch();
                ?>

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>Full name:</td>
                            <td><?php echo $user['full_name']; ?></td>
                        </tr>
                        <tr>
                            <td>Username:</td>
                            <td><?php echo $user['username']; ?></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><?php echo $user['email']; ?></td>
                        </tr>
                        <tr>
                            <td>Mobile:</td>
                            <td><?php echo $user['mobile']; ?></td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td><?php echo $user['address']; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="d-flex gap-1 flex-wrap">
                    <a href="./update-profile.php" class="btn btn-primary">Update Profile Info</a>
                    <a href="./change-pass.php" class="btn btn-primary">Change Password</a>
                    <a href="./logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <?php include $root . '/inc/footer.php'; ?>
</body>

</html>