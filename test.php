<?php
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';
include 'include/function.php';


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
debug(getInterval(getUniqueValues('year', false)));

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
    'years' => array(1992, 1999)
);
/* debug(searchFilm($term)) . '<br>'; */

$term = array(
    'genres' => array('sf', 'thriller', 'comedy'),
    'years' => array(1992, 1999),
    'popularity' => 50
);
/* debug(searchFilm($term)) . '<br>'; */
>>>>>>> Add a function to search film by criteria
?>

<?php include 'include/footer.php';
