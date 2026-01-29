<?php
require 'config.php';

$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();

echo "<pre>";
print_r($users);
