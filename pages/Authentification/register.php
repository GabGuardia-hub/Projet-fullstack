<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=Projets_full_stack; charset=utf8;', 'root', '');

if (isset($_POST['envoie'])) {


    if(!empty($_POST['lastName']) AND !empty($_POST['firstName']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['confirmPassword'])) {
        
        
        // Ici on récupere les données de l'insciption //
        $lastName = htmlspecialchars($_POST['lastName']);
        $firstName = htmlspecialchars($_POST['firstName']);
        $email = htmlspecialchars($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $confirmPassword = password_hash($_POST['confirmPassword'], PASSWORD_DEFAULT);

        
        // En gros ici, on creer une fonction "selectUser" qui va recuperer dans la bdd : l'id du compte qui vient detre créé //
        // Et le if d'en dessous verifie si l'email est deja utilisé //
        $selectUser = $bdd->prepare("SELECT id FROM users WHERE lastName = ? AND firstName = ? AND email = ?");
        $selectUser->execute(array($lastName, $firstName, $email));
        if ($selectUser->rowCount() > 0) {
            echo "Adresse email déjà utilisée.";
            exit();
        }

        // On attrivut les données dans des variables de session //
        $_SESSION['id'] = $selectUser->fetch();['id']; 
        $_SESSION['lastName'] = $lastName;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;


        //On insere les données dans la bdd //
        $insertUser = $bdd->prepare("INSERT INTO users (lastName, firstName, email, password) VALUES (?, ?, ?, ?)");
        $insertUser->execute(array($lastName, $firstName, $email, $password));

        header("Location: login.php");


    }else {
        echo "Tous les champs doivent être complétés !";
    }

    

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/register.css">
</head>
<body>
    <div class="register-card">
        <div class="header">
            <div class="logo">🚀 GuardiaProject</div>
            <h1 class="title">Créer un compte</h1>
        </div>

        <!-- Message d'erreur -->
        <?php if (!empty($errorMsg)): ?>
            <div class="error-message">
                <?= htmlspecialchars($errorMsg) ?>
            </div>
        <?php endif; ?>


        <form action="#" method="POST">
            <div class="form-group">
                <!--ici c'est le nom de famille / name = lastName-->
                <label class="label">Nom de famille</label>
                <div class="input-wrapper">
                    <span class="input-icon">👤</span>
                    <input type="text" name = "lastName" class="input-field" placeholder="Dupont" autocomplete="off" required>
                </div>
            </div>
            <!--ici c'est le prenom / name = firstName-->
            <div class="form-group">
                <label class="label">Prénom</label>
                <div class="input-wrapper">
                    <span class="input-icon">👤</span>
                    <input type="text" name="firstName" class="input-field" placeholder="Jean" autocomplete="off"  require>
                </div>
            </div>
            <!--ici c'est l'email / name = email-->
            <div class="form-group">
                <label class="label">Email professionnel</label>
                <div class="input-wrapper">
                    <span class="input-icon">📧</span>
                    <input type="email" name="email" class="input-field" placeholder="nom@entreprise.com" autocomplete="off" required>
                </div>
            </div>

            <!--ici c'est le password / name = password-->
            <div class="form-group">
                <label class="label">Mot de passe</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password" class="input-field" placeholder="8+ caractères" autocomplete="off" required>
                </div>
            </div>

            <!--ici c'est la confirmation du password / name = confirmPassword-->
            <div class="form-group">
                <label class="label">Confirmer le mot de passe</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔐</span>
                    <input type="password" name="confirmPassword" class="input-field" placeholder="Répétez le mot de passe" autocomplete="off" required>
                </div>
            </div>

            <div class="terms-check">
                <input type="checkbox" id="terms" required>
                <label for="terms">
                    J'accepte les <a href="#" class="terms-link">conditions d'utilisation</a> et la <a href="#" class="terms-link">politique de confidentialité</a>.
                </label>
            </div>

            <!--ici c'est le bouton d'envoie -->
            <button type="submit" name = "envoie" class="btn-submit">Créer mon compte</button>

            <div class="footer-link">
                Déjà membre ? <a href="login.php">Se connecter</a>
            </div>
        </form>
    </div>
</body>
</html>