<?php
echo"
<form class='login' id='form' method='POST' >
		<div class='infobox'>
			<h2>S'inscrire</h2>
			<div class='right'>
                    <input type='text' id='Nom' name='Nom' class='field' placeholder='Nom'>
                    <input type='text' id='Prenom' name='Prenom' class='field' placeholder='Prenom'>
                    <input type='number' id='cin' name='CIN' class='field' placeholder='CIN'>
                    <input type='email' id='email' name='Mail' class='field' placeholder='Mail'>
                    <p id='erreur'></p>
            </div>
            <div class='left'>
                    <input type='text' id='pseudo' name='Pseudo' class='field' placeholder='Pseudo'>
                    <input type='password' id='pass' name='MP' class='field' placeholder='Mot de passe'>
                    <input type='password' id='cpass' name='CMP' class='field' placeholder='Confirmer le mot de passe'>
                    <button type='submit' class='btn' name='valider'>S'inscrire</button> <br><br>
                    
                    <a href='login.php' class='btn' >Retour</a> <br>

                    
			</div>
		</div>
	</form>
";
if(isset($_POST['valider'])){

session_start();

$servername = 'localhost';
$username = 'root';
$password = '';
$conn = new PDO("mysql:host=$servername;dbname=travail",$username,$password);

$recherche1=$conn->prepare("select * from demandeur where cin= :ab");
$ab = strval($_POST['CIN']);
$recherche1->bindParam(':ab', $ab);
$recherche1->execute();
$result = $recherche1->fetchAll();
$nombre = count($result);

$recherche2=$conn->prepare("select count(*) from demandeur where cin= :cd");
$cd = $_POST['Pseudo'];
$recherche2->bindParam(':cd', $cd);
$recherche2->execute();
$result1 = $recherche1->fetchAll();
$nombre1 = count($result1);

if($nombre>0){
    ?>
    <script>
        let myError=document.getElementById('erreur');
        myError.innerHTML='CIN deja existante !!';
        myError.style.color='red';
    </script>
    <?php
}
else if($nombre1>0){
    
    ?>
    <script>
        let myError=document.getElementById('erreur');
        myError.innerHTML='Pseudo deja existant !!';
        myError.style.color='red';
    </script>
    <?php
}
else{
    $_SESSION['cin'] = strval($_POST['CIN']);
    $_SESSION['nom'] = $_POST['Nom'];
    $_SESSION['prenom'] = $_POST['Prenom'];
    $_SESSION['pseudo'] = $_POST['Pseudo'];
    $_SESSION['mp'] = $_POST['MP'];
    $_SESSION['mail'] = $_POST['Mail'];

    header("location: deposercv.php");
}
$conn=null;
}
?>
<script>



let formulaire = document.getElementById('form');
formulaire.addEventListener('submit',function(e){
  
    let Nom=document.getElementById("Nom");
    let Prenom=document.getElementById("Prenom");
    let pseudo=document.getElementById("pseudo");
    let pass=document.getElementById("pass");
    let cin=document.getElementById("cin");
    let email = document.getElementById("email");
    let cpass = document.getElementById("cpass");

    let regExpPrenom=/^[a-zA-Z\s]+$/;
    let regExNom=/^[a-zA-Z\s]+$/;
    let regExpseudo=/^[a-zA-Z\s]+$/;
    let regExpass=/^[a-zA-Z\s]+$/;
    let regExEmail= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/ ;
    let myError=document.getElementById('erreur');
    myError.style.color='red';
    
     
 
    
    // controle du Nom
    if (Nom.value.trim()=='')
    {	
		myError.innerHTML='Le champ Nom est requis';
		myError.style.color='red';
		e.preventDefault();
    }
    else if(regExNom.test(Nom.value)==false){

		myError.innerHTML="Le champ Nom doit être composé de lettres ou d'espaces";
		e.preventDefault();
    }else
    //  control du Prenom
    if (Prenom.value.trim()=='')
    {	
		myError.innerHTML='Le champ Prenom est requis';
		myError.style.color='red';
		e.preventDefault();
    }
    else if(regExpPrenom.test(Prenom.value)==false){

		myError.innerHTML="Le champ Prenom doit être composé de lettres ou d'espaces";
		e.preventDefault();
    }else 
    //controle du cin
    if (cin.value.trim()=='')
    {	
		myError.innerHTML='Le champ cin est requis';
		e.preventDefault();
    }
    else
	    if(Number(cin.value)>99999999   || Number(cin.value) < 10000000 ){
			myError.innerHTML="veuillez saisir un cin valide";
			e.preventDefault();
	    }
       else
    //controle de l'email
    if (email.value.trim()=='')
    {	
		myError.innerHTML='Le champ Email est requis';
		e.preventDefault();
    }
    else 
      if(regExEmail.test(email.value)==false){
		myError.innerHTML="L'adresse Email n'est pas valide";
		e.preventDefault();
      }else
     // controle du pseudo
     if (pseudo.value.trim()=='')
     {	
         myError.innerHTML='Le champ pseudo est requis';
         myError.style.color='red';
         e.preventDefault();
     }
     else if(regExpseudo.test(pseudo.value)==false){
 
         myError.innerHTML="Le champ pseudo doit être composé de lettres ou d'espaces";
         e.preventDefault();
     }else
     //  control du pass
     if (pass.value.trim()=='')
     {	
         myError.innerHTML='Le champ password est requis';
         myError.style.color='red';
         e.preventDefault();
     }
     
     else if (pass.value.length<8){
         myError.innerHTML="Le champ password doit avoir minimun 8 carateres";
         e.preventDefault();
     }else
     

     //  control du confirmationde passeword
     if (cpass.value.trim()=='')
     {	
         myError.innerHTML='Le champ confirmer password est requis';
         myError.style.color='red';
         e.preventDefault();
     }
     else 
        if(cpass.value!=pass.value){
        myError.innerHTML='Vous avez pas bien confirmer votre passeword';
         myError.style.color='red';
         e.preventDefault();
     }
 
    

})
</script>    

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


/* .infobox{
	max-width: 850px;
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	background-color: #fff;
	box-shadow: 0px 0px 19px 5px rgba(0,0,0,0.19);
} */



h2{
	position: relative;
	padding: 0 0 10px;
	margin-bottom: 10px;
    margin-top: 20px;
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

.field{
	width: 90%;
	border: 2px solid rgba(0, 0, 0, 0);
	outline: none;
	background-color: rgba(230, 230, 230, 0.6);
	padding: 0.5rem 1rem;
	font-size: 1.1rem;
	margin-bottom: 22px;
	border-radius: 8px;
}

.field:hover{
	background-color: rgba(0, 0, 0, 0.1);
}



.btn{
	width: 90%;
	padding: 0.5rem 1rem;
	background-color: #2ecc71;
	color: #fff;
	font-size: 1.1rem;
	border: none;
	outline: none;
	cursor: pointer;
	transition: .3s;
    border-radius: 10px;
    margin-bottom: 3px;
}

.btn:hover{
    background-color: #27ae60;
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
    background-color: white;
    border-radius: 10px;
    text-align: center;
}

.right {
    grid-column: 1 / 2;
}

.left {
    grid-column: 2 / 3;
}
</style>