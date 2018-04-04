<?php
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';

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
    <?php  
    foreach($movie as $data){ ?>
        <p><?php echo $data?></p>
    <?php }?>
</div>

<?php include 'include/footer.php';