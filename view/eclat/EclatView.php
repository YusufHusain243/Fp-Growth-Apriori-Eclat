<h1 class="text-black">Eclat Algorithm</h1>
<form action="" method="post">
    <label for="" class="text-black">Min Support</label>
    <input type="text" name="min_support">
    <label for="" class="text-black">Min Confidence</label>
    <input type="text" name="min_confidence">
    <button type="submit" name="submit">Submit</button>
</form>

<?php
require "controller\EclatController.php";

$eclatController = new EclatController();

if (isset($_POST['submit'])) {
    $data = $eclatController->index();
    include "components/table_transaction.php";
    include "components/table_vertikalDataFormat.php";
    include "components/table_itemsets.php";
    include "components/table_rules.php";
    echo "Lama Eksekusi = " . $data['lama'] . "detik";
}
?>