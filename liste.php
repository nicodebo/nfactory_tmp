<?php session_start();
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';
include 'include/function.php';

include 'include/header.php';


$filmstosee = getUserFilmToSee($_SESSION['user']['id']);

if($filmstosee) { ?>
    <ul>
    <?php foreach($filmstosee as $elem) { ?>
        <li><?php echo $elem['title']; ?></li>
    <?php } ?>
    </ul>
<?php }

include 'include/footer.php';
