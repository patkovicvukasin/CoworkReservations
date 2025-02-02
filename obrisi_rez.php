<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rezervacija_id'])) {
    include 'classes/Database.php';
    $db = new Database();
    $rezervacija_id = intval($_POST['rezervacija_id']);
    $userId = $_SESSION['user']['id'];
    // Provjeri da li rezervacija pripada korisniku prije brisanja
    $query = "DELETE FROM rezervacije WHERE id = ? AND korisnik_id = ?";
    $stmt = $db->conn->prepare($query);
    $stmt->bind_param("ii", $rezervacija_id, $userId);
    $stmt->execute();
}
header("Location: rezervacije.php");
exit();
?>
