<?php
    session_start();
    include 'private/connexionbdd.php';
    $req_get_nb_annonces = $LINK -> query("select count(*) nb from _annonce", 
        array());
    $req_get_nb_annonces = $req_get_nb_annonces -> fetch();
    if (!$req_get_nb_annonces['nb'])
    {
        $nb_annonces = 0;
    } else{
        $nb_annonces = $req_get_nb_annonces['nb'];
    }
?>

<!doctype html>
<html lang="fr">
    <?php 
        $title='Accueil';
        $content='Bienvenue sur lecoinbzh';
        include('ressources/includes/elements/head.php');
        ?><style><?php include 'css/style.css';?></style>
    <body>
        <?php include('ressources/includes/elements/nav.php');?>
 
        <main class="acc">
            <div class="acc_presentation">
                <div class="acc_presentation_2 flex">
                    <div class="title_acc">
                        <h1>Le coin BZH</h1>
                        <h2>Débarrassez-vous de vos biens<br>publiez vos annonces<br>concluez des affaires</h2>
                        <p class="acc_count">Annonces publiées : <span class="yellow"><?php echo $nb_annonces ?></span></p>
                    </div>
                    <img src="ressources/img/static/serrage_mains.webp" alt="" title="" width="400px" height="400px">
                </div>
            </div>
        </main>
        
        <?php include('ressources/includes/elements/footer.php');?>
    </body>
</html>