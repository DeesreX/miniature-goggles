<?php namespace Rextopia\Game\Window;

class WindowOutput{
    public $messages;
    private array $sessionMessages;

    public function __construct(){
        $this->messages = array();
        $this->sessionMessages = $_SESSION['messages'];
    }

    public static function addSessionMessage($message){
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
            echo "<ul>" . $value . "</ul>" . "<br>";
        }
    }


    public function Bar($min, $max, $current, $color){
        include "Bar/bar.php";
    }
}