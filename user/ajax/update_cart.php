<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

if (!isset($_SESSION['user']) || !isset($_SESSION['cart'])) {
    echo json_encode(['status' => 'error', 'message' => 'Something went wrong']);
    exit;
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$food_id = $data['food_id'];
$action = $data['action'];

$sql = "SELECT * FROM foods WHERE id = $food_id";
$food = $db->query($sql)->fetch();

if ($action == 'dec') {
    if ($_SESSION['cart'][$food_id] == 1) {
        unset($_SESSION['cart'][$food_id]);
    } else {
        if ($_SESSION['cart'][$food_id] > $food['in_stock'])
            $_SESSION['cart'][$food_id] = $food['in_stock'];
        else
            $_SESSION['cart'][$food_id]--;
    }
} else if ($action == 'inc') {
    if ($_SESSION['cart'][$food_id] >= $food['in_stock']) {
        $_SESSION['cart'][$food_id] = $food['in_stock'];
        echo json_encode(['status' => 'error', 'message' => 'There is not enough of this item in stock']);
        exit;
    } else {
        $_SESSION['cart'][$food_id]++;
    }
} else if ($action == 'remove') {
    unset($_SESSION['cart'][$food_id]);
}

echo json_encode(['status' => 'success']);
