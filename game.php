<?php
namespace Game\game;
session_start();

use Rexpg\Window;
include "Rexpg/Window/Window.php";
$windowRenderer = new Window();



use Rextopia\Game\Enemy\Enemy;
use Rextopia\Game\Online\Online;
use Rextopia\Game\Shop\Shop;
use Rextopia\Game\Character\Character;
use Rextopia\Game\Window\WindowOutput;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('HTML/header.php');
require_once('Game/Character/Character.php');
require_once('Game/Shop.php');
require_once('Game/Windows/Window_output.php');
require_once('Game/Enemies/Enemy.php');
require_once('Game/Battle.php');
require_once('Game/Online.php');

if (!$_SESSION['character']) {
    header("Location: index.php");
}
$user = $_SESSION['character'];
$page = $_SERVER['PHP_SELF'];
$_SESSION['path'] = $_SERVER['DOCUMENT_ROOT'];
$time = strtotime('now');
$_SESSION['lastAction'] = $time;
$_SESSION['area'] = "town";




$character = new Character();
$window = new WindowOutput();

$online = new Online();

if ($character->existsCharacter($user)) {
    $window->addSessionMessage("Welcome Back " . $user);
    $character->loadCharacter($user);
}

$online->updateOnlineUsers($character, $time);

$shop = new Shop();
$window = new WindowOutput();
$message = "Welcome to RextopiA<br>";
$window->addSessionMessage($message);

if(isset($_POST['btn_mountain'])){
    $path = "/Game/Windows/Area/mountain_01.php";
    header("Location: " . $path);
}
if (isset($_POST['btn_home'])) {
    header("Location: Game/Windows/Area/window_home.php");
}
if (isset($_POST['changeCharacter'])) {
    header("Location: Game/Windows/window_load_character.php");
}
if (isset($_POST['btn_name'])) {
    $message = $character->getName();
    $window->addSessionMessage($message);
}
if (isset($_POST['btn_gold'])) {
    $message = "Gold: " . $character->getGold();
    $window->addSessionMessage($message);
}
if (isset($_POST['btn_health'])) {
    $message = "Health: " . $character->getHealth();
    $window->addSessionMessage($message);
}
if (isset($_POST['btn_get_gold'])) {
    $ammount = 50;
    $character->addGold($ammount);
    $message = "You got " . $ammount . " gold!";
    $window->addSessionMessage($message);
}
if (isset($_POST['btn_add_health'])) {
    $ammount = 20;
    $character->addHealth(20);
    $message = "You healed " . $ammount . " Health";
    $window->addSessionMessage($message);
}
if (isset($_POST['btn_remove_health'])) {
    $ammount = 20;
    $character->removeHealth(20);
    $message = "You lost " . $ammount . " Health";
    $window->addSessionMessage($message);
}
if (isset($_POST['btn_remove_gold'])) {
    $ammount = 15;
    $character->removeGold($ammount);
    $message = "You lost " . $ammount . " gold!";
    $window->addSessionMessage($message);
}
if (isset($_POST['btn_buy'])) {
    $buying = $_POST['btn_buy'];
    $result = $shop->buy($buying, $character);
    $character = $result[0];
    $message = $result[1];
    $window->addSessionMessage($message);
}
if (isset($_POST['btn_show_items'])) {
    foreach ($shop->showItems() as $key => $value) {
        $message = (string)$value . " : " . (string)$shop->getPrice($value) . "g";
        $window->addSessionMessage($message);
    }
}
if (isset($_POST['btn_use_item'])) {
    $using = $_POST['btn_use_item'];
    $result = $character->useItem($using, $character);
    $character = $result[0];
    $message = $result[1];
    $window->addSessionMessage($message);
}
if (isset($_POST['btn_stats'])) {
    $window->addSessionMessage("You are " . $character->getName());
    $window->addSessionMessage("You have " . (string)$character->getGold() . " gold");
    $window->addSessionMessage("You have " . (string)$character->getHealth() . " health left.");
}
if (isset($_POST['btn_show_inventory'])) {
    foreach ($character->getInventory() as $key => $value) {
        $message = $value;
        $window->addSessionMessage($message);
    }
}
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
}
if (isset($_POST['btn_forest'])) {
    $path = "/Game/Windows/Area/forest_01.php";
    header("Location: " . $path);
}
$enemyToSpawn = "";
$keys = array_keys($_POST);
foreach ($keys as $value){
    if(str_contains($value, 'btn_battle' )){
        if($value === "btn_battle"){$enemyToSpawn = "btn_battle_" . Enemy::getRandomEnemy();}
        else {$enemyToSpawn = $value;}
    }
}


function setEnemy(mixed $enemyToSpawn, mixed $character): Enemy
{
    $enemy = new Enemy($enemyToSpawn);
    $enemy->saveTmpEnemy($enemy);
    $_SESSION['enemyId'] = $enemy->getId();
    $_SESSION['turn'] = true;
    $_SESSION['gameover'] = 0;
    $_SESSION['player'] = $character->getName();
    return $enemy;
}

if($enemyToSpawn){
    if ($character->getHealth() > 0) {
        setEnemy(str_replace('btn_battle_', '', $enemyToSpawn), $character);
        header("Location: Game/Windows/Window_Battle.php");
    } else {
        $window->addSessionMessage("You dont have enough HP to battle...");
    }
}
$character->saveCharacter();

?>


<body>
<div class="container-fluid">
    <?php ob_start(); ?>
    <form method="post" class="container" action="">
        <h3>Welcome <strong><?php echo $character->getName() ?></strong>!</h3>

        <hr>
        <input class="btn btn-success" type="submit" name="btn_home" value="Go home"/>
        <input class="btn btn-success" type="submit" name="btn_forest" value="Go to Forest"/>
        <input class="btn btn-success" type="submit" name="btn_mountain" value="Go to Mountain"/>
        <input class="btn btn-warning" type="submit" name="btn_shop" value="Go to Market"/>
        <hr>

        <input class="btn btn-primary" type="submit" name="btn_refresh" value="Refresh"/>
        <hr>

    </form>
    <?php $part_01 = ob_get_clean();
    ob_start(); ?>

    <div class="container">
        <form action="" method="post" class="d-block">
            <input class="btn btn-danger" type="submit" name="logout" value="Log Out"/>
            <input class="btn btn-danger" type="submit" name="changeCharacter" value="Change Character"/>
        </form>
    </div>

    <?php $part_02 = ob_get_clean();
    ob_start(); ?>

    <div class="container">
        <div class="progress w-100 healthBar">
            <div class="progress-bar bg-success"
                 style="width: <?php echo($character->getHealth() / $character->getMaxHealth() * 100) ?>%;"
                 role="progressbar"
                 aria-valuenow="<?php echo $character->getHealth() ?>" aria-valuemin="0"
                 aria-valuemax="<?php echo $character->getMaxHealth() ?>"><?php echo $character->getHealth() ?>
                / <?php echo $character->getMaxHealth() ?></div>
        </div>
        <div class="progress w-100 experienceBar">
            <div class="progress-bar bg-warning"
                 style="width: <?php echo($character->getCurrentExperience() / $character->getToLevel() * 100) ?>%;"
                 role="progressbar"
                 aria-valuenow="<?php echo $character->getCurrentExperience() ?>" aria-valuemin="0"
                 aria-valuemax="<?php echo $character->getToLevel() ?>"><?php echo $character->getCurrentExperience() ?>
                / <?php echo $character->getToLevel() ?></div>
        </div>
        <div class="container character">
            <?php
            $hints = array(
                'HINT: Sleeping allows you to level up when requirements are met (The yellow bar)',
                'HINT: You cant see crafting recipes. Yet...',
                "HINT: The blacksmith can make an axe. That's it",
                "AXE: 2x rope | 1x stone | 1x branch"
            );

            $window->addSessionMessage("You are a Level " . $character->getLevel() . " " . $character->getClass() . " called " . $character->getName());
            $window->addSessionMessage("You have " . (string)$character->getGold() . " gold");
            $hint = $hints[rand(0, count($hints) - 1)];
            $window->addSessionMessage($hint);

            $window->printSessionMessages();
            $window->flushSessionMessages(); ?>

        </div>
        <div class="container">
            <?php
            $online_users = $online->getOnlineUsers();
            foreach ($online_users as $key => $value) {
                if ($value) {
                    echo $value . " is online. <br>";
                }
            }
            ?>
        </div>
    </div>

    <?php $part_03 = ob_get_clean(); ?>
</div>

</body>


<?php


$page = array($part_01 => 40, $part_02 => 10, $part_03 => 50);
$content = $windowRenderer->createContent($page);
$town = $windowRenderer->createWindow($content);
$windowRenderer->display($town);

?>


<style>
    body {
        margin: 0;
        background-color: black;
    }

    .experienceBar {
        color: yellow;
        border-radius: 0;
    }

    .container .character{
        background-color: #880D1E;
        justify-content: space-between;
        border-radius: 0;

    }

    .healthBar{
        border-radius: 0;

    }

    .btn{
        border-radius: 0;
    }
</style>