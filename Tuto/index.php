<?php

include('autoload.php');

$perso = new Personnage([
    'nom' => 'Victor',
    'forcePerso' => 5,
    'degats' => 0,
    'niveau' => 1,
    'experience' => 0
]);

try {
    $db = new PDO('mysql:host=localhost;dbname=ocpoo', 'iamroot', 'iamroot');
} catch (PDOException $e) {
    die('Erreur : boulette ' . $e->getMessage());
}

$manager = new PersonnagesManager($db);
$manager->add($perso);
