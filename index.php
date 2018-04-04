<?php
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';
include 'include/function.php';

$movies  = getRandomFilm(10);



include 'include/header.php';
if(!empty($_POST['submitted'])){
    print_r($_POST['genres']);
    // echo $_POST['genres'];
    }
?>
<!-- refresh ma selection aléatoire -->
    <div id="refresh">
        <button><a class="reloadPage" href="refreshfilm.php">refresh Random selection</a></button>
    </div>

    <!-- affiche les posters -->
    <?php foreach($movies as $movie){?>
    <div class="poster">
        <div class="card">
            <a href="detail.php?id=<?php echo $movie['id']; ?>">
            <img src="<?php echo 'posters/'.$movie['id'].'.jpg'?>" alt="<?php echo $movie['title'] ?>">
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
            afficheChexbox($tab_years, 'year');
            ?>
        </fieldset>

        <fieldset>
            <legend>Popularité en nombre de vues :</legend>
            <div>
                <input type="checkbox" name="popularity" value="25">
                <label for="25">25</label>
            </div>
            <div>
                <input type="checkbox" name="popularity" value="50">
                <label for="50">50</label>
            </div>
            <div>
                <input type="checkbox" name="popularity" value="75">
                <label for="75">75</label>
            </div>
        </fieldset>

        <input class="reloadPage" type="submit" name="submitted" value="Voir ma selection personnalisée">
    </form>

<?php include 'include/footer.php';
