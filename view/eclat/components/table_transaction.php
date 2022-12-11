<h1 class="text-black">Transaksi</h1>
<table class="table table-bordered">
    <thead class="text-black">
        <tr>
            <th>No</th>
            <th>TID</th>
            <th>Produk</th>
        </tr>
    </thead>
    <tbody class="text-black">
        <?php
        $i = 1;
        foreach ($data['transaksi'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item['id'] ?></td>
                <td><?= $item['item'] ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>