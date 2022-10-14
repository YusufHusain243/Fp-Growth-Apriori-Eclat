<h1>Sort By Priority</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Freq</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['sortByPriority'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item['produk'] ?></td>
                <td><?= $item['count_transaction'] ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>