<?php

require_once("../FormulaireUtilisateur/cnx.php");

echo "<link rel='stylesheet' href='style.css'";
$stmt = $conn->prepare("SELECT * FROM clients");
$stmt->execute();
$result = $stmt->get_result();

$display = isset($_POST['display']) ? $_POST['display'] : '';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Affichage des clients</title>
</head>
<body>
    <h1>Liste des clients</h1>
    <form method="post" action="">
        <label for="display">Afficher :</label>
        <select name="display" id="display">
            <option value="tout" <?php if($display == "tout") echo "selected"; ?>>Tous</option>
            <option value="pre" <?php if($display == "pre") echo "selected"; ?>>Prévisions</option>
            <option value="val" <?php if($display == "val") echo "selected"; ?>>Validés</option>
            <option value="ann" <?php if($display == "ann") echo "selected"; ?>>Annulés</option>
        </select><br><br>
        <input type="submit" value="Afficher">
    </form>
    <br>

    <?php
    if ($result->num_rows > 0) {
        echo '<table>';
        
        echo '<thead><tr><th>Nom</th><th>Prénom</th><th>Société</th><th>Email</th><th>Téléphone</th><th>Objet Réservé</th><th>Début</th><th>Fin</th><th>Date</th><th>Prix</th><th>Token</th><th>Lieu</th><th>État</th></tr></thead>';

        while($row = $result->fetch_assoc()) {
            $etatICs = $row["etat"];

            if ($display == "tout" ||
                ($etatICs == "prévision" && $display == "pre") ||
                ($etatICs == "validé" && $display == "val") ||
                ($etatICs == "annulé" && $display == "ann")) {
                
                $nomICS = $row["nom"];
                $prenomICS = $row["prenom"];
                $societeICS = $row["societe"];
                $emailICS = $row["email"];
                $telICS = $row["tel"];
                $objectCoworkICS = $row["ObjReservé"];
                $startICS = $row["start"];
                $endICS = $row["end"];
                $dateICS = $row["date"];
                $tokenICS = $row["token"];
                $persICS = $row["prix"];
                $lieuICS = $row["lieu"];
                $etatICS = $row["etat"];

                echo '<tr>';
                echo '<td>' . $nomICS . '</td>';
                echo '<td>' . $prenomICS . '</td>';
                echo '<td>' . $societeICS . '</td>';
                echo '<td>' . $emailICS . '</td>';
                echo '<td>' . $telICS . '</td>';
                echo '<td>' . $objectCoworkICS . '</td>';
                echo '<td>' . $startICS . '</td>';
                echo '<td>' . $endICS . '</td>';
                echo '<td>' . $dateICS . '</td>';
                echo '<td>' . $persICS . '</td>';
                echo '<td>' . $tokenICS . '</td>';
                echo '<td>' . $lieuICS . '</td>';
                echo '<td>' . $etatICS . '</td>';
                echo '</tr>';
                
            }
        }

        echo '</table>';
    } else {
        echo 'Aucun client trouvé.';
    }
    ?>
<br><br><br>
<button onclick="window.location.href = 'createICS.php';">Créer le Calendrier</button>


</body>
</html>
