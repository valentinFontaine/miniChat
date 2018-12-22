<?php

        session_start();
//  Récupération de l'utilisateur et de son pass hashé
try
{ 
    $bdd = new PDO('mysql:host=localhost;dbname=miniChat;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

$req = $bdd->prepare('SELECT id, pass FROM members WHERE pseudo = :pseudo');

$req->execute(array(

    'pseudo' => htmlspecialchars($_POST['pseudo'])));

$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['password'], $resultat['pass']);

if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passe !';
}
else
{

    if ($isPasswordCorrect) {


        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $_POST['pseudo'];

        header('Location: miniChat.php');    

    }

    else {

        header('Location: connexion.php?erreur=password');
    }

}
