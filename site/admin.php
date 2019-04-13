<?php
session_start();
$db=new PDO("mysql:host=localhost;dbname=internaute;charset=utf8","root","");
if(isset($_SESSION['id'])){
if(isset($_GET['type']) AND !empty($_GET['type'])){
$type=$_GET['type'];
}
$getid=intval($_SESSION['id']);
$requser=$db->prepare('select * from clients where id=?');
$requser->execute(array($getid));
$userinfo=$requser->fetch();
if(isset($userinfo['admin'])){
if(isset($_GET['confirme']) AND !empty($_GET['confirme'])){
$confirme=(int) $_GET['confirme'];
$req=$db->prepare('update clients set confirme=1 where id=?');
$req->execute(array($confirme));
}
if(isset($_GET['supprimer']) AND !empty($_GET['supprimer'])){
$supp=(int) $_GET['supprimer'];
$req=$db->prepare('delete from clients  where id=?');
$req->execute(array($supp));
}
if(isset($_GET['administrateurA']) AND !empty($_GET['administrateurA'])){
$add=(int) $_GET['administrateurA'];
$req=$db->prepare('update clients set admin=1  where id=?');
$req->execute(array($add));
}
if(isset($_GET['administrateurR']) AND !empty($_GET['administrateurR'])){
$add=(int) $_GET['administrateurR'];
$req=$db->prepare('update clients set admin=0  where id=?');
$req->execute(array($add));
}
}
if(isset($_GET['approuve']) AND !empty($_GET['approuve'])){
$app=(int) $_GET['approuve'];
$reqet=$db->prepare('update article set approuver=1 where id_art=?');
$reqet->execute(array($app));
}
if(isset($_GET['suprimer']) AND !empty($_GET['suprimer'])){
$ap=(int) $_GET['suprimer'];
$reqet=$db->prepare('delete from article where id_art=?');
$reqet->execute(array($ap));
}


if($userinfo['admin']==1){
  $member=$db->Query('select * from clients where admin=0 order by id desc');
}else if($userinfo['admin']==2){
  $member=$db->Query('select * from clients where admin=0 OR admin=1 order by id desc');
}
$article=$db->query('select * from article,clients where clients.id=article.id order by date desc');

}else{
  exit();
}





 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="zz.css" media="screen" />
     <link rel="stylesheet" href="ts.css" media="screen" />
     <title>Administration</title>
   </head>
   <body>
     <div class="bl1">
             <ul class="ins">
       <li id="acc"><a href="index.php?id=<?=$_SESSION['id']?>">Home</a></li>
       <li id="dec"><a href="deconnection.php">deconnecter</li></a>
<li></li>
     </ul>
   </div><br>
   <div align="center"><?php
     if(isset($userinfo['nom'],$userinfo['prenom'])){?>
<h1 class="pr">Administrateur <?php echo $userinfo['nom']." ".$userinfo['prenom'];?></h1>
<?php } ?>
</div>
<?php
if(isset($type)){
 if($type=="confirmer"){
 ?>
  <table border="1">
    <tr style="font-size:25px" border="10">
      <td >
        id
      </td>
      <td>
        pseudo
      </td>
      <td>
        confirmer
      </td>
      <td>
        supprimer
      </td>
      <?php
      if(isset($userinfo['admin'])){
      if($userinfo['admin']==2){?>
      <td>
        ajouter comme administrateur
      </td>
      <?php  }}?>
    </tr><?php
    if(isset($member)){
     while($m=$member->fetch()){ ?>
    <td>
      <?=$m['id']?>
    </td>
    <td>
      <?=$m['nom']."_".$m['prenom']?>
    </td>
    <td>
      <?php if($m['confirme']==0) {?><a href="admin.php?confirme=<?=$m['id']?>">Confirmer</a><?php } ?>
    </td>
    <td>
      <a href="admin.php?supprimer=<?=$m['id']?>">Supprimer</a>
    </td>
    <?php
    if($userinfo['admin']==2){?>
    <td>
      <?php
      if($m['confirme']==1){?>
      <?php if($m['admin']==0) {?><a href="admin.php?administrateurA=<?=$m['id']?>&type=confirmer" style="color:green;">ajouter_Admin</a><?php } ?>
    <?php
     if($userinfo['admin']==2){?>
            <?php if($m['admin']==1) {?><a href="admin.php?administrateurR=<?=$m['id']?>&type=confirmer"style="color:orange;">Retirer_Admin</a><?php } ?>
<?php  }}}?>
    </td>

  </tr>
  <tr>
    <?php }} }}?>

</table>


<?php
if(isset($type)){
 if($type=="approuver") {?>
<div class="container" style="margin:2%">

    <!-- Marketing Icons Section -->
    <div class="row">
        <div class="col-lg-30">
            <h1 class="page-header">
            Approuver les publication            </h1>
            <?php
            if(isset($article)){
            while($a=$article->fetch() ){
              if($a['approuver']==0 AND $a['admin']==0){
            ?>
        </div>
<div class="col-md-35">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><i class="fa fa-fw fa-gift">
              <?php
              if(isset($a['nom'],$a['prenom'])){?>
              <h3><?php echo $a['nom']."_".$a['prenom'] ?></h3>
              <img src="avatar/<?php echo $a['photo'] ?>" alt="" width="80" id="im"/></i>
              <?php if(isset($_SESSION['id'],$_GET['id']) ) {?>
              <?php  if($_SESSION['id']==$exe['id']){?>
                  <select name="nimporte" onChange="location.href=''+this.options[this.selectedIndex].value;"style="margin-left:1110px ;width:20px">
                             <option></option>
                             <option value="supprimer.php?supprimer=<?=$a['id_art']?>">supprimer</option>
                             <option value="modifier.php?modif=<?=$a['id_art']?>">modifier</option>
                   </select>
                  <?php } }?>
                 </div>
        <div class="panel-body">
          <h3><?php echo $a['titre'].":" ?></h3>
           <form class="" action="modifier.php" method="post">
             <textarea name="txt" rows="15" cols="150%" readonly="readonly"><?php echo $a['article'] ?></textarea>

           </form>
           <a href="admin.php?approuve=<?=$a['id_art']?>&type=approuver" style="font-size:20px">Approuver</a>
           <a href="admin.php?suprimer=<?=$a['id_art']?>&type=approuver" style="font-size:20px; margin:10%">Supprimer</a>

        </div>
<?php }} } } }}?>
</div>
   </body>
 </html>
