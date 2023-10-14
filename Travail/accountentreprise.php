


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
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
    
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
    .infobox {
  background-color: #f1f1f1;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.haut {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.gauche{
  border-right: 1px solid #ccc;
  width: 50%;
  margin-right: 40px;
  margin-left: 30px;

}
.droite {
  width: 50%;
  margin-right: 40px;
  margin-left: 10px;
}

#crc,
#infos {
  font-weight: bold;
  font-size: 14px;
}

.bas {
  display: flex;
  justify-content: center;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
}

li {
  margin: 5px 10px;
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
.btn {
  color: #2ecc38;
  text-decoration: none;
  font-weight: bold;
  font-size: 18px;
  border:none;
  cursor:pointer;
  transition: color 0.3s ease;
}

.btn:hover {
  color: #4CAF50;
}


</style>




<?php
session_start();

if(isset($_SESSION['pseudo'])){
$servername = 'localhost';
$username = 'root';
$password = '';

$conn = new PDO("mysql:host=$servername;dbname=travail",$username,$password);
$pseudo=$_SESSION['pseudo'];


$recuperer=$conn->prepare("select crc,nom_ent,nom_g,prenom_g from entreprise where pseudo = :ps");
$recuperer->bindParam(':ps', $pseudo);
$recuperer->execute();
$resultat=$recuperer->fetchAll();
foreach($resultat as $one){
    $crc=$one['crc'];
    $noment=$one['nom_ent'];
    $nomg=$one['nom_g'];
    $prenomg=$one['prenom_g'];
}
echo"<div class='login' >
<div class='infobox'>
    <h2> Mon compte</h2><br>
    <div class='haut'>
        <div class='gauche' ><p id='crc'>CRC : $crc <br><br>Pseudo:   $pseudo</p></div>
        <div class='droite' ><p id='infos'> Nom de l'entreprise : $noment    <br> <br>  Nom du Gérant : $nomg<br><br>Prenom du Gérant  : $prenomg</p></div>
    </div>
    <form class='bas' method=POST>
        <ul>
        <li><button type='submit' class='btn' name='offres' >Mes offres</button></li>
        <li><button type='submit' class='btn' name='proposer' >Publier un offre</button></li>
        <li><button type='submit' class='btn' name='logout' >Logout</button></li>
        </ul>
    </from> 
</div>
</div>";
$_SESSION['crc']=$crc;
if(isset($_POST['offres'])){
  header("Location: mesoffres.php");
}
if(isset($_POST['proposer'])){
  header("Location: offre.html");
}
if(isset($_POST['logout'])){
  header("Location: login.php");
  session_destroy();
}

}
else{
  header("Location: login.php");
}
?>


<script>
    let code=document.getElementById("crc");
    let crc='<?php echo $crc ?>';
    let pseudo='<?php echo $pseudo ?>';
    code.innerHTML="CRC :"+crc+"<br><br>Pseudo:   "+pseudo;

    let def=document.getElementById("infos");
    let NomEnt='<?php echo $noment ?>';
    let NomG='<?php echo $nomg ?>';
    let PrenomG='<?php echo $prenomg ?>';
    let infos="  Nom de l'entreprise : "+NomEnt+"<br> <br>  Nom du Gérant : "+NomG+"<br><br>Prenom du Gérant  : "+PrenomG;
    def.innerHTML=infos;
</script>




