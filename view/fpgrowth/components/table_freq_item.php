<h1>Freq Itemset</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Freq</th>
            <th>Support</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['freqItemSet'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $key ?></td>
                <td><?= $item['qty'] ?></td>
                <td><?= $item['support'] ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>