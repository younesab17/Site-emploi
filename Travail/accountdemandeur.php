
<?php 
session_start();

if(isset($_SESSION['pseudo'])){

$servername = 'localhost';
$username = 'root';
$password = '';

$conn = new PDO("mysql:host=$servername;dbname=travail",$username,$password);
$pseudo=$_SESSION['pseudo'];
$recuperer=$conn->prepare("select cin,nom,prenom,numtlf,mail,pdd,type from demandeur where pseudo = :ps");
$recuperer->bindParam(':ps', $pseudo);
$recuperer->execute();
$resultat=$recuperer->fetchAll();

foreach($resultat as $one){
    $cin=$one['cin'];
    $nom=$one['nom'];
    $prenom=$one['prenom'];
    $tlf=$one['numtlf'];
    $mail=$one['mail'];
    $type=$one['type'];
    $pdd= $one['pdd'];
    $_SESSION['cin']=$cin;
//     $imgdata = file_get_contents($pdd);
//     $imgbase64 = 'data:' . $filetype . ';base64,' . base64_encode($imgdata);
// echo '<img src="' . $imgbase64 . '" alt="mon image" title="image"/>';

//     $image_data = 'data:' . $type . ';base64,' . base64_encode($pdd);
// <img src='data:image/jpeg;base64,' . base64_encode($donnees['image']) . ''  alt='mon image' title='image'/>
// <img id='pdd' src=$image_data></img>

if(isset($_POST['marche'])){
    header("Location: marche.php");
  }
  if(isset($_POST['condidats'])){
    header("Location: condidats.php");
  }
  if(isset($_POST['logout'])){
    header("Location: login.php");
    session_destroy();

  }


echo"<div class='login' >
<div class='infobox'>
    <h2> Mon compte</h2><br>
    <div class='haut'>
        <div class='gauche' ><img class='pdp' src='data:image/jpeg;base64," . base64_encode($pdd) . "' />
        <br><p id='crc'>CIN : $cin <br><br>Pseudo:   $pseudo</p>
        </div>
        <div class='droite' ><p id='infos'> <br>Nom Prenom: $nom $prenom    <br> <br> Telephone : $tlf <br><br>  Mail : $mail<br><br><br><br></p>
        </div>
        </div>
        <form class='bas' method=POST>
        <ul>
        <li><button type='submit' class='btn' name='marche' >Marché</button></li>
        <li><button type='submit' class='btn' name='condidats' >Mes condidatures</button></li>
        <li><button type='submit' class='btn' name='logout' >Logout</button></li>
        </ul>
        </from> 



</div>
</div>";
}
}
else{
    header("Location: login.php");
  }
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
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 65%;
  height: 60%;
  margin: 0 auto;
  background-color: #f2f2f2;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 20px;
}

h2{
	position: relative;
  text-align: center;
  font-size: 25px;
	padding: 0 0 10px;
	margin-bottom: 10px;
  margin-left: -60px;
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

.haut {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;

}

.gauche {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 40%;
  padding: 10px;
  border-right: 1px solid #ccc;
}

.pdp {
  width: 120px;
  height: 120px;
  border-radius: 50%;
}

.droite {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 50%;
  padding: 10px;
}

#infos {
  font-size: 18px;
  text-align: center;
  color: #333;
  margin-top: 20px;
}

.bas {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
}

.btn {
  color: #2ecc38;
  text-decoration: none;
  font-weight: bold;
  font-size: 16px;
  border:none;
  cursor:pointer;
  transition: color 0.3s ease;
}

.btn:hover {
  color: #4CAF50;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex;
  margin-top: 5px;
  justify-content: center;
}

li {
  margin: 5px 40px;
}
</style>

