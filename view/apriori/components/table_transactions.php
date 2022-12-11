<h1 class="text-black">Transaksi</h1>
<table class="table table-bordered">
    <thead class="text-black">
        <tr>
            <th>No</th>
            <th>Daftar Transaksi</th>
        </tr>
    </thead>
    <tbody class="text-black">
        <?php
        $i = 1;
        foreach ($data['transactions_data'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item['item'] ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>