<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'user.php';

$username = $_POST['username'];
$password = $_POST['password'];

$password_repeat = $_POST['password_repeat'];

header("Location: ../game.php");
