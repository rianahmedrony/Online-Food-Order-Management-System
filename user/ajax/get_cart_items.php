<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['cart'])) {
    echo json_encode(['status' => 'error', 'message' => 'Something went wrong']);
    exit;
}

$cart_items = $_SESSION['cart'];
echo json_encode($cart_items);
