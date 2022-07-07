<nav>
    <div class="menu">
        <div class="menu_gauche">
            <img src="" alt="" title="">
            <a class="menu_a menu_bouton" href="/sae203/deposer-annonce.php" id="yellowid11"><span class="yellow" id="yellow_id12">+</span> AJOUTER UNE ANNONCE</a>
        </div>
        <ul class="menu_ul">
            <li class="menu_li"><a class="menu_a" href="/sae203/index.php">ACCUEIL</a></li>
            <li class="menu_li"><a class="menu_a" href="/sae203/annonces.php">ANNONCES</a></li>
            <?php
                if(isset($_SESSION['id'])){
                    echo '<li class="menu_li"><div class="menu_a">' . strtoupper($_SESSION['username']) .'</div></li>';
                    echo '<li class="menu_li"><a class="menu_a" href="/sae203/ressources/libs/deconnexion.php">DECONNEXION</a></li>';
                }
                else{
                    echo '<li class="menu_li"><a class="menu_a" href="/sae203/login.php">SE CONNECTER</a></li>';
                    echo '<li class="menu_li"><a class="menu_a" href="/sae203/registration.php">INSCRIPTION</a></li>';
                }
            ?>
        </ul>
    </div>
</nav>