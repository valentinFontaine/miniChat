<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8" />
        <title>Inscription</title>
    </head>
    
    <body>
        <form action="inscription_post.php" method="POST" />
            
            <p><label>Votre pseudo : </label><input name="pseudo" value="" type="text" /></p>
            <p><label>Adresse mail : </label><input name="mail" value="" type="text" /></p>
            <p><label>Mot de passe : </label><input name="password_1" value="" type="password" /></p>
            <p><label>Confirmez votre mot de passe : </label><input name="password_2" value="" type="password" /></p>
            <p><input type="submit" value="s'inscrire" /></p>
            
        </form>
    </body>
</html>
