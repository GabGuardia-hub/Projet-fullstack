<?php
$bdd = new PDO('mysql:host=localhost;dbname=Projets_full_stack;charset=utf8;', 'root', 'root');
    if (isset($_POST['valider'])) {

        

        if (!empty($_POST['newlastName']) && !empty($_POST['newfirstName']) && !empty($_POST['newemail']) && !empty($_POST['newphone'])) {
            $errorMsg = "Tous les champs sont obligatoires.";
            
        }
        $newlastName = htmlspecialchars($_POST['newlastName']);
        $newfirstName = htmlspecialchars($_POST['newfirstName']);
        $newemail = htmlspecialchars($_POST['newemail']);
        $newphone = htmlspecialchars($_POST['newphone']);

        $updateUser = $bdd->prepare("UPDATE users SET lastName = ?, firstName = ?, email = ?, phone = ? WHERE id = ?");
        $updateUser->execute(array($newlastName, $newfirstName, $newemail, $newphone, $_SESSION['id']));

        // Mettre à jour les variables de session
        $_SESSION['lastName'] = $newlastName;
        $_SESSION['firstName'] = $newfirstName;
        $_SESSION['email'] = $newemail;
        $_SESSION['phone'] = $newphone;

        
    }


?>