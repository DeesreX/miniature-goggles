<?php
include "../../HTML/header.php";

session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../Character/Character.php";
include "../Enemy.php";
include "./Window_output.php";
include "../Battle.php";

$turn = $_SESSION['turn'];
$player = $_SESSION["player"];
$gameover = $_SESSION['gameover'];
$enemyId = $_SESSION['enemyId'];


$character = new \Rextopia\Game\Character\Character();
$character->loadCharacter($player);

$enemy = \Rextopia\Game\Enemy\Enemy::loadTmpEnemy($enemyId);
$window = new \Rextopia\Game\Window\WindowOutput();
$battle = new \Rextopia\Game\Battle\Battle($character, $enemy, $window, $turn);


?>

<div class="container">
    <div class="messages w-75">
        <?php $window->printSessionMessages(); ?>
        <?php $window->flushSessionMessages(); ?>
    </div>


    <?php echo $character->getName(); ?>
    <?php $window->Bar(0, $character->getMaxHealth(), $character->getHealth(), "success"); ?>


    <?php echo $enemy->getName(); ?>
    <?php $window->Bar(0, $enemy->getMaxHealth(), $enemy->getHealth(), "danger"); ?>


    <br>

    <form method="post" class="battle">
        <input class="btn btn-primary" type="submit" name="btn_add_update" value="Press Me"/>
    </form>

</div>

<?php
if (isset($_POST['btn_add_update'])) {
    $res = $battle->battle();
    if ($res) {
        include("../Modals/BattleResults.php");
    } else {
        header("Location: Window_Battle.php");
    }
}

?>
<style>
    .container {
        width: 100%;
        background-color: #BFD7EA;
        padding: 10px 30px;
        height: 100vh;
        /*display: flex;*/
    }

    .messages {
        background-color: #00A6FB;
        height: 50vh;
        /*padding: 20px;*/
        /*margin: 20px;*/

    }

    .battle_info {
        height: 30vh;
        width: 50%;
        background-color: #B5BD89;
        display: flex;
        justify-content: center;
    }

</style>