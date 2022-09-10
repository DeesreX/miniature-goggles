<?php

namespace Rextopia\Game\Character\Skills;

trait SkillsManager
{
    private $crafting;

    public function initSkills(){
        $this->crafting = 0;
    }

    public function getCrafting()
    {
        return $this->crafting;
    }

    public function setCrafting($crafting): void
    {
        $this->crafting = $crafting;
    }

    public function addSkillPoint($skill){
        $this->$skill = $skill;
    }
}