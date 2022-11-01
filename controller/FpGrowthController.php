<?php

use Renaldy\PhpFPGrowth\FPGrowth;

require "vendor\autoload.php";
require "model\FpGrowthModel.php";

class FpGrowthController extends FpGrowthModel
{
    public function index()
    {
        $awal =  microtime(true);

        $minSupport = $_POST['min_support'];
        $minConfidence = $_POST['min_confidence'];
        $getTransaction = $this->getTransaction();
        $transactions = $this->formatDataTransactions($getTransaction);

        $fpgrowth = new FPGrowth($transactions, $minSupport, $minConfidence);
        $fpgrowth->run();

        $freqItemSet = $fpgrowth->getFrequentItemSet();
        $orderItemSet = $fpgrowth->getOrderedItemSet();
        $fpTree = $fpgrowth->getTree();
        $patterns = $fpgrowth->getPatterns();
        $rules = $fpgrowth->getRules();

        $akhir = microtime(true);
        $lama = $akhir - $awal;

        return [
            'transaksi' => $getTransaction,
            'freqItemSet' => $freqItemSet,
            'orderItemSet' => $orderItemSet,
            'fpTree' => $fpTree,
            'patterns' => $patterns,
            'rules' => $rules,
            'lama' => $lama,
        ];
    }

    private function formatDataTransactions($getTransactions)
    {
        $transactions = [];
        foreach ($getTransactions as $value) {
            $temp = [];
            $item = explode(', ', $value['item']);
            foreach ($item as $value2) {
                $temp[] = $value2;
            }
            $transactions[] = $temp;
        }
        return $transactions;
    }
}
