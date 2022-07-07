<?php
    session_start();
    include 'private/connexionbdd.php';
    if (!isset($_SESSION['id']))
    {
        header("location: /sae203/login.php");
        exit;
    }
    
    else {
        $req_cat = $LINK->query("SELECT libelle FROM _categorie", 
            array());
        $req_cat = $req_cat->fetchAll(\PDO::FETCH_ASSOC);

        $req_nb_news = $LINK->query("SELECT count(*) nb from _annonce", 
            array());
        $req_nb_news = $req_nb_news -> fetch();

        $message_error = ' ';

        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {

            $title_new = htmlentities($_POST['title_new']);
            $city = htmlentities($_POST['city']);
            $description = htmlentities($_POST['description']);
            $categorie = htmlentities($_POST['categorie']);
            $tailleMax = 2097152;
            $extensionValides = array('jpg', 'jpeg', 'png', 'webp');
            
            if (strcmp($categorie, 'default') === 0){
                $message_error = 'Veuillez choisir une catégorie';
            
            } elseif ($_FILES['image']['size'] <= $tailleMax) {
                $extensionUpload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
                if (in_array($extensionUpload, $extensionValides)) {
                    $nom_unique_img = $_SESSION['id'] . "a" . $req_nb_news['nb'] . $extensionUpload;
                    $chemin = "./ressources/img/dynamic/" . $nom_unique_img . "." . $extensionUpload;
                    $deplacement = move_uploaded_file($_FILES['image']['tmp_name'], $chemin);
                    if ($deplacement) {
                        $insertImage = $LINK->insert("insert into _annonce (title_new, city, date_creation, file_name, img_user_name, description, libelle, user_id) values (?, ?, now(), ?, ?, ?, ?, ?);",
                            array($title_new, $city, $nom_unique_img, $_FILES['image']['name'], $description, $categorie, $_SESSION['id']));
                    } else {
                        $msg = "Impossible d'importer l'image";
                    }
                } else {
                    $msg = "Mauvais format (jpg, png, jpeg, webp)";
                }
            } else {
                $msg = "Votre image ne doit pas dépasser 2Mo";
            }
        }
    }
?>

<!doctype html>
<html lang="fr">
    <?php 
        $title='Accueil';
        $content='Bienvenue sur <nom du site>';
        include('ressources/includes/elements/head.php');
        ?><style><?php include 'css/style.css';?></style>
    <body>
        <?php include('ressources/includes/elements/nav.php');?>
        <main class="main_annonce_dep">
            <h1 class="text-center">Ajout d'une annonce</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" maxlength="58" placeholder="Ville" name="city" autocomplete="off" value="<?php if(isset($city)) echo $city; ?>"required>
                <br>
                <br>
                <div class="multi-flex flex">
                    <input type="text" maxlength="78" placeholder="Titre" name="title_new" autocomplete="off" value="<?php if(isset($title_new)) echo $title_new; ?>"required>
                    <select name="categorie" id="categorie">
                        <option value="default">- Catégorie -</option>
                        <?php
                            foreach($req_cat as $row) {
                                echo '<option value="' . $row['libelle'] . '">' . $row['libelle'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <br>
                <br>
                <textarea placeholder="Description..." maxlength="2000" name="description" autocomplete="off" value="<?php if(isset($description)) echo $description; ?>" required></textarea>
                <br>
                <br>
                <input type="file" id="avatar" name="image" accept="image/png, image/jpeg, image/webp, image/jpg" required>
                <br>
                <br>
                <?php echo '<p class="error">'. $message_error .'</p>'?>
                <button class="submit_connexion" type="submit" name="add_new">Publier</button>
            </form>
        </main>

        
        <?php include('ressources/includes/elements/footer.php');?>
    </body>
</html>