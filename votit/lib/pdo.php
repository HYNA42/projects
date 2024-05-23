<?php

try {
    //code...
    $pdo = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=utf8', DB_USER, BD_PASSWORD);
} catch (PDOException $e) {
    die('Erreur : ' . $se->getMessage());
}
