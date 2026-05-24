<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="hr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="description"
          content="Top 10 pjesama iz Music Info baze podataka uz pregled i analizu.">

    <link rel="stylesheet" href="style.css">

    <title>LV4 Web aplikacija</title>

</head>

<body>

<header>

    <div class="header-top">

        <h1>Top 10 pjesama</h1>

        <?php if(isset($_SESSION["korisnicko_ime"])): ?>

            <div class="user-info">

                <span>
                    Prijavljeni korisnik:
                    <strong>
                        <?php echo $_SESSION["korisnicko_ime"]; ?>
                    </strong>
                </span>

                <a class="logout-link" href="odjava.php">
                    Odjava
                </a>

            </div>

        <?php endif; ?>

    </div>

    <nav>

        <a href="index.php">Početna</a>

        <a href="glazba.php">Glazba</a>

        <a href="dodaj_pjesmu.php">Dodaj pjesmu</a>

        <a href="playlista.php">Moja playlista</a>

        <a href="galerija.php">Galerija</a>

        <?php if(!isset($_SESSION["korisnicko_ime"])): ?>

            <a href="prijava.php">Prijava</a>

            <a href="registracija.php">Registracija</a>

        <?php endif; ?>

    </nav>

</header>