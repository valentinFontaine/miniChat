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
if (isset($_POST['pseudo']) AND isset($_POST['message']) ) 
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $message = htmlspecialchars($_POST['message']);

    if ($pseudo != '' AND $message != '')
    {
        $requete = $bdd->prepare('INSERT INTO messages(pseudo, message, date_message) VALUES(:pseudo, :message, NOW())');
        $requete->execute(array('pseudo' => $pseudo, 'message' => $message));

        $_SESSION['pseudo'] = $pseudo;
    }
}

header('Location: miniChat.php');
?>
