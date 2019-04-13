<?php
session_start();
$db=new PDO("mysql:host=localhost;dbname=internaute;charset=utf8","root","");
if(isset($_GET['id'])){
$getid=intval($_GET['id']);
$requser=$db->prepare('select * from clients where id=?');
$requser->execute(array($getid));
$userinfo=$requser->fetch();
 ?>
 <?php
  if($userinfo['id']==$_SESSION['id']){
    if(!empty($_POST['name']) AND !empty($_POST['prenom']) AND !empty($_POST['email'])){
      $nom=htmlspecialchars($_POST['name']);
      $prenom=htmlspecialchars($_POST['prenom']);
      $email=htmlspecialchars($_POST['email']);
      $mot=sha1($_POST['mote']);
      $up=$db->prepare('update clients set nom=?  where id=?');
      $up->execute(array($nom,$_SESSION['id']));
      $up=$db->prepare('update clients set prenom=?  where id=?');
      $up->execute(array($prenom,$_SESSION['id']));
      $up=$db->prepare('update clients set email=?  where id=?');
      $up->execute(array($email,$_SESSION['id']));
      if(!empty($_POST['mote'])){
      $up=$db->prepare('update clients set mot=?  where id=?');
      $up->execute(array($mot,$_SESSION['id']));
      }
      if(isset($_FILES['photo']) AND !empty($_FILES['photo']['name'])){
        $taillemax=2097152;
        $extension=array('jpg','jpeg','gif','png');
        if($_FILES['photo']['size']<=$taillemax){
            $extensionUp=strtolower(substr(strrchr($_FILES['photo']['name'],'.'),1));
            if(in_array($extensionUp,$extension)){
                   $chemin="avatar/".$_SESSION['id'].".".$extensionUp;
                   $resultat=move_uploaded_file($_FILES['photo']['tmp_name'],$chemin);
                   if($resultat){
                     $update=$db->prepare('update clients set photo=? where id=?');
                     $update->execute(array($_SESSION['id'].'.'.$extensionUp,$_SESSION['id']));
                   }else{
                     $erreur='erreur importation de fichier';

                   }
            } else{
              $erreur='votre photo de profil doit être au format jpg,jpeg,gif,png';
            }
        }else{
          $erreur='votre photo de profil ne doit pas dépassé 2 Mo';
        }
      }
      header("Location:index.php?id=".$_SESSION['id']);
    }

    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <link rel="stylesheet" href="z.css" media="screen" />
    <meta charset="utf-8">
    <link rel="stylesheet" href="s.css" media="screen" title="css" charset="utf-8">

    <title>profil</title>
  </head>
  <body>

<div class="col-lg-6 col-sm-6">
    <div class="card hovercard">
        <div class="card-background">
            <img class="card-bkimg" alt="" src="http://lorempixel.com/100/100/people/9/">
            <!-- http://lorempixel.com/850/280/people/9/ -->
        </div>
        <div class="useravatar">
          <?php
          if(!empty($userinfo['photo'])){
             ?>
             <img src="avatar/<?php echo $userinfo['photo'] ?>" alt="" width="100" id="im"/>
             <?php
          }
              ?>
        </div>
        <div class="card-info"> <span class="card-title">
          <?php
          if(isset($userinfo['admin']) AND $userinfo['admin']!=0){
            ?>
      Admin <?php echo $userinfo['nom']." ".$userinfo['prenom'];?>
  <?php }elseif(isset($userinfo['admin']) AND $userinfo['admin']==0){?>
      Profil <?php echo $userinfo['nom']." ".$userinfo['prenom'];?>
    <?php }?>

        </span>

        </div>
    </div>
    <div class="bl1">
            <ul class="ins">
      <li><a href="deconnection.php">Deconnection</a></li>
      <li><a href="deri.php">Accueil</a></li>
      <li>Bienvenu</li>

    </ul>
  </div>
    <?php
}else{
  header("Location:index.php?id=".$_SESSION['id']."&nom=".$_SESSION['nom']);
}


?>

  <div id="container">


    <form id="form2" action="" method="POST" enctype="multipart/form-data">

      <h3><span>Modification</span></h3>

      <fieldset><legend>Formulaire de contact</legend>
        <p class="first">
          <label for="name">Nom</label>
          <input type="text" name="name" id="name" size="30" value="<?php echo $userinfo['nom']; ?> "  />
        </p>
        <p>
          <label for="prenom">Prénom</label>
          <input type="text" name="prenom" id="prenom" size="30" value="<?php echo $userinfo['prenom']; ?> "/>
        </p>
        <p>
          <label for="email">Email</label>
          <input type="text" name="email" id="email" size="30" value="<?php echo $userinfo['email']; ?> "/>
        </p>
        <p>
          <label for="password">Mot de Passe</label>
          <input type="password" name="mote" id="mot" size="30" />
        </p>
        <p>
          <label for="photo">Photo de profil</label>
          <input type="file" name="photo" id="photo" size="30" />
        </p>


        <p class="submit"><button type="submit">Modifier</button></p>

      </fieldset>

    </form>

  </div>

  </body>
</html>
<?php
if(isset($erreur)){
echo '<font color="red">'.$erreur;
}
}

 ?>
