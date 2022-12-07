<h1>Apriori Algorithm</h1>
<form action="" method="post">
    <label for="">Min Support</label>
    <input type="text" name="min_support">
    <label for="">Min Confidence</label>
    <input type="text" name="min_confidence">
    <button type="submit" name="submit">Submit</button>
</form>

<?php
require "controller\AprioriController.php";

$aprioriController = new AprioriController();

if (isset($_POST['submit'])) {
    $data = $aprioriController->index();
    include "components/table_produk.php";
    include "components/table_transaksi.php";
    include "components/table_itemsets.php";
    include "components/table_rules.php";
    echo "Lama Eksekusi = " . $data['lama'] . "detik";
}
?>