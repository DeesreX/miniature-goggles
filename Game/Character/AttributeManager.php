<?php

namespace Rextopia\Manager\Character;

trait AttributeManager
{
    protected $currentHealth;
    protected $maxHealth;

    protected function initAttributes(){
        $this->maxHealth = 100;
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
}