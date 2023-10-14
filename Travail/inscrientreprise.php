<?php

class Entreprise{

    private $CRC;
    private $pseudo;
    private $noment;
    private $mp;
    private $nomg;
    private $prenomg;
    private $mailg;
   


    public function get_CRC(){
        return $this->CRC;
    }
    public function get_pseudo(){
        return $this->pseudo;
    }
    public function get_mp(){
        return $this->mp;
    }
    public function get_noment(){
        return $this->noment;
    }
    public function get_nomg(){
        return $this->nomg;
    }
    public function get_prenomg(){
        return $this->prenomg;
    }
    public function get_mailg(){
        return $this->mailg;
    }
    

    public function set_CRC($CRC){
        $this->CRC=$CRC;
    }
    public function set_noment($noment){
        $this->noment=$noment;
    }
    public function set_pseudo($pseudo){
        $this->pseudo=$pseudo;
    }
    public function set_mp($mp){
        $this->mp=$mp;
    }
    public function set_nomg($nomg){
        $this->nomg=$nomg;
    }
    public function set_prenomg($prenomg){
        $this->prenomg=$prenomg;
    }
    public function set_mailg($mailg){
        $this->mailg=$mailg;
    }

    public function __construct($CRC,$noment,$pseudo,$mp, $nomg,$prenomg,$mailg){
        $this->CRC =$CRC ;
        $this->noment =$noment;
        $this->pseudo =$pseudo ;
        $this->mp =$mp;
        $this->nomg =$nomg;
        $this->prenomg =$prenomg ;
        $this->mailg =$mailg;
        }
    }
    echo"
    <form class='login' id='form' method='POST' >
		<div class='infobox'>
		<h2>S'inscrire</h2>
		<div class='right'>
                <input type='text' id='NomEnt' class='field'  placeholder='Nom Entreprise' name='noment'>
                <input type='text' id='NomGer' class='field' placeholder='Nom Gerant' name='nomg'>
                <input type='text' id='PrenomGer' class='field' placeholder='Prenom Gerant' name='prenomg'>
                <input type='email' id='email' class='field' placeholder='Mail Gerant' name='mailg'>
                </div>
                <div class='left'>
                <input type='text' id='crc' class='field' placeholder='CRC' name='CRC'>
                <input type='text' id='pseudo' class='field' placeholder='Pseudo' name='Pseudo'>
                <input type='password' id='pass' class='field' placeholder='Mot de passe' name='MP'>
                <input type='password' id='cpass' class='field' placeholder='Confirmer le mot de passe'>
                </div>
                <button type='submit' class='btn' name='inscrire'>S'inscrire</button> <br>
                <a href='login.php' class='btn'>Retour</a> <br>
                <p id='erreur'class='erreur'></p>
		</div>
	</form>";
    if(isset($_POST['inscrire'])){
    
    $servername = 'localhost'; 
    $username = 'root';
    $password = '';
    $conn = new PDO("mysql:host=$servername;dbname=travail",$username,$password);
    
    $recherche1=$conn->prepare("select * from entreprise where crc= :ab");
    $ab = $_POST['CRC'];
    $recherche1->bindParam(':ab', $ab);
    $recherche1->execute();
    $result = $recherche1->fetchAll();
    $nombre = count($result);
    
    $recherche2=$conn->prepare("select * from entreprise where pseudo= :cd");
    $cd = $_POST['Pseudo'];
    $recherche2->bindParam(':cd', $cd);
    $recherche2->execute();
    $result1 = $recherche2->fetchAll();
    $nombre1 = count($result1);
    if($nombre>0){
        // header("location :inscrientreprise.php");
    ?>
    <script>
        let erreur=document.getElementById('erreur');
		erreur.innerHTML="CRC deja existant";
		erreur.style.color='red';
    </script>
    <?php
    }
    else if($nombre1>0){
        ?>
    <script>
        let erreur=document.getElementById('erreur');
		erreur.innerHTML="Pseudo deja existant";
		erreur.style.color="red";
        
        
    </script>
    <?php
    }
    else{

$entreprise =new Entreprise($_POST['CRC'],$_POST['noment'],$_POST['Pseudo'],$_POST['MP'],$_POST['nomg'],$_POST['prenomg'],$_POST['mailg']);

$ajout=$conn->prepare("insert into entreprise values (:crc,:pseudo,:mp,:noment,:nomg,:prenomg,:mailg)");

$crc=$entreprise->get_CRC() ;
$noment=$entreprise->get_noment() ;
$pseudo=$entreprise->get_pseudo() ;
$mp=$entreprise->get_mp() ;
$nomg=$entreprise->get_nomg() ;
$prenomg=$entreprise->get_prenomg() ;
$mailg=$entreprise->get_mailg() ;

$ajout->bindParam(':crc', $crc);
$ajout->bindParam(':noment', $noment);
$ajout->bindParam(':pseudo', $pseudo);
$ajout->bindParam(':mp', $mp);
$ajout->bindParam(':nomg', $nomg);
$ajout->bindParam(':prenomg', $prenomg);
$ajout->bindParam(':mailg', $mailg);

$ajout->execute();

session_start();
$_SESSION['crc']=$crc;

header("location: accountentreprise.php");

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
    background-color: #b5f0b9;
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

.erreur{
	width: 90%;
	padding: 0.5rem 1rem;
	border: none;
	outline: none;
	cursor: pointer;
	transition: .3s;
    border-radius: 10px;
    margin-bottom: 10px;
    margin-left: 270px;
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
    margin-bottom: 5px;
    margin-left: 270px;
    
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

<script>
    


let formulaire = document.getElementById('form');
formulaire.addEventListener('submit',function(e){
  
    let NomEnt=document.getElementById("NomEnt");
    let PrenomGer=document.getElementById("PrenomGer");
    let NomGer=document.getElementById("NomGer");
    let pseudo=document.getElementById("pseudo");
    let pass=document.getElementById("pass");
    let cpass=document.getElementById("cpass");
    let email = document.getElementById("email");
    let crc = document.getElementById("crc");

    let regExpPrenomGer=/^[a-zA-Z\s]+$/;
    let regExpNomGer=/^[a-zA-Z\s]+$/;
    let regExpcrc=/^[a-zA-Z0-9\s]+$/;
    let regExNomEnt=/^[a-zA-Z\s]+$/;
    let regExpseudo=/^[a-zA-Z\s]+$/;
    let regExpass=/^[a-zA-Z\s]+$/;
    let regExEmail= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/ ;
    let myError=document.getElementById('erreur');
    myError.style.color='red';
    
    // controle du Nom de l'entreprise
    if (NomEnt.value.trim()=='')
    {	
		myError.innerHTML='Le champ Nom de Entreprise est requis';
		myError.style.color='red';
		e.preventDefault();
    }
    else if(regExNomEnt.test(NomEnt.value)==false){

		myError.innerHTML="Le champ Nom de L'Entreprise doit être composé de lettres ou d'espaces";
		e.preventDefault();
    }else
    //  control du prenom gerant
    if (PrenomGer.value.trim()=='')
    {	
		myError.innerHTML='Le champ prenom gerant est requis';
		myError.style.color='red';
		e.preventDefault();
    }
    else if(regExpPrenomGer.test(PrenomGer.value)==false){

		myError.innerHTML="Le champ prenom gerant doit être composé de lettres ou d'espaces";
		e.preventDefault();
    }else

    //  control du nom gerant
    if (NomGer.value.trim()=='')
    {	
		myError.innerHTML='Le champ nom gerant est requis';
		myError.style.color='red';
		e.preventDefault();
    }
    else if(regExpNomGer.test(NomGer.value)==false){

		myError.innerHTML="Le champ nom gerant doit être composé de lettres ou d'espaces";
		e.preventDefault();
    }else
   
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
      // controle CRC
    if (crc.value.trim()=='')
    {	
		myError.innerHTML='Le champ CRC est requis';
		myError.style.color='red';
		e.preventDefault();
    }
    else if((regExpcrc.test(crc.value)==false)&&(crc.value.length!=5)){

		myError.innerHTML="Le champ CRC doit être composé de 5 lettres, chiifres ou d'espaces";
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
     }else//  control du confirmation de passeword
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