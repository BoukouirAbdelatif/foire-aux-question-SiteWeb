<?php
session_start();
$db=new PDO("mysql:host=localhost;dbname=internaute;charset=utf8","root","");
if(isset($_SESSION['id'])){
if(isset($_GET['id']) AND !empty($_GET['id'])){
$getid=intval($_GET['id']);
$requser=$db->prepare('select * from clients where id=?');
$requser->execute(array($getid));
$userinfo=$requser->fetch();

 ?>
 <?php
 ?>
<?php
if(isset($_GET['supprimer']) AND !empty($_GET['supprimer'])){
$supp=(int) $_GET['supprimer'];
$req=$db->prepare('delete from article  where id_art=?');
$req->execute(array($supp));
}

  }else{
    $_SESSION=array();
    session_destroy();
    header("Location:index.php");
  }
}


$aff=$db->query('select * from article inner join clients on article.id=clients.id order by date desc');
$com=$db->prepare('select * from  commentaire  inner join clients on clients.id=commentaire.id where id_art=? order by date_com asc');

if(isset($_GET['recherche']) and !empty($_GET['Recherche'])){
  $p=htmlspecialchars($_GET['Recherche']);
  $rech=$db->query('select * from article inner join clients on article.id=clients.id where article.titre like"c++" order by date desc' );

  
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="aaa.css" media="screen" title="css" charset="utf-8">
    <title>Forum de descussion</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="css/mod.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond. IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond. doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv."></script>
        <script src="https://oss.maxcdn.com/libs/respond./1.4.2/respond.min."></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#" style="font-size:25px;">Forum Question Réponse</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">

                  <li>
                    <?php
                    if(!empty($userinfo['photo'])){
                       ?>
                       <a href="profil.php?id=<?=$_SESSION['id']?>"> <img src="avatar/<?php echo $userinfo['photo'] ?>" alt="" width="30" id="im"/></a>
                       <?php
                    }
                        ?>
                  </li>
                  <?php
                  if(isset($_SESSION['id'])){
                  if(isset($_GET['id']) AND !empty($_GET['id'])){
                  if($userinfo['id']==$_SESSION['id'] AND $userinfo['nom']==$_SESSION['nom'] ){
                    ?>
                  <li>
                    <a href="profil.php?id=<?=$_SESSION['id']?>"><?php echo $userinfo['nom'];?></a></li>
                  <?php }else{
                    header("Location:index.php?id=".$_SESSION['id']);
                  }

                }
               }?>
                    <li>
                        <a href="#w7">Contacter</a>
                    </li>
                    <?php
                    if(!isset($_GET['id']) or !isset($_SESSION['id'])){
                     ?>
                    <li>
                        <a href="ins.php">inscription</a>
                    </li>
                    <li>
                        <a href="#w6">login</a>
                    </li>
                    <?php }?>

                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">catégories<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="portfolio-1-col.html">HTML et CSS et PHP</a>
                            </li>
                            <li>
                                <a href="portfolio-2-col.html">Java</a>
                            </li>
                            <li>
                                <a href="portfolio-3-col.html">C++</a>
                            </li>
                            <li>
                                <a href="portfolio-4-col.html">Python</a>
                            </li>
                            <li>
                                <a href="portfolio-item.html">C#</a>
                            </li>
                        </ul>
                    </li>
                    <?php
                    if(isset($_SESSION['id'])){
                    if(isset($_GET['id']) AND !empty($_GET['id'])){
                      if($userinfo['id']==$_SESSION['id']){
                      if(isset($userinfo['admin']) AND $userinfo['admin']!=0  ){
                        ?>
                    <li class="dropdown">
                        <a href="admin.php?id=<?=$_SESSION['id']?>" class="dropdown-toggle" data-toggle="dropdown">Admin<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="admin.php?type=confirmer">confirmer membre</a>
                            </li>
                            <li>
                                <a href="admin.php?type=approuver">approuver publication</a>
                            </li>
                        </ul>
                    </li>
                    <?php }}else{

                      header("Location:index.php?id=".$_SESSION['id']);
                    }
                  }
                }
                    ?>
                    <!-- /.navbar-collapse

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Other Pages <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="full-width.html">Full Width Page</a>
                            </li>
                            <li>
                                <a href="sidebar.html">Sidebar Page</a>
                            </li>
                            <li>
                                <a href="faq.html">FAQ</a>
                            </li>
                            <li>
                                <a href="404.html">404</a>
                            </li>
                            <li>
                                <a href="pricing.html">Pricing Table</a>
                            </li>
                        </ul>
                    </li>

                       <li><a href="#">Blog</a></li>-->
                       <?php
                       if(isset($_SESSION['id'])){
                       if(isset($_GET['id']) AND !empty($_GET['id'])){
                       if($userinfo['id']==$_SESSION['id']){
                         ?>

                    <li> <a href="deconnection.php">Deconnection</a></li>
                    <li>
                     <?php }
                     else {
                       header("Location:index.php?id=".$_SESSION['id']);
                     }
                     ?>
                     <?php  }

                   }

                     ?>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Header Carousel -->
    <header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url(b.jpg);"></div>
                <div class="carousel-caption">
                  <h2>Bienvenu</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url(HE.jpg);"></div>
                <div class="carousel-caption">
                    <h2>sur le site</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url(bb.jpg);"></div>
                <div class="carousel-caption">
                    <h2>developper_DZ</h2>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>

    </header>

    <!-- Page Content -->
    <div class="container">

        <!-- Marketing Icons Section -->
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
                    <script>
                    setTimeout( function(){
    window.alert("en attente approuve de la publication");
  }, 2000);
                    
                    </script>

                      <?php
                    }
                  }?>
                  <?php
                  if($exe['approuver']==1 OR $exe['admin']!=0){
                ?>
            </div>
                <div class="col-md-35">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-fw fa-gift">
                              <h3><?php echo $exe['nom']."_".$exe['prenom'] ?></h3>
                              <img src="avatar/<?php echo $exe['photo'] ?>" alt="" width="80" id="im"/></i>
                              <?php if(isset($_SESSION['id'],$_GET['id']) ) {?>
                              <?php  if($_SESSION['id']==$exe['id'] ){?>
                                  <select name="nimporte" onChange="location.href=''+this.options[this.selectedIndex].value;"style="margin-left:1110px ;width:20px">
                                             <option></option>
                                             <option value="supprimer.php?supprimer=<?=$exe['id_art']?>">supprimer</option>
                                             <option value="modifier.php?modif=<?=$exe['id_art']?>">modifier</option>
                                   </select>
                                  <?php } }?>
                                 </div>
                        <div class="panel-body">
                          <h3><?php echo $exe['titre'].":" ?></h3>
                           <form class="" action="modifier.php" method="post">
                             <textarea name="txt" rows="15" cols="150%" readonly="readonly"><?php echo $exe['article'] ?></textarea>
                           </form>
                        </div>
                       
                       
                       
                       
                          <a href="modifier_com.php?id_art=<?=$exe['id_art']?>&id=<?=$exe['id']?> " style="margin:2%">commenter</a>
                          <a href="artcom.php?id_art=<?= $exe['id_art']?>">commentaire</a>
              <?php
            }}}                         ?>
 </div>
    </div>


            <!-- /.row cas normal -->




        <!-- Features Section -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Contactez Nous</h2>
            </div>
            <div class="col-md-6">
                <p>Contactez Nous </p>
                <ul>
                    <li><strong>Master2 isi</strong>
                    </li>
                    <li>Faculté des sciences exacte</li>
                    <li>Université de Mascara</li>
                    <li>***********************</li>
                    <li>*********************************</li>
                    <li>*******************************************</li>
                </ul>
            </div>
            <div class="col-md-6">
                <img class="img-responsive" src="f7.jpg" alt="">
            </div>
        </div>
        <!-- /.row -->

        <hr>
        <?php
        if(!isset($_GET['id']) OR (isset($_GET['id']) AND $userinfo['id']!=$_SESSION['id'])){
         ?>
        <div class="w6" id="w6">
          <form id="form2" action="conec.php" method="post">

            <h3><span>Login</span></h3>

            <fieldset><legend>Formulaire de contact</legend>
              <p class="first">
              <p>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" size="30" />
              </p>
              <p>
                <label for="password">Mot de Passe</label>
                <input type="password" name="mo" id="mot" size="30" />
              </p>

              <p class="submit"><button type="submit">Connecter</button></p>

            </fieldset>

          </form>

        <div class="re">

        <br><br>
        </div>

          </form>
        </div>
        <?php }?>


        <!-- Call to Action Section -->
        <div class="well">
            <div class="row">
                <div class="col-md-8">
                    <p></p>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-lg btn-default btn-block" href="#">Home</a>
                </div>
            </div>
        </div>

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row" id="w7">
                <div class="col-lg-12" >
                  contacter nous:tel 0559804573/ Email: boukouir.abdelatif@gmail.com <br>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>
