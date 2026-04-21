<?php
  require_once "db.php";

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
    <div class="rejestracja">
        <h2>Rejestracja</h2>
        <form action="rejestracja.php" method="POST">
        <label for="login">Login</label>
        <input type="text" id="login" name="login" required>
        <label for="haslo">Hasło</label>
        <input type="password" id="haslo" name="haslo" required>
        <label for="powtorz_haslo">Powtórz hasło</label>
        <input type="password" id="powtorz_haslo" name="powtorz_haslo">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required>
         <input type="submit" value="Zarejestruj się" name="zarejestruj">
</form>
        <h4>Masz już konto?</h4>
        <a href="logowanie.php">Zaloguj się</a>
    </div>
</body>
</html>
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['login']) && !empty($_POST['haslo']) && !empty($_POST['powtorz_haslo']) && !empty($_POST['email'])) {

        $login = $_POST['login'];
        $haslo = $_POST['haslo'];
        $powtorz_haslo = $_POST['powtorz_haslo'];
        $email = $_POST['email'];

     
        if ($haslo !== $powtorz_haslo) {
            die("Hasła są różne!");
        }

        if (strlen($haslo) < 8) {
            die("Hasło musi zawierać co najmniej 8 znaków!");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Niepoprawny email!");
        }

        $stmt = mysqli_prepare($con, "SELECT id FROM uzytkownicy WHERE login=?");
        mysqli_stmt_bind_param($stmt, "s", $login);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            die("Login jest już zajęty!");
        }

        $zaszyfrowane_haslo = password_hash($haslo, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($con, "INSERT INTO uzytkownicy (login, haslo, email) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $login, $zaszyfrowane_haslo, $email);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: logowanie.php");
            exit();
        } else {
            echo "Błąd rejestracji!";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($con);
    }
}
?>