<?php
require "lib\apriori\Apriori.php";
require "model\AprioriModel.php";

class AprioriController extends AprioriModel
{
    public function index()
    {
        $awal =  microtime(true);

        $minSupport = $_POST['min_support'];
        $minConfidence = $_POST['min_confidence'];

        $apriori = new AprioriAlgorithm();
        $dataTransaksi = $this->getTransaction();
        $dataProduk = $this->splitItemTransaction($dataTransaksi);
        $dataItemsets = $apriori->apriori($dataProduk, $dataTransaksi, $minSupport);
        $dataRules = $apriori->generateRule($dataItemsets, $dataTransaksi, $minConfidence);
        $akhir = microtime(true);
        $lama = $akhir - $awal;
        return [
            'produk' => $dataProduk,
            'transaksi' => $dataTransaksi,
            'dataItemsets' => $dataItemsets,
            'dataRules' => $dataRules,
            'lama' => $lama,
        ];
    }

    private function splitItemTransaction($data)
    {
        $dataProduk = [];
        foreach ($data as $key => $value) {
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
