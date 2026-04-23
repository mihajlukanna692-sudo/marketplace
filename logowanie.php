<?php
session_start();
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = trim($_POST['login'] ?? '');
    $haslo = trim($_POST['haslo'] ?? '');

    if (empty($login) || empty($haslo)) {
        $error = "Wszystkie pola są wymagane.";
    } elseif (strlen($login) < 3 || strlen($login) > 50) {
        $error = "Login musi mieć od 3 do 50 znaków.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $login)) {
        $error = "Login może zawierać tylko litery, cyfry i _";
    } elseif (strlen($haslo) < 6) {
        $error = "Hasło musi mieć co najmniej 6 znaków.";
    } else {

        
        $stmt = mysqli_prepare($con, "SELECT id, haslo FROM uzytkownicy WHERE login=?");
        mysqli_stmt_bind_param($stmt, "s", $login);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {

            if (password_verify($haslo, $row['haslo'])) {

                $_SESSION['id'] = $row['id'];
                $_SESSION['login'] = $login;

                header("Location: produkty.php");
                exit();

            }
        }

        $error = "Nieprawidłowy login lub hasło.";

        mysqli_stmt_close($stmt);
        mysqli_close($con);
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <div class="logowanie">
         <h2>Logowanie</h2>
        <form action="logowanie.php" method="POST">
        <label for="login">Login</label>
        <input type="text" id="login" name="login" required>
        <label for="haslo">Hasło</label>
        <input type="password" id="haslo" name="haslo" required>
        <input type="submit" value="Zaloguj się" name="zaloguj">
</form>

        <h4>Nie masz konta?</h4>
        <a href="rejestracja.php">Zarejestruj się</a>
         <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
</body>
</html>

