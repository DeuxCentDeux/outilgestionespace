<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Formulaire Coworking Space</title>
    <!-- 41x85 -->
</head>
<body>
  <style>
    form {
      width: 300px;
      margin: 0 auto;
    }

    h1 {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      text-align: center;
    }

    input[type="text"],
    input[type="number"],
    input[type="email"],
    input[type="time"],
    select,
    input[type="date"] {
      padding: 12px;
      width: 280px;
      font-size: 16px;
      border: 1px solid #ccc;
      box-shadow: none;
      text-align: center;
      display: block;
      margin: 0 auto;
    }

    input[type="submit"] {
      padding: 25px;
      width: 322px;
      font-size: 16px;
      border: none;
      border-radius: 1px 0 0 0;
      color: white;
      background-color: #5bb05d;
      box-shadow: none;
      text-align: center;
      display: block;
      margin: 0 auto;
    }

    input[type="submit"]:hover {
      background-color: #338f35;
    }

    label {
      font-size: 22px;
      margin-bottom: 10px;
      text-align: center;
      color: grey;
    }
  </style>

  <h1>Réservation</h1>
  <form method="post" action="saveData.php" onsubmit="return validateForm()">

    <label for="lieu">Je réserve au :</label>
    <select name="lieu" id="lieu">
      <option value="cowork">Cowork'in Vendée</option>
      <option value="flex">Flex Office</option>
    </select><br><br>

    <input type="text" placeholder="Votre nom*" name="nom" required><br><br>
    <input type="text" placeholder="Votre prénom*" name="prenom" required><br><br>
    <input type="email" placeholder="Email*" name="email" required><br><br>
    <input type="number" placeholder="Nombre de Personnes*" name="pers" required><br><br>
    <input type="text" placeholder="Société" name="societe"><br><br>
    <input type="number" placeholder="N° de Téléphone" name="tel"><br><br>
    <label class="reserv">Je réserve :</label>
    <select name="ObjectCowork">
      <option value="coworking">Coworking</option>
      <option value="forfait">Forfait Coworking + Bulle Confidentielle</option>
      <option value="bulle">Bulle Confidentielle</option>
      <option value="bureau">Bureau Privé</option>
      <option value="SDR20">Salle de Réunion 20m²</option>
      <option value="SDR30">Salle de Réunion 30m²</option>
    </select>
    <br><br>
    <label for="date">A partir du :</label>
    <input required type="date" name="date"><br><br>
    <input type="number" placeholder="Nombre de jour(s)" name="periode"><br><br>
    <label for="start">De :</label>
    <input min="08:00" max="18:00" type="time" name="start">
    <label for="end">à</label>
    <input min="08:00" max="18:00" type="time" name="end"><br><br><br>
    <p>lu/ ma/ me/ je/ ve</p>
    <input type="checkbox" name="lundi">
    <input type="checkbox" name="mardi">
    <input type="checkbox" name="mercredi">
    <input type="checkbox" name="jeudi">
    <input type="checkbox" name="vendredi"><br><br>


    <br><br>

    <input type="submit" value="Réserver">
  </form>
  
  <script>
    function validateForm() {
      var startInput = document.getElementsByName('start')[0];
      var endInput = document.getElementsByName('end')[0];
      var start = new Date('1970-01-01T' + startInput.value);
      var end = new Date('1970-01-01T' + endInput.value);
      var hourDifference = end.getHours() - start.getHours();
      var personne = document.getElementsByName('pers')[0].value;
      var selectedValue = document.getElementsByName('ObjectCowork')[0].value;
      var inputDate = document.getElementsByName('date')[0].value;
      var today = new Date().toISOString().split('T')[0];

      if (hourDifference < 4 && selectedValue === 'forfait') {
        alert('Sélectionnez une période de temps plus importante pour réserver le forfait Coworking avec bulle. Minimum 4 heures.');
        return false;
      }

      if (personne > 12  && selectedValue === 'SDR20') {
        alert('Sélectionnez une salle plus grande');
        return false;
      }

      if (personne >= 20  && selectedValue === 'SDR30') {
        alert('Le nombre de personnes est limité à 20.');
        return false;
      }

      if (start >= end) {
        alert('Vos horaires sont incorrects !');
        return false;
      }

      if (inputDate < today) {
        alert("La date ne peut pas être antérieure à aujourd'hui.");
        return false;
      }

      return true;
    }
  </script>
</body>
</html>