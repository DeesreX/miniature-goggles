<?php

namespace Rextopia\Manager\Character;

trait LevelingManager
{
    private int $level = 1;
    private int $currentExperience = 5;
    private int $toLevel = 10;

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

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function levelUp(){
        $this->level += 1;
        $this->allocateStatPoints();
        $this->toLevel += $this->getLevel();
    }

}