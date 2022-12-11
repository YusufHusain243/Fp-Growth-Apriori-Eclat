<h1 class="text-black">Itemsets</h1>
<table class="table table-bordered">
    <thead class="text-black">
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>TID</th>
            <th>Freq</th>
            <th>Support</th>
        </tr>
    </thead>
    <tbody class="text-black">
        <?php
        $i = 1;
        foreach ($data['itemsets'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item['produk'] ?></td>
                <td><?= $item['TID'] ?></td>
                <td><?= $item['freq'] ?></td>
                <td><?= $item['support'] ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>