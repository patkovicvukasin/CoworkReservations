<?php
session_start();
include 'classes/Database.php';
include 'classes/Korisnik.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mejl = $_POST['mejl'];
    $sifra = $_POST['sifra'];
    
    $user = Korisnik::prijava($mejl, $sifra, $db);
    
    if ($user) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit();
    } else {
        $error = "Pogresan mejl ili šifra.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Prijava - Coworking Rezervacije</title>
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
        <li><a href="register.php">Registracija</a></li>
      </ul>
    </nav>
  </header>
  
  <div class="container">
    <h1>Prijava</h1>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form action="login.php" method="post">
      <label for="mejl">Mejl</label>
      <input type="email" id="mejl" name="mejl" required>
      
      <label for="sifra">Šifra</label>
      <input type="password" id="sifra" name="sifra" required>
      
      <button type="submit">Prijavi se</button>
    </form>
    <p>Nemate nalog? <a href="register.php">Registrujte se</a></p>
  </div>
  
  <footer>
    <p>&copy; 2025 Coworking Rezervacije. Sva prava zadržana.</p>
  </footer>
</body>
</html>
