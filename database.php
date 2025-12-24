<?php
    require_once __DIR__ . "/Classes/Database.php";

    $db = new Database("localhost", "wallet", "root", "");
    $pdo = $db->getConnection();