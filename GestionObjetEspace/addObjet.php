<?php

require_once("../FormulaireUtilisateur/cnx.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formularaire
    $nom = $_POST["nom"];
    $categorie = $_POST["categorie"];
    $nbDePoste = $_POST["nbDePoste"];
    $capacite = $_POST["capacite"];
    $qtPiece = $_POST["qtPiece"];
    $surface = $_POST["surface"];
    $totalCoworking = $_POST["totalCoworking"];
    $totalAccueil = $_POST["totalAccueil"];
    $coworkable = $_POST["coworkable"];
    $pieceUnique = $_POST["pieceUnique"];
    $surfaceTotale = $_POST["surfaceTotale"];
    $specificites = $_POST["specificites"];
    $equipements = $_POST["equipements"];
    $quantite = $_POST["quantite"];
    $lieu = $_POST["lieu"];

    echo $nom . "<br>" . $categorie . "<br>" . $nbDePoste . "<br>" . $capacite . "<br>" . $qtPiece . "<br>" . $surface . "<br>" . $totalCoworking . "<br>" . $totalAccueil . "<br>" . $coworkable . "<br>" . $pieceUnique . "<br>" . $surfaceTotale . "<br>" . $specificites . "<br>" . $equipements . "<br>" . $quantite . "<br>" . $lieu . "<br>";

    // Préparer et exécuter la requête SQL d'insertion avec des paramètres
    $sql = "INSERT INTO objetcowork (nom, categorie, nbPoste, capacite, qtPiece, surface, totalCoworking, coworkable, pieceUnique, surfaceTotale, specificites, equipement, quantite, lieu, TotaleAcceuil) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssiiiiiiiississ", $nom, $categorie, $nbDePoste, $capacite, $qtPiece, $surface, $totalCoworking, $coworkable, $pieceUnique, $surfaceTotale, $specificites, $equipements, $quantite, $lieu, $totalAccueil);

    if ($stmt->execute()) {
        echo "Données insérées avec succès dans la base de données.";
    } else {
        echo "Erreur lors de l'insertion des données : " . $stmt->error;
    }

    // Fermer la connexion à la base de données
    $stmt->close();
    $conn->close();
}
?>