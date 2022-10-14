<h1>Iterasi 1</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>Total Transaksi</th>
            <th>Support</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['dataItemOne'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item['produk'] ?></td>
                <td><?= $item['count_transaction'] ?></td>
                <td><?= $item['support'] ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>