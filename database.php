<?php
    session_start();

    require_once __DIR__ . "/Classes/Database.php";

    $db = new Database("localhost", "Smart_Wallet_db_1.5", "root", "");
    $pdo = $db->getConnection();