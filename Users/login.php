<?php
include './user.php';
include '../Game/User.php';

session_start();
$user = new User('RextopiA', 'dedi1240.jnb2.host-h.net', 'rextopia_01','urcA8d5LL4zE38U8VJR8');

$username = $_POST['username'];
$password = $_POST['password'];



if ($user->exists($username, $password)) {
    $_SESSION['login'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['lastAction'] = strtotime('now');
    header("Location: ../main_menu.php");
} else {
    $user = new User('RextopiA', 'dedi1240.jnb2.host-h.net', 'rextopia_01','urcA8d5LL4zE38U8VJR8');
    $userClass = new \Rextopia\Game\User\User();
    $user->create($username, $password);
    $userClass->createUser($username);
    header("Location: ../main_menu.php");

}

