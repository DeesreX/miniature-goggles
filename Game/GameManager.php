<?php

namespace Rextopia\Manager\Game;
class GameManager
{

    private array $actions;

    public function __construct(){
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Windows/Actions/actions.json";
        foreach (json_decode(file_get_contents($path)) as $area => $action){
            $this->actions[$area] = $action;
        }
    }

    public function getActions($area){
        return $this->actions[$area];
    }
}