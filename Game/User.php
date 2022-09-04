<?php

namespace Rextopia\Game\User;

use stdClass;

class User
{
    public function createUser($username){
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Users/" . $username . ".json";
        $data = array($username=>new stdClass());
        file_put_contents($path, json_encode($data));
    }

    public static function loadCharacters($username)
    {
        $characters = array();
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Game/Users/" . $username . ".json";
        if (!file_exists($path)) {
            echo "You have yet to create a character";
            return "NO CHARACTERS";
        } else {
            $user = json_decode(file_get_contents($path));
            foreach ($user->$username as $key => $value) {
                array_push($characters, $key);
            }
        }
        return $characters;
    }

    public static function hasCharacters($username)
    {
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/Game/Users/" . $username . ".json")){
            return true;
        }
        return false;

    }

}