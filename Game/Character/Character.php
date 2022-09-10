<?php

namespace Rextopia\Game\Character;

include "LevelingManager.php";
include "StatsManager.php";
include "AttributeManager.php";
include "InventoryManager.php";
include "WeaponManager.php";

use Rextopia\Manager\Character\AttributeManager;
use Rextopia\Manager\Character\InventoryManager;
use Rextopia\Manager\Character\LevelingManager;
use Rextopia\Manager\Character\StatsManager;
use Rextopia\Game\Window\WindowOutput;
use stdClass;


class Character
{
    use StatsManager;
    use LevelingManager;
    use AttributeManager;
    use InventoryManager;
    use WeaponManager;

    private $name;
    private $gold;
    private $class;

    public $attack = 5;

    public function __construct($name = null, $class = null)
    {
        $this->name = $name;
        $this->class = $class;
        $this->window = new WindowOutput();
        if (!$this->loadCharacter($name)) {
            $this->init_stats($class);
            $this->initInventoryManager();
            $this->initAttributes();
            $this->initWeapons();
            $this->gold = 20;
        }
    }


    public function getClass(): mixed
    {
        return $this->class;
    }

    public function getAttack(): int
    {
        return $this->calculateAttack();
    }

    public function equipWeapon($weapon){
        if($this->hasWeapon($weapon)){
            $this->setWeapon($weapon);
            $this->saveCharacter();
            return true;
        } return false;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getGold()
    {
        return $this->gold;
    }

    public function setInventoryToArray()
    {
        $this->inventory = json_decode(json_encode($this->inventory), true);
    }

    public function addGold($gold)
    {
        $this->gold = $this->gold + $gold;
    }

    public function removeGold($gold)
    {
        $this->gold = $this->gold - $gold;
    }

    public function getProperty($property)
    {
        return $this->$property;
    }

    public function restore($attribute, $ammount)
    {
        switch ($attribute) {
            case "health":
                $this->addHealth($ammount);
        }
    }

    public function useItem($item)
    {

        $this->setInventoryToArray();
        if (array_key_exists($item, $this->inventory)) {
            WindowOutput::addSessionMessage("You used " . $item . "!" . "<br>");
            $this->removeItem($item);
            $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Items/effects.json";
            $itemEffects = json_decode(file_get_contents($path));
            $itemEffect = $itemEffects->food->$item;
            foreach ($itemEffect as $key => $value) {
                $this->restore($key, $value);
                WindowOutput::addSessionMessage("You're " . $key . " restored by " . $value . "<br>");
            }
            $this->saveCharacter();
            return true;
        }
        WindowOutput::addSessionMessage("You have no " . $item . "'s left...");
        return false;
    }



    public function saveCharacter($character = null)
    {
        $characterData = array();

        if (!$character) {
            $character = $this;
        }
        $this->save($character, $characterData);

        foreach ($character as $key => $value) {
            $characterData[$key] = $this->getProperty($key);
        }

        $username = $_SESSION['username'];
        $characterName = $character->getName();


        $pathSaveCharacter = $_SERVER['DOCUMENT_ROOT'] . "/Game/Saves/" . $character->getName() . ".json";
        $pathSaveUser = $_SERVER['DOCUMENT_ROOT'] . "/Game/Users/" . $_SESSION["username"] . ".json";


        if (file_exists($pathSaveUser)) {
            $user = json_decode(file_get_contents($pathSaveUser));
        } else {
            $user = new stdClass();
            $user->$username = new stdClass();
        }

        $user->$username->$characterName = $character->level;
        $jsonDataUser = json_encode($user);
        $jsonDataCharacter = json_encode($characterData);
        file_put_contents($pathSaveCharacter, $jsonDataCharacter);
        file_put_contents($pathSaveUser, $jsonDataUser);

    }

    /**
     * @param mixed $character
     * @param array $characterData
     * @return void
     */
    public function save(mixed $character, array $characterData): void
    {
        foreach ($character as $key => $value) {
            if ($key) {
                $characterData[$key] = $this->getProperty($key);
            }
        }
        $characterName = $character->getName();
        $pathSaveCharacter = $_SERVER['DOCUMENT_ROOT'] . "/Game/Saves/" . $characterName . ".json";
        $jsonDataCharacter = json_encode($characterData);
        file_put_contents($pathSaveCharacter, $jsonDataCharacter);
    }


    public function loadCharacter($name)
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Saves/" . $name . ".json";
        if (self::existsCharacter($name)) {
            $arrayData = \json_decode(\file_get_contents($path));
            foreach ($arrayData as $key => $value) {
                $this->$key = $value;
            }
            if(!in_array('class', (array)$arrayData)){
                $this->class = "Villager";
            }
            return true;
        }
        return false;
    }

    public static function existsCharacter($name)
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Saves/" . $name . ".json";
        if (file_exists($path)) {
            return true;
        }
        return false;
    }

}