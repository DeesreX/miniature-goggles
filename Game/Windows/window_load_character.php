<?php
include "../User.php";
include "../../HTML/header.php";
session_start();

$user = $_SESSION['username'];
if (!\Rextopia\Game\User\User::hasCharacters($user)) {
    echo "You don't have any characters yet. Click here to create a new one: ";
}


$characters = \Rextopia\Game\User\User::loadCharacters($user);

?>

    <div class="container">
        <form action="" method="post">
            <?php foreach ($characters as $key => $value) { ?>
                <input type="submit" name="characterName" value="<?php echo $value?>">
            <?php } ?>

        </form>
    </div>

<?php

if (isset($_POST['characterName'])) {
    $_SESSION['character'] = $_POST['characterName'];
    header("Location: Area/window_home.php");
} ?>

<style>
    body{
        background-color: #090C08;
    }
    
    .container input{
        padding: 20px;
        margin-top: 10px;
        border: 5px solid black;
        border-radius: 5px;
    }

    .container{
        margin-top: 5%;
        margin-bottom: 5%;
        background-color: #EEE5E9;
        height: 70vh;
        display: grid;
    }
</style>