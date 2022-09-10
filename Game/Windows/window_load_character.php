<?php
include "../User.php";
include "../../HTML/header.php";
include "../Windows/Window_output.php";
include "../Character/Character.php";
session_start();

$user = $_SESSION['username'];
if (!\Rextopia\Game\User\User::hasCharacters($user)) {
    echo "You don't have any characters yet. Click here to create a new one: ";
}

use Rexpg\Window;

include "../../Rexpg/Window/Window.php";
$windowRenderer = new Window();
$window = new \Rextopia\Game\Window\WindowOutput();
$characters = \Rextopia\Game\User\User::loadCharacters($user);
?>

<?php ob_start(); ?>

<div class="container-fluid header">
    <h1>Choose a character</h1>
</div>

<?php $part_header = ob_get_clean(); ?>


<?php ob_start(); ?>
<div class="container-fluid">
    <form action="" method="post">
        <?php foreach ($characters as $key => $value) { ?>
            <div class="container-fluid char_info">

            <?php
            $character = new \Rextopia\Game\Character\Character();
            $character->loadCharacter($value);
            ?>

            <input type="submit" name="characterName" value="<?php echo $value ?>"><br>
            <p><?php echo ("You are a Level " . $character->getLevel() . " " . $character->getClass()); ?></p>
            </div>

        <?php } ?>

        <input type="submit" name="new_character" value="Create new Character?">

    </form>
</div>
<?php $part_character = ob_get_clean(); ?>

<?php

$page = array($part_header => 10, $part_character => 80);
$content = $windowRenderer->createContent($page);
$town = $windowRenderer->createWindow($content);
$windowRenderer->display($town);

if (isset($_POST['characterName'])) {
    $_SESSION['character'] = $_POST['characterName'];
    header("Location: Area/window_home.php");
}
if (isset($_POST['new_character'])) {
    header("Location: window_character_creation.php");
}

?>

<style>
    body {
        background-color: #090C08;
    }

    .container input {
        padding: 20px;
        margin-top: 10px;
        border: 5px solid black;
        border-radius: 5px;
    }

    .container {
        margin-top: 5%;
        margin-bottom: 5%;
        background-color: #EEE5E9;
        height: 70vh;
        display: grid;
    }

    .char_info {
        background-color: white;
        margin: 5px;
        text-align: center;
    }

    .char_info input{
        width: 100%;
        background-color: blue;
        color: white;
    }

    .char_info p{
        padding-top: 5px;
    }

    .header{
        display: flex;
        justify-content: center;
        color: white;
        padding-top: 20px;
    }
</style>