<?php
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';

$movies  = getRandomFilm(10);
include 'include/header.php';
?>
<div id="poster">
    <?php foreach($movies as $movie){?>
    <div class="card">
        <img src="<?php echo 'posters/'.$movie['id'].'.jpg'?>" alt="<?php echo $movie['title'] ?>">
    </div>
    <?php } ?>
</div>


<?php include 'include/footer.php';
