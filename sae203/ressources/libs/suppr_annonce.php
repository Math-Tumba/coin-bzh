<?php 
include '../../private/connexionbdd.php';
if (isset($_POST['supp_annonce'])){
    $supp_annonce = $_POST['supp_annonce'];
    $pieces = explode(";", $supp_annonce);
    $news_id = $pieces[0];
    $user_id = $pieces[1];

    $req_suppr_annonce = $LINK->insert("delete from _annonce where news_id = ? and user_id = ?",
        array($news_id, $user_id));
    
    header('location: /sae203/private/admin.php');
    exit;
} else{
    header('location: /sae203/index.php');
    exit;
}
?>