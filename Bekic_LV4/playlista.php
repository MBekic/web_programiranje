<?php
session_start();

if (!isset($_SESSION["korisnik_id"])) {
    header("Location: prijava.php");
    exit();
}

include 'includes/db.php';

$korisnik_id = $_SESSION["korisnik_id"];

$upit = $pdo->prepare("
    SELECT
        playlista.id AS playlista_id,
        pjesme.*
    FROM playlista
    JOIN pjesme
        ON playlista.pjesma_id = pjesme.id
    WHERE playlista.korisnik_id = ?
");

$upit->execute([$korisnik_id]);

$pjesme = $upit->fetchAll();

include 'includes/header.php';
?>

<main>
<section class="content">

<h1>Moja playlista</h1>

<table border="1" cellpadding="10">

<tr>
    <th>Naziv</th>
    <th>Izvođač</th>
    <th>Žanr</th>
    <th>Godina</th>
    <th>Akcija</th>
</tr>

<?php foreach($pjesme as $pjesma): ?>

<tr>

    <td><?php echo htmlspecialchars($pjesma["naziv"]); ?></td>

    <td><?php echo htmlspecialchars($pjesma["izvodac"]); ?></td>

    <td><?php echo htmlspecialchars($pjesma["zanr"]); ?></td>

    <td><?php echo htmlspecialchars($pjesma["godina"]); ?></td>

    <td>
        <a href="ukloni_iz_playliste.php?id=<?php echo $pjesma["playlista_id"]; ?>">
            Ukloni
        </a>
    </td>

</tr>

<?php endforeach; ?>

</table>

</section>
</main>

<?php include 'includes/footer.php'; ?>