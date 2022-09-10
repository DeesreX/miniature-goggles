<?php

namespace Rextopia\Game\Character;

use Rextopia\Game\Window\WindowOutput;

trait WeaponManager
{
    private $weapon;


    public function initWeapons(){
        $this->weapon = "fist";
    }

    public function getWeapon()
    {
        if($this->weapon === null){
            $this->weapon = "fist";
        }
        return $this->weapon;
    }

    public function setWeapon($weapon): void
    {
        $this->weapon = $weapon;
    }

    public function hasWeapon($weapon){
        $inventory = $this->getInventory();

        if(in_array($weapon , array_keys($inventory))){
            if(!$inventory[$weapon] >= 1){

                return false;
            }
            return true;
        }
        return false;
    }

    public function getWeaponDamage($weapon){
        $path = $_SESSION['path'] . '/Game/Items/weapons.json';
        $file = json_decode(file_get_contents($path));
        return $file->$weapon->attack;
    }
}