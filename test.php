<?php
require 'config.php';

$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();

echo "<pre>";
print_r($users);


// remplacer student par courses 
// ajouter appointement dans le rubrique
// integrer careers dabs contact us
// supprimer le logo dans le navbar
// amincir le header 
// ajouter la barre de recherche dans main section 
// deployer le logo cheval en ligne 
// ajouter un titre pour le chatbox 


