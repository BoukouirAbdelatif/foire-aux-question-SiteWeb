<?php
session_start() ;
$db=new PDO("mysql:host=localhost;dbname=internaute;charset=utf8","root","");
if(isset($_GET['modif']) AND !empty($_GET['modif'])){
  if(isset($_POST['name'])){
    if(isset($_POST['txt']) AND !empty($_POST['txt']) ){
$sup=(int) $_GET['modif'];
$contenu=htmlspecialchars($_POST['txt']);
$req=$db->prepare('update article set article=?  where id_art=? AND id=?');
$req->execute(array($contenu,$sup,$_SESSION['id']));
header("Location:index.php?id=".$_SESSION['id']);
}else{
  $erreur="le champ est vide veuillez le remplir";
}}
$sup=(int) $_GET['modif'];
 $af=$db->prepare('select * from article,clients where article.id=clients.id AND id_art=? AND article.id=?');
 $af->execute(array($sup,$_SESSION['id']));
 $exe=$af->fetch();
 }
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>modification_Article</title>
    <link rel="stylesheet" href="ts.css" media="screen" />
    <link rel="stylesheet" href="zz.css" media="screen" />
  </head>
  <body >
    <div class="bl1">
            <ul class="ins">
              <li></li>
      <li><a href="index.php?id=<?=$_SESSION['id']?>">Home</a></li>
      <li><a href="modifier.php" style="color:grey">modification</a></li>
      <li><a href="deconnection.php">Deconnection</a></li>

    </ul>
  </div>

</div>
    <div class="col-md-35" style="margin:3%">
        <div class="panel panel-default">
            <div class="panel-heading" >
                <i class="fa fa-fw fa-gift">
                  <?php if(!empty($exe['nom'])AND !empty($exe['prenom'])) {?>
                  <h3><?php echo $exe['nom']."_".$exe['prenom'] ?></h3>
                  <img src="avatar/<?php echo $exe['photo'] ?>" alt="" width="80" id="im"/></i>
                  <?php } ?>
                  <?php if(!empty($exe['id_art'])) {?>
                      <select name="nimporte" onChange="location.href=''+this.options[this.selectedIndex].value;"style="margin-left:1110px ;width:30px">
                                 <option></option>
                                 <option value="supprimer.php?supprimer=<?=$exe['id_art']?>">supprimer</option>
                       </select>
                      <?php } ?>
                     </div>
            <div class="panel-body">
              <?php if(!empty($exe['titre']) AND !empty($exe['article'])) {?>
              <h3><?php echo $exe['titre'].":" ?></h3>
               <form class="" action="modifier.php?modif=<?=$exe['id_art']?>" method="post">
                 <textarea name="txt" rows="15" cols="150%"><?php echo $exe['article'] ?></textarea><br><br>
                 <input type="submit" name="name" value="modifier">
               </form>
               <?php } ?>
            </div>
</div></div>


  </body>
</html>
<?php
if(isset($erreur)){
echo '<font color="red">'.$erreur;
}?>
