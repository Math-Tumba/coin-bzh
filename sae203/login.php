<?php
session_start();
include('private/connexionbdd.php');
$message_error = ' ';

if (isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['mail'])) {
    $valid = true;

    $mail = $_POST['mail'];
    
    if (isset($_POST['connexion'])) {
        $mail = htmlentities(strtolower(trim($mail))); 
        $mdp = sha1($_POST['mdp']);
        
        $req_mail = $LINK->query("select mail from _users where mail = ?", 
            array($mail));
        $req_mail = $req_mail->fetch();

        $req_verif_mdp = $LINK->query("select mail from _users where mail = ? and password = ?",
             array($mail, $mdp));
        $req_verif_mdp = $req_verif_mdp -> fetch();

        $req_verif_status = $LINK->query("select status from _users where mail = ?",
            array($mail));
        $req_verif_status = $req_verif_status -> fetch();

        // Vérification du mail
        if (empty($mail)) {
            $valid = false;
            $message_error = "Le mail est requis.";
        } elseif (!(filter_var($mail, FILTER_VALIDATE_EMAIL))) {
            $valid = false;
            $message_error = "Le mail est invalide";
        } elseif (!$req_mail) {
            $valid = false;
            $message_error = 'Ce mail n\'existe pas.';
        } elseif ($req_mail){
            if (empty($mdp)) {
                $valid = false;
                $message_error = "Le mot de passe ne peut pas être vide";
            }
            else if (!$req_verif_mdp){
                $valid = false;
                $message_error = 'Le mot de passe ne correspond avec le mail renseigné.';
            }
            else if (!$req_verif_status['status']){
                $valid = false;
                $message_error = "Veuillez confirmer votre compte pour vous connecter.";
            }
        }

        // Si toutes les conditions sont remplies alors on fait le traitement
        if ($valid) {
            $user=$LINK->query("select user_id, name, first_name, mail, username from _users where mail = ?",
                array($mail));
            $user = $user -> fetch();

            $_SESSION['id'] = $user['user_id'];
            $_SESSION['nom'] = $user['name'];
            $_SESSION['prenom'] = $user['first_name'];
            $_SESSION['mail'] = $user['mail'];
            $_SESSION['username'] = $user['username'];

            header('Location: index.php');
            exit;
        }
    }
}
?>

<!doctype html>
<html lang="fr">
    <?php
        $title = 'Connexion';
        $content = 'Connectez-vous ici !';
        include('ressources/includes/elements/head.php');
    ?>
    <style><?php include 'css/style.css'; ?></style>

    <body>
        <?php include('ressources/includes/elements/nav.php'); ?>

        <main class="main_connexion">
            <section class="bloc_connexion">
                <div class="img_connexion img_connexion_log">
                </div>

                <div class="form_connexion_reg">
                    <h1>CONNEXION</h1>
                    <form class="form_connexion" method="post" action="">

                        <div class="flex">
                            <p class="label_input">Email<span class="required">*</span> :</p>
                            <input type="email" maxlength="78" placeholder="Adresse mail" name="mail" autocomplete="off" value="<?php if(isset($mail)) echo $mail; ?>" required>
                        </div>

                        <div class="flex">
                            <p class="label_input">Mot de passe<span class="required">*</span> :</p>
                            <input type="password" minlength="6" placeholder="Mot de passe" name="mdp" autocomplete="off" required>
                        </div>

                        <br>
                        <button type="submit" minlength="6" class="submit_connexion" name="connexion">Envoyer</button>
                        <br>
                        <div class="error"><?php echo $message_error; ?></div>
                    </form>
                </div>
            </section>
            <p>Vous n'êtes pas inscrit ? <a class="link yellow" href="registration.php">Inscrivez-vous ici</a></p>
        </main>

        <?php include('ressources/includes/elements/footer.php'); ?>
    </body>

</html>