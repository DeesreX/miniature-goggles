<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  SHOP
</button>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: black;">Shop</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="shop">
          <?php foreach ($shop->showItems() as $key => $value) { ?>
            <input class="btn btn-success" type="submit" name="btn_buy" value="<?php echo $value ?>" data="<?php echo $value ?>"/>  
           <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>


<style>
  .shop{
    color: black;
  }
</style>



