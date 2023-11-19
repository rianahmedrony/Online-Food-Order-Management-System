<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'nedd_logged_in', 'message' => 'You must be logged in to add to cart']);
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$food_id = $data['food_id'];

// Check if food exists
$food = $db->query("SELECT * FROM foods WHERE id = $food_id")->fetch();

if (!$food) {
    $res = [
        'status' => 'error',
        'message' => 'This item does not exist'
    ];
    echo json_encode($res);
    exit;
}

// Check if food is in stock
if ($food['in_stock'] == 0) {
    $res = [
        'status' => 'error',
        'message' => 'This item is out of stock'
    ];
    echo json_encode($res);
    exit;
}

// Check if enough food in stock
if (isset($_SESSION['cart'][$food_id]) && $_SESSION['cart'][$food_id] >= $food['in_stock']) {
    $res = [
        'status' => 'error',
        'message' => 'There is not enough of this item in stock'
    ];
    echo json_encode($res);
    exit;
}

// Add to cart
if (isset($_SESSION['cart'][$food_id])) {
    $_SESSION['cart'][$food_id]++;
} else {
    $_SESSION['cart'][$food_id] = 1;
}

$res = [
    'status' => 'success',
    'message' => 'Item added to cart',
    'cart_count' => count($_SESSION['cart'])
];

echo json_encode($res);
