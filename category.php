<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

if ($_GET['cat'] && $_GET['cat'] != '') {
    $catName = $_GET['cat'];
    $query = "SELECT * FROM foods WHERE cat = " . $db->quote($catName);
    $result = $db->query($query);
    $rows = $result->rowCount();

    if ($rows == 0) {
        http_response_code(404);
        header('Location: /');
        exit;
    }

    $catName = ucfirst($catName);
    $title = "$catName";
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
        <h1 class="text-center my-3 mb-md-5"><?= $catName ?></h1>
        <div class="foodlist">
            <?php
            while ($row = $result->fetch()) {
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