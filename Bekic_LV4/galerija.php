<?php
session_start();

if (!isset($_SESSION["korisnik_id"])) {
    header("Location: prijava.php");
    exit();
}

include 'includes/db.php';

$upit = $pdo->query("SELECT * FROM slike");
$slike = $upit->fetchAll();

include 'includes/header.php';
?>

<main>
<section class="content">

<style>

.galerija {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.slika-kartica {
    border: 1px solid #ccc;
    padding: 15px;
    width: 250px;
}

img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

</style>

<h1>Galerija slika</h1>

<div class="galerija">

<?php foreach($slike as $slika): ?>

<?php

$prosjek_upit = $pdo->prepare("
    SELECT AVG(ocjena) AS prosjek
    FROM ocjene
    WHERE slika_id = ?
");

$prosjek_upit->execute([$slika["id"]]);

$prosjek = $prosjek_upit->fetch();

?>

<div class="slika-kartica">

    <img src="<?php echo $slika["putanja"]; ?>">

    <h3><?php echo htmlspecialchars($slika["opis"]); ?></h3>

    <p>
        Prosječna ocjena:

        <?php
        if ($prosjek["prosjek"] !== null) {
            echo round($prosjek["prosjek"], 1);
        } else {
            echo "Nema ocjena";
        }
        ?>
    </p>

    <form action="ocijeni_sliku.php" method="POST">

        <input type="hidden"
               name="slika_id"
               value="<?php echo $slika["id"]; ?>">

        <select name="ocjena">

            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>

        </select>

        <button type="submit">Ocijeni</button>

    </form>

</div>

<?php endforeach; ?>

</div>

</section>
</main>

<?php include 'includes/footer.php'; ?>