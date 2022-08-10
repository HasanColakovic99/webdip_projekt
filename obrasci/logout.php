<?php
    session_start();
    unset($_SESSION['uloga_korisnika']);
    session_destroy();
    header('Location: prijava.php');
    exit();
?>