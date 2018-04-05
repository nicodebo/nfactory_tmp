<?php 
include('include/identifier.php');
include('include/pdo.php');
include('include/model.php');
include('include/function.php');



    if (!empty($_GET['search'])){
       $search =trim(strip_tags( $_GET['search']));
//Selection des article et des titre où contenant la chaine de caractère entrer dans le champs de recherche

        $sql = "SELECT * FROM movies_full WHERE title LIKE :search"; //OR content LIKE :search
        $query = $pdo -> prepare($sql);
        $query -> bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
        $query -> execute();
        $finds = $query -> fetchAll();
    }

include('include/header.php');
?> <div class="recherche">
<p> Nous avons trouver des résultats dans les articles suivants:</p>
<ul>
<?php
//Affichage des résultats de la recherhce

foreach($finds as $find){
    if(!empty($find['title'])){ //& !empty($find['content'])
?>
        <li class="cherche"> 
        <a href="single.php?id=<?php echo $find['id']; ?>"><?php echo $find['title'] ?></a>
        </li>
<?php }else{
        echo '<li>Aucun résultat</li>';
} } ?>
    </ul>
</div>
<?php
include('include/footer.php');

