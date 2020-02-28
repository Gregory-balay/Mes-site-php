<?php
include('config.php');
?>
<!DOCTYPE >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Profil d'un utilisateur</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Espace Membre" /></a>
	    </div>
        <div class="content">
<?php
//On verifie que lidentifiant de lutilisateur est defini
if(isset($_SESSION['id']))
{
	$id = intval($_SESSION['id']);
	//On verifie que lutilisateur existe
	$dn = $bdd -> prepare('SELECT username, email, signup_date FROM users WHERE id= ?');
	$dn -> execute(array($id));
	if(($dn -> rowCount()) >0)
	{
		$dnn = $dn ->fetch();
		//On affiche les donnees de lutilisateur
?>
Voici le profil de "<?php echo htmlentities($dnn['username']); ?>" :
<table style="width:500px;">
	<tr>
    	<td class="left"><h1><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></h1>
    	Email: <?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?><br />
        Cet utilisateur s'est inscrit le <?php echo date($dnn['signup_date']); ?></td>
    </tr>
</table>
<?php
	}
	else
	{
		echo 'Cet utilisateur n\'existe pas.';
	}
}
else
{
	echo 'L\'identifiant de l\'utilisateur n\'est pas d&eacute;fini.';
}
?>
<div class="foot"><a href="<?php echo $url_home; ?>">Retour &agrave; l'accueil</a></div>
	</body>
</html>