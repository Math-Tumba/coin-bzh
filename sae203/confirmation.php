<?php
    session_start();
    include('private/connexionbdd.php');
    if (isset($_SESSION['id'])) {
        header('Location: index.php');
        exit;
    }
    else{
        $id_url = $_GET['id'];
        $sql_verif = $LINK->query("select count(*) nb from _users where link_confirmation = ?",
        array($id_url));
        $sql_verif = $sql_verif -> fetch();
        if($sql_verif['nb'] == 0)
        {
            header('Location: index.php');
            exit;
        }
        else{
            $sql_confirm = $LINK->insert("update _users set link_confirmation = null, status = true where link_confirmation = ?;",
                array($id_url));
            header("location: login.php");
            exit;
        }
    }
?>