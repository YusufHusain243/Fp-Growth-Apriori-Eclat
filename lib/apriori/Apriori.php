<?php

class AprioriAlgorithm
{
    public function apriori($arr_produk, $arr_transactions, $min_support)
    {
        $L = -1;
        $result = null;
        $check = false;
        while ($check == false) {
            if ($result == null) {
                $arr = $this->combine($arr_produk, $arr_transactions, $min_support, null, null);
                if ($arr != null) {
                    $result[] = $arr;
                }
            } else {
                for ($j = 0; $j < count($result[$L]) - 1; $j++) {
                    $temp = explode(", ", $result[$L][$j]['product']);
                    $p = end($temp);
                    $index = array_search($p, $arr_produk);
                    $arr = $this->combine($arr_produk, $arr_transactions, $min_support, $result[$L][$j]['product'], $index);
                    if ($arr != null) {
                        $result[] = $arr;
                    }
                }
            }
            $L++;
            $check = !isset($result[$L]);
        }
        $result = $this->mergeArray($result);
        return $result;
    }

    private function combine($arr_produk, $arr_transactions, $min_support, $produk, $index)
    {
        $result = null;
        $temp = $produk;
        if ($produk == null && $index == null) {
            for ($i = 0; $i < count($arr_produk); $i++) {
                $freq = $this->freq($arr_transactions, $arr_produk[$i]);
                $support = ($freq / count($arr_transactions));
                $t = null;
                $t["product"] = $arr_produk[$i];
                $t["freq"] = $freq;
                $t["support"] = $support;
                if ($support >= $min_support) {
                    $result[] = $t;
                }
            }
        } else {
            for ($j = $index + 1; $j < count($arr_produk); $j++) {

                $cut_string = explode(", ", $arr_produk[$j]);
                $p = end($cut_string);
                $produk .= ", " . $p;

                $freq = $freq = $this->freq($arr_transactions, $produk);
                $support = ($freq / count($arr_transactions));
                $t = null;
                $t['product'] = $produk;
                $t["freq"] = $freq;
                $t['support'] = $support;
                if ($support >= $min_support) {
                    $result[] = $t;
                }
                $produk = $temp;
            }
        }
        return $result;
    }

    private function mergeArray($array)
    {
        $arraysMerged = [];
        if (is_array($array)) {
            foreach ($array as $a) {
                $arraysMerged = array_merge($arraysMerged, $a);
            }
        }
        return $arraysMerged;
    }

    private function freq($arr_transactions, $arr_produk)
    {
        $freq = 0;
        foreach ($arr_transactions as $transaction) {
            $arr = explode(", ", $arr_produk);
            $check = 0;
            for ($k = 0; $k < count($arr); $k++) {
                if (strpos($transaction['item'], $arr[$k]) !== false) {
                    $check += 0;
                } else {
                    $check += 1;
                }
            }

            if ($check == 0) {
                $freq += 1;
            }
        }
        return $freq;
    }

    public function generateRule($itemsets, $arr_transactions, $min_confidence)
    {
        $result = null;
        for ($i = 0; $i < count($itemsets); $i++) {
            $arr_produk = explode(", ", $itemsets[$i]['product']);
            if (count($arr_produk) == 2) {
                $t = null;
                for ($j = 0; $j < count($arr_produk); $j++) {
                    $confidence = $this->confidence($arr_produk[$j], implode($this->consequent($arr_produk, $arr_produk[$j])), $arr_transactions);
                    $t = null;
                    $t['antecedent'] = $arr_produk[$j];
                    $t['consequent'] = implode($this->consequent($arr_produk, $arr_produk[$j]));
                    $t['confidence'] = $confidence;
                    $t['lift_ratio'] = $this->lift_ratio($confidence, implode($this->consequent($arr_produk, $arr_produk[$j])), $arr_transactions);
                    if ($confidence >= $min_confidence) {
                        $result[] = [$t];
                    }
                }
            }
            if (count($arr_produk) > 2) {
                $result[] = $this->antecedent($arr_produk, $arr_transactions, $min_confidence);
            }
        }
        $result = $this->mergeArray($result);
        return $result;
    }

    private function consequent($arr_produk, $antecedent)
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
        return $result;
    }

    private function antecedent($arr_produk, $arr_transactions, $min_confidence)
    {
        $L = -1;
        $temp_result = null;
        $result = null;
        $check = false;
        while ($check == false) {
            if ($temp_result == null) {
                $arr = $this->combineAntecedent($arr_produk, null, null, $arr_transactions, $min_confidence);
                if ($arr != null) {
                    $temp_result[] = $arr;
                    if ($this->checkConfidence($arr, $min_confidence) != null) {
                        $result[] = $this->checkConfidence($arr, $min_confidence);
                    }
                }
            } else {
                for ($j = 0; $j < count($temp_result[$L]) - 1; $j++) {
                    $temp = explode(", ", $temp_result[$L][$j]['antecedent']);
                    $p = end($temp);
                    $index = array_search($p, $arr_produk);
                    $arr = $this->combineAntecedent($arr_produk, $temp_result[$L][$j]['antecedent'], $index, $arr_transactions, $min_confidence);
                    if ($arr != null) {
                        $temp_result[] = $arr;
                        if ($this->checkConfidence($arr, $min_confidence) != null) {
                            $result[] = $this->checkConfidence($arr, $min_confidence);
                        }
                    }
                }
            }
            $L++;
            $check = !isset($temp_result[$L]);
        }
        $result = $this->mergeArray($result);
        return $result;
    }

    private function checkConfidence($arr_confidence, $min_confidence)
    {
        $result = null;
        for ($i = 0; $i < count($arr_confidence); $i++) {
            if ($arr_confidence[$i]['confidence'] >= $min_confidence) {
                $result[] = $arr_confidence[$i];
            }
        }
        return $result;
    }

    private function combineAntecedent($arr_produk, $produk, $index, $arr_transactions, $min_confidence)
    {
        $result = null;
        $temp = $produk;
        if ($produk == null && $index == null) {
            for ($i = 0; $i < count($arr_produk); $i++) {
                $confidence = $this->confidence($arr_produk[$i], implode(", ", $this->consequent($arr_produk, $arr_produk[$i])), $arr_transactions);

                $t = null;
                $t['antecedent'] = $arr_produk[$i];
                $t['consequent'] = implode(", ", $this->consequent($arr_produk, $arr_produk[$i]));
                $t['confidence'] = $confidence;
                $t['lift_ratio'] = $this->lift_ratio($confidence, implode(", ", $this->consequent($arr_produk, $arr_produk[$i])), $arr_transactions);
                $result[] = $t;
            }
        } else {
            if (count(explode(", ", $produk)) < count($arr_produk) - 1) {
                for ($j = $index + 1; $j < count($arr_produk); $j++) {
                    $produk .= ", " . $arr_produk[$j];
                    $confidence = $this->confidence($produk, implode(", ", $this->consequent($arr_produk, $produk)), $arr_transactions);
                    $t = null;
                    $t['antecedent'] = $produk;
                    $t['consequent'] = implode(", ", $this->consequent($arr_produk, $produk));
                    $t['confidence'] = $confidence;
                    $t['lift_ratio'] = $this->lift_ratio($confidence, implode(", ", $this->consequent($arr_produk, $produk)), $arr_transactions);
                    $result[] = $t;
                    $produk = $temp;
                }
            }
        }
        return $result;
    }

    private function confidence($antecedent, $consequent, $itemsets)
    {
        $freq_ab = $this->freq($itemsets, $antecedent . ", " . $consequent);
        $freq_a =  $this->freq($itemsets, $antecedent);
        $result = $freq_ab / $freq_a;
        return $result;
    }

    private function lift_ratio($confidence, $consequent, $arr_transactions)
    {
        $result = $confidence / $this->benchmark_confidence($consequent, $arr_transactions);
        return $result;
    }

    private function benchmark_confidence($consequent, $arr_transactions)
    {
        $result = $this->freq($arr_transactions, $consequent) / count($arr_transactions);
        return $result;
    }
}
