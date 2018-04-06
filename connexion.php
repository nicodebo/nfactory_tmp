<?php session_start();

include('include/identifier.php');
include('include/pdo.php');
include('include/model.php');
include('include/function.php');

$error = [];
if(!empty($_POST['submitlogin'])) {
    // protection XSS
    $login     = trim(strip_tags($_POST['login']));
    $password  = trim(strip_tags($_POST['password']));

    ///////////////////////////////////////
    // Validation
    /////////////////////////////////////////
    if(empty($login) OR empty($password)) {
      $error['login'] = ' Veuillez renseigner les deux champs';
    } else {
        $sql = "SELECT * FROM users WHERE pseudo = :login OR email = :login";
        $query = $pdo->prepare($sql);
        $query->bindValue(':login',$login,PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch();
        if(!empty($user)) {
            	if(password_verify($password,$user['password'])) {

                    // connexion, password ok , user ok
                        $_SESSION['user'] = array(
                            'id'     => $user['id'],
                            'pseudo' => $user['pseudo'],
                            'role'   => $user['role'],
                            'ip'     => $_SERVER['REMOTE_ADDR']
                        );
                        
                        header('Location: index.php');

              } else {
                    $error['password'] = 'Mauvais mot de passe';
              }
        } else {
          $error['login'] = 'Identifiant inconnu';
        }
    }
}

?>
<?php include('include/header.php'); ?>

<form action="connexion.php" method="post">
      <label for="login">Pseudo OR email</label>
      <span class="error"><?php if(!empty($errors['login'])) { echo $errors['login']; } ?></span>

      <input type="text" name="login" value="<?php if(!empty($_POST['login'])) { echo $_POST['login']; } ?>">

      <label for="password">Password *</label>
      <span class="error"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></span>
      <input type="password" name="password" value="">

      <input type="submit" name="submitlogin" value="Envoyer">

</form>

<a href ="checkemail.php">mot de passe oublié</a>
<?php include('include/footer.php');
