<div class="progress w-100">
    <div class="progress-bar bg-<?php echo $color ?>"
         style="width: <?php echo($current / $max * 100) ?>%;"
         role="progressbar"
         aria-valuenow="<?php echo $current ?>" aria-valuemin="0"
         aria-valuemax="<?php echo $max ?>"><?php echo $current ?>
        / <?php echo $max ?></div>
</div>