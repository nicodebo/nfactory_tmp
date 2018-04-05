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

    if(!empty($pseudo)){ 
        if(strlen($pseudo) <= 8){
            $error['pseudo'] = 'Veuillez renseigner au moins 8 caractères pour ce champs';
        } elseif (strlen('pseudo') >= 50){
            $error['pseudo'] = 'Veuillez renseigner au maximum 50 caractères pour ce champs';
        } else{
            // ICI IL N'Y A PAS D'ERREUR
            $sql = "SELECT * FROM users WHERE pseudo = :pseudo";
            $querry = $pdo -> prepare($sql);
            $querry -> bindValue(':pseudo', $pseudo, PDO::PARAM_STR); // protection
            $querry -> execute(); // execution
            $pseudoExist = $querry->fetch(); // je récupere mon utilisateur
            if(!empty($pseudoExist)) {
                 $error['pseudo'] = 'Pseudo éxiste déjà';         
            }
        }
    } else {
        $error['pseudo'] = 'Veuillez renseigner ce champ';
    }

    // email 
    if(!empty($email)){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Email non valide";
        } else{ 
            $sql = "SELECT * FROM users WHERE email = :email";
            $querry = $pdo -> prepare($sql);
            $querry -> bindValue(':email', $email, PDO::PARAM_STR);
            $querry -> execute();
            $emailExist = $querry->fetch();
            if(!empty($emailExist)) {
            $error['email'] = 'Email éxiste déjà'; 
            }   
        }
    }else{
        $error['email'] ='Veuillez renseigner le champs email';
    }

    //validation password
    if(!empty($password)&& !empty($confirm_password)){
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
        $sql = "INSERT INTO users (pseudo, email, password, token, created_at, role) VALUES (:pseudo, :email, :password, :token, NOW(), 'abonné')";
        $querry = $pdo -> prepare($sql);
        $querry -> bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $querry -> bindValue(':email', $email, PDO::PARAM_STR);
        $querry -> bindValue(':password', $password, PDO::PARAM_STR);
        $querry -> bindValue(':token', $token, PDO::PARAM_STR);
        $querry -> execute();

        //REDIRECTION VERS LA CONNECTION
        // header('Location: connexion.php');
    }
}

include('include/header.php');
//Formulaire
?>
<h1> Formulaire </h1>
<form action="inscription.php" method="POST" >
    <div>    
    <label for="pseudo">Pseudo: *</label>
        <input type="text" id="pseudo" name="pseudo" value="<?php if(!empty($_POST['pseudo'])){echo $_POST['pseudo'];} ?>">
        <span class="error"><?php if(!empty($error['pseudo'])){echo $error['pseudo'];} ?></span>
    </div>
    <div>                
    <label for="email">Email: *</label> 
        <input type="email" id="email" name="email" value="<?php if(!empty($_POST['email'])){echo $_POST['email'];} ?>">
        <span class="error"><?php if(!empty($error['email'])){echo $error['email'];} ?></span>  
    </div>
    <div> 
    <label for="password">Mot de passe: *</label>
        <input type="password" id="password" name="password" value="">  
        <span class="error"><?php if(!empty($error['password'])){echo $error['password'];} ?></span>
    </div>
    <label for="confirm_password">Validation Mot de passe: *</label>
        <input type="password" id="confirm_password" name="confirm_password" value="">
    </div>
    <div> 
        <input type="submit" value="Ajouter" name="submitted" id="sub">
    </div>
</form>

<?php include('include/footer.php'); 