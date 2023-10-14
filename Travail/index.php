<?php
echo "  <header>
<div class='header_section_1'>

</div>
<div class='header_section_2'>

</div>
<div class='header_section_3'>
    <div class='partition_1'>
        <div class='partion_1_head'>
            <div class='logo_container'>
                <div class='logo'>

                </div>
            </div>
            <nav>
                <ul>
                    <li><a href='login.php'>Login</a></li>
                    <li><a href='aboutus.php'>A propos</a></li>
                   
                </ul>
            </nav>
        </div>
        <h1 class='welcome_message'>Find me JOB </h1>
    </div>
    <div class='partition_2'>
        <div class='cart_container'>
            <div class='cart cart_1'>
                <div class='img_container img_1'>
              
                </div>
            </div>

            <div class='cart cart_2'>
                <div class='img_container img_2'>

                </div>
            </div>

            <div class='cart cart_3'>
                <div class='img_container img_3'>

                </div>
            </div>
        </div>
    </div>
</div>
</header>";
?>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

header {
    position: relative;
    height: 100vh;
    width: 100%;
    background-color: rgb(250, 250, 250);
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: 3fr 1fr;
}

.header_section_1 {
    background-color: crimson;
    position: relative;
    background-position: top;
    background-size: cover;
    background-repeat: no-repeat;
    background-image: url(wimi-autonomie-travail.jpg);
    filter:blur(3px);
}

.header_section_3 {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: 1fr 1fr;
}

.header_section_3 .partition_1 .partion_1_head {
    position: relative;
    height: auto;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo_container .logo {
    height: 70px;
    width: 200px;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    background-image: url(logo.png);
}

nav {
    transform: translateX(-50px);
    
}

nav ul {
    display: flex;
    list-style: none;
    gap: 10px;
}

nav ul li a {
    text-decoration: none;
    font-size: 1.2rem;
    font-weight: bolder;
    color: #333;
    margin-left: 5px;
    font-family: sans-serif;
    transition: all .3s ease;
    border-bottom: 2px solid #27ae60;
}

nav ul li a:hover {
    color: #27ae60;
}

.welcome_message {
    font-size: 10rem;
    -webkit-text-stroke: 2px #fff;
    color: transparent;
    font-family: sans-serif;
    transform: translate(5%, 60%);
    transition: .3s ease;
    cursor: pointer;
    display: inline-block;
}

.welcome_message:hover {
    color:#54b97e;
    -webkit-text-stroke: 0px;
}

.partition_2 {
    margin-top: 50px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

.cart_container {
    position: relative;
    height: 90%;
    width: 60%;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.cart {
    position: relative;
    display: grid;
    grid-template-rows: 3fr 1fr;
    border: 1px solid lightgray;
    padding: 5px;
    background-color: #fff;
    border-radius: 10px;
    transition: all .5s ease;
}

.cart:hover {
    transform: translateY(-10px);
}

.cart .img_container {
    border-radius: 10px;
}

.img_1 {
    background-position: center;
    background-size: cover;
	height: 100%;
    background-repeat: no-repeat;
    background-image: url(photo2.jpg);
}

.img_2 {
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    background-image: url(photo3.jpg);
}

.img_3 {
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    background-image: url(photo1.jpg);
}
</style>