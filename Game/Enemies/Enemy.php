<?php

namespace Rextopia\Game\Enemy;


class Enemy
{
    private $health;
    private $gold;
    private $name;
    private $inventory;
    private $id;
    private int $strength;

    public function __construct($name = null, $gold = null, $health = null, $mana = null, $inventory = array())
    {
        $this->health = $health;
        $this->gold = $gold;
        $this->name = $name;
        $this->mana = $mana;
        $this->inventory = $inventory;

        switch ($name) {
            case "bat":
                $this->strength = 3;
                break;
            case "spider":
            case "rat":
                $this->strength = 2;
                break;
            case "slime":
                $this->strength = 1;
                break;
            case "goblin":
                $this->strength = 8;
                break;
            case "skeleton":
            case "orc":
                $this->strength = 15;
                break;
            case "chicken":
                $this->strength = 4;
                break;
            case "wolf":
                $this->strength = 10;
                break;
            case "scarecrow":
                $this->strength = 12;
                break;
            case "bandit":
                $this->strength = 20;
                break;
            case "ent":
                $this->strength = 30;
                break;
            case "stone_golem":
                $this->strength = 17;
                break;
            case "troll":
                $this->strength = 65;
                break;
        }
    }

    public function setMaxHealth()
    {
        $this->maxHealth = $this->health;
    }

    public function getAttack()
    {
        $dmg = $this->strength;
        return rand($dmg - 1, $dmg + 1);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getGold()
    {
        return $this->gold;
    }

    public function getHealth()
    {
        if ($this->health > $this->maxHealth) {
            $this->health = $this->maxHealth;
        }
        return $this->health;
    }

    public function getInventory()
    {
        return $this->inventory;
    }

    public function setInventoryToArray()
    {
        $this->inventory = json_decode(json_encode($this->inventory), true);
    }

    public function addHealth($health)
    {
        $this->health = $this->health + $health;
    }

    public function addGold($gold)
    {
        $this->gold = $this->gold + $gold;
    }

    public function removeHealth($health)
    {
        $this->health = $this->health - $health;
    }

    public function removeGold($gold)
    {
        $this->gold = $this->gold - $gold;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setGold($gold)
    {
        $this->gold = $gold;
    }

    public function setHealth($health)
    {
        $this->health = $health;
    }

    public function setPorperty($property, $value)
    {
        $this->$property = $value;
    }

    public function getPorperty($property)
    {
        return $this->$property;
    }

    public function addItem($item)
    {
        $this->setInventoryToArray();
        array_push($this->inventory, $item);
    }

    public function add($property, $value)
    {
        $this->$property = $this->$property + $value;
    }

    public function useItem($item, $character)
    {
        $message = '';
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


    public function saveEnemy($enemy)
    {
        $path = $enemy->getId();
        $arrayData = array();
        foreach ($enemy as $key => $value) {
            $arrayData[$key] = $enemy->getPorperty($key);
        }

        $jsonData = \json_encode($arrayData);
        file_put_contents($path, $jsonData);
        return $path;
    }

    public function saveTmpEnemy($enemy)
    {
        $enemy->loadBase($this->getName());
        $uuid = uniqid($enemy->getName(), true);
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Enemies/tmp/" . $uuid . ".json";
        $this->id = $path;

        $arrayData = array();
        foreach ($this as $key => $value) {
            $arrayData[$key] = $this->getPorperty($key);
        }
        $jsonData = \json_encode($arrayData);
        file_put_contents($path, $jsonData);
    }

    public function getId()
    {
        return $this->id;
    }

    public function loadEnemy($name)
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Enemies/rat.json";
        $arrayData = \json_decode(\file_get_contents($path));
        foreach ($arrayData as $key => $value) {
            $this->setPorperty($key, $value);
        }
    }

    public static function loadTmpEnemy($id)
    {
        $path = $id;
        $arrayData = \json_decode(\file_get_contents($path));
        $enemy = new Enemy();
        foreach ($arrayData as $key => $value) {
            $enemy->setPorperty($key, $value);
        }

        return $enemy;
    }

    public function getMaxHealth()
    {
        return $this->maxHealth;
    }

    private function setInventory($inventory)
    {
        $this->inventory = $inventory;
    }

    private function loadBase($name)
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Enemies/Base/" . $name . ".json";
        $arrayData = \json_decode(\file_get_contents($path));
        $this->setHealth($arrayData->health);
        $this->setGold($arrayData->gold);
        $this->setInventory($arrayData->inventory);
        $this->setMaxHealth();
        return $this;
    }

    public function existsCharacter($name)
    {
        if (file_exists('Game/Saves/' . $name . '.json')) {
            return true;
        }
        return false;
    }

    public function createNewCharacter($name = null, $gold = null, $health = null, $mana = null)
    {
        $this->health = $health;
        $this->gold = $gold;
        $this->name = $name;
        $this->mana = $mana;
        $this->inventory = array();
    }

    public function getStats()
    {
        foreach ($this as $key => $value) {
            if (\gettype($value) != 'array') {
                echo $key . " : ";
                print_r($value);
            }
        }
    }

    public function dropItem()
    {
        $items = $this->getInventory();
        $this->setInventoryToArray();
        $len = count($items) - 1;
        return $items[rand(0, $len)];
    }

    public static function getEnemies()
    {
        $enemies = array();
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Enemies/";
        foreach (scandir($path) as $key => $value) {
            if (str_contains($value, ".json")) {
                array_push($enemies, str_replace($value, ".json", ""));
            }
        }
        return $enemies;
    }

    public static function getRandomEnemy()
    {
        $enemies = array();
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Enemies/Base/";
        foreach (scandir($path) as $key => $value) {
            if (str_contains($value, ".json")) {
                $name = str_replace(".json", "", $value);
                array_push($enemies, $name);
            }
        }

        $index = rand(0, count($enemies) - 1);
        return $enemies[$index];
    }
}