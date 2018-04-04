<?php

// Récupère des films de manière aléatoire.
// $nbfilm = le nombre de film que l'on veut récupérer
function getRandomFilm($nbfilm)
{
    global $pdo;
    $sql = "SELECT * FROM movies_full ORDER BY RAND() LIMIT $nbfilm";
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

// recupérer une column, grâce un nom mis en paramètre
function getTabColumnValues($column, $table="movies_full")
{
    global $pdo;
    $sql = "SELECT DISTINCT $column FROM $table";
    $query = $pdo->prepare($sql);
    $query->bindValue(':column', $column, PDO::PARAM_STR);
    $query->execute();
    $column = $query->fetchAll();

    return $column;
}

// Search film by years, genres and popularity
function searchFilm(array $terms, $table="movies_full")
{
    global $pdo;
    $sql = "SELECT * FROM $table WHERE 1 = 1";
    $index = 0;
    $bindTable = array();
    $requestPiece = array();
    $finalPiece = array();
    $param = '';

    foreach($terms as $key => $values)
    {
        if($key == 'genres' && !is_null($values)){
            foreach($values as $value){
                $param = ':val' . $index;
                $bindTable['PDO::PARAM_STR'][$param] = '%' . $value . '%';
                $requestPiece['genres'][] = 'genres LIKE ' . $param;
                $index++;
            }
        } elseif($key == 'years' && !is_null($values)){
            foreach($values as $value){
                $param = ':val' . $index;
                $bindTable['PDO::PARAM_INT'][$param] = $value;
                $requestPiece['years'][] = 'year = ' . $param;
                $index++;
            }
        } elseif($key == 'popularity' && !is_null($values)){
                $param = ':val' . $index;
                $bindTable['PDO::PARAM_INT'][$param] = $values;
                $requestPiece['popularity'][] = 'popularity > ' . $param;
                $index++;
        }
    }

    // merge final request pieces
    $finalPiece[] = $sql;
    foreach($requestPiece as $elem)
    {
        $finalPiece[] = '( ' .implode(' OR ', $elem). ' )';
    }

    $sql = implode(' AND ', $finalPiece);
    /* echo $sql; */
    /* debug($bindTable); */

    // bind values of request
    $query = $pdo->prepare($sql);
    foreach($bindTable as $key => $values)
    {
        foreach($values as $param => $value)
        {
            if($key == 'PDO::PARAM_INT') {
                $query->bindValue($param, $value, PDO::PARAM_INT);
            } elseif($key == 'PDO::PARAM_STR') {
                $query->bindValue($param, $value, PDO::PARAM_STR);
            }
        }
    }
    $query->execute();
    $films = $query->fetchAll();

    return $films;
}
