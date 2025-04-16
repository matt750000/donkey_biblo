<?php
require_once './config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    echo "erreur de connexsion : " . $e->getMessage();
    die();
}
