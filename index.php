<?php
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';

$movies  = getRandomFilm(10);
include 'include/header.php';
?>
<?php foreach($movies as $key => $movies)?>
<div class="card">
    <img src="<?php echo 'posters/'.$movie['id'].'jpg'?>">
</div>

<?php include 'include/footer.php';
