<h1>Fp Growth Algorithm</h1>
<form action="" method="post">
    <label for="">Min Support</label>
    <input type="text" name="min_support">
    <label for="">Min Confidence</label>
    <input type="text" name="min_confidence">
    <button type="submit" name="submit">Submit</button>
</form>

<?php
require "controller/FpGrowthController.php";

$fpGrowthController = new FpGrowthController();
$data = $fpGrowthController->index();
include "components/table_transaksi.php";
include "components/table_freq_item.php";
include "components/table_sortByPriority.php";
include "components/table_sortItemByPriority.php";
if (isset($_POST['submit'])) {
}
?>