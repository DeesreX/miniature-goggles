<?php

namespace Rextopia\Manager\Character;

trait AttributeManager
{
    protected $currentHealth;
    protected $maxHealth;

    protected function initAttributes(){
        $this->maxHealth = $this->calculateMaxHp();
        $this->currentHealth = $this->maxHealth;
    }

    public function getMaxHealth(){
        return $this->maxHealth;
    }

    public function addHealth($health){
        $this->currentHealth += $health;
        $this->updateHealth();
    }

    public function getHealth()
    {
        $this->updateHealth();
        return $this->currentHealth;
    }

    protected function updateHealth(){
        if ($this->currentHealth > $this->maxHealth) {
            $this->currentHealth = $this->maxHealth;
        }
    }

    public function removeHealth($health)
    {
        $this->currentHealth -= $health;
    }
    public function calculateMaxHp(){
        return round(($this->constitution * 2.5) + ($this->strength * 1.1) + ($this->dexterity * 1.1)) * $this->getLevel();
    }

    public function setMaxHealth(){
        $this->maxHealth = $this->calculateMaxHp();
    }



}