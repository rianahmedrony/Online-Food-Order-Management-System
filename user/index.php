<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: ./profile.php");
    die();
} else {
    header("Location: ./login.php");
    die();
}
