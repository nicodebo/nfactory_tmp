<?php
session_start();

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
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $token = generateRandomString(50);
        $success = createUser($pseudo, $email, $password_hash, $token);
        //REDIRECTION VERS LA CONNECTION
        if($success) {
            $_SESSION['user'] = array(
                'id'     => $pdo->lastInsertId(),
                'pseudo' => $pseudo,
                'role'   => 'abonne',
                'ip'     => $_SERVER['REMOTE_ADDR']
            );
            header('Location: index.php');
        }
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
