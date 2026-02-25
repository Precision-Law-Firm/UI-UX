<?php
$host =  "srv502.hstgr.io";
$port = 3306;
$dbname = "u662658788_plf_db";
$username = "u662658788_plf";
$password = "y>Mf9|v$9X/";

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