<?php
class HelperEclat
{
    public function mergeArray($array)
    {
        $arraysMerged = [];
        if (is_array($array)) {
            foreach ($array as $a) {
                $arraysMerged = array_merge($arraysMerged, $a);
            }
        }
        return $arraysMerged;
    }

    public function getTid($produk, $arr_transactions)
    {
        $result = null;
        $arr_p = explode(", ", $produk);
        foreach ($arr_transactions as $transaction) {
            $check = 0;
            for ($i = 0; $i < count($arr_p); $i++) {
                if (strpos($transaction['item'], $arr_p[$i]) !== false) {
                    $check += 0;
                } else {
                    $check += 1;
                }
            }

            if ($check == 0) {
                if ($result == null) {
                    $result .= $transaction['id'];
                } else {
                    $result .= ", " . $transaction['id'];
                }
            }
        }
        return $result;
    }

    public function support($total_tid, $total_transactions)
    {
        $result = $total_tid / $total_transactions;
        return $result;
    }

    public function consequent($arr_produk, $antecedent)
    {
        $result = null;
        for ($i = 0; $i < count($arr_produk); $i++) {
            $arr_antecedent = explode(", ", $antecedent);
            $check = 0;
            for ($j = 0; $j < count($arr_antecedent); $j++) {
                if ($arr_produk[$i] != $arr_antecedent[$j]) {
                    $check += 0;
                } else {
                    $check += 1;
                }
            }
            if ($check == 0) {
                $result[] = $arr_produk[$i];
            }
        }
        $result = implode(", ", $result);
        return $result;
    }

    public function confidence($antecedent, $consequent, $itemsets)
    {
        $freq_ab = count(explode(", ", $this->getTid($antecedent . ", " . $consequent, $itemsets)));
        $freq_a =  count(explode(", ", $this->getTid($antecedent, $itemsets)));
        $result = $freq_ab / $freq_a;
        return $result;
    }

    public function lift_ratio($confidence, $consequent, $arr_transactions)
    {
        $result = $confidence / $this->benchmark_confidence($consequent, $arr_transactions);
        return $result;
    }

    public function benchmark_confidence($consequent, $arr_transactions)
    {
        $result = count(explode(", ", $this->getTid($consequent, $arr_transactions))) / count($arr_transactions);
        return $result;
    }

    public function checkConfidence($arr_confidence, $min_confidence)
    {
        $result = null;
        for ($i = 0; $i < count($arr_confidence); $i++) {
            if ($arr_confidence[$i]['confidence'] >= $min_confidence) {
                $result[] = $arr_confidence[$i];
            }
        }
        return $result;
    }
}
