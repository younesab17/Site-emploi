<?php 
echo '<div class="login" > <div class="infobox" id="wa">';
$servername = 'localhost';
$username = 'root';
$password = '';
session_start();
$cin=$_SESSION['cin'];
$conn = new PDO("mysql:host=$servername;dbname=travail",$username,$password);
$pseudo=$_SESSION['pseudo'];

$condids=$conn->prepare("select nom_ent ,  offre.id ,  titre,salaire , diplome ,description,reponse from entreprise , offre ,
 condidature where  offre.crc=entreprise.crc and condidature.cin=:cin and  offre.id=condidature.id  ");
$condids->bindParam(":cin",$cin);
$condids->execute();
$mescondids=$condids->fetchAll();
if(count($mescondids)==0){
    echo"<p id='rien'>Vous n'avez fait aucune condidature pour le moment!!</p>";
  ?>
  
  <script>
  
  
  let ab=document.getElementById('wa');
  ab.style.backgroundColor="rgba(254, 251, 251, 0.753)";
  ab.style.width="50%";
  ab.style.height="50%";
  
  let p=document.getElementById('rien');
  p.style.top="45%";
  p.style.left="12%";
  p.style.position="absolute";
  p.style.fontSize="18px";
  p.style.color="#ae3427";
  </script>
  
  <?php
  }
  else{
    foreach($mescondids as $one){
        $noment=$one['nom_ent'];
        $id=$one['id'];
        $titre=$one['titre'];
        $salaire=$one['salaire'];
        $diplome=$one['diplome'];
        $description=$one['description'];
        $reponse=$one['reponse'];
        $classreponse="";
    $classretire="";
    $classrefuse="";
    if($reponse==='accepte(e)'){
      $classreponse="oui";
      $classretire="hide";
    }
    else if($reponse==='refuse(e)'){
      $classreponse="non";
      $classretire="hide";
    }
    else{
      $classreponse="reponse";
      $classretire="retirer";
    }
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
                    <form method='POST' action='' >
                      <input type='text' name='id' style='display:none' value=$id>
                      <div class='reponse' id=$classreponse >$reponse </div> 
                    </form>
                </div>
                <div class='delete'>
                    <form method='POST' action='' id='suppression'>
                      <input type='text' name='id' style='display:none' value=$id>
                      <button type='submit' class='btn' id=$classretire name='supprimer' >Retirer</button>
                    </form>
                </div>
            </div>
        </div>";
       
    }
  }

  if(isset($_POST['supprimer'])) {
    $id = $_POST['id']; 
    $postuler=$conn->prepare("delete from condidature where id=:id and cin=:cin");
    $postuler->bindParam(":cin",$cin);
    $postuler->bindParam(":id",$id);
    $postuler->execute();
    header("location: condidats.php");
    ?>
    <script>
      alert("votre suppresion du demande d'emploi est effectuée avec succes !");
    </script>
    <?php
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
  margin-top: 8px;
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
#reponse{
    background-color: #696c6a;
    /* refusée background-color: #e84646; */
    /* acceptee ::background-color:  #58e191; */
  color: white;
  border: none;
  margin-right: 30px;
  padding: 8px 27px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  border-radius: 5px;
  transition: background-color 0.3s;
}
#oui{
  background-color: #2ecc71;
    /* refusée background-color: #e84646; */
    /* acceptee ::background-color:  #58e191; */
  color: white;
  border: none;
  margin-right: 30px;
  padding: 8px 27px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  border-radius: 5px;
  transition: background-color 0.3s;
}
#non{
  background-color: #cc2e2e;
    /* refusée background-color: #e84646; */
    /* acceptee ::background-color:  #58e191; */
  color: white;
  border: none;
  margin-right: 30px;
  padding: 8px 27px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  border-radius: 5px;
  transition: background-color 0.3s;
}
#hide{
  display: none;
}
</style> 