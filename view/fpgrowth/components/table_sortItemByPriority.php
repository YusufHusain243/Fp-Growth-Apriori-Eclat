<h1>Sort Item Transaction By Priority</h1>
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
        foreach ($data['sortItemByPriority'] as $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td>
                    <?php
                    for ($j = 0; $j < count($item); $j++) {
                        echo $item[$j]['item'] . ", ";
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