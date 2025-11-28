<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=Projets_full_stack; charset=utf8;', 'root', '');

$errorMsg = "";

if (isset($_POST['envoie'])) {
if(!empty($_POST['email']) AND !empty($_POST['password'])) {
    // Ici on récupere les données de la connexion(htmlspecialchars c'est le truc anti injection sql) //
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    
    // On verifie si l'utilisateur existe dans la bdd grace à leur email//
    $selectUser = $bdd->prepare("SELECT * FROM users WHERE email = ?");
    $selectUser->execute(array($email));

    // Si l'utilisateur existe on va verifier le mdp //
    if ($selectUser->rowCount() > 0) {
        $user = $selectUser->fetch();

        // On verifie le mot de passe -> en gros le mdp dans la bdd est hashé avec une randomseed donc même si on a le meme mdp, on ne pourra pas le lire donc on use password_verify //
        if (password_verify($password, $user['password'])) {
            // On attrivut les données dans des variables de session //
            $_SESSION['connected'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['lastName'] = $user['lastName'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['email'] = $user['email'];

            header("Location: ../../index.php");
        } else {
            $errorMsg = "Adresse Mail ou Mot de passe incorrect.";
        }
    } else {
        $errorMsg = "Adresse Mail ou Mot de passe incorrect.";
    }
} else {
    $errorMsg = "Merci de remplir tous les champs !";
}




}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/login.css">
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">

                <!-- Connexion -->


              <!-- Message d'erreur -->
                <?php if (!empty($errorMsg)): ?>
                    <div class="error-message">
                        <?= htmlspecialchars($errorMsg) ?>
                    </div>
                <?php endif; ?>


                    <!-- Formulaire de connexion -->
                <form method="POST" action="#" class="sign-in-form">
                    <h2 class="title">Connexion</h2>
                    <p class="subtitle">Heureux de vous revoir ! 👋</p>

                    <div class="input-field">
                        <i>📧</i>
                        <input type="text" name="email" placeholder="Email" />
                    </div>
                    <div class="input-field">
                        <i>🔒</i>
                        <input type="password" name="password" placeholder="Mot de passe" />
                    </div>

                    <input type="submit" name = "envoie" value="Se connecter" class="btn solid" />

                 

                
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <a href="../../index.php" class="btn retour-btn" id ="retour-btn" role="button" aria-label="Retour à l'accueil">← Accueil</a>
                    <h3>Nouveau ici ?</h3>
                    <p>
                        Découvrez une gestion de projet simplifiée grace à GuardiaProjets. Créez votre compte en seulement quelques clics.
                    </p>
                    <a href="register.php" class="btn transparent" id="sign-up-btn">S'inscrire</a>
                </div>
                <!-- Image SVG simplifiée intégrée pour éviter les liens externes cassés -->
                <svg class="image" viewBox="0 0 500 300" xmlns="http://www.w3.org/2000/svg">
                   <g transform="translate(20,20)">
                        <rect x="50" y="0" width="300" height="200" rx="10" fill="rgba(255,255,255,0.2)"/>
                        <rect x="70" y="30" width="260" height="140" rx="5" fill="rgba(255,255,255,0.4)"/>
                        <circle cx="30" cy="180" r="30" fill="#fff" opacity="0.8"/>
                        <circle cx="400" cy="50" r="50" fill="#fff" opacity="0.6"/>
                   </g>
                </svg>
            </div>
        </div>
    </div>
    
</body>
</html>