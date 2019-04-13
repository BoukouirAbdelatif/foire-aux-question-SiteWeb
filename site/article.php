<?php
session_start();
$db=new PDO("mysql:host=localhost;dbname=internaute;charset=utf8","root","");
if(isset($_SESSION['id'])){
$getid=intval($_SESSION['id']);
$requser=$db->prepare('select * from clients where id=?');
$requser->execute(array($getid));
$userinfo=$requser->fetch();

if(isset($_POST['titr']) AND isset($_POST['contenu'])){
  if(!empty($_POST['titr']) AND !empty($_POST['contenu'])){

            $titre=htmlspecialchars($_POST['titr']);
            $contenu=htmlspecialchars($_POST['contenu']);

            $ins=$db->prepare('insert into article (titre,id,article,date) values(?,?,?,NOW())');
            $ins->execute(array($titre,$_SESSION['id'],$contenu));
            header("Location:index.php?id=".$_SESSION['id']);
  }else{
    $erreur='veuillez remplir tout les champs';
  }
}

if(isset($erreur)){
  echo '<font color="red">'.$erreur;
}}

 ?>
