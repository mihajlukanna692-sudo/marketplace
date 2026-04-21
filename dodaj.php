<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['login'])) {
    die("Musisz być zalogowany!");
}

$login = $_SESSION['login'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nazwa = $_POST['nazwa'];
    $opis = $_POST['opis'];
    $cena = $_POST['cena'];
    $user_id = $_SESSION['id'];

    $stmt = mysqli_prepare($con,
        "INSERT INTO produkty (nazwa, opis, cena, user_id, status)
         VALUES (?, ?, ?, ?, 'dostepny')"
    );

    mysqli_stmt_bind_param($stmt, "ssdi", $nazwa, $opis, $cena, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: produkty.php");
        exit();
    } else {
        echo "Błąd dodawania produktu!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj produkt</title>
    <link rel="stylesheet" href="styl1.css">
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

<div class="produkt">
    <form method="post" id="produktForm">
        <h2>Dodaj produkt</h2>

        <label>Nazwa:</label>
        <input type="text" name="nazwa" required>

        <label>Opis:</label>
        <textarea name="opis"></textarea>

        <label>Cena:</label>
        <input type="text" name="cena" required>

        <input type="submit" value="Dodaj produkt">
    </form>
    <div id="error" style="color:red;"></div>
</div>
<script src="script.js"></script>
</body>
</html>