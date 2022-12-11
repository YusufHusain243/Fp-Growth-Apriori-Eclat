<h1 class="text-black">Rules</h1>
<table class="table table-bordered">
    <thead class="text-black">
        <tr>
            <th>No</th>
            <th>Antecedent</th>
            <th>Consequent</th>
            <th>Confidence</th>
            <th>Lift Ratio</th>
        </tr>
    </thead>
    <tbody class="text-black">
        <?php
        $i = 1;
        foreach ($data['rules_data'] as $key => $item) {
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