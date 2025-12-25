<?php
    session_start();
    $_SESSION = [];
    session_destroy();
    header("Location: signIn.php");

    exit();
?>