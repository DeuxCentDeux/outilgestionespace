<?php
require_once("../FormulaireUtilisateur/cnx.php");

$id = isset($_POST['id']) ? $_POST['id'] : '';
$state = isset($_POST['state']) ? $_POST['state'] : '';

$query = "UPDATE clients SET Etat = ? WHERE ID = ?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Erreur lors de la préparation de la requête : " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ss", $state, $id);

if (!mysqli_stmt_execute($stmt)) {
    die("Erreur lors de l'exécution de la requête : " . mysqli_error($conn));
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

// Redirect back to the previous page
header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
?>
