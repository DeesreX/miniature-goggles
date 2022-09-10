<?php
include "../../HTML/header.php";
include "../../Rexpg/Window/Window.php";

session_start();
if (!$_SESSION['character']) {
    header("Location: index.php");
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../Character/Character.php";
include "../Enemies/Enemy.php";
include "./Window_output.php";
include "../Battle.php";

$turn = $_SESSION['turn'];
$player = $_SESSION["player"];
$gameover = $_SESSION['gameover'];
$enemyId = $_SESSION['enemyId'];
$windowManager = new \Rexpg\Window();

$character = new \Rextopia\Game\Character\Character();
$character->loadCharacter($player);

$enemy = \Rextopia\Game\Enemy\Enemy::loadTmpEnemy($enemyId);
$window = new \Rextopia\Game\Window\WindowOutput();
$battle = new \Rextopia\Game\Battle\Battle($character, $enemy, $window, $turn);

if($turn){ ?>
    <div class="container-fluid window">
    <div class="background_forest"></div>

    <div class="messages">
        <?php $window->printSessionMessages(); ?>
        <?php $window->flushSessionMessages(); ?>
    </div>

    <div class="info_bars">
        <?php echo $character->getName(); ?>
        <?php $window->Bar(0, $character->getMaxHealth(), $character->getHealth(), "success"); ?>


        <?php echo $enemy->getName(); ?>
        <?php $window->Bar(0, $enemy->getMaxHealth(), $enemy->getHealth(), "danger"); ?>
    </div>


    <form method="post" class="battle">
        <input class="btn btn-primary" type="submit" name="btn_attack" value="Attack"/>
        <input class="btn btn-primary" type="submit" name="btn_inventory" value="Inventory"/>
    </form>

</div>
<?php } else { ?>
<div class="container-fluid window">
    <div class="background_forest"></div>

    <div class="messages">
        <?php $window->printSessionMessages(); ?>
        <?php $window->flushSessionMessages(); ?>
    </div>

    <div class="info_bars">
        <?php echo $character->getName(); ?>
        <?php $window->Bar(0, $character->getMaxHealth(), $character->getHealth(), "success"); ?>


        <?php echo $enemy->getName(); ?>
        <?php $window->Bar(0, $enemy->getMaxHealth(), $enemy->getHealth(), "danger"); ?>
    </div>


    <form method="post" class="battle">
        <input class="btn btn-primary" type="submit" name="btn_attack" value="Continue"/>
    </form>

</div>
<?php } ?>




<?php
if (isset($_POST['btn_inventory'])) {
    $modal = "inventory";
    include("../Modals/Inventory.php");
}
if (isset($_POST['btn_use_item'])) {
    $using = $_POST['btn_use_item'];
    $result = $character->useItem($using, $character);
    $character->saveCharacter();
    header("Location: ./Window_Battle.php");
}

if (isset($_POST['btn_attack'])) {
    $res = $battle->battle();
    if ($res) {
        include("../Modals/BattleResults.php");
    } else {
        header("Location: Window_Battle.php");
    }
}

?>
<style>

    .window {
        width: 100%;
        background-color: #000000;
        height: 100vh;
        /*display: flex;*/
    }

    .messages {
        background-color: #090909;
        height: 30vh;
        color: white;
        padding: 15px;
        font-size: 1em;
        /*margin: 20px;*/

    }

    .battle {
        background-color: #090909;
        display: flex;
        justify-content: space-around;
        padding: 10px;
    }

    .background_forest {
        height: 40vh;
    <?php
    $area = $_SESSION['area'];
    switch ($area){
            case "forest_01":
                $url = '../Graphics/Backgrounds/Background.png';
            break;
            case "mountain_01":
                $url = "https://cdn.pixabay.com/photo/2017/03/28/21/44/autumn-2183489_960_720.jpg";
            break;
    }
    ?> background: url(<?php echo $url?>) repeat-x bottom;
    }

    .info_bars {
        background-color: #090909;
        padding: 10px;
        color: white;
        height: 20vh;
    }

</style>