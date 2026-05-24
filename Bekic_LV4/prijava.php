<?php
session_start();

include 'includes/db.php';

$poruka = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $korisnicko_ime = trim($_POST["korisnicko_ime"]);
    $lozinka = trim($_POST["lozinka"]);

    $upit = $pdo->prepare("
        SELECT * FROM korisnici
        WHERE korisnicko_ime = ?
    ");

    $upit->execute([$korisnicko_ime]);

    $korisnik = $upit->fetch();

    if ($korisnik && password_verify($lozinka, $korisnik["lozinka"])) {

        $_SESSION["korisnik_id"] = $korisnik["id"];
        $_SESSION["korisnicko_ime"] = $korisnik["korisnicko_ime"];

        header("Location: index.php");
        exit();

    } else {

        $poruka = "Pogrešno korisničko ime ili lozinka.";
    }
}
?>

<!DOCTYPE html>
<html lang="hr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Prijava</title>

    <link rel="stylesheet" href="auth.css">

</head>

<body class="auth-page">

<div class="auth-box">
    <?php if(isset($_GET["registracija"])): ?>

        <p class="success-message">
            Registracija uspješna. Prijavite se.
        </p>

    <?php endif; ?>

    <h1>Prijava</h1>

    <form method="POST">

        <label>Korisničko ime</label>

        <input type="text"
               name="korisnicko_ime"
               required>

        <label>Lozinka</label>

        <input type="password"
               name="lozinka"
               required>

        <button type="submit">
            Prijavi se
        </button>

    </form>

    <p class="auth-link">

        Nemaš račun?

        <a href="registracija.php">
            Registriraj se
        </a>

    </p>

    <?php if(!empty($poruka)): ?>

        <p class="auth-message">
            <?php echo $poruka; ?>
        </p>

    <?php endif; ?>

</div>

</body>
</html>