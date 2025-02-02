<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_GET['rezervacija_id'])) {
    header("Location: rezervacije.php");
    exit();
}
$rezervacija_id = intval($_GET['rezervacija_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Potvrda brisanja rezervacije</title>
  <link rel="stylesheet" href="css/styles.css">
  <!-- Font Awesome za ikonicu, ako već nije uključen -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="images/logo.png" alt="Logo" style="filter: brightness(0) invert(1);">
    </div>
    <nav>
      <ul>
        <li><a href="rezervacije.php">Nazad na rezervacije</a></li>
      </ul>
    </nav>
  </header>
  <main class="main-container">
    <section class="page-title">
      <h1>Potvrda brisanja rezervacije</h1>
    </section>
    <section class="confirmation" style="text-align: center; margin: 40px auto;">
      <p style="font-size: 1.2rem; margin-bottom: 30px;">Da li ste sigurni da želite da izbrišete ovu rezervaciju?</p>
      <form action="obrisi_rez.php" method="post" style="display: inline-block; margin-right: 20px;">
          <input type="hidden" name="rezervacija_id" value="<?php echo $rezervacija_id; ?>">
          <button type="submit" class="btn">Da, izbriši</button>
      </form>
      <form action="rezervacije.php" method="get" style="display: inline-block;">
          <button type="submit" class="btn">Ne, odustani</button>
      </form>
    </section>
  </main>
  <footer>
    <p>&copy; 2025 Cowork Reservations. Sva prava zadržana.</p>
  </footer>
</body>
</html>
