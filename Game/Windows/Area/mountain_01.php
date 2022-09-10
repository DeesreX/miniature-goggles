<?php


use Rextopia\Game\Enemy\Enemy;

include "../../Craft.php";
include "../../../HTML/header.php";
include "../../Character/Character.php";
include "../Window_output.php";
include "../../GameManager.php";
include "../../Enemies/Enemy.php";
session_start();
if (!$_SESSION['character']) {
    header("Location: index.php");
}
$_SESSION['area'] = "mountain_01";
$characterName = $_SESSION['character'];
$character = new \Rextopia\Game\Character\Character($characterName);
$gameManager = new \Rextopia\Manager\Game\GameManager();
$actions = $gameManager->getActions("mountain_01");
$window = new \Rextopia\Game\Window\WindowOutput();
$craft = new \Rextopia\Game\Craft\Craft();
?>

<div class="container-fluid Background_room"></div>


<div class="container-fluid actions">
    <form method="post">
        <?php foreach ($actions as $key => $action) { ?>
            <input class="btn btn-success" type="submit" value="<?php echo $action ?>" name="<?php echo $action ?>">
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
<br><br>
<a class="btn btn-dark" href="https://www.paypal.com/donate/?hosted_button_id=E3WHXUTDXKDV6" target="_blank">Buy me a
    Coffee</a>

<?php
$action = $_POST;

if (isset($_POST['btn_craft'])) {
    $craft->craft($craft->getRecipe($_POST['btn_craft'], 'craftables'), $character, $_POST['btn_craft']);
}
if (isset($_POST['btn_blacksmith'])) {
    $craft->craft($craft->getRecipe($_POST['btn_blacksmith'], 'tools'), $character, $_POST['btn_blacksmith']);
}

switch (array_key_first($action)) {
    case "search":
        $file = json_decode(file_get_contents($_SESSION['path'] . "/Game/Windows/Actions/spawns.json"));
        $enemies = $file->mountain_01;

        $random = rand(0, 100);
        if($random <= 2){
            $enemyToSpawn = $enemies[3];
        } elseif ($random <= 10){
            $enemyToSpawn = $enemies[2];
        } elseif ($random <= 30){
            $enemyToSpawn = $enemies[1];
        } else {
            $enemyToSpawn = $enemies[0];
        }
        $enemy = new Enemy($enemyToSpawn);


        function setEnemy($enemy, $character)
        {
            $enemy->saveTmpEnemy($enemy);
            $_SESSION['enemyId'] = $enemy->getId();
            $_SESSION['turn'] = true;
            $_SESSION['gameover'] = 0;
            $_SESSION['player'] = $character->getName();
            return $enemy;
        }

        if ($character->getHealth() > 0) {
            setEnemy($enemy, $character);
            header("Location: /Game/Windows/Window_Battle.php");
        } else {
            $window->addSessionMessage("You dont have enough HP to battle...");
        }
        break;
    case "town":
        header("Location: /game.php");
}


?>

<style>
    body {
        background-color: black;
    }

    .Background_room {
        height: 30vh;
        background: black url("https://cdn.pixabay.com/photo/2016/05/24/16/48/mountains-1412683_960_720.png") no-repeat bottom;
    }

    .Background_room {
        background-size: contain;
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

