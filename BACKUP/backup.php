<hr>
<input class="btn btn-success" type="submit" name="btn_home" value="Go home"/>
<input class="btn btn-success" type="submit" name="btn_forest" value="Go to Forest"/>
<input class="btn btn-primary" type="submit" name="btN_refresh" value="Refresh"/>
<hr>

<?php
if (isset($_POST['btn_forest'])) {
    $path = "/Game/Windows/Area/forest_01.php";
    header("Location: " . $path);
}
if (isset($_POST['btn_home'])) {
    $path = "/Game/Windows/Area/home.php";
    header("Location: " . $path);
}