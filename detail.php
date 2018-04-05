<?php
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';
include 'include/function.php';

// recupérer le $_GET
if (!empty($_GET['slug']) && is_string($_GET['slug'])){
    $slug = $_GET['slug'];
    if(checkFilmExistsBySlug($slug)){
        $movie = readFilmByColVal('slug', $slug);
        if(empty($movie)){
            die('404');
        }
    }else{
        die('404');
    }
}

include 'include/header.php';
?>

<!-- affiche le film -->
<div id="detail">
    <div class="poster">
        <div class="card">
            <img src="<?php echo checkSrcImg($movie['id'].'.jpg', 'posters/');?>" alt="<?php echo $movie['title'] ?>">
        </div>
    </div>
    <div id="description" class="">
        <div class="card">
            <p class="description"><span>Titre</span> : <?php echo $movie['title']; ?></p>
            <p class="description"><span>Année</span> : <?php echo $movie['year']; ?></p>
            <p class="description"><span>Genres</span> : <?php echo $movie['genres']; ?></p>
            <p class="description"><span>Synopsis</span> : <?php echo $movie['plot']; ?></p>
            <p class="description"><span>Directeurs</span> : <?php echo $movie['directors']; ?></p>
            <p class="description"><span>Acteurs</span> : <?php echo $movie['cast']; ?></p>
            <p class="description"><span>Auteurs</span> : <?php echo $movie['writers']; ?></p>
            <p class="description"><span>Durée</span> : <?php echo $movie['runtime']; ?></p>
            <p class="description"><span>Mpaa</span> : <?php echo $movie['mpaa']; ?></p>
            <p class="description"><span>Rating</span> : <?php echo $movie['rating']; ?></p>
            <p class="description"><span>Popularité</span> : <?php echo $movie['popularity']; ?></p>
        </div>
    </div>
</div>

<?php include 'include/footer.php';
