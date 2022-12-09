<h1 class="text-white">Produk</h1>
<table class="table table-bordered">
    <thead class="text-white">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
        </tr>
    </thead>
    <tbody class="text-white">
        <?php
        $i = 1;
        foreach ($data['products_data'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>