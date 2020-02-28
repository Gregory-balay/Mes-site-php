<?php
include('config.php');
?>
<!DOCTYPE >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Connection</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Espace Membre" /></a>
	    </div>
<?php
//Si lutilisateur est connecte, on le deconecte
if(isset($_SESSION['username']))
{
        //On le deconecte en supprimant simplement les sessions username et userid
        unset($_SESSION['username'], $_SESSION['id']);
?>
<div class="message">Vous avez bien &eacute;t&eacute; d&eacute;connect&eacute;.<br />
<a href="<?php echo $url_home; ?>">Accueil</a></div>
<?php
}
else
{
        $ousername = '';
        //On verifie si le formulaire a ete envoye
        if(isset($_POST['username'], $_POST['password']))
        {
						
			$username = htmlspecialchars($_POST['username']);
			$password = sha1($_POST['password']);
            $requser = $bdd ->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
			$requser -> execute(array($username , $password));
			$userExist =  $requser -> rowCount();
			if($userExist == 1)
			{
				$userinfo =$requser->fetch();
				$_SESSION['id'] = $userinfo['id'];
				$_SESSION['username'] = $userinfo['username'];
				$_SESSION['email'] = $userinfo['email'];
				header("Location: profile.php?".$_SESSION['id']);
?>
<div class="message">Vous avez bien &eacute;t&eacute; connect&eacute;. Vous pouvez acc&eacute;der &agrave; votre espace membre.<br />
<a href="<?php echo $url_home; ?>">Accueil</a></div>
<?php
			}
			else
			{
					//Sinon, on indique que la combinaison nest pas bonne
					$form = true;
					$message = 'La combinaison que vous avez entr&eacute; n\'est pas bonne.';
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
    <form action="connexion.php" method="post">
        Veuillez entrer vos identifiants pour vous connecter:<br />
        <div class="center">
            <label for="username">Nom d'utilisateur</label><input type="text" name="username" id="username" value="<?php echo htmlentities($ousername, ENT_QUOTES, 'UTF-8'); ?>" /><br />
            <label for="password">Mot de passe</label><input type="password" name="password" id="password" /><br />
            <input type="submit" value="Connection" />
                </div>
    </form>
</div>
<?php
        }
}
?>
<div class="foot"><a href="<?php echo $url_home; ?>">Retour &agrave; l'accueil</a></div>
        </body>
</html>