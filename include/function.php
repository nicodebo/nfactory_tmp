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

// pour le Token
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// retourne la dernière valeur rempli par l'utilisateur
function lastValue($value){
    if(!empty($_POST[$value])){
        return $_POST[$value];
    }
}

// affiche les erreurs pour remplir le formulaire
function afficheError($error, $value){
    if (!empty($error[$value])) {
        echo $error[$value];
    }
}

// control les $_POST
function control($error, $value, $key,$max, $min){
    if(!empty($value)){

        if(strlen($value) <= $min){
            $error[$key] = 'Veuillez renseigner au moins '.$min.' caractères pour ce champs';
        }elseif (strlen($value) >= $max){
            $error[$key] = 'Veuillez renseigner au maximum '.$max.'caractères pour ce champs';
        }
        $value = ucfirst($value);
    }else{
        $error[$key] ='Veuillez renseigner ce champs';
    }
return $error;
}

//Fonction de controle de l'adresse mail
function controlEmail($email, $error, $key){
    if(!empty($email)){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        } else {
            $error[$key] = "Email non valide";
        }
        
    }else{
        $error[$key] ='Veuillez renseigner le champs email';
    }
    return $error;
}