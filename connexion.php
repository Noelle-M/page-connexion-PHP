<?php
session_start(); 
include('includes/identifiants.php');
include('includes/debut.php');

$query = $db->prepare('SELECT * FROM membres WHERE membre_email = :email AND membre_mdp = :pass');
$query->bindValue(':email',$_POST['email'], PDO::PARAM_STR);
$query->bindValue(':pass',$_POST['password'], PDO::PARAM_STR);
$query->execute();
$data=$query->fetch();

$message='';
    if (empty($_POST['email']) || empty($_POST['password']) ) //Oublie d'un champ
        {
            $message = '<p class="white center">Merci de saisir tous les champs</p>
            <p><a class="white" href="http://www.monsite.fr/index.php">
            Cliquez ici pour revenir à la page précédente</a></p>';
        }

    else // Acces OK !
		{
			$_SESSION['email'] = $data['membre_email'];
			$_SESSION['membre_confirm'] = $data['membre_confirm'];
			$_SESSION['pseudo'] = $data['membre_pseudo'];
      $_SESSION['nom'] = $data['membre_nom'];
			$_SESSION['level'] = $data['membre_rang']; // permet de gérer les droits des membres et/ou les admins
			$_SESSION['id'] = $data['membre_id'];
			$_SESSION['avatar'] = $data['membre_avatar'];
      
			$message = ' ';
      
      // Confirmation suite à une inscription
      //Lors de l'inscription le champ confirm du formulaire est HIDDEN et value à 0
			if ($data['membre_email'] === $_POST['email'] && $data['membre_mdp'] === $_POST['password'] && $data['membre_confirm'] == 0)
			{
				echo'
				<meta http-equiv="refresh" content="1 ; url=http://www.monsite.fr/sections/membres/voirprofil.php?m='.$_SESSION['id'].'&amp;action=modifier">
				';
			}

      //Si le membre est déjà confirmé
			elseif($data['membre_email'] === $_POST['email'] && $data['membre_mdp'] === $_POST['password'] && $data['membre_confirm'] == 1)
			{
              	$query=$db->prepare('UPDATE membres SET membre_connect = 1
                WHERE membre_id = :membre_id');
                $query->bindValue(':membre_id', $_SESSION['id'],PDO::PARAM_INT);
                $query->execute();
				?>
				<meta http-equiv="refresh" content="1 ; url=http://www.monsite.fr/sections/membres/index.php">
				<?php
			}

			else // Acces pas OK !
			{
				$message = '<p class="white center">Une erreur s\'est produite lors de votre identification.<br /> 
                Le mot de passe ou l\'adresse mail saisi n\'est pas correcte.</p>';
              	?>
				<meta http-equiv="refresh" content="1 ; url=http://www.monsite.fr/sections/membres/deconnexion.php">
				<?php
			}
	}
		$query->CloseCursor();
echo $message;          
