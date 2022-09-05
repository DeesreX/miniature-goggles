<?php

namespace Rextopia\Manager\Character;

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
        }
    }

    protected function calculate(){
        $maxHp = 0;
        $attack = 0;
        $defense = 0;
        $doubleAttackChance = 0;
        $dodgeChance = 0;
        $speed = 0;
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
        return rand($damage - $this->getLevel(), $damage + $this->getLevel());
    }

}











