<?php
session_start() ;
$db=new PDO("mysql:host=localhost;dbname=internaute;charset=utf8","root","");
if(isset($_GET['supprimer']) AND !empty($_GET['supprimer'])){
$supp=(int) $_GET['supprimer'];
$req=$db->prepare('delete from article  where id_art=?');
$req->execute(array($supp));
header("Location:index.php?id=".$_SESSION['id']);
}


 ?>
