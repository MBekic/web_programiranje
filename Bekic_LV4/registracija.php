<?php
session_start();

include 'includes/db.php';

$poruka = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $korisnicko_ime = trim($_POST["korisnicko_ime"]);
    $lozinka = trim($_POST["lozinka"]);
    $potvrda_lozinke = trim($_POST["potvrda_lozinke"]);

    if (
        empty($korisnicko_ime) ||
        empty($lozinka) ||
        empty($potvrda_lozinke)
    ) {

        $poruka = "Sva polja su obavezna.";

    } elseif ($lozinka !== $potvrda_lozinke) {

        $poruka = "Lozinke se ne podudaraju.";

    } else {

        $provjera = $pdo->prepare("
            SELECT * FROM korisnici
            WHERE korisnicko_ime = ?
        ");

        $provjera->execute([$korisnicko_ime]);

        if ($provjera->rowCount() > 0) {

            $poruka = "Korisničko ime već postoji.";

        } else {

            $hashirana_lozinka = password_hash(
                $lozinka,
                PASSWORD_DEFAULT
            );

            $upit = $pdo->prepare("
                INSERT INTO korisnici
                (korisnicko_ime, lozinka)
                VALUES (?, ?)
            ");

            $upit->execute([
            $korisnicko_ime,
            $hashirana_lozinka
        ]);

        header("Location: prijava.php?registracija=uspjesna");
        exit();

            $poruka = "Registracija uspješna!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Registracija</title>

    <link rel="stylesheet" href="auth.css">

</head>

<body class="auth-page">

<div class="auth-box">

    <h1>Registracija</h1>

    <form method="POST">

        <label>Korisničko ime</label>

        <input type="text"
               name="korisnicko_ime"
               required>

        <label>Lozinka</label>

        <input type="password"
               name="lozinka"
               required>

        <label>Potvrdi lozinku</label>

        <input type="password"
               name="potvrda_lozinke"
               required>

        <button type="submit">
            Registriraj se
        </button>

    </form>

    <p class="auth-link">

        Već imaš račun?

        <a href="prijava.php">
            Prijavi se
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