
<?php 
echo '<div class="login" > <div class="infobox" id="wa">';
$servername = 'localhost';
$username = 'root';
$password = '';
session_start();
$conn = new PDO("mysql:host=$servername;dbname=travail",$username,$password);
$pseudo=$_SESSION['pseudo'];

$infos=$conn->prepare("select diplome from demandeur where pseudo=:ps ");
$infos->bindParam(":ps",$pseudo);
$infos->execute();
$affiche=$infos->fetchAll();
foreach($affiche as $one){
    $diplome_dem=$one['diplome'];
}


$cin=$_SESSION['cin'];
$infos1=$conn->prepare("select comp from competence_dem  where cin=:cin ");
$infos1->bindParam(":cin",$cin);
$infos1->execute();
$competences=$infos1->fetchAll();


$recuperer=$conn->prepare("select nom_ent, id, titre, salaire, diplome, description, score 
  from entreprise, offre 
  where offre.crc = entreprise.crc and id not in (select id from condidature where cin=:cin)");
$recuperer->bindParam(":cin",$cin);
$recuperer->execute();
$resultat=$recuperer->fetchAll();

if(count($resultat)==0){
  echo"<p id='rien'>Il n'y a aucun dans le marché pour le moment !!</p>";
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
</script>

<?php
}
else{
  foreach($resultat as &$one){
    $id=$one['id'];
    $diplome=$one['diplome'];
    $comp=$conn->prepare("select * from competence_offre  where  competence_offre.id=:id");
    $comp->bindParam(":id",$id);
    $comp->execute();
    $comp_offre=$comp->fetchAll();
    $one['score']=scoring($one,$diplome_dem,$competences,$comp_offre);
  }



$result_final = array();

for($i=0;$i<count($resultat);$i++){
  if($resultat[$i]['score']<=0){
    $result_final[]=$i;
  }
}

for($j=0;$j<count($result_final);$j++){
  unset($resultat[$j]);
}

usort($resultat,"compare");








if(count($resultat)==0){
  echo"<p id='rien'> Il n'existe pas un offre convenable avec votre cv pour le moment !!!</p>";
  ?>
  
  <script>
  
  
  let ab=document.getElementById('wa');
  ab.style.backgroundColor="rgba(254, 251, 251, 0.753)";
  ab.style.width="50%";
  ab.style.height="50%";
  
  let p=document.getElementById('rien');
  p.style.top="45%";
  p.style.left="15%";
  p.style.position="absolute";
  p.style.fontSize="14px";
  p.style.color="#ae3427";
  // p.style.transform="translate(-50%, -50%)";
  </script>
  
  <?php
}
else{
  for($i=0;$i<count($resultat);$i++){
    $noment=$resultat[$i]['nom_ent'];
    $id=$resultat[$i]['id'];
    $titre=$resultat[$i]['titre'];
    $salaire=$resultat[$i]['salaire'];
    $diplome=$resultat[$i]['diplome'];
    $description=$resultat[$i]['description'];
    
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
            <div class='idetent'>
                <form method='POST' action='' style='display:none'>
                  <input type='text' name='id'  value=$id>
                  <button type='submit' class='btn' name='supprimer' >Retirer</button>
                </form>
            </div>
            <div class='delete'>
                <form method='POST' action='' >
                  <input type='text' name='id'  style='display:none' value=$id>
                  <button type='submit' class='btn' name='postuler' >Postuler</button> 
                </form>
            </div>
        </div>
    </div>";
  }
}

    if(isset($_POST['postuler'])) {
      $id = $_POST['id']; 
      $postuler=$conn->prepare("insert into condidature values(:cin , :id, 'en attente')");
      $postuler->bindParam(":cin",$cin);
      $postuler->bindParam(":id",$id);
      $postuler->execute();
      header("location: marche.php");
      ?>
      <script>
        alert("votre demande d'emploi est envoyé avec succes !");
      </script>
      <?php
    }
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

  /* margin-right: 60px; */

}

.offre .idetent {
  margin-top: 10px;
}

.offre .btn {
  background-color: #f44336;
  color: white;
  border: none;
  margin-right: 30px;
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


<?php
function scoring($row,$diplome_dem,$competences,$comp_offre){
    $score=0;
    if($row['diplome']!==$diplome_dem){
      $score=0;
    }
    else {
      $score=$score+($row['salaire']/100);
      foreach($competences as $one){
          foreach($comp_offre as $comp){
            if($one['comp']===$comp['comp']){
              $score=$score+5;
            }
          }
      }
      
    }
    return $score;
  }



  function compare($a,$b){
    return  $b['score'] - $a['score'];
}
?>
