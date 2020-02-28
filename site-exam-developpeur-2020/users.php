<?php
include('config.php');
?>
<!DOCTYPE >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Liste des utilisateurs</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Espace Membre" /></a>
	    </div>
        <div class="content">
Voici la liste des utilisateurs:
<table>
    <tr>
    	<th>Nom d'utilisateur</th>
    	<th>Email</th>
		<th>Date d'inscription</th>
		<th>Grade</th>
    </tr>
<?php
//On recupere les identifiants, les pseudos et les emails des utilisateurs
$req = $bdd -> query('SELECT id, username, email, signup_date, grade FROM users');
while($dnn = $req -> fetch())
{
?>
	<tr>
    	<td class="left"><a href="profile.php?id=<?php echo $dnn['id']; ?>"><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td class="left"><?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?></td>
    	<td class="left"><?php echo htmlentities($dnn['signup_date'], ENT_QUOTES, 'UTF-8'); ?></td>
		<?php
		if($dnn['grade']==1)
		{
			?>
			<td class="left">Menbre</td>
			<?php
		}
		else if($dnn['grade']==2)
		{
			?>
			<td class="left">Admin</td>
			<?php
		}
		?>
    </tr>
<?php
}
?>
</table>
		</div>
		<div class="foot"><a href="<?php echo $url_home; ?>">Retour &agrave; l'accueil</a> </div>
	</body>
</html>