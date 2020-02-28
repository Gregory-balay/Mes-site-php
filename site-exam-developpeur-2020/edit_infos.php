<?php
include('config.php');
?>
<!DOCTYPE >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Modifier ses informations personnelles</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Espace Membre" /></a>
	    </div>
<?php
//On verifie si lutilisateur est connecte
if(isset($_SESSION['id']))
{
	$requser = $bdd -> prepare("SELECT * FROM users WHERE id= ?");
	$requser ->execute(array($_SESSION['id']));
    $user = $requser -> fetch();
    //On verifie si le username est different de l'ancien
    if(isset($_POST['newusername']) AND !empty($_POST['newusername']) AND $_POST['newusername'] != $user['username'])
    {
        $newusername = htmlspecialchars($_POST['newusername']);
        $verifuser = $bdd -> prepare("SELECT * FROM users WHERE username = ?");
        $verifuser -> execute(array($newusername));
        $userexist = $verifuser -> rowCount();
        if($userexist==0)
        {
            $insertUsername = $bdd -> prepare("UPDATE users SET username = ? WHERE id = ?");
            $insertUsername -> execute(array($newusername , $_SESSION['id']));
            header('Location: profile.php?id'.$_SESSION['id']);
        }
        else
        {
            //Sinon, on dit que le pseudo voulu est deja pris
            $message = 'Un autre utilisateur utilise d&eacute;j&agrave; le nom d\'utilisateur que vous d&eacute;sirez utiliser.';
        }
    }
    if(isset($_POST['password']) AND !empty($_POST['password']) AND isset($_POST['passverif']) AND !empty($_POST['passverif']) AND $_POST['password'] != $user['password'])
    {
        $password = sha1($_POST['password']);
        $passverif = sha1($_POST['passverif']);
        $passwordlenght = strlen($_POST['password']);
		if($passwordlenght>=6)
        {
            if($password == $passverif)
            {
                $insertPassword = $bdd -> prepare("UPDATE users SET password = ? WHERE id = ?");
                $insertPassword -> execute(array($password , $_SESSION['id']));
                header('Location: profile.php?id'.$_SESSION['id']);

            header('Location: profile.php?id'.$_SESSION['id']);
            }
            else
            {
                
                //Sinon, on dit que les mots de passes ne sont pas identiques
                $form = true;
                $message = 'Les mot de passe que vous avez entr&eacute; ne sont pas identiques.';
            }
        }
        else
        {
            //Sinon, on dit que le mot de passe nest pas assez long
            $form = true;
            $message = 'Le mot de passe que vous avez entr&eacute; contien moins de 6 caract&egrave;res.';
        }
    }
    //On verifie si l'email est different de l'ancien
    if(isset($_POST['newemail']) AND !empty($_POST['newemail']) AND $_POST['newemail'] != $user['email'])
    {
        $newemail = htmlspecialchars($_POST['newemail']);
        $verifemail = $bdd -> prepare("SELECT * FROM users WHERE email = ?");
        $verifemail -> execute(array($newemail));
        $emailexist = $verifemail -> rowCount();
        if($emailexist==0)
        {
            $insertemail = $bdd -> prepare("UPDATE users SET email = ? WHERE id = ?");
            $insertemail -> execute(array($newemail , $_SESSION['id']));
            header('Location: profile.php?id'.$_SESSION['id']);
        }
    }
    if(isset($_POST['newusername']) AND !empty($_POST['newusername']) AND $_POST['newusername'] == $user['username'] AND isset($_POST['newemail']) AND !empty($_POST['newemail']) AND $_POST['newemail'] == $user['email'] AND isset($_POST['password']) AND !empty($_POST['password']) AND isset($_POST['passverif']) AND !empty($_POST['passverif']) AND $_POST['password'] == $user['password'])
    {
        header('Location: profile.php?id'.$_SESSION['id']);
    }
    //On affiche un message sil y a lieu
    if(isset($message))
    {
        echo '<div class="message">'.$message.'</div>';
    }
    //On affiche le formulaire
?>
<div class="content">
    <form action="edit_infos.php" method="post">
        Vous pouvez modifier vos informations:<br />
        <div class="center">
            <label for="username">Nom d'utilisateur</label><input type="text" name="newusername" id="newusername" value="<?php echo $user['username'] ?>" /><br />
            <label for="password">Mot de passe<span class="small">(6 caract&egrave;res min.)</span></label><input type="password" name="password" id="password"/><br />
            <label for="passverif">Mot de passe<span class="small">(v&eacute;rification)</span></label><input type="password" name="passverif" id="passverif"/><br />
            <label for="email">Email</label><input type="text" name="newemail" id="newemail" value="<?php echo $user['email']  ?>" /><br />
            <input type="submit" value="Envoyer" />
        </div>
    </form>
</div>
<?php
}
else
{
?>
<div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre connect&eacute;.<br />
<a href="connexion.php">Se connecter</a></div>
<?php
}
?>
<div class="foot"><a href="<?php echo $url_home; ?>">Retour &agrave; l'accueil</a></div>
	</body>
</html>