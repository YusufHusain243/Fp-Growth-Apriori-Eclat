<h1>Vertikal Data Format</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>TID</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['vertikalDataFormat'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item['produk'] ?></td>
                <td>
                    <?php
                    foreach ($item['TID'] as $key => $value) {
                        echo $value . ", ";
                    }
                    ?>
                </td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>