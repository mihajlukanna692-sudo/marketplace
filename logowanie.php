<?php
  session_start();
?>

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
    </div>
</body>
</html>


 <?php
   if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['login']) && !empty($_POST['haslo'])) {

    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    
    $stmt = mysqli_prepare($con, "SELECT id, haslo FROM uzytkownicy WHERE login=?");
    mysqli_stmt_bind_param($stmt, "s", $login);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        if (password_verify($haslo, $row['haslo'])) {

            $_SESSION['id'] = $row['id'];
            $_SESSION['login'] = $login;

            header("Location: produkty.php");
            exit();

        } else {
            echo "Błędne hasło!";
        }

    } else {
        echo "Nie ma takiego loginu!";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
    ?>
