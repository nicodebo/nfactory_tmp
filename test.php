<?php
session_start();
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';
include 'include/function.php';

$movies  = getRandomFilm(10);
include 'include/header.php';
?>
<style>
    .underline{
        text-decoration: underline;
    }
</style>
<h3 class="underline">Test getUniqueValues</h3>
<?php
// $tab_genre = getTabColumnValues('genres');
// debug($tab_genre);
// debug(getInterval(getUniqueValues('year', false)));

?>
<h3 class="underline">Test searchFilm</h3>
<?php
$term = array(
    'genres' => null
);
/* debug(searchFilm($term)) . '<br>'; */

$term = array(
    'genres' => array('sf', 'thriller')
);
/* debug(searchFilm($term)) . '<br>'; */

$term = array(
    'genres' => array('sf', 'thriller'),
    'years' => array("1992-1993", "1993-1994")
);
/* debug(searchFilm($term)) . '<br>'; */

$term = array(
    'genres' => array('sf', 'thriller', 'comedy'),
    'years' => array("1992-1999"),
    'popularity' => 50
);
/* debug(searchFilm($term)) . '<br>'; */

// debug(getInterval(getUniqueValues('year', false)));
?>
<h3 class="underline">Test getInterval pour les années : </h3>
<?php
    $tab_years = getUniqueValues('year', false);
    $offset = 10;
    print_r(getInterval($tab_years));
    // afficheChexbox($tab_years, 'year');
?>

<h3 class="underline">Test pretty url slugify : </h3>
<?php
    echo $movies[0]['slug'];
    echo slugify($movies[0]['slug']);
?>

<h3 class="underline">Test  : </h3>
<?php
    $user_id = $_SESSION['user']['id'];
    $movie_id = $_GET['movie']['slug'];
    function checkFilmAVoir($user_id, $movie_id, $table = 'user_note'){
        $exists = false;
        global $pdo;
        $sql = "SELECT id FROM $table WHERE user_id = :user_id AND movie_id = :movie_id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $query->bindValue(':movie_id', $movie_id, PDO::PARAM_STR);        
        $query->execute();
        if($query->fetch())
        {
            $exists = true;
        }

        return $exists;
    }
?>
?>


<?php include 'include/footer.php';
