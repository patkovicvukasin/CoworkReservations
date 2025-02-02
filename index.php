<?php 
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cowork Reservations</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header>
    <div class="logo">
      <!-- Postavi odgovarajuću sliku u images folderu -->
      <img src="images/logo.png" alt="Cowork Reservations">
    </div>
    <nav>
      <ul>
        <?php if(isset($_SESSION['user'])): ?>
          <li><a href="prostorije.php">Prostori</a></li>
          <li><a href="rezervacije.php">Moje Rezervacije</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Prijava</a></li>
          <li><a href="register.php">Registracija</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>
  <main>
  <section class="hero">
      <?php if(isset($_SESSION['user'])): ?>
        <h1>Dobrodošli u Cowork Reservations!</h1>
        <p>Drago nam je da ste ponovo tu. Pregledajte dostupne prostore i zakažite svoj termin.</p>
        <div class="cta">
          <a href="prostorije.php" class="btn">Pogledaj Prostore</a>
          <a href="rezervacije.php" class="btn">Moje Rezervacije</a>
        </div>
      <?php else: ?>
        <h1>Dobrodošli u Cowork Reservations</h1>
        <p>Rezervišite svoj omiljeni coworking prostor i radni sto brzo i jednostavno. Prijavite se ili registrujte da biste započeli!</p>
        <div class="cta">
          <a href="login.php" class="btn">Prijavi se</a>
          <a href="register.php" class="btn">Registruj se</a>
        </div>
      <?php endif; ?>
    </section>
    <section class="info">
      <h2>O nama</h2>
      <p>Naš sistem omogućava jednostavno upravljanje coworking prostorima. Pregledajte dostupne prostore, zakazujte termine i uživajte u produktivnom radu!</p>
    </section>
  </main>
  <footer>
    <p>&copy; 2025 Cowork Reservations. Sva prava zadržana.</p>
  </footer>
</body>
</html>
