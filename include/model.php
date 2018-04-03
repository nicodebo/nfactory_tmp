<?php

// Récupère des films de manière aléatoire.
// $nbfilm = le nombre de film que l'on veut récupérer
function getRandomFilm($nbfilm)
{
    global $pdo;
    $sql = "SELECT * FROM movies_full ORDER BY RAND() LIMIT $nbfilm";
    echo $sql;
    $query = $pdo->prepare($sql);
    $query->execute();
    $films = $query->fetchAll();

    return $films;
}


//Récupère un element par son id
// $id = l'id que l'on recherche
function readFilmById($id)
{
    global $pdo;
    $sql = "SELECT * FROM movies_full WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $film = $query->fetch();

    return $film;
}


//Cette fonction permet de savoir si un id existe
// $id = l'id dont l'on veut vérifier que la ligne existe.
function checkFilmExists($id, $table="movies_full")
{
    $exists = false;
    global $pdo;
    $sql = "SELECT id FROM $table WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    if($query->fetch())
    {
        $exists = true;
    }

    return $exists;
}
