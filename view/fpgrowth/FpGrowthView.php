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
if (isset($_POST['submit'])) {
    $data = $fpGrowthController->index();
    include "components/table_transaksi.php";
    include "components/table_freq_item.php";
    include "components/table_orderItem.php";
    include "components/fpTree.php";
    include "components/table_patterns.php";
    include "components/table_rules.php";
    echo "Lama Eksekusi = " . $data['lama'] . "detik";
}
?>