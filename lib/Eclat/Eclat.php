<?php
require "lib\Eclat\HelperEclat.php";
class Eclat
{
    public function vertikalDataFormat($dataProduk, $dataTransaction)
    {
        $result = null;
        foreach ($dataProduk as $dp) {
            $temp['produk'] = $dp;
            $t = array();
            foreach ($dataTransaction as $dt) {
                if (strpos($dt['item'], $dp) !== false) {
                    if (!in_array($dt['id'], $t)) {
                        $t[] = $dt['id'];
                    }
                }
                $temp['TID'] = implode(", ", $t);
            }
            $result[] = $temp;
        }
        return $result;
    }

    public function itemsets($arr_produk, $arr_transactions, $min_support)
    {
        $helper_eclat = new HelperEclat();
        $i = -1;
        $result = null;
        $check = false;
        while ($check == false) {
            if ($result == null) {
                $arr = $this->combine(
                    $arr_produk,
                    $arr_transactions,
                    null,
                    null,
                    $min_support
                );
                if ($arr != null) {
                    $result[] = $arr;
                }
            } else {
                for ($j = 0; $j < count($result[$i]) - 1; $j++) {
                    $arr_p = explode(", ", $result[$i][$j]['produk']);
                    $end_p = end($arr_p);
                    $index_end_p = array_search($end_p, array_column($arr_produk, "produk"));
                    $arr = $this->combine(
                        $arr_produk,
                        $arr_transactions,
                        $result[$i][$j]['produk'],
                        $index_end_p,
                        $min_support
                    );
                    if ($arr != null) {
                        $result[] = $arr;
                    }
                }
            }
            $i++;
            $check = !isset($result[$i]);
        }
        $result = $helper_eclat->mergeArray($result);
        return $result;
    }

    private function combine($arr_produk, $arr_transactions, $produk, $index, $min_support)
    {
        $helper_eclat = new HelperEclat();
        $result = null;
        $temp = $produk;

        if ($produk == null && $index == null) {
            for ($i = 0; $i < count($arr_produk); $i++) {

                $tid = $helper_eclat->getTid($arr_produk[$i]['produk'], $arr_transactions);
                $support = $helper_eclat->support($tid == null ? 0 : count(explode(", ", $tid)), count($arr_transactions));

                $t = null;
                $t['produk'] = $arr_produk[$i]['produk'];
                $t['TID'] = $tid;
                $t['freq'] = $tid == null ? 0 : count(explode(", ", $tid));
                $t['support'] = $support;

                if ($support >= $min_support) {
                    $result[] = $t;
                }
            }
        } else {
            for ($j = $index + 1; $j < count($arr_produk); $j++) {
                $arr_p = explode(", ", $arr_produk[$j]['produk']);
                $end_p = end($arr_p);
                $produk .= ", " . $end_p;

                $tid = $helper_eclat->getTid($produk, $arr_transactions);
                $support = $helper_eclat->support($tid == null ? 0 : count(explode(", ", $tid)), count($arr_transactions));

                $t = null;
                $t['produk'] = $produk;
                $t['TID'] = $tid;
                $t['freq'] = $tid == null ? 0 : count(explode(", ", $tid));
                $t['support'] = $support;

                if ($support >= $min_support) {
                    $result[] = $t;
                }
                $produk = $temp;
            }
        }
        return $result;
    }

    public function generateRule($itemsets, $arr_transactions, $min_confidence)
    {
        $helper_eclat = new HelperEclat();
        $result = null;
        for ($i = 0; $i < count($itemsets); $i++) {
            $arr_produk = explode(", ", $itemsets[$i]['produk']);
            if (count($arr_produk) == 2) {
                for ($j = 0; $j < count($arr_produk); $j++) {
                    $consequent = $helper_eclat->consequent($arr_produk, $arr_produk[$j]);
                    $confidence = $helper_eclat->confidence(
                        $arr_produk[$j],
                        $consequent,
                        $arr_transactions
                    );
                    $t = null;
                    $t['antecedent'] = $arr_produk[$j];
                    $t['consequent'] = $consequent;
                    $t['confidence'] = $confidence;
                    $t['lift_ratio'] = $helper_eclat->lift_ratio(
                        $confidence,
                        $consequent,
                        $arr_transactions
                    );
                    if ($confidence >= $min_confidence) {
                        $result[] = [$t];
                    }
                }
            }
            if (count($arr_produk) > 2) {
                $result[] = $this->antecedent(
                    $arr_produk,
                    $arr_transactions,
                    $min_confidence
                );
            }
        }
        $result = $helper_eclat->mergeArray($result);
        return $result;
    }

    private function antecedent($arr_produk, $arr_transactions, $min_confidence)
    {
        $helper_eclat = new HelperEclat();
        $L = -1;
        $temp_result = null;
        $result = null;
        $check = false;
        while ($check == false) {
            if ($temp_result == null) {
                $arr = $this->combineAntecedent(
                    $arr_produk,
                    null,
                    null,
                    $arr_transactions
                );
                if ($arr != null) {
                    $temp_result[] = $arr;
                    $checkConfidence = $helper_eclat->checkConfidence($arr, $min_confidence);
                    if ($checkConfidence != null) {
                        $result[] = $checkConfidence;
                    }
                }
            } else {
                for ($j = 0; $j < count($temp_result[$L]) - 1; $j++) {
                    $temp = explode(", ", $temp_result[$L][$j]['antecedent']);
                    $p = end($temp);
                    $index = array_search($p, $arr_produk);
                    $arr = $this->combineAntecedent(
                        $arr_produk,
                        $temp_result[$L][$j]['antecedent'],
                        $index,
                        $arr_transactions
                    );
                    if ($arr != null) {
                        $temp_result[] = $arr;
                        $checkConfidence = $helper_eclat->checkConfidence($arr, $min_confidence);
                        if ($checkConfidence != null) {
                            $result[] = $checkConfidence;
                        }
                    }
                }
            }
            $L++;
            $check = !isset($temp_result[$L]);
        }
        $result = $helper_eclat->mergeArray($result);
        return $result;
    }

    private function combineAntecedent($arr_produk, $produk, $index, $arr_transactions)
    {
        $helper_eclat = new HelperEclat();
        $result = null;
        $temp = $produk;
        if ($produk == null && $index == null) {
            for ($i = 0; $i < count($arr_produk); $i++) {
                $confidence = $helper_eclat->confidence(
                    $arr_produk[$i],
                    $helper_eclat->consequent($arr_produk, $arr_produk[$i]),
                    $arr_transactions
                );

                $t = null;
                $t['antecedent'] = $arr_produk[$i];
                $t['consequent'] = $helper_eclat->consequent($arr_produk, $arr_produk[$i]);
                $t['confidence'] = $confidence;
                $t['lift_ratio'] = $helper_eclat->lift_ratio(
                    $confidence,
                    $helper_eclat->consequent($arr_produk, $arr_produk[$i]),
                    $arr_transactions
                );
                $result[] = $t;
            }
        } else {
            if (count(explode(", ", $produk)) < count($arr_produk) - 1) {
                for ($j = $index + 1; $j < count($arr_produk); $j++) {
                    $produk .= ", " . $arr_produk[$j];
                    $confidence = $helper_eclat->confidence(
                        $produk,
                        $helper_eclat->consequent($arr_produk, $produk),
                        $arr_transactions
                    );
                    $t = null;
                    $t['antecedent'] = $produk;
                    $t['consequent'] = $helper_eclat->consequent($arr_produk, $produk);
                    $t['confidence'] = $confidence;
                    $t['lift_ratio'] = $helper_eclat->lift_ratio(
                        $confidence,
                        $helper_eclat->consequent($arr_produk, $produk),
                        $arr_transactions
                    );
                    $result[] = $t;
                    $produk = $temp;
                }
            }
        }
        return $result;
    }
}
