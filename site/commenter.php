<?php
session_start();
$db=new PDO("mysql:host=localhost;dbname=internaute;charset=utf8","root","");
if(isset($_SESSION['id'])){
if(esset($_POST['text'])){
  if($empty($_POST['text'])){
    if(isset($_GET['id_art']) AND !empty($_GET['id_art'])){
    $id=intval($_GET['id_art']);
    $comment=htmlspecialchars($_POST['text']);
    $reqet=$db->prepare('insert into commentaire (id,id_art,comment,date_com) values(?,?,?,NOW())');
    $reqet->execute(array($_SESSION['id'],$id,$comment));
    header("Location:index.php?id=".$_SESSION['id']);
}}
  }
}

 ?>
