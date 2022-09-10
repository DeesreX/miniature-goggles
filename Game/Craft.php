<?php

namespace Rextopia\Game\Craft;


use Rextopia\Game\Window\WindowOutput;

include "./Windows/Window_output.php";

class Craft
{

    public function __construct()
    {
        $this->window = new WindowOutput();
    }

    private function getRecipes($type = "craftables")
    {
        $path = $_SESSION['path'] . "/Game/Items/craftItems.json";
        $recipes = json_decode(file_get_contents($path));
        switch ($type){
            case "craftables":
                return $recipes->craftables;
            case "tools":
                return $recipes->tools;

        }
    }


    public function getRecipe($recipe, $type)
    {
        foreach ($this->getRecipes($type) as $recipes => $value) {
            if ($recipes == $recipe) {
                return $value;
            }
        }
        return null;
    }

    public function canSmith($inventory, $type)
    {
        $inventory = (array)$inventory;
        $recipes = $this->getRecipes('tools');
        $canCraftRecipes = array();

        foreach ($recipes as $item => $recipe) {
            $canCraft = true;
            foreach ($recipe as $itemNeeded => $ammount) {
                if (in_array($itemNeeded, array_keys($inventory)) && $inventory[$itemNeeded] >= $ammount) {
                    continue;
                }
                $canCraft = false;
            }
            if ($canCraft) {
                $canCraftAmmount = round($inventory[$itemNeeded] / $ammount);
                $canCraftRecipes[$item] = $canCraftAmmount;
            }
        }
        return $canCraftRecipes;
    }

    public function canCraft($inventory)
    {
        $inventory = (array)$inventory;
        $recipes = $this->getRecipes();
        $canCraftRecipes = array();

        foreach ($recipes as $item => $recipe) {
            $canCraft = true;
            foreach ($recipe as $itemNeeded => $ammount) {
                if (in_array($itemNeeded, array_keys($inventory)) && $inventory[$itemNeeded] >= $ammount) {
                    continue;
                }
                $canCraft = false;
            }
            if ($canCraft) {
                $canCraftAmmount = round($inventory[$itemNeeded] / $ammount);
                $canCraftRecipes[$item] = $canCraftAmmount;
            }
        }
        return $canCraftRecipes;
    }

    public function craft($recipe, $character, $item)
    {
        foreach ($recipe as $key => $value) {
            $character->removeItem($key, $value);
        }
        $character->addItem($item);
        $character->saveCharacter();
    }
}