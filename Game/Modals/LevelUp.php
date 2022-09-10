<?php include $_SERVER['DOCUMENT_ROOT'] . "/HTML/header.php"; ?>

<div id="myModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Level Up</h5>
            </div>


            <div class="modal-body">
                <div>
                    <?php
                    $character->levelUp();
                    $character->setCurrentExperience($character->getCurrentExperience() - $character->getToLevel());
                    $character->setToLevel($character->getToLevel() + ($character->getLevel() * $character->getToLevel()));
                    $character->saveCharacter($character);

                    echo "Congratulations! You are now Level " . $character->getLevel();
                    ?>
                </div>
            </div>


            <div class="modal-footer">
                <form action="../Area/window_home.php" method="post">
                    <button type="submit" class="btn btn-primary">Next</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#myModal").modal('show');
    });
</script>







