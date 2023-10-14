<?php


if(isset($_POST['valider'])){
  session_start();
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $conn = new PDO("mysql:host=$servername;dbname=travail",$username,$password);
  
  $ajout=$conn->prepare("insert into demandeur values (:cin,:nom,:prenom,:pseudo,:mp,:pdd,:type,:dn,:etatcv,:adresse,:numtlf,:mail,:diplome,:fac,:exp,:score)");
  $cin = $_SESSION['cin'];
  $nom = $_SESSION['nom'];
  $prenom = $_SESSION['prenom'];
  $pseudo = $_SESSION['pseudo'];
  $mp = $_SESSION['mp'];
  $score=0;
  $dn = $_POST['DN'];
  $etatcv = $_POST['etatcv'];
  $adresse = $_POST['Adresse'];
  $numtlf = $_POST['numtlf'];
  $mail = $_SESSION['mail'];
  $diplome = $_POST['diplomes'];
  $fac = $_POST['universite'];
  $exp = $_POST['experience'];
  $pdd=file_get_contents( $_FILES['pdd']['tmp_name']);
  $filetype = $_FILES["pdd"]["type"];
  $ajout->bindParam(':cin', $cin);
  $ajout->bindParam(':nom', $nom);
  $ajout->bindParam(':prenom', $prenom);
  $ajout->bindParam(':pseudo', $pseudo);
  $ajout->bindParam(':mp', $mp);
  $ajout->bindParam(':pdd', $pdd);
  $ajout->bindParam(':type', $filetype);
  $ajout->bindParam(':dn', $dn);
  $ajout->bindParam(':etatcv', $etatcv);
  $ajout->bindParam(':adresse', $adresse);
  $ajout->bindParam(':numtlf', $numtlf);
  $ajout->bindParam(':mail', $mail);
  $ajout->bindParam(':diplome', $diplome);
  $ajout->bindParam(':fac', $fac);
  $ajout->bindParam(':exp', $exp);
  $ajout->bindParam(':score', $score);
  $ajout->execute();
  
  $competences=$_POST['competences'];
  $n=count($competences);
  for($i=0;$i<$n;$i++){
      $insert1=$conn->prepare("insert into competence_dem values (:cin , :comp )");
      $insert1->bindParam(":comp",$competences[$i]);
      $insert1->bindParam(":cin",$cin);
      $insert1->execute();
  }

  $_SESSION['pseudo']=$pseudo;
  header("location: accountdemandeur.php");
  
}
  if(isset($_POST['back'])){
    header("location: inscridemandeur.php");
  }
echo"<div class='login'   >
        <form id='form' method='POST' enctype='multipart/form-data'>
        <div class='slider'>  
            <h2> Déposer votre CV </h2>
            <fieldset class='pageactive'>
            <div class='infobox' >
            <div class='right'>
                <input type='text' id='Nom' name ='Nom' class='field' placeholder='Nom'>
                <input type='text' id='Prenom' name ='Prenom' class='field' placeholder='Prenom'>
                <input type='file' id='Photo' name ='pdd' class='field' placeholder='Photo ID' accept='image/*'>
                <input type='date' id='date' name ='DN' class='field' placeholder='DN'>
        </div>
        <div class='left'>
                <div class='fieldl'>
                    <label> Etat Civil  :</label>
                    <input type='radio' name='etatcv'  class='choix' id='celib' >
                    <label for='celib'>Celibataire</label>
                    <input type='radio' name='etatcv' class='choix' id='marrie' >
                    <label for='marrie'>Marrié(e)</label>
                    <input type='radio' name='etatcv' class='choix' id='veuf' >
                    <label for='veuf'>Veuf</label>
                </div>
                    <input type='text' id='adresse' name ='Adresse' class='field' placeholder='adresse'>
                    <input type='number' id='tel' name ='numtlf' class='field' placeholder='num tlf'>
                    <input type='text' id='email' name ='Mail' class='field' placeholder='mail'>
            </div>
            
            </div> 
            
            </fieldset>
            <fieldset class='page'>
                <div class='infobox'>
                    <div class='fieldl'>                    
                        <select name='diplomes' id='diplomes'>
                        <option selected='selected'>Selectionner votre diplome </option> 
                        <option value='Securite Informatique'>Securite Informatique </option> 
                        <option value='Business Intelligence'>Business Intelligence </option> 
                        <option value='Business Informations Systems'>Business Informations Systems</option>
                        <option value='Genie Logiciel'>Genie Logiciel </option>
                        <option value='Developpement Web'>Developpement Web </option>
                        <option value='Developpement Mobile'>Developpement Mobile </option>
                        </select>
                    </div>
                <div class='fieldl'>                    
                    <select name='universite' id='universite'>
                        <option selected='selected'>Selectionner votre Faculté/Institut </option> 
                    <optgroup label='Université de Tunis'>
                    <option value='ISG'>ISG </option> 
                    <option value='ISSEC'>ESSECT </option> 
                    <option value='IPEIT'>IPEIT </option>
                    <option value='ENIT'>ENIT </option> 
                    </optgroup>
                    <optgroup label='Université el Manar'>
                    <option value='INSAT'>INSAT </option> 
                    <option value='IPEIM'>IPEIM </option> 
                    <option value='ISI'>ISI </option> 
                    <option value='FST'>FST </option> 
                    </optgroup>
                    </select>
                </div>
                <div class='fieldl'>
                    <label>Competences :</label>
                    <label for='JAVA'>
                    <input type='checkbox' id='JAVA' name='competences[]' value='JAVA'> JAVA
                    </label>
                    <label for='PHP'>
                    <input type='checkbox' id='PHP' name='competences[]' value='PHP'> PHP
                    </label>
                </div> 
                <div class='fieldl'><input type='number' name ='experience' id='AnEx' placeholder='Annee(s) d'experience' min='0' max='10'></div> 
                <div class='fieldl'>
                    
                    <label for='C++'>
                        <input type='checkbox' id='C++' name='competences[]' value='C++'> C++
                    </label>
                    
                    <label for='Python'>
                    <input type='checkbox' id='Python'  name='competences[]' value='Python'> Python
                    </label>
                    <label for='PL/SQL'>
                    <input type='checkbox' id='PLSQL' name='competences[]' value='PLSQL'> PL/SQL
                    </label>
                </div>              
            </div>    
            </fieldset>
            <div class='cont-btn'>
                <div class='btn prev'>coordonnées</div>
                <div class='btn next'>Compétences</div>
            </div>
           
            <button type='submit' class='btn' name='valider'>Deposer</button>
            
	</form>
  <form method='post'>
  <button type='submit' class='btn' name='back'> Retour</button>

            <p id='erreur'class='erreur'></p>
  </form>
            </div>
";
?>



<style>
    *{
	padding: 0;
	margin: 0;
	box-sizing: border-box;
	font-family: 'Quicksand', sans-serif;
}

body{
    height: 100vh;
	width: 100%;
}

.login{
	position: relative;
	width: 100%;
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	padding: 20px 100px;
}

.login:after{
	content: '';
	position: absolute;
	width: 100%;
	height: 100%;
	left: 0;
	top: 0;
	background: url("wimi-autonomie-travail.jpg") no-repeat center;
	background-size: cover;
	filter:blur(7px);
	z-index: -1;
}

h2{
	position: relative;
	padding: 0 0 7px;
	margin-bottom: 3px;
    margin-top: 10px;
}

h2:after{
	content: '';
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
    height: 4px;
    width: 50px;
    border-radius: 2px;
    background-color: #2ecc71;
}

/* .infobox{
	max-width: 850px;
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	background-color: #fff;
	box-shadow: 0px 0px 19px 5px rgba(0,0,0,0.19);
} */

.slider{
    background-color: white;
    border-radius: 10px;
    text-align: center;
}
.slider .page{
    max-width: 100%;
    display: none;
  }
  .pageactive{
    display: block;
    animation: fade 0.8s;
  }
  @keyframes fade{
    from{
      opacity: 0;
    }
    to{
      opacity: 1;
    }
  }


.field{
	width: 85%;
	border: 2px solid rgba(0, 0, 0, 0);
	outline: none;
	background-color: rgba(230, 230, 230, 0.6);
	padding: 0.5rem 1rem;
	font-size: 1.1rem;
	margin-bottom: 22px;
    margin-top: 27px;
	border-radius: 8px;
}

.field:hover{
	background-color: rgba(0, 0, 0, 0.1);
}



.btn{
	width: 80%;
	padding: 0.5rem 1rem;
	background-color: #2ecc71;
	color: #fff;
	font-size: 1.1rem;
	border: none;
	outline: none;
	cursor: pointer;
	transition: .3s;
    border-radius: 10px;
    margin-bottom: 10px;
    margin-left: 70px;
    
}

.btn:hover{
    background-color: #27ae60;
}

.fieldl{
	width: 85%;
    height: 44px;
	border: 2px solid rgba(0, 0, 0, 0);
	outline: none;
	background-color: rgba(230, 230, 230, 0.6);
	padding: 0.5rem 1rem;
	font-size: 1.1rem;
    margin-left: 36px;
    margin-bottom: 22px;
    margin-top: 27px;
	border-radius: 8px;
    font-size: 15px;
}
.fieldl input[type="number"]{
    width: 85%;
}

.fieldl:hover{
	background-color: rgba(0, 0, 0, 0.1);
}

.field:focus{
    border: 2px solid rgba(30,85,250,0.47);
    background-color: #fff;
}
a{
    display: inline-block;
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    border-radius: 7px;
}
a:hover{
    background-color: #0f6b35;
}

.infobox {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 20px; 
    border: none;
    
}

.right {
    grid-column: 1 / 2;
}
.right input[type="file"]{
    height: 40px;
}

.left {
    grid-column: 2 / 3;
}

.erreur{
    color: red;
}

.cont-btn{
    width: 100%;
    height: auto;
    /* border:1px solid black; */
    box-shadow: 0 10px 10px rgba(72, 56, 56, 0);
    display: flex;
    justify-content: center;
    
}

.prev{
    margin-left: 40px;
}
.next{
    margin-right: 30px;
}
fieldset{border: none;}


select[multiple] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f2f2f2;
  font-size: 16px;
  font-family: sans-serif;
  color: #333;
  height: 100px; /* Hauteur personnalisée */
}

select[multiple] option {
  padding: 5px;
  font-size: 14px;
  font-family: sans-serif;
  color: #333;
  background-color: #fff;
}

select[multiple] option:checked {
  background-color: #ddd;
}
</style>
<script>



// récupération des éléments du formulaire
const form = document.getElementById("form");
const nomInput = document.getElementById("Nom");
const tel = document.getElementById("tel");
const date = document.getElementById("date");
const AnEx = document.getElementById("AnEx");
const adresse = document.getElementById("adresse");
const prenomInput = document.getElementById("Prenom");
const emailInput = document.getElementById("email");
const celib = document.getElementById('celib');
const marrie = document.getElementById('marrie');
const veuf = document.getElementById('veuf');
const diplomesSelect = document.getElementById("diplomes");
const universiteSelect = document.getElementById("universite");
const competencesCheckboxes = document.getElementsByName("competences[]");
const Photo = document.getElementById("Photo");
// const checkboxes = document.getElementsByName('Languages');
const EtatCivlcheckboxes = document.getElementsByName('Etat Civil');


form.addEventListener("submit", function (event) {
  
  // empêcher la soumission du formulaire si des champs sont invalides
  const file = Photo.files[0];
  const maxYear = (new Date()).getFullYear() - 21; // 21 ans en arrière de l'année actuelle
  date.max = `${maxYear}-12-31`;
  // const atLeastOneChecked = Array.from(checkboxes).some((checkboxes) => checkboxes.checked);
        
  if (!estNomValide()) {
    event.preventDefault();
    afficherErreur("Veuillez entrer un nom valide.");
  } else if (!estPrenomValide()) {
    event.preventDefault();
    afficherErreur("Veuillez entrer un prénom valide.");
  } else
    if (Photo.files.length === 0) {
    event.preventDefault();
    afficherErreur("Veuillez choisir un fichier.");
  }else
  if (!file.type.match("image.*")) {
    event.preventDefault();
    afficherErreur("Le fichier doit etre un image.");
  }else
  if(date.value.trim()==''){
   event.preventDefault();
   afficherErreur("Veuillez remplire le date de naissance.");
  }else 
  if (!celib.checked && !marrie.checked && !veuf.checked) {
    event.preventDefault();
    afficherErreur("Veuillez sélectionner votre état civil.");
  } else
  
  if(adresse.value.trim()==''){
    event.preventDefault();
    afficherErreur("Veuillez remplire le champ adresse.");
   }else
   if(tel.value.trim()==''){
    event.preventDefault();
    afficherErreur("Veuillez remplire le champ telephone.");
   }else if (tel.value<20000000){
    event.preventDefault();
    afficherErreur("numero de telephone invalide.");
   }else if (tel.value>99999999){
    event.preventDefault();
    afficherErreur("numero de telephone invalide.");
   }else if (!estEmailValide()) {
    event.preventDefault();
    afficherErreur("Veuillez entrer un email valide.");
  } else
  if(AnEx.value.trim()==''){
    event.preventDefault();
    afficherErreur("Veuillez remplire le champ Années d'experience.");
   }else if (!estDiplomeValide()) {
    event.preventDefault();
    afficherErreur("Veuillez sélectionner un diplôme.");
  } else if (!estUniversiteValide()) {
    event.preventDefault();
    afficherErreur("Veuillez sélectionner une université.");
  } else if (!estCompetencesValides()) {
    event.preventDefault();
    afficherErreur("Veuillez sélectionner au moins une compétence.");
    }

});

// fonctions de validation de chaque champ
function estNomValide() {
  return /^[a-zA-Z]+$/.test(nomInput.value);
}

function estPrenomValide() {
  return /^[a-zA-Z]+$/.test(prenomInput.value);
}

function estEmailValide() {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
}

function estDiplomeValide() {
  return diplomesSelect.selectedIndex !== 0;
}

function estUniversiteValide() {
  return universiteSelect.selectedIndex !== 0;
}

function estCompetencesValides() {
  return Array.from(competencesCheckboxes).some((checkbox) => checkbox.checked);
}



// fonction utilitaire pour afficher un message d'erreur
function afficherErreur(message) {
  const erreurElement = document.getElementById("erreur");
  erreurElement.textContent = message;
  erreurElement.style.display = "block";
}
let items=document.querySelectorAll('fieldset');
let nbslides=items.length;
let next=document.querySelector('.next');
let previous=document.querySelector('.prev');
let i=0;


function slidesuivant(){

  items[i].className="page";
  
  if(i<nbslides-1){
    i++;
  }
  items[i].className="pageactive";
}
next.addEventListener('click',slidesuivant)


function slideprecedent(){
  items[i].className="page";
  if(i>0){
    i--;
  }
  items[i].className="pageactive";
}
previous.addEventListener('click',slideprecedent)


</script>    





