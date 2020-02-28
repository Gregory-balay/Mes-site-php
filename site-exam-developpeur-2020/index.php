<?php
include('config.php')
?>
<!DOCTYPE >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Espace membre</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Espace Membre" /></a>
	    </div>
        <div class="content">
<?php
//On affiche un message de bienvenue, si lutilisateur est connecte, on affiche son pseudo
?>
Bonjour<?php if(isset($_SESSION['username'])){echo ' '.htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8');} ?>,<br />
Bienvenue sur notre site.<br />
Vous pouvez voir les <a href="Articles.php">Article ici</a><br />
<?php 
if(isset($_SESSION['username']))
{
$requser = $bdd -> prepare("SELECT * FROM users WHERE id= ?");
$requser ->execute(array($_SESSION['id']));
$user = $requser -> fetch();
if($user['grade'] == 2)
{
?>
Vous pouvez <a href="users.php">voir la liste des utilisateurs</a>.
<?php
}
}
?>
<br /><br />
<?php
//Si lutilisateur est connecte, on lui donne un lien pour modifier ses informations, pour voir ses messages et un pour se deconnecter
if(isset($_SESSION['username']))
{
?>
<a href="edit_infos.php">Modifier mes informations personnelles</a><br />
<a href="connexion.php">Se d&eacute;connecter</a>
<?php
}
else
{
//Sinon, on lui donne un lien pour sinscrire et un autre pour se connecter
?>
<a href="sign_up.php">Inscription</a><br />
<a href="connexion.php">Se connecter</a>
<?php
}
?>
<div class="foot"><a href="<?php echo $url_home; ?>">Retour &agrave; l'accueil</a></div>
	</body>
</html>