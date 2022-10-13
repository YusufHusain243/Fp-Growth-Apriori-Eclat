<form action="" method="post">
    <label for="">Min Support</label>
    <input type="text" name="min_support">
    <button type="submit" name="submit">Submit</button>
</form>

<?php
require "controller\AprioriController.php";

$aprioriController = new AprioriController();

if (isset($_POST['submit'])) {
    $data = $aprioriController->index();
    // include "components/table_produk.php";
    include "components/table_transaksi.php";
    include "components/table_iterasi_1.php";
    include "components/table_iterasi_2.php";
    include "components/table_iterasi_3.php";
    include "components/table_rule_2.php";
    include "components/table_rule_3.php";
}
?>