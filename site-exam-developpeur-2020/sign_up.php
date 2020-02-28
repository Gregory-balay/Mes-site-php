<?php
include('config.php');
?>
<!DOCTYPE >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Inscription</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Espace Membre" /></a>
	    </div>
<?php
//On verifie que le formulaire a ete envoye
if(isset($_POST['username'], $_POST['password'], $_POST['passverif'], $_POST['email']) and $_POST['username']!='')
{
		$username = htmlspecialchars($_POST['username']);
		$password= sha1($_POST['password']);
		$passverif = sha1($_POST['passverif']);
		$email= htmlspecialchars($_POST['email']);
		$grade = 1;
	//On verifie si le mot de passe et celui de la verification sont identiques
	if($password==$passverif)
	{
		//On verifie si le mot de passe a 6 caracteres ou plus
		$passwordlenght = strlen($_POST['password']);
		if($passwordlenght>=6)
		{
			//On verifie si lemail est valide
			if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
			{
				//On verifie sil ny a pas deja un utilisateur inscrit avec l'email choisis
				$verifemail = $bdd -> prepare("SELECT * FROM users WHERE email = ?");
				$verifemail -> execute(array($email));
				$emailexist = $verifemail -> rowCount();
				if($emailexist==0)
				{
					//On verifie sil ny a pas deja un utilisateur inscrit avec le pseudo choisis
					$verifuser = $bdd -> prepare("SELECT * FROM users WHERE username = ?");
					$verifuser -> execute(array($username));
					$userexist = $verifuser -> rowCount();
					if($userexist==0)
					{
						//On enregistre les informations dans la base de donnee
						$verifUpload = $bdd -> prepare("INSERT INTO users (username, password, email, grade) VALUES (?, ?, ?, ?)");
						$verifUpload -> execute(array($username, $password , $email ,$grade));
						if($verifUpload == true)
						{
							//Si ca a fonctionne, on naffiche pas le formulaire
							$form = false;
	?>
	<div class="message">Vous avez bien &eacute;t&eacute; inscrit. Vous pouvez dor&eacute;navant vous connecter.<br />
	<a href="connexion.php">Se connecter</a></div>
	<?php
						}
						else
						{
							//Sinon on dit quil y a eu une erreur
							$form = true;
							$message = 'Une erreur est survenue lors de l\'inscription.';
						}
					}
					else
					{
						//Sinon, on dit que le pseudo voulu est deja pris
						$form = true;
						$message = 'Un autre utilisateur utilise d&eacute;j&agrave; le nom d\'utilisateur que vous d&eacute;sirez utiliser.';
					}
				}
				else
				{
					//Sinon, on dit que le pseudo voulu est deja pris
					$form = true;
					$message = 'Un autre utilisateur utilise d&eacute;j&agrave; l\'email que vous d&eacute;sirez utiliser.';
				}
			}
			else
			{
				//Sinon, on dit que lemail nest pas valide
				$form = true;
				$message = 'L\'email que vous avez entr&eacute; n\'est pas valide.';
			}
		}
		else
		{
			//Sinon, on dit que le mot de passe nest pas assez long
			$form = true;
			$message = 'Le mot de passe que vous avez entr&eacute; contien moins de 6 caract&egrave;res.';
		}
	}
	else
	{
		//Sinon, on dit que les mots de passes ne sont pas identiques
		$form = true;
		$message = 'Les mots de passe que vous avez entr&eacute; ne sont pas identiques.';
	}
}
else
{
	$form = true;
}
if($form)
{
	//On affiche un message sil y a lieu
	if(isset($message))
	{
		echo '<div class="message">'.$message.'</div>';
	}
	//On affiche le formulaire
?>
<div class="content">
    <form action="sign_up.php" method="post">
        Veuillez remplir ce formulaire pour vous inscrire:<br />
        <div class="center">
            <label for="username">Nom d'utilisateur</label><input type="text" name="username" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <label for="password">Mot de passe<span class="small">(6 caract&egrave;res min.)</span></label><input type="password" name="password" /><br />
            <label for="passverif">Mot de passe<span class="small">(v&eacute;rification)</span></label><input type="password" name="passverif" /><br />
            <label for="email">Email</label><input type="text" name="email" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <input type="submit" value="Envoyer" />
		</div>
    </form>
</div>
<?php
}
?>
		<div class="foot"><a href="<?php echo $url_home; ?>">Retour &agrave; l'accueil</a></div>
	</body>
</html>