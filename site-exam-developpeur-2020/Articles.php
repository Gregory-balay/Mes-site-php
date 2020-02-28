<?php
include('config.php');
?>
<!DOCTYPE >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Article liste</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Espace Membre" /></a>
	    </div>
<?php
    $req =$bdd->prepare('SELECT id,tittle,date FROM article ORDER BY id DESC');
    $req->execute();
    $data= $req->fetchAll(PDO::FETCH_OBJ);
    $req ->closeCursor();
?>
<h1>Article :</h1>
<?php foreach($data as $article):?>
<h2><?= $article ->tittle?></h2>
<time><?=$article->date?></time>
<br/>
<a href="article.php?id=<?= $article-> id?>">Lire la suite</a>
<?php endforeach;?>
<div class="foot"><a href="<?php echo $url_home; ?>">Retour &agrave; l'accueil</a></div>
        </body>
</html>