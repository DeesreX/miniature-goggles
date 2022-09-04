<?php
namespace Game\game;
session_start();



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
require_once('Game/Enemy.php');
require_once('Game/Battle.php');
require_once('Game/Online.php');



if (!$_SESSION['character']) {
    header("Location: index.php");
}
$user = $_SESSION['character'];
$page = $_SERVER['PHP_SELF'];
$time = strtotime('now');
$_SESSION['lastAction'] = $time;


$character = new Character();
$window = new WindowOutput();
$battle = true;

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

if (isset($_POST['btn_home'])) {
    header("Location: Game/Windows/Area/window_home.php");
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
//$character->saveCharacter($character);
$character->saveNewCharacter($character);


if (isset($_POST['btn_battle'])) {
    $enemyName = Enemy::getRandomEnemy();
    $enemy = new Enemy($enemyName);
    $enemy->saveTmpEnemy($enemy);
    $_SESSION['enemyId'] = $enemy->getId();
    $_SESSION['turn'] = true;
    $_SESSION['gameover'] = 0;
    $_SESSION['player'] = $character->getName();
    header("Location: Game/Windows/Window_Battle.php");
} ?>

<body>
<div class="container-fluid">
    <form method="post" class="container" action="">
        <h3>Super User</h3>
        <input class="btn btn-danger" type="submit" name="btn_battle" value="Battle Random Enemy?"/>
        <input class="btn btn-success" type="submit" name="btn_home" value="Go home?"/>
        <hr>
<!--        --><?php //include("Game/Modals/Shop.php");?>
<!--        --><?php //include("Game/Modals/Inventory.php");?>
        <hr>
        <input class="btn btn-primary" type="submit" name="btn_refresh" value="Refresh"/>
        <hr>

    </form>
    <div class="container">
        <form action="index.php" method="post">
            <input class="btn btn-danger container" type="submit" name="logout" value="Log Out"/>
        </form>
    </div>




    <div class="container">
        <div class="progress w-100">
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
            $window->flushSessionMessages();
            $window->addSessionMessage("You are " . $character->getName());
            $window->addSessionMessage("You have " . (string)$character->getGold() . " gold");
            $window->printSessionMessages(); ?>
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
</body>

<style>
    .experienceBar{
        color: yellow;
    }
</style>