<?php include "../../HTML/header.php"; ?>

<div id="myModal" class="modal fade" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <h5 class="modal-title">Battle results</h5>
            </div>


            <div class="modal-body">
                <?php
                $enemyName =  $enemy->getName();
                $drop = $_SESSION['drop'];
                echo "You beat a " . $enemyName . "<br>";
                echo "The " . $enemyName . " dropped " . $drop;
                $character->addItem($drop);
                $window->flushSessionMessages();
                ?>
            </div>


            <div class="modal-footer">
                <form action="../../game.php" method="post">
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







