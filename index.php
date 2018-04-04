<?php
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';

$movies  = getRandomFilm(10);
include 'include/header.php';
?>

    <form action="refreshfilm.php">
        <input class="reloadPage" type="submit" value="more film"></button> 
    </form>

    <?php foreach($movies as $movie){?>
    <div class="poster">
        <div class="card">
            <a href="detail.php?id=<?php echo $movie['id']; ?>">
            <img src="<?php echo 'posters/'.$movie['id'].'.jpg'?>" alt="<?php echo $movie['title'] ?>">
            </a>
        </div>
    </div>
    <?php } ?>

<?php include 'include/footer.php';
