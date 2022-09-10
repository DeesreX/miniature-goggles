<?php
switch ($modal) {
    case "inventory":
        include("Inventory/InventoryModal.php");
        break;
    case "canCraft":
        include('Inventory/CraftModal.php');
        break;
    case "canBlacksmith":
        include('Inventory/BlacksmithModal.php');
        break;
} ?>


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

    .modal-body {
        padding: 5px;
    }



</style>