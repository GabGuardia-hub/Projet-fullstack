
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nav</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <div class="top-nav">
            <a href="../../index.php" class="logo"><span class="guardia" style="color: #6d28d9;">Guardia</span><span class="navprojets" style ='color: #2563eb'>Projets</span></a>
            <div class="header-actions">
                <a class="btn btn-ghost" href="../Gestion/projets.php">Mes projets</a>
                <a class="btn btn-ghost" href="../support/Aide.php">Aide</a>
                <a class="btn btn-ghost" href="../support/Contact.php">Contact</a>
                <?php if (!isset($_SESSION['connected'])): ?>
                    <a class="btn btn-gradient" href="../Authentification/login.php">Se connecter</a>
                <?php else: ?>
                    <a class="btn btn-gradient" href="../Gestion/account.php">Mon compte</a>
                <?php endif; ?>
            </div>
        </div>
</body>
</html>
