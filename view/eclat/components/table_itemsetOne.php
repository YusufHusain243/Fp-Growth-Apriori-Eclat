<h1>1 - Itemset</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Support</th>
            <th>TID</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['itemsetOne'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item['produk'] ?></td>
                <td><?= $item['support'] ?></td>
                <td>
                    <?php
                    foreach ($item['TID'] as $key => $value) {
                        echo $value . ", ";
                    }
                    ?>
                </td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>