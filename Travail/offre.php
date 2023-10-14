<?php
session_start();
class offre{

    private $titre;
    private $description;
    private $salaire;
    private $experience;
    private $diplome;
    
    public function get_titre(){
        return $this->titre;
    }
    public function get_description(){
        return $this->description;
    }
    public function get_salaire(){
        return $this->salaire;
    }
    public function get_experience(){
        return $this->experience;
    }
    public function get_diplome(){
        return $this->diplome;
    }

    public function set_titre($titre){
        $this->titre=$titre;
    }
    public function set_noment($description){
        $this->description=$description;
    }
    public function set_salaire($salaire){
        $this->salaire=$salaire;
    }
    public function set_experience($experience){
        $this->experience=$experience;
    }
    public function set_diplome($diplome){
        $this->diplome=$diplome;
    }


    public function __construct($titre,$description,$salaire,$experience, $diplome){
        $this->titre =$titre ;
        $this->description =$description;
        $this->salaire =$salaire ;
        $this->experience =$experience;
        $this->diplome =$diplome;
        }
    }

$offre = new offre($_POST['titre'],$_POST['description'],$_POST['salaire'],$_POST['experience'],$_POST['diplomes']);


$pseudo=$_SESSION['pseudo'];


$servername = 'localhost';
$username = 'root';
$password = '';

$conn = new PDO("mysql:host=$servername;dbname=travail",$username,$password);
$insert=$conn->prepare("insert into offre (titre,description,experience,salaire,diplome,score,crc) values (:titre , :desc , :exp , :sal , :diplome ,:score, :crc)");

$crc=$_SESSION['crc'];
$titre=$offre->get_titre();
$desc=$offre->get_description();
$sal=$offre->get_salaire();
$exp=$offre->get_experience();
$diplome=$offre->get_diplome();
$score=0;

$insert->bindParam(":titre",$titre);
$insert->bindParam(":desc",$desc);
$insert->bindParam(":exp",$exp);
$insert->bindParam(":sal",$sal);
$insert->bindParam(":diplome",$diplome);
$insert->bindParam(":score",$score);
$insert->bindParam(":crc",$crc);


$insert->execute();

$competences=$_POST['competences'];
$n=count($competences);
for($i=0;$i<$n;$i++){
    $insert1=$conn->prepare("insert into competence_offre values (:comp , LAST_INSERT_ID() )");
    $insert1->bindParam(":comp",$competences[$i]);
    $insert1->execute();
}
?>
<script>
    alert("Votre offre est crée avec succés !!");
</script>
<?php
header("location: accountentreprise.php");
?>