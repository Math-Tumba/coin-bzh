<?php
    session_start();
    include('connexionbdd.php');
    $message_error = ' ';

    $req_get_cat = $LINK->query("select * from _categorie",
        array());
    $req_get_cat = $req_get_cat->fetchAll(\PDO::FETCH_ASSOC);

    $req_get_new = $LINK->query("select * from _annonce natural join _users order by date_creation desc",
        array());
    $req_get_new = $req_get_new->fetchAll(\PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="fr">
    <?php 
        $title='Administration';
        $content='Administration le coin BZH';
        include '../ressources/includes/elements/head.php'?>
        <style><?php include '../css/style.css';?></style>
    <body>
        <?php include '../ressources/includes/elements/nav.php'?>

        <main class="main_admin flex">
            <div class="categorie_admin">
                <h1 class="text-center">Gestion catégories</h1>
                <div class="gestion_categorie_main">
                    <form class="flex" action="../ressources/libs/ajout_categorie.php" method="post">
                        <label>Choisir une catégorie à ajouter : </label>
                        <input type="text" placeholder="Ajouter une catégorie" name="categorie_input" autocomplete="off" value="" required>
                        <button type="submit" class="submit_admin" name="add_cat">Ajouter</button>
                    </form>
                    <?php if(isset($_GET['error']) && $_GET['error'] == 21) echo '<p class="error text-center">' . 'Cette catégorie existe déjà.' . '</p>'; ?>

                    <br>
                    <form class="flex" action="../ressources/libs/supprimer_categorie.php" method="post">
                        <label>Choisir une catégorie à supprimer : </label>
                        <select name="categorie" id="Categorie">
                            <option value="default">- Catégorie -</option>
                            <?php
                                if(isset($_POST['delete_cat'])){
                                    foreach($req_get_cat as $row) {
                                        if ((strcmp($row['libelle'], $categorie) !== 0)){
                                            echo '<option value="' . $row['libelle'] . '">' . $row['libelle'] . '</option>';
                                        }
                                    }
                                }
                                elseif(isset($_POST['add_cat'])){
                                    if (!in_array($categorie, $row)){
                                        echo '<option value="' . $categorie . '">' . $categorie . '</option>';
                                    }
                                    foreach($req_get_cat as $row) {
                                        echo '<option value="' . $row['libelle'] . '">' . $row['libelle'] . '</option>';
                                    }
                                } else if (!isset($_POST['add_cat']) && !isset($_POST['del_cat'])){
                                    foreach($req_get_cat as $row) {
                                        echo '<option value="' . $row['libelle'] . '">' . $row['libelle'] . '</option>';
                                    }
                                }
                            ?>
                        </select>
                        <button type="submit" class="submit_admin" name="delete_cat">Supprimer</button>
                        <br>
                    </form>
                    <?php if(isset($_GET['error']) && $_GET['error'] == 11) echo '<p class="error text-center">' . 'Veuillez choisir une catégorie.' . '</p>'; ?>
                    <?php if(isset($_GET['error']) && $_GET['error'] == 12) echo '<p class="error text-center">' . 'Impossible de supprimer cette catégorie, <br>Des annonces existent avec celle-ci.' . '</p>'; ?>

                </div>
            </div>
            
            <div class="annonces_admin">
                <h1 class="text-center">Gestion annonces</h1>
                <form class="filtrage_annonce flex" action="../ressources/libs/rechercher_categorie.php" method="post">
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
                                    <div class="placement_img_annonce" style="background-image: url(../ressources/img/dynamic/'.$row['file_name'].')"></div>
                                    <form action="../ressources/libs/suppr_annonce.php" method="post">
                                        <button type="submit" class="suppr" name="supp_annonce" value="'. $row['news_id'] . ';' . $row['user_id'] .'">x</button>
                                    </form>
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
                                    <div class="placement_img_annonce" style="background-image: url(../ressources/img/dynamic/'.$row['file_name'].')"></div>
                                    <form action="../ressources/libs/suppr_annonce.php" method="post">
                                        <button type="submit" class="suppr" name="supp_annonce" value="'. $row['news_id'] . ';' . $row['user_id'] .'">x</button>
                                    </form>
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
            </div>
        </main>
        
        <?php include '../ressources/includes/elements/footer.php'?>
    </body>
</html>