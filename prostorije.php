<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

include 'classes/Database.php';
include 'classes/Prostor.php';

$db = new Database();
$sort = isset($_GET['sort']) ? $_GET['sort'] : null;
$prostori = Prostor::sviProstori($db, $sort);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dostupni Prostori - Cowork Reservations</title>
  <link rel="stylesheet" href="css/styles.css">
  <!-- Opcionalno: možeš dodati i font awesome ako već nije uključen -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

    <!-- Dropdown meni za sortiranje -->
    <section class="sorting-options" style="text-align: center; margin-bottom: 20px;">
      <form method="GET" id="sortForm">
        <select name="sort" onchange="this.form.submit()">
          <option value="" <?php if (!$sort) echo 'selected'; ?>>-- Sortiraj po --</option>
          <option value="cena_asc" <?php if ($sort == 'cena_asc') echo 'selected'; ?>>Cena rastući</option>
          <option value="cena_desc" <?php if ($sort == 'cena_desc') echo 'selected'; ?>>Cena opadajući</option>
          <option value="kapacitet_asc" <?php if ($sort == 'kapacitet_asc') echo 'selected'; ?>>Kapacitet rastući</option>
          <option value="kapacitet_desc" <?php if ($sort == 'kapacitet_desc') echo 'selected'; ?>>Kapacitet opadajući</option>
        </select>
      </form>
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
            <p><strong>Adresa:</strong> <?php echo htmlspecialchars($prostor['adresa']); ?></p>
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
