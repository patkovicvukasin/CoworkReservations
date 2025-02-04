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
        if ($sort == 'kapacitet') {
            $query .= " ORDER BY kapacitet";
        } elseif ($sort == 'cena') {
            $query .= " ORDER BY cena_po_satu";
        }
        $result = $db->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>
