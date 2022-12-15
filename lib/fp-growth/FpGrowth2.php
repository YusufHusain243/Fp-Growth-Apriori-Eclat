<?php
class FpGrowth2
{
    public function freqItemSet($dataProduk, $dataTransaction)
    {
        $freqItemSet = [];
        foreach ($dataProduk as $produk) {
            $count_transaction = 0;
            foreach ($dataTransaction as $transaksi) {
                if (strpos($transaksi['item'], $produk) !== false) {
                    $count_transaction += 1;
                }
            }
            $freqItemSet[] = [
                "produk" => $produk,
                "count_transaction" => $count_transaction,
            ];
        }
        return $freqItemSet;
    }

    public function sortByPriority($freqItemSet)
    {
        $sortByPriority = $freqItemSet;
        $count_transaction = array_column($sortByPriority, 'count_transaction');
        array_multisort($count_transaction, SORT_DESC, $sortByPriority);
        return $sortByPriority;
    }

    public function sortItemByPriority($dataTransaction, $sortByPriority)
    {
        $sortItemByPriority = [];
        foreach ($dataTransaction as $value) {
            $arr_item = explode(', ', $value['item']);
            $temp = [];
            $temp2 = [];
            foreach ($arr_item as $value2) {
                foreach ($sortByPriority as $value3) {
                    if ($value3['produk'] === $value2) {
                        $temp['item'] = $value2;
                        $temp['freq'] = $value3['count_transaction'];
                        if (!in_array($temp, $temp2)) {
                            $temp2[] = $temp;
                        }
                    }
                }
            }
            $count_transaction = array_column($temp2, 'freq');
            array_multisort($count_transaction, SORT_DESC, $temp2);
            $sortItemByPriority[] = $temp2;
        }
        return $sortItemByPriority;
    }

    // public function fpTree()
    // {
    //     $array = [
    //         ['a', 'b', 'c'],
    //         ['b', 'c', 'd', 'e'],
    //         ['a', 'c', 'd'],
    //         ['c', 'd'],
    //     ];

    //     $tree = null;

    //     for ($i = 0; $i < count($array); $i++) {
    //         $id = uniqid();
    //         if ($tree == null) {
    //             $t['id'] = $id;
    //             $t['parent'] = null;
    //             $t['item'] = null;
    //             $tree[] = $t;
    //             for ($j = 0; $j < count($array[0]); $j++) {
    //                 $id = uniqid();
    //                 $t['id'] = $id;
    //                 $t['parent'] = $tree[$j]['id'];
    //                 $t['item'] = $array[0][$j];
    //                 $tree[] = $t;
    //             }
    //         } else {
    //             $k = 1;
    //             $check = false;
    //             while ($check == false) {
    //                 print_r(json_encode($k));
    //                 print_r(json_encode($tree[$k]));
    //                 echo "<br>";
    //                 $k++;
    //                 $check = !isset($tree[$k]);
    //             }
    //         }
    //         echo "<br>";
    //     }

    //     return $tree;
    // }
}
