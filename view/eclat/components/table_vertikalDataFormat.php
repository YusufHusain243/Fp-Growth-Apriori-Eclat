<h1 class="text-black">Vertikal Data Format</h1>
<table class="table table-bordered">
    <thead class="text-black">
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>TID</th>
        </tr>
    </thead>
    <tbody class="text-black">
        <?php
        $i = 1;
        foreach ($data['vertikalDataFormat'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item['produk'] ?></td>
                <td><?= $item['TID'] ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>