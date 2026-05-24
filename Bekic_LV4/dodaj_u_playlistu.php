<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION["korisnik_id"])) {
    header("Location: prijava.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: glazba.php");
    exit();
}

$korisnik_id = $_SESSION["korisnik_id"];
$pjesma_id = $_GET["id"];

$provjera = $pdo->prepare("
    SELECT * FROM playlista
    WHERE korisnik_id = ? AND pjesma_id = ?
");

$provjera->execute([$korisnik_id, $pjesma_id]);

if ($provjera->rowCount() > 0) {

    $_SESSION["poruka"] = "Ova pjesma je već u playlisti.";

} else {

    $upit = $pdo->prepare("
        INSERT INTO playlista (korisnik_id, pjesma_id)
        VALUES (?, ?)
    ");

    $upit->execute([$korisnik_id, $pjesma_id]);

    $_SESSION["poruka"] = "Pjesma dodana u playlistu!";
}

header("Location: glazba.php");
exit();
?>