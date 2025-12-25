<?php
    require_once __DIR__ . "/Classes/Database.php";

    $db = new Database("localhost", "Smart_Wallet_db", "root", "");
    $pdo = $db->getConnection();