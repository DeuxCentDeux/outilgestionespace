<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Formulaire Affichage</title>
</head>
<body>
  <h1>Affichage</h1>
  <form method="post" action="">
    <span class="datepicker-toggle">
        <label>Période de :</p>
        <span class="datepicker-toggle-button"></span>
        <input type="date" name="date" id="date"><br><br>
    </span><br>
  
    <span class="datepicker-toggle">
        <label>à :</label>
        <span class="datepicker-toggle-button"></span>
        <input type="date" name="date2" id="date2"><br><br>
    </span><br>

      <label for="start">Horaire :</label>
      <input min="08:00" max="18:00" type="time" name="start" id="start"><br><br>
      <label for="end">à :</label>
      <input min="08:00" max="18:00" type="time" name="end" id="end"><br><br><br>
  
    <label class="reserv2">Trier par :</label>
    <select class="reserv2" id="choiceCowork" name="choiceCowork">
      <option value="date">Date</option>
      <option value="fin">Fin Horaire</option>
      <option value="debut">Début Horaire</option>
      <option value="datedebutfin">Date et Début et Fin</option>
      <option value="debutfin">Début et Fin</option>
      <option value="datedebut">Date et Début</option>
      <option value="datefin">Date et Fin</option>
      <option value="betweentime">Entre les 2 périodes de temps</option>
      <option value="betweendate">Entre les 2 dates</option>
    </select>

    <br><br>
    <input type="submit" value="Afficher">
    <br><br><br><br><br>
  </form>
</body>
</html>

<?php
require_once("../FormulaireUtilisateur/cnx.php");

echo "<link rel='stylesheet' type='text/css' href='style.css'>";
echo "<title>Affichage</title>";

$datePrecise = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : '';
$datePreciseFin = isset($_POST['date2']) ? htmlspecialchars($_POST['date2']) : '';
$debutPrecis = isset($_POST['start']) ? htmlspecialchars($_POST['start']) : '';
$finPrecis = isset($_POST['end']) ? htmlspecialchars($_POST['end']) : '';
$timing = isset($_POST['choiceCowork']) ? $_POST['choiceCowork'] : '';

$query = "SELECT * FROM clients WHERE ObjReservé = 'coworking'";
$bindTypes = '';
$bindValues = [];

if ($timing == "betweendate") {
    $query .= " AND date >= ? AND date <= ?";
    $bindTypes = "ss";
    $bindValues = [$datePrecise, $datePreciseFin];
} elseif ($timing == "betweentime") {
    $query .= " AND start >= ? AND end <= ?";
    $bindTypes = "ss";
    $bindValues = [$debutPrecis, $finPrecis];
} elseif ($timing == "date") {
    $query .= " AND date = ?";
    $bindTypes = "s";
    $bindValues = [$datePrecise];
} elseif ($timing == "fin") {
    $query .= " AND end = ?";
    $bindTypes = "s";
    $bindValues = [$finPrecis];
} elseif ($timing == "debut") {
    $query .= " AND start = ?";
    $bindTypes = "s";
    $bindValues = [$debutPrecis];
} elseif ($timing == "datedebutfin") {
    $query .= " AND start = ? AND end = ? AND date = ?";
    $bindTypes = "sss";
    $bindValues = [$debutPrecis, $finPrecis, $datePrecise];
} elseif ($timing == "debutfin") {
    $query .= " AND start = ? AND end = ?";
    $bindTypes = "ss";
    $bindValues = [$debutPrecis, $finPrecis];
} elseif ($timing == "datedebut") {
    $query .= " AND start = ? AND date = ?";
    $bindTypes = "ss";
    $bindValues = [$debutPrecis, $datePrecise];
} elseif ($timing == "datefin") {
    $query .= " AND end = ? AND date = ?";
    $bindTypes = "ss";
    $bindValues = [$finPrecis, $datePrecise];
}

$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    die("Erreur lors de la préparation de la requête : " . mysqli_error($conn));
}

if ($bindTypes !== '') {
    mysqli_stmt_bind_param($stmt, $bindTypes, ...$bindValues);
}

if (!mysqli_stmt_execute($stmt)) {
    die("Erreur lors de l'exécution de la requête : " . mysqli_error($conn));
}

$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Erreur lors de l'exécution de la requête : " . mysqli_error($conn));
}

$i = 0;

echo "<table><";
echo "<thead><td>ID</td><td>Nom</td><td>Prénom</td><td>Société</td><td>Email</td><td>Téléphone</td><td>Objet Réservé</td><td>Début</td><td>Fin</td><td>Durée</td><td>Date</td><td>Prix (€)</td><td>Jeton Unique</td><td>Nombre de Personnes</td><td>Lieu</td><td>État</td><td>Changer l'état de la réservation</td></thead>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    foreach ($row as $column => $value) {
        $idd = $row['id'];
        echo "<td>" . htmlspecialchars($value) . "</td>";
        $i++;
    }
    echo "<td>
        <form method='post' action='update.php'>
            <input type='hidden' name='id' value='" . $idd . "'>
            <select name='state'>
                <option value='prévision'>prévision</option>
                <option value='validé'>validé</option>
                <option value='annulé'>annulé</option>
            </select>
            <br>
            <input type='submit' value='Modifier'>
        </form>
    </td>";
    echo "</tr>";
}
echo "</table>";

/* Afficher les objets
$sql = "SELECT * FROM objetcowork";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Accéder aux colonnes de chaque ligne
        $row1 = $row["nom"];
        $row2 = $row["categorie"];
        $row3 = $row["totalCoworking"];
        $row4 = $row["PlaceOccupe"];
        $row5 = $row["lieu"];

        // (a faire ) additioner tous les donnees de places des espaces flexible dans un lieu
        // gerer les demandes selon les espaces voulu

        echo "Nom : " . $row1 . "<br>";
        echo "Catégorie : " . $row2 . "<br>";
        echo "NbPlacesMax : " . $row3 . "<br>";
        echo "NbPlacesOccupé : " . $row4 . "<br>";
        echo "Lieu : " . $row5 . "<br><br>";
    }
}
*/

mysqli_close($conn);
?>