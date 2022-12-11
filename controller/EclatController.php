<?php
require "lib\Eclat\Eclat.php";
require "model\EclatModel.php";

class EclatController extends EclatModel
{
    public function index()
    {
        $awal =  microtime(true);

        $minSupport = $_POST['min_support'];
        $minConfidence = $_POST['min_confidence'];

        $eclat = new Eclat();

        $dataTransaksi = $this->getTransaction();
        $dataProduk = $this->splitItemTransaction($dataTransaksi);
        $vertikalDataFormat = $eclat->vertikalDataFormat($dataProduk, $dataTransaksi);
        $itemsets = $eclat->itemsets($vertikalDataFormat, $dataTransaksi, $minSupport);
        $generateRules = $eclat->generateRule($itemsets, $dataTransaksi, $minConfidence);
        // print_r(json_encode($generateRules));
        $akhir = microtime(true);
        $lama = $akhir - $awal;
        return [
            'produk' => $dataProduk,
            'transaksi' => $dataTransaksi,
            'vertikalDataFormat' => $vertikalDataFormat,
            'itemsets' => $itemsets,
            'generateRules' => $generateRules,
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
