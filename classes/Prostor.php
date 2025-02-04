<?php

class Prostor {
    private $id;
    private $naziv;
    private $kapacitet;
    private $cenaPoSatu;
    private $status;

    public function __construct($id, $naziv, $kapacitet, $cenaPoSatu, $status) {
        $this->id = $id;
        $this->naziv = $naziv;
        $this->kapacitet = $kapacitet;
        $this->cenaPoSatu = $cenaPoSatu;
        $this->status = $status;
    }

    public static function sviProstori($db, $sort = null) {
        $query = "SELECT * FROM prostor WHERE status = 'dostupno'";
        if ($sort == 'cena_asc') {
            $query .= " ORDER BY cena_po_satu ASC";
        } elseif ($sort == 'cena_desc') {
            $query .= " ORDER BY cena_po_satu DESC";
        } elseif ($sort == 'kapacitet_asc') {
            $query .= " ORDER BY kapacitet ASC";
        } elseif ($sort == 'kapacitet_desc') {
            $query .= " ORDER BY kapacitet DESC";
        }
        $result = $db->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>
