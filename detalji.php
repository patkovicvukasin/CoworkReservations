<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

include 'classes/Database.php';
include 'classes/Prostor.php';
include 'classes/Rezervacija.php';

$db = new Database();

// Provjera GET parametra i dohvaćanje podataka o prostoru
if (isset($_GET['prostor_id'])) {
  $prostor_id = intval($_GET['prostor_id']);
  $query = "SELECT * FROM prostor WHERE id = ?";
  $stmt = $db->conn->prepare($query);
  $stmt->bind_param("i", $prostor_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $prostor = $result->fetch_assoc();
  if (!$prostor) {
    die("Prostor nije pronađen.");
  }
} else {
  die("Prostor nije izabran.");
}

// Obrada rezervacije – sva polja su required u HTML formi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $datum = $_POST['datum'];
  $pocetno_vreme = $_POST['pocetno_vreme'];
  $krajnje_vreme = $_POST['krajnje_vreme'];
  $userId = $_SESSION['user']['id'];
  $success = Rezervacija::napraviRezervaciju($userId, $prostor_id, $datum, $pocetno_vreme, $krajnje_vreme, $db);
  if ($success) {
    $msg = "Rezervacija je uspješno kreirana!";
  } else {
    $error = "Termin je već rezervisan ili je došlo do greške.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detalji Prostora - <?php echo htmlspecialchars($prostor['naziv']); ?></title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="images/logo.png" alt="Logo" style="filter: brightness(0) invert(1);">
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Početna</a></li>
        <li><a href="prostorije.php">Prostori</a></li>
        <li><a href="rezervacije.php">Moje Rezervacije</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="page-title">
      <h1><?php echo htmlspecialchars($prostor['naziv']); ?></h1>
    </section>
    
    <section class="detalji-container">
      <div class="detalji-info">
        <?php if(isset($prostor['slika']) && !empty($prostor['slika'])): ?>
          <img src="images/<?php echo htmlspecialchars($prostor['slika']); ?>" alt="<?php echo htmlspecialchars($prostor['naziv']); ?>">
        <?php endif; ?>
        <p><strong>Kapacitet:</strong> <?php echo $prostor['kapacitet']; ?> osoba</p>
        <p><strong>Cena po satu:</strong> <?php echo $prostor['cena_po_satu']; ?> RSD</p>
        <!-- Dodaj opis prostora, eventualno više teksta -->
        <p>Ovaj prostor je idealan za timski rad, sastanke i kreativne radionice. Uživajte u modernom ambijentu i svim pogodnostima coworking prostora.</p>
      </div>
      <div class="rezervacija-forma">
        <h2>Rezerviši Termin</h2>
        <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="detalji.php?prostor_id=<?php echo $prostor_id; ?>" method="post">
          <label for="datum">Datum (YYYY-MM-DD)</label>
          <input type="date" id="datum" name="datum" required>
          
          <label for="pocetno_vreme">Od (HH:MM)</label>
          <input type="time" id="pocetno_vreme" name="pocetno_vreme" required>
          
          <label for="krajnje_vreme">Do (HH:MM)</label>
          <input type="time" id="krajnje_vreme" name="krajnje_vreme" required>
          
          <button type="submit">Rezerviši</button>
        </form>
        <?php if(isset($msg)) { echo "<p class='success'>$msg</p>"; } ?>
      </div>
    </section>
  </main>
  <footer>
    <p>&copy; 2025 Cowork Reservations. Sva prava zadržana.</p>
  </footer>
</body>
</html>
