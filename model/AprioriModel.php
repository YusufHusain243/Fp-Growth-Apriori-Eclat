<?php
require "../Connection.php";

class AprioriModel extends Connection
{
    private function processData($data)
    {
        $rows = [];
        while ($row = mysqli_fetch_assoc($data)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getAll()
    {
        $data = mysqli_query($this->connect(), "SELECT * FROM produk");
        return $this->processData($data);
    }

    public function getTransaction()
    {
        $data = mysqli_query($this->connect(), "SELECT
                                                    GROUP_CONCAT(produk.nama separator ', ') AS item
                                                FROM
                                                    detail_transaksi
                                                LEFT JOIN 
                                                    produk ON (detail_transaksi.id_produk = produk.id)
                                                GROUP BY detail_transaksi.id_transaksi");
        return $this->processData($data);
    }
}
