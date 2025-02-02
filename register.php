<?php
include 'classes/Database.php';
include 'classes/Korisnik.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $mejl = $_POST['mejl'];
    $sifra = $_POST['sifra'];
    
    $success = Korisnik::registracija($ime, $prezime, $mejl, $sifra, $db);
    
    if ($success) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Registracija nije uspela. Pokušajte ponovo.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registracija - Coworking Rezervacije</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="images/logo.png" alt="Logo">
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Početna</a></li>
        <li><a href="login.php">Prijava</a></li>
      </ul>
    </nav>
  </header>
  
  <div class="container">
    <h1>Registracija</h1>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form action="register.php" method="post">
      <label for="ime">Ime</label>
      <input type="text" id="ime" name="ime" required>
      
      <label for="prezime">Prezime</label>
      <input type="text" id="prezime" name="prezime" required>
      
      <label for="mejl">Mejl</label>
      <input type="email" id="mejl" name="mejl" required>
      
      <label for="sifra">Šifra</label>
      <input type="password" id="sifra" name="sifra" required>
      
      <button type="submit">Registruj se</button>
    </form>
    <p>Već imate nalog? <a href="login.php">Prijavite se</a></p>
  </div>
  
  <footer>
    <p>&copy; 2025 Coworking Rezervacije. Sva prava zadržana.</p>
  </footer>
</body>
</html>
