<?php
    session_start();
    include 'private/connexionbdd.php';

    $req_get_cat = $LINK->query("select * from _categorie",
        array());
    $req_get_cat = $req_get_cat->fetchAll(\PDO::FETCH_ASSOC);

    if (isset($_POST['research_cat']) && (strcmp($_POST['categorie'], 'default') !== 0)){
        $categorie = $_POST['categorie'];
        $req_get_new_filter = $LINK->query("select * from _annonce natural join _users where libelle = ? order by date_creation desc",
            array($categorie));
        $req_get_new_filter = $req_get_new_filter->fetchAll(\PDO::FETCH_ASSOC);
    }
    else{
        $req_get_new = $LINK->query("select * from _annonce natural join _users order by date_creation desc",
            array());
        $req_get_new = $req_get_new->fetchAll(\PDO::FETCH_ASSOC);
    }
?>

<!doctype html>
<html lang="fr">
    <?php 
        $title='Annonces';
        $content='Retrouvez ici toutes les annonces du coin BZH';
        include('ressources/includes/elements/head.php');
        ?><style><?php include 'css/style.css';?></style>
    <body>
        <?php include('ressources/includes/elements/nav.php');?>
        <main class="main_annonce">
            <h1 class="text-center">ANNONCES</h1>
            <form class="filtrage_annonce flex" action="" method="post">
                <select name="categorie" id="categorie">
                    <option value="default">- Catégorie -</option>
                    <?php
                        foreach($req_get_cat as $row) {
                            echo '<option value="' . $row['libelle'] . '">' . $row['libelle'] . '</option>';
                        } 
                    ?>
                </select>
                <button type="submit" class="submit_connexion" name="research_cat">Rechercher</button>
            </form>
            <hr>
            <div class="repertoire_annonce flex">
                <?php 
                    if(isset($_POST['research_cat']) && (strcmp($_POST['categorie'], 'default') !== 0)){
                        if ($req_get_new_filter){
                            foreach($req_get_new_filter as $row) {
                                echo 
                                '<section class="section_annonce flex">
                                    <div class="placement_img_annonce" style="background-image: url(ressources/img/dynamic/'.$row['file_name'].')"></div>
                                    <div class="infos_annonce">
                                        <p>- '.$row['libelle'].' -</p>
                                        <p>'.$row['title_new'].' - '.$row['city'].' </p>
                                        <p class="description">'. nl2br($row['description']).'</p>
                                        <p class="poste_par">Posté par : '.$row['username'] . ' le ' . $row['date_creation'] .'<br>Le contacter : ' . $row['mail'] . '</p>
                                    </div> 
                                </section>';
                            }
                         } else {
                        echo '<p>Aucune annonce n\'a été trouvée dans cette catégorie.';
                    }
                    } else {
                        if ($req_get_new){
                            foreach($req_get_new as $row) {
                                echo 
                                '<section class="section_annonce flex">
                                    <div class="placement_img_annonce" style="background-image: url(ressources/img/dynamic/'.$row['file_name'].')"></div>
                                    <div class="infos_annonce">
                                        <p>- '.$row['libelle'].' -</p>
                                        <p>'.$row['title_new'].' - '.$row['city'].' </p>
                                        <p class="description">'. nl2br($row['description']).'</p>
                                        <p class="poste_par">Posté par : '.$row['username'] . ' le ' . $row['date_creation'] .'<br>Le contacter : ' . $row['mail'] . '</p>
                                    </div> 
                                </section>';
                            }   
                        } else {
                            echo '<p>Aucune annonce n\'a été trouvée.';
                        }
                    }
                ?>
            </div>
        </main>
        
        <?php include('ressources/includes/elements/footer.php');?>
    </body>
</html>