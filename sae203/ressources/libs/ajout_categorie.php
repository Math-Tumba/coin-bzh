<?php 
include '../../private/connexionbdd.php';
if(isset($_POST['add_cat'])){
    $categorie = $_POST['categorie_input'];
    $req_sel_cat = $LINK->query("select libelle from _categorie where libelle = ?", 
        array($categorie));
    $req_sel_cat = $req_sel_cat -> fetch();

    if(!isset($req_sel_cat['libelle'])){
        $req_add_cat = $LINK->insert("insert into _categorie (libelle) values(?)", 
            array($categorie));
    } else {
        header('location: /sae203/private/admin.php?error=21');
        exit;
    }
    header('location: /sae203/private/admin.php');
    exit;
} else{
    header('location: /sae203/index.php');
    exit;
}
?>