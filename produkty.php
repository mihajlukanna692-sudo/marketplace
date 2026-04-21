<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['login'])) {
    header("Location: logowanie.php");
    exit();
}

$login = $_SESSION['login'];
$user_id = $_SESSION['id'];


if (isset($_GET['kup'])) {

    $produkt_id = (int)$_GET['kup'];


    $stmt = mysqli_prepare($con, "SELECT user_id, status FROM produkty WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $produkt_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $produkt = mysqli_fetch_assoc($result);

    if (!$produkt) {
        die("Produkt nie istnieje");
    }

    if ($produkt['status'] == 'sprzedany') {
        die("Produkt już sprzedany");
    }

    if ($produkt['user_id'] == $user_id) {
        die("Nie możesz kupić własnego produktu");
    }

    $stmt = mysqli_prepare($con, "INSERT INTO zakupy (produkt_id, kupujacy_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ii", $produkt_id, $user_id);
    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($con, "UPDATE produkty SET status='sprzedany' WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $produkt_id);
    mysqli_stmt_execute($stmt);

    header("Location: produkty.php");
    exit();
}

$sql = "SELECT p.*, u.login 
        FROM produkty p 
        JOIN uzytkownicy u ON p.user_id = u.id";

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Produkty</title>
    <link rel="stylesheet" href="style.css">
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

<h3>Lista produktów</h3>

<div class="grid">

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

    <div class="card">

        <h4><?= htmlspecialchars($row['nazwa']) ?></h4>

      
        <p><?= htmlspecialchars($row['opis']) ?></p>

   
        <b><?= (float)$row['cena'] ?> zł</b>

        <p>Autor: <b><?= htmlspecialchars($row['login']) ?></b></p>

   
        <p>
            Status:
            <?php if ($row['status'] == 'dostepny') { ?>
                <span style="color:green;">dostepny</span>
            <?php } else { ?>
                <span style="color:red;">sprzedany</span>
            <?php } ?>
        </p>

        
        <?php if ($row['status'] == 'dostepny') { ?>

            <?php if ($row['user_id'] != $user_id) { ?>
                <a href="?kup=<?= $row['id'] ?>">Kup</a>
            <?php } else { ?>
                <button disabled>Twój produkt</button>
            <?php } ?>

        <?php } else { ?>
            <button disabled>Sprzedany</button>
        <?php } ?>

    </div>

<?php } ?>

</div>

</body>
</html>