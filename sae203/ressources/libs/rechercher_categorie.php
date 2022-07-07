<?php 
include '../../private/connexionbdd.php';
if (isset($_POST['research_cat']) && (strcmp($_POST['categorie'], 'default') !== 0)){
    $categorie = $_POST['categorie'];
    $req_get_new_filter = $LINK->query("select * from _annonce natural join _users where libelle = ? order by date_creation desc",
        array($categorie));
    $req_get_new_filter = $req_get_new_filter->fetchAll(\PDO::FETCH_ASSOC);
    
    header('location: /sae203/private/admin.php');
    exit;
} else {
    header('location: /sae203/private/admin.php');
    exit;
}
?>