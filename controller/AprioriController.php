<?php
require "lib\apriori\Apriori.php";
require "model\AprioriModel.php";

class AprioriController extends AprioriModel
{
    public function index()
    {
        $minSupport = $_POST['min_support'];

        $apriori = new Apriori();

        $dataTransaksi = [];
        if (($open = fopen("dataset sakuyan2.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $temp['item'] = implode($data);
                $dataTransaksi[] = $temp;
            }

            fclose($open);
        }

        // $dataTransaksi = $this->getTransaction();
        // echo "<pre>";
        // var_dump($dataTransaksi);
        // echo "</pre>";
        // die;

        $dataProduk = $this->splitItemTransaction($dataTransaksi);
        $dataItemOne = $apriori->itemSetOne($dataProduk, $dataTransaksi, $minSupport);
        $dataItemTwo = $apriori->itemSetTwo($dataItemOne, $dataTransaksi, $minSupport);
        $dataItemThree = $apriori->itemSetThree($dataItemOne, $dataTransaksi, $minSupport);
        $ruleTwoItem = $apriori->ruleTwoItem($dataItemOne, $dataItemTwo, count($dataTransaksi));
        $ruleThreeItem = $apriori->ruleThreeItem($dataItemOne, $dataItemTwo, $dataItemThree, count($dataTransaksi));
        return [
            'produk' => $dataProduk,
            'transaksi' => $dataTransaksi,
            'dataItemOne' => $dataItemOne,
            'dataItemTwo' => $dataItemTwo,
            'dataItemThree' => $dataItemThree,
            'ruleTwoItem' => $ruleTwoItem,
            'ruleThreeItem' => $ruleThreeItem,
        ];
    }

    private function splitItemTransaction($data)
    {
        $dataProduk = [];
        foreach ($data as $key => $value) {
            $item = explode(' ', $value['item']);
            // print_r($item);
            // die;
            for ($i = 0; $i < count($item); $i++) {
                if (!in_array($item[$i], $dataProduk)) {
                    $dataProduk[] = $item[$i];
                }
            }
        }
        return $dataProduk;
    }
}
