<h1>Eclat Algorithm</h1>
<form action="" method="post">
    <label for="">Min Support</label>
    <input type="text" name="min_support">
    <label for="">Min Confidence</label>
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
    include "components/table_itemsetOne.php";
    include "components/table_itemsetTwo.php";
    include "components/table_itemsetThree.php";
    include "components/table_rule_2.php";
    include "components/table_rule_3.php";
    echo "Lama Eksekusi = " . $data['lama'] . "detik";
}
?>