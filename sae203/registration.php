<?php
session_start();
include('private/connexionbdd.php'); // Fichier PHP contenant la connexion à votre BDD
$message_error = ' ';
// S'il y a une session alors on ne retourne plus sur cette page
if (isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

// Si la variable "$_Post" contient des informations alors on les traite
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['username'])) {
    $valid = true;

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $username = $_POST['username'];

    // On se place sur le bon formulaire grâce au "name" de la balise "input"
    if (isset($_POST['inscription'])) {
        $nom = htmlentities(trim($nom)); // On récupère le nom
        $prenom = htmlentities(trim($prenom)); // on récupère le prénom
        $mail = htmlentities(strtolower(trim($mail))); // On récupère le mail
        $username = htmlentities(trim($username)); // On récupère le username
        $mdp = sha1($_POST['mdp']); // On récupère le mot de passe  sha1(mdp) ----------
        $confmdp = sha1($_POST['confmdp']); //   On récupère la confirmation du mot de passe

        $req_mail = $LINK->query("SELECT mail FROM _users WHERE mail = ?", 
            array($mail));
        $req_mail = $req_mail->fetch();

        $req_username = $LINK->query("SELECT username FROM _users WHERE username = ?", 
            array($username));
        $req_username = $req_username->fetch();

        //   Vérification du nom
        if (empty($nom)) {
            $valid = false;
            $message_error = "Le nom est requis.";
        }

        //   Vérification du prénom
        else if (empty($prenom)) {
            $valid = false;
            $message_error = "Le prénom est requis.";
        }

        //   Vérification du username
        elseif (empty($username)) {
            $valid = false;
            $message_error = "Le nom d'utilisateur est requis.";
        } elseif (isset($req_username['username'])) {
            $valid = false;
            $message_error = "Ce nom d'utilisateur existe déjà, veuillez en choisir un autre.";
        }
        
        // Vérification du mail
        elseif (empty($mail)) {
            $valid = false;
            $message_error = "Le mail est requis.";

            // On vérifit que le mail est dans le bon format
        } elseif (!(filter_var($mail, FILTER_VALIDATE_EMAIL))) {
            $valid = false;
            $message_error = "Le mail est invalide";
        } elseif (isset($req_mail['mail'])) {
            // On vérifie que le mail est disponible   
            $valid = false;
            $message_error = "Ce mail existe déjà. Veuillez en choisir un autre.";
        }

        // Vérification du mot de passe
        if (empty($mdp)) {
            $valid = false;
            $message_error = "Le mot de passe ne peut pas être vide";
        } elseif ($mdp != $confmdp) {
            $valid = false;
            $message_error = "La confirmation du mot de passe ne correspond pas";
        }

        // Si toutes les conditions sont remplies alors on fait le traitement
        if ($valid) {
            
            // On insert nos données dans la table utilisateur
            $LINK->insert("insert into _users (name, first_name, mail, username, password, date_registration) VALUES  (?, ?, ?, ?, ?, now())",
                array($nom, $prenom, $mail, $username, $mdp));
            $user=$LINK->query("select user_id, name, first_name, mail from _users where mail = ?",
                array($mail));
            $user = $user -> fetch();
            $token_link = $user['user_id'] . bin2hex(random_bytes(25));
            $LINK->insert("update _users set link_confirmation = ? where mail = ?",
                array($token_link, $mail));

            $user_final=$LINK->query("select user_id, name, first_name, username, link_confirmation from _users where mail = ?",
                array($mail));
            $user_final = $user_final -> fetch();

            $_SESSION['id'] = $user_final['user_id']; // id de l'utilisateur unique pour les requêtes futures
            $_SESSION['nom'] = $user_final['name'];
            $_SESSION['prenom'] = $user_final['first_name'];
            $_SESSION['username'] = $user_final['username'];
            $_SESSION['lien'] = $user_final['link_confirmation'];

            header('Location: lien_confirmation.php?id=' . $user_final['user_id']);
            exit;
        }
    }
}
?>

<!doctype html>
<html lang="fr">
    <?php
        $title = 'Inscription';
        $content = 'Inscrivez-vous ici !';
        include('ressources/includes/elements/head.php');
    ?>
    <style><?php include 'css/style.css'; ?></style>

    <body>
        <?php include('ressources/includes/elements/nav.php'); ?>

        <main class="main_connexion">
            <section class="bloc_connexion flex">
                <div class="img_connexion img_connexion_reg">
                </div>

                <div class="form_connexion_reg">
                    <h1>INSCRIPTION</h1>
                    <form class="form_connexion" method="post" action="">
                        <div class="flex">
                            <p class="label_input">Nom<span class="required">*</span> :</p>
                            <input type="text" maxlength="38" placeholder="Votre nom" name="nom" autocomplete="off" value="<?php if(isset($nom)) echo $nom; ?>"required>
                        </div>

                        <div class="flex">
                            <p class="label_input">Prénom<span class="required">*</span> :</p>
                            <input type="text" maxlength="38" placeholder="Votre prénom" name="prenom" autocomplete="off" value="<?php if(isset($prenom)) echo $prenom; ?>" required>
                        </div>

                        <div class="flex">
                            <p class="label_input">Nom d'utilisateur<span class="required">*</span> :</p>
                            <input type="text" maxlength="38" placeholder="Nom d'utilisateur" name="username" autocomplete="off" value="<?php if(isset($username)) echo $username; ?>" required>
                        </div>

                        <div class="flex">
                            <p class="label_input">Email<span class="required">*</span> :</p>
                            <input type="email" maxlength="78" placeholder="Adresse mail" name="mail" autocomplete="off" value="<?php if(isset($mail)) echo $mail; ?>" required>
                        </div>

                        <div class="flex">
                            <p class="label_input">Mot de passe<span class="required">*</span> :</p>
                            <input type="password" minlength="6" placeholder="Mot de passe" name="mdp" autocomplete="off" required>
                        </div>

                        <div class="flex">
                            <p class="label_input">Confirmer<span class="required">*</span> :</p>
                            <input type="password" minlength="6" placeholder="Confirmer le mot de passe" name="confmdp" autocomplete="off" required>
                        </div>
                        <br>
                        <button type="submit"  class="submit_connexion" name="inscription">Envoyer</button>
                        <div class="error"><?php echo $message_error; ?></div>
                    </form>
                </div>
            </section>
            <p>Déjà inscrit ? <a class="link yellow" href="login.php">Connectez-vous</a></p>
        </main>

        <?php include('ressources/includes/elements/footer.php'); ?>
    </body>

</html>