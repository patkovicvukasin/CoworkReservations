<?php
session_start();
session_destroy(); // Uništava sve podatke sesije
header("Location: index.php"); // Preusmerava na početnu stranicu
exit();
?>
