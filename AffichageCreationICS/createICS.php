<?php
require_once("../FormulaireUtilisateur/cnx.php");

$stmt = $conn->prepare("SELECT * FROM clients");
$stmt->execute();
$result = $stmt->get_result();

// Début du calendrier
$ics = "BEGIN:VCALENDAR\n";
$ics .= "VERSION:2.0\n";
$ics .= "PRODID:-//hacksw/handcal//NONSGML v1.0//EN\n";

// Récupération des données de la base de données
$i = 0; 
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        
        $nomICS = $row["nom"];
        $prenomICS = $row["prenom"];
        $societeICS = $row["societe"];
        $emailICS = $row["email"];
        $telICS = $row["tel"];
        $objectCoworkICS = $row["ObjReservé"];
        $startICS = $row["start"];
        $endICS = $row["end"];
        $dateICS = $row["date"];
        $persICS = $row["prix"];
        $tokenICS = $row["token"];
        $etatICs = $row["etat"];
        $id = $row["id"];


        if ($etatICs == "prévision") {

        // Titre
        $objet = "Réservation du ". $objectCoworkICS. " pour le ". $dateICS;

        // Contenu
        $details = "Mr/Mme ".$nomICS." ".$prenomICS.
                   " Email: ".$emailICS.
                   " Numéro de téléphone: ".$telICS.
                   " Société: ".$societeICS.
                   " Nombre de personne(s): ".$persICS.
                   " Date de début: ".$dateICS;

        // Date de début et fin
        $dateStart = str_replace("-", "", $dateICS) . "T" . str_replace(":", "", $startICS) . "00"; 
        $dateEnd = str_replace("-", "", $dateICS) . "T" . str_replace(":", "", $endICS) . "00"; 
        
            // Contenu du fichier ICS
            $ics .= "BEGIN:VEVENT\n";
            $ics .= "X-WR-TIMEZONE:Europe/Paris\n";
            $ics .= "DTSTART:".$dateStart."\n";
            $ics .= "DTEND:".$dateEnd."\n";
            $ics .= "SUMMARY:".$objet."\n";
            $ics .= "DESCRIPTION:".$details."\n";
            $ics .= "END:VEVENT\n";
            $etat = "validé";

            // Incrémentation Indicatif 
            $i++;

            // Mise à jour de l'état

            $updateStmt = $conn->prepare("UPDATE clients SET etat = ? WHERE id = ?");
            $updateStmt->bind_param("si", $etat, $id);

            $updateStmt->execute();
        }
    }
}

// Fermeture du calendrier 
$ics .= "END:VCALENDAR\n";
// Création du nom et du calendrier
$timestamp = time();
$formattedTimestamp = date('Y-m-d-H-i', $timestamp);
$filename = 'agenda-' . $formattedTimestamp . '.ics';
file_put_contents($filename, $ics);

echo $filename . " à était crée avec " . $i . " nouvelle(s) entrée(s)."; 

// The end
$stmt->close();
$conn->close();
?>