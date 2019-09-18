<?php
session_start();

include('includes/identifiants.php');
include('includes/debut.php');
?>

<div class="text-align-center">
?php
    if(!isset($_SESSION['pseudo']))
    {
        include('includes/banniere-noconnect.php');
     
//=================== FORMULAIRE DE CONNEXION ================================

    <fieldset>
       <h2> Bonjour et bienvenue sur monsite </h2>
         <p> Pour accéder à cette section tu dois t'identifier<br/>
         
         <a href="inscription"> Pas encore inscrit ?</a></p>
         <br/>
         
         <form method="post" action="connexion.php">
            <p>e-mail <br/>
            <input name="email" type="mail" id="email" placeholder="Email" /><br /><br/>
            Mot de passe <br/>
            <input type="password" name="password" id="password" placeholder="Mot de passe" /><br/><br/>
            <input type="hidden" name="membre_id" value="<?php echo $data['membre_id']; ?>" /></p>

            <input type="submit" value="Connexion" />
         </form>
     </fieldset>
    
    <p><a href="inscription.php">Pas encore inscrit ?</a></p>
    <?php
    }

    else
    {
      include('includes/banniere-membres.php');
      $email = $_SESSION['email'];
      $query=$db->prepare('SELECT membre_pseudo, membre_avatar, membre_inscrit, membre_confirm
      FROM membres');
      $query->execute();
      $data=$query->fetch();
  		$pseudo = $_SESSION['pseudo'];
      $avatar = $_SESSION['avatar'];

			echo'<p>Ta connexion est déja active ' . $pseudo . ' </p><br/>';
      echo'<p>Clique sur ton avatar pour retourner sur ton SpaceFamily</p><br/>';
      
      //Si le membre n a pas d avatar, un par defaut
      if(!empty($_SESSION['avatar']))
      {
         echo '<p>
         <a href="http://www.monsite.fr/sections/index.php">
         <img class="roundedImage" src="http://www.monsite.fr/sections/membres/avatars/'.$_SESSION['avatar'].'" 
         alt="Avatar" title="Retour espace membre"/>
         </a></p>';
      }
      else //Le membre a un avatar perso
      {
         echo '<p>
         <a href="http://www.monsite.fr/sections/index.php">
         <img class="roundedImage" src="http://www.monsite.fr/sections/membres/avatars/avatar-par-defaut.png" 
         alt="Avatar" title="Retour espace membre" />
         </a></p>';
      }
      
      echo '
      <a href="http://www.monsite.fr/sections/deconnexion.php"> 
      Me deconnecter</a>
      
} //end if isset session

include('includes/footer.php');

