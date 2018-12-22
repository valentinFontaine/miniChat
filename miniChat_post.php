<?php
//Démarrage de la session 
session_start();

//Connexion à la base de donnée
try
{ 
    $bdd = new PDO('mysql:host=localhost;dbname=miniChat;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

//envoi du message à la base de données (si il y en a un) 
if (isset($_SESSION['id'])  AND isset($_POST['message']))
{
    $message = ($_POST['message']);

    if ($message != '')
    {
        $requete = $bdd->prepare('INSERT INTO messages(id_pseudo, message, date_message) VALUES(:id_pseudo, :message, NOW())');
        $requete->execute(array('id_pseudo' => $_SESSION['id'], 'message' => $message));
    }

    header('Location: miniChat.php');
}
else
{
    header('Location: connexion.php');
}


?>
