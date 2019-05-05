<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=datalink', 'root','');

if(isset($_POST['formNewAdherent']))
{
	$codeRFIDAdherent = htmlspecialchars($_POST['RFID_carte_adherent']);
	$codeRFIDLivre = htmlspecialchars($_POST['RFID_livre']);
	if(!empty($codeRFIDAdherent) AND !empty($codeRFIDLivre))
	{
		$reqdoc = $bdd->query('SELECT RFID_documents, RFID_adherent FROM adherents, documents');
		$docInfo = $reqdoc->fetch();
		if ($codeRFIDAdherent == $docInfo['RFID_adherent']) 
		{
			if ($codeRFIDLivre == $docInfo['RFID_documents']) 
			{
				$reqdoc->closeCursor();
				$reqade = $bdd->prepare('SELECT id FROM adherents WHERE RFID_adherent = ?');
				$reqade->execute(array($codeRFIDAdherent));
				$idInfo = $reqade->fetch();
				$reqdoc = $bdd->prepare('INSERT ON documents(id_adherent, date_echeance) VALUES($idInfo, DATE_ADD(CURDATE(), INTERVAL 14 DAY))');
				$erreur = "Le livre a été bien été emprunter";
				$reqdoc->closeCursor();
				$reqade->closeCursor();
				$reqdoc = $bdd->prepare('SELECT date_echeance FROM documents WHERE RFID_documents = ?');
				$reqdoc->execute(array($codeRFIDLivre));
				$docInfo = $reqdoc->fetch();
				$reqdoc->closeCursor();
			}
			else
			{
				$erreur = "Le code RFID est incorecte ou ne correspond à aucun livre";
			}
		}
		else
		{
			$erreur = "Le livre a été bien été emprunter";
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
		<title>DATALINK - NEW EMPRUNT</title>
	</head>

	<body>
		
		<div align="center">
			<h2>DATA-LINK</h2>
			<h2>New Emprunt</h2>
			<br /><br /><br />
			<form method="POST" action="">
				<table>
					<tr>
						<td align="right"><label for="RFID_carte_adherent"></label>Code RFID Carte Adherent :</td>
						<td><input type="text" name="RFID_carte_adherent" id="RFID_carte_adherent" /></td>
					</tr>
					<tr>
						<td align="right"><label for="RFID_livre"></label>Code RFID Livre :</td>
						<td><input type="text" name="RFID_livre" id="RFID_livre" /></td>
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
$erreur = "Le code RFID est incorecte ou ne correspond à aucun adherents";