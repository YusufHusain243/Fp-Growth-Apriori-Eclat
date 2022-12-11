<?php
class Eclat
{
    public function vertikalDataFormat($dataProduk, $dataTransaction)
    {
        $vertikalDataFormat = [];
        foreach ($dataProduk as $dp) {
            $temp['produk'] = $dp;
            $t = [];
            foreach ($dataTransaction as $dt) {
                if (strpos($dt['item'], $dp) !== false) {
                    if (!in_array($dt['id'], $t)) {
                        $t[] = $dt['id'];
                    }
                }
                $temp['TID'] = $t;
            }
            $vertikalDataFormat[] = $temp;
        }
        return $vertikalDataFormat;
    }

    public function itemsetOne($vertikalDataFormat, $totalTransaction, $minSupport)
    {
        $itemsetOne = [];
        foreach ($vertikalDataFormat as $value) {
            $support = (count($value['TID']) / $totalTransaction);
            if ($support >= $minSupport) {
                $temp['produk'] = $value['produk'];
                $temp['freq'] = count($value['TID']);
                $temp['support'] = $support;
                $temp['TID'] = $value['TID'];
                $itemsetOne[] = $temp;
            }
        }
        return $itemsetOne;
    }

    public function itemsetTwo($itemsetOne, $totalTransaction, $minSupport)
    {
        $itemsetTwo = [];
        for ($i = 0; $i < count($itemsetOne) - 1; $i++) {
            for ($j = $i + 1; $j < count($itemsetOne); $j++) {
                $t = [];
                foreach ($itemsetOne[$i]['TID'] as $value1) {
                    foreach ($itemsetOne[$j]['TID'] as $value2) {
                        if ($value1 == $value2) {
                            $t[] = $value2;
                        }
                    }
                }
                $support = count($t) / $totalTransaction;
                if ($support >= $minSupport) {
                    $temp['produk'] = $itemsetOne[$i]['produk'] . ", " . $itemsetOne[$j]['produk'];
                    $temp['freq'] = count($t);
                    $temp['TID'] = $t;
                    $temp['support'] = $support;
                    $itemsetTwo[] = $temp;
                }
            }
        }
        return $itemsetTwo;
    }

    public function itemsetThree($itemsetOne, $totalTransaction, $minSupport)
    {
        $itemsetThree = [];
        for ($i = 0; $i < count($itemsetOne) - 1; $i++) {
            for ($j = $i + 1; $j < count($itemsetOne); $j++) {
                for ($k = $j + 1; $k < count($itemsetOne); $k++) {
                    $t = [];
                    foreach ($itemsetOne[$i]['TID'] as $value1) {
                        foreach ($itemsetOne[$j]['TID'] as $value2) {
                            foreach ($itemsetOne[$k]['TID'] as $value3) {
                                if ($value1 == $value2 && $value1 == $value3) {
                                    $t[] = $value2;
                                }
                            }
                        }
                    }
                    $support = count($t) / $totalTransaction;
                    if ($support >= $minSupport) {
                        $temp['produk'] = $itemsetOne[$i]['produk'] . ", " . $itemsetOne[$j]['produk'] . ", " . $itemsetOne[$k]['produk'];
                        $temp['freq'] = count($t);
                        $temp['TID'] = $t;
                        $temp['support'] = $support;
                        $itemsetThree[] = $temp;
                    }
                }
            }
        }
        return $itemsetThree;
    }

    public function ruleTwoItem($itemsetOne, $itemsetTwo, $total_transaction, $minConfidence)
    {
        $ruleTwoItem = [];
        foreach ($itemsetTwo as $value) {
            $temp = explode(', ', $value['produk']);

            $freq_ant1 = 0;
            $freq_ant2 = 0;

            $freq_cons1 = 0;
            $freq_cons2 = 0;

            //get antecedent freq
            for ($x = 0; $x < count($itemsetOne); $x++) {
                switch ($itemsetOne[$x]['produk']) {
                    case $temp[0]:
                        $freq_ant1 = $itemsetOne[$x]['freq'];
                        break;
                    case $temp[1]:
                        $freq_ant2 = $itemsetOne[$x]['freq'];
                        break;
                }
            }

            //get consequent freq
            for ($y = 0; $y < count($itemsetOne); $y++) {
                switch ($itemsetOne[$y]['produk']) {
                    case $temp[1]:
                        $freq_cons1 = $itemsetOne[$y]['freq'];
                        break;
                    case $temp[0]:
                        $freq_cons2 = $itemsetOne[$y]['freq'];
                        break;
                }
            }

            $confidence1 = $value['freq'] / $freq_ant1;
            if ($confidence1 >= $minConfidence) {
                $temp_data1['antecedent'] = $temp[0];
                $temp_data1['consequent'] = $temp[1];
                $temp_data1['ab'] = $value['freq'];
                $temp_data1['a'] = $freq_ant1;
                $temp_data1['confidence'] =  $confidence1;
                $temp_data1['lift_ratio'] = ($confidence1) / ($freq_cons1 / $total_transaction);
            }

            $confidence2 = $value['freq'] / $freq_ant2;
            if ($confidence2 >= $minConfidence) {
                $temp_data2['antecedent'] = $temp[1];
                $temp_data2['consequent'] = $temp[0];
                $temp_data2['ab'] = $value['freq'];
                $temp_data2['a'] = $freq_ant2;
                $temp_data2['confidence'] = $confidence2;
                $temp_data2['lift_ratio'] = ($confidence2) / ($freq_cons2 / $total_transaction);
            }

            if (!in_array($temp_data1, $ruleTwoItem) && isset($temp_data1) == true) {
                $ruleTwoItem[] = $temp_data1;
            }
            if (!in_array($temp_data2, $ruleTwoItem) && isset($temp_data2) == true) {
                $ruleTwoItem[] = $temp_data2;
            }
        }
        return $ruleTwoItem;
    }

    public function ruleThreeItem($itemsetOne, $itemsetTwo, $itemsetThree, $total_transaction, $minConfidence)
    {
        $ruleThreeItem = [];
        foreach ($itemsetThree as $value) {
            $temp = explode(', ', $value['produk']);

            $freq_ant1 = 0;
            $freq_ant2 = 0;
            $freq_ant3 = 0;
            $freq_ant4 = 0;
            $freq_ant5 = 0;
            $freq_ant6 = 0;

            $freq_cons1 = 0;
            $freq_cons2 = 0;
            $freq_cons3 = 0;
            $freq_cons4 = 0;
            $freq_cons5 = 0;
            $freq_cons5 = 0;

            $temp_produk1 = $temp[0] . ", " . $temp[1];
            $temp_produk2 = $temp[0] . ", " . $temp[2];
            $temp_produk3 = $temp[1] . ", " . $temp[2];

            //1 item antecedent start
            // - get antecedent freq
            for ($x = 0; $x < count($itemsetOne); $x++) {
                switch ($itemsetOne[$x]['produk']) {
                    case $temp[0]:
                        $freq_ant1 = $itemsetOne[$x]['freq'];
                        break;
                    case $temp[1]:
                        $freq_ant2 = $itemsetOne[$x]['freq'];
                        break;
                    case $temp[2]:
                        $freq_ant3 = $itemsetOne[$x]['freq'];
                        break;
                }
            }
            // - get consequent freq
            for ($i = 0; $i < count($itemsetTwo); $i++) {
                switch ($itemsetTwo[$i]['produk']) {
                    case $temp_produk3:
                        $freq_cons1 = $itemsetTwo[$i]['freq'];
                        break;
                    case $temp_produk2:
                        $freq_cons2 = $itemsetTwo[$i]['freq'];
                        break;
                    case $temp_produk1:
                        $freq_cons3 = $itemsetTwo[$i]['freq'];
                        break;
                }
            }
            //1 item antecedent end

            //======================================================//

            //2 item antecedent start
            // - get antecedent freq
            for ($y = 0; $y < count($itemsetTwo); $y++) {
                switch ($itemsetTwo[$y]['produk']) {
                    case $temp_produk1:
                        $freq_ant4 = $itemsetTwo[$y]['freq'];
                        break;
                    case $temp_produk2:
                        $freq_ant5 = $itemsetTwo[$y]['freq'];
                        break;
                    case $temp_produk3:
                        $freq_ant6 = $itemsetTwo[$y]['freq'];
                        break;
                }
            }
            // - get consequent freq
            for ($j = 0; $j < count($itemsetOne); $j++) {
                switch ($itemsetOne[$j]['produk']) {
                    case $temp[2]:
                        $freq_cons4 = $itemsetOne[$j]['freq'];
                        break;
                    case $temp[1]:
                        $freq_cons5 = $itemsetOne[$j]['freq'];
                        break;
                    case $temp[0]:
                        $freq_cons5 = $itemsetOne[$j]['freq'];
                        break;
                }
            }
            //2 item antecedent end


            $confidence1 = $value['freq'] / $freq_ant1;
            if ($confidence1 >= $minConfidence) {
                $temp_data1['antecedent'] = $temp[0];
                $temp_data1['consequent'] = $temp_produk3;
                $temp_data1['ab'] = $value['freq'];
                $temp_data1['a'] = $freq_ant1;
                $temp_data1['confidence'] = $confidence1;
                $temp_data1['lift_ratio'] = ($confidence1) / ($freq_cons1 / $total_transaction);
            }

            $confidence2 = $value['freq'] / $freq_ant2;
            if ($confidence2 >= $minConfidence) {
                $temp_data2['antecedent'] = $temp[1];
                $temp_data2['consequent'] = $temp_produk2;
                $temp_data2['ab'] = $value['freq'];
                $temp_data2['a'] = $freq_ant2;
                $temp_data2['confidence'] =  $confidence2;
                $temp_data2['lift_ratio'] = ($confidence2) / ($freq_cons2 / $total_transaction);
            }

            $confidence3 = $value['freq'] / $freq_ant3;
            if ($confidence3 >= $minConfidence) {
                $temp_data3['antecedent'] = $temp[2];
                $temp_data3['consequent'] = $temp_produk1;
                $temp_data3['ab'] = $value['freq'];
                $temp_data3['a'] = $freq_ant3;
                $temp_data3['confidence'] =  $confidence3;
                $temp_data3['lift_ratio'] = ($confidence3) / ($freq_cons3 / $total_transaction);
            }

            $confidence4 = $value['freq'] / $freq_ant4;
            if ($confidence4 >= $minConfidence) {
                $temp_data4['antecedent'] = $temp_produk1;
                $temp_data4['consequent'] = $temp[2];
                $temp_data4['ab'] = $value['freq'];
                $temp_data4['a'] = $freq_ant4;
                $temp_data4['confidence'] =  $confidence4;
                $temp_data4['lift_ratio'] = ($confidence4) / ($freq_cons4 / $total_transaction);
            }

            $confidence5 = $value['freq'] / $freq_ant5;
            if ($confidence5 >= $minConfidence) {
                $temp_data5['antecedent'] = $temp_produk2;
                $temp_data5['consequent'] = $temp[1];
                $temp_data5['ab'] = $value['freq'];
                $temp_data5['a'] = $freq_ant5;
                $temp_data5['confidence'] = $confidence5;
                $temp_data5['lift_ratio'] = ($confidence5) / ($freq_cons5 / $total_transaction);
            }

            $confidence6 = $value['freq'] / $freq_ant6;
            if ($confidence6 >= $minConfidence) {
                $temp_data6['antecedent'] = $temp_produk3;
                $temp_data6['consequent'] = $temp[0];
                $temp_data6['ab'] = $value['freq'];
                $temp_data6['a'] = $freq_ant6;
                $temp_data6['confidence'] = $confidence6;
                $temp_data6['lift_ratio'] = ($confidence6) / ($freq_cons5 / $total_transaction);
            }


            if (!in_array($temp_data1, $ruleThreeItem) && isset($temp_data1) == true) {
                $ruleThreeItem[] = $temp_data1;
            }
            if (!in_array($temp_data2, $ruleThreeItem) && isset($temp_data2) == true) {
                $ruleThreeItem[] = $temp_data2;
            }
            if (!in_array($temp_data3, $ruleThreeItem) && isset($temp_data3) == true) {
                $ruleThreeItem[] = $temp_data3;
            }
            if (!in_array($temp_data4, $ruleThreeItem) && isset($temp_data4) == true) {
                $ruleThreeItem[] = $temp_data4;
            }
            if (!in_array($temp_data5, $ruleThreeItem) && isset($temp_data5) == true) {
                $ruleThreeItem[] = $temp_data5;
            }
            if (!in_array($temp_data6, $ruleThreeItem) && isset($temp_data6) == true) {
                $ruleThreeItem[] = $temp_data6;
            }
        }
        return $ruleThreeItem;
    }
}
