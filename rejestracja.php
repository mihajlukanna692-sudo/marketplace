<?php
  require_once "db.php";

?>
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['login']) && !empty($_POST['haslo']) && !empty($_POST['powtorz_haslo']) && !empty($_POST['email'])) {

       $login = trim($_POST['login'] ?? '');
        $haslo = trim($_POST['haslo'] ?? '');
        $powtorz_haslo = trim($_POST['powtorz_haslo'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (empty($login) || empty($haslo) || empty($powtorz_haslo) || empty($email)) {
            $error = "Wszystkie pola są wymagane.";
        } elseif (strlen($login) < 3 || strlen($login) > 50) {
            $error = "Login musi mieć 3–50 znaków.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $login)) {
            $error = "Login może zawierać tylko litery, cyfry i _.";
        } elseif ($haslo !== $powtorz_haslo) {
            $error = "Hasła są różne.";
        } elseif (strlen($haslo) < 8) {
            $error = "Hasło min. 8 znaków.";
        } elseif (!preg_match('/[A-Z]/', $haslo)) {
            $error = "Hasło musi mieć dużą literę.";
        } elseif (!preg_match('/[0-9]/', $haslo)) {
            $error = "Hasło musi mieć cyfrę.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Niepoprawny email.";
        } elseif (strlen($email) > 100) {
            $error = "Email za długi.";
        } else {

            $stmt = mysqli_prepare($con, "SELECT id FROM uzytkownicy WHERE login=? OR email=?");
            mysqli_stmt_bind_param($stmt, "ss", $login, $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $error = "Login lub email jest już zajęty.";
            } else {

                $hash = password_hash($haslo, PASSWORD_DEFAULT);

                $stmt = mysqli_prepare($con, "INSERT INTO uzytkownicy (login, haslo, email) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sss", $login, $hash, $email);

                if (mysqli_stmt_execute($stmt)) {
                    header("Location: logowanie.php");
                    exit();
                } else {
                    $error = "Błąd rejestracji.";
                }
            }

            mysqli_stmt_close($stmt);
            mysqli_close($con);
        }
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
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
</body>
</html>
