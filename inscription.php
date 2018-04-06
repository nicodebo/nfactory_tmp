<?php

include('include/identifier.php');
include('include/pdo.php');
include('include/model.php');
include('include/function.php');

$error = array();
$success = false;

//formulaire soumis 
if(!empty($_POST['submitted'])){
//Protection contre les failles XSS
    $pseudo   = trim(strip_tags($_POST['pseudo']));
    $email    = trim(strip_tags($_POST['email']));
    $password = trim(strip_tags($_POST['password']));
    $confirm_password = trim(strip_tags($_POST['confirm_password']));
/////////////////////
// Validation
/////////////////////
   
    //pseudo
    $error = control($error, $pseudo, 'pseudo', 55, 5);
    $pseudoExist = readTableByColVal('pseudo', $pseudo, 'users');
    if(!empty($pseudoExist)) {
         $error['pseudo'] = 'Pseudo existe déjà';         
    }

    // email
    $error = controlEmail($email, $error, 'email', 'users');
    $emailExist = readTableByColVal('email', $email, 'users');
    if(!empty($emailExist)) {
         $error['email'] = 'Email existe déjà';       
    }

    if(!empty($password)&& !empty($confirm_password)) {
        if($password != $confirm_password) { 
            $error['password'] = 'Les mots de passent doivent être identiques';
    
        } elseif (strlen('password') <= 6){
                $error['password'] = 'Veuillez renseigner au minimum 6 caractères pour ce champs';
        }
    }else{
            $error['password'] ='Veuillez renseigner un mot de passe';
    }
    
    //Requete d'insertion dans le formulaire si celui-ci ne contient pas d'érreur
    if(count($error) == 0){
        $hassPassword = password_hash($password, PASSWORD_DEFAULT);
        $token = generateRandomString(50);
        $role ='user';
        $sql = "INSERT INTO users (pseudo, email, password, token, created_at, role) VALUES (:pseudo, :email, :password, :token, NOW(), 'abonne')";
        $querry = $pdo -> prepare($sql);
        $querry -> bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $querry -> bindValue(':email', $email, PDO::PARAM_STR);
        $querry -> bindValue(':password', $hassPassword, PDO::PARAM_STR);
        $querry -> bindValue(':token', $token, PDO::PARAM_STR);
        $querry -> execute();

        //REDIRECTION VERS LA CONNECTION
        // header('Location: connexion.php');
    }
}

include('include/header.php');
//Formulaire
?>
<h1> Inscription </h1>
<form action="inscription.php" method="POST" >
    <div>    
    <label for="pseudo">Pseudo: *</label>
        <input type="text" id="pseudo" name="pseudo" value="<?php echo lastValue('pseudo');?>">
        <span class="error"><?php afficheError($error, 'pseudo'); ?></span>
    </div>
    <div>                
    <label for="email">Email: *</label> 
        <input type="email" id="email" name="email" value="<?php echo lastValue('email');?>">
        <span class="error"><?php afficheError($error, 'email'); ?></span>  
    </div>
    <div> 
    <label for="password">Mot de passe: *</label>
        <input type="password" id="password" name="password" value="">
        <span class="error"><?php afficheError($error, 'password'); ?></span>
    </div>
    <label for="confirm_password">Validation Mot de passe: *</label>
        <input type="password" id="confirm_password" name="confirm_password" value="">
    </div>
    <div> 
        <input type="submit" value="Ajouter" name="submitted" id="sub">
    </div>
</form>

<?php include('include/footer.php'); 