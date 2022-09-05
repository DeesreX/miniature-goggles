<div class="modal fade" id="inventory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="btn" id="inventory" style="color: black;">Inventory</h5>
                <h5 class="btn" id="filter" style="color: black;">Mob Drops</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="inventory">
                    <?php foreach ($character->getInventory() as $key => $value) { ?>
                        <input class="btn btn-success" type="submit" name="btn_use_item" value="<?php echo $value ?>"
                               data="<?php echo $value ?>"/>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="inventoryMob" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="btn" id="inventory" style="color: black;">Inventory</h5>
                <h5 class="btn" id="filter" style="color: black;">Mob Drops</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="inventory">
                    <?php foreach ($character->filterMobDrops() as $key => $value) { ?>
                        <input class="btn btn-success" type="submit" name="btn_use_item" value="<?php echo $value ?>"
                               data="<?php echo $value ?>"/>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="consumables" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="btn" id="inventory" style="color: black;">Inventory</h5>
                <h5 class="btn" id="filter" style="color: black;">Mob Drops</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="inventory">
                    <form method="post">
                        <?php foreach ($character->filterMobDrops() as $key => $value) { ?>
                            <input class="btn btn-success" type="submit" name="btn_use_item"
                                   value="<?php echo $value ?>" data="<?php echo $value ?>"/>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_POST['btn_use_item'])) {
    $using = $_POST['btn_use_item'];
    $result = $character->useItem($using, $character);
    $character = $result[0];
    $message = $result[1];
    $window->addSessionMessage($message);
    header("Location: ./Window_Battle.php");
}

?>




<script type="text/javascript">
    $(document).ready(function () {
        $("#<?php echo $modal ?>").modal('show');
    });
</script>


<style>
    .inventory {
        color: black;
    }

    .inventory input {
        margin: 10px;
    }

</style>