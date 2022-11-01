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

    public function fpTree($sortItemByPriority)
    {
        $fpTree = [];
        foreach ($sortItemByPriority as $value) {
            foreach ($value as $value2) {
                $fpTree = $this->insertTree($value2);
            }
        }

        print_r(json_encode($fpTree));
    }

    private function insertTree($tree)
    {
        $arr_tree = [];
        array_push($arr_tree, $tree);
        return $arr_tree;
    }

    // public function fpTree($sortItemByPriority)
    // {
    //     //if order by parentid, id
    //     $arr = array(
    //         array('id' => 100, 'parentid' => 0, 'name' => 'a'),
    //         array('id' => 101, 'parentid' => 100, 'name' => 'b'),
    //         array('id' => 102, 'parentid' => 101, 'name' => 'c'),
    //         array('id' => 103, 'parentid' => 101, 'name' => 'd'),
    //     );

    //     $arr_tree = array();
    //     $arr_tmp = array();

    //     foreach ($arr as $item) {
    //         $parentid = $item['parentid'];
    //         $id = $item['id'];

    //         if ($parentid  == 0) {
    //             $arr_tree[$id] = $item;
    //             $arr_tmp[$id] = &$arr_tree[$id];
    //         } else {
    //             if (!empty($arr_tmp[$parentid])) {
    //                 $arr_tmp[$parentid]['children'][$id] = $item;
    //                 $arr_tmp[$id] = &$arr_tmp[$parentid]['children'][$id];
    //             }
    //         }
    //     }

    //     unset($arr_tmp);
    //     echo '<pre>';
    //     print_r($arr_tree);
    //     echo "</pre>";
    // }
}
