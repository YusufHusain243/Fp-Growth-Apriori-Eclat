<?php
// error_reporting(0);
$page = $_GET['page'];
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

<body class="bg-light">
    <div class="container">
        <nav class="navbar navbar-expand navbar-dark bg-primary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?= $page === 'apriori' ? 'active' : '' ?>" aria-current="page" href="index.php?page=apriori">Apriori</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $page === 'fp-growth' ? 'active' : '' ?>" aria-current="page" href="index.php?page=fp-growth">Fp Growth</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $page === 'eclat' ? 'active' : '' ?>" aria-current="page" href="index.php?page=eclat">Eclat</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <?php
        if ($page == 'apriori') {
            include 'view/apriori/AprioriView.php';
        }
        if ($page == 'fp-growth') {
            include 'view/fpgrowth/FpGrowthView.php';
        }
        if ($page == 'eclat') {
            include 'view/eclat/EclatView.php';
        }
        ?>
    </div>
</body>

</html>