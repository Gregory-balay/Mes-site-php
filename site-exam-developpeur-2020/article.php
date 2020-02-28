<?php
include('config.php');
?>
<!DOCTYPE >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Article</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Espace Membre" /></a>
	    </div>
<?php
if(!isset($_GET['id']) OR !is_numeric($_GET['id'])){
    header('Location: Articles.php');
}
else
{
    extract($_GET);
    $id = strip_tags($id);
    $req = $bdd->prepare('SELECT * FROM article WHERE id=?');
    $req->execute(array($id));
    if($req->rowCount() == 1)
    {
        $data= $req->fetch(PDO::FETCH_OBJ);
    }
    else
    {
        header('Location: Articles.php');
    }
}
?>
<h1><?= $data ->tittle?></h1>
<time><?=$data->date?></time>
<p><?= $data->content?></p>
<hr/>
<div class="foot"><a href="<?php echo $url_home; ?>">Retour &agrave; l'accueil</a></div>
        </body>
</html>