<h1>Itemsets</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>Freq</th>
            <th>Support</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['dataItemsets'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item['product'] ?></td>
                <td><?= $item['freq'] ?></td>
                <td><?= $item['support'] ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>