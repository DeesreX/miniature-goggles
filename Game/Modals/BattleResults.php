<?php include "../../HTML/header.php"; ?>

<div id="myModal" class="modal fade" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Battle results</h5>
            </div>

            <div class="modal-body">
                <?php
                $result = $_SESSION['battle_win'];
                if($result) {
                    $enemyName = $enemy->getName();
                    $drop = $_SESSION['drop'];
                    $xp = $_SESSION['xp'];
                    echo "You beat a " . $enemyName . "<br>";
                    echo "The " . $enemyName . " dropped " . $drop . "<br>";
                    echo "You got " . $xp . "XP.";
                    $character->addItem($drop);
                    $window->flushSessionMessages();
                    $_SESSION['enemyId'] = null;
                    $_SESSION['drop'] = null;
                    $_SESSION['xp'] = null;
                    unlink($enemy->getId());
                } else {
                    echo "Battle Lost...";
                }
                ?>
            </div>

            <div class="modal-footer">
                <?php $area = $_SESSION['area'];
                $path = "/Game/Windows/Area/" . $area . ".php"; ?>


                <form action="<?php echo $path;?>" method="post">
                <button type="submit" class="btn btn-primary">Next</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
</script>

<style>
  .shop{
    color: black;
  }
</style>







