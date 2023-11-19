<?php
require "dbconfig.php";

try {
	$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
	$db = new PDO($dsn, DB_USER, DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	die("DB Connection failed: " . $e->getMessage());
}
