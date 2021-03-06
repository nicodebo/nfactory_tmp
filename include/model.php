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

//Récupère un element par son nom de colonne et sa valeur
function readTableByColVal($col, $val, $table="movies_full")
{
    global $pdo;
    $sql = "SELECT * FROM $table WHERE $col = :val";
    $query = $pdo->prepare($sql);
    $query->bindValue(':val', $val, PDO::PARAM_STR);
    $query->execute();
    $elem = $query->fetch();

    return $elem;
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

//Cette fonction permet de savoir si un slug existe
// $slug = le slug dont l'on veut vérifier que la ligne existe.
function checkFilmExistsBySlug($slug, $table="movies_full")
{
    $exists = false;
    global $pdo;
    $sql = "SELECT slug FROM $table WHERE slug = :slug";
    $query = $pdo->prepare($sql);
    $query->bindValue(':slug', $slug, PDO::PARAM_STR);
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
                $bindTable['str'][$param] = '%' . $value . '%';
                $requestPiece['genres'][] = 'genres LIKE ' . $param;
                $index++;
            }
        } elseif($key == 'years' && !is_null($values)){
            foreach($values as $value){
                $expYears = explode('-', $value);
                $param = ':val' . $index;
                $bindTable['int'][$param] = $expYears[0];
                $requestPiece['years'][] = 'year BETWEEN ' . $param . ' AND ';
                $param = ':val' . ($index + 1);
                $bindTable['int'][$param] = $expYears[1];
                $requestPiece['years'][count($requestPiece['years']) - 1] .= $param;
                $index +=2;
            }
        } elseif($key == 'popularity' && !is_null($values)){
                $param = ':val' . $index;
                $bindTable['int'][$param] = $values;
                $requestPiece['popularity'][] = 'popularity >= ' . $param;
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
            if($key == 'int') {
                $query->bindValue($param, $value, PDO::PARAM_INT);
            } elseif($key == 'str') {
                $query->bindValue($param, $value, PDO::PARAM_STR);
            }
        }
    }
    $query->execute();
    $films = $query->fetchAll();

    return $films;
}


// search film by search term
function searchFilmForm(string $search)
{
    global $pdo;
    $sql = "SELECT * FROM movies_full WHERE title LIKE :search OR cast LIKE :search OR directors LIKE :search";
    $query = $pdo->prepare($sql);
    $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $query->execute();
    $films = $query->fetchAll();

    return $films;
}

//CRUD user table
function createUser($pseudo, $email, $password_hash, $token)
{
    global $pdo;
    $sql = "INSERT INTO users (pseudo, email, password, token, created_at, role ) VALUES (:pseudo, :email, :password_hash, :token, now(), 'abonne')";
    $query = $pdo->prepare($sql);
    $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
    $query->bindValue(':token', $token, PDO::PARAM_STR);

    return $query->execute();
}


// ameliorer pour voir plus de parametres
// function pour checké si film exist dans user_note
function checkFilmAVoir($user_id, $movie_id, $table = 'user_note'){
    $exists = false;
    global $pdo;
    $sql = "SELECT id FROM $table WHERE user_id = :user_id AND movie_id = :movie_id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':movie_id', $movie_id, PDO::PARAM_INT);
    $query->execute();
    if($query->fetch())
    {
        $exists = true;
    }

    return $exists;
}


function getUserFilmToSee($user_id)
{
    global $pdo;
    $sql = "SELECT m.*, n.note
            FROM user_note AS n
            LEFT JOIN movies_full AS m
            ON n.movie_id = m.id
            WHERE n.user_id = $user_id
            AND n.note IS NULL";
    $query = $pdo->prepare($sql);
    $query->execute();
    $userNotes = $query->fetchAll();

    return $userNotes;
}
