<?php

namespace Rextopia\Manager\Character;

trait InventoryManager
{
    protected $inventory;

    protected function initInventoryManager(){
        $this->inventory = array();
    }

    public function getInventory()
    {
        return $this->inventory;
    }

    public function addItem($item)
    {
        $this->setInventoryToArray();
        array_push($this->inventory, $item);
    }

    public function flushInventory(){
        $this->inventory = array();
        $this->saveCharacterSelf();
    }

    public function getMobDrops(){
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Items/mobDropItems.json";
        $file = json_decode(file_get_contents($path));

        return $file;
    }

    public function filterMobDrops(){
        $mobDrops = get_object_vars($this->getMobDrops());
        $tmpInventory = array();
        foreach ($this->inventory as $key => $value){
            if(in_array($value, $mobDrops["drops"])){
                array_push($tmpInventory, $value);
            }
        }
        return $tmpInventory;
    }
}