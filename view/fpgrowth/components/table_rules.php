<h1>Rules</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>Support</th>
            <th>Confidence</th>
            <th>Lift Ratio</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['rules'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item['antecedent'] . "=>" . $item['consequent'] ?></td>
                <td><?= $item['support'] ?></td>
                <td><?= $item['confidence'] ?></td>
                <td><?= $item['liftRatio'] ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>