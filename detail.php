<?php
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';
include 'include/function.php';

// recupérer le $_GET
if (!empty($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
    if(checkFilmExists($id)){
        $movie = readFilmById($id);
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
    <div>
        <p><?php echo $movie['title']; ?></p>
        <p><?php echo $movie['year']; ?></p>
        <p><?php echo $movie['genres']; ?></p>
        <p><?php echo $movie['plot']; ?></p>
        <p><?php echo $movie['directors']; ?></p>
        <p><?php echo $movie['cast']; ?></p>
        <p><?php echo $movie['writers']; ?></p>
        <p><?php echo $movie['runtime']; ?></p>
        <p><?php echo $movie['mpaa']; ?></p>
        <p><?php echo $movie['rating']; ?></p>
        <p><?php echo $movie['popularity']; ?></p>
    </div> 
</div>

<?php include 'include/footer.php';