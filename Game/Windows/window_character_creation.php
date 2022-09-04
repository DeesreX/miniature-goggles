<?php
include('../../HTML/header.php');
include('./Window_output.php');
include('../Character/Character.php');

session_start();
$window = new \Rextopia\Game\Window\WindowOutput();
$active = "primary";
?>

<div class="container d-flex align-items-center justify-content-center">
    <form class="login100-form validate-form" action="" method="post">
        <label for="character">Enter Character name</label><br>
        <input name="character" type="text"/><br><br>
        <div class="row">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="class" id="inlineRadio1" value="Warrior">
                <label class="form-check-label" for="inlineRadio1">Warrior</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="class" id="inlineRadio2" value="Rogue">
                <label class="form-check-label" for="inlineRadio2">Rogue</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="class" id="inlineRadio2" value="Wizard">
                <label class="form-check-label" for="inlineRadio2">Wizard</label>
            </div>
        </div>
        <br>
        <button name="submit" class="btn btn-success" type="submit">Create</button>
    </form>

    <?php
    $canCreate = true;

    if(isset($_POST['submit'])){
        if (isset($_POST['character'])) {
            if ($_POST['character'] == $_SESSION['username']) {
                $window->addSessionMessage("Please use a different name than your username");
                $canCreate = false;
            } elseif (\Rextopia\Game\Character\Character::existsCharacter($_POST['character'])) {
                $canCreate = false;
                $window->addSessionMessage('Name all ready taken');
            }
        }

        if (isset($_POST['class'])) {
            $class = $_POST['class'];
        } else {
            $window->addSessionMessage("Please choose a class");
            $canCreate = false;
        }

        if($canCreate){
            $charName = $_POST['character'];
            $character = new \Rextopia\Game\Character\Character($charName,"warrior" );
            $character->saveNewCharacter($character);
            $character->saveCharacter($character);
            $_SESSION['character'] = $character->getName();
            header("Location: ../../game.php");
        }
    }




    ?>

</div>
<div class="container d-flex align-items-center justify-content-center">
    <?php
    $window->printSessionMessages();
    $window->flushSessionMessages();
    ?>
</div>

<style>
    .container {
        margin-top: 15vh;
        margin-bottom: 15vh;
        background-color: lightgrey;
        padding: 50px;
    }
</style>

