<h1>Rule Association 3 Item</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Rule</th>
            <th>A&B</th>
            <th>A</th>
            <th>Confidence</th>
            <th>Lift Ratio</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['ruleThreeItem'] as $key => $item) {
            // foreach ($item as $key => $value) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td>Jika Membeli {<?= $item['antecedent'] ?>}, Maka Membeli {<?= $item['consequent'] ?>}</td>
                <td><?= $item['ab'] ?></td>
                <td><?= $item['a'] ?></td>
                <td><?= $item['confidence'] ?></td>
                <td><?= $item['lift_ratio'] ?></td>
            </tr>
        <?php
            $i++;
            // }
        }
        ?>
    </tbody>
</table>