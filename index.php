<?php
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';
include 'include/function.php';


include 'include/header.php';

$movies = getRandomFilm(10);

$success = false;

?>
<!-- refresh ma selection aléatoire -->
<div id="refresh">
    <button><a class="reloadPage" href="refreshfilm.php">refresh Random selection</a></button>
</div>

<?php
if(!empty($_POST['submitted'])) {
    $genres = array();
    $years = array();

    //faille xss
    if(!empty($_POST['genres'])){
        foreach($_POST['genres'] as $elem) {
            $genres[] = trim(strip_tags($elem));
        }
    }

    if(!empty($_POST['year'])){
        foreach($_POST['year'] as $elem) {
            $years[] = trim(strip_tags($elem));
        }
    }

    $popularity = trim(strip_tags($_POST['popularity']));

    #TODO: vérifier la validité des valueurs

    if(empty($error)){
        $searchTerms = array(
            'genres' => null,
            'years' => null,
            'popularity' => $popularity
        );

        if(!empty($genres))
        {
            $searchTerms['genres'] = $genres;
        }

        if(!empty($years))
        {
            $searchTerms['years'] = $years;
        }

        $movies = searchFilm($searchTerms);

        if($movies) {
            $success = true;
        }
    }
}


// si les critères du formulaire n'ont rien retournés on affiche 10 films au
// hasard
if(!$success && !empty($_POST['submitted'])){
    echo 'no films found. Displaying 10 randoms film.' . '<br>';
    $movies = getRandomFilm(10);
}

    foreach($movies as $movie) { ?>
    <!-- affiche les posters -->
    <div class="poster">
        <div class="card">
            <a href="detail.php?id=<?php echo $movie['id']; ?>">
                <img src="<?php echo checkSrcImg($movie['id'].'.jpg', 'posters/');?>" alt="<?php echo $movie['title'] ?>">
            </a>
        </div>
    </div>
    <?php } ?>

    <!-- formulaire -->
    <form id="favoris" action="" method="post">
        <!-- Ajout des chexbox par genres, années et popularité -->
        <fieldset>
            <legend>Vous pouvez sélectionner votre genre favoris :</legend>
            <!-- // foreach -->
            <?php
            $tab_genres = getUniqueValues('genres');
            afficheChexbox($tab_genres, 'genres');
            ?>
        </fieldset>

        <fieldset>
            <legend>Vous pouvez sélectionner l'année de sortie du film :</legend>
            <?php

            $tab_years = getUniqueValues('year', false);
            $tab_years = getInterval($tab_years);
            afficheChexbox($tab_years, 'year');
            ?>
        </fieldset>

        <fieldset>
            <legend>Popularité en nombre de vues :</legend>
            <div class="slidecontainer">
              <input type="range" min="0" max="100" value="50" class="slider" name="popularity" id="myRange">
            </div>
        </fieldset>

        <input class="reloadPage" type="submit" name="submitted" value="Voir ma selection personnalisée">
    </form>

<?php include 'include/footer.php';
