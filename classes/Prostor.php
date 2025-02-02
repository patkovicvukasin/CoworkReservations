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

    public static function sviProstori($db) {
        $query = "SELECT * FROM prostor WHERE status='dostupno'";
        $result = $db->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>
