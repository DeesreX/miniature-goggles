<?php
include('../../HTML/header.php');
include('./Window_output.php');
include('../Character/Character.php');

session_start();
$window = new \Rextopia\Game\Window\WindowOutput();
$active = "primary";
?>

<div class="container-fluid new_character">
    <form class="login100-form validate-form" action="" method="post">
        <label for="character">Enter Character name</label><br><br>
        <label>
            <input name="character" type="text"/>
        </label><br><br>
        <button name="submit" class="btn btn_create" type="submit">Create</button>
    </form>
</div>
<div class="bgImage"></div>



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


    if($canCreate){
        $charName = $_POST['character'];
        $character = new \Rextopia\Game\Character\Character($charName);
        $character->saveCharacter($character);
        $_SESSION['character'] = $character->getName();
        header("Location: ../../game.php");
    }
}




?>

<style>
    .container {
        margin-top: 15vh;
        margin-bottom: 15vh;
        background-color: lightgrey;
        padding: 50px;
    }

    .new_character{
        height: 20vh;
        display: flex;
        justify-content: center;
        padding: 20px;
        background-color: black;
        color:white;
    }

    .btn_create{
        width: 100%;
        background-color: #6f8211;
        color: white;
    }
    
    .bgImage {
        background: url('../Graphics/Rex-topia.png') no-repeat center fixed;
        background-size: contain;
        height: 80vh;
        background-color: black;

    }

    .bgimage_{
        width: 100%;
    }
</style>

