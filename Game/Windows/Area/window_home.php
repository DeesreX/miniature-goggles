<?php
include "../../Craft.php";
include "../../../HTML/header.php";
include "../../Character/Character.php";
include "../Window_output.php";
include "../../GameManager.php";
session_start();
if (!$_SESSION['character']) {
    header("Location: index.php");
}
$characterName = $_SESSION['character'];
$character = new \Rextopia\Game\Character\Character($characterName);
$window = new \Rextopia\Game\Window\WindowOutput();
$craft = new \Rextopia\Game\Craft\Craft();
$gameManager = new \Rextopia\Manager\Game\GameManager();
$actions = $gameManager->getActions("home");


use Rexpg\Window;
include "../../../Rexpg/Window/Window.php";
$windowRenderer = new Window();?>





<?php ob_start(); ?>

<div class="container-fluid Background_room"></div>
<div class="container-fluid actions">
    <form method="post">
        <?php foreach ($actions as $key => $action) { ?>
            <input class="btn btn-success" type="submit" value="<?php echo $action ?>" name="<?php echo $action ?>">
        <?php } ?>
    </form>
</div>

<?php $part_actions = ob_get_clean();?>

<?php ob_start(); ?>

<div class="container-fluid messages">
    <?php $window->printSessionMessages(); ?>
    <?php $window->flushSessionMessages(); ?>
</div>

<?php $part_messages = ob_get_clean();?>

<?php ob_start(); ?>

<div class="container-fluid footer">
    <h4>HP</h4>
    <?php $window->Bar(0, $character->getMaxHealth(), $character->getHealth(), "success"); ?>
    <h4>EXP</h4>
    <?php $window->Bar(0, $character->getToLevel(), $character->getCurrentExperience(), "warning"); ?>
</div>

<a class="btn btn-dark" href="https://www.paypal.com/donate/?hosted_button_id=E3WHXUTDXKDV6" target="_blank">Buy me a
    Coffee</a>

<?php $part_character_information = ob_get_clean();?>


<?php
$action = $_POST;



switch (array_key_first($action)) {
    case "equip_stone_axe":
        if($character->equipWeapon('stone_axe')){
            $window->addSessionMessage("Stone Axe Equipped.");
        }else{
            $window->addSessionMessage("You don't have a Stone Axe");
        }
        header("Location: window_home.php");
        break;
    case "cook":
        $window->addSessionMessage("You can't cook yet...");
        header("Location: window_home.php");
        break;
    case "sleep":
        $healthToAdd = $character->getMaxHealth() - $character->getHealth();
        $character->addHealth($healthToAdd);
        $character->saveCharacter($character);
        $window->addSessionMessage("You slept and restored " . $healthToAdd . "HP.");
        if ($character->getCurrentExperience() >= $character->getToLevel()) {
            include('../../Modals/LevelUp.php');
        } else {
            header("Location: window_home.php");
        }
        break;
    case "craft":
        $canCraft = $craft->canCraft($character->getInventory());
        $modal = "canCraft";
        include "../../Modals/Inventory.php";
        break;
    case "village":
        header('Location: ../../../game.php');
        break;
    case "inventory":
        $modal = "inventory";
        include "../../Modals/Inventory.php";
        break;
    case "blacksmith":
        $canBlacksmith = $craft->canSmith($character->getInventory(), 'tools');
        $modal = "canBlacksmith";
        include "../../Modals/Inventory.php";
        break;


}

if (isset($_POST['btn_craft'])) {
    $craft->craft($craft->getRecipe($_POST['btn_craft'], 'craftables'), $character, $_POST['btn_craft']);
}
if (isset($_POST['btn_blacksmith'])) {
    $craft->craft($craft->getRecipe($_POST['btn_blacksmith'], 'tools'), $character, $_POST['btn_blacksmith']);
}

?>



<?php

$page = array($part_actions => 40, $part_messages => 40, $part_character_information => 20 );
$content = $windowRenderer->createContent($page);
$town = $windowRenderer->createWindow($content);


$windowRenderer->display($town);

?>

<style>
    body {
        background-color: black;
    }

    .Background_room {
        height: 30vh;
        background: black url("../../Graphics/Backgrounds/background_room.jpeg") no-repeat bottom;
    }

    .Background_room {
        background-size: cover;
    }

    .actions {
        background-color: #000000;
        text-align: center;
        padding: 10px;
        height: 20vh;
    }

    .actions .btn {
        margin: 5px;
    }

    .btn {
        border-radius: 0;
    }

    .messages {
        background-color: #000000;
        text-align: center;
        padding: 20px;
        height: 30vh;
        color: white;
    }

    .footer {
        background-color: #000000;
        text-align: center;
        padding: 10px;
        height: 20vh;
        color: white;
    }
</style>

