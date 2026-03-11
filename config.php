<?php
$host =  "localhost";
$port = 3306;
$dbname = "u662658788_plf_db";
$username = "root";
$password = "root";

try {
 $pdo = new PDO(
 "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
 $username,
 $password,
 [
 PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
 PDO::ATTR_EMULATE_PREPARES => false,
 ]
 );
} catch (PDOException $e) {
 die("DB error: " . $e->getMessage());
}

