<?php

namespace Rextopia\Manager\Character;

trait LevelingManager
{
    private int $level = 1;
    private int $currentExperience = 5;
    private int $toLevel = 50;

    public function getToLevel(): int
    {
        return $this->toLevel;
    }

    public function getCurrentExperience(): int
    {
        return $this->currentExperience;
    }

    public function getLevel(){
        return $this->level;
    }

    public function addExperience($experience){
        $this->currentExperience += $experience;
    }

    public function setCurrentExperience($experience){
        $this->currentExperience = $experience;
    }

    public function setToLevel(int $toLevel)
    {
        $this->toLevel = $toLevel;
    }

}