<?php
require_once("cnx.php");
echo "<link rel='stylesheet' href='style.css'";
// Fonction de nettoyage
function sanitize($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

$car = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$token = substr(str_shuffle($car), 0, 32);



$nom = isset($_POST['nom']) ? sanitize($_POST['nom']) : '';
$prenom = isset($_POST['prenom']) ? sanitize($_POST['prenom']) : '';
$societe = isset($_POST['societe']) ? sanitize($_POST['societe']) : '';
$email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
$tel = isset($_POST['tel']) ? sanitize($_POST['tel']) : '';
$pers = isset($_POST['pers']) ? sanitize($_POST['pers']) : '';
$objectCowork = isset($_POST['ObjectCowork']) ? sanitize($_POST['ObjectCowork']) : '';
$start = isset($_POST['start']) ? sanitize($_POST['start']) : '';
$end = isset($_POST['end']) ? sanitize($_POST['end']) : '';
$date = isset($_POST['date']) ? sanitize($_POST['date']) : '';
$periode = isset($_POST['periode']) ? sanitize($_POST['periode']) : '';
$lieu = isset($_POST['lieu']) ? sanitize($_POST['lieu']) : '';

// Remplacement des données non présentes
$societe = empty($societe) ? "NON RENSEIGNÉ" : $societe;
$tel = empty($tel) ? "NON RENSEIGNÉ" : $tel;

// État
$etat = "prévision";

// Calcul des différences des dates 
$startDateTime = new DateTime($start);
$endDateTime = new DateTime($end);

$diff = $startDateTime->diff($endDateTime);
$diffHours = $diff->h + ($diff->days * 24);
$diffMinutes = $diff->i;

// Ajout d'un heure si un certains nombre de minutes et t'ajoutez ici 30
if ($diffMinutes > 30) {
    $diffHours++;
}
// Calcul du temps 
switch (true) {
    case ($diffHours <= 1):
        $time = "1H";
        break;
    case ($diffHours <= 4):
        $time = "1/2J";
        break;
    default:
        $time = "1J";
        break;
}

// Tableau associatif des prix selon l'objet réservé
$prices = [
    'coworking' => [
        '1H' => 5,
        '1/2J' => 15,
        '1J' => 25
    ],
    'forfait' => [
        '1/2J' => 22,
        '1J' => 40
    ],
    'bulle' => [
        '1H' => 12,
        '1/2J' => 36,
        '1J' => 60
    ],
    'bureau' => [
        '1H' => 12,
        '1/2J' => 45,
        '1J' => 75
    ],
    'SDR20' => [
        '1H' => 25,
        '1/2J' => 70,
        '1J' => 125
    ],
    'SDR30' => [
        '1H' => 30,
        '1/2J' => 100,
        '1J' => 175
    ]
];

$prix = $prices[$objectCowork][$time] * $pers * $periode;

// Formatage de la date 
$formatDate = date('d/m/Y', strtotime($date));

// Envoie d'un message après la réservation 
echo "<label>Vous avez sélectionné " . $objectCowork . " pour " . htmlspecialchars($time) . " pendant " . htmlspecialchars($periode) . " jours, à partir du " . $formatDate . " de " . $start . " à " . $end . " le prix total sera de " . htmlspecialchars($prix) . "€ pour " . htmlspecialchars($pers) . " personne(s).<br></label>";
echo "<br><br><button onclick=\"window.location.href = 'index.php';\">Aller en arrière</button>";


// Associaction des jours choisis 
$joursSelectionnes = [];

if (isset($_POST["lundi"])) {
    $joursSelectionnes[] = 1; 
}
if (isset($_POST["mardi"])) {
    $joursSelectionnes[] = 2; 
}
if (isset($_POST["mercredi"])) {
    $joursSelectionnes[] = 3; 
}
if (isset($_POST["jeudi"])) {
    $joursSelectionnes[] = 4;
}
if (isset($_POST["vendredi"])) {
    $joursSelectionnes[] = 5;
}

$occurrences = []; // Tableau associatif pour stocker
$currentDate = new DateTime($date);
$occurrenceCount = 0; 

$nombreOccurrences = count($joursSelectionnes);

$periode = $periode * $nombreOccurrences;

// Création des dates pour les jours choisis
while ($occurrenceCount < $periode) {
    if (in_array($currentDate->format("N"), $joursSelectionnes)) {   // Si le jour de la semaine correspond à l'un des jours sélectionnés
        $occurrences[] = $currentDate->format("Y-m-d");
        $occurrenceCount++;
    }
    $currentDate->modify("+1 day"); // Passe à la journée d'après
}

$stmt = $conn->prepare("INSERT INTO clients(nom, prenom, societe, email, tel, objReservé, start, end, time, date, prix, token, pers, lieu , etat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Envoi autant de rêquete que nécessaire
foreach ($occurrences as $occurrence) {
    $stmt->bind_param("sssssssssssssss", $nom, $prenom, $societe, $email, $tel, $objectCowork, $start, $end, $time, $occurrence, $prix, $token, $pers, $lieu, $etat);
    if (!$stmt->execute()) {
        echo "<script>alert('Échec !');</script>";
    }
}

$stmt->close();
$conn->close();
?>