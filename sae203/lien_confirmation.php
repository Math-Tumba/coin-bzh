<?php
session_start();
if (!isset($_SESSION['id']))
{
    header("location: index.php");
    exit;
}
else{
    $lien_confirmation_inscription=$_SESSION['lien'];
}
session_destroy();
?>

<!doctype html>
<html lang="fr">
    <?php 
        $title='Confirmation du compte';
        $content='Lien de confirmation';
        include('ressources/includes/elements/head.php');
    ?>
    <style><?php include 'css/style.css';?></style>

    <body>
        <?php include('ressources/includes/elements/nav.php');?>
        <main>
            <div class="flex bloc_link_conf">
                <p>Bonjour <?php echo $_SESSION['nom'] . " " . $_SESSION['prenom']?>, Veuillez confirmez votre inscription : </p>
                <a class="link yellow" href="confirmation.php?id=<?php echo $lien_confirmation_inscription; ?>">Confirmation</a>   
            </div>
        </main>
        <?php include('ressources/includes/elements/footer.php');?>
    </body>
</html>