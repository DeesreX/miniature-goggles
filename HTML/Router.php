<?php namespace Rextopia\Router;

class Router
{
    public static function redirect($url){
        header("Location: " . $url);
    }
}