<h1 class="text-black">Produk</h1>
<table class="table table-bordered">
    <thead class="text-black">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
        </tr>
    </thead>
    <tbody class="text-black">
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