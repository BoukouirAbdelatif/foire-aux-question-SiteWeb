<?php
session_start();
$db=new PDO("mysql:host=127.0.0.1;dbname=internaute;charset=utf8","root","");
if(isset($_POST['email'],$_POST['mo'])){
  $email=htmlspecialchars($_POST['email']);
  $mot=sha1($_POST['mo']);
  if(!empty($_POST['email']) AND !empty($_POST['mo'])){
        $recuser=$db->prepare('select * from clients where email=? AND mot=?');
        $recuser->execute(array($email,$mot));
        $userexist=$recuser->rowCount();
        if($userexist==1){
              $userinfo=$recuser->fetch();
              $_SESSION['id']=$userinfo['id'];
              $_SESSION['email']=$userinfo['email'];
              $_SESSION['nom']=$userinfo['nom'];
              $_SESSION['prenom']=$userinfo['prenom'];
              $_SESSION['admin']=$userinfo['admin'];
              header("Location:index.php?id=".$_SESSION['id']);
              }else{
                   $erreur='email ou le mot de passe est incorect';
                  }
  }else{
    $erreur='tout les champs doivent être compléter';
  }
}
if(isset($erreur)){
echo '<font color="red">'.$erreur;
}
 ?>
