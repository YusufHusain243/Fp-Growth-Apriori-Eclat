<h1>OrderedItemSet</h1>
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
        foreach ($data['orderItemSet'] as $item) {

        ?>
            <tr>
                <td><?= $i; ?></td>
                <td>
                    <?php
                    foreach ($item as $value) {
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