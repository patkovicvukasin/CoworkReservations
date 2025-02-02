<?php

class Rezervacija {
    private $id;
    private $korisnikId;
    private $prostorId;
    private $datum;
    private $pocetnoVreme;
    private $krajnjeVreme;

    public function __construct($id, $korisnikId, $prostorId, $datum, $pocetnoVreme, $krajnjeVreme) {
        $this->id = $id;
        $this->korisnikId = $korisnikId;
        $this->prostorId = $prostorId;
        $this->datum = $datum;
        $this->pocetnoVreme = $pocetnoVreme;
        $this->krajnjeVreme = $krajnjeVreme;
    }

    public static function napraviRezervaciju($korisnikId, $prostorId, $datum, $pocetnoVreme, $krajnjeVreme, $db) {
        // Provjera da li postoji rezervacija za isti prostor, datum i termin
        $query_check = "SELECT * FROM rezervacije WHERE prostor_id = ? AND datum = ? AND pocetno_vreme = ? AND krajnje_vreme = ?";
        $stmt_check = $db->conn->prepare($query_check);
        $stmt_check->bind_param("isss", $prostorId, $datum, $pocetnoVreme, $krajnjeVreme);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if($result_check->num_rows > 0) {
            return false; // Termin je već rezervisan
        }
        // Unos nove rezervacije
        $query = "INSERT INTO rezervacije (korisnik_id, prostor_id, datum, pocetno_vreme, krajnje_vreme) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->conn->prepare($query);
        $stmt->bind_param("iisss", $korisnikId, $prostorId, $datum, $pocetnoVreme, $krajnjeVreme);
        return $stmt->execute();
    }

    public static function mojeRezervacije($korisnikId, $db) {
        $query = "SELECT r.*, p.naziv AS prostor_naziv, p.adresa AS prostor_adresa 
                  FROM rezervacije r 
                  JOIN prostor p ON r.prostor_id = p.id 
                  WHERE r.korisnik_id = ?";
        $stmt = $db->conn->prepare($query);
        $stmt->bind_param("i", $korisnikId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
}

?>
