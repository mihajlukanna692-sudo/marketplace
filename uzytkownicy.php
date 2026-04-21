<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['login'])) {
    die("Zaloguj się!");
}

$login = $_SESSION['login'];

$sql = "SELECT login, email FROM uzytkownicy";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Użytkownicy</title>
     <link rel="stylesheet" href="styl2.css">
</head>
<body>

<header>
    <div class="nawigacja">
        <a href="produkty.php">Produkty</a>
        <a href="dodaj.php">Dodaj produkt</a>
        <a href="uzytkownicy.php">Użytkownicy</a>
    </div>

    <div class="uzytkownik">
        <h3><?= htmlspecialchars($login) ?></h3>
        <a href="wyloguj.php">Wyloguj się</a>
    </div>
</header>

<h2>Użytkownicy</h2>

<div class="user-list">

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

    <div class="user-card">
        <div class="user-name">
            <?= htmlspecialchars($row['login']) ?>
        </div>

        <div class="user-email">
            <?= htmlspecialchars($row['email']) ?>
        </div>
    </div>

<?php } ?>

</div>

</body>
</html>