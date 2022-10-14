<?php
require "lib\Fp-growth\FpGrowth.php";
require "model\FpGrowthModel.php";

class FpGrowthController extends FpGrowthModel
{
    public function index()
    {
        $minSupport = $_POST['min_support'];
        $minConfidence = $_POST['min_confidence'];

        $fpGrowth = new FpGrowth();
        $dataTransaksi = $this->getTransaction();
        $dataProduk = $this->splitItemTransaction($dataTransaksi);
        $freqItemSet = $fpGrowth->freqItemSet($dataProduk, $dataTransaksi, $minSupport);
        $sortByPriority = $fpGrowth->sortByPriority($freqItemSet);
        $sortItemByPriority = $fpGrowth->sortItemByPriority($dataTransaksi, $sortByPriority);
        return [
            'produk' => $dataProduk,
            'transaksi' => $dataTransaksi,
            'freqItemSet' => $freqItemSet,
            'sortByPriority' => $sortByPriority,
            'sortItemByPriority' => $sortItemByPriority,
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
