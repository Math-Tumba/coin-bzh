<?php
include '/sae203/private/connexionbdd.php';
$req_delete_all_temp = $LINK->insert("delete * from _users where status = false", 
	array());
?>