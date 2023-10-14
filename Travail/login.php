<?php
echo"
	<form class='login' id='form' method='POST' >
		<div class='infobox'>
			<div class='left'></div>
			<div class='right'>
				<h2>Se connecter</h2><br>
				<form method=POST>
				<input type='text' id='pseudo' class='field'  placeholder='Pseudo' name='Pseudo'>
				<input type='password' id='pass' class='field'  placeholder='Mot de passe' name='MP'>
				<p id='erreur'></p>
				<button type='submit' class='btn' name='cnx'>Connexion</button> <br><br>
				<a  href='index.php' class='btn'> Retour</a> <br><br>

				</form> 
                <h2>S'inscrire</h2> <br>
                <a href='inscridemandeur.php'>Postulant </a>
                <a href='inscrientreprise.php'>Employeur </a> 
			</div>
		</div>
	</form>
";
?>
<script>
	


let formulaire = document.getElementById('form');
formulaire.addEventListener('submit',function(e){
  
    let pseudo=document.getElementById("pseudo");
    let pass=document.getElementById("pass");
    let regExpseudo=/^[a-zA-Z\s]+$/;
    let regExpass=/^[a-zA-Z\s]+$/;
    let myError=document.getElementById('erreur');
    myError.style.color='red';
    
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
    }

})

</script>

<?php 




$servername = 'localhost';
$username = 'root';
$password = '';
$conn = new PDO("mysql:host=$servername;dbname=travail",$username,$password);

if(isset($_POST['cnx'])){
	session_start();
$pseudo=$_POST['Pseudo'];
$mp=$_POST['MP'];
$_SESSION['pseudo']=$pseudo;

$login1=$conn->prepare("select * from entreprise where pseudo= :ps and mp= :password");
$login1->bindParam(':ps', $pseudo);
$login1->bindParam(':password', $mp);
$login1->execute();
$result1 = $login1->fetchAll();
$nombre1 = count($result1);

$login2=$conn->prepare("select * from demandeur where pseudo= :ps and mp= :password");
$login2->bindParam(':ps', $pseudo);
$login2->bindParam(':password', $mp);
$login2->execute();
$result2 = $login2->fetchAll();
$nombre2 = count($result2);
if($nombre1>0){
    header("Location: accountentreprise.php");
}
else if($nombre2>0){
    header("Location: accountdemandeur.php");
}
else{
	?>
	<script>
		let erreur=document.getElementById('erreur');
		erreur.innerHTML="Merci de verifier vos infos de connexion";
		erreur.style.color='red';
		let pseudo=document.getElementById('pseudo');
		let mp=document.getElementById('pass');
		pseudo.innerHTML="";
		pass.innerHTML="";
	</script>
<?php 
}
}
$conn=null;

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
.infobox{
	max-width: 850px;
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	justify-content: center;
	align-items: center;
	text-align: center;
	background-color: #fff;

    border-radius: 10px;
}

.left{
	background: url("wimi-autonomie-travail.jpg") no-repeat center;
	background-size: cover;
	height: 100%;
    border-top-left-radius: 10px;
}

.right{
	padding: 25px 40px;
}

h2{
	position: relative;
	padding: 0 0 10px;
	margin-bottom: 10px;
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
    border-radius: 8px;
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

</style>