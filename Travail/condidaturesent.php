<?php 
session_start();
echo '<div class="login" > <div class="infobox" id="wa">';
$id=$_SESSION['id'];
$exp=$_SESSION['exp'];
$diplome=$_SESSION['dip'];
$servername = 'localhost';
$username = 'root';
$password = '';

$conn = new PDO("mysql:host=$servername;dbname=travail",$username,$password);
$affichage=$conn->prepare("select demandeur.cin,nom,prenom,pdd,diplome,fac,mail,experience,score,reponse from condidature,demandeur where demandeur.cin=condidature.cin and condidature.id=:id");
$affichage->bindParam(":id",$id);
$affichage->execute();
$liste=$affichage->fetchAll();

$comp1=$conn->prepare("select comp from competence_offre where id=:id");
$comp1->bindParam(":id",$id);
$comp1->execute();
$competences=$comp1->fetchAll();

foreach($liste as &$one){
    $comp=$conn->prepare("select * from competence_dem  where  competence_dem.cin=:cin");
    $comp->bindParam(":cin",$one['cin']);
    $comp->execute();
    $comp_dem=$comp->fetchAll();
    $one['score']=scoring($one,$diplome,$competences,$comp_dem,$exp);
}
usort($liste,"compare");


if(isset($_POST['offres'])){
    $cin=$_POST['cin'];
    $accept=$conn->prepare("update condidature set reponse= 'accepte(e)' where cin=:cin and id=:id");
    $accept->bindParam(":cin",$cin);
    $accept->bindParam(":id",$id);
    $accept->execute();
    header("location: condidaturesent.php");

}
if(isset($_POST['delete'])){
    $cin=$_POST['cin'];
    $delete=$conn->prepare("update condidature set reponse= 'refuse(e)' where cin=:cin");
    $delete->bindParam(":cin",$cin);
    $delete->execute();
    header("location: condidaturesent.php");

}


if(count($liste)==0){
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
  foreach($liste as $item){
    $cin=$item['cin'];
    $pdd=$item['pdd'];
    $nom=$item['nom'];
    $prenom=$item['prenom'];
    $diplome=$item['diplome'];
    $fac=$item['fac'];
    $mail=$item['mail'];
    $experience=$item['experience'];
    $reponse=$item['reponse'];
    $comp=$conn->prepare("select * from competence_dem  where  competence_dem.cin=:cin");
    $comp->bindParam(":cin",$cin);
    $comp->execute();
    $comp_dem=$comp->fetchAll();
    $comps="| ";
    foreach($comp_dem as $comp_item){
        $comps=  $comps.$comp_item['comp']." | ";
    }
    $classreponse="";
    $classaccepte="";
    $classrefuse="";
    if($reponse==='accepte(e)'){
      $classreponse="oui";
      $classaccepte="hide";
      $classrefuse="hide";
    }
    else if($reponse==='refuse(e)'){
      $classreponse="non";
      $classaccepte="hide";
      $classrefuse="hide";
    }
    else{
      $classreponse="reponse";
      $classaccepte="accepter";
      $classrefuse="refuser";
    }
    

    echo"
    <div class='offre'> 
  <div class='pdp'>
  <img class='photo' src='data:image/jpeg;base64," . base64_encode($pdd) . "' />
      <div id=$classreponse> $reponse</div>
  </div> 
  <div class='infos'>
    <div class='part'><p>Nom Prenom : $nom  $prenom</p></div>
    <div class='part'><p>Diplome :$diplome</p></div>
    <div class='part'><p>Competence(s) :  $comps </p></div>
    <div class='part'>
      <form  class='part' method='POST'  >
        <input type='text' name='cin' style='display:none' value=$cin>
        <button type='submit' id=$classaccepte class='btn1' name='offres' >Accepter</button> 
      </form>
  </div>
  </div>

  <div class='infos'>
 
    <div class='part'><p>Mail: $mail</p></div>
    <div class='part'><p>Faculté :$fac</p></div>
    <div class='part'><p>Année(s) d'experience : $experience </p></div>
    <div class='part'>
      <form  class='part'  method='POST'  >
        <input type='text' name='cin' style='display:none' value=$cin>
        <button type='submit' id=$classrefuse class='btn' name='delete' >Refuser</button> 
      </form>
  </div>
  </div>
</div>";


}

}





function scoring($row,$diplome,$competences,$comp_dem,$exp){
    $score=0;

        if($row['experience']>=$exp){
            $score=$score+($row['experience']-$exp)*2;
        }
        foreach($competences as $one){
            foreach($comp_dem as $comp){
                if($one['comp']===$comp['comp']){
                $score=$score+5;
            }
            }
        }
    
    return $score;
}


function compare($a,$b){
    return  $b['score'] - $a['score'];
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
    height: 90%;
    
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
  padding: 10px;
  height: 150px;
  /* border: 1px solid #ccc; */
  border-radius: 5px;
  margin-bottom: 10px;
  background-color: rgba(254, 251, 251, 0.753);
  /* background-color: rgba(223, 33, 33, 0.753); */
}
.pdp{
  width: 20%;
  height: 100%;


}
.photo{
  margin-top: 5px;
  margin-left: 10px;
  height: 90px;
  width: 90px;
  border-radius: 50%;
}
.infos {
  display: flex;
  width: 37.5%;
  height: 100%;
  flex-direction: column;
  justify-content: space-between;
  margin-bottom: 10px;
}
.part{
  margin-left:15px ;
  margin-top: 5px;
  text-align: center;
  height: 25%;
  width: 100%;
}

.btn1{
  background-color: #38c320;
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

.btn1:hover{
  background-color: #09f363;
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
#reponse{
    background-color: #696c6a;
    /* refusée background-color: #e84646; */
    /* acceptee ::background-color:  #58e191; */
  color: white;
  border: none;
  margin-top: 5px;
  margin-left: 5px;
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
  margin-top: 5px;
  margin-left: 5px;
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
  margin-top: 5px;
  margin-left: 5px;
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



        
    