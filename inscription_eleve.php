<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Inscription d'un élève à une séance</titres></br></br></br>

	<?php

		date_default_timezone_set('Europe/Paris');
		$date_actuelle = date("Ymd");


    include (connexion.php);
		$table_eleves = mysqli_query($connect,"SELECT * FROM eleves"); //On choisit tous les élèves
		$table_seances = mysqli_query($connect,"SELECT * FROM seance"); // On choisit toutes les séances

		if(!$table_eleves)
		{
			echo "<br> Erreur :".mysqli_error($connect);
		}
		if(!$table_seances)
		{
			echo "<br> Erreur :".mysqli_error($connect);
		}
		else
		{
			//Formulaire pour choisir un élève et une séance
			echo "<table>";

			echo "<FORM METHOD='POST' ACTION='inscrire_eleve.php' >";
			echo "<tr><td>Choisissez l'élève :</td><td><select name='eleve' BORDER='1'>";

			foreach ($table_eleves as $eleve)
			{
				echo "<option value=".$eleve['ideleve'].">".$eleve['prenom']." ".$eleve['nom']." ".$eleve['dateNaiss']."</option>";
			}

			echo "</select></td></tr>";
			echo "<tr></tr>";


			foreach ($table_seances as $seance)
			{
						$id_theme = $seance['Idtheme'];
						$theme_seance_query = mysqli_query($connect,"SELECT * FROM themes WHERE idtheme = $id_theme;"); //requête pour avoir les infos de la séance
						$theme_seance = mysqli_fetch_array($theme_seance_query, MYSQL_NUM);

						if ($theme_seance['supprime']==0 && (strtotime($seance[1]) >= strtotime($date_actuelle))) // On vérifie que la séance n'est pas passée
						{
							echo "<option value=".$seance[0].">".$theme_seance[1]." ".$seance[1]."</option>";
						}
			}

			echo "</select></td></tr>";

			echo "<tr><td><br><br><INPUT type='submit' value='Enregistrer inscription'></td></tr>";

			echo "</FORM>";

			echo "</table>";
		}

	?>


</body>
</html>
