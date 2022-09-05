<?php

namespace Rextopia\Game\Character;

include "LevelingManager.php";
include "StatsManager.php";
include "AttributeManager.php";
include "InventoryManager.php";

use Rextopia\Manager\Character\AttributeManager;
use Rextopia\Manager\Character\InventoryManager;
use Rextopia\Manager\Character\LevelingManager;
use Rextopia\Manager\Character\StatsManager;
use stdClass;


class Character
{
    use StatsManager;
    use LevelingManager;
    use AttributeManager;
    use InventoryManager;

    private $name;
    private $gold;
    private $class;

    public $attack = 5;
    public function __construct($name = null, $class = null)
    {
//        $this->levelUp();
        $this->name = $name;
        if(!$this->loadCharacter($name)){
            $this->init_stats($class);
            $this->initInventoryManager();
            $this->initAttributes();

            $this->gold = 20;
        }
    }

    public function getAttack(): int
    {
        return $this->calculateAttack();
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

    public function useItem($item, $character)
    {

        $this->setInventoryToArray();
        if (\in_array($item, $this->inventory)) {
            $message = $message . "You used " . $item . "!" . "<br>";
            $this->removeItem($item);
            $itemEffects = (array)json_decode(\file_get_contents('Game/Items/effects.json'));
            $itemEffect = $itemEffects['food']->$item;
            foreach ($itemEffect as $key => $value) {
                $character->add($key, $value);
                $message = $message . "You're " . $key . " restored by " . $value . "<br>";
            }
            return [$character, $message];
        }
        return [$character, "You have no " . $item . "'s left..."];
    }

    public function removeItem($item)
    {
        $key = array_search($item, $this->inventory);
        if ($key !== false) {
            unset($this->inventory[$key]);
        }
    }

    public function saveNewCharacter($character)
    {
        $characterData = array();

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

    public function saveCharacter($character)
    {
        $characterData = array();
        foreach ($character as $key => $value) {
            if($key) {
                $characterData[$key] = $this->getProperty($key);
            }
        }
        $characterName = $character->getName();
        $pathSaveCharacter = $_SERVER['DOCUMENT_ROOT'] . "/Game/Saves/" . $characterName . ".json";
        $jsonDataCharacter = json_encode($characterData);
        file_put_contents($pathSaveCharacter, $jsonDataCharacter);
    }

    private function saveCharacterSelf(){
        $characterData = array();
        foreach ($this as $key => $value) {
            if($key) {
                $characterData[$key] = $this->getProperty($key);
            }
        }
        $characterName = $this->getName();
        $pathSaveCharacter = $_SERVER['DOCUMENT_ROOT'] . "/Game/Saves/" . $characterName . ".json";
        $jsonDataCharacter = json_encode($characterData);
        file_put_contents($pathSaveCharacter, $jsonDataCharacter);
    }

    public function loadCharacter($name)
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Saves/" . $name . ".json";
        if(self::existsCharacter($name)){
            $arrayData = \json_decode(\file_get_contents($path));
            foreach ($arrayData as $key => $value) {
                $this->$key = $value;
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