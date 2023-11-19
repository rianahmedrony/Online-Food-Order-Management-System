<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . '/db/dbconn.php';
