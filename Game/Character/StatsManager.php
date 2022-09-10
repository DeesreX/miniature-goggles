<?php

namespace Rextopia\Manager\Character;

use Rextopia\Game\Window\WindowOutput;

Trait StatsManager
{
    protected int $strength;
    protected int $dexterity;
    protected int $constitution;
    protected int $intelligence;
    protected int $charisma;
    protected int $luck;


    protected function init_stats($class)
    {
        switch ($class){
            case "warrior":
                $this->strength = 3;
                $this->dexterity = 2;
                $this->constitution = 4;
                $this->intelligence = 1;
                $this->charisma = 0;
                $this->luck = 0;
                break;
            case "rogue":
                $this->strength = 1;
                $this->dexterity = 3;
                $this->constitution = 2;
                $this->intelligence = 2;
                $this->charisma = 1;
                $this->luck = 1;
                break;
            case "wizard":
                $this->strength = 1;
                $this->dexterity = 1;
                $this->constitution = 3;
                $this->intelligence = 4;
                $this->charisma = 0;
                $this->luck = 2;
                break;
            default:
                $this->strength = 2;
                $this->dexterity = 2;
                $this->constitution = 2;
                $this->intelligence = 2;
                $this->charisma = 2;
                $this->luck = 2;

        }
    }

    protected function allocateStatPoints(){
        $this->strength += 1;
        $this->dexterity += 1;
        $this->constitution += 1;
        $this->intelligence += 1;
        $this->charisma += 1;
        $this->luck += 1;

        $this->setMaxHealth();
    }

    public function calculateAttack(){
        $damage = round($this->strength * 3.5);
        $weapon = $this->getWeapon();
        $weaponDmg = $this->getWeaponDamage($weapon);
        $total_dmg = rand($damage + $weaponDmg - $this->getLevel(), $damage + $weaponDmg + $this->getLevel());

        if(rand(0,100) <= 5){
            $total_dmg *= 1.5;
            WindowOutput::addSessionMessage('You just got a crit in!');
        }

        return round($total_dmg);
    }

}











