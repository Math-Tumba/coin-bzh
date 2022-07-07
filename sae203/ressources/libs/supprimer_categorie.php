<?php 
include '../../private/connexionbdd.php';

if(isset($_POST['delete_cat'])){
    $categorie = $_POST['categorie'];
    if (strcmp($categorie, "default") === 0){
        header('location: /sae203/private/admin.php?error=11');
        exit;
    } else {
        $req_cat_verif_del = $LINK->query("select count(*) nb from _annonce where libelle = ?",
            array($categorie));
        $req_cat_verif_del = $req_cat_verif_del -> fetch();

        if ($req_cat_verif_del['nb'] > 0){
            header('location: /sae203/private/admin.php?error=12');
            exit;
        } else {
            $req_del_cat = $LINK->insert("delete from _categorie where libelle = ?",
            array($categorie)); 
        }
    }
    header('location: /sae203/private/admin.php');
    exit;
} else{
    header('location: /sae203/index.php');
    exit;
}
?>