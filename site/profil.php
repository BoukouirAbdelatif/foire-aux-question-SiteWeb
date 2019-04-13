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
    $aff=$db->prepare('select * from article,clients where article.id=clients.id AND id');
    $aff->execute(array($_SESSION['id']));
    $exe=$aff->fetch();
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
      header("http://localhost/site/profil.php?id=".$_SESSION['id']);
    }

    ?>
    <!DOCTYPE html >
    <html >
  <head>
    <link rel="stylesheet" href="ss.css" media="screen" />
    <meta charset="utf-8">
    <link rel="stylesheet" href="zz.css" media="screen" title="css" charset="utf-8">

    <title>profil</title>
  </head>
  <body>

<div class="col-lg-6 col-sm-6" >
    <div class="card hovercard">
        <div class="card-background" style="background-color:#ff6666;border-radius:2px;">
        <div style="margin-left:50px;padding-top:30px;">
        <?php
          if(!empty($userinfo['photo'])){
             ?>
             <img src="avatar/<?php echo $userinfo['photo'] ?>" alt="" width="100" id="im" style="border-radius:50px"/>
             <?php
          }
              ?>
        </div>
        <div class="card-info"> <span class="card-title" style="margin-left:15px;font-family: 'Merriweather', serif;">
          <?php
          if(isset($userinfo['admin']) AND $userinfo['admin']!=0){
            ?>
      Admin <?php echo $userinfo['nom']." ".$userinfo['prenom'];?>
  <?php }elseif(isset($userinfo['admin']) AND $userinfo['admin']==0){?>
            <?php echo $userinfo['nom']." ".$userinfo['prenom'];?>
    <?php }?>
    
        </span>

        </div>
    
    </div>
    <div class="bl1">
            <ul class="ins">
              <li></li><li></li>
              <li></li><li></li>
      <li><a href="index.php?id=<?=$_SESSION['id']?>">Home</a></li>
      <li><a href="profil.php?id=<?=$_SESSION['id']?>" style="color: #cccccc">profil</a></li>
      <li><a href="publication.php">Publication</a></li>
      <li><a href="#container">Paramètre</a></li>
      <li><a href="deconnection.php">Deconnection</a></li>

    </ul>
  </div>
    <?php
}else{
  header("Location:index.php?id=".$_SESSION['id']);
}


?>
<form class="" action="article.php" method="post" style="margin-left:25%">
  <br>
  <input type="text" name="titr" value="" placeholder="titre" size="60" ><br><br>
  <textarea name="contenu" rows="8" cols="59" placeholder="Question" ></textarea><br><br>
  <br><br>
  <input type="submit" name="name" value="publier" style="width:200px ; margin-left:30% ; height:30px ; font-weight:bold">

</form>


  <div id="container" style="align:left;">


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
