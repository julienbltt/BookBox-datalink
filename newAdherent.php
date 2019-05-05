<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=datalink', 'root','');

if(isset($_POST['formNewAdherent']))
{
	$name = htmlspecialchars($_POST['nom']);
	$firstname = htmlspecialchars($_POST['prenom']);
	$codeRFIDAdherent = $_POST['code_RFID_adherent'];
	if(!empty($name) AND !empty($firstname) AND !empty($codeRFIDAdherent))
	{
		$reqUser = $bdd->prepare('SELECT * FROM adherents WHERE nom = ?, prenom = ?, RFID_adherent = ?');
		$reqUser->execute(array($name ,$firstname, $codeRFIDAdherent));
		$userInfo = $reqUser->fetch();
		if (!$userInfo)
		{
			$insertadr = $bdd->prepare('INSERT INTO adherents(nom, prenom, RFID_adherent) VALUES (?, ?, ?)');
						$insertadr->execute(array($name, $firstname, $codeRFIDAdherent));
				$erreur = "Adherent bien ajouté";
		        header('Location: acceuil.php?id='. $_SESSION['id'] );
		}
		else
		{
			$erreur = "L'adherent éxiste déjà";
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
		<title>DATALINK - NEW ADHERENT</title>
	</head>

	<body>
		
		<div align="center">
			<h2>DATA-LINK</h2>
			<h2>New Adherent</h2>
			<br /><br /><br />
			<form method="POST" action="">
				<table>
					<tr>
						<td align="right"><label for="nom"></label>Nom :</td>
						<td><input type="text" name="nom" id="nom" /></td>
					</tr>
					<tr>
						<td align="right"><label for="prenom"></label>Prénom :</td>
						<td><input type="text" name="prenom" id="prenom" /></td>
					</tr>
					<tr>
						<td align="right"><label for="code_RFID_adherent"></label>Code RFID :</td>
						<td><input type="number" name="code_RFID_adherent" id="code_RFID_adherent"/></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="formNewAdherent" value="Ajouté"></td>
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