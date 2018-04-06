<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Streaming Film</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/main.css" />
    <!-- <script src="main.js"></script> -->
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="inscription.php">Inscription</a></li>
                <?php if(!empty($_SESSION['user'])) { ?>
                    <li><a href="liste.php">Voir liste film</a></li>
                    <li><a href="deconnexion.php">Déconnexion (<?php echo $_SESSION['user']['pseudo'];?>)</a></li>
                        <?php if($_SESSION['user']['role'] == 'admin') { ?>
                            <li><a href="dashboard.php">Dashboard</a></li>
                        <?php } ?>
                <?php } else { ?>
                    <li><a href="connexion.php">Connexion</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>
    <div id="content">
