<?php
$db=new PDO("mysql:host=localhost;dbname=internaute;charset=utf8","root","");
$aff=$db->query('select * from article inner join clients on article.id=clients.id order by date desc');
$com=$db->query('select * from  commentaire  inner join clients on clients.id=commentaire.id order by date_com asc');

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
       <li><a href="http://localhost:85/site/index.php">Home</a></li>
     <li></li>
     <li></li>
     <li>
     </li>
     <li></li>
       

     </ul>
   </div>

   <div class="row">
            <div class="col-lg-30">
                <h1 class="page-header">
                    Bienvenu sur le Forum Question Reponse
                </h1>
                <?php
                if(isset($aff)){
                while($exe=$aff->fetch()){
                  if(isset($_SESSION['id'])){
                    if($_SESSION['id']==$exe['id'])
                    if($exe['approuver']==0 AND  $exe['admin']==0){?>
                    

                      <?php
                    }
                  }?>
                  >
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
                       
 

<?php

      while($b=$com->fetch()){?>
      <div class="" style="margin-left:10%">
    <h4><?php echo $b['nom']."_".$b['prenom'] ?></h4>
    <div class="" id="ph">
    <form class="" action="modifier.php" method="post">
    
      <img src="avatar/<?php echo $b['photo'] ?>" alt="" width="60" id="im"/></i>
      <textarea name="txt" rows="2" cols="110%" readonly="readonly" style="margin-left:4% ; outline:none"><?php echo $b['comment'] ?></textarea>
      </div>
    </form>
  </div>
  </div>
  </div>
    <?php }?>
                       
                       
                         
              <?php
            }}                         ?>
 </div>
    </div>


