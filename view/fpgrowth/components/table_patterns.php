<h1>Patterns</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>FrequentPattern</th>
            <th>Frequnet</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['patterns'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item['item'] ?></td>
                <td><?= $item['frequentPattern'] ?></td>
                <td><?= $item['frequent'] ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>