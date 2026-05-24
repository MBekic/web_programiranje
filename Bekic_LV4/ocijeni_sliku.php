<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION["korisnik_id"])) {
    header("Location: prijava.php");
    exit();
}

$korisnik_id = $_SESSION["korisnik_id"];

$slika_id = $_POST["slika_id"];
$ocjena = $_POST["ocjena"];

$provjera = $pdo->prepare("
    SELECT * FROM ocjene
    WHERE korisnik_id = ? AND slika_id = ?
");

$provjera->execute([$korisnik_id, $slika_id]);

if ($provjera->rowCount() > 0) {

    $update = $pdo->prepare("
        UPDATE ocjene
        SET ocjena = ?
        WHERE korisnik_id = ? AND slika_id = ?
    ");

    $update->execute([
        $ocjena,
        $korisnik_id,
        $slika_id
    ]);

} else {

    $insert = $pdo->prepare("
        INSERT INTO ocjene
        (korisnik_id, slika_id, ocjena)
        VALUES (?, ?, ?)
    ");

    $insert->execute([
        $korisnik_id,
        $slika_id,
        $ocjena
    ]);
}

header("Location: galerija.php");
exit();
?>