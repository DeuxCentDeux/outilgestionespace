<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de remplacement de données</title>
</head>
<body>
    <h2>Formulaire de remplacement de données</h2>
    
    <form action="addObjet.php" method="POST">

        <label for="nom">Nom  :</label>
        <input type="text" name="nom" id="nom" required><br><br>

        <label for="categorie">Catégorie :</label>
        <select name="categorie" id="categorie" required>
            <option value="Privée">Privée</option>
            <option value="Partagé">Partagé</option>
            <option value="Flexible">Flexible</option>
        </select><br><br>        
        <label for="nbDePoste">Nombre de postes :</label>
        <input type="number" name="nbDePoste" id="nbDePoste" required><br><br>
        
        <label for="capacite">Capacité :</label>
        <input type="number" name="capacite" id="capacite" required><br><br>
        
        <label for="qtPiece">Quantité de pièces :</label>
        <input type="number" name="qtPiece" id="qtPiece" required><br><br>
        
        <label for="surface">Surface :</label>
        <input type="number" name="surface" id="surface" required><br><br>
        
        <label for="totalCoworking">Total coworking :</label>
        <input type="number" name="totalCoworking" id="totalCoworking" required><br><br>
        
        <label for="totalAccueil">Total accueil :</label>
        <input type="number" name="totalAccueil" id="totalAccueil" required><br><br>
        
        <label for="coworkable">Coworkable :</label>
        <select name="coworkable" id="coworkable" required>
            <option value="Oui">Oui</option>
            <option value="Non">Non</option>
        </select>
        
        <br><br>
        
        <label for="pieceUnique">Pièce unique :</label>
        <select name="pieceUnique" id="pieceUnique" required>
            <option value="Oui">Oui</option>
            <option value="Non">Non</option>
        </select><br><br>
        
        <label for="surfaceTotale">Surface totale :</label>
        <input type="number" name="surfaceTotale" id="surfaceTotale" required><br><br>
        
        <label for="specificites">Spécificités :</label>
        <textarea name="specificites" id="specificites" rows="4" required></textarea><br><br>
        
        <label for="equipements">Équipements :</label>
        <textarea name="equipements" id="equipements" rows="4" required></textarea><br><br>
        
        <label for="quantite">Quantité :</label>
        <input type="number" name="quantite" id="quantite" required><br><br>
        
        <label for="lieu">Lieu :</label>
        <input type="text" name="lieu" id="lieu" required><br><br>
        
        <input type="submit" value="Remplacer">
    </form>
    </body>
</html>