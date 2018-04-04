<?php
include 'include/identifier.php';
include 'include/pdo.php';
include 'include/model.php';
include 'include/function.php';


include 'include/header.php';
?>
<style>
    .underline{
        text-decoration: underline;
    }
</style>
<h3 class="underline">Test getUniqueValues</h3>
<?php 
// $tab_genre = getTabColumnValues('genres');
// debug($tab_genre);
debug(getInterval(getUniqueValues('year', false)));
?>
<?php include 'include/footer.php';
