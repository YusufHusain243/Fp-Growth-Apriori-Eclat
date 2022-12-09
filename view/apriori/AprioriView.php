<h1 class="text-white">Apriori Algorithm</h1>
<form action="" method="post">
    <label for="" class="text-white">Min Support</label>
    <input type="text" name="min_support">
    <label for="" class="text-white">Min Confidence</label>
    <input type="text" name="min_confidence">
    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
</form>

<?php
require "controller\AprioriController.php";

$aprioriController = new AprioriController();

if (isset($_POST['submit'])) {
    $data = $aprioriController->index();
    include "components/table_products.php";
    include "components/table_transactions.php";
    include "components/table_itemsets.php";
    include "components/table_rules.php";
    echo "Lama Eksekusi = " . $data['lama'] . "detik";
}
?>