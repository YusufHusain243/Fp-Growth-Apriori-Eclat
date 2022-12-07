<h1>Rules</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Antecedent</th>
            <th>Consequent</th>
            <th>Confidence</th>
            <th>Lift Ratio</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['dataRules'] as $key => $item) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $item['antecedent'] ?></td>
                <td><?= $item['consequent'] ?></td>
                <td><?= $item['confidence'] ?></td>
                <td><?= $item['lift_ratio'] ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>