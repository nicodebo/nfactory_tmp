<?php

function debug($myArr)
{
    echo '<pre>';
    print_r($myArr);
    echo '</pre>';
}

// génére un tableau des genres à partir de la base de données
function getUniqueValues($column){
    //la requête pour tous les champs genres
    $strvalues = "";
    $tab_values = getTabColumnValues($column, $table="movies_full");
    foreach($tab_values as $values){
        $strvalues = $strvalues . $values[$column] . ', ';
    }
    $tab = array_filter(array_unique(explode(', ', $strvalues)));
    return $tab;
}