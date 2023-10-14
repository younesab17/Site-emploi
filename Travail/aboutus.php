<?php
echo"
<div class='about'>
        <div class='inner-section'>
            <h1>About Us</h1>
            <p class='text'>
                Find me job est une application web qui vous permet des chercher des opportunités 
                d'emploi qui conviennent avec vos compétences et vos diplomes en tant qu'un demandeur d'emploi.
                En outre , il vous permet, en tant qu'un gérant d'entreprise, de publier des offres d'emploi et gérer 
                les demandes des postulants.  
            </p>
            <div class='skills'>
                <a href='contactus.php'>Contact Us</a>
                <br><br>
                <a class='retour'  href='index.php'>Back</a>
            </div>
        </div>
    </div>";
?>




<style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body{
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f1f1f1;
}
.about{
    background: url(wimi-autonomie-travail.jpg) no-repeat left;
    background-size: 73%;
    background-color: #fdfdfd;
    overflow: hidden;
    padding: 100px 0;
}
.about::after{
    content: '';
	position: absolute;
	width: 100%;
	height: 100%;
	left: 0;
	top: 0;
	background: url("wimi-autonomie-travail.jpg") no-repeat center;
	background-size: cover;
	filter: blur(50px);
	z-index: -1;
}
.inner-section{
    width: 55%;
    float: right;
    background-color:#2ecc71;
    padding: 140px;
    box-shadow: 13px 12px 8px rgba(0,0,0,0.3);
}
.inner-section h1{
    margin-bottom: 30px;
    font-size: 30px;
    font-weight: 900;
    color:#fff;
}
.text{
    font-size: 13px;
    color: #fff;
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    line-height: 30px;
    text-align: justify;
    margin-bottom: 40px;
}
.skills a{
    font-size: 22px;
    text-align: center;
    letter-spacing: 2px;
    border: none;
    border-radius: 20px;
    padding: 8px;
    width: 200px;
    text-decoration: none;
    background-color: #00999c;
    color: white;
    cursor: pointer;
}
.skills a:hover{
    transition: 1s;
    background-color: #ecf5f5;
    color: #00999c;
}
.retour{
    font-size: 18px;
    text-align:center;
    letter-spacing: 2px;
    border: none;
    border-radius: 20px;
    padding: 8px;
    width: 100px; 
     text-decoration: none;
    background-color: #00999c;
    color: white;
    cursor: pointer;
    margin-left: 400px;

}
@media screen and (max-width:1200px){
    .inner-section{
        padding: 80px;
    }
}
@media screen and (max-width:1000px){
    .about{
        background-size: 100%;
        padding: 100px 40px;
    }
    .inner-section{
        width: 100%;
    }
}

@media screen and (max-width:600px){
    .about{
        padding: 0;
    }
    .inner-section{
        padding: 60px;
    }
    .skills a{
        font-size: 19px;
        padding: 5px;
        width: 160px;
    }
}
</style>