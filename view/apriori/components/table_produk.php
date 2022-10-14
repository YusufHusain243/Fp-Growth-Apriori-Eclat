<h1>Produk</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['produk'] as $key => $item) {
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