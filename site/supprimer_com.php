<?php
session_start();
$db=new PDO("mysql:host=localhost;dbname=internaute;charset=utf8","root","");
if(isset($_GET['supprimer']) AND !empty($_GET['supprimer'])){
$supp=(int) $_GET['supprimer'];
$req=$db->prepare('delete from commentaire  where id_com=?');
$req->execute(array($supp));
header("location:modifier_com.php?id_art=".$_GET['id_art']."&id=".$_SESSION['id']);
}

 ?>
