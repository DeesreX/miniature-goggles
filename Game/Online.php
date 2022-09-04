<?php

namespace Rextopia\Game\Online;

class Online
{
    public function getOnlineUsers(){
        $online = array();
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Online/";
        $dir    = $path;
        $files = scandir($dir, 1);
        foreach ($files as $key => $value){
            if(str_contains($value, '.json')){
                $tmpPath = $path . $value;
                $a = json_decode(file_get_contents($tmpPath));
                foreach ($a as $key => $value){
                    $offline = (int)strtotime("now");
                    $last = (int)$value;
                    $isOnline = $offline - $last;
                    if($isOnline < 320){
                        array_push($online, $key);
                    }
                }
            }
        }
        return $online;
    }

    public function updateOnlineUsers($character, $time){
        $arrayData = array($character->getName() => $time);
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Online/" . $character->getName() . ".json";
        $jsonData = \json_encode($arrayData);
        file_put_contents($path, $jsonData);
    }

    public function clean(){

    }


}