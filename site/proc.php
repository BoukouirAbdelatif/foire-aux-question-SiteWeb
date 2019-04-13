<?php
session_start();
$db=new PDO("mysql:host=localhost;dbname=internaute;charset=utf8","root","");
if(isset($_POST['name'],$_POST['prenom'],$_POST['email'],$_POST['mote'])){
  if(!empty($_POST['name']) AND !empty($_POST['prenom']) AND !empty($_POST['email']) AND !empty($_POST['mote'])){
       $nom=htmlspecialchars($_POST['name']);
       $prenom=htmlspecialchars($_POST['prenom']);
       $email=htmlspecialchars($_POST['email']);
       $mot=sha1($_POST['mote']);

      $lennom=strlen($nom);
      $lenprenom=strlen($prenom);
      if($lennom<=30 And $lenprenom<=30){
       $recnom=$db-> prepare('select * from clients where nom=?');
       $recprenom=$db-> prepare('select * from clients where prenom=?');
       $recmail=$db-> prepare('select * from clients where email=?');
       $recmail->execute(array($email));
       $mailexiste= $recmail->rowCount();
       if(($mailexiste==0 )){
      $ins=$db->prepare('insert into clients(nom,prenom,email,mot,photo) values(?,?,?,?,?)');
      $ins->execute(array($nom,$prenom,$email,$mot,"avatar_defaut.png"));

      $recuser=$db->prepare('select * from clients where email=? AND mot=?');
      $recuser->execute(array($email,$mot));
            $userinfo=$recuser->fetch();
            $_SESSION['id']=$userinfo['id'];
            $_SESSION['email']=$userinfo['email'];
            $_SESSION['nom']=$userinfo['nom'];
            $_SESSION['prenom']=$userinfo['prenom'];

            header("Location:profil.php?id=".$_SESSION['id']);
    }else{
      $erreur='internaut exist déjat';
    }
                   }else{
                           $erreur='le nom ou le prenom ne doit pas dépassé 30 caractère';
                           }
       } else {
    $erreur='veuillez remplir tout les champs';
              }
              }
if(isset($erreur)){
  echo '<font color="red">'.$erreur;
}
 ?>
