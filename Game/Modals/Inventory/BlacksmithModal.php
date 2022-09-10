<div class="modal" id="canBlacksmith" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <?php foreach ($canBlacksmith as $key => $value) { ?>
                        <button class="btn btn-success" type="submit" name="btn_blacksmith"
                                value="<?php echo $key ?>"><?php echo $key . ": ". $value ?></button>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

