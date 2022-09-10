<?php namespace Game\menu;
include('HTML/header.php');
session_start();
$_SESSION['messages'] = array();
?>

<div class="container fullWindow">
    <div class="row align-items-start h-25">
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
    </div>
    <div class="row align-items-center">
        <div class="col"></div>

        <div class="col main_menu">
            <h2 class="container w-100">Main Menu</h2>
            <form method="post" action="">
                <input class="btn btn-primary w-100" type="submit" value="New Game" name="newGame"/>
                <input class="btn btn-primary w-100" type="submit" value="Continue" name="continueGame"/>
                <input class="btn btn-success w-100" type="submit" value="Settings" name="settings"/>
            </form>
        </div>
        <div class="col"></div>
    </div>
    <div class="row align-items-end h-25">
        <div class="col"></div>
        <div class="col"></div>
        <?php if(isset($_SESSION['username'])){ ?>
        <div class="col user">Welcome Back <?php echo $_SESSION['username'];?></div>
        <?php } ?>
    </div>
</div>


<?php

if (isset($_POST['newGame'])) {
    header('Location: Game/Windows/window_character_creation.php');
}
if (isset($_POST['continueGame'])){
    header('Location: Game/Windows/window_load_character.php');
}
?>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500&display=swap');
    body{
        background-color: black;
    }

    .btn {
        background-color: #162521;
    }

    .btn:hover {
        background-color: #C0E0DE;
        color: #162521;
    }

    .btn:active {
        background-color: #162521;
    }

    .container {
        background-color: #3C474B;
    }

    .setRed {
        background-color: red;
    }

    .fullWindow {
        height: 100vh;
    }

    .col {
        min-height: 50px;
    }

    .main_menu {
        font-family: 'Oswald', sans-serif;
        padding: 50px;
        background-color: orange;
        text-align: center;
        border-radius: 10px;
    }

    .row {
        min-height: 33vh;
    }

    .user{
        text-align: right;
    }
</style>