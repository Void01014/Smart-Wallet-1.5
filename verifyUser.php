<?php

$current_page = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION['logged_in']) && !in_array($current_page, ["signIn.php", "signUp.php"])) {
    header('Location: signUp.php');
    // echo $current_page;
    exit();
}

if (isset($_SESSION['logged_in']) && in_array($current_page, ["signin.php", "signUp.php"])) {
    header('Location: index.php');
    echo $current_page;
    exit();
}
?>
