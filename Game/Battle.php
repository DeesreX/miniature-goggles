<?php
namespace Rextopia\Game\Battle;

use Rextopia\Game\Window\WindowOutput;
class Battle{
    private $turn;
    private $result;
    public function __construct(&$character, &$enemy, &$window, $turn){
        $this->character = $character;
        $this->enemy = $enemy;
        $this->window = $window;
    }



    public function battle(){
        if($_SESSION['turn']){
            $this->window->addSessionMessage("IT'S YOUR TURN <br>");
            $dmg = $this->character->getAttack();
            $this->enemy->removeHealth($dmg);
            $this->window->addSessionMessage("<br>You dealt " . $dmg . " damage to " . $this->enemy->getName() . "<br>");
            $this->window->addSessionMessage("ENEMY HAS " . $this->enemy->getHealth() . " HP left" . "<br>");
        } else {
            $dmg = $this->enemy->getAttack();
            $this->window->addSessionMessage("ITS THE ENEMY TURN");
            $this->window->addSessionMessage("<br>You lost " . $dmg . " health.. ");
            $this->character->removeHealth($dmg);
        }

        $this->enemy->saveEnemy($this->enemy);
        $this->character->saveCharacter($this->character);
        $this->endTurn();

        if($this->enemy->getHealth() <= 0){
            $_SESSION['battle_win'] = true;
            $this->character->addGold($this->enemy->getGold());
            $drop = $this->enemy->dropItem();
            if($drop){
                $this->character->addItem($drop);
                $xp = round(0.5 * $this->enemy->getAttack());
                $this->character->addExperience($xp);
            }
            $_SESSION['drop'] = $drop;
            $_SESSION['xp'] = $xp;
            $this->character->saveCharacter($this->character);
            return true;
        } elseif ($this->character->getHealth() <= 0){
            $_SESSION['battle_win'] = false;
            return true;
        }
        return false;

    }

    public function endTurn(){
        if($_SESSION['turn'] === true){
            $_SESSION['turn'] = false;
        } else {
            $_SESSION['turn'] = true;
        }
    }

}
