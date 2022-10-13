<h1>Rule Association 2 Item</h1>
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
        foreach ($data['ruleTwoItem'] as $key => $item) {
            foreach ($item as $key => $value) {
        ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td>Jika Membeli {<?= $value['antecedent'] ?>}, Maka Membeli {<?= $value['consequent'] ?>}</td>
                    <td><?= $value['ab'] ?></td>
                    <td><?= $value['a'] ?></td>
                    <td><?= $value['confidence'] ?></td>
                    <td><?= $value['lift_ratio'] ?></td>
                </tr>
        <?php
            }
            $i++;
        }
        ?>
    </tbody>
</table>