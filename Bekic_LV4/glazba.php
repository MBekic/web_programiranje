<?php
session_start();

if (!isset($_SESSION["korisnik_id"])) {
    header("Location: prijava.php");
    exit();
}

include 'includes/db.php';

$sql = "SELECT * FROM pjesme WHERE 1=1";

$params = [];

if (!empty($_GET["zanr"])) {
    $sql .= " AND zanr = ?";
    $params[] = $_GET["zanr"];
}

if (!empty($_GET["izvodac"])) {
    $sql .= " AND izvodac LIKE ?";
    $params[] = "%" . $_GET["izvodac"] . "%";
}

if (!empty($_GET["godina"])) {
    $sql .= " AND godina = ?";
    $params[] = $_GET["godina"];
}

if (!empty($_GET["raspolozenje"])) {
    $sql .= " AND raspolozenje LIKE ?";
    $params[] = "%" . $_GET["raspolozenje"] . "%";
}

$upit = $pdo->prepare($sql);
$upit->execute($params);

$pjesme = $upit->fetchAll();

include 'includes/header.php';
?>

<main>
<section class="content">

<?php
if (isset($_SESSION["poruka"])) {

    echo "<p>" . $_SESSION["poruka"] . "</p>";

    unset($_SESSION["poruka"]);
}
?>

<h1>Popis pjesama</h1>

<form method="GET">

    <label>Žanr:</label>
    <input type="text" name="zanr">

    <label>Izvođač:</label>
    <input type="text" name="izvodac">

    <label>Godina:</label>
    <input type="number" name="godina">

    <label>Raspoloženje:</label>
    <input type="text" name="raspolozenje">

    <button type="submit">Filtriraj</button>

</form>

<hr>

<table border="1" cellpadding="10">

<tr>
    <th>Naziv</th>
    <th>Izvođač</th>
    <th>Žanr</th>
    <th>BPM</th>
    <th>Godina</th>
    <th>Popularnost</th>
    <th>Raspoloženje</th>
    <th>Akcija</th>
</tr>

<?php foreach($pjesme as $pjesma): ?>

<tr>

    <td><?php echo htmlspecialchars($pjesma["naziv"]); ?></td>

    <td><?php echo htmlspecialchars($pjesma["izvodac"]); ?></td>

    <td><?php echo htmlspecialchars($pjesma["zanr"]); ?></td>

    <td><?php echo htmlspecialchars($pjesma["bpm"]); ?></td>

    <td><?php echo htmlspecialchars($pjesma["godina"]); ?></td>

    <td><?php echo htmlspecialchars($pjesma["popularnost"]); ?></td>

    <td><?php echo htmlspecialchars($pjesma["raspolozenje"]); ?></td>

    <td>
        <a href="dodaj_u_playlistu.php?id=<?php echo $pjesma["id"]; ?>">
            Dodaj u playlistu
        </a>
    </td>

</tr>

<?php endforeach; ?>

</table>

</section>
</main>

<?php include 'includes/footer.php'; ?>