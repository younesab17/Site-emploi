
<?php 
echo '<div class="login" > <div class="infobox" id="wa">';
$servername = 'localhost';
$username = 'root';
$password = '';
session_start();
$conn = new PDO("mysql:host=$servername;dbname=travail",$username,$password);
$pseudo=$_SESSION['pseudo'];

$recuperer=$conn->prepare("select nom_ent ,  id ,  titre,salaire , diplome ,description,experience from entreprise , offre  where pseudo = :ps and  offre.crc=entreprise.crc");
$recuperer->bindParam(':ps', $pseudo);
$recuperer->execute();
$resultat=$recuperer->fetchAll();
if(count($resultat)==0){
  echo"<p id='rien'>Vous n'avez publié aucun offre !!</p>";
?>

<script>


let ab=document.getElementById('wa');
ab.style.backgroundColor="rgba(254, 251, 251, 0.753)";
ab.style.width="50%";
ab.style.height="50%";

let p=document.getElementById('rien');
p.style.top="40%";
p.style.left="25%";
p.style.position="absolute";
p.style.fontSize="18px";
p.style.color="#ae3427";
// p.style.transform="translate(-50%, -50%)";
</script>

<?php
}
else{

foreach($resultat as $one){
    $noment=$one['nom_ent'];
    $id=$one['id'];
    $titre=$one['titre'];
    $salaire=$one['salaire'];
    $diplome=$one['diplome'];
    $description=$one['description'];
    $experience=$one['experience'];
    echo"<div class='offre'> 
        <div class='infos'>
            <div class='titre'>  <p> Poste : $titre</p>  </div>
            <div class='description'><p>Description : $description</p></div>
        </div>
        <div class='infos'>
            <div class='salaire'><p>Salaire : $salaire DT</p></div>
            <div class='diplome'><p>Diplome demandé : $diplome</p></div>
        </div>
        <div class='infos'>
            <div class='delete'>
                <form method='POST' action='' >
                  <input type='text' name='id' style='display:none' value=$id>
                  <input type='text' name='exp' style='display:none' value=$experience>
                  <input type='text' name='dip' style='display:none' value='" . $diplome . "'>


                  <button type='submit' class='btn' name='offres' >Condidatures</button> 
                </form>
            </div>
            <div class='idetent'>
                <form method='POST' action='' >
                  <input type='text' name='id' style='display:none' value=$id>
                  <button type='submit' class='btn' name='supprimer' >Retirer</button>
                </form>
            </div>
        </div>
    </div>";
}
}

    if(isset($_POST['supprimer'])) {
        $id = $_POST['id']; 
        $delete=$conn->prepare("delete from offre where id=:x");
        $delete->bindParam(':x',$id);
        $delete->execute();
        header('Location: ' . $_SERVER['REQUEST_URI']); // rediriger la page après suppression
        exit(); // arrêter l'exécution du script
    }
    if(isset($_POST['offres'])) {
      $id = $_POST['id']; 
      $experience=$_POST['exp'];
      $diplome=$_POST['dip'];
      $_SESSION['exp']=$experience;
      $_SESSION['id']=$id;
      $_SESSION['dip']=$diplome;
      header("Location: condidaturesent.php"); 
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

.infobox{
    display: flex;
    flex-direction: column;
    width: 70% ;
    /* height: 70%; */
    
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 5px;
    margin-top: 30px;
    margin-bottom: 30px;


}
.offre {
  display: flex;
  flex-direction: column;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 10px;
  background-color: rgba(254, 251, 251, 0.753);
}

.offre .infos {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  margin-bottom: 10px;
}

.offre .titre {
  font-weight: bold;
  margin-bottom: 10px;
  font-size: 18px;
}

.offre .description {
  width: 50%;
  /* margin-top: 5px;
  margin-bottom: 10px; */
  /* margin-right: 95px; */
  font-size: 16px;
  margin-left: 0px;
 /* float: right; */
}

.offre .salaire {
  font-size: 16px;
}

.offre .diplome {
  font-size: 16px;
  width: 50%;

  margin-left: 0px;
}

.offre .idetent {
  margin-top: 10px;
}

.offre .btn {
  background-color: #f44336;
  color: white;
  border: none;
  padding: 8px 27px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.offre .btn:hover {
  background-color: #d32f2f;
}
.delete .btn {
background-color: rgb(123, 249, 151);
  color: white;
  border: none;
  padding: 9px 16px;
  text-align: center;
  margin-top: 9px;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.delete .btn:hover {
  background-color:  #27ae60;
}
</style> 




