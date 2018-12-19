<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8" />
        <title>Mon mini Chat</title>
    </head>

    <body>
        <form action="miniChat_post.php" method="POST">
            <p><label>Pseudo : </label><input type="input" name="pseudo" value="" /></p>
            <p><label>Message : </label><input type="input" name="message" value="" /></p>
            <p><input type="submit" value="Poster le message" /></p>
        </form>

        <?php 
            try
            { 
                $bdd = new PDO('mysql:host=localhost;dbname=miniChat;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch(Exception $e)
            {
                die('Erreur : ' . $e->getMessage());
            }

            //Affichage de tous les messages envoyés par la base
            $requete = $bdd->query('SELECT pseudo, message, DATE_FORMAT(date_message, \'%d/%m/%Y - %Hh%imin%ss\') as date_message_fr FROM messages ORDER BY ID DESC');
            while ($message = $requete->fetch())
            {
                if(isset($message['pseudo']) AND isset($message['message']))
                {
                    echo '<p><strong>' . htmlspecialchars($message['pseudo']) . '</strong> à '. $message['date_message_fr'] . ' : ' . htmlspecialchars($message['message']) . '</p>';
                } 

            }
        ?>


    </body>
</html>
