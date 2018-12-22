<?php

//Connexion à la base de donnée
try
{ 
    $bdd = new PDO('mysql:host=localhost;dbname=miniChat;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['pseudo']) AND isset($_POST['mail']) AND isset($_POST['password_1']) AND isset($_POST['password_2']))
{
    
    if ($_POST['password_1'] != $_POST['password_2']) 
    {
        header('Location: inscription.php?error=password');
    }
    elseif (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['mail']))
    {
        header('Location: inscription.php?error=mail');
    }
    else
    {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $password = password_hash($_POST['password_1'], PASSWORD_DEFAULT);


        if ($pseudo != '' AND $mail != '' AND $password !='')
        {
            $requete = $bdd->prepare('INSERT INTO members(pseudo, mail, pass, date_subscription) VALUES(:pseudo, :mail, :pass, CURDATE())');
            $requete->execute(array('pseudo' => $pseudo, 'mail' => $mail, 'pass' => $password));

            header('Location: connexion.php');

        }
        else
        {
            header('Location: inscription.php?error=empty');
        }
    }
}
else
{
    header('Location: inscription.php');
}


