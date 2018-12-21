<?php
    //Démarrage de la session pour retenir le mot de passe
    session_start();
    $nb_msg_page = 10;
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8" />
        <title>Mon mini Chat</title>
    </head>

    <body>
        <form action="miniChat_post.php" method="POST">
        <?php
            if (isset($_SESSION['pseudo']) OR $_SESSION['pseudo'] != '')
            {
                $pseudo = htmlspecialchars($_SESSION['pseudo']);
            }
            else 
            {
                $pseudo = "";
            }
?>

            
        <p><label>Pseudo : </label><input type="input" name="pseudo" value="<?php echo $pseudo; ?>" /></p>
            <p><label>Message : </label><input type="input" name="message" value="" /></p>
            <p><input type="submit" value="Poster le message" /></p>
        </form>
        <a href="miniChat.php">Actualiser</a>

        <?php 
            try
            { 
                $bdd = new PDO('mysql:host=localhost;dbname=miniChat;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch(Exception $e)
            {
                die('Erreur : ' . $e->getMessage());
            }

            if (isset($_GET['page']))
            {
                $num_page = (int) $_GET['page'];
                $lim_min = $nb_msg_page*($num_page-1);
                $lim_max = $nb_msg_page*($num_page);
            }
            else
            {
                $lim_min = 0;
                $lim_max = 10;
            }

            //Affichage de tous les messages envoyés par la base
            $requete = $bdd->prepare('SELECT pseudo, message, DATE_FORMAT(date_message, \'%d/%m/%Y - %Hh%imin%ss\') as date_message_fr FROM messages ORDER BY ID DESC LIMIT :lim_min,:lim_max');
            $requete->bindValue(':lim_min', intval($lim_min), PDO::PARAM_INT);
            $requete->bindValue(':lim_max', intval($lim_max), PDO::PARAM_INT);

            $requete->execute();
            
            
            while ($message = $requete->fetch())
            {
                if(isset($message['pseudo']) AND isset($message['message']))
                {
                    //traitement du message pour afficher le BBCode
                    $message_traite = nl2br(htmlspecialchars(stripslashes($message['message'])));
                    $message_traite = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $message_traite);
                    $message_traite = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $message_traite);
                    $message_traite = preg_replace('#\[color=(.+)\](.+)\[/color\]#isU','<span style="color:$1">$2</span>', $message_traite);
                    $message_traite = preg_replace('#(http|https):[a-z0-9._/-]+(\?)?([a-z0-9]+=[a-z0-9]+(&(amp;)?)?)*#i', '<a href="$0">$0</a>', $message_traite);

                    echo '<p><strong>' . htmlspecialchars($message['pseudo']) . '</strong> à '. $message['date_message_fr'] . ' : ' . $message_traite . '</p>';
                } 

            }

            //Affichage du nombre de page
            $requete = $bdd->query('SELECT COUNT(*) AS nb_messages FROM messages');

            while ($nb_ligne = $requete->fetch())
            {
                echo '<p> Pages : ';
                $i_max = ceil(((int)$nb_ligne['nb_messages'])/ $nb_msg_page);
                for($i = 1; $i <= $i_max  ; $i++)
                {
                    echo '<a href="miniChat.php?page=' . $i .'">' . $i . '</a>';

                    if ($i < $i_max) 
                    {
                        echo '  -  ';
                    }
                }
                echo '</p>';
            }
        ?>


    </body>
</html>
