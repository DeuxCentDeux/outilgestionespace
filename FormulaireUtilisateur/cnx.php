<?php
// Connnexion à la base de données
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'coworking';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Vérification de la connexion à la base de données
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}
?>