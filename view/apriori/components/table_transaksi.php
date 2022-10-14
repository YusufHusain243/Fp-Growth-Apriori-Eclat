<h1>Transaksi</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Daftar Transaksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['transaksi'] as $key => $item) {
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