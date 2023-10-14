

// récupération des éléments du formulaire
const form = document.getElementById("form");
const titreOf = document.getElementById("titreOf");
const AnEx = document.getElementById("AnEx");
const salaire = document.getElementById("salaire");
const desc = document.getElementById("desc");
const diplomesSelect = document.getElementById("diplomes");
const checkboxes = document.getElementsByName("competences[]");
// const php=document.getElementById("PHP");
// const java=document.getElementById("JAVA");
// const python=document.getElementById("Python");
// const cplus=document.getElementById("C++");
// const plsql=document.getElementById("PLSQL");





form.addEventListener("submit", function (event) {
  // empêcher la soumission du formulaire si des champs sont invalides
  const atLeastOneChecked = Array.from(checkboxes).some((checkboxes) => checkboxes.checked);
   
   
  if (!esttitreOfValide()) {
    event.preventDefault();
    afficherErreur("Veuillez entrer un titre valide.");
  } else  
  if(desc.value.trim()==''){
   event.preventDefault();
   afficherErreur("Veuillez remplire le champ description.");
  }else if (!atLeastOneChecked) {
    event.preventDefault();
  afficherErreur("Veuillez choisir au moins un Language.");
  
  }
  else if (!estDiplomeValide()) {
    event.preventDefault();
    afficherErreur("Veuillez sélectionner un diplôme.");
  } else if(AnEx.value.trim()==''){
    event.preventDefault();
    afficherErreur("Veuillez remplire le champ Années d'experience.");
   } else  if(salaire.value.trim()==''){
    event.preventDefault();
    afficherErreur("Veuillez remplire le champ salaire.");
   }
});

// fonctions de validation de chaque champ
function esttitreOfValide() {
  return /^[a-zA-Z\s]+$/.test(titreOf.value);
}


function estDiplomeValide() {
  return diplomesSelect.selectedIndex !== 0;
}


// fonction utilitaire pour afficher un message d'erreur
function afficherErreur(message) {
  const erreurElement = document.getElementById("erreur");
  erreurElement.textContent = message;
  erreurElement.style.display = "block";
}
