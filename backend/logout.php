<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: /Projet-fullstack/pages/Authentification/login.php");
?>