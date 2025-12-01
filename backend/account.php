<?php
session_start();
if (!isset($_SESSION['connected'])){
    header("Location: /Projet-fullstack/pages/Authentification/login.php");
    exit();
}

?>