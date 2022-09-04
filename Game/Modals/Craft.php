<?php

use Rextopia\Game\Battle\Battle;
use Rextopia\Game\Enemy\Enemy;

// use Rextopia\Game\Enemy\Enemy;
$enemy = new Enemy('rat', 10, 25, 0);
$battle = new Battle($character, $enemy, $window);
?>


<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#battle">
    BATTLE
</button>

<div class="modal fade" id="battle" tabindex="-1" aria-labelledby="battle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="battle" style="color: black;">battle</h5>
            </div>
            <div class="modal-body">
                <?php $turn = $battle->battle($turn) ?>
            </div>
        </div>
    </div>
</div>


<style>
    .modal {
        color: black;
    }
</style>