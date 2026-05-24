<?php
session_start();

if (!isset($_SESSION["korisnik_id"])) {
    header("Location: prijava.php");
    exit();
}

include 'includes/db.php';


$poruka = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $naziv = trim($_POST["naziv"]);
    $izvodac = trim($_POST["izvodac"]);
    $zanr = trim($_POST["zanr"]);
    $bpm = trim($_POST["bpm"]);
    $godina = trim($_POST["godina"]);
    $popularnost = trim($_POST["popularnost"]);
    $raspolozenje = trim($_POST["raspolozenje"]);

    if (
        empty($naziv) ||
        empty($izvodac) ||
        empty($zanr)
    ) {

        $poruka = "Naziv, izvođač i žanr su obavezni.";

    } elseif ($godina < 1900 || $godina > 2026) {

        $poruka = "Godina nije ispravna.";

    } else {

        $upit = $pdo->prepare("
            INSERT INTO pjesme
            (naziv, izvodac, zanr, bpm, godina, popularnost, raspolozenje)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $upit->execute([
            $naziv,
            $izvodac,
            $zanr,
            $bpm,
            $godina,
            $popularnost,
            $raspolozenje
        ]);

        $poruka = "Pjesma uspješno dodana!";
    }
}

include 'includes/header.php';
?>

<main>
<section class="content">

<h1>Dodaj pjesmu</h1>

<form method="POST">

    <label>Naziv:</label><br>
    <input type="text" name="naziv"><br><br>

    <label>Izvođač:</label><br>
    <input type="text" name="izvodac"><br><br>

    <label>Žanr:</label><br>
    <input type="text" name="zanr"><br><br>

    <label>BPM:</label><br>
    <input type="number" name="bpm"><br><br>

    <label>Godina:</label><br>
    <input type="number" name="godina"><br><br>

    <label>Popularnost:</label><br>
    <input type="number" name="popularnost"><br><br>

    <label>Raspoloženje:</label><br>
    <input type="text" name="raspolozenje"><br><br>

    <button type="submit">Dodaj pjesmu</button>

</form>

<p><?php echo $poruka; ?></p>

</section>
</main>

<?php include 'includes/footer.php'; ?>