<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

include 'classes/Database.php';
include 'classes/Prostor.php';

$db = new Database();
$prostori = Prostor::sviProstori($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dostupni Prostori - Cowork Reservations</title>
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
        <li><a href="rezervacije.php">Moje Rezervacije</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="page-title">
      <h1>Dostupni Prostori</h1>
      <p>Izaberite prostor da vidite detalje i rezervišete termin.</p>
    </section>
    <section class="prostori">
      <?php if (!empty($prostori)): ?>
        <?php foreach ($prostori as $prostor): ?>
          <div class="prostor-card">
            <h2><?php echo htmlspecialchars($prostor['naziv']); ?></h2>
            <?php if(isset($prostor['slika']) && !empty($prostor['slika'])): ?>
              <img src="images/<?php echo htmlspecialchars($prostor['slika']); ?>" alt="<?php echo htmlspecialchars($prostor['naziv']); ?>" class="prostor-thumb">
            <?php endif; ?>
            <p><strong>Kapacitet:</strong> <?php echo $prostor['kapacitet']; ?> osoba</p>
            <p><strong>Cena po satu:</strong> <?php echo $prostor['cena_po_satu']; ?> RSD</p>
            <a href="detalji.php?prostor_id=<?php echo $prostor['id']; ?>" class="btn">Pogledaj Detalje</a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Nema dostupnih prostora u ovom trenutku.</p>
      <?php endif; ?>
    </section>
  </main>
  <footer>
    <p>&copy; 2025 Cowork Reservations. Sva prava zadržana.</p>
  </footer>
</body>
</html>
