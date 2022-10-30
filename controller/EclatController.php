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
        $itemsetOne = $eclat->itemsetOne($vertikalDataFormat, count($dataTransaksi), $minSupport);
        $itemsetTwo = $eclat->itemsetTwo($itemsetOne, count($dataTransaksi), $minSupport);
        $itemsetThree = $eclat->itemsetThree($itemsetOne, count($dataTransaksi), $minSupport);
        $ruleTwoItem = $eclat->ruleTwoItem($itemsetOne, $itemsetTwo, count($dataTransaksi), $minConfidence);
        $ruleThreeItem = $eclat->ruleThreeItem($itemsetOne, $itemsetTwo, $itemsetThree, count($dataTransaksi), $minConfidence);
        $akhir = microtime(true);
        $lama = $akhir - $awal;
        return [
            'produk' => $dataProduk,
            'transaksi' => $dataTransaksi,
            'vertikalDataFormat' => $vertikalDataFormat,
            'itemsetOne' => $itemsetOne,
            'itemsetTwo' => $itemsetTwo,
            'itemsetThree' => $itemsetThree,
            'ruleTwoItem' => $ruleTwoItem,
            'ruleThreeItem' => $ruleThreeItem,
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
