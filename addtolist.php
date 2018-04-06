<?php
session_start();
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';
include 'include/function.php';

// recuperer le slug et le user_id
if (!empty($_GET['slug']) && is_string($_GET['slug']) && !empty($_SESSION['user'])){
    $slug = trim(strip_tags($_GET['slug']));
    
    if(checkFilmExistsBySlug($slug)){
        $movie = readTableByColVal('slug', $slug);
        if(empty($movie)){
            die('404');
        }
    }else{
        die('404');
    }
    $movie_id = $movie['id'];
    
    // add les vérification user
    $user_id = $_SESSION['user']['id'];
    if(checkFilmExists($user_id, 'users')){

    }else{
        die('404');
    }

    //remplir la table movies_to_see
    $sql_note = "INSERT INTO user_note(user_id, movie_id) VALUES (:user_id, :movie_id)";
    $query = $pdo -> prepare($sql_note);
    $query -> bindValue(':movie_id', $movie_id, PDO::PARAM_STR);
    $query -> bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $query -> execute();

    
    header("location: detail.php?slug=$slug");
}
