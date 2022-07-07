<?php session_start() ?>

<!doctype html>
<html lang="fr">
    <?php 
        $title='Accueil';
        $content='Page d\erreur 404';
        include('ressources/includes/elements/head.php');
        ?><style><?php include 'css/style.css';?></style>
    <body>
        <?php include('ressources/includes/elements/nav.php');?>
 
        <main class="main_error">
            <div class="bloc_error flex">
                <div class="text_error">
                    <h1>Erreur 404</h1>
                    <p>La page est introuvable ou n'existe plus.</p>
                    <br><br>
                    <a class="link error_link" href="/sae203/index.php">Revenir à l'accueil</a>
                </div>
                <img src="/sae203/ressources/img/static/error404_pic.png" alt="error404" title="error404" width="400px" height="300px">
            </div>
        </main>
        
        <?php include('ressources/includes/elements/footer.php');?>
    </body>
</html>