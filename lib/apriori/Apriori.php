<?php

class Apriori
{
    public function itemSetOne($dataProduk, $dataTransaction, $minSupport)
    {
        $dataItemOne = [];
        foreach ($dataProduk as $produk) {
            $count_transaction = 0;
            $support = 0;
            foreach ($dataTransaction as $transaksi) {
                if (strpos($transaksi['item'], $produk) !== false) {
                    $count_transaction += 1;
                }
            }
            $support = (($count_transaction / count($dataTransaction)));
            if ($support >= $minSupport) {
                $dataItemOne[] = [
                    "produk" => $produk,
                    "count_transaction" => $count_transaction,
                    "support" => $support,
                ];
            }
        }
        return $dataItemOne;
    }

    public function itemSetTwo($dataItemOne, $dataTransaction, $minSupport)
    {
        $dataItemTwo = [];
        for ($i = 0; $i < count($dataItemOne) - 1; $i++) {
            for ($j = $i + 1; $j < count($dataItemOne); $j++) {
                $produk = $dataItemOne[$i]['produk'] . ', ' . $dataItemOne[$j]['produk'];
                $count_transaction = 0;
                $support = 0;
                foreach ($dataTransaction as $transaksi) {
                    if (
                        strpos($transaksi['item'], $dataItemOne[$i]['produk']) !== false &&
                        strpos($transaksi['item'], $dataItemOne[$j]['produk']) !== false
                    ) {
                        $count_transaction += 1;
                    }
                }
                $support = (($count_transaction / count($dataTransaction)));
                if ($support >= $minSupport) {
                    $dataItemTwo[] = [
                        "produk" => $produk,
                        "count_transaction" => $count_transaction,
                        "support" => $support,
                    ];
                }
            }
        }
        return $dataItemTwo;
    }

    public function itemSetThree($dataItemOne, $dataTransaction, $minSupport)
    {
        $dataItemThree = [];
        for ($i = 0; $i < count($dataItemOne) - 1; $i++) {
            for ($j = $i + 1; $j < count($dataItemOne); $j++) {
                for ($k = $j + 1; $k < count($dataItemOne); $k++) {
                    $produk = $dataItemOne[$i]['produk'] . ', ' . $dataItemOne[$j]['produk'] . ', ' . $dataItemOne[$k]['produk'];
                    $count_transaction = 0;
                    $support = 0;
                    foreach ($dataTransaction as $transaksi) {
                        if (
                            strpos($transaksi['item'], $dataItemOne[$i]['produk']) !== false &&
                            strpos($transaksi['item'], $dataItemOne[$j]['produk']) !== false &&
                            strpos($transaksi['item'], $dataItemOne[$k]['produk']) !== false
                        ) {
                            $count_transaction += 1;
                        }
                    }
                    $support = (($count_transaction / count($dataTransaction)));
                    if ($support >= $minSupport) {
                        $dataItemThree[] = [
                            "produk" => $produk,
                            "count_transaction" => $count_transaction,
                            "support" => $support,
                        ];
                    }
                }
            }
        }
        return $dataItemThree;
    }

    public function ruleTwoItem($dataItemOne, $dataItemTwo, $total_transaction, $min_confidence)
    {
        $ruleTwoItem = [];
        foreach ($dataItemTwo as $value) {
            $temp = explode(', ', $value['produk']);

            $temp_count1 = 0;
            $temp_count2 = 0;

            $cons_freq1 = 0;
            $cons_freq2 = 0;

            //get antecedent freq
            for ($x = 0; $x < count($dataItemOne); $x++) {
                switch ($dataItemOne[$x]['produk']) {
                    case $temp[0]:
                        $temp_count1 = $dataItemOne[$x]['count_transaction'];
                        break;
                    case $temp[1]:
                        $temp_count2 = $dataItemOne[$x]['count_transaction'];
                        break;
                }
            }

            //get consequent freq
            for ($y = 0; $y < count($dataItemOne); $y++) {
                switch ($dataItemOne[$y]['produk']) {
                    case $temp[1]:
                        $cons_freq1 = $dataItemOne[$y]['count_transaction'];
                        break;
                    case $temp[0]:
                        $cons_freq2 = $dataItemOne[$y]['count_transaction'];
                        break;
                }
            }

            $confidence1 = $value['count_transaction'] / $temp_count1;
            if ($confidence1 <= $min_confidence) {
                $temp_data['antecedent'] = $temp[0];
                $temp_data['consequent'] = $temp[1];
                $temp_data['ab'] = $value['count_transaction'];
                $temp_data['a'] = $temp_count1;
                $temp_data['confidence'] = $confidence1;
                $temp_data['lift_ratio'] = ($value['count_transaction'] / $temp_count1) / ($cons_freq1 / $total_transaction);
            }



            $confidence2 = $value['count_transaction'] / $temp_count2;
            if ($confidence2 <= $min_confidence) {
                $temp_data2['antecedent'] = $temp[1];
                $temp_data2['consequent'] = $temp[0];
                $temp_data2['ab'] = $value['count_transaction'];
                $temp_data2['a'] = $temp_count2;
                $temp_data2['confidence'] = $confidence2;
                $temp_data2['lift_ratio'] = ($value['count_transaction'] / $temp_count2) / ($cons_freq2 / $total_transaction);
            }


            $ruleTwoItem[] = [$temp_data, $temp_data2];
        }
        return $ruleTwoItem;
    }

    public function ruleThreeItem($dataItemOne, $dataItemTwo, $dataItemThree, $total_transaction, $min_confidence)
    {
        $ruleThreeItem = [];
        foreach ($dataItemThree as $value) {
            $temp = explode(', ', $value['produk']);

            $temp_count1 = 0;
            $temp_count2 = 0;
            $temp_count3 = 0;
            $temp_count4 = 0;
            $temp_count5 = 0;
            $temp_count6 = 0;

            $const_freq1 = 0;
            $const_freq2 = 0;
            $const_freq3 = 0;
            $const_freq4 = 0;
            $const_freq5 = 0;
            $const_freq6 = 0;

            $temp_produk1 = $temp[0] . ", " . $temp[1];
            $temp_produk2 = $temp[0] . ", " . $temp[2];
            $temp_produk3 = $temp[1] . ", " . $temp[2];

            //1 item antecedent start
            // - get antecedent freq
            for ($x = 0; $x < count($dataItemOne); $x++) {
                switch ($dataItemOne[$x]['produk']) {
                    case $temp[0]:
                        $temp_count1 = $dataItemOne[$x]['count_transaction'];
                        break;
                    case $temp[1]:
                        $temp_count2 = $dataItemOne[$x]['count_transaction'];
                        break;
                    case $temp[2]:
                        $temp_count3 = $dataItemOne[$x]['count_transaction'];
                        break;
                }
            }
            // - get consequent freq
            for ($i = 0; $i < count($dataItemTwo); $i++) {
                switch ($dataItemTwo[$i]['produk']) {
                    case $temp_produk3:
                        $const_freq1 = $dataItemTwo[$i]['count_transaction'];
                        break;
                    case $temp_produk2:
                        $const_freq2 = $dataItemTwo[$i]['count_transaction'];
                        break;
                    case $temp_produk1:
                        $const_freq3 = $dataItemTwo[$i]['count_transaction'];
                        break;
                }
            }
            //1 item antecedent end

            //======================================================//

            //2 item antecedent start
            // - get antecedent freq
            for ($y = 0; $y < count($dataItemTwo); $y++) {
                switch ($dataItemTwo[$y]['produk']) {
                    case $temp_produk1:
                        $temp_count4 = $dataItemTwo[$y]['count_transaction'];
                        break;
                    case $temp_produk2:
                        $temp_count5 = $dataItemTwo[$y]['count_transaction'];
                        break;
                    case $temp_produk3:
                        $temp_count6 = $dataItemTwo[$y]['count_transaction'];
                        break;
                }
            }
            // - get consequent freq
            for ($j = 0; $j < count($dataItemOne); $j++) {
                switch ($dataItemOne[$j]['produk']) {
                    case $temp[2]:
                        $const_freq4 = $dataItemOne[$j]['count_transaction'];
                        break;
                    case $temp[1]:
                        $const_freq5 = $dataItemOne[$j]['count_transaction'];
                        break;
                    case $temp[0]:
                        $const_freq6 = $dataItemOne[$j]['count_transaction'];
                        break;
                }
            }
            //2 item antecedent end

            $temp_data1['antecedent'] = $temp[0];
            $temp_data1['consequent'] = $temp_produk3;
            $temp_data1['ab'] = $value['count_transaction'];
            $temp_data1['a'] = $temp_count1;

            $confidence1 = $value['count_transaction'] / $temp_count1;
            if ($confidence1 <= $min_confidence) {
                $temp_data1['confidence'] = $confidence1;
            }

            $temp_data1['lift_ratio'] = ($value['count_transaction'] / $temp_count1) / ($const_freq1 / $total_transaction);

            $temp_data2['antecedent'] = $temp[1];
            $temp_data2['consequent'] = $temp_produk2;
            $temp_data2['ab'] = $value['count_transaction'];
            $temp_data2['a'] = $temp_count2;

            $confidence2 = $value['count_transaction'] / $temp_count2;
            if ($confidence2 <= $min_confidence) {
                $temp_data2['confidence'] = $confidence2;
            }

            $temp_data2['lift_ratio'] = ($value['count_transaction'] / $temp_count2) / ($const_freq2 / $total_transaction);

            $temp_data3['antecedent'] = $temp[2];
            $temp_data3['consequent'] = $temp_produk1;
            $temp_data3['ab'] = $value['count_transaction'];
            $temp_data3['a'] = $temp_count3;

            $confidence3 = $value['count_transaction'] / $temp_count3;
            if ($confidence3 <= $min_confidence) {
                $temp_data3['confidence'] = $confidence3;
            }

            $temp_data3['lift_ratio'] = ($value['count_transaction'] / $temp_count3) / ($const_freq3 / $total_transaction);

            $temp_data4['antecedent'] = $temp_produk1;
            $temp_data4['consequent'] = $temp[2];
            $temp_data4['ab'] = $value['count_transaction'];
            $temp_data4['a'] = $temp_count4;

            $confidence4 = $value['count_transaction'] / $temp_count4;
            if ($confidence4 <= $min_confidence) {
                $temp_data4['confidence'] = $confidence4;
            }

            $temp_data4['lift_ratio'] = ($value['count_transaction'] / $temp_count4) / ($const_freq4 / $total_transaction);

            $temp_data5['antecedent'] = $temp_produk2;
            $temp_data5['consequent'] = $temp[1];
            $temp_data5['ab'] = $value['count_transaction'];
            $temp_data5['a'] = $temp_count5;

            $confidence5 = $value['count_transaction'] / $temp_count5;
            if ($confidence5 <= $min_confidence) {
                $temp_data5['confidence'] = $confidence5;
            }

            $temp_data5['lift_ratio'] = ($value['count_transaction'] / $temp_count5) / ($const_freq5 / $total_transaction);

            $temp_data6['antecedent'] = $temp_produk3;
            $temp_data6['consequent'] = $temp[0];
            $temp_data6['ab'] = $value['count_transaction'];
            $temp_data6['a'] = $temp_count6;

            $confidence6 = $value['count_transaction'] / $temp_count6;
            if ($confidence6 <= $min_confidence) {
                $temp_data6['confidence'] = $confidence6;
            }

            $temp_data6['lift_ratio'] = ($value['count_transaction'] / $temp_count6) / ($const_freq6 / $total_transaction);

            $ruleThreeItem[] = [
                $temp_data1,
                $temp_data2,
                $temp_data3,
                $temp_data4,
                $temp_data5,
                $temp_data6,
            ];
        }
        return $ruleThreeItem;
    }
}
