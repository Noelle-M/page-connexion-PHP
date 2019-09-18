<?php
session_start();
$titre="Déconnexion";

include("includes/identifiants.php");
include("includes/debut.php");

//membre_connect = 0 indicateur qui permet de mettre un visuel sur les membres connectés ou pas
//met le champ à 1 lors de la connexion

$query=$db->prepare('UPDATE membres SET membre_connect = 0
WHERE membre_id = :membre_id');
$query->bindValue(':membre_id', $_SESSION['id'],PDO::PARAM_INT);
$query->execute();
echo '<p> Redirection automatique<br/>
<a href="http://www.monsite.fr/index.php">Cliquez ici pour revenir à la page d\'accueil.</a></p><br />';

session_start();
if (isset ($_COOKIE['pseudo']))
{
setcookie('pseudo', '', -1);
}
session_destroy();
?>
<meta charset="utf-8" http-equiv="Refresh" content="0.3;URL=http://www.monsite.fr/index.php"/>

include("includes/footer.php");
