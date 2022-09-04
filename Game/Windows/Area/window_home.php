<?php
include "../../../HTML/header.php";
include "../../Character/Character.php";
include "../Window_output.php";
include "../../GameManager.php";
session_start();

$characterName = $_SESSION['character'];
$character = new \Rextopia\Game\Character\Character($characterName);
$gameManager = new \Rextopia\Manager\Game\GameManager();
$actions = $gameManager->getActions("home");
$window = new \Rextopia\Game\Window\WindowOutput();
?>

<div class="container-fluid header">
    <h1>Welcome Home <?php echo $characterName ?></h1>
</div>
<div class="container-fluid actions">
    <form method="post">
        <?php foreach ($actions as $key => $action) { ?>
            <input class="btn btn-success" type="submit" value="<?php echo $action?>" name="<?php echo $action?>">
        <?php } ?>
    </form>
</div>
<div class="container-fluid messages">
    <?php $window->printSessionMessages(); ?>
    <?php $window->flushSessionMessages(); ?>
</div>
<div class="container-fluid footer">
    <h4>HP</h4>
    <?php $window->Bar(0, $character->getMaxHealth(), $character->getHealth(), "success"); ?>
    <h4>EXP</h4>
    <?php $window->Bar(0, $character->getToLevel(), $character->getCurrentExperience(), "warning"); ?>
</div>

<?php
$action = $_POST;
switch (array_key_first($action)){
    case "cook":
        $window->addSessionMessage("You can't cook yet...");
        header("Location: window_home.php");
        break;
    case "sleep":

        $healthToAdd = $character->getMaxHealth() - $character->getHealth();
        $character->addHealth($healthToAdd);
        $character->saveCharacter($character);
        $window->addSessionMessage("You slept and restored " . $healthToAdd . "HP.");
        if($character->getCurrentExperience() > $character->getToLevel()){
            include ('../../Modals/LevelUp.php');
        } else {
            header("Location: window_home.php");
        }
        break;
    case "craft":
        $window->addSessionMessage("You can't craft yet...");
        header("Location: window_home.php");
        break;
    case "village":
        header('Location: ../../../game.php');
    case "inventory":
        $character->filterMobDrops();
        include "../../Modals/Inventory.php";
}

?>

<style>
    .header {
        background-color: red;
        text-align: center;
        padding: 10px;
        height: 10vh;
    }

    .actions {
        background-color: blue;
        text-align: center;
        padding: 10px;
        height: 20vh;
    }

    .messages {
        background-color: #090c04;
        text-align: center;
        padding: 20px;
        height: 30vh;
        color: white;
    }

    .footer {
        background-color: lightgrey;
        text-align: center;
        padding: 10px;
        height: 40vh;
    }
</style>

