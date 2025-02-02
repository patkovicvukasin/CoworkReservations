<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

include 'classes/Database.php';
include 'classes/Rezervacija.php';

$db = new Database();
$userId = $_SESSION['user']['id'];
$rezervacije = Rezervacija::mojeRezervacije($userId, $db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Moje Rezervacije - Coworking Rezervacije</title>
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
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="page-title">
      <h1>Moje Rezervacije</h1>
      <p>Pregled svih vaših rezervacija.</p>
    </section>
    
    <section class="moje-rezervacije">
      <?php if (!empty($rezervacije)): ?>
        <table>
          <thead>
            <tr>
              <th>Naziv Prostora</th>
              <th>Datum</th>
              <th>Od</th>
              <th>Do</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rezervacije as $rez): ?>
              <tr>
                <td><?php echo htmlspecialchars($rez['prostor_naziv']); ?></td>
                <td><?php echo $rez['datum']; ?></td>
                <td><?php echo $rez['pocetno_vreme']; ?></td>
                <td><?php echo $rez['krajnje_vreme']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>Nema rezervacija.</p>
      <?php endif; ?>
    </section>
    
    <section class="nova-rezervacija">
      <form action="prostorije.php" method="get">
        <button type="submit" class="btn">Napravi novu rezervaciju</button>
      </form>
    </section>
    
  </main>
  <footer>
    <p>&copy; 2025 Cowork Reservations. Sva prava zadržana.</p>
  </footer>
</body>
</html>
