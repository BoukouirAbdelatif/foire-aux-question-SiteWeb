<?php
session_start();
$db=new PDO("mysql:host=localhost;dbname=internaute;charset=utf8","root","");
if(isset($_SESSION['id'])){
  $aff=$db->prepare('select * from article,clients where article.id=clients.id AND article.id=? order by date desc');
  $aff->execute(array($_SESSION['id']));
}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>publication</title>
    <link rel="stylesheet" href="ts.css" media="screen" />
    <link rel="stylesheet" href="zz.css" media="screen" />
  </head>
  <body>
    <div class="bl1">
            <ul class="ins">
              <li></li>
              <li></li><li></li>
      <li><a href="index.php?id=<?=$_SESSION['id']?>">Home</a></li>
      <li><a href="profil.php?id=<?=$_SESSION['id']?>">profil</a></li>
      <li><a href="publication.php" style="color:grey">Publication</a></li>
      <li><a href="#container">Paramètre</a></li>
      <li><a href="deconnection.php">Deconnection</a></li>

    </ul>
  </div>
    <?php
    while($exe=$aff->fetch()){
    ?>  </div>
    <div class="col-md-35" style="margin:2%">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-fw fa-gift">
                  <h3><?php echo $exe['nom']."_".$exe['prenom'] ?></h3>
                  <img src="avatar/<?php echo $exe['photo'] ?>" alt="" width="80" id="im"/></i>
                  <?php if(isset($_SESSION['id']) ) {?>
                  <?php  if($_SESSION['id']==$exe['id']){?>
                      <select name="nimporte" onChange="location.href=''+this.options[this.selectedIndex].value;"style="margin-left:1110px ;width:30px">
                                 <option></option>
                                 <option value="supprimer.php?supprimer=<?=$exe['id_art']?>">supprimer</option>
                                 <option value="modifier.php?modif=<?=$exe['id_art']?>">modifier</option>
                       </select>
                      <?php } }?>
                     </div>
            <div class="panel-body">
              <h3><?php echo $exe['titre'].":" ?></h3>
               <form class="" action="modifier.php" method="post">
                 <textarea name="txt" rows="15" cols="150%"><?php echo $exe['article'] ?></textarea>
               </form>
            </div>
            <?php
            if(isset($_SESSION['id'])){
              ?>
            <div class="col-md-35">
              <div class="panel-body">
              <form class="" action="commenter" method="post">
                <label for="" style="color:grey;">Commentaire:</label><br>
                <textarea name="text" rows="3" cols="110" placeholder="commenter"></textarea>
              </form>
            </div>    </div>          </div>

    <?php }} ?>

    </div>

  </body>
</html>
