<?php

$db_name='webolic_5nuns';

try
{
    if($os == 'Windows') {

        $pdo = new PDO('mysql:host=localhost;dbname=' . $db_name, "root", "", array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // permet de recupérer des tableaux
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING // permet d'afficher les erreurs
        ));

    } elseif($os == 'Mac') {

        $pdo = new PDO('mysql:host=localhost;dbname=' . $db_name, "root", "root", array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // permet de recupérer des tableaux
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING // permet d'afficher les erreurs
        ));

    }
}
catch (PDOException $e)
{
    echo 'Erreur de connexion : ' . $e->getMessage();
}
