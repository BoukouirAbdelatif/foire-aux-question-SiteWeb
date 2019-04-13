+<?php
session_start();
$db=new PDO("mysql:host=localhost;dbname=internaute;charset=utf8","root","");
if(isset($_SESSION['id'])){
  $af=$db->prepare('select * from article inner join clients on article.id=clients.id where id_art=?');
  $id=intval($_GET['id_art']);
  $af->execute(array($id));

  if(isset($_GET['id_art']) AND !empty($_GET['id_art'])){
    if(isset($_POST['btn'])){
    if(!empty($_POST['text'])){
      $id=intval($_GET['id_art']);
      $comment=htmlspecialchars($_POST['text']);
      $reqet=$db->prepare('insert into commentaire (id,id_art,comment,date_com) values(?,?,?,NOW())');
      $reqet->execute(array($_SESSION['id'],$id,$comment));
      header("location:modifier_com.php?id_art=".$_GET['id_art']."&id=".$_SESSION['id']);
  }}
  $id=intval($_GET['id_art']);
  $test=$db->prepare('select count(id) as num from commentaire where id_art=?');
  $test->execute(array($id));
  if(isset($_GET['id_art'])){
    $c=$test->fetch();
  $af=$db->prepare('select * from article inner join clients on article.id=clients.id where id_art=?');
  $id=intval($_GET['id_art']);
  $af->execute(array($id));
  $exe=$af->fetch();

  }
  $id=intval($_GET['id_art']);
$com=$db->prepare('select * from  commentaire  inner join clients on clients.id=commentaire.id where id_art=? order by date_com asc');
$com->execute(array($id));
}else{
    header("location:modifier_com.php?id_art=".$_GET['id_art']."&id=".$_SESSION['id']);

  }



 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <link rel="stylesheet" href="ts.css" media="screen" />
     <link rel="stylesheet" href="zz.css" media="screen" />
     <meta charset="utf-8">
     <title>commentaire</title>
   </head>
   <body>
     <div class="bl1">
             <ul class="ins"  style="margin-left:2">
               <li></li>
               <li></li>
       <li><a href="index.php?id=<?=$_SESSION['id']?>">Home</a></li>
       <li><a href="modifier.php" style="color:grey">commenter</a></li>
       <li><a href="deconnection.php">Deconnection</a></li>

     </ul>
   </div>

     <div class="container" style="margin:2%">

         <!-- Marketing Icons Section -->
         <div class="row">
             <div class="col-lg-30">
                 <h1 class="page-header">
                     Bienvenu sur le Forum de descussion
                 </h1>
             </div>
                 <div class="col-md-35">
                     <div class="panel panel-default">
                         <div class="panel-heading">
                             <h4><i class="fa fa-fw fa-gift">
                               <h3><?php echo $exe['nom']."_".$exe['prenom'] ?></h3>
                               <img src="avatar/<?php echo $exe['photo'] ?>" alt="" width="80" id="im"/></i>
                                  </div>
                         <div class="panel-body">
                           <h3><?php echo $exe['titre'].":" ?></h3>
                            <form class="" action="modifier.php" method="post">
                              <textarea name="txt" rows="15" cols="150%" readonly="readonly"><?php echo $exe['article'] ?></textarea>
                            </form>
                         </div>
                    <div class="" style="margin:2%">

                           <?php
                           if(isset($_GET['id_art'])){
                             if(!empty($_GET['id_art'])){
                                 while($b=$com->fetch()){?>
                               <h4><?php echo $b['nom']."_".$b['prenom'] ?></h4>
                               <div class="" id="ph">
                               <form class="" action="modifier.php" method="post">
                                 <?php if($exe['id']==$_SESSION['id'] OR $b['id']==$_SESSION['id']){?>
                                 <select name="nimporte" onChange="location.href=''+this.options[this.selectedIndex].value;"style="margin-left:1110px ;width:20px">
                                   <option value=""></option>
                                  <option value="supprimer_com.php?supprimer=<?=$b['id_com']?>&id_art=<?=$_GET['id_art']?>">supprimer</option>
                               </select><br>
                               <?php }  ?>
                                 <img src="avatar/<?php echo $b['photo'] ?>" alt="" width="60" id="im"/></i>
                                 <textarea name="txt" rows="2" cols="110%" readonly="readonly" style="margin-left:4% ; outline:none"><?php echo $b['comment'] ?></textarea>
                               </form>
                             </div>
                               <?php }?>

                         <div class="col-md-35" id="w">
                           <div class="panel-body">
                           <form class="" action="" method="post">
                             <textarea name="text" rows="2" cols="109" placeholder="commenter"></textarea><br>
                             <input type="submit" name="btn" value="commenter">
                           </form>
                         </div>
                         </div>
                       </div>
                     </div>
                   </div>
                                </div>                       </div>




               <?php }}

 ?>




   </body>
 </html>
<?php } ?>
