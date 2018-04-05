<?php
include('include/identifier.php');
include('include/pdo.php');
include('include/model.php');
include('include/function.php');

$success = false;

if (!empty($_GET['search'])){
    $search = trim(strip_tags($_GET['search']));
    $films = searchFilmForm($search);
    if($films)
    {
        $success = true;
    }
}

include('include/header.php');

if($success) { ?>
    <div class="recherche">
        <p> Nous avons trouver des résultats dans les articles suivants:</p>
        <ul>
        <?php
        //Affichage des résultats de la recherhce
        foreach($films as $film){
            if(!empty($film['title'])){ ?>
                <li class="cherche">
                    <a href="detail.php?id=<?php echo $film['id']; ?>"><?php echo $film['title'] ?></a>
                </li>
            <?php } ?>
        <?php } ?>
        </ul>
    </div>
    <?php } else { ?>
                <li>Aucun résultat</li>
        <?php } ?>
<?php
include('include/footer.php');

