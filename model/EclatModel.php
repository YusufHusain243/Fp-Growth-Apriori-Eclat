<?php
require "Connection.php";

class EclatModel extends Connection
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
                                                    transaksi.id,
                                                    GROUP_CONCAT(produk.nama separator ', ') AS item
                                                FROM
                                                    detail_transaksi
                                                INNER JOIN 
                                                    produk ON (detail_transaksi.id_produk = produk.id)
                                                INNER JOIN 
                                                    transaksi ON (detail_transaksi.id_transaksi = transaksi.id)
                                                GROUP BY detail_transaksi.id_transaksi");
        return $this->processData($data);
    }
}
