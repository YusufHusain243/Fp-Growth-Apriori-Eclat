<?php
require "lib\apriori\Apriori.php";
require "model\AprioriModel.php";

class AprioriController extends AprioriModel
{
    //ini adalah function index untuk halaman apriori
    public function index()
    {
        //init waktu awal ketika run algoritma
        $start_time =  microtime(true);

        //set min support & min confidence
        $min_support = $_POST['min_support'];
        $min_confidence = $_POST['min_confidence'];

        //init apriori algorithm
        $apriori = new AprioriAlgorithm();
        //data transaksi
        $transactions_data = $this->getTransaction();
        //data produk
        $products_data = $this->splitItemTransaction($transactions_data);
        //data itemsets
        $itemsets_data = $apriori->itemsets($products_data, $transactions_data, $min_support);
        // data rules
        $rules_data = $apriori->generateRule($itemsets_data, $transactions_data, $min_confidence);

        //waktu akhir run algoritma
        $end_time = microtime(true);

        //lama waktu eksekusi
        $times = $end_time - $start_time;

        return [
            'products_data' => $products_data,
            'transactions_data' => $transactions_data,
            'itemsets_data' => $itemsets_data,
            'rules_data' => $rules_data,
            'times' => $times,
        ];
    }

    //ini adalah function untuk mengambil uniq produk dari data transaksi
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
