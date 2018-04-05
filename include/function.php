<?php

function debug($myArr)
{
    echo '<pre>';
    print_r($myArr);
    echo '</pre>';
}

// génére un tableau des genres à partir de la base de données
function getUniqueValues($column, $reverse = true){
    //la requête pour tous les champs genres
    $strvalues = "";
    $tab_values = getTabColumnValues($column, $table="movies_full");
    foreach($tab_values as $values){
        $strvalues = $strvalues . $values[$column] . ', ';
    }
    $tab = array_filter(array_unique(explode(', ', $strvalues)));
    // sort() ne conserve pas les index naturel
    sort($tab);
    if($reverse = false){
        rsort($tab);
    }
    return $tab;
}

function getInterval($tab){
    for($i = 0; $i < count($tab); $i+=10){
        $output = array_slice($tab, $i, 10);
        $str = min($output) . '-' . max($output);
        $tab_interval[] = $str;
    }
    return $tab_interval;
}

function afficheChexbox($tab, $column){
    foreach($tab as $value){
        echo '<div><input type="checkbox" name="' . $column . '[]' . '" value="' . $value .'"><label for="'. $value . '">' . $value . '</label></div>';
    }
}

function checkSrcImg($name, $fold){
    if (!file_exists($fold . $name)){
        $name = '0000.jpg';
    }
    return $fold . $name;
}

// pretty url
function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}