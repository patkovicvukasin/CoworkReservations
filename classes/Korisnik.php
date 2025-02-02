<?php

class Korisnik {
    private $id;
    private $ime;
    private $prezime;
    private $mejl;
    private $sifra;

    public function __construct($id, $ime, $prezime, $mejl, $sifra) {
        $this->id = $id;
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->mejl = $mejl;
        $this->sifra = $sifra;
    }

    public static function registracija($ime, $prezime, $mejl, $sifra, $db) {
        $hashed_sifra = password_hash($sifra, PASSWORD_DEFAULT);
        $query = "INSERT INTO korisnik (ime, prezime, mejl, sifra) VALUES (?, ?, ?, ?)";
        $stmt = $db->conn->prepare($query);
        $stmt->bind_param("ssss", $ime, $prezime, $mejl, $hashed_sifra);
        return $stmt->execute();
    }

    public static function prijava($mejl, $sifra, $db) {
        $query = "SELECT * FROM korisnik WHERE mejl = ?";
        $stmt = $db->conn->prepare($query);
        $stmt->bind_param("s", $mejl);
        $stmt->execute();
        $result = $stmt->get_result();
        $korisnik = $result->fetch_assoc();

        if ($korisnik && password_verify($sifra, $korisnik['sifra'])) {
            return $korisnik;
        }
        return false;
    }
}

?>
