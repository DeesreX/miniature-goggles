<?php
namespace Rextopia\Game\Shop;
class Shop {
    private $items;
    private $weapons;
    private $armor;

    public function __construct(){
        $this->items = array();
        $this->loadItems();
    }

    public function buy($item, $character){
        if(!in_array($item, $this->items)){
            return array($character, $item . " is not for sale...");
        }
        $price = $this->getPrice($item);
        if($character->getGold() >= $price){
            $character->removeGold($price);
            $character->addItem($item);
            return array($character, "You have purchased a " . (string)$item . " for " . (string)$price);
        }
        return array($character, "You don't have enough gold...");
    }

    public function loadItems(){
        $items = json_decode(file_get_contents('Game/Shop/prices.json'));
        $food = $items->food;
        foreach ($food as $key => $value) {
            array_push($this->items, $key);
        }
    }

    public function showItems(){

        return $this->items; 
    }

    public function getPrice($item){
        $prices = json_decode(file_get_contents("Game/Shop/prices.json"));
        return $prices->food->$item; 
    }
    
}