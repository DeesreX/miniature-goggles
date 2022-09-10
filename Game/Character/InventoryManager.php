<?php

namespace Rextopia\Manager\Character;

trait InventoryManager
{
    protected $inventory = array();

    protected function initInventoryManager(){
        $this->inventory = array("slime" => 5);
    }

    public function getInventory()
    {
        return (array)$this->inventory;
    }

    public function addItem($item)
    {
        $inventory = $this->getInventory();
        if(!array_key_exists($item, $inventory)){
            $inventory[$item] = 1;
        } else {
            $inventory[$item] += 1;
        }
        $this->setInventory($inventory);
    }

    public function setInventory(array $inventory): void
    {
        $this->inventory = $inventory;
    }

    public function flushInventory(){
        $this->inventory = array();
        $this->saveCharacter();
    }

    public function removeItem($item, $ammount = 1)
    {
        $inventory = $this->getInventory();
        $inventory[$item] -= $ammount;
        $this->setInventory($inventory);
        $this->saveCharacter();
    }
}