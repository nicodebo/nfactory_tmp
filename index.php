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
        <a href="detail.php?id=<?php echo $id; ?>">
        <img src="<?php echo 'posters/'.$movie['id'].'.jpg'?>" alt="<?php echo $movie['title'] ?>">
        </a>
    </div>
    <?php } ?>
</div>

 

<?php include 'include/footer.php';
