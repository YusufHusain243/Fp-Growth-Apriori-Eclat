<?php
require "../controller/AprioriController.php";
$aprioriController = new AprioriController();
if (isset($_POST['submit'])) {
    $data = $aprioriController->index();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <label for="">Min Support</label>
            <input type="text" name="min_support">
            <button type="submit" name="submit">Submit</button>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            include "components/table_produk.php";
            include "components/table_transaksi.php";
            include "components/table_iterasi_1.php";
            include "components/table_iterasi_2.php";
            include "components/table_iterasi_3.php";
            include "components/table_rule_2.php";
            include "components/table_rule_3.php";
        }
        ?>
    </div>
</body>

</html>