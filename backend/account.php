<?php
session_start();
if (!isset($_SESSION['connected'])){
    header("Location: ../pages/Authentification/login.php");
    exit();
}

?>