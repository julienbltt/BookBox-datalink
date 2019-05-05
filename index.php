<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=datalink', 'root','');

if(isset($_POST['formConnect']))
{
	$loginConnect = htmlspecialchars($_POST['loginConnect']);
	$passwordConnect = htmlspecialchars($_POST['passwordConnect']);
	if(!empty($loginConnect) AND !empty($passwordConnect))
	{
		$reqUser = $bdd->prepare('SELECT * FROM administrateur WHERE login = ?');
		$reqUser->execute(array($loginConnect));
		$userInfo = $reqUser->fetch();
		if (!$userInfo) 
		{
			$erreur = "Mauvais identifiant ou mot de passe";
		}
		else
		{
			if ($_POST['passwordConnect'] == $userInfo['password']) 
			{
		        $_SESSION['id'] = $userInfo['id'];
		        $erreur = "Vous êtes connecté";
		        header('Location: acceuil.php?id='. $_SESSION['id'] );
			}
			else
			{
				$erreur = "Mauvais identifiant ou mot de passe";
			}
		}
	}
	else
	{
		$erreur = "Tout les champs doivent éter completer";
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="design/style.css">
		<title>DATALINK - Login-in</title>
	</head>

	<body>
		
		<div align="center">
			<h2>DATA-LINK</h2>
			<h2>Connection</h2>
			<br /><br /><br />
			<form method="POST" action="">
				<table>
					<tr>
						<td align="right"><label for="loginConnect"></label>Login :</td>
						<td><input type="text" name="loginConnect" id="loginConnect" /></td>
					</tr>
					<tr>
						<td align="right"><label for="passwordConnect"></label>Mot de passe :</td>
						<td><input type="password" name="passwordConnect" id="passwordConnect" /></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="formConnect" value="Se connecter"></td>
					</tr>
				</table>
			</form>
<?php

if (isset($erreur)) 
{
	echo $erreur;
}

?>
		</div>

	</body>
</html>