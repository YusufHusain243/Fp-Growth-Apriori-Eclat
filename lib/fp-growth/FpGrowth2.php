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

    // public function fpTree($sortItemByPriority)
    // {
    //     $fpTree = [];
    //     foreach ($sortItemByPriority as $value) {
    //         foreach ($value as $value2) {
    //             $fpTree = $this->insertTree($value2);
    //         }
    //     }

    //     print_r(json_encode($fpTree));
    // }

    private function insertTree($tree)
    {
        $arr_tree = [];
        array_push($arr_tree, $tree);
        return $arr_tree;
    }

    // public function fpTree()
    // {
    //     //if order by parentid, id
    //     $arr = array(
    //         // array('id' => 100, 'parentid' => 0, 'name' => 'a'),
    //         // array('id' => 101, 'parentid' => 100, 'name' => 'b'),
    //         // array('id' => 102, 'parentid' => 101, 'name' => 'c'),
    //         // array('id' => 103, 'parentid' => 101, 'name' => 'd'),
    //         array('product'=> 'null', 'parent'=> 0, 'child'=> 'Roti'),
    //         array('product'=> 'Roti', 'parent'=> 'null', 'child'=> 'Mentega'),
    //         array('product'=> 'Mentega', 'parent'=> 'Roti', 'child'=> 'Pena'),
    //         array('product'=> 'Pena', 'parent'=> 'Mentega', 'child'=> ''),
    //         array('product'=> 'Roti', 'parent'=> 'null', 'child'=> 'Mentega'),
    //         array('product'=> 'Mentega', 'parent'=> 'Roti', 'child'=> 'Telur'),
    //         array('product'=> 'Telur', 'parent'=> 'Mentega', 'child'=> ''),
    //         array('product'=> 'Telur', 'parent'=> 'null', 'child'=> 'Susu'),
    //         array('product'=> 'Susu', 'parent'=> 'Telur', 'child'=> 'Buncis'),
    //         array('product'=> 'Buncis', 'parent'=> 'Susu', 'child'=> ''),
    //         array('product'=> 'Roti', 'parent'=> 'null', 'child'=> 'Mentega'),
    //         array('product'=> 'Mentega', 'parent'=> 'Roti', 'child'=> ''),
    //         array('product'=> 'Roti', 'parent'=> 'null', 'child'=> 'Mentega'),
    //         array('product'=> 'Mentega', 'parent'=> 'Roti', 'child'=> 'Telur'),
    //         array('product'=> 'Telur', 'parent'=> 'Mentega', 'child'=> 'Susu'),
    //         array('product'=> 'Susu', 'parent'=> 'Telur', 'child'=> 'Kecap'),
    //         array('product'=> 'Kecap', 'parent'=> 'Susu', 'child'=> '')
    //     );

    //     $arr_tree = array();
    //     $arr_tmp = array();

    //     foreach ($arr as $item) {
    //         $parentid = $item['parent'];
    //         $id = $item['product'];

    //         if ($parentid  == 0) {
    //             $arr_tree[$id] = $item;
    //             $arr_tmp[$id] = &$arr_tree[$id];
    //         } else {
    //             if (!empty($arr_tmp[$parentid])) {
    //                 $arr_tmp[$parentid]['c'][$id] = $item;
    //                 $arr_tmp[$id] = &$arr_tmp[$parentid]['c'][$id];
    //             }
    //         }
    //     }

    //     unset($arr_tmp);
    //     echo '<pre>';
    //     print_r($arr_tree);
    //     echo "</pre>";
    // }

    function buildTree(array $flatList)
    {
        $grouped = [];
        foreach ($flatList as $node) {
            $grouped[$node['parent']][] = $node;
        }

        $fnBuilder = function ($siblings) use (&$fnBuilder, $grouped) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling['id'];
                if (isset($grouped[$id])) {
                    $sibling['children'] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }
            return $siblings;
        };

        return $fnBuilder($grouped[0]);
    }

    function tree()
    {
        $arr = array(
            array('id' => 0, 'parent' => 0, 'product' => 'null', 'child' => 'Roti'),
            array('id' => 1, 'parent' => 0, 'product' => 'Roti', 'child' => 'Mentega'),
            array('id' => 2, 'parent' => 1, 'product' => 'Mentega', 'child' => 'Pena'),
            array('id' => 3, 'parent' => 2, 'product' => 'Pena', 'child' => ''),
            //array('id' => 1, 'parent' => 0, 'product' => 'Roti', 'child' => 'Mentega'),
            array('id' => 2, 'parent' => 1, 'product' => 'Mentega', 'child' => 'Telur'),
            array('id' => 6, 'parent' => 2, 'product' => 'Telur', 'child' => ''),
            array('id' => 6, 'parent' => 0, 'product' => 'Telur', 'child' => 'Susu'),
            array('id' => 8, 'parent' => 6, 'product' => 'Susu', 'child' => 'Buncis'),
            array('id' => 9, 'parent' => 8, 'product' => 'Buncis', 'child' => ''),
            //array('id' => 1, 'parent' => 0, 'product' => 'Roti', 'child' => 'Mentega'),
            // array('id' => 2, 'parent' => 1, 'product' => 'Mentega', 'child' => ''),
            //array('id' => 1, 'parent' => 0, 'product' => 'Roti', 'child' => 'Mentega'),
            //array('id' => 2, 'parent' => 1, 'product' => 'Mentega', 'child' => 'Telur'),
            array('id' => 6, 'parent' => 2, 'product' => 'Telur', 'child' => 'Susu'),
            array('id' => 8, 'parent' => 6, 'product' => 'Susu', 'child' => 'Kecap'),
            array('id' => 16, 'parent' => 8, 'product' => 'Kecap', 'child' => '')
        );

        // $arr = array(
        //     array('id' => 100, 'parentid' => 0, 'name' => 'a'),
        //     array('id' => 101, 'parentid' => 100, 'name' => 'a'),
        //     array('id' => 102, 'parentid' => 101, 'name' => 'a'),
        //     array('id' => 103, 'parentid' => 101, 'name' => 'a'),
        // );

        $arr_tree = array();
        $arr_tmp = array();

        foreach ($arr as $item) {
            $parentid = $item['parent'];
            $id = $item['id'];

            if ($parentid  == 0) {
                $arr_tree[$id] = $item;
                $arr_tmp[$id] = &$arr_tree[$id];
            } else {
                if (!empty($arr_tmp[$parentid])) {
                    $arr_tmp[$parentid]['children'][$id] = $item;
                    $arr_tmp[$id] = &$arr_tmp[$parentid]['children'][$id];
                }
            }
        }

        unset($arr_tmp);
        echo '<pre>';
        print_r($arr_tree);
        echo "</pre>";
    }
}
