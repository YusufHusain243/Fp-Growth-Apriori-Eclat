<?php

use Renaldy\PhpFPGrowth\FPGrowth;

require "vendor\autoload.php";
require "model\FpGrowthModel.php";
require "lib\Fp-Growth\FpGrowth2.php";

class FpGrowthController extends FpGrowthModel
{
    public function index()
    {
        $awal =  microtime(true);

        $minSupport = $_POST['min_support'];
        $minConfidence = $_POST['min_confidence'];
        $getTransaction = $this->getTransaction();
        $product = $this->splitItemTransaction($getTransaction);
        // print_r(json_encode($product));
        $fpgrowth = new FpGrowth2();
        $freqItemSet = $fpgrowth->freqItemSet($product, $getTransaction);
        // print_r(json_encode($freqItemSet));
        $sortByPriority = $fpgrowth->sortByPriority($freqItemSet);
        // print_r(json_encode($sortByPriority));
        $sortItemByPriority = $fpgrowth->sortItemByPriority($getTransaction, $sortByPriority);
        print_r(json_encode($sortItemByPriority));
        // $tree = $fpgrowth->fpTree();
        // print_r(json_encode($tree));
        // $fpgrowth = new FPGrowth2($transactions, $minSupport, $minConfidence);
        // $fpgrowth->run();

        // $freqItemSet = $fpgrowth->getFrequentItemSet();
        // $orderItemSet = $fpgrowth->getOrderedItemSet();
        // $fpTree = $fpgrowth->getTree();
        // $patterns = $fpgrowth->getPatterns();
        // $rules = $fpgrowth->getRules();

        // $akhir = microtime(true);
        // $lama = $akhir - $awal;

        // return [
        //     'transaksi' => $getTransaction,
        //     'freqItemSet' => $freqItemSet,
        //     'orderItemSet' => $orderItemSet,
        //     'fpTree' => $fpTree,
        //     'patterns' => $patterns,
        //     'rules' => $rules,
        //     'lama' => $lama,
        // ];
    }

    // private function formatDataTransactions($getTransactions)
    // {
    //     $transactions = [];
    //     foreach ($getTransactions as $value) {
    //         $temp = [];
    //         $item = explode(', ', $value['item']);
    //         foreach ($item as $value2) {
    //             $temp[] = $value2;
    //         }
    //         $transactions[] = $temp;
    //     }
    //     return $transactions;
    // }

    private function splitItemTransaction($data)
    {
        $dataProduk = [];
        foreach ($data as $value) {
            $item = explode(', ', $value['item']);
            for ($i = 0; $i < count($item); $i++) {
                if (!in_array($item[$i], $dataProduk)) {
                    $dataProduk[] = $item[$i];
                }
            }
        }
        return $dataProduk;
    }
}
