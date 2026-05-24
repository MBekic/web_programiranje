<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION["korisnik_id"])) {
    header("Location: prijava.php");
    exit();
}

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $upit = $pdo->prepare("
        DELETE FROM playlista
        WHERE id = ?
    ");

    $upit->execute([$id]);
}

header("Location: playlista.php");
exit();
?>