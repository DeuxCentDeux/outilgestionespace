var startInput = document.getElementById('start');
var endInput = document.getElementById('end');

var start = new Date('1970-01-01T' + startInput.value);
var end = new Date('1970-01-01T' + endInput.value);

var startHours = start.getHours();
var endHours = end.getHours();
var hourDifference = endHours - startHours;

var personne = document.getElementById('pers');

var selectElement = document.getElementById('ObjectCowork');
var selectedValue = selectElement.value;
console.log(personne);

function validateForm() {

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

  var inputDate = document.getElementById('date').value;
  var today = new Date().toISOString().split('T')[0];

  if (inputDate < today) {
    alert("La date ne peut pas être antérieure à aujourd'hui.");
    return false;
  }

  return true;
}