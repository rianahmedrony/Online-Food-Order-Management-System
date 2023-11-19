<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

if ($_GET['q'] && $_GET['q'] != '') {
    $q = $_GET['q'];
    $query = "SELECT * FROM foods WHERE name LIKE ?";
    $stmt = $db->prepare($query);
    $stmt->execute(["%$q%"]);
    $title = "Search result for \"$q\"";
} else {
    header('Location: /');
    exit;
}
?>
<?php require $root . '/inc/header.php'; ?>
</head>

<body>
    <?php include $root . '/inc/navbar.php'; ?>
    <div class="container-md my-4">
        <h1 class="text-center my-3 mb-md-5">Search result for "<?= $q ?>"</h1>
        <?php
        if ($stmt->rowCount() == 0) :
        ?>
            <div class="alert alert-warning" role="alert">
                No result found!
            </div>
        <?php
        endif;
        ?>
        <div class="foodlist">
            <?php
            while ($row = $stmt->fetch()) {
                $id = $row['id'];
                $title = $row['name'];
                $price = $row['price'];
                $img = $row['img'];

                include($root . '/inc/foodcard.php');
            }
            ?>
        </div>
    </div>
    <?php include $root . '/inc/footer.php'; ?>
</body>

</html>