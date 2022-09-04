<?php namespace Rextopia\Game\Window;

class WindowOutput{
    public $messages;
    private array $sessionMessages;

    public function __construct(){
        $this->messages = array();
        $this->sessionMessages = $_SESSION['messages'];
//        $this->flushSessionMessages();
    }

    public function addSessionMessage($message){
        array_push($_SESSION['messages'], $message);
    }

    public function getSessionMessages(): array
    {
        return $_SESSION['messages'];
    }

    public function flushSessionMessages(){
        $_SESSION['messages'] = array();
    }

    public function printSessionMessages(){
        foreach ($_SESSION['messages'] as $key => $value) {
            print_r($value . "<br>");
        }
    }


    public function Bar($min, $max, $current, $color){
        include "Bar/bar.php";
    }
}